<?php

//Actualizamos la información de entrada
date_default_timezone_set('America/Bogota');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	$fechaActualSalida = $fecha.' '.$hora;
	$tablaSesion="usuario_sesion";
	$nroSesion = $_SESSION['sesion_usuario'];
    $datosSalida = array("horaSalida" => $fechaActualSalida,
					"nroSesion" => $nroSesion,
					"Usuario_identificador" => $_SESSION['identificador']);
	$datosAccesoUsuarioSalida = ControladorUsuarios::ctrSalidaUsuario($tablaSesion,$datosSalida);

	// FIn actualizacion
	if($datosAccesoUsuarioSalida=="ok")
	{
		$_SESSION = array();
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
		echo '<script>window.location = "login";</script>';
	}
	else
	{
		echo "<script>alert('error');</script>";
	}