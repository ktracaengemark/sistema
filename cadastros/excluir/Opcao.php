<?php

include_once '../../conexao.php';

$Dados 	= filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 	= filter_var($Dados['id_ExcluirOpcao'], FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){

	$result_opcao = "DELETE FROM Tab_Opcao WHERE idTab_Opcao = '$id'";
	$resultado_opcao = mysqli_query($conn, $result_opcao);

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