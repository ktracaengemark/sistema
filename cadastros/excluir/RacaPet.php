<?php

include_once '../../conexao.php';

$Dados 	= filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 	= filter_var($Dados['id_ExcluirRacaPet'], FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){

	$result_RacaPet = "DELETE FROM Tab_RacaPet WHERE idTab_RacaPet = '$id'";
	$resultado_RacaPet = mysqli_query($conn, $result_RacaPet);

	if(mysqli_affected_rows($conn)){
		echo true;
	}else{
		echo false;
	}
}else{
	echo false;
}	
unset($id, $Dados);
mysqli_close($conn);