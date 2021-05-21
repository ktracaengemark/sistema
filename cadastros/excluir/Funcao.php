<?php

include_once '../../conexao.php';

$Dados 	= filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 	= filter_var($Dados['id_ExcluirFuncao'], FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){

	$result_Funcao = "DELETE FROM Tab_Funcao WHERE idTab_Funcao = '$id'";
	$resultado_Funcao = mysqli_query($conn, $result_Funcao);

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