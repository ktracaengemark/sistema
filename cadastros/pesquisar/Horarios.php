<?php
	
include_once '../../conexao.php';

if ($_GET['id']) {
	//echo $_GET['id'];

	$result = 'SELECT *
						FROM
							App_Consulta
						WHERE
							idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
							DataInicio = "' . $_GET['id'] . '"
					';

	$resultado = mysqli_query($conn, $result);

	while ($row = mysqli_fetch_assoc($resultado) ) {
		$agendados[] = array(
			
			'id' 		=> $row['idApp_Consulta'],
			'dataehora' => $row['DataInicio'],
			
		);
	}

	echo(json_encode($agendados));
}else{
	echo false;
}
mysqli_close($conn);
