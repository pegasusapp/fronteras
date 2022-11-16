<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');
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
        self::setUpGraphic($graph,$frontera,"Comparacion de consumo (x1000 ".Constantes::SIGLA_ACTIVA." )");
    }

    public function fillArrayDataInductiva($graph,$frontera){
        //desviaciones
        $arrayConsumoLastMonth = [];
        $arrayConsumoLastMonth = ControladorFronteras::ctrmMostrarTotalFronteraxPeriodoComparativo($frontera,1,"months",Constantes::SIGLA_SING_ACTIVA,Constantes::SIGLA_MEDIDOR_PROD);
        $datay1 = [];
        foreach($arrayConsumoLastMonth as $valor){                    array_push($datay1,$valor["total"]/1000 );

        }
        $arrayConsumoThisMonth = [];
        $arrayConsumoThisMonth = ControladorFronteras::ctrmMostrarTotalFronteraxPeriodoComparativo($frontera,1,"days",Constantes::SIGLA_SING_ACTIVA,Constantes::SIGLA_MEDIDOR_PROD);
        foreach($arrayConsumoThisMonth as $valor){
            array_push($datay1,$valor["total"]/1000 );
        }

        self::drawGrapLines($datay1,$graph,$frontera);
    }

    public function setUpGraphic($graph,$frontera,$name){
        // Setup the graph
        $graph->SetScale("textlin");
        $graph->SetTickDensity(TICKD_DENSE);
        $graph->yscale->SetAutoTicks();
        $theme_class=new UniversalTheme;
        $graph->SetTheme($theme_class);
        $top = 60;
        $bottom = 30;
        $left = 80;
        $right = 30;
        $graph->Set90AndMargin($left,$right,$top,$bottom);
        // Nice shadow
        $graph->SetShadow();
        $graph->xaxis->SetTickLabels(array('Anterior','Actual'));
        $graph->SetImgFormat('png',99);
        $graph->img->SetQuality(100);
        $graph->xaxis->SetLabelAlign('right','center','right');
        $graph->yaxis->SetLabelAlign('center','bottom');
        // Titles
        $graph->title->Set($name);
        self::fillArrayDataInductiva($graph,$frontera);
        }

        public function drawGrapLines($datay1,$graph,$frontera){
        (empty($datay1)) ? $datay1 = array(0,0) : $datay1;
            $p1 = new BarPlot($datay1);
            $p1->SetColor("#B22222");
            $p1->SetWeight(6);
            $p1->SetWidth(45);
            $graph->Add($p1);
            // Create the second line
            self::setLegend($graph,$frontera);
            }

        public function setLegend($graph,$frontera){
            self::exportImage($graph,$frontera);
        }

        public function exportImage($graph,$frontera){
        $nameoFfile = dirname(__FILE__)."/../files/imgFrt/".$frontera."_consumo";
        $graph->Stroke($nameoFfile.".png");
        }

}

$fronteras = ControladorFronteras::ctrMostrarFronteras("","");

foreach($fronteras as $valor){
    $paint = new ControlerDrawGraphicsInductiva(1000,300,'auto',$valor["fronteraCliente"]);
}

?>