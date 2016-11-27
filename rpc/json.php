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

$result = mysql_query(
        'SELECT
            idApp_Servico,
            NomeServico,
            ValorServico
        FROM 
            App_Servico 
        WHERE
            idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
            idSis_Usuario = ' . $_SESSION['log']['id']
);

while ($row = mysql_fetch_assoc($result)) {

    $event_array[] = array(
        'id' => $row['idApp_Servico'],
        'name' => utf8_encode($row['NomeServico']),
        'value' => $row['ValorServico'],
    );
}

echo json_encode($event_array);
mysql_close($link);
?>
