<?php

//session_start();

include_once '../conexao.php';

/*
$id = mysqli_real_escape_string($conn, $_POST['id_Categoria']);
$categoria = mysqli_real_escape_string($conn, $_POST['recipient-name']);

//echo "$id - $categoria";

$result_categoria = "UPDATE Tab_Catprod SET Catprod='$categoria' WHERE idTab_Catprod = '$id'";
$resuultado_categoria = mysqli_query($conn, $result_categoria);
*/



$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//echo "$Dados";


$id = filter_var($Dados['id_Categoria'], FILTER_SANITIZE_STRING);
$categoria = filter_var($Dados['recipient-name'], FILTER_SANITIZE_STRING);
$categoria_maiuscula = trim(mb_strtoupper($categoria, 'ISO-8859-1'));
$result_categoria = "UPDATE Tab_Catprod SET Catprod='$categoria_maiuscula' WHERE idTab_Catprod = '$id'";
$resuultado_categoria = mysqli_query($conn, $result_categoria);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $categoria);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);


//echo "$categoria";
/*
$motivo = trim(mb_strtoupper($motivo0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());

$query_usuario = "INSERT INTO Tab_Categoria (Categoria, idSis_Usuario, idSis_Empresa, idTab_Modulo, Data_Cad_Categoria) VALUES ('$motivo', '$usuario', '$empresa', '$modulo', '$datacad')";

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

*/
