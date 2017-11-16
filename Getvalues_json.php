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
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorVendaServico) AS NomeServico,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TSV.Empresa = ' . $_SESSION['log']['Empresa'] . '
			ORDER BY
				TSV.NomeServico ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorVendaServico'],
        );
    }

}

elseif ($_GET['q'] == 2) {

    $result = mysql_query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(P.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TCO.Convenio,""), " -- ", IFNULL(V.Convdesc,""), " --- ", V.ValorVendaProduto, " -- ", IFNULL(P.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,""), " -- ", IFNULL(P.CodProd,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
        );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Valor'],
            #'name' => utf8_encode($row['NomeProduto']),
            #'name' => $row['NomeProduto'],
            'name' => mb_convert_encoding($row['NomeProduto'], "UTF-8", "ISO-8859-1"),
            'value' => $row['ValorVendaProduto'],
        );
    }

}
elseif ($_GET['q'] == 3) {

    $result = mysql_query(
            'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Profissional'],
            'name' => utf8_encode($row['NomeProfissional']),
        );
    }

}

elseif ($_GET['q'] == 4) {

    $result = mysql_query(
            'SELECT
				idTab_Convenio,
				Convenio,
				Abrev
            FROM
                Tab_Convenio
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . '
                ORDER BY Convenio ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Convenio'],
            'name' => utf8_encode($row['Convenio']),
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
