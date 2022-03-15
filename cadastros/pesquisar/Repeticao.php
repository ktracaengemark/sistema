<?php
	
include_once '../../conexao.php';

$id_cliente = $_REQUEST['idApp_Cliente'];

$result_sub_cat = "
					SELECT 
						idApp_Consulta, 
						idApp_Cliente, 
						Repeticao,
						DataTermino						
					FROM 
						App_Consulta 
					WHERE 
						idApp_Cliente=$id_cliente 
					GROUP BY 
						Repeticao 
					ORDER BY 
						idApp_Consulta";

$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);

while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
		
	$dataini = explode(' ', $row_sub_cat['DataTermino']);
	//$dataTer = $dataini[0];
	$dataTer = new DateTime($dataini[0]);
	$dataTer = $dataTer->format('d/m/Y');
	
	$sub_categorias_post[] = array(
		'id_Repeticao'	=> $row_sub_cat['Repeticao'],
		'dt_Term'		=> $dataTer,
	);
}

echo(json_encode($sub_categorias_post));

mysqli_close($conn);
