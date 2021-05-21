<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];

	$result = 'SELECT 
					PD.idApp_Produto,
					PD.idSis_Empresa,
					PD.idApp_Cliente,
					PD.ValorComissaoCashBack,
					PD.StatusComissaoCashBack,
					PD.DataPagoCashBack,
					PD.id_Orca_CashBack
				FROM
					App_Produto AS PD
						LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PD.idApp_OrcaTrata
				WHERE
					PD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					PD.StatusComissaoCashBack = "N" AND
					PD.id_Orca_CashBack = 0 AND
					PD.ValorComissaoCashBack > 0.00 AND
					OT.QuitadoOrca = "S" AND
					OT.CanceladoOrca = "N" AND
					PD.idApp_Cliente = "' . $_GET['id'] . '" 
			';

	$resultado = mysqli_query($conn, $result);
	$cashtotal = 0;
	while ($row = mysqli_fetch_assoc($resultado) ) {
		$cashtotal += $row['ValorComissaoCashBack'];
		
		$agendados[] = array(
			
			'id' 		=> $row['idApp_Produto'],
			'valorcash_id' 		=> $row['ValorComissaoCashBack'],
			'cashtotal' => $cashtotal,
			
		);
		
	}

	//echo(json_encode($agendados));
	echo(json_encode($cashtotal));
}else{
	echo false;
}
mysqli_close($conn);
