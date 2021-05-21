<?php
	
include_once '../../conexao.php';

$id_categoria = $_REQUEST['idApp_Cliente'];

$result_sub_cat = "SELECT * FROM App_ClienteDep WHERE idApp_Cliente=$id_categoria ORDER BY NomeClienteDep";

$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);

while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	$sub_categorias_post[] = array(
		'id_ClienteDep'	=> $row_sub_cat['idApp_ClienteDep'],
		'nome_ClienteDep' => utf8_encode($row_sub_cat['NomeClienteDep']),
	);
}

echo(json_encode($sub_categorias_post));

mysqli_close($conn);
