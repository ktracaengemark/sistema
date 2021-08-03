<?php
include_once '../../conexao.php';
include_once("../../xlsxwriter.class.php");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$tipoevento = 'CO.Tipo = ' . $_SESSION['Agendamentos']['TipoEvento'];

$cliente 	= ($_SESSION['Agendamentos']['idApp_Cliente']) ? ' AND CO.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] : FALSE;
$clientepet = ($_SESSION['Empresa']['CadastrarPet'] == "S" && $_SESSION['Agendamentos']['idApp_ClientePet']) ? ' AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] : FALSE;
$clientedep = ($_SESSION['Empresa']['CadastrarDep'] == "S" && $_SESSION['Agendamentos']['idApp_ClienteDep']) ? ' AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep'] : FALSE;

$campo 			= (!$_SESSION['Agendamentos']['Campo']) ? 'CO.DataInicio' : $_SESSION['Agendamentos']['Campo'];
$ordenamento 	= (!$_SESSION['Agendamentos']['Ordenamento']) ? 'ASC' : $_SESSION['Agendamentos']['Ordenamento'];

($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;

$date_inicio_orca 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
$date_fim_orca 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

$result_query = '
					SELECT
						CO.*,
						CO.idSis_Empresa AS Empresa,
						DATE_FORMAT(CO.DataInicio, "%Y-%m-%d") AS DataInicio,
						DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
						DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
						DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim,
						C.idApp_Cliente AS id_Cliente,
						CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
						CP.*,
						CONCAT(IFNULL(CP.idApp_ClientePet,""), " - " ,IFNULL(CP.NomeClientePet,"")) AS NomeClientePet,
						RP.RacaPet,
						CD.*,
						CONCAT(IFNULL(CD.idApp_ClienteDep,""), " - " ,IFNULL(CD.NomeClienteDep,"")) AS NomeClienteDep
					FROM
						App_Consulta AS CO
							LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
							LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
							LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CP.RacaPet
							LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = CO.idApp_ClienteDep
					WHERE
						' . $date_inicio_orca . '
						' . $date_fim_orca . '
						CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
						' . $tipoevento . '
						' . $cliente . '
						' . $clientepet . '
						' . $clientedep . '
					ORDER BY
						' . $campo . '
						' . $ordenamento . '
				';
$query = mysqli_query($conn , $result_query);

$header = array('Empresa'=>'integer',
				'ID'=>'integer',
				'Cliente'=>'string',
				);

$filename = "Agendamentos_" . date('d-m-Y') . ".xlsx";

header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$writer = new XLSXWriter();

$writer->writeSheetHeader('Sheet1', $header);

$writer->setAuthor('Some Author'); 

while($row = $query->fetch_assoc()){ 
	
	$lineData = array(	$row["Empresa"],
						$row["id_Cliente"],
						$row["NomeCliente"]
					); 
	 
	$writer->writeSheetRow('Sheet1', $lineData);
}

$writer->writeToStdOut();

exit(0);