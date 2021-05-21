<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];

	$result = 'SELECT 
					CashBackCliente 
				FROM 
					App_Cliente 
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Cliente = "' . $_GET['id'] . '" 
				LIMIT 1
			';

	$resultado = mysqli_query($conn, $result);
	
	while ($row = mysqli_fetch_assoc($resultado) ) {
		$cashtotal = $row['CashBackCliente'];
	}

	echo(json_encode($cashtotal));
}else{
	echo false;
}
mysqli_close($conn);
