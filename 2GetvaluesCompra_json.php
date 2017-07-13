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

    $result = mysql_query(
            'SELECT
                S.idTab_Servico,
				CONCAT(S.TipoServico, " --- ", SB.ServicoBase, " --- R$ ", S.ValorCompraServico) As ServicoBase,
				S.ValorCompraServico
                
            FROM
                Tab_Servico AS S
				LEFT JOIN Tab_ServicoBase AS SB ON SB.idTab_ServicoBase = S.ServicoBase
				
            WHERE
                S.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                S.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY S.TipoServico DESC, S.ServicoBase ASC '
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['ServicoBase']),
            'value' => $row['ValorCompraServico'],
        );
    }

}
elseif ($_GET['q'] == 2) {

    $result = mysql_query(
            'SELECT
                idTab_ProdutoBase,
				CONCAT(TipoProdutoBase, " --- ", ProdutoBase, " --- ", UnidadeProdutoBase, " --- R$ ", ValorCompraProdutoBase) AS ProdutoBase,
				ValorCompraProdutoBase
            FROM
                Tab_ProdutoBase

            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
				
			ORDER BY TipoProdutoBase DESC, ProdutoBase ASC '
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_ProdutoBase'],
            'name' => utf8_encode($row['ProdutoBase']),
            'value' => $row['ValorCompraProdutoBase'],
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
