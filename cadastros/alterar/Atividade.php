<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Atividade'], FILTER_SANITIZE_STRING);
$atividade = filter_var($Dados['AtividadeAlterar'], FILTER_SANITIZE_STRING);

$atividade_maiuscula = trim(mb_strtoupper($atividade, 'ISO-8859-1'));

$result_atividade = "UPDATE App_Atividade SET Atividade='$atividade_maiuscula' WHERE idApp_Atividade = '$id'";
$resultado_atividade = mysqli_query($conn, $result_atividade);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $atividade);
mysqli_close($conn);