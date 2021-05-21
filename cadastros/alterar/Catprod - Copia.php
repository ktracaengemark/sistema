<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 		= filter_var($Dados['id_Categoria'], FILTER_SANITIZE_STRING);
$categoria 	= filter_var($Dados['Catprod'], FILTER_SANITIZE_STRING);
$sitecat 	= filter_var($Dados['Site_Catprod_Alterar'], FILTER_SANITIZE_STRING);
$balcaocat 	= filter_var($Dados['Balcao_Catprod_Alterar'], FILTER_SANITIZE_STRING);

$categoria_maiuscula 	= trim(mb_strtoupper($categoria, 'ISO-8859-1'));
$sitecat_maiuscula 		= trim(mb_strtoupper($sitecat, 'ISO-8859-1'));
$balcaocat_maiuscula 	= trim(mb_strtoupper($balcaocat, 'ISO-8859-1'));

$result_categoria = "UPDATE Tab_Catprod SET Catprod='$categoria_maiuscula', Site_Catprod='$sitecat_maiuscula', Balcao_Catprod='$balcaocat_maiuscula' WHERE idTab_Catprod = '$id'";
$resultado_categoria = mysqli_query($conn, $result_categoria);

if(mysqli_affected_rows($conn) != 0){
	echo true;
}else{
	echo false;
}
unset($id, $categoria);
mysqli_close($conn);