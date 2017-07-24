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
                CONCAT(TCO.Abrev, " --- ", TEM.NomeEmpresa, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorVendaServico) AS ServicoBase,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio				
				LEFT JOIN Tab_ServicoCompra AS TSC ON TSC.idTab_ServicoCompra = TSV.ServicoBase												
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TSC.Empresa				
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSC.ServicoBase								
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC, 
				TEM.NomeEmpresa ASC,
				TSB.ServicoBase 				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['ServicoBase']),
            'value' => $row['ValorVendaServico'],
        );
    }

}

elseif ($_GET['q'] == 2) {

    $result = mysql_query(
            'SELECT
                TPV.idTab_Produto,
				CONCAT(TCO.Abrev, " --- ", TEM.NomeEmpresa, " --- ", TPB.ProdutoBase, " --- ", TPB.UnidadeProdutoBase, " --- R$ ", TPV.ValorVendaProduto) AS ProdutoBase,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV				
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TPV.Convenio				
				LEFT JOIN Tab_ProdutoCompra AS TPC ON TPC.idTab_ProdutoCompra = TPV.ProdutoBase				
				LEFT JOIN App_Empresa AS TEM ON TEM.idApp_Empresa = TPC.Empresa				
				LEFT JOIN Tab_ProdutoBase AS TPB ON TPB.idTab_ProdutoBase = TPC.ProdutoBase								
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC, 
				TEM.NomeEmpresa ASC,
				TPB.ProdutoBase 				
    ');

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
