<?php
ini_set('memory_limit', '2048M');
require_once "conexion.php";

class ModeloFronteras{

	protected int $number;
	protected string $period;
	protected array $dateLastDay;
	protected string $yearReport;
	protected string $monthReport;
	protected string $dayReport;

	public function __construct($name,$period){
        $this->dateLastPeriod = explode("-",ControladorUtilidades::lastPeriodDate($name,$period));
		$this->yearReport =  $this->dateLastPeriod[0];
		$this->monthReport = $this->dateLastPeriod[1];
		$this->dayReport = $this->dateLastPeriod[2];

    }

	static public function mdlMostrarFronteras($tabla, $item, $valor){
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
			if($item != null){
				$stmt = $pdo->prepare("SELECT * FROM $tabla WHERE $item = :$item");
				$stmt ->bindParam(":".$item, $valor, PDO::PARAM_STR);
			}
			else{
				$stmt = $pdo->prepare("SELECT  * FROM $tabla");
			}
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex){
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarEnergiasFronteraDia($valor,$anyo_curso,$mes_curso,$dia_curso){
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
			$stmt = $pdo->prepare("SELECT  anyoLectura, mesLectura , diaLectura, tipoEnergia ,concat(H1,',',H2,',',H3,',',H4,',',H5,',',H6,',',H7,',',H8,',',H9,',',H10,',',H11,',',H12,',',H13,',',H14,',',H15,',',H16,',',H17,',',H18,',',H19,',',H20,',',H21,',',H22,',',H23,',',H24) as datos,sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24) as total_dia 
									FROM lecturaFrontera
									WHERE frontera_fronteraCliente = :frontera_fronteraCliente
									AND anyoLectura = :anyoLectura
									AND mesLectura = :mesLectura
									AND diaLectura = :diaLectura
									AND tipoMedidor='P'
									GROUP BY anyoLectura, mesLectura, diaLectura,tipoEnergia, datos");
			$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
			$stmt ->bindParam(":anyoLectura", $anyo_curso, PDO::PARAM_INT);
			$stmt ->bindParam(":mesLectura", $mes_curso, PDO::PARAM_INT);
			$stmt ->bindParam(":diaLectura", $dia_curso, PDO::PARAM_INT);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex){
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarEnergiasFronteraMesEnergia($tabla,$frontera){
		$dateConstructor = new ModeloFronteras(1,"days");
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
			$stmt = $pdo->prepare("SELECT  frontera_fronteraCliente,anyoLectura,mesLectura,tipoEnergia, sum((H1)+(H2)+(H3)+(H4)+(H5)+(H6)+(H7)+(H8)+(H9)+(H10)+(H11)+(H12)+(H13)+(H14)+(H15)+(H16)+(H17)+(H18)+(H19)+(H20)+(H21)+(H22)+(H23)+(H24)) as total_mes
									FROM $tabla
									WHERE anyoLectura = :anyoLectura
									AND mesLectura = :mesLectura
									AND frontera_fronteraCliente = :frontera_fronteraCliente
									GROUP BY frontera_fronteraCliente, anyoLectura, mesLectura, tipoEnergia");
			$stmt ->bindParam(":anyoLectura", $dateConstructor->yearReport, PDO::PARAM_STR);
			$stmt ->bindParam(":mesLectura", $dateConstructor->monthReport, PDO::PARAM_STR);
			$stmt ->bindParam(":frontera_fronteraCliente", $frontera, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex){
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarTotalFronteraxPeriodoComparativo($frontera,$number,$period,$tipoEne,$tipoMed){
		$dateConstructor = new ModeloFronteras($number,$period);
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
			$stmt = $pdo->prepare("SELECT anyoLectura, mesLectura,diaLectura,frontera_fronteraCliente, sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24) AS total
									FROM lecturaFrontera
									WHERE frontera_fronteraCliente = :frontera_fronteraCliente
									AND anyoLectura = :anyoLectura
									AND mesLectura = :mesLectura
									AND diaLectura <= :diaLectura
									AND tipoEnergia = :tipoEnergia
									AND tipoMedidor = :tipoMedidor");
			$stmt ->bindParam(":frontera_fronteraCliente", $frontera, PDO::PARAM_STR);
			$stmt ->bindParam(":anyoLectura", $dateConstructor->yearReport, PDO::PARAM_STR);
			$stmt ->bindParam(":mesLectura", $dateConstructor->monthReport, PDO::PARAM_STR);
			$stmt ->bindParam(":diaLectura", $dateConstructor->dayReport, PDO::PARAM_STR);
			$stmt ->bindParam(":tipoEnergia", $tipoEne, PDO::PARAM_STR);
			$stmt ->bindParam(":tipoMedidor", $tipoMed, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarEnergiaFronteraxDiaxEnergia($valor,$time,$energia)
	{
		$dateConstructor = new ModeloFronteras($time,"days");
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
			$stmt = $pdo->prepare("SELECT  anyoLectura, mesLectura , diaLectura, tipoEnergia ,concat(H1,',',H2,',',H3,',',H4,',',H5,',',H6,',',H7,',',H8,',',H9,',',H10,',',H11,',',H12,',',H13,',',H14,',',H15,',',H16,',',H17,',',H18,',',H19,',',H20,',',H21,',',H22,',',H23,',',H24) as datos,sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24) as total_dia
									FROM lecturaFrontera
									WHERE frontera_fronteraCliente = :frontera_fronteraCliente
									AND anyoLectura = :anyoLectura
									AND mesLectura = :mesLectura
									AND diaLectura = :diaLectura
									AND tipoMedidor = 'P'
									AND tipoEnergia = :tipoEnergia
									GROUP BY anyoLectura, mesLectura, diaLectura,tipoEnergia, datos");
			$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
			$stmt ->bindParam(":anyoLectura", $dateConstructor->yearReport, PDO::PARAM_STR);
			$stmt ->bindParam(":mesLectura", $dateConstructor->monthReport, PDO::PARAM_STR);
			$stmt ->bindParam(":diaLectura", $dateConstructor->dayReport, PDO::PARAM_STR);
			$stmt ->bindParam(":tipoEnergia", $energia, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarAvgEnergiasFrontera($valor,$energia,$time)
	{
		$dateConstructor = new ModeloFronteras($time,"days");
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
					$stmt = $pdo->prepare("SELECT anyoLectura, mesLectura , frontera_fronteraCliente,tipoEnergia,DAYOFWEEK(concat( anyoLectura,'-', mesLectura,'-', diaLectura )) as dia,
												concat(avg(H1),',',avg(H2),',',avg(H3),',',avg(H4),',',avg(H5),',',avg(H6),',',avg(H7),',',avg(H8),',',avg(H9),',',avg(H10),',',avg(H11),',',
														avg(H12),',',avg(H13),',',avg(H14),',',avg(H15),',',avg(H16),',',avg(H17),',',avg(H18),',',avg(H19),',',avg(H20),',',avg(H21),',',avg(H22),',',
														avg(H23),',',avg(H24)) as datos,
														AVG((H1)+(H2)+(H3)+(H4)+(H5)+(H6)+(H7)+(H8)+(H9)+(H10)+(H11)+	(H12)+(H13)+(H14)+(H15)+(H16)+(H17)+(H18)+(H19)+(H20)+(H21)+(H22)+(H23)+(H24)) as total_dia
														FROM
														lecturaFrontera
														WHERE frontera_fronteraCliente = :frontera_fronteraCliente
														AND  anyoLectura = :anyoLectura
														AND mesLectura = :mesLectura
														AND tipoEnergia = :tipoEnergia
														AND tipoMedidor = 'P'
														GROUP BY frontera_fronteraCliente,dia, tipoEnergia");
					$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
					$stmt ->bindParam(":anyoLectura", $dateConstructor->yearReport, PDO::PARAM_STR);
					$stmt ->bindParam(":mesLectura", $dateConstructor->monthReport, PDO::PARAM_STR);
					$stmt ->bindParam(":tipoEnergia", $energia, PDO::PARAM_STR);
					$stmt ->execute();
					$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarEnergiasFronteraMes($valor,$anyo_curso,$mes_curso,$energia)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
					$stmt = $pdo->prepare("SELECT anyoLectura, mesLectura , frontera_fronteraCliente,tipoEnergia,DAYOFWEEK(concat( anyoLectura,'-', mesLectura,'-', diaLectura )) as dia,
												concat(avg(H1),',',avg(H2),',',avg(H3),',',avg(H4),',',avg(H5),',',avg(H6),',',avg(H7),',',avg(H8),',',avg(H9),',',avg(H10),',',avg(H11),',',
														avg(H12),',',avg(H13),',',avg(H14),',',avg(H15),',',avg(H16),',',avg(H17),',',avg(H18),',',avg(H19),',',avg(H20),',',avg(H21),',',avg(H22),',',
														avg(H23),',',avg(H24)) as datos,
														AVG((H1)+(H2)+(H3)+(H4)+(H5)+(H6)+(H7)+(H8)+(H9)+(H10)+(H11)+	(H12)+(H13)+(H14)+(H15)+(H16)+(H17)+(H18)+(H19)+(H20)+(H21)+(H22)+(H23)+(H24)) as total_dia 
														FROM
															lecturaFrontera
															WHERE frontera_fronteraCliente = :frontera_fronteraCliente
															AND  anyoLectura = :anyoLectura
															AND mesLectura = :mesLectura
															AND tipoEnergia = :tipoEnergia
															AND tipoMedidor='P'
															GROUP BY frontera_fronteraCliente,dia, tipoEnergia");
					$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
					$stmt ->bindParam(":anyoLectura", $anyo_curso, PDO::PARAM_STR);
					$stmt ->bindParam(":mesLectura", $mes_curso, PDO::PARAM_STR);
					$stmt ->bindParam(":tipoEnergia", $energia, PDO::PARAM_STR);
					$stmt ->execute();
					$pdo->commit();
		}
		catch (PDOException $ex){
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarEnergiasFronteraPromedio($valor)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
			$stmt = $pdo->prepare("Select  anyoLectura, mesLectura , tipoEnergia ,sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24) as datos
									from lecturaFrontera
									Where frontera_fronteraCliente = :frontera_fronteraCliente and  tipoMedidor='P'
									and  fechaCompleta BETWEEN date_sub(date_format(curdate(), '%Y-%m-01'), interval 6 month) and date_format(LAST_DAY(date_add(now(),interval -1 month)), '%Y-%m-%d')
									GROUP BY anyoLectura, mesLectura, tipoEnergia");
			$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

static public function mdlMostrarEnergiasFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
			$stmt = $pdo->prepare("SELECT anyoLectura, mesLectura,tipoEnergia, diaLectura,@var_max_val:= GREATEST(H1,H2,H3,H4,H5,H6,H7,H8,H9,H10,H11,H12,H13,H14,H15,H16,H17,H18,H19,H20,H21,H22,H23) as max_value,
			CASE @var_max_val WHEN H1 THEN 'H1'
							WHEN H2 THEN 'H2'
							WHEN H3 THEN 'H3'
							WHEN H4 THEN 'H4'
							WHEN H5 THEN 'H5'
							WHEN H6 THEN 'H6'
							WHEN H7 THEN 'H7'
							WHEN H8 THEN 'H8'
							WHEN H9 THEN 'H9'
							WHEN H10 THEN 'H10'
							WHEN H11 THEN 'H11'
							WHEN H12 THEN 'H12'
							WHEN H13 THEN 'H13'
							WHEN H14 THEN 'H14'
							WHEN H15 THEN 'H15'
							WHEN H16 THEN 'H16'
							WHEN H17 THEN 'H17'
							WHEN H18 THEN 'H18'
							WHEN H19 THEN 'H19'
							WHEN H20 THEN 'H20'
							WHEN H21 THEN 'H21'
							WHEN H22 THEN 'H22'
							WHEN H23 THEN 'H23'
							WHEN H24 THEN 'H24'
			END as column_max_value
			FROM lecturaFrontera
			WHERE frontera_fronteraCliente = :frontera_fronteraCliente
			AND tipoEnergia = :tipoEnergia
			AND tipoMedidor = 'P'
			AND anyoLectura = :anyoLectura
			AND mesLectura = :mesLectura
			GROUP BY anyoLectura, mesLectura, diaLectura, max_value,column_max_value");
			$stmt ->bindParam(":frontera_fronteraCliente", $fronteraEnvio, PDO::PARAM_STR);
			$stmt ->bindParam(":tipoEnergia", $energia, PDO::PARAM_STR);
			$stmt ->bindParam(":anyoLectura", $anyo_curso, PDO::PARAM_STR);
			$stmt ->bindParam(":mesLectura", $mes_curso, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarTotalConsumoFronterasAnyoEnergia($valor)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
		if($valor != ""){
			$stmt = $pdo->prepare("SELECT lecf.anyoLectura,lecf.tipoEnergia, sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24) AS total 
									FROM lecturaFrontera lecf LEFT JOIN frontera frt ON lecf.frontera_fronteraCliente = frt.fronteraCliente
									WHERE frt.clienteFrontera_nitCliente=:frontera_fronteraCliente
									AND lecf.tipoMedidor='P'
									AND lecf.tipoEnergia='A'
									AND  anyoLectura BETWEEN YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 24 month)) and YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 0 month)) 
									GROUP BY lecf.anyoLectura,lecf.tipoEnergia");
			$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
		}else{
			$stmt = $pdo->prepare("SELECT lecf.anyoLectura,lecf.tipoEnergia, sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24) AS total 
									FROM lecturaFrontera lecf LEFT JOIN frontera frt ON lecf.frontera_fronteraCliente = frt.fronteraCliente
									WHERE  lecf.tipoMedidor='P'
									AND lecf.tipoEnergia='A'
									AND  anyoLectura BETWEEN YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 24 month)) and YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 0 month)) 
									GROUP BY lecf.anyoLectura,lecf.tipoEnergia");
		}
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarTotalConsumoFronterasAnyoMesEnergia($valor)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
			if($valor != ""){
				$stmt = $pdo->prepare("SELECT s.anyoLectura,GROUP_CONCAT(s.mesLectura) as mesLectura, GROUP_CONCAT(total) as total
									FROM
									(SELECT lecf.anyoLectura,lecf.mesLectura,ROUND(sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24),2) AS total 
										FROM lecturaFrontera lecf LEFT JOIN frontera frt ON lecf.frontera_fronteraCliente = frt.fronteraCliente
										WHERE frt.clienteFrontera_nitCliente=:frontera_fronteraCliente
										AND lecf.tipoMedidor='P'
										AND lecf.tipoEnergia='A'
										AND  anyoLectura BETWEEN YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 24 month))
										AND YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 0 month))
										GROUP BY lecf.anyoLectura,lecf.mesLectura
										) s");
				$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
			}
			else{
				$stmt = $pdo->prepare("SELECT s.anyoLectura,GROUP_CONCAT(s.mesLectura) as mesLectura, GROUP_CONCAT(total) as total
									FROM
									(
										SELECT lecf.anyoLectura,lecf.mesLectura,ROUND(sum(H1+H2+H3+H4+H5+H6+H7+H8+H9+H10+H11+H12+H13+H14+H15+H16+H17+H18+H19+H20+H21+H22+H23+H24),2) AS total 
										FROM lecturaFrontera lecf LEFT JOIN frontera frt ON lecf.frontera_fronteraCliente = frt.fronteraCliente
										WHERE lecf.tipoMedidor='P'
										AND lecf.tipoEnergia='A'
										AND anyoLectura BETWEEN YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 24 month))
										AND YEAR(date_sub(date_format(curdate(), '%Y-%m-%d'), interval 0 month))
										GROUP BY lecf.anyoLectura,lecf.mesLectura
									) s");
			}
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}


	static public function mdlEditarFrontera($tabla, $item,$item2,$item3, $datos)
	{

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
				$stmt = $pdo->prepare("UPDATE $tabla SET $item = :$item,$item3 = :$item3 WHERE $item2 = :$item2");
				$stmt ->bindParam(":".$item, $datos["seguimiento"], PDO::PARAM_STR);
				$stmt ->bindParam(":".$item3, $datos["minimoKv"], PDO::PARAM_INT);
				$stmt ->bindParam(":".$item2, $datos["fronteraCliente"], PDO::PARAM_STR);
				$stmt ->execute();
				$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return "ok";
	}

	static public function mdlConsultarFronteraReportarXM($valor,$energia)
	{
		$dateConstructor = new ModeloFronteras(1,"days");
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
			$stmt = $pdo->prepare("SELECT *
									FROM lecturaFrontera
									WHERE frontera_fronteraCliente IN (:frontera_fronteraCliente)
									AND tipoMedidor='P'
									AND tipoEnergia=:tipoEnergia
									AND  anyoLectura=:anyoLectura
									AND mesLectura=:mesLectura
									AND diaLectura=:diaLectura");
			$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
			$stmt ->bindParam(":tipoEnergia", $energia, PDO::PARAM_STR);
			$stmt ->bindParam(":anyoLectura", $dateConstructor->yearReport, PDO::PARAM_INT);
			$stmt ->bindParam(":mesLectura",  $dateConstructor->monthReport, PDO::PARAM_INT);
			$stmt ->bindParam(":diaLectura",  $dateConstructor->dayReport, PDO::PARAM_INT);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlCrearFronteraPenalizada($anyo,$mes,$dia,$frontera,$valor)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{

			$stmt = $pdo->prepare("INSERT INTO
							penalizacionFrontera(fechaRegistro, diaPenalizacion, mesLectura, anyoLectura, valor, frontera_fronteraCliente)
							VALUES(NOW(), :diaPenalizacion, :mesLectura, :anyoLectura, :valor, :frontera_fronteraCliente) ");
			$stmt ->bindParam(":diaPenalizacion", $dia, PDO::PARAM_INT);
			$stmt ->bindParam(":mesLectura",  $mes, PDO::PARAM_INT);
			$stmt ->bindParam(":anyoLectura", $anyo, PDO::PARAM_INT);
			$stmt ->bindParam(":valor",  $valor, PDO::PARAM_INT);
			$stmt ->bindParam(":frontera_fronteraCliente", $frontera, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}


	static public function mdlMostrarMatrizEnergiaDatos($tabla,$item, $valor,$valor2,$valor21,$item3,$valor3)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try{
			$stmt = $pdo->prepare("SELECT  anyoLectura, mesLectura , diaLectura, frontera_fronteraCliente,H1,H2,H3,H4,H5,H6,H7,H8,H9,H10,H11,H12,H13,H14,H15,H16,H17,H18,H19,H20,H21,H22,H23,H24
										FROM $tabla
										WHERE $item = :$item
										AND $item3 = :$item3
										AND tipoMedidor='P'
										AND fechaCompleta BETWEEN date_format('$valor2', '%Y-%m-%d') and date_format('$valor21','%Y-%m-%d')");
			$stmt ->bindParam(":frontera_fronteraCliente", $valor, PDO::PARAM_STR);
			$stmt ->bindParam(":tipoEnergia", $valor3, PDO::PARAM_STR);
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex)
		{
				$pdo->rollBack();
				return $ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlSearchData($dataIn):int{

		$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM lecturaFrontera WHERE diaLectura = :diaLectura AND mesLectura = :mesLectura AND anyoLectura = :anyoLectura AND frontera_fronteraCliente = :frontera_fronteraCliente AND tipoEnergia = :tipoEnergia");
		$stmt -> bindParam(":diaLectura", $dataIn["diaLectura"], PDO::PARAM_STR);
		$stmt -> bindParam(":mesLectura", $dataIn["mesLectura"], PDO::PARAM_STR);
		$stmt -> bindParam(":anyoLectura", $dataIn["anyoLectura"], PDO::PARAM_STR);
		$stmt -> bindParam(":frontera_fronteraCliente", $dataIn["frontera_fronteraCliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":tipoEnergia", $dataIn["tipoEnergia"], PDO::PARAM_STR);
		$stmt -> execute();
		return  $stmt->fetchColumn();
	}

	static public function mdlInsertLecturasFrontera($datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva,$datosLecturasEnergiaPenalizada):bool{

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try
		{
			$resultado_gral = array();
			$result_activa = array_merge($datosMedidor,$datosLecturasEnergiaActiva);
			$resultado_gral +=[0=>$result_activa];
			$result_exportada = array_merge($datosMedidor,$datosLecturasEnergiaExportada);
			$resultado_gral +=[1=>$result_exportada];
			$result_reactiva = array_merge($datosMedidor,$datosLecturasEnergiaReactiva);
			$resultado_gral +=[2=>$result_reactiva];
			$result_capacitiva = array_merge($datosMedidor,$datosLecturasEnergiaCapacitiva);
			$resultado_gral +=[3=>$result_capacitiva];
			$result_penalizada = array_merge($datosMedidor,$datosLecturasEnergiaPenalizada);
			$resultado_gral +=[4=>$result_penalizada];
			for($i = 0; $i < count($resultado_gral); $i++)
			{
			if(self::mdlSearchData($resultado_gral[$i]) == 0)
								{
									$stmt = $pdo->prepare("INSERT INTO lecturaFrontera(diaLectura, mesLectura, anyoLectura, H1, H2, H3, H4, H5, H6, H7, H8, H9, H10, H11, H12, H13, H14, H15, H16, H17, H18, H19, H20, H21, H22, H23, H24, medidorFrontera, frontera_fronteraCliente, tipoEnergia, tipoMedidor, fechaCompleta) VALUES (:diaLectura, :mesLectura, :anyoLectura,:H1, :H2,:H3, :H4, :H5, :H6, :H7, :H8, :H9, :H10, :H11, :H12, :H13, :H14, :H15, :H16, :H17, :H18, :H19, :H20, :H21, :H22, :H23, :H24, :medidorFrontera, :frontera_fronteraCliente, :tipoEnergia, :tipoMedidor, :fechaCompleta)");
									$stmt->execute($resultado_gral[$i]);
								}
							else{
									$stmt = $pdo->prepare("UPDATE lecturaFrontera
														SET
														H1 = :H1,
														H2 = :H2,
														H3 = :H3,
														H4 = :H4,
														H5 = :H5,
														H6 = :H6,
														H7 = :H7,
														H8 = :H8,
														H9 = :H9,
														H10 = :H10,
														H11 = :H11,
														H12 = :H12,
														H13 = :H13,
														H14 = :H14,
														H15 = :H15,
														H16 = :H16,
														H17 = :H17,
														H18 = :H18,
														H19 = :H19,
														H20 = :H20,
														H21 = :H21,
														H22 = :H22,
														H23 = :H23,
														H24 = :H24,
														medidorFrontera = :medidorFrontera,
														tipoMedidor = :tipoMedidor,
														fechaCompleta = :fechaCompleta
														WHERE
														diaLectura = :diaLectura AND
														mesLectura = :mesLectura AND
														anyoLectura = :anyoLectura AND
														frontera_fronteraCliente = :frontera_fronteraCliente AND
														tipoEnergia = :tipoEnergia");
									$stmt ->bindParam(":H1", $resultado_gral[$i]["H1"], PDO::PARAM_STR);
									$stmt ->bindParam(":H2", $resultado_gral[$i]["H2"], PDO::PARAM_INT);
									$stmt ->bindParam(":H3", $resultado_gral[$i]["H3"], PDO::PARAM_STR);
									$stmt ->bindParam(":H4", $resultado_gral[$i]["H4"], PDO::PARAM_STR);
									$stmt ->bindParam(":H5", $resultado_gral[$i]["H5"], PDO::PARAM_STR);
									$stmt ->bindParam(":H6", $resultado_gral[$i]["H6"], PDO::PARAM_STR);
									$stmt ->bindParam(":H7", $resultado_gral[$i]["H7"], PDO::PARAM_STR);
									$stmt ->bindParam(":H8", $resultado_gral[$i]["H8"], PDO::PARAM_STR);
									$stmt ->bindParam(":H9", $resultado_gral[$i]["H9"], PDO::PARAM_STR);
									$stmt ->bindParam(":H10", $resultado_gral[$i]["H10"], PDO::PARAM_STR);
									$stmt ->bindParam(":H11", $resultado_gral[$i]["H11"], PDO::PARAM_STR);
									$stmt ->bindParam(":H12", $resultado_gral[$i]["H12"], PDO::PARAM_STR);
									$stmt ->bindParam(":H13", $resultado_gral[$i]["H13"], PDO::PARAM_STR);
									$stmt ->bindParam(":H14", $resultado_gral[$i]["H14"], PDO::PARAM_STR);
									$stmt ->bindParam(":H15", $resultado_gral[$i]["H15"], PDO::PARAM_STR);
									$stmt ->bindParam(":H16", $resultado_gral[$i]["H16"], PDO::PARAM_STR);
									$stmt ->bindParam(":H17", $resultado_gral[$i]["H17"], PDO::PARAM_STR);
									$stmt ->bindParam(":H18", $resultado_gral[$i]["H18"], PDO::PARAM_STR);
									$stmt ->bindParam(":H19", $resultado_gral[$i]["H19"], PDO::PARAM_STR);
									$stmt ->bindParam(":H20", $resultado_gral[$i]["H20"], PDO::PARAM_STR);
									$stmt ->bindParam(":H21", $resultado_gral[$i]["H21"], PDO::PARAM_STR);
									$stmt ->bindParam(":H22", $resultado_gral[$i]["H22"], PDO::PARAM_STR);
									$stmt ->bindParam(":H23", $resultado_gral[$i]["H23"], PDO::PARAM_STR);
									$stmt ->bindParam(":H24", $resultado_gral[$i]["H24"], PDO::PARAM_STR);
									$stmt ->bindParam(":medidorFrontera", $resultado_gral[$i]["medidorFrontera"], PDO::PARAM_STR);
									$stmt ->bindParam(":tipoMedidor", $resultado_gral[$i]["tipoMedidor"], PDO::PARAM_STR);
									$stmt ->bindParam(":fechaCompleta", $resultado_gral[$i]["fechaCompleta"], PDO::PARAM_STR);
									$stmt ->bindParam(":diaLectura", $resultado_gral[$i]["diaLectura"], PDO::PARAM_STR);
									$stmt ->bindParam(":mesLectura", $resultado_gral[$i]["mesLectura"], PDO::PARAM_STR);
									$stmt ->bindParam(":anyoLectura", $resultado_gral[$i]["anyoLectura"], PDO::PARAM_STR);
									$stmt ->bindParam(":frontera_fronteraCliente", $resultado_gral[$i]["frontera_fronteraCliente"], PDO::PARAM_STR);
									$stmt ->bindParam(":tipoEnergia", $resultado_gral[$i]["tipoEnergia"], PDO::PARAM_STR);
									$stmt ->execute();
							}
			}
			$pdo->commit();
		}
		catch (PDOException $ex)
			{
				$pdo->rollBack();
				return false;
			}
		return true;
	}
}