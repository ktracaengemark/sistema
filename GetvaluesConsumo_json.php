<?php

session_start();

$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link) {
    die('N�o foi poss�vel conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('N�o foi poss�vel selecionar banco de dados: ' . mysql_error());
}

#echo 'Conex�o bem sucedida';

if ($_GET['q']==1) {

    $result = mysql_query(
            'SELECT
                idTab_Servico,
				CONCAT(TipoServico, " --- ", Convenio, " --- ", NomeServico, " --- R$ ", ValorConsumoServico) As NomeServico,
				ValorConsumoServico
                
            FROM
                Tab_Servico 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY TipoServico DESC, Convenio ASC, NomeServico ASC '
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorConsumoServico'],
        );
    }

}
elseif ($_GET['q'] == 2) {

    $result = mysql_query(
            'SELECT
                idTab_Produto,
				CONCAT(TipoProduto, " --- ", Convenio, " --- ", NomeProduto, " --- ", UnidadeProduto, " --- R$ ", ValorConsumoProduto) AS NomeProduto,
				ValorConsumoProduto
            FROM
                Tab_Produto
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
				ORDER BY TipoProduto DESC, Convenio ASC, NomeProduto ASC '
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorConsumoProduto'],
        );
    }

}
elseif ($_GET['q'] == 3) {

    $result = mysql_query(
            'SELECT
                idApp_Profissional,
                NomeProfissional
            FROM
                App_Profissional
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY NomeProfissional ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Profissional'],
            'name' => utf8_encode($row['NomeProfissional']),
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>