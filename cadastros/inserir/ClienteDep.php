<?php

include_once '../../conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$cliente = filter_var($dados['id_Cliente'], FILTER_SANITIZE_STRING);
$clientedep0 = filter_var($dados['NomeClienteDep'], FILTER_SANITIZE_STRING);
$sexo0 = filter_var($dados['SexoDep'], FILTER_SANITIZE_STRING);
$relacao0 = filter_var($dados['RelacaoDep'], FILTER_SANITIZE_STRING);
$obsdep0 = filter_var($dados['ObsDep'], FILTER_SANITIZE_STRING);
/*
$datanascimento = $dados['DataNascimentoDep'];
        
if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $datanascimento)) {
	
	if ($datanascimento) {
		$datanascimento = DateTime::createFromFormat('d/m/Y', $datanascimento);
		$datanascimento = $datanascimento->format('Y-m-d');
	} else {
		$datanascimento = NULL;
	}
}
*/

if(empty($dados['DataNascimentoDep'])){
	$datanascimento = "0000-00-00";
}else{
	$datanascimento = $dados['DataNascimentoDep'];
	
	if ($datanascimento) {
		
		if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $datanascimento) && checkdate(substr($datanascimento, 3, 2), substr($datanascimento, 0, 2), substr($datanascimento, 6, 4))){
			
			if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $datanascimento)) {
				
				if ($datanascimento) {
					$datanascimento = DateTime::createFromFormat('d/m/Y', $datanascimento);
					$datanascimento = $datanascimento->format('Y-m-d');
				}else{
					//$datanascimento = NULL;
					$datanascimento = "0000-00-00";
				}
			}					
		}else{
			$ddatanascimentoata = "0000-00-00";
		}
	}else{
		$datanascimento = "0000-00-00";
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

$clientedep1 = preg_replace("/[^a-zA-Z]/", " ", strtr($clientedep0, $caracteres_sem_acento));
$clientedep = trim(mb_strtoupper($clientedep1, 'ISO-8859-1'));
$sexo = trim(mb_strtoupper($sexo0, 'ISO-8859-1'));
$obsdep = trim(mb_strtoupper($obsdep0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$DataCadastroFornecedor = date('Y-m-d', time());

$result_clientedep = "INSERT INTO App_ClienteDep (
													idSis_Empresa, 
													idTab_Modulo, 
													idSis_Usuario,
													idApp_Cliente, 
													NomeClienteDep,
													DataNascimentoDep,
													SexoDep,
													RelacaoDep,
													ObsDep
												) 
												VALUES (
													'" .$empresa. "',
													'1',
													'" .$usuario. "',
													'" .$cliente. "',
													'" .$clientedep. "',
													'" .$datanascimento. "',
													'" .$sexo. "',
													'" .$relacao0. "',
													'" .$obsdep. "'
												)";
$resultado_clientedep = mysqli_query($conn, $result_clientedep);
$id_clientedep = mysqli_insert_id($conn);

if($id_clientedep){
	echo true;
}else{
	echo false;
}

unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
