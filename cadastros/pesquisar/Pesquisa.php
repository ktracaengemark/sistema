<?php
	
include_once '../../conexao.php';

if($_GET['q'] == "idTab_Catprod") {
	
	if ($_GET['id']) {
		//echo $_GET['tabela'];
		
		$result = "SELECT * FROM Tab_Catprod WHERE idTab_Catprod='". $_GET['id'] ."'";
		
		//echo $result;
		$resultado = mysqli_query($conn, $result);
		//echo $resultado;
		$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		//echo $row_resultado;
		//echo $row_resultado['Catprod'];
		
		$event_array[0] = array(
			'id' => $row_resultado['idTab_Catprod'],
			'nome' => utf8_encode($row_resultado['Catprod']),
		);
		echo json_encode($event_array);
		
		//echo json_encode($row_resultado);
	}
	
}elseif($_GET['q'] == "idTab_Produto") {
	
	if ($_GET['id']) {
		//echo $_GET['tabela'];
		
		$result = "SELECT * FROM Tab_Produto WHERE idTab_Produto='". $_GET['id'] ."'";
		
		//echo $result;
		$resultado = mysqli_query($conn, $result);
		//echo $resultado;
		$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		//echo $row_resultado;
		//echo $row_resultado['Produtos'];
		
		$event_array[0] = array(
			'id' => $row_resultado['idTab_Produto'],
			'nome' => utf8_encode($row_resultado['Produtos']),
		);
		echo json_encode($event_array);
		
		//echo json_encode($row_resultado);
	}
	
}elseif($_GET['q'] == "Opcao_Atributo_1") {
	
	if ($_GET['id']) {
		//echo $_GET['tabela'];
		
		$result = "SELECT * FROM Tab_Opcao WHERE idTab_Opcao='". $_GET['id'] ."'";
		
		//echo $result;
		$resultado = mysqli_query($conn, $result);
		//echo $resultado;
		$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		//echo $row_resultado;
		//echo $row_resultado['Opcao'];
		
		$event_array[0] = array(
			'id' => $row_resultado['idTab_Opcao'],
			'nome' => utf8_encode($row_resultado['Opcao']),
		);
		echo json_encode($event_array);
		
		//echo json_encode($row_resultado);
	}
	
}elseif($_GET['q'] == "Opcao_Atributo_2") {
	
	if ($_GET['id']) {
		//echo $_GET['tabela'];
		
		$result = "SELECT * FROM Tab_Opcao WHERE idTab_Opcao='". $_GET['id'] ."'";
		
		//echo $result;
		$resultado = mysqli_query($conn, $result);
		//echo $resultado;
		$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		//echo $row_resultado;
		//echo $row_resultado['Opcao'];

		$event_array[0] = array(
			'id' => $row_resultado['idTab_Opcao'],
			'nome' => utf8_encode($row_resultado['Opcao']),
		);
		echo json_encode($event_array);
		
		//echo json_encode($row_resultado);
	
	}		
		
}else{
	echo false;
}

mysqli_close($conn);
