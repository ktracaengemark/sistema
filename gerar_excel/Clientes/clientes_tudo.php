<?php
include_once '../../conexao.php';
include_once("../../xlsxwriter.class.php");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'C.DataCadastroCliente >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'C.DataCadastroCliente <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;		

$data['Dia'] = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
$data['Mesvenc'] = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
$data['Ano'] = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;

//$data['NomeCliente'] = ($_SESSION['FiltroAlteraParcela']['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] : FALSE;
$data['idApp_Cliente'] = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] : FALSE;
$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'C.NomeCliente' : $_SESSION['FiltroAlteraParcela']['Campo'];
$data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
$filtro10 = ($_SESSION['FiltroAlteraParcela']['Ativo'] != '#') ? 'C.Ativo = "' . $_SESSION['FiltroAlteraParcela']['Ativo'] . '" AND ' : FALSE;
$filtro20 = ($_SESSION['FiltroAlteraParcela']['Motivo'] != '0') ? 'C.Motivo = "' . $_SESSION['FiltroAlteraParcela']['Motivo'] . '" AND ' : FALSE;


$result_query = 'SELECT * 
					FROM 
						App_Cliente AS C
					WHERE
						' . $date_inicio_orca . '
						' . $date_fim_orca . '
						' . $filtro10 . '
						' . $filtro20 . '
						C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
						' . $data['idApp_Cliente'] . ' 
						' . $data['Dia'] . ' 
						' . $data['Mesvenc'] . '
						' . $data['Ano'] . '
					ORDER BY
						' . $data['Campo'] . '
						' . $data['Ordenamento'] . '
				';
$query = mysqli_query($conn , $result_query);

$header = array('Empresa'=>'integer',
				'Ficha'=>'string',
				'ID'=>'integer',
				'Cliente'=>'string',
				'Nasc.'=>'string',
				'Sexo'=>'string',
				'Celular'=>'string',
				'Telefone'=>'string',
				'Telefone2'=>'string',
				'Telefone3'=>'string',
				'CepCliente'=>'string',
				'Endereço'=>'string',
				'NumeroCliente'=>'string',
				'ComplementoCliente'=>'string',
				'Bairro'=>'string',
				'Cidade'=>'string',
				'EstadoCliente'=>'string',
				'ReferenciaCliente'=>'string',
				'Email'=>'string',
				'Obs'=>'string',
				'Ativo'=>'string',
				'Motivo'=>'string',
				'Cadast.'=>'string',
				'ValorCash'=>'string',
				'Valid.Cash'=>'string',
				);

//$filename = "clientes.xlsx";
$filename = "Clientes_" . date('d-m-Y') . ".xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$writer = new XLSXWriter();

$writer->writeSheetHeader('Sheet1', $header);

$writer->setAuthor('Some Author'); 

while($row = $query->fetch_assoc()){ 
	
	$lineData = array(	$row["idSis_Empresa"],
						$row["RegistroFicha"],
						$row["idApp_Cliente"],
						$row["NomeCliente"],
						$row["DataNascimento"],
						$row["Sexo"],
						$row["CelularCliente"],
						$row["Telefone"],
						$row["Telefone2"],
						$row["Telefone3"],
						$row["CepCliente"],
						$row["EnderecoCliente"],
						$row["NumeroCliente"],
						$row["ComplementoCliente"],
						$row["BairroCliente"],
						$row["CidadeCliente"],
						$row["EstadoCliente"],
						$row["ReferenciaCliente"],
						$row["Email"],
						$row["Obs"],
						$row["Ativo"],
						$row["Motivo"],
						$row["DataCadastroCliente"],
						$row["CashBackCliente"],
						$row["ValidadeCashBack"]
						
					); 
	 
	$writer->writeSheetRow('Sheet1', $lineData);
}

$writer->writeToStdOut();
exit(0);