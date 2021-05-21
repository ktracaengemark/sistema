<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = filter_var($Dados['id_Motivo'], FILTER_SANITIZE_STRING);
$motivo = filter_var($Dados['MotivoAlterar'], FILTER_SANITIZE_STRING);
$descmotivo = filter_var($Dados['DescMotivoAlterar'], FILTER_SANITIZE_STRING);

$motivo_maiuscula = trim(mb_strtoupper($motivo, 'ISO-8859-1'));
$descmotivo_maiuscula = trim(mb_strtoupper($descmotivo, 'ISO-8859-1'));

$result_motivo = "UPDATE Tab_Motivo SET Motivo='$motivo_maiuscula', Desc_Motivo='$descmotivo_maiuscula'  WHERE idTab_Motivo = '$id'";
$resultado_motivo = mysqli_query($conn, $result_motivo);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $motivo);
mysqli_close($conn);