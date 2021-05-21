<?php
	
include_once '../../conexao.php';

$id_categoria = $_REQUEST['idApp_Cliente'];

$result_sub_cat = "SELECT * FROM App_OrcaTrata WHERE idApp_Cliente=$id_categoria AND ConcluidoOrca='N' AND CanceladoOrca='N' ORDER BY idApp_OrcaTrata";

$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);

while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	$sub_categorias_post[] = array(
		'id_OrcaTrata'	=> $row_sub_cat['idApp_OrcaTrata'],
		'descricao_OrcaTrata' => utf8_encode($row_sub_cat['Descricao']),
	);
}

echo(json_encode($sub_categorias_post));

mysqli_close($conn);
