<?php 
	
	//include_once('config.php'); 
	//include('Classes/PHPExcel.php');
	include_once '../../conexao.php';
	include_once '../../Classes/PHPExcel.php';
 
$objPHPExcel    =   new PHPExcel();
//$result         =   $db->query("SELECT * FROM App_Cliente") or die(mysql_error());

$result_query = "SELECT * FROM App_Cliente WHERE idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . "";
$result = mysqli_query($conn , $result_query);
 
$objPHPExcel->setActiveSheetIndex(0);
 
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Empresa');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Ficha');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ID');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Cliente');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Nasc');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Sexo');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Celular');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Telefone');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Telefone2');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Telefone3');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'CepCliente');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Endereço');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Numero');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Complemento');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Bairro');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Cidade');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Estado');
$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Referencia');
$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Email');
$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Obs');
$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Ativo');
$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Motivo');
$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Cadast');
$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'ValorCash');
$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'ValidCash');

//$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
 
$rowCount   =   2;
while($row  =   $result->fetch_assoc()){

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, mb_strtoupper($row['idSis_Empresa'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, mb_strtoupper($row['RegistroFicha'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, mb_strtoupper($row['idApp_Cliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, mb_strtoupper($row['NomeCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, mb_strtoupper($row['DataNascimento'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, mb_strtoupper($row['Sexo'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, mb_strtoupper($row['CelularCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, mb_strtoupper($row['Telefone'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, mb_strtoupper($row['Telefone2'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, mb_strtoupper($row['Telefone3'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, mb_strtoupper($row['CepCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, mb_strtoupper($row['EnderecoCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, mb_strtoupper($row['NumeroCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, mb_strtoupper($row['ComplementoCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, mb_strtoupper($row['BairroCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, mb_strtoupper($row['CidadeCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, mb_strtoupper($row['EstadoCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, mb_strtoupper($row['ReferenciaCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, mb_strtoupper($row['Email'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, mb_strtoupper($row['Obs'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, mb_strtoupper($row['Ativo'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, mb_strtoupper($row['Motivo'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, mb_strtoupper($row['DataCadastroCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, mb_strtoupper($row['CashBackCliente'],'UTF-8'));
    $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, mb_strtoupper($row['ValidadeCashBack'],'UTF-8'));
    
	$rowCount++;
	
}
 
 
$objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
 
 
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="teste_clientes.xlsx"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
$objWriter->save('php://output');
?>