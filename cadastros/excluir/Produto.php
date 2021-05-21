<?php

include_once '../../conexao.php';

$Dados 	= filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 	= filter_var($Dados['id_ExcluirProduto'], FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){	

	$result_produto = "DELETE FROM Tab_Produto WHERE idTab_Produto = '$id'";
	$resultado_produto = mysqli_query($conn, $result_produto);

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