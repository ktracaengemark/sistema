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

if ($_GET['q']==1) {
/*
$query = ($_SESSION['log']['Convenio'] && isset($_SESSION['log']['Convenio'])) ?
    'P.idTab_Convenio = ' . $_SESSION['log']['Convenio'] . ' AND ' : FALSE;
*/
    $result = mysql_query(
            'SELECT
                S.idTab_Servico,
                CONCAT(CO.Convenio, " --- ", SB.ServicoBase, " --- R$ ", S.ValorVendaServico) AS ServicoBase,
                S.ValorVendaServico
            FROM
                Tab_Servico AS S
				LEFT JOIN Tab_ServicoBase AS SB ON SB.idTab_ServicoBase = S.ServicoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = S.Convenio
            WHERE
                S.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                S.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY CO.Convenio DESC, SB.ServicoBase ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['ServicoBase']),
            'value' => $row['ValorVendaServico'],
        );
    }

}

elseif ($_GET['q'] == 2) {
/*
$query = ($_SESSION['log']['Convenio'] && isset($_SESSION['log']['Convenio'])) ?
    'P.idTab_Convenio = ' . $_SESSION['log']['Convenio'] . ' AND ' : FALSE;
*/
    $result = mysql_query(
            'SELECT
                P.idTab_Produto,
				CONCAT(CO.Convenio, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- R$ ", P.ValorVendaProduto) AS ProdutoBase,
				P.ValorVendaProduto
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC '
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['ProdutoBase']),
            'value' => $row['ValorVendaProduto'],
        );
    }

}
elseif ($_GET['q'] == 3) {

    $result = mysql_query(
            'SELECT                
				idApp_Profissional,
				CONCAT(NomeProfissional, " --- ", Funcao) AS NomeProfissional				
            FROM
                App_Profissional
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY Funcao ASC, NomeProfissional ASC'
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
