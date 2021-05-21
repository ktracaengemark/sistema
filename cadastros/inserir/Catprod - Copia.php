<?php

//session_start();

include_once '../../conexao.php';

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$catprod0 = filter_var($Dados['Novo_Catprod'], FILTER_SANITIZE_STRING);
$tipocategoria0 = filter_var($Dados['TipoCatprod'], FILTER_SANITIZE_STRING);
$site_cat0 = filter_var($Dados['Site_Catprod_Cadastrar'], FILTER_SANITIZE_STRING);
$balcao_cat0 = filter_var($Dados['Balcao_Catprod_Cadastrar'], FILTER_SANITIZE_STRING);

$catprod = trim(mb_strtoupper($catprod0, 'ISO-8859-1'));
$tipocategoria = trim(mb_strtoupper($tipocategoria0, 'ISO-8859-1'));
$site_cat = trim(mb_strtoupper($site_cat0, 'ISO-8859-1'));
$balcao_cat = trim(mb_strtoupper($balcao_cat0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());
$query_usuario = "INSERT INTO Tab_Catprod (Catprod, TipoCatprod, Site_Catprod, Balcao_Catprod,  idSis_Usuario, idSis_Empresa, idTab_Modulo) VALUES ('$catprod', '$tipocategoria', '$site_cat', '$balcao_cat', '$usuario', '$empresa', '$modulo')";
mysqli_query($conn, $query_usuario);

if(mysqli_insert_id($conn)){
	echo true;
}else{
	echo false;
}
unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
