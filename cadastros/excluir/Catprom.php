<?php

include_once '../../conexao.php';

$Dados 	= filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 	= filter_var($Dados['id_ExcluirCategoria'], FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){	

	$result_categoria = "DELETE FROM Tab_Catprom WHERE idTab_Catprom = '$id'";
	$resultado_categoria = mysqli_query($conn, $result_categoria);

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