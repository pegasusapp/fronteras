<?php
/*=============================================
PLANTILLA DE CONFIGURACIÓN LOCAL
=============================================
1. Copia este archivo como  config.local.php  en la RAÍZ del proyecto
   (al mismo nivel que index.php).
2. Reemplaza los valores de ejemplo por los reales de producción.
3. config.local.php está en .gitignore: NO se versiona ni se sube por git.
   Debe crearse manualmente en cada entorno (local / producción).
=============================================*/
return array(
    // --- Base de datos ---
    'DB_HOST'  => 'localhost',
    'DB_NAME'  => 'NOMBRE_BASE_DATOS',
    'DB_USER'  => 'USUARIO_BASE_DATOS',
    'DB_PASS'  => 'CONTRASEÑA_BASE_DATOS',

    // --- Correo (SMTP Gmail) ---
    'EMAIL_COMPANY'       => 'correo@dominio.com',
    'PASS_EMAIL_COMPANY'  => 'CLAVE_APP_GMAIL',

    // --- Web service telmetergy ---
    'USER_WS'   => 'USUARIO_WS',
    'PASSW_WS'  => 'CLAVE_WS',
);
