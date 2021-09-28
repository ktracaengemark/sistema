<?php
include_once '../../conexao_pdo.php';

$cliente = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$clientex = explode(' ', $cliente);

if (isset($clientex[2]) && $clientex[2] != ''){
	$cliente2 = $clientex[2];
	if (isset($cliente2)){	
		if(is_numeric($cliente2)){
			if((strlen($cliente2)) < 6){
				$query2 = 'RegistroFicha like "' . $cliente2 . '"';
			}elseif(strlen($cliente2) >= 6 && strlen($cliente2) <= 7){
				$query2 = 'idApp_Cliente like "' . $cliente1 . '"';
			}else{
				$query2 = '(CelularCliente like "%' . $cliente2 . '%" OR '
						. 'Telefone like "%' . $cliente2 . '%" OR '
						. 'Telefone2 like "%' . $cliente2 . '%" OR '
						. 'Telefone3 like "%' . $cliente2 . '%" )';
			}		
		}else{
			$query2 = '(NomeCliente like "%' . $cliente2 . '%" )';
		}
	}	
	$filtro2 = ' AND ' . $query2 ;
} else {
	$filtro2 = FALSE ;
}

if (isset($clientex[1]) && $clientex[1] != ''){
	$cliente0 = $clientex[0];
	$cliente1 = $clientex[1];
	
	if (isset($cliente1)){	
		if(is_numeric($cliente1)){
			if((strlen($cliente1)) < 6){
				$query1 = 'RegistroFicha like "' . $cliente1 . '"';
			}elseif(strlen($cliente1) >= 6 && strlen($cliente1) <= 7){
				$query1 = 'idApp_Cliente like "' . $cliente1 . '"';
			}else{
				$query1 = '(CelularCliente like "%' . $cliente1 . '%" OR '
						. 'Telefone like "%' . $cliente1 . '%" OR '
						. 'Telefone2 like "%' . $cliente1 . '%" OR '
						. 'Telefone3 like "%' . $cliente1 . '%" )';
						}		
		}else{
			$query1 = '(NomeCliente like "%' . $cliente1 . '%" )';
		}
	}	
	$filtro1 = ' AND ' . $query1 ;
	
}else{
	$cliente0 = $cliente;
	$filtro1 = FALSE;
}

if(is_numeric($cliente0)){
	if((strlen($cliente0)) < 6){
		$query0 = 'RegistroFicha like "' . $cliente0 . '"';
	}elseif(strlen($cliente0) >= 6 && strlen($cliente0) <= 7){
		$query0 = 'idApp_Cliente like "' . $cliente0 . '"';
	}else{
		$query0 = '(CelularCliente like "%' . $cliente0 . '%" OR '
				. 'Telefone like "%' . $cliente0 . '%" OR '
				. 'Telefone2 like "%' . $cliente0 . '%" OR '
				. 'Telefone3 like "%' . $cliente0 . '%" )';
	}		
}else{
	$query0 = '(NomeCliente like "%' . $cliente0 . '%" )';
}

//SQL para selecionar os registros
$result_msg_cont = '
					SELECT 
						idApp_Cliente,
						idSis_Empresa, 
						NomeCliente,
						RegistroFicha,
						CelularCliente,
						Telefone,
						Telefone2,
						Telefone3
					FROM 
						App_Cliente 
					WHERE
						idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
						(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ')
					ORDER BY NomeCliente ASC 
					LIMIT 7
				';

//Seleciona os registros
$resultado_msg_cont = $conn->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
	
    //$data[] = $row_msg_cont['NomeCliente'];
	
	$data[$row_msg_cont['idApp_Cliente']] = $row_msg_cont['idApp_Cliente'] . '#' . $row_msg_cont['NomeCliente'] . ' | Fch:' . $row_msg_cont['RegistroFicha']
											. ' | Cel:' . $row_msg_cont['CelularCliente'] . ' | Tel1:' . $row_msg_cont['Telefone']
											. ' | Tel2:' . $row_msg_cont['Telefone2'] . ' | Tel3:' . $row_msg_cont['Telefone3'];
	//$data[$row_msg_cont['NomeCliente']] = $row_msg_cont['idApp_Cliente'];
}

echo json_encode($data);