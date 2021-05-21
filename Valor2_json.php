<?php

session_start();

$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}

#echo 'Conexão bem sucedida';
$result = mysql_query(
        'SELECT
			T.idTab_Produtos,
			T.Nome_Prod,
			T.Cod_Prod,
			T.Comissao,
			T.Valor_Produto,
			T.Prod_Serv,
			CONCAT(IFNULL(T.Nome_Prod,"")) AS NomeProduto
        FROM
            Tab_' . $_GET['tabela'] . ' AS T			
        WHERE
			T.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
');

if ($_GET['tabela']) {

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_' . $_GET['tabela']],
            'valor' => str_replace(".", ",", $row['Valor_Produto']),
			'comissaoprod' => str_replace(".", ",", $row['Comissao']),
			'comissaoservico' => str_replace(".", ",", $row['Comissao']),
			'comissaocashback' => str_replace(".", ",", $row['Comissao']),
			'nomeprod' => $row['NomeProduto'],
			'id_produto' => $row['idTab_Produtos'],
			'prod_serv' => $row['Prod_Serv'],
        );
    }
}
else {

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'valor' => str_replace(".", ",", $row['Valor_Produto']),
			'comissaoprod' => str_replace(".", ",", $row['Comissao']),
			'comissaoservico' => str_replace(".", ",", $row['Comissao']),
			'comissaocashback' => str_replace(".", ",", $row['Comissao']),
			'nomeprod' => $row['NomeProduto'],
			'id_produto' => $row['idTab_Produtos'],
			'prod_serv' => $row['Prod_Serv'],
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
