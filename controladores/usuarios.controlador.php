<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

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
	    //$valid_attempts = $now - (2 * 60 * 60);
        $respuesta_fecha = ModeloLogin_attempts::mdlMostrarLoginAttempsFecha($identificador,$tiempo);

	        // Si ha habido más de 5 intentos de inicio de sesión fallidos.
			if ($respuesta_fecha > 5) 
			{
	            return true;
			} 
			else 
			{
	            return false;
	        }
	    }



	 public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"]))
		   {
			date_default_timezone_set('America/Bogota');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && $_POST["ingPassword"])
				 {
		 		        
		 		         $tabla = "usuario";
		 				 $item = "identificador";
						 $valor = $_POST["ingUsuario"];
						 $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
						 $email_envio = $respuesta["email"];
						 $identificador=$respuesta["identificador"];
						 $password = hash('sha512', $_POST["ingPassword"].$respuesta["salt"]);
					
						 if($respuesta["estado"] == 1) 
						  {	
									if ($respuesta["password"] == $password)
											{
													// ¡La contraseña es correcta!
													// Obtén el agente de usuario del usuario.
													$user_browser = $_SERVER['HTTP_USER_AGENT'];
													//  Protección XSS ya que podríamos imprimir este valor.
													$identificador = preg_replace("/[^0-9]+/", "", $respuesta["identificador"]);
													$_SESSION['identificador'] = $respuesta["identificador"];
													$_SESSION['nombreCompleto'] = $respuesta["nombreCompleto"];
													$_SESSION['nuevaFoto'] = $respuesta["nuevaFoto"];
													$_SESSION['login_string'] = hash('sha512',$password.$user_browser);
													$_SESSION["iniciarSesion"] = "ok";
													$_SESSION["perfilSesion"] = $respuesta["idPerfilUsuarios"];

												
													$item1 = "ultimo_login";
													$valor1 = $fechaActual;
													$item2 = "identificador";
													$valor2 = $respuesta["identificador"];
													$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
													$tablaSesion="usuario_sesion";
													$ipUsuarioSesion=$_SERVER['REMOTE_ADDR'];
													$user_agent = $_SERVER['HTTP_USER_AGENT'];
													$nroSesion = session_id();
													$_SESSION['sesion_usuario'] = $nroSesion; 

													$datosAcceso = array("horaIngreso" => $fechaActual,
																		 "horaSalida" =>$fechaActual,
																		 "dirIP" => $ipUsuarioSesion,
																		 "nroSesion" => $nroSesion,
																		 "navegador" => $user_agent,"Usuario_identificador" => $respuesta["identificador"]);
													$datosAccesoUsuario = ModeloUsuarios::mdlAccesoUsuario($tablaSesion,$datosAcceso);
													
													if($ultimoLogin == "ok")
															{
																echo '<script>
																window.location = "inicio";
																</script>';
															}

											}
									else
											{
													// La contraseña no es correcta.
													// Se graba este intento en la base de datos.
													
													$identificador = $_POST["ingUsuario"];
													$datos_login_fallido = array("fecha" => $fechaActual,"Usuario_identificador" => $identificador);
													$intentoLogin = ModeloLogin_attempts::mdlIngresarLoginAttemps('login_attempts', $datos_login_fallido);
													if ($this->checkbrute($identificador) == true)
														{							
															// La cuenta está bloqueada.
															$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
															try {
																	//Server settings
																	//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
																	//Enable SMTP debugging.
																	//$mail->SMTPDebug = 3;  
																	$mail->isSMTP();                                      // Set mailer to use SMTP
																	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
																	$mail->SMTPAuth = true;                               // Enable SMTP authentication
																	$mail->Username = 'notificaciones.sistemas@ruitoqueesp.com';                 // SMTP username
																	$mail->Password = 'od2001601';                           // SMTP password
																	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
																	$mail->Port = 587;                                     // TCP port to connect to
																	//$mail->setFrom('notificaciones.sistemas@ruitoqueesp.com', 'Ruitoque SA ESP');
																	$mail->From = "notificaciones.sistemas@ruitoqueesp.com";
																	$mail->FromName = "Ruitoque SA ESP- Fronteras de energía";
																	$mail->addAddress($email_envio, 'Usuario :');     // Add a recipient
																	$mail->isHTML(true);                                                      // Set email format to HTML
																	$mail->Subject = 'Bloqueo de usuario';
																	$mail->Body    = 'Cordial saludo. El usuario con identificador  '.$identificador.', ha sido bloqueado, ha estado intentanto ingresar mas de 5 veces a la plataforma, por favor contactar con el administrador, para ser desbloqueado.';
																	$mail->send();
																	echo '<br><div class="alert alert-danger">Usted ha sido bloqueado</div>';
																} 
															catch (Exception $e)
																{
																		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
																}
														// actualizamos el estado del usuarios
																$cambioEstado = ModeloUsuarios::mdlActualizarUsuario($tabla, 'estado', '0', 'identificador', $identificador);
																if ($cambioEstado=="ok")
																		{
											
																			return false;
																			echo '<br><div class="alert alert-danger">Usted ha sido bloqueado</div>';

																		} 
														}
														else
														{

																echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

														}

											}
						}
						else
						   {
  						 	 echo '<br><div class="alert alert-danger">Su usuario se encuentra inactivo</div>';
							}	
				}
				else
				   {

						
										 // La contraseña no es correcta.
										 // Se graba este intento en la base de datos.
										 $now = time();
										 $identificador=$_POST["ingUsuario"];
										 $datos_login_fallido = array("fecha" => $now,"Usuario_identificador" => $identificador);
										 $intentoLogin = ModeloLogin_attempts::mdlIngresarLoginAttemps('login_attempts', $identificador);
										 if ($this->checkbrute($identificador) == true)
		 									{							
												// La cuenta está bloqueada.
												$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
												try {
														//Server settings
														//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
														$mail->isSMTP();                                      // Set mailer to use SMTP
														$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
														$mail->SMTPAuth = true;                               // Enable SMTP authentication
														$mail->Username = 'notificaciones.italener@gmail.com';                 // SMTP username
														$mail->Password = 'Od2001601.';                           // SMTP password
														$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
														$mail->Port = 587;                                    // TCP port to connect to
														$mail->setFrom('notificaciones.italener@gmail.com', 'Italener');
														$mail->addAddress($email_envio, 'Usuario :');     // Add a recipient
														$mail->isHTML(true);                                  // Set email format to HTML
														$mail->Subject = 'Bloqueo de usuario';
														$mail->Body    = 'Cordial saludo. El usuario con identificador  '.$identificador.', ha sido bloqueado, ha estado intentanto ingresar mas de 5 veces a la plataforma, por favor contactar con el administrador, para ser desbloqueado.';
														$mail->send();
														
													} catch (Exception $e) {
															echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
													}
													echo '<br><div class="alert alert-danger">Usted ha sido bloqueado</div>';
				  							// actualizamos el estado del usuarios
													$cambioEstado = ModeloUsuarios::mdlActualizarUsuario($tabla, 'estado', '0', 'identificador', $identificador);
													if ($cambioEstado=="ok")
															 {
								
																return false;
																

															 } 
								 			}
								 			else
											   {

													echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

												}

					}
			

		}
		

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
                
				$ruta = "vistas/img/usuarios/default/anonymous.png";

				if(isset($_FILES["nuevaFoto"]["tmp_name"]))
				{

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					$nuevoAncho = 50;
					$nuevoAlto = 50;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                
					$directorio = "vistas/img/usuarios/".$_POST["identificador"];

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

						$ruta = "vistas/img/usuarios/".$_POST["identificador"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				} 
				

				$tabla = "usuario";

				//$encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
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

		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;
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
		
				
				if(isset($_FILES["nuevaFoto"]["name"]) and ($_FILES["nuevaFoto"]["name"] <> null))
					{
						
						list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

						$nuevoAncho = 500;
						$nuevoAlto = 500;

						/*=============================================
						CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
						=============================================*/
					
						$directorio = "vistas/img/usuarios/".$_POST["editaridentificador"];
						if (!file_exists($directorio))  
							{ 
								mkdir($directorio, 0755);
							} 
							
							

						/*=============================================
						DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
						=============================================*/



						
							/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/

							$aleatorio = mt_rand(100,999);
							$ruta = "vistas/img/usuarios/".$_POST["editaridentificador"]."/".$aleatorio.".png";
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
				if(isset($_POST["paginar"])){$paginar="datosPersonales";}else{$paginar="crearUsuario";};

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
				rmdir('vistas/img/usuarios/'.$_GET["usuario"]);

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
