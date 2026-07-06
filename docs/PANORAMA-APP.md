# Panorama de la Aplicación — "Fronteras" (ITALENER)

> Documento generado a partir del análisis del código fuente del repositorio.
> Propósito: dar una visión completa de qué hace la app, cómo está construida
> y cómo fluyen los datos entre sus componentes.

---

## 1. Resumen ejecutivo

**Fronteras** es una aplicación web PHP para la **gestión de fronteras comerciales
de energía eléctrica** en el mercado colombiano, operada por la empresa **ITALENER**
(marca visible en la UI: "SoftFocus™").

Una *frontera comercial* es el punto de medición (medidor) donde se registra el
consumo de energía de un cliente. La aplicación:

1. **Ingiere lecturas horarias de energía** (24 horas por día) desde dos fuentes:
   - Carga manual de archivos **CSV**.
   - Un **web service XML-RPC** externo (`telmetergy.com.co`), consultado por tareas
     programadas diarias.
2. **Clasifica la energía** en cinco tipos: Activa (A), Reactiva (R), Capacitiva (C),
   Exportada (E) y Penalizada/Inductiva (P).
3. **Calcula penalizaciones** por exceso de energía reactiva y el **factor M**
   (conteo de meses consecutivos con consumo penalizable), insumo regulatorio.
4. **Almacena facturas en PDF** por frontera/periodo.
5. **Genera reportes** (PDF con gráficas) y los **envía por correo** a los clientes.
6. Administra **usuarios, perfiles y un sistema de permisos jerárquico** por menú.

**Stack:** PHP 7.4 (cPanel/LiteSpeed) + MySQL (`energia6_fronteras`) + plantilla
front-end **AdminLTE 3** (Bootstrap 4, jQuery, DataTables, Select2, Chart.js,
SweetAlert). Zona horaria `America/Bogota`.

---

## 2. Arquitectura general

Patrón **MVC artesanal** (estilo tutoriales AdminLTE en español), sin framework ni
Composer. La organización de carpetas:

```
index.php                → punto de entrada; incluye todos los controladores/modelos
.htaccess                → reescritura de URL: /ruta → index.php?ruta=ruta
controladores/           → lógica de negocio (Controlador*)
modelos/                 → acceso a datos con PDO (Modelo*)
vistas/                  → capa de presentación
  plantilla.php          → layout maestro (HTML, CSS/JS)
  modulos/               → parciales y "pantallas" por módulo
  js/                    → JS por módulo (llaman a /ajax vía AJAX)
  dist/, plugins/, img/  → activos de AdminLTE
ajax/                    → endpoints AJAX (*.ajax.php) que responden JSON/HTML
files/                   → imágenes/archivos generados para reportes
docs/                    → documentación AdminLTE + carpetas de datos:
  docs/facturas/<idFrontera>/<añomes>/  → PDFs de facturas subidas
  docs/lecturas/                        → CSV de lecturas cargados
build/, dist/            → activos compilados de la plantilla
```

### 2.1 Flujo de una petición (routing)

1. Toda URL amigable `https://.../<ruta>` es reescrita por `.htaccess` a
   `index.php?ruta=<ruta>`.
2. `index.php` hace `require_once` de todos los controladores y modelos, y arranca
   `ControladorPlantilla::ctrPlantilla()`, que incluye `vistas/plantilla.php`.
3. `plantilla.php` abre sesión (`session_start`) y carga el `<head>` con todos los
   assets, luego incluye `vistas/modulos/body.php`.
4. `body.php` decide:
   - Si **no** hay sesión (`$_SESSION["iniciarSesion"] != "ok"`) → muestra `login.php`.
   - Si hay sesión → arma el layout (cabezote, menú, breadcrumb, footer) e **incluye
     la plantilla del módulo** resuelta en `breadcrumb.php`.
5. `breadcrumb.php` traduce `$_GET["ruta"]` en el archivo de vista `$template`:
   - Casos especiales: `editMenu` → `editMenu.php`; `datosGenerados` → `datosGenerados.php`;
     `salir` → `salir.php`.
   - Caso general: consulta la tabla `subproceso` (`ModeloSubproceso::mdlMostrarSubproceso`)
     por `plantillaSubproceso = ruta` y usa el nombre de plantilla resultante.
   - Si no hay coincidencia → `inicio.php`.

Es decir: **el menú y las rutas viven en la base de datos**, no en código.

### 2.2 Menú y permisos (autorización)

Jerarquía de tres niveles almacenada en BD:

```
servicio (idServicio)          ← grupo mayor del menú
  └─ proceso (idProceso)       ← subgrupo
       └─ subproceso           ← ítem final; plantillaSubproceso = nombre de la vista
            └─ acciones        ← acciones/plantillas adicionales
```

