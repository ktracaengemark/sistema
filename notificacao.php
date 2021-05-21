<?php
//session_start();
//require 'php/conn.php';
//include './configuracao.php';
//include './conexao.php';

//$id_pedido = addslashes($_GET['id']);

$notificationCode = preg_replace('/[^[:alnum:]-]/','',$_POST["notificationCode"]);

$data['token'] = 'A058483B1624431FB344C5FB79A44A4E';
$data['email'] = 'marciorodeng@gmail.com';

$data = http_build_query($data);

$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?'.$data;
//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$_POST["notificationCode"]}?email=marciorodeng@gmail.com&token=A058483B1624431FB344C5FB79A44A4E';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

$Retorno = curl_exec($curl);

curl_close($curl);

$xml = simplexml_load_string($Retorno);

echo $xml->status;
/*
$reference 	= $xml -> reference;
$status		= $xml -> status;

if($reference && $status){
	include_once 'conecta.php';
	$conn = new conecta();
	
	$rs_pedido = $conn->consultarPedido($reference);
	
	if($rs_pedido){
		$conn->atualizaPedido($reference,$status);
	}
}
*/
?>