<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo $_SERVER['DOCUMENT_ROOT']; 
// Crear una imagen en blanco y añadir algún texto
$im = imagecreatetruecolor(120, 20);
$color_texto = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  'Una Sencilla Cadena De Texto', $color_texto);

// Guardar la imagen como 'textosimple.jpg'
imagejpeg($im, $_SERVER['DOCUMENT_ROOT']."/fronteras/controladores/textosimple.jpg");

// Liberar memoria
imagedestroy($im);

?>