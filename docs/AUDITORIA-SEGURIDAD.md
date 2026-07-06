# Auditoría de Seguridad — "Fronteras" (ITALENER)

> Revisión estática del código fuente. Hallazgos ordenados por severidad.
> Cada ítem incluye ubicación, descripción, impacto y remediación sugerida.
> Fecha de la revisión: 2026-07-05.

---

## Resumen

Se identificaron vulnerabilidades **críticas explotables sin autenticación**
(los endpoints AJAX no validan sesión y filtran hashes de contraseña), además de
inyección SQL, XSS, subida de archivos insegura, borrado de rutas arbitrario,
secretos hardcodeados y ausencia de protección CSRF.

Prioridad recomendada: 1 → 2 → 3 → 4 → 5 → 6 (ver sección "Plan de remediación").

---

## CRÍTICAS

### C1. Los endpoints AJAX no verifican sesión (Broken Access Control)
- **Ubicación:** todos los archivos en `ajax/` (`usuarios.ajax.php`, `menu.ajax.php`,
  `fronteras.ajax.php`, `factura.ajax.php`, `clientes.ajax.php`, etc.).
- **Descripción:** ninguno hace `session_start()` ni comprueba
  `$_SESSION["iniciarSesion"]`. Se pueden invocar directamente sin login.
- **Impacto:**
  - `ajax/usuarios.ajax.php` (`ajaxEditarUsuario`/`ajaxValidarUsuario`) devuelve el
    registro del usuario **incluyendo `password` (hash) y `salt`** vía `json_encode`.
  - `ajaxActivarUsuario` permite activar/desactivar cuentas.
  - `ajax/menu.ajax.php` (`ajaxEditarMenu`) permite modificar permisos de cualquier
    usuario.
  - Exposición general de datos de fronteras, facturas y clientes.
- **Remediación:** guardia de sesión común incluida al inicio de cada endpoint
  (`session_start()` + verificar `iniciarSesion == "ok"`, cortar con 401/403 si no).

### C2. Fuga de hash + salt y hashing débil de contraseñas
- **Ubicación:** `modelos/usuarios.modelo.php` (`mdlMostrarUsuarios` selecciona
  `password, salt`); `controladores/usuarios.controlador.php` (hashing).
- **Descripción:** `password` y `salt` viajan al cliente (ver C1). El hashing es
  `sha512($password.$salt)` de una sola pasada (rápido, sin *key stretching*).
- **Impacto:** con hash + salt filtrados, las contraseñas son recuperables offline.
- **Remediación:** no exponer nunca `password`/`salt` en respuestas; migrar a
  `password_hash()` (bcrypt/argon2) y `password_verify()`.

### C3. Subida de archivos sin validación efectiva (riesgo de RCE)
- **Ubicación:** `controladores/factura.controlador.php`,
  `controladores/logLectura.controlador.php`, `controladores/validaciones.controlador.php`.
- **Descripción:**
  - `validateFile()` solo hace `in_array`.
  - En `factura` se le pasa `$_FILES["nameFile"]["tmp_name"]` (una ruta que nunca
    está en el array de MIME permitidos) y, aunque el chequeo falle, **no hay
    `return`**: el flujo sigue y ejecuta `move_uploaded_file`.
  - En `logLectura` se valida con `$_FILES['nameFile']['type']` (MIME enviado por el
    cliente, falsificable).
  - Los archivos aterrizan en `docs/facturas/...` y `docs/lecturas/` (servidos por el
    servidor web).
- **Impacto:** subir un `.php` puede derivar en ejecución remota de código.
- **Remediación:** validar extensión y MIME real con `finfo_file`; forzar `return`
  al fallar; renombrar el archivo; almacenar fuera del webroot o bloquear ejecución
  de PHP en `docs/` (`.htaccess` con `php_flag engine off` / `RemoveHandler`).

### C4. Borrado / recorrido de rutas arbitrario (Path Traversal)
- **Ubicación:** `controladores/usuarios.controlador.php` (`ctrBorrarUsuario`);
  `ajax/factura.ajax.php`; `ajax/logLectura.ajax.php`.
- **Descripción:**
  - `unlink($_GET["fotoUsuario"])` y `rmdir(Constantes::DIR_IMG_USR.$_GET["usuario"])`
    con parámetros de URL; permite borrar archivos/directorios arbitrarios con `../`.
    Además es una operación de estado por **GET**.
  - En los AJAX, `unlink($_SERVER['DOCUMENT_ROOT']."/docs/.../".$file_pointer)` con
    nombre controlado por el cliente (y sin sesión, ver C1).
- **Impacto:** borrado de archivos arbitrarios del servidor; borrado por enlace/CSRF.
- **Remediación:** operar con IDs internos, resolver la ruta desde BD, validar con
  `realpath()` que quede dentro del directorio permitido, y usar POST + token CSRF.

