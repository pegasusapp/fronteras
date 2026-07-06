<?php
/*=============================================
GUARDIA DE SESIÓN PARA ENDPOINTS AJAX
Incluir al inicio de cada ajax/*.php.
Corta con 401 cualquier petición sin sesión válida.
=============================================*/
if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => $secure,
    ]);
    session_start();
}

if (!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] !== "ok") {
    http_response_code(401);
    header("Content-Type: application/json; charset=utf-8");
    exit(json_encode(["error" => "No autorizado"]));
}