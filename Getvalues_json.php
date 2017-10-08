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
				(TSV.Empresa = ' . $_SESSION['log']['id'] . ' OR
				 TSV.Empresa = ' . $_SESSION['log']['Empresa'] . ')
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
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorVendaProduto) AS NomeProduto,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV																	
            WHERE
				TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TPV.Empresa = ' . $_SESSION['log']['id'] . ' OR
				 TPV.Empresa = ' . $_SESSION['log']['Empresa'] . ') 
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
                idSis_Usuario = ' . $_SESSION['log']['id'] . '
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
