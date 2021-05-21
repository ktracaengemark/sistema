<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['tabela'];
	
	$result = "SELECT * FROM App_Cliente WHERE idApp_Cliente='". $_GET['id'] ."'";
	
	//echo $result;
	$resultado = mysqli_query($conn, $result);
	//echo $resultado;
	$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	//echo $row_resultado;
	//echo $row_resultado['Catprod'];
	
	$event_array[0] = array(
		'id' => $row_resultado['idApp_Cliente'],
		'nome' => utf8_encode($row_resultado['NomeCliente']),
		'celular' => utf8_encode($row_resultado['CelularCliente']),
	);
	echo json_encode($event_array);
	
	//echo json_encode($row_resultado);
}else{
	echo false;
}

mysqli_close($conn);
