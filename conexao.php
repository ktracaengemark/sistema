<?php
	
session_start();

$servidor = $_SESSION['db']['hostname'];
$usuario = $_SESSION['db']['username'];
$senha = $_SESSION['db']['password'];
$dbname = $_SESSION['db']['database'];

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
/*
$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}
*/
#echo 'Conexão bem sucedida';	
	

//$servidor = "localhost";
//$usuario = "root";
//$senha = "";
//$dbname = "celke";

////Criar a conexao
//$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
