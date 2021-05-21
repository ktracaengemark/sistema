<?php

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id 		= filter_var($Dados['id_Categoria'], FILTER_SANITIZE_STRING);
$categoria 	= filter_var($Dados['Catprod'], FILTER_SANITIZE_STRING);
$sitecat 	= filter_var($Dados['Site_Catprod_Alterar'], FILTER_SANITIZE_STRING);
$balcaocat 	= filter_var($Dados['Balcao_Catprod_Alterar'], FILTER_SANITIZE_STRING);

$caracteres_sem_acento = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    'a'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
);

$categoria1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($categoria, $caracteres_sem_acento));
$categoria_maiuscula 	= trim(mb_strtoupper($categoria1, 'ISO-8859-1'));
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