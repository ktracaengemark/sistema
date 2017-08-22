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
                CONCAT(TCO.Abrev, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorVendaServico) AS ServicoBase,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio															
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSV.ServicoBase								
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY 
				TCO.Convenio DESC, 
				TSB.ServicoBase ASC 				
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
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorVendaProduto) AS NomeProduto,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV																	
            WHERE
                TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TPV.idSis_Usuario = ' . $_SESSION['log']['id'] . ' 
			ORDER BY  
				TPV.NomeProduto ASC				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
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
