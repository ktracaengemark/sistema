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
                TSC.idTab_ServicoCompra,
				CONCAT(TEM.NomeEmpresa, " --- ", TSB.ServicoBase) AS ServicoBase,
				TSC.ValorCompraServico               
            FROM
                Tab_ServicoCompra AS TSC
					LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase
					LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TSC.Empresa
				
            WHERE
                TSC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSC.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY 
					TEM.NomeEmpresa ASC,
					TSB.ServicoBase ASC 
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_ServicoCompra'],
            'name' => utf8_encode($row['ServicoBase']),
            'value' => $row['ValorCompraServico'],
        );
    }

}
elseif ($_GET['q'] == 2) {

    $result = mysql_query(
            'SELECT
                TPC.idTab_ProdutoCompra,
				CONCAT(TEM.NomeEmpresa, "---", TPB.ProdutoBase, "---", TPB.UnidadeProdutoBase) AS ProdutoBase,
				TPC.ValorCompraProduto
            FROM
                Tab_ProdutoCompra AS TPC
					LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase
					LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TPC.Empresa
            WHERE
                TPC.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPC.idSis_Usuario = ' . $_SESSION['log']['id'] . '				
			ORDER BY 
				TEM.NomeEmpresa,
				TPB.ProdutoBase ASC 
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_ProdutoCompra'],
            'name' => utf8_encode($row['ProdutoBase']),
            'value' => $row['ValorCompraProduto'],
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

echo json_encode($event_array);
mysql_close($link);
?>
