<?php


class ControladorUsuarios{

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/
	 public function checkbrute($identificador)
	  {

	    // Obtiene el timestamp del tiempo actual.
	    $now = new DateTime();
	    $now->modify('-2 hours');
	    $tiempo= $now->format('Y-m-d H:i:s');
	    // Todos los intentos de inicio de sesión se cuentan desde las 2 horas anteriores.
        $respuesta_fecha = ModeloLogin_attempts::mdlMostrarLoginAttempsFecha($identificador,$tiempo);
		return $respuesta_fecha > 5; 
			
	  }



	 public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"]))
		   {
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && $_POST["ingPassword"])
				 {
		 		        
					     $tabla = "usuario";
		 				 $item = "identificador";
						 $valor = $_POST["ingUsuario"];
						 $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
						 if(ctrUserIn($respuesta)){
							echo '<script>window.location = "inicio";</script>';
						 }
	
				  }
			   	  else{
						 echo Constantes::MGS_ERROR_INGRESO;
			 			 return false;
   				      }
		    }
	}

	/*=============================================
	LOGIN USER 
	===============================================*/

	static public function ctrUserIn($respuesta){

		date_default_timezone_set('America/Bogota');
		$fechaActual = date('Y-m-d').' '.date('H:i:s');
		$email_envio = $respuesta["email"];
		$password = hash('sha512', $_POST["ingPassword"].$respuesta["salt"]);
		if($respuesta["estado"] == 1) 
		 {	
				   if ($respuesta["password"] == $password)
						   {
							   
							   ctrSessionVariable($_SERVER['HTTP_USER_AGENT'],$respuesta["identificador"],
														 $respuesta["nombreCompleto"],$respuesta["nuevaFoto"],$respuesta["idPerfilUsuarios"],
														 $password);
							     $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, "ultimo_login",$fechaActual, "identificador", $respuesta["identificador"]);
							     if($ultimoLogin == "ok"){
									 return true;
									}  
						    }
				   else{
							   if (checkbrute($_POST["ingUsuario"])){							
								   $subject = "Bloqueo de usuario";
								   $emailDestino = $email_envio;
								   $mensajeBody = "Cordial saludo. El usuario con identificador ".$_POST["ingUsuario"].", ha sido bloqueado, ha estado intentanto ingresar mas de 5 veces a la plataforma, por favor contactar con el administrador, para ser desbloqueado.";
								   ControladorUtilidades::sendMail($subject,$emailDestino,$mensajeBody);	
								   $cambioEstado = ModeloUsuarios::mdlActualizarUsuario($tabla, 'estado', '0', 'identificador', $identificador);
								   if ($cambioEstado=="ok"){
										   echo Constantes::MSG_BLOQUEO;
										    } 
							   }
						   else{
								   echo Constantes::MSG_ERROR_INGRESO; 
							   }
							   return false;
					   }
		 }
		else{
			   echo Constantes::MSG_INACTIVO;
			   return false;
		   }

	}

	/*=============================================
	CREATE SESSION VARIABLE
	=============================================*/
	 public function ctrSessionVariable($user_agent,$identify,$nombreCompleto,$foto,$idPerfil,$clave){

		$user_browser = $user_agent;
		$_SESSION['identificador'] = $identify;
		$_SESSION['nombreCompleto'] = $nombreCompleto;
		$_SESSION['nuevaFoto'] = $foto;
		$_SESSION['login_string'] = hash('sha512',$clave.$user_browser);
		$_SESSION["iniciarSesion"] = "ok";
		$_SESSION["perfilSesion"] = $idPerfil;
		$nroSesion = session_id();
		$_SESSION['sesion_usuario'] = $nroSesion; 
		

	}



	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	 public function ctrCrearUsuario()
	 {

	
		
		if(isset($_POST["identificador"]))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreCompleto"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["identificador"]))
			   {

			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/
                
				$ruta = Constantes::DIR_IMG_USR_DEFAULT;

				if(isset($_FILES["nuevaFoto"]["tmp_name"]))
				{

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					$nuevoAncho = 50;
					$nuevoAlto = 50;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                
					$directorio = Constantes::DIR_IMG.$_POST["identificador"];

					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/png")
					{

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = Constantes::DIR_IMG_USR.$_POST["identificador"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				} 
				

				$tabla = "usuario";

				$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
				$password = hash('sha512',$_POST["password"] . $random_salt);
				date_default_timezone_set('America/Bogota');
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha.' '.$hora;
				$datos = array("identificador" => $_POST["identificador"],
					           "password" => $password,
					           "estado" => $_POST["estado"],
					           "email" => $_POST["email"],
							   "salt"=>$random_salt,
							   "ultimo_login" =>$fechaActual,
					           "celular"=>$_POST["celular"],
							   "nombreCompleto"=>$_POST["nombreCompleto"],
							   "PerfilUsuarios_idPerfilUsuarios"=>$_POST["idPerfilUsuarios"],
							   "nuevaFoto"=>$ruta);

				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
				
				if($respuesta == "ok"){

					echo '<script>

					swal("¡El usuario ha sido guardado correctamente!", {
						buttons: 
						{
						 catch: 
						   {
						   text: "Cerrar",
						   value: "ok",
						   }
						},
					  })
					  .then((value) => {
						switch (value)
						{
					        case "ok":
						            window.location = "crearUsuario";
							break;
					   
						    default:
						            window.location = "crearUsuario";
						}
					  });


					</script>';


				}
				else
				{
					echo "<script>

					Swal.fire({
						icon: 'error',
						title: 'Oops...algo salió mal',
						html: \"".$respuesta."\",
						footer: '<a href=\"errores\">Por favor reportar este error haciendo click aqui</a>'
					})

					</script>";
				}


			}
			else{

				echo '<script>


				swal("¡El usuario no puede ir vacío o llevar caracteres especiales!", {
					buttons: 
					{
					 catch: 
					   {
					   text: "Cerrar",
					   value: "ok",
					   }
					},
				  })
				  .then((value) => {
					switch (value)
					{
						case "ok":
								window.location = "crearUsuario";
						break;
				   
						default:
								window.location = "crearUsuario";
					}
				  });

			</script>';

			}


		}

	

	}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	 static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuario";

		return ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

	}


    /*=============================================
	EDITAR SESION USUARIO
	=============================================*/

	static public function ctrSalidaUsuario($item, $valor){

	

		$respuesta = ModeloUsuarios::mdlSalidaUsuario($item, $valor);
       
		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	 public function ctrEditarUsuario(){

        
		if(isset($_POST["editaridentificador"]))
		  {

	
			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/
                
				$ruta = $_POST["editarnuevaFoto"];
		
				
				if(isset($_FILES["nuevaFoto"]["name"]) && ($_FILES["nuevaFoto"]["name"] <> null))
					{
						
						list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

						$nuevoAncho = 500;
						$nuevoAlto = 500;

						/*=============================================
						CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
						=============================================*/
					
						$directorio = Constantes::DIR_IMG_USR.$_POST["editaridentificador"];
						if (!file_exists($directorio))  
							{ 
								mkdir($directorio, 0755);
							} 
						/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/

							$aleatorio = mt_rand(100,999);
							$ruta = Constantes::DIR_IMG_USR.$_POST["editaridentificador"]."/".$aleatorio.".png";
							$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
					} 
				$tabla = "usuario";

				if($_POST["editarpassword"] != "")
				{

					if($_POST["editarpassword"])
					{
 						
 						
                        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                        $password = hash('sha512',$_POST["editarpassword"].$random_salt);
                        $datos = array("identificador" => $_POST["editaridentificador"],
			                           "password" => $password,
			                           "salt" => $random_salt,
									   "estado" => $_POST["editarestado"],
									   "email" => $_POST["editaremail"],
									   "idPerfilUsuarios" => $_POST["editaridPerfilUsuarios"],
									   "celular" => $_POST["editarcelular"],
									   "nombreCompleto" =>  $_POST["editarnombreCompleto"],
									   "nuevaFoto" => $ruta);


					}
					else
					{ 

						echo'<script>


						swal("¡El usuario no puede ir vacío o llevar caracteres especiales!", {
								buttons: 
								{
								catch: 
								{
								text: "Cerrar",
								value: "ok",
								}
								},
							})
							.then((value) => {
								switch (value)
								{
									case "ok":
											window.location = "crearUsuario";
									break;
							
									default:
											window.location = "crearUsuario";
								}
							});


							

						  	</script>';

					}

				}
				else
				{

					
					$datos = array("identificador" => $_POST["editaridentificador"],
							   "estado" => $_POST["editarestado"],
							   "email" => $_POST["editaremail"],
							   "idPerfilUsuarios" => $_POST["editaridPerfilUsuarios"],
							   "celular" => $_POST["editarcelular"],
							   "nombreCompleto" =>  $_POST["editarnombreCompleto"],
							   "nuevaFoto" => $ruta);
					

				}
			
			  
               
				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
				if(isset($_POST["paginar"])){
					$paginar="datosPersonales";
				}else{
					$paginar="crearUsuario";
				}

				if($respuesta == "ok"){

					echo'<script>

					swal("¡El usuario ha sido editado correctamentu!", {
						buttons: 
						{
						 catch: 
						   {
						   text: "Cerrar",
						   value: "ok",
						   }
						},
					  })
					  .then((value) => {
						switch (value)
						{
					        case "ok":
						            window.location = "'.$paginar.'";
							break;
					   
						    default:
						            window.location = "'.$paginar.'";
						}
					  });


					</script>';

				}




		}
		

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	 public function ctrBorrarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];

			if($_GET["fotoUsuario"] != ""){

				unlink($_GET["fotoUsuario"]);
				rmdir(Constantes::DIR_IMG_USR.$_GET["usuario"]);

			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';

			}

		}

	}


}
