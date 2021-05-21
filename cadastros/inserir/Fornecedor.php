<?php

include_once '../../conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$fornecedor0 = filter_var($dados['NomeFornecedor'], FILTER_SANITIZE_STRING);
$sexo0 = filter_var($dados['Sexo'], FILTER_SANITIZE_STRING);
$cep0 = filter_var($dados['CepFornecedor'], FILTER_SANITIZE_STRING);
$endereco0 = filter_var($dados['EnderecoFornecedor'], FILTER_SANITIZE_STRING);
$numero0 = filter_var($dados['NumeroFornecedor'], FILTER_SANITIZE_STRING);
$complemento0 = filter_var($dados['ComplementoFornecedor'], FILTER_SANITIZE_STRING);
$bairro0 = filter_var($dados['BairroFornecedor'], FILTER_SANITIZE_STRING);
$cidade0 = filter_var($dados['CidadeFornecedor'], FILTER_SANITIZE_STRING);
$estado0 = filter_var($dados['EstadoFornecedor'], FILTER_SANITIZE_STRING);
$referencia0 = filter_var($dados['ReferenciaFornecedor'], FILTER_SANITIZE_STRING);

$data = $dados['DataNascimento'];
        
if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
	
	if ($data) {
		$data = DateTime::createFromFormat('d/m/Y', $data);
		$data = $data->format('Y-m-d');
	} else {
		$data = NULL;
	}
}

//$celular = filter_var($dados['CelularFornecedor'], FILTER_VALIDATE_INT);

$celular = $dados['CelularFornecedor'];

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

$fornecedor1 = preg_replace("/[^a-zA-Z]/", " ", strtr($fornecedor0, $caracteres_sem_acento));
$fornecedor = trim(mb_strtoupper($fornecedor1, 'ISO-8859-1'));
$sexo = trim(mb_strtoupper($sexo0, 'ISO-8859-1'));
$cep = trim(mb_strtoupper($cep0, 'ISO-8859-1'));
$endereco = trim(mb_strtoupper($endereco0, 'ISO-8859-1'));
$numero = trim(mb_strtoupper($numero0, 'ISO-8859-1'));
$complemento = trim(mb_strtoupper($complemento0, 'ISO-8859-1'));
$bairro = trim(mb_strtoupper($bairro0, 'ISO-8859-1'));
$cidade = trim(mb_strtoupper($cidade0, 'ISO-8859-1'));
$estado = trim(mb_strtoupper($estado0, 'ISO-8859-1'));
$referencia = trim(mb_strtoupper($referencia0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$DataCadastroFornecedor = date('Y-m-d', time());

$result_fornecedor = "INSERT INTO App_Fornecedor (idSis_Empresa, 
											idTab_Modulo, 
											idSis_Usuario, 
											NomeFornecedor, 
											CelularFornecedor,
											DataNascimento,
											Sexo,
											CepFornecedor,
											EnderecoFornecedor,
											NumeroFornecedor,
											ComplementoFornecedor,
											BairroFornecedor,
											CidadeFornecedor,
											EstadoFornecedor,
											ReferenciaFornecedor,
											DataCadastroFornecedor) 
											VALUES (
											'" .$empresa. "',
											'1',
											'" .$usuario. "',
											'" .$fornecedor. "',
											'" .$celular. "',
											'" .$data. "',
											'" .$sexo. "',
											'" .$cep. "',
											'" .$endereco. "',
											'" .$numero. "',
											'" .$complemento. "',
											'" .$bairro. "',
											'" .$cidade. "',
											'" .$estado. "',
											'" .$referencia. "',
											'" .$DataCadastroFornecedor. "'
											)";
$resultado_fornecedor = mysqli_query($conn, $result_fornecedor);
$id_fornecedor = mysqli_insert_id($conn);

if($id_fornecedor){
	echo true;
}else{
	echo false;
}


unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
