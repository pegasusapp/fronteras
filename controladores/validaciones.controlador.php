<?php

class ControladorValidaciones
{


	/*=============================================
	Validar tipo de archivo pdf
	=============================================*/
 
	static public function validateFile($nameFile,$fileType)
	{

		if (mime_content_type($_FILES[$nameFile]['tmp_name']) == $fileType){
			return true;
		}
		return false;
	}

		


}

