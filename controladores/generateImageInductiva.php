<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require "fronteras.controlador.php";
require "utilidades.controlador.php";
require "constantes.controlador.php";




class ControlerDrawGraphicsInductiva{
    protected $graph;
    public $width;
    public $heigth;
    public $form;
    public $nameGraphic;

    public function __construct($width,$heigth,$form,$frontera){
        $graph = new Graph($width,$heigth,$form,$frontera);
        self::setUpGraphic($graph,$frontera,"Energia inductiva");
    }

    public function fillArrayDataInductiva($graph,$frontera){
        //desviaciones
        $arrayInductiva = [];
        $arrayInductiva = ControladorFronteras::ctrMostrarEnergiasFronteraDiaxEnergia($frontera,2,"P");
        $datay1 = [];
        foreach($arrayInductiva as $valor){
                    $datay1 = explode(',',$valor["datos"]);
        }
        $datax1 = [];
        foreach($datay1 as $key => $value) {
            if ($key % 2 != 0) {
                array_push($datax1,$value);
            }
        }
        self::drawGrapLines($datax1,$graph,$frontera);
    }

    public function setUpGraphic($graph,$frontera,$name){
        // Setup the graph
        $graph->SetScale("textlin");
        $graph->SetImgFormat('png',99);
        $theme_class=new UniversalTheme;
        $graph->SetTheme($theme_class);
        $graph->img->SetAntiAliasing();
        $graph->img->SetQuality(100);
        $graph->title->Set($name);
        $graph->SetBox(false);
        $graph->yaxis->title->Set("KWh");
        $graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD,50);
        $graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD,50);

        $graph->xaxis->SetTitle('Horas','center');
        $graph->yaxis->SetLabelAlign('center','bottom');
        $graph->xaxis->SetFont(FF_FONT2,FS_NORMAL,50);
        $graph->yaxis->SetFont(FF_FONT2,FS_NORMAL,50);

        $graph->SetMargin(60,40,40,60);
        $graph->yaxis->SetLabelMargin(10);
        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);
        $graph->xgrid->Show();
        $graph->xgrid->SetLineStyle("solid");
        $graph->xaxis->SetTickLabels(array('1','3','5','7','9','11','13','15','17','19','21','23'));
        $graph->xgrid->SetColor('#E3E3E3');
        self::fillArrayDataInductiva($graph,$frontera);
        }

        public function drawGrapLines($datay1,$graph,$frontera){
        (empty($datay1)) ? $datay1 = array(0,0,0,0,0,0,0,0,0,0,0,0) : $datay1;
            $p1 = new LinePlot($datay1);
            $graph->Add($p1);
            $p1->SetColor("#B22222");
            $p1->SetWeight(6);
            $p1->SetStyle("solid");
            //$p1->SetLegend('Generación de energía inductiva');
            // Create the second line
            self::setLegend($graph,$frontera);
            }

        public function setLegend($graph,$frontera){
           /* $graph->legend->SetFrameWeight(1);
            $graph->legend->SetPos(0.5,0.1,'center','top');
            $graph->legend->SetLineWeight(13);
            $graph->legend->SetMarkAbsSize(27);
            $graph->legend->SetFont(FF_FONT2,FS_NORMAL,15);*/
            self::exportImage($graph,$frontera);
        }

        public function exportImage($graph,$frontera){

        $nameoFfile = dirname(__FILE__)."/../files/imgFrt/".$frontera."_perdidas";
        $graph->Stroke($nameoFfile.".png");
        }

}

$fronteras = ControladorFronteras::ctrMostrarFronteras("","");

foreach($fronteras as $valor){
    $paint = new ControlerDrawGraphicsInductiva(800,400,'auto',$valor["fronteraCliente"]);
}

?>