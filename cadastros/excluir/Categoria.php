<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Categoria'], FILTER_SANITIZE_STRING);
$categoria = filter_var($Dados['CategoriaAlterar'], FILTER_SANITIZE_STRING);

$categoria_maiuscula = trim(mb_strtoupper($categoria, 'ISO-8859-1'));

$result_categoria = "UPDATE Tab_Categoria SET Categoria='$categoria_maiuscula' WHERE idTab_Categoria = '$id'";
$resultado_categoria = mysqli_query($conn, $result_categoria);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $categoria);
mysqli_close($conn);