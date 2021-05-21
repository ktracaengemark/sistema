<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];
	$result = "SELECT * FROM App_ClienteDep WHERE idApp_ClienteDep='". $_GET['id'] ."'";
	//echo $result;
	$resultado = mysqli_query($conn, $result);
	//echo $resultado;
	$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	//echo $row_resultado;
	$event_array[0] = array(
		'id' => $row_resultado['idApp_ClienteDep'],
		'nome' => utf8_encode($row_resultado['NomeClienteDep']),
		'nascimento' => utf8_encode($row_resultado['DataNascimentoDep']),
		'sexo' => utf8_encode($row_resultado['SexoDep']),
		'obs' => utf8_encode($row_resultado['ObsDep']),
	);
	echo json_encode($event_array);
	//echo json_encode($row_resultado);
}else{
	echo false;
}

mysqli_close($conn);
