<?php

//create_pdf.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('pdf.php');

if(isset($_POST["hidden_html"]) && $_POST["hidden_html"] != '')
{
 $file_name = 'google_chart.pdf';
 $html = '<link rel="stylesheet" href="bootstrap.min.css">';
 $html .= $_POST["hidden_html"];

 $pdf = new Pdf();
 $pdf->load_html($html);
 $pdf->render();
 $salida = $pdf->output();
 $file_location = $_SERVER['DOCUMENT_ROOT']."/docs/facturas/salida.pdf";

        file_put_contents($file_location, $salida);
}

?>
