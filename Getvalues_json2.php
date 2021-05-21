<?php

session_start();

$link2 = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
if (!$link2) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db2 = mysql_select_db($_SESSION['db']['database'], $link2);
if (!$db2) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}

#echo 'Conexão bem sucedida';

if ($_GET['q']==1) {

    $result = mysql_query(
            'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorServico) AS NomeServico,
                TSV.ValorServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				TSV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				TSV.NomeServico ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorServico'],
        );
    }

}

elseif ($_GET['q'] == 2) {

    $result = mysql_query('
            SELECT
				P.idTab_Funcao,
				CONCAT(IFNULL(P.Funcao,"")) AS Funcao
            FROM
                Tab_Funcao AS P
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				P.Funcao ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idTab_Funcao'],
            'name' => utf8_encode($row['Funcao']),
        );
    }

}

elseif ($_GET['q'] == 3) {

    $result = mysql_query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idSis_Usuario'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

elseif ($_GET['q'] == 30) {

    $result = mysql_query('
            SELECT
				AF.idApp_Funcao,
				CONCAT(IFNULL(TF.Abrev,""), " || ", IFNULL(U.Nome,"")) AS Nome
            FROM
                App_Funcao AS AF
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = AF.idSis_Usuario
					LEFT JOIN Tab_Funcao AS TF ON TF.idTab_Funcao = AF.idTab_Funcao
            WHERE
				AF.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				U.Inativo = "0" AND
				U.Servicos = "S"  
			
			ORDER BY 
				TF.Abrev ASC,
				U.Nome ASC
				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idApp_Funcao'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

elseif ($_GET['q'] == 300) {

    $result = mysql_query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(P.Nome,""), " -- ", IFNULL(F.Funcao,"")) AS Nome
            FROM
                Sis_Usuario AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Inativo = "0" AND
				P.Servicos = "S"  
			ORDER BY 
				F.Funcao ASC,
				P.Nome ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array2[] = array(
            'id' => $row['idSis_Usuario'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

elseif ($_GET['q'] == 14) {
	
    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TCP.idTab_Cor_Prod,
				TCP.Nome_Cor_Prod,
				TTP.idTab_Tam_Prod,
				TTP.Nome_Tam_Prod,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TCP.Nome_Cor_Prod,""), " - ", IFNULL(TTP.Nome_Tam_Prod,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Cor_Prod AS TCP ON TCP.idTab_Cor_Prod = TPS.Cor_Prod
					LEFT JOIN Tab_Tam_Prod AS TTP ON TTP.idTab_Tam_Prod = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_3'] . '
			ORDER BY
				TPS.Nome_Prod ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['Nome_Prod']),
            'value' => $row['Valor_Produto'],
        );
    } 
    
}

echo json_encode($event_array2);
mysql_close($link2);
?>
