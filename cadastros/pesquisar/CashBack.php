<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];

	$result = 'SELECT 
					CashBackCliente,
					ValidadeCashBack
				FROM 
					App_Cliente 
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = "' . $_GET['id'] . '" 
				LIMIT 1
			';

	$resultado = mysqli_query($conn, $result);
	
	while ($row = mysqli_fetch_assoc($resultado) ) {
		/*
		$cashtotal = $row['CashBackCliente'];
		$validade = $row['ValidadeCashBack'];
		*/
		$event_array[0] = array(
			'cashtotal' => $row['CashBackCliente'],
			'validade' => $row['ValidadeCashBack'],
			//'nome' => utf8_encode($row['NomeCliente']),
		);		
		
	}

	//echo(json_encode($cashtotal));
	echo json_encode($event_array);
}else{
	echo false;
}
mysqli_close($conn);
