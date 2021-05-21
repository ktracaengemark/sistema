<?php

include_once '../../conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$cliente = filter_var($dados['id_Cliente'], FILTER_SANITIZE_STRING);
$clientepet0 = filter_var($dados['NomeClientePet'], FILTER_SANITIZE_STRING);
$sexo0 = filter_var($dados['SexoPet'], FILTER_SANITIZE_STRING);
$especiepet0 = filter_var($dados['EspeciePet'], FILTER_SANITIZE_STRING);
$racapet0 = filter_var($dados['RacaPet'], FILTER_SANITIZE_STRING);
$pelopet0 = filter_var($dados['PeloPet'], FILTER_SANITIZE_STRING);
$corpet0 = filter_var($dados['CorPet'], FILTER_SANITIZE_STRING);
$portepet0 = filter_var($dados['PortePet'], FILTER_SANITIZE_STRING);
$obspet0 = filter_var($dados['ObsPet'], FILTER_SANITIZE_STRING);

$alergicopet0 = filter_var($dados['AlergicoPet'], FILTER_SANITIZE_STRING);
$pesopet0 = filter_var($dados['PesoPet'], FILTER_SANITIZE_STRING);

$pesopet1 = str_replace(',', '.', str_replace('.', '', $pesopet0));	

$datanascimento = $dados['DataNascimentoPet'];
        
if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $datanascimento)) {
	
	if ($datanascimento) {
		$datanascimento = DateTime::createFromFormat('d/m/Y', $datanascimento);
		$datanascimento = $datanascimento->format('Y-m-d');
	} else {
		$datanascimento = NULL;
	}
}

$caracteres_sem_acento = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    'a'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
);

$clientepet1 = preg_replace("/[^a-zA-Z]/", " ", strtr($clientepet0, $caracteres_sem_acento));
$clientepet = trim(mb_strtoupper($clientepet1, 'ISO-8859-1'));
$sexo = trim(mb_strtoupper($sexo0, 'ISO-8859-1'));
$especiepet = trim(mb_strtoupper($especiepet0, 'ISO-8859-1'));
$racapet = trim(mb_strtoupper($racapet0, 'ISO-8859-1'));
$pelopet = trim(mb_strtoupper($pelopet0, 'ISO-8859-1'));
$corpet = trim(mb_strtoupper($corpet0, 'ISO-8859-1'));
$portepet = trim(mb_strtoupper($portepet0, 'ISO-8859-1'));
$obspet = trim(mb_strtoupper($obspet0, 'ISO-8859-1'));

$alergicopet = trim(mb_strtoupper($alergicopet0, 'ISO-8859-1'));
$pesopet = trim(mb_strtoupper($pesopet1, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$DataCadastroFornecedor = date('Y-m-d', time());

$result_clientepet = "INSERT INTO App_ClientePet (
													idSis_Empresa, 
													idTab_Modulo, 
													idSis_Usuario,
													idApp_Cliente, 
													NomeClientePet,
													DataNascimentoPet,
													SexoPet,
													EspeciePet,
													RacaPet,
													PeloPet,
													CorPet,
													PortePet,
													ObsPet,
													AlergicoPet,
													PesoPet
												) 
												VALUES (
													'" .$empresa. "',
													'1',
													'" .$usuario. "',
													'" .$cliente. "',
													'" .$clientepet. "',
													'" .$datanascimento. "',
													'" .$sexo. "',
													'" .$especiepet. "',
													'" .$racapet. "',
													'" .$pelopet. "',
													'" .$corpet. "',
													'" .$portepet. "',
													'" .$obspet. "',
													'" .$alergicopet. "',
													'" .$pesopet. "'
												)";
$resultado_clientepet = mysqli_query($conn, $result_clientepet);
$id_clientepet = mysqli_insert_id($conn);

if($id_clientepet){
	echo true;
}else{
	echo false;
}

unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
