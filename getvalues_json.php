<?php

$link = mysql_connect('159.203.125.243', 'usuario', '20UtpJ15');
if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db = mysql_select_db('app', $link);
if (!$db) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}

#echo 'Conexão bem sucedida';

session_start();

if ($_GET['q']==1) {

    $result = mysql_query(
            'SELECT
                idTab_Servico,
                NomeServico,
                ValorVenda
            FROM 
                Tab_Servico 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id']
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorVenda'],
        );
    }

}
elseif ($_GET['q'] == 2) {

    $result = mysql_query(
            'SELECT
                idTab_Produto,
                NomeProduto,
                ValorVenda
            FROM 
                Tab_Produto 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id']
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorVenda'],
        );
    } 
    
}
    
echo json_encode($event_array);
mysql_close($link);
?>