Los permisos por usuario se materializan en tablas puente con banderas
`activo / lectura / escritura`:

- `servicio_has_usuario`
- `proceso_has_usuario`
- `subproceso_has_usuario`

`ModeloMenu` arma el árbol lateral (`GROUP_CONCAT` para colapsar servicios→procesos→
subprocesos) filtrando por `Usuario_identificador` y `activo=1`. La vista
`editMenu.php` + `permisos.js` (widget *hummingbird treeview*) permite asignar/
revocar subprocesos a un usuario; `mdlEditarMenuServicio` sincroniza altas/bajas.

---

## 3. Capa de datos

- **Conexión** (`modelos/conexion.php`): PDO a MySQL.
  - Host `localhost`, base `energia6_fronteras`, usuario `energia6_fronteras`.
  - ⚠️ **Credenciales de BD hardcodeadas** en el archivo (riesgo de seguridad).
  - `SET names 'utf8'`, `lc_time_names='es_CO'`, errores en modo excepción.

### 3.1 Tablas principales (inferidas del SQL)

- **Usuarios / seguridad**
  - `usuario` (identificador, password sha512, salt, estado, email, celular,
    nombreCompleto, PerfilUsuarios_idPerfilUsuarios, nuevaFoto, ultimo_login)
  - `login_attempts` (registro de intentos fallidos por usuario/fecha)
  - `PerfilUsuarios` / `perfiles`
- **Menú / permisos**
  - `servicio`, `proceso`, `subproceso`, `acciones`
  - `servicio_has_usuario`, `proceso_has_usuario`, `subproceso_has_usuario`
- **Clientes y fronteras**
  - `clienteproyecto` (cliente/proyecto: nombre, email, teléfono, identificación)
  - `clienteFrontera` (cliente por NIT: nitCliente, contacto, email, activo)
  - `frontera` (fronteraCliente, clienteFrontera_nitCliente, seguimiento, minimoKv)
- **Lecturas de energía**
  - `lecturaFrontera` — **tabla central**: una fila por (frontera, fecha, tipoEnergia)
    con 24 columnas horarias `H1..H24`, `medidorFrontera`, `tipoMedidor`,
    `fechaCompleta`, `anyoLectura/mesLectura/diaLectura`.
  - `logLecturas` (bitácora de CSV cargados)
  - `logLecturasWS` (bitácora de consultas al web service)
- **Cálculos regulatorios**
  - `factorm` (registro diario: tipoEnergia C/P, cantidad, fecha, frontera)
  - `ctrFactorm` (consolidado mensual: anyo, mes, factor, total, días, tipoEnergia)
  - `penalizacionFrontera` (energía penalizada)
- **Facturación**
  - `facturas` (anyo, mes, nameFile, frontera_fronteraCliente)
- **Desviación**
  - `desviacion` (vlrMinimo, vlrMaximo) — umbrales para reportes
- **Otras** (modelos presentes): `areas`, `fuentes`, `pais`, `proyecto`,
  `equipos`, `subproceso`, `itemPlantillaTrabajo` (plantillas de trabajo),
  `alterno`, `estado_solicitud`.

### 3.2 Modelo de energía horaria

Cada lectura diaria de una frontera se descompone por tipo de energía y se guarda
como una fila con 24 valores horarios. Las siglas (en `Constantes`):

- `A` Activa (`kWhD`) · `R` Reactiva (`kVarhD`) · `C` Capacitiva (`kVarhR`)
- `E` Exportada (`kWhR`) · `P` Penalizada / Inductiva
- `tipoMedidor = 'P'` (principal)

Los totales diarios/mensuales se calculan con `sum(H1+...+H24)` directamente en SQL.

---

## 4. Módulos funcionales (Controlador ↔ Modelo ↔ Vista)

### 4.1 Usuarios y sesión
- **Controlador:** `usuarios.controlador.php` · **Modelo:** `usuarios.modelo.php`,
  `login_attempts.modelo.php` · **Vistas:** `login.php`, `crearUsuario.php`,
  `datosPersonales.php` · **JS:** `usuarios.js`
- Login: valida usuario (regex alfanumérico), hash `sha512(password + salt)`,
  verifica `estado=1`.
- **Anti-fuerza-bruta:** `checkbrute()` cuenta intentos en las últimas 2 horas; a
  partir de 5 fallidos **bloquea la cuenta** (`estado=0`) y **envía correo** de aviso.
- Variables de sesión: identificador, nombre, foto, perfil, `login_string`
  (hash clave+user-agent) y `frtSession` (fronteras del cliente).
- CRUD de usuarios con subida y redimensión de foto (GD, solo PNG).

