<?php

class ControladorUtilidades
{




	/*============================================
	 Respuesta generica
	 =============================================*/
	 static public function answerScript($texto,$back){

		return '<script>

					swal("¡'.$texto.'!", {
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
						            window.location = "'.$back.'";
							break;
					   
						    default:
						            window.location = "'.$back.'";
						}
					  });


					</script>';


	 }	
	


}

