<?php
require "utilidades.controlador.php";
require "constantes.controlador.php";



function compressFolder(){
        $pathdir =  dirname(__FILE__)."/../files/pdf/";
        $zipcreated = "pdf-".ControladorUtilidades::anyoMesDia(1).".zip";
        $zip = new ZipArchive;
        if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE){
            $dir = opendir($pathdir);
            while($file = readdir($dir)) {
                if(is_file($pathdir.$file)) {
                    echo "-->".$pathdir.$file;
                    $zip -> addFile($pathdir.$file, $file);
                }
            }
            $zip ->close();
            $dataFile = [];
            $dataFile = array("nameFile" =>"pdf-".ControladorUtilidades::anyoMesDia(1),"extension"=>"zip","ubication"=>dirname(__FILE__)."/");
            $mailDestiny="luzguevara@italcol.com";
            $result = ControladorUtilidades::sendMail("Reporte diario pdf ",$mailDestiny,"Adjunto a este correo encontrará los archivos pdf del día ".ControladorUtilidades::anyoMesDia(1),$dataFile);
            print_r($dataFile);
            if($result == 1){
                unlink($zipcreated);
            }
        }
}
compressFolder();