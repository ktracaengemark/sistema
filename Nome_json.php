<?php

session_start();
	//$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
//$link = mysqli_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
//if (!$link) {
    //die('Não foi possível conectar: ' . mysql_error());
//}

//$db = mysql_select_db($_SESSION['db']['database'], $link);
$db = mysqli_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password'],$_SESSION['db']['database']);
//if (!$db) {
    //die('Não foi possível selecionar banco de dados: ' . mysql_error());
//}

#echo 'Conexão bem sucedida';
$result = mysqli_query($db,
        'SELECT
            *
        FROM 
            Tab_' . $_GET['tabela'] . ' AS T
        WHERE
            T.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
			T.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . 'AND
			T.idTab_' . $_GET['tabela'] . ' = ' . $_GET['id_prod'] . '
');

echo $_GET['tabela'];
echo ' - ';
echo $_GET['id_prod'];
exit();

if ($_GET['tabela']) {
	
	if(mysqli_num_rows($result) > '0'){
		foreach($result as $read_produto_view){
			$id_produto 	= $read_produto_view['idTab_' . $_GET['tabela'] . '']; 
			$nome		 	= $read_produto_view[$_GET['tabela']];

		}
	}	
	
}

//echo json_encode($event_array);
//mysql_close($link);
?>
