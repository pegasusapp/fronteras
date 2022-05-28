<?php

class ControladorValidaciones
{


	/*=============================================
	Validar tipo de archivo pdf
	=============================================*/
 
	static public function validateFile($file,$fileType)
	{
		if (mime_content_type($file) == $fileType){
			return true;
		}
		return false;
	}

		


}

