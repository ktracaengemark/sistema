<?php
	
session_start();
/*
$servidor = $_SESSION['db']['hostname'];
$usuario = $_SESSION['db']['username'];
$senha = $_SESSION['db']['password'];
$dbname = $_SESSION['db']['database'];

//Criar a conexao
//$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn = new PDO('mysql:host=' . $servidor . ';dbname=' . $dbname . ';', $usuario, $senha);
*/
/*
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'celke');
*/

define('HOST', $_SESSION['db']['hostname']);
define('USER', $_SESSION['db']['username']);
define('PASS', $_SESSION['db']['password']);
define('DBNAME', $_SESSION['db']['database']);

$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);



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
