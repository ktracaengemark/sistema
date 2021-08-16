<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['tabela'];
	
	$result = (
				"SELECT
					idApp_Cliente, 
					NomeCliente,
					CelularCliente,
					Telefone,
					Telefone2,
					Telefone3
				FROM 
					App_Cliente 
				WHERE 
					idApp_Cliente='". $_GET['id'] ."'"
	);
	
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
		'telefone' => utf8_encode($row_resultado['Telefone']),
		'telefone2' => utf8_encode($row_resultado['Telefone2']),
		'telefone3' => utf8_encode($row_resultado['Telefone3']),
	);
	echo json_encode($event_array);
	
	//echo json_encode($row_resultado);
}else{
	echo false;
}

mysqli_close($conn);
