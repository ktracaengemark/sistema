<?php
	
include_once '../../conexao.php';

$id_categoria = $_REQUEST['idApp_Cliente'];

$result_sub_cat = "SELECT * FROM App_ClientePet WHERE idApp_Cliente=$id_categoria ORDER BY NomeClientePet";

$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);

while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	$sub_categorias_post[] = array(
		'id_ClientePet'	=> $row_sub_cat['idApp_ClientePet'],
		'nome_ClientePet' => utf8_encode($row_sub_cat['NomeClientePet']),
	);
}

echo(json_encode($sub_categorias_post));



/*	
if ($_GET['id']) {
	//echo $_GET['id'];

	$result = "SELECT * FROM App_ClientePet WHERE idApp_Cliente='". $_GET['id'] ."'";
	//echo $result;
	
	$resultado = mysqli_query($conn, $result);
	
	$row_resultado = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$event_array[0] = array(
		'id' => $row_resultado['idApp_ClientePet'],
		'nome' => utf8_encode($row_resultado['NomeClientePet']),
	);
	//echo json_encode($event_array);
	
	echo json_encode($row_resultado);
	
	
	while ($row_sub_cat = mysqli_fetch_assoc($resultado) ) {
		$sub_categorias_post[] = array(
			'id'	=> $row_sub_cat['idApp_ClientePet'],
			'nome_sub_categoria' => utf8_encode($row_sub_cat['NomeClientePet']),
		);
	
	}
	
	//echo json_encode($sub_categorias_post);
	echo json_encode($row_sub_cat);
}else{
	echo false;
}
*/

mysqli_close($conn);