### 4.2 Perfiles
- `perfiles.controlador.php` / `perfiles.modelo.php`, `crearPerfil.*` — gestión de
  perfiles de usuario (roles).

### 4.3 Clientes
- `clientes.controlador.php` (`clienteproyecto`) y
  `clienteFrontera.controlador.php` (`clienteFrontera`, por NIT).
- **Vistas:** `listadoClientes.php` · **JS:** `clientes.js`

### 4.4 Fronteras (núcleo del dominio)
- **Controlador:** `fronteras.controlador.php` · **Modelo:** `fronteras.modelo.php`
  (el más grande) · **Vistas:** `listadoFronteras.php`, `editlistadoFronteras.php`,
  `editListadoFronteras`, `datosGenerados.php` · **JS:** `fronteras.js`, `totales.js`
- Consultas de energía por día/mes/año/tipo, promedios, matrices comparativas y
  totales por periodo (insumo para gráficas).
- Edición de frontera: `seguimiento`, `minimoKv`.
- **Ingesta CSV** (`ctrInsertLecturasFrontera`): parsea el archivo por columnas
  fijas — activa (cols 5–28), exportada (29–52), reactiva (53–76), capacitiva
  (77–100), 24 horas cada una — e inserta/actualiza en `lecturaFrontera`
  (`mdlInsertLecturasFrontera`, con anti-duplicado por `mdlSearchData`).

### 4.5 Lecturas (bitácora de cargas)
- `logLectura.controlador.php` — sube CSV a `docs/lecturas/`, valida tipo MIME y
  tamaño (≤5 MB), registra en `logLecturas`. **Vista:** `uploadConsumo.php`,
  **JS:** `logLectura.js`.
- `logLecturaWS.controlador.php` — bitácora de las lecturas obtenidas vía web service.

### 4.6 Penalización y Factor M (cálculos regulatorios)
- **Regla de penalización** (`ctrCalculePenalty`): por cada hora,
  si `reactiva > 0.5 × activa`, la energía penalizada = `reactiva − 0.5×activa`
  (excedente de reactiva sobre el 50% de la activa).
- Al cargar lecturas se calcula automáticamente la energía **penalizada (P)** y se
  acumulan totales **capacitiva (C)** y **penalizada (P)** en `factorm`
  (`ControladorFactorM::ctrCrearFactorM`).
- **Factor M** (`factorm.controlador.php`, `ctrfactorm.controlador.php`): a partir de
  los registros diarios, `dailyFactorTask.php` consolida por mes cuántos días superan
  el umbral (>10) y lleva la cuenta consecutiva (`factor`) en `ctrFactorm`.
- `penalizacion.controlador.php` — consulta la energía penalizada (`penalizacionFrontera`).

### 4.7 Facturas
- `factura.controlador.php` / `factura.modelo.php` — sube PDF de factura por
  frontera/año/mes a `docs/facturas/<idFrontera>/<añomes>/`, valida que sea PDF,
  ≤5 MB, sin duplicados; registra en `facturas`. **Vistas:** `uploadFile.php`,
  `descargaFactura.php` · **JS:** `factura.js`

### 4.8 Desviación
- `desviacion.controlador.php` / `desviacion.modelo.php` — administra umbrales
  `vlrMinimo/vlrMaximo` usados para detectar desviaciones en el consumo y para
  colorear/alertar en los reportes. **Vista:** `desviacion.php` · **JS:** `desviacion.js`

---

## 5. Integración con el web service (telmetergy)

- **Constantes:** `URL_WS = https://medicion.telmetergy.com.co/xmlrpc/2/object`,
  `USER_WS`, `PASSW_WS`, `DIRIN_WS = telmetergy.webservices`,
  `NAME_WS = webserviceConsumosActual`.
- Protocolo **XML-RPC** (aspecto de Odoo `execute_kw`) invocado con `cURL`.
- `dailyTask.php` (`ControladorFronterasWS`):
  1. Recorre todas las fronteras.
  2. Por cada una consulta las lecturas del día objetivo (`?days=N` atrás) al WS.
  3. Parsea la respuesta XML → estructura por canal (activa/reactiva/capacitiva/
     exportada), calcula penalización y **guarda en `lecturaFrontera`**.
  4. Registra el resultado (OK/ERROR) en `logLecturasWS`.
  5. Con `days=1` envía un **correo de reporte diario**.
- **Ejecución:** por línea de comandos / cron: `php dailyTask.php "days=1"` y
  `php dailyFactorTask.php "days=1"` (leen `$argv[1]` con `parse_str`).

---

## 6. Reportes, PDF y correo

