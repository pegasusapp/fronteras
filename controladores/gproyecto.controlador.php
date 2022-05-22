<?php

class ControladorgProyecto{

	/*=============================================
	CREAR ITEM
	=============================================*/ 
	
	static public function ctrCreargProyecto()
	{
       
		
		if(isset($_POST["nombregProyecto"]))
		{
			$tabla = "gproyecto";
			$respuesta ="";
			$datos = array("nombregProyecto"=>$_POST["nombregProyecto"],"descripcionProyecto"=>$_POST["descripcionProyecto"],"potenciagSistema"=>$_POST["potenciagSistema"],
						   "generacionaProyecto"=>$_POST["generacionaProyecto"],"energiaAutoconsumo"=>$_POST["energiaAutoconsumo"],"energiaExcedentes"=>$_POST["energiaExcedentes"],
						   "tarifaAplicada"=>$_POST["tarifaAplicada"],"tarifaGenerada"=>$_POST["tarifaGenerada"],"trmDolar"=>$_POST["trmDolar"],"impuestoRenta"=>$_POST["impuestoRenta"],
						   "depreciacion"=>$_POST["depreciacion"],"ipc"=>$_POST["ipc"],"dtf"=>$_POST["dtf"],"interesBancario"=>$_POST["interesBancario"],"clienteProyecto_idclienteProyecto"=>$_POST["clienteProyecto_idclienteProyecto"],"tipoproyecto_idtipoproyecto"=>$_POST["tipoproyecto_idtipoproyecto"]);
			if($_POST["idgproyecto"]=="")
			  {
			   $respuesta = ModelogProyecto::mdlCreargProyecto($tabla, $datos);
			  }	   
			else
			  {
	  			$item = "idgproyecto";
				$valor = $_POST["idgproyecto"];
				$data = array( "idgproyecto"=>$_POST["idgproyecto"]);
				$datos = array_merge($datos,$data);
				$respuesta = ModelogProyecto::mdlEditargProyecto($tabla,$valor,$datos);
			  }	   
				  				
		   if($respuesta == "ok")
					{
 						echo'<script>
									swal({
											title: "Los datos han sido cambiados correctamente!",
											text: "ok",
											type: "success"
										}).then(function() 
										{
											window.location = "gproyectos";
										});
							</script>';
					}
				  else
					{
						echo "<script>
						Swal.fire({
							icon: 'error',
							title: 'Oops...algo salió mal',
							text: '".$respuesta."',
							footer: '<a href='errores'>Por favor reportar este error haciendo click aqui</a>'
						})
						";
				   }
		}

	

	} 

		/*=============================================
	MOSTRAR PROYECTOS
	=============================================*/
 
	static public function ctrMostrargProyectos($item, $valor)
	{

		$tabla = "gproyecto";
		$tabla2 = "tipoproyecto";
		$tabla3 = "clienteproyecto";
		$tabla4 = "concepto";
		$tabla5 = "movimiento";	
		$respuesta = ModelogProyecto::mdlMostrargProyectosAjax($tabla,$tabla2, $tabla3,$tabla4,$tabla5);
		//$respuesta = "ok";

      	return $respuesta;



	} 

	/*=============================================
	MOSTRAR MOVIMIENTOS
	=============================================*/
 
	static public function ctrMostrargProyectosMovimientos($item, $valor)
	{

		$tabla = "concepto";
		$tabla2 = "gproyecto";
		$tabla3 = "movimiento";
		$respuesta = ModelogProyecto::mdlMostrargProyectosMovimientos($tabla,$tabla2, $tabla3,$item,$valor);
		

      	return $respuesta;



	} 	

	static public function ctrCreargProyectoConcepto()
	{
		if(isset($_POST["nombreConcepto"]))
		{
			
			
			if($_POST["nombreConcepto"])
			  {
					$tabla = "concepto";
					

					$datos = array("nombreConcepto"=>$_POST["nombreConcepto"],"valor"=>$_POST["valor"],
					"movimiento_idmovimiento"=>$_POST["movimiento_idmovimiento"],"gproyecto_idgproyecto"=>$_POST["gproyecto_idgproyecto"],"fecha"=>$_POST["fecha"]);
				
					$respuesta = ModelogProyecto::mdlCreargProyectoConcepto($tabla, $datos);
				  
					 
					if($respuesta == "ok"){
 
											echo'<script>
						
											
											swal({
												title: "El concepto ha sido creado correctamente!",
												text: "ok",
												type: "success"
											}).then(function() {
												window.location = "gproyectos";
											});
											
											
											</script>';
				                        }
										else
										{
											echo "<script>
											Swal.fire({
												icon: 'error',
												title: 'Oops...algo salió mal',
												text: '".$respuesta."',
												footer: '<a href='errores'>Por favor reportar este error haciendo click aqui</a>'
											})
											";
										}
 
			  }
			 else{
 
				 echo'<script>
 
				 Swal.fire({
					 type: "error",
					 title: "Oops...",
					 confirmButtonText: "Shopping",
					 text: "There is no items on your cart.",
					 footer: "",
					 showCloseButton: true
				 })
				 .then(function (result) {
					 if (result.value) {
						 window.location = "gproyectos";
					 }
				 })
				   </script>';
 
 
 
			 }
 
		 }
	}
	


}