---

## ALTAS

### A5. Inyección SQL
- **Ubicaciones:**
  - `modelos/login_attempts.modelo.php` (`mdlMostrarLoginAttempsFecha`):
    `... WHERE Usuario_identificador = '$Usuario_identificador' AND fecha > '$tiempo'`
    por concatenación (mitigado parcialmente por `preg_match` en login).
  - `modelos/menu.modelo.php` (`mdlExpandirMenu`): concatena
    `plantillaSubproceso = '".$valor."'` con `$valor = $_GET["ruta"]`. El `.htaccess`
    limita `ruta` a `[a-zA-Z0-9]+`, pero `index.php?ruta=...` directo salta esa regla.
  - `modelos/menu.modelo.php` (`mdlEditarMenuServicio`): construye
    `IN (".implode(",",$vector_subprocesos).")` desde `$_POST`.
  - Patrón general: nombres de tabla/columna (`$tabla`, `$item`) interpolados en
    muchos modelos (los valores sí usan `bindParam`).
- **Remediación:** consultas totalmente parametrizadas; *allow-list* para nombres de
  tabla/columna; validar/castear IDs a entero antes de usarlos.

### A6. XSS reflejado y almacenado
- **Ubicaciones:**
  - `vistas/plantilla.php` (~línea 140): `echo "---->".$_GET["ruta"];` → XSS reflejado
    (además de código de depuración a eliminar).
  - `vistas/modulos/editMenu.php`: imprime `$_POST["identificadorMenu"]` sin escapar
    en el breadcrumb y en un `value`.
  - `vistas/modulos/menu.php` y `answerScript`/`answerBad` (`utilidades`): insertan
    valores de BD/errores en HTML/JS sin `htmlspecialchars`.
- **Remediación:** `htmlspecialchars()` en toda salida; eliminar el `echo $_GET`.

### A7. Credenciales y secretos hardcodeados
- **Ubicaciones:** `modelos/conexion.php` (usuario/clave MySQL);
  `controladores/constantes.controlador.php` (clave de app Gmail `PASS_EMAIL_COMPANY`,
  credenciales del web service `USER_WS`/`PASSW_WS`).
- **Impacto:** todo versionado en el repositorio.
- **Remediación:** rotar los secretos comprometidos y moverlos a variables de entorno
  fuera del control de versiones.

### A8. Ausencia de protección CSRF
- **Descripción:** no hay tokens anti-CSRF en formularios ni endpoints; combinado con
  operaciones de estado por GET (C4), un enlace basta para alterar/borrar datos.
- **Remediación:** token CSRF por sesión, validado en cada operación de escritura.

---

## MEDIAS

### M9. Divulgación de información en mensajes de error
- **Ubicaciones:** modelos que devuelven `$e->getMessage()` de PDO al cliente
  (`mdlIngresarUsuario`, `mdlEditarUsuario`, `menu.modelo`, etc.); archivos
  `logFileControlador.log` y `ajax/error_log` versionados.
- **Remediación:** registrar en servidor, devolver mensaje genérico al cliente,
  sacar los logs del repositorio.

### M10. Gestión de sesión débil
- No hay `session_regenerate_id()` tras login (session fixation).
- `login_string` no se revalida por petición.
- Faltan flags `HttpOnly`/`Secure`/`SameSite` en la cookie de sesión.

### M11. Bloqueo de cuenta como vector de DoS
- `checkbrute` bloquea (`estado=0`) tras 5 intentos por identificador; permite
  bloquear cuentas ajenas deliberadamente.
- **Remediación:** limitar por IP + backoff temporal en lugar de deshabilitar la
  cuenta permanentemente.

### M12. Datos reales versionados
- `docs/lecturas/*.csv` y `docs/facturas/Frt01081/` contienen datos de clientes.
- **Remediación:** eliminarlos del control de versiones y del historial; `.gitignore`.

---

## Plan de remediación (orden sugerido)

1. **C1 + C2** — Guardia de sesión en todos los `ajax/*.php` y dejar de enviar
   `password`/`salt` al cliente.
2. **C3** — Validación de subida real + bloqueo de ejecución PHP en `docs/`.
3. **C4** — Eliminar `unlink`/`rmdir` con entrada del cliente; IDs internos + POST/CSRF.
4. **A5** — Parametrizar SQL y *allow-list* de identificadores.
5. **A6** — Escapar salida y quitar `echo $_GET["ruta"]`.
6. **A7 + C2(hash)** — Rotar/externalizar secretos y migrar a `password_hash`.
7. **A8, M9–M12** — CSRF, manejo de errores, sesión, anti-DoS y limpieza de datos.
