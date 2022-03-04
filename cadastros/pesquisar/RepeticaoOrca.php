<?php
	
include_once '../../conexao.php';

if ($_GET['id_orca']) {

	$result_repeticaoorca = "
							SELECT 
								idApp_OrcaTrata, 
								idApp_Cliente, 
								RepeticaoCons 
							FROM 
								App_OrcaTrata
							WHERE 
								RepeticaoCons='". $_GET['id_orca'] ."'
							ORDER BY 
								idApp_OrcaTrata
						";

	$resultado_repeticaoorca = mysqli_query($conn, $result_repeticaoorca);

	while ($row_repeticaoorca = mysqli_fetch_assoc($resultado_repeticaoorca) ) {
		$repeticaoorca_post[] = array(
			'id_orca'	=> $row_repeticaoorca['idApp_OrcaTrata'],
		);
	}

	echo(json_encode($repeticaoorca_post));

}else{
	echo false;
}

mysqli_close($conn);