<?php
include_once '../../conexao_pdo.php';

$cliente = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$clientex = explode(' ', $cliente);

if (isset($clientex[2]) && $clientex[2] != ''){
	$cliente2 = $clientex[2];
	if (isset($cliente2)){	
		
			$query2 = '(CP.NomeClientePet like "%' . $cliente2 . '%" )';
		
	}	
	$filtro2 = ' AND ' . $query2 ;
} else {
	$filtro2 = FALSE ;
}

if (isset($clientex[1]) && $clientex[1] != ''){
	$cliente0 = $clientex[0];
	$cliente1 = $clientex[1];
	
	if (isset($cliente1)){
	
			$query1 = '(CP.NomeClientePet like "%' . $cliente1 . '%" )';
		
	}	
	$filtro1 = ' AND ' . $query1 ;
	
}else{
	$cliente0 = $cliente;
	$filtro1 = FALSE;
}


	$query0 = '(CP.NomeClientePet like "%' . $cliente0 . '%" )';


//SQL para selecionar os registros
$result_msg_cont = '
					SELECT 
						CP.idApp_ClientePet,
						CP.idSis_Empresa, 
						CP.NomeClientePet,
						C.idApp_Cliente, 
						C.NomeCliente
					FROM 
						App_ClientePet AS CP
							LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CP.idApp_Cliente
					WHERE
						CP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
						(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ')
					ORDER BY 
						CP.NomeClientePet ASC 
					LIMIT 7
				';

//Seleciona os registros
$resultado_msg_cont = $conn->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
	
    //$data[] = $row_msg_cont['NomeClientePet'];
	
	$data[$row_msg_cont['idApp_ClientePet']] = $row_msg_cont['idApp_ClientePet'] . '#' . $row_msg_cont['NomeClientePet'] . ' | ' . $row_msg_cont['NomeCliente'];
	//$data[$row_msg_cont['NomeClientePet']] = $row_msg_cont['idApp_ClientePet'];
}

echo json_encode($data);