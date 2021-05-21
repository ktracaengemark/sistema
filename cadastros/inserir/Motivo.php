<?php

//session_start();

include_once '../../conexao.php';
/*
$servidor = $_SESSION['db']['hostname'];
$usuario = $_SESSION['db']['username'];
$senha = $_SESSION['db']['password'];
$dbname = $_SESSION['db']['database'];

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
*/


$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//$motivo0 = filter_input(INPUT_POST, 'Novo_Motivo', FILTER_SANITIZE_STRING);
//$descricao0 = filter_input(INPUT_POST, 'Desc_Motivo', FILTER_SANITIZE_STRING);

$motivo0 = filter_var($Dados['Novo_Motivo'], FILTER_SANITIZE_STRING);
$descricao0 = filter_var($Dados['Desc_Motivo'], FILTER_SANITIZE_STRING);

//$motivo0 = filter_input(INPUT_POST, 'Novo_Motivo', FILTER_SANITIZE_STRING);
//$descricao0 = filter_input(INPUT_POST, 'Desc_Motivo', FILTER_SANITIZE_STRING);

$motivo = trim(mb_strtoupper($motivo0, 'ISO-8859-1'));
$descricao = trim(mb_strtoupper($descricao0, 'ISO-8859-1'));

//$motivo = trim(mb_strtoupper($Dados['Novo_Motivo'], 'ISO-8859-1'));
//$descricao = trim(mb_strtoupper($Dados['Desc_Motivo'], 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$query_usuario = "INSERT INTO Tab_Motivo (Motivo, Desc_Motivo, idSis_Usuario, idSis_Empresa, idTab_Modulo, Data_Cad_Motivo) VALUES ('$motivo', '$descricao', '$usuario', '$empresa', '$modulo', '$datacad')";
mysqli_query($conn, $query_usuario);

if(mysqli_insert_id($conn)){
	echo true;
}else{
	echo false;
}
unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