- **Generación de PDF:** `dompdf/` (HTML→PDF) y controladores `pdf.php`,
  `create_pdf.php`, `pdfdiv.php`, `logpdf`.
- **Gráficas:** `jpgraph/` con generadores de imagen:
  `generateImageInductiva.php`, `generateImageCapacitiva.php`,
  `generateImageDeviation.php`, `generateImageComparativa.php` — producen las
  imágenes de energía inductiva/capacitiva, desviación y comparativos que se
  incrustan en los reportes (se sirven desde `files/imgFrt/`).
- **Compresión:** `compressFolder.php` (empaqueta reportes en ZIP).
- **Correo:** `ControladorUtilidades::sendMail` con **PHPMailer** vía SMTP Gmail
  (`smtp.gmail.com:587`, TLS), cuenta `notificaciones.italener@gmail.com`.
  Se usa para: bloqueo de usuario, reporte diario de lecturas y envío de reportes
  con adjuntos. `sendEmail.php`, `mail.php` complementan el envío.
- **Utilidades** (`utilidades.controlador.php`): respuestas SweetAlert
  (`answerScript`/`answerBad`), cálculo de fechas relativas (`anyoMesDia`,
  `lastPeriodDate`), mapeo de siglas→nombre de energía (`tipoEnergia`),
  logging a `logFileControlador.log`.

---

## 7. Capa AJAX / Front-end

- Los archivos en `ajax/` (`fronteras.ajax.php`, `logLectura.ajax.php`,
  `insertLectura.ajax.php`, `desviacion.ajax.php`, `clientes.ajax.php`,
  `factura.ajax.php`, `usuarios.ajax.php`, `menu.ajax.php`, `pais.ajax.php`,
  `totales.ajax.php`, `changeLogLectura.ajax.php`, `perfiles.ajax.php`) son los
  endpoints que reciben las peticiones jQuery desde los `vistas/js/*.js`,
  invocan los controladores y devuelven JSON/HTML.
- El front usa **DataTables** (con exportación a Excel/PDF/print), **Select2**,
  **daterangepicker**, **Chart.js** y **SweetAlert** para la interacción.

---

## 8. Recorrido de datos de punta a punta

```
[Medidor] ──► telmetergy WS (XML-RPC)         [CSV manual]
                    │                               │
             dailyTask.php                   uploadConsumo → logLectura
                    │                               │
                    ▼                               ▼
              lecturaFrontera  ◄──── (H1..H24 por tipo de energía A/R/C/E/P)
                    │
        ┌───────────┼─────────────────────────┐
        ▼           ▼                          ▼
  penalización   factorm/ctrFactorm      consultas de totales
  (reactiva>50%)  (factor M mensual)     (día/mes/año/comparativos)
        │                                      │
        └──────────────┬───────────────────────┘
                       ▼
            jpgraph (gráficas) + dompdf (PDF)
                       ▼
              PHPMailer → correo al cliente
```

---

## 9. Observaciones técnicas y riesgos

- **Seguridad:**
  - Credenciales de BD y contraseña de correo **hardcodeadas** en el repo
    (`conexion.php`, `constantes.controlador.php`). Deberían ir a variables de entorno.
  - Varias consultas concatenan variables directamente en el SQL (menú,
    `login_attempts`), lo que abre **riesgo de inyección**; conviven con otras que sí
    usan sentencias preparadas.
  - Contraseñas con `sha512 + salt` (mejor usar `password_hash`/bcrypt/argon2).
- **Portabilidad:** rutas y comportamiento atados a cPanel/PHP 7.4 y a
  `America/Bogota`; sin gestor de dependencias (librerías vendorizadas a mano).
- **Datos de prueba en el repo:** hay muchos CSV reales en `docs/lecturas/` y un PDF
  de factura en `docs/facturas/Frt01081/` — conviene depurarlos del control de versiones.
- **Mezcla idiomática** en nombres (español/inglés) y lógica de negocio dentro de
  controladores; oportunidad de refactor hacia servicios y capa de validación única.

---

## 10. Glosario

- **Frontera comercial:** punto/medidor donde se registra el consumo de un cliente.
- **Energía activa (A):** energía útil consumida (kWh).
- **Energía reactiva (R) / capacitiva (C):** energía no útil asociada a la carga;
  su exceso genera penalización.
- **Energía exportada (E):** energía entregada a la red.
- **Energía penalizada / inductiva (P):** excedente de reactiva sobre el 50% de la
  activa, facturable como penalización.
- **Factor M:** indicador regulatorio (conteo de periodos con penalización) usado en
  la liquidación del mercado.
- **XM:** administrador del mercado eléctrico colombiano (referenciado en
  `mdlConsultarFronteraReportarXM`).
