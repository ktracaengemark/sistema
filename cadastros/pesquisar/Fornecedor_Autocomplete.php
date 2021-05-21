<?php
include_once '../../conexao_pdo.php';

$fornecedor = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$fornecedorx = explode(' ', $fornecedor);

if (isset($fornecedorx[2]) && $fornecedorx[2] != ''){
	$fornecedor2 = $fornecedorx[2];
	if (isset($fornecedor2)){	
		if(is_numeric($fornecedor2)){
			if(strlen($fornecedor2) <= 7){
				$query2 = 'idApp_Fornecedor like "' . $fornecedor1 . '"';
			}else{
				$query2 = '(CelularFornecedor like "%' . $fornecedor2 . '%" OR '
						. 'Telefone1 like "%' . $fornecedor2 . '%" OR '
						. 'Telefone2 like "%' . $fornecedor2 . '%" OR '
						. 'Telefone3 like "%' . $fornecedor2 . '%" )';
			}		
		}else{
			$query2 = '(NomeFornecedor like "%' . $fornecedor2 . '%" )';
		}
	}	
	$filtro2 = ' AND ' . $query2 ;
} else {
	$filtro2 = FALSE ;
}

if (isset($fornecedorx[1]) && $fornecedorx[1] != ''){
	$fornecedor0 = $fornecedorx[0];
	$fornecedor1 = $fornecedorx[1];
	
	if (isset($fornecedor1)){	
		if(is_numeric($fornecedor1)){
			if(strlen($fornecedor1) <= 7){
				$query1 = 'idApp_Fornecedor like "' . $fornecedor1 . '"';
			}else{
				$query1 = '(CelularFornecedor like "%' . $fornecedor1 . '%" OR '
						. 'Telefone1 like "%' . $fornecedor1 . '%" OR '
						. 'Telefone2 like "%' . $fornecedor1 . '%" OR '
						. 'Telefone3 like "%' . $fornecedor1 . '%" )';
			}		
		}else{
			$query1 = '(NomeFornecedor like "%' . $fornecedor1 . '%" )';
		}
	}	
	$filtro1 = ' AND ' . $query1 ;
	
}else{
	$fornecedor0 = $fornecedor;
	$filtro1 = FALSE;
}

if(is_numeric($fornecedor0)){
	if(strlen($fornecedor0) <= 7){
		$query0 = 'idApp_Fornecedor like "' . $fornecedor0 . '"';
	}else{
		$query0 = '(CelularFornecedor like "%' . $fornecedor0 . '%" OR '
				. 'Telefone1 like "%' . $fornecedor0 . '%" OR '
				. 'Telefone2 like "%' . $fornecedor0 . '%" OR '
				. 'Telefone3 like "%' . $fornecedor0 . '%" )';
	}		
}else{
	$query0 = '(NomeFornecedor like "%' . $fornecedor0 . '%" )';
}

//SQL para selecionar os registros
$result_msg_cont = '
					SELECT 
						idApp_Fornecedor,
						idSis_Empresa, 
						NomeFornecedor,
						CelularFornecedor
					FROM 
						App_Fornecedor 
					WHERE
						idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
						(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ')
					ORDER BY NomeFornecedor ASC 
					LIMIT 7
				';

//Seleciona os registros
$resultado_msg_cont = $conn->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
	
	$data[$row_msg_cont['idApp_Fornecedor']] = $row_msg_cont['idApp_Fornecedor'] . '#' . $row_msg_cont['NomeFornecedor'] . ' | Cel:' . $row_msg_cont['CelularFornecedor'];

}

echo json_encode($data);