<?php
include_once '../../conexao.php';
include_once("../../xlsxwriter.class.php");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$result_query = "SELECT * FROM App_Cliente WHERE idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . "";
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