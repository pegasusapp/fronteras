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




class ControlerDrawGraphics{
    protected $graph;
    public $width;
    public $heigth;
    public $form;
    public $nameGraphic;

    public function nameDay($number_day):string{
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return $days[$number_day];
    }

    public function __construct($width,$heigth,$form,$frontera){
        $graph = new Graph($width,$heigth,$form,$frontera);
        self::setUpGraphic($graph,$frontera,"Comportamiento del día ".self::nameDay(ControladorUtilidades::getNumberday(ControladorUtilidades::anyoMesDia(1))));
    }

    public function fillArrayDataDesviacion($graph,$frontera){
        //desviaciones
        $arrayAvg = [];
        $arrayAvg = ControladorFronteras::ctrMostrarAvgEnergiasFrontera($frontera,"A",1);
        $dayTodayMySql = ControladorUtilidades::getDayToMysql(ControladorUtilidades::getNumberday(ControladorUtilidades::anyoMesDia(1)));
        $datay1 = [];
        foreach($arrayAvg as $valor){
            if($valor["dia"] == $dayTodayMySql){
                    $datay1 = explode(',',$valor["datos"]);
            }
        }
        $arrayLastDay = [];
        $datay2 = [];
        $arrayLastDay = ControladorFronteras::ctrMostrarEnergiasFronteraDiaxEnergia($frontera,1,Constantes::SIGLA_SING_ACTIVA);
        foreach($arrayLastDay as $vlr){
                    $datay2 = explode(',',$vlr["datos"]);
        }

    self::drawGrapLines($datay1,$datay2,$graph,$frontera);
    }

    public function setUpGraphic($graph,$frontera,$name){
        // Setup the graph
        $graph->SetScale("textlin");
        $graph->SetImgFormat('png',99);
        $theme_class=new UniversalTheme;
        $graph->SetTheme($theme_class);
        $graph->img->SetAntiAliasing(false);
        $graph->img->SetQuality(100);
        $graph->title->Set($name);
        $graph->SetBox(false);
        $graph->yaxis->title->Set("KWh");
        $graph->xaxis->SetTitle('Horas','center');
        $graph->yaxis->SetLabelAlign('center','bottom');
        $graph->SetMargin(60,40,40,60);
        $graph->yaxis->SetLabelMargin(10);
        $graph->img->SetAntiAliasing();
        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);
        $graph->xgrid->Show();
        $graph->xgrid->SetLineStyle("solid");
        $graph->xaxis->SetTickLabels(array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'));
        $graph->xgrid->SetColor('#E3E3E3');
        self::fillArrayDataDesviacion($graph,$frontera);
        }

        public function drawGrapLines($datay1,$datay2,$graph,$frontera){
        (empty($datay1)) ? $datay1 = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0) : $datay1;
        (empty($datay2)) ? $datay2 = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0) : $datay2;
            $p1 = new LinePlot($datay1);
            $graph->Add($p1);
            $p1->SetColor("#6495ED");
            $p1->SetLegend('Promedio del día '.self::nameDay(ControladorUtilidades::getNumberday(ControladorUtilidades::anyoMesDia(1))).' el mes pasado');
            // Create the second line
            $p2 = new LinePlot($datay2);
            $graph->Add($p2);
            $p2->SetColor("#B22222");
            $p2->SetLegend('Promedio del día '.self::nameDay(ControladorUtilidades::getNumberday(ControladorUtilidades::anyoMesDia(1))).' el mes actual');
            self::setLegend($graph,$frontera);
        }

        public function setLegend($graph,$frontera){
            $graph->legend->SetFrameWeight(1);
            $graph->legend->SetPos(0.5,0.1,'center','bottom');
            self::exportImage($graph,$frontera);
        }

        public function exportImage($graph,$frontera){

        $nameoFfile = dirname(__FILE__)."/../files/imgFrt/".$frontera."_desviacion";
        $graph->Stroke($nameoFfile.".png");
        }

}

$fronteras = ControladorFronteras::ctrMostrarFronteras("","");

foreach($fronteras as $valor){
    $paint = new ControlerDrawGraphics(1200,500,'auto',$valor["fronteraCliente"]);
}

?>