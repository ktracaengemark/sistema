<?php
	
include_once '../../conexao.php';

if ($_GET['id_cons']) {

	$result_repeticaocons = "
							SELECT 
								idApp_Consulta, 
								idApp_Cliente, 
								Repeticao 
							FROM 
								App_Consulta 
							WHERE 
								Repeticao='". $_GET['id_cons'] ."'
							ORDER BY 
								idApp_Consulta
						";

	$resultado_repeticaocons = mysqli_query($conn, $result_repeticaocons);

	while ($row_repeticaocons = mysqli_fetch_assoc($resultado_repeticaocons) ) {
		$repeticaocons_post[] = array(
			'id_cons'	=> $row_repeticaocons['idApp_Consulta'],
		);
	}

	echo(json_encode($repeticaocons_post));

}else{
	echo false;
}

mysqli_close($conn);