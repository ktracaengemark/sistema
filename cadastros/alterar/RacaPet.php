<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_RacaPet'], FILTER_SANITIZE_STRING);
$RacaPet = filter_var($Dados['Nome_RacaPet'], FILTER_SANITIZE_STRING);

$RacaPet_maiuscula = trim(mb_strtoupper($RacaPet, 'ISO-8859-1'));

$result_RacaPet = "UPDATE Tab_RacaPet SET RacaPet='$RacaPet_maiuscula' WHERE idTab_RacaPet = '$id'";
$resultado_RacaPet = mysqli_query($conn, $result_RacaPet);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $RacaPet);
mysqli_close($conn);