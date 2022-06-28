<?php
	
session_start();
if(!isset($_SESSION['db'])){
	echo 'Não foi possível conectar';
}else{
	$servidor = $_SESSION['db']['hostname'];
	$usuario = $_SESSION['db']['username'];
	$senha = $_SESSION['db']['password'];
	$dbname = $_SESSION['db']['database'];

	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	if (!$conn) {
		echo 'Não foi possível conectar';
	}	
}	

