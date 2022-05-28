<?php

class ControladorValidaciones
{


	/*=============================================
	Validar tipo de archivo pdf
	=============================================*/
 
	static public function validateFile($file,$fileType)
	{
        echo "/////---////".mime_content_type($file);
		if (mime_content_type($file) == $fileType){
			return true;
		}
		return false;
	}

		


}

