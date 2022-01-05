<?php
	
include_once '../../conexao.php';

if ($_GET['Cupom']) {
	//echo $_GET['Cupom'];
	$cupom = addslashes($_GET['Cupom']);
	$result = 'SELECT 
					ValorDesconto,
					ValorMinimo,
					DataCampanha,
					DataCampanhaLimite,
					TipoCampanha,
					TipoDescCampanha,
					Campanha,
					DescCampanha
				FROM 
					App_Campanha 
				WHERE
					idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
					idApp_Campanha = "' . $cupom . '" AND
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
			'campanha' => utf8_encode ($row['Campanha']),
			'desccampanha' => utf8_encode ($row['DescCampanha']),
			//'nome' => utf8_encode($row['NomeCliente']),
		);	
	}

	echo json_encode($event_array);
}else{
	echo false;
}
mysqli_close($conn);
