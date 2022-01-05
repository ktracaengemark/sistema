<?php
	
include_once '../../conexao.php';

if ($_GET['Cupom']) {
	//echo $_GET['Cupom'];

	$result = 'SELECT 
					ValorDesconto,
					ValorMinimo,
					DataCampanha,
					DataCampanhaLimite,
					TipoCampanha,
					TipoDescCampanha
				FROM 
					App_Campanha 
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Campanha = "' . $_GET['Cupom'] . '" AND
					TipoCampanha = 2
				LIMIT 1
			';

	$resultado = mysqli_query($conn, $result);
	
	while ($row = mysqli_fetch_assoc($resultado) ) {
		$event_array[0] = array(
			'tipo' => $row['TipoCampanha'],
			'tipodesc' => $row['TipoDescCampanha'],
			'valorcupom' => $row['ValorDesconto'],
			'valorminimo' => $row['ValorMinimo'],
			'datacampanha' => $row['DataCampanha'],
			'datacampanhalimite' => $row['DataCampanhaLimite'],
			//'nome' => utf8_encode($row['NomeCliente']),
		);	
	}

	echo json_encode($event_array);
}else{
	echo false;
}
mysqli_close($conn);
