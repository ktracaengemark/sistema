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
$dataatual = date('Y-m-d', time());
$dia_da_semana = date('N');
	  
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

        $event_array[] = array(
            'id' => $row['idTab_Servico'],
            'name' => utf8_encode($row['NomeServico']),
            'value' => $row['ValorServico'],
        );
    }

}

elseif  ($_GET['q']==100) {

    $result = mysql_query('
		SELECT *
        FROM
            App_Cliente
        WHERE
		idApp_Cliente = ' . $_GET['idCliente'] . '
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Cliente'],
			'cepcliente' => utf8_encode($row['CepCliente']),
            'enderecocliente' => utf8_encode($row['EnderecoCliente']),
			'numerocliente' => utf8_encode($row['NumeroCliente']),
			'complementocliente' => utf8_encode($row['ComplementoCliente']),
			'bairrocliente' => utf8_encode($row['BairroCliente']),
			'municipiocliente' => utf8_encode($row['CidadeCliente']),
			'estadocliente' => utf8_encode($row['EstadoCliente']),
			'referenciacliente' => utf8_encode($row['ReferenciaCliente']),
        );
    }

}

elseif  ($_GET['q']==110) {

    $result = mysql_query('
		SELECT *
        FROM
            App_Fornecedor
        WHERE
		idApp_Fornecedor = ' . $_GET['idFornecedor'] . '
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Fornecedor'],
			'cepfornecedor' => utf8_encode($row['CepFornecedor']),
            'enderecofornecedor' => utf8_encode($row['EnderecoFornecedor']),
			'numerofornecedor' => utf8_encode($row['NumeroFornecedor']),
			'complementofornecedor' => utf8_encode($row['ComplementoFornecedor']),
			'bairrofornecedor' => utf8_encode($row['BairroFornecedor']),
			'municipiofornecedor' => utf8_encode($row['CidadeFornecedor']),
			'estadofornecedor' => utf8_encode($row['EstadoFornecedor']),
			'referenciafornecedor' => utf8_encode($row['ReferenciaFornecedor']),
        );
    }

}

elseif ($_GET['q'] == 16) {

    $result = mysql_query('
            SELECT
                idTab_Atributo,
                CONCAT(IFNULL(Atributo,"")) AS Atributo
            FROM 
                Tab_Atributo 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY 
				Atributo ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Atributo'],
            'name' => utf8_encode($row['Atributo']),
        );
    } 
    
}

elseif ($_GET['q'] == 11) {

    $result = mysql_query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(CodProd,""), " - ", IFNULL(Produtos,""), " - ", IFNULL(UnidadeProduto,""), " - ", IFNULL(ValorProdutoSite,"")) AS NomeProduto,
                ValorProdutoSite
            FROM 
                Tab_Produto 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
			ORDER BY
				NomeProduto ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorProdutoSite'],
        );
    } 
    
}

elseif ($_GET['q'] == 12) {

    $result = mysql_query('
            SELECT
                TPS.*,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TPS.Cod_Barra,"")) AS Nome_Prod
            FROM 
                Tab_Produtos AS TPS		
            WHERE
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
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

elseif ($_GET['q'] == 122) {

    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2			
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
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

elseif ($_GET['q'] == 13) {

    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Promocao']['Mod_2'] . '
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

elseif ($_GET['q'] == 14) {
	
    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
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

elseif ($_GET['q'] == 15) {

    $result = mysql_query('
            SELECT
                TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TOP2.Opcao,
				TOP1.Opcao,				
				CONCAT(IFNULL(TPS.Nome_Prod,""), " - ", IFNULL(TOP1.Opcao,""), " - ", IFNULL(TOP2.Opcao,""), " - ", IFNULL(TPS.Valor_Produto,"")) AS Nome_Prod,
                TPS.Valor_Produto
            FROM 
                Tab_Produtos AS TPS
					LEFT JOIN Tab_Opcao AS TOP2 ON TOP2.idTab_Opcao = TPS.Opcao_Atributo_1
					LEFT JOIN Tab_Opcao AS TOP1 ON TOP1.idTab_Opcao = TPS.Opcao_Atributo_2				
            WHERE
                TPS.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				TPS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				TPS.idTab_Produto = ' . $_SESSION['Produto']['idTab_Produto'] . '
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

elseif ($_GET['q'] == 20) {

    $result = mysql_query('
            SELECT
                P.idTab_Produtos,
				P.Nome_Prod,
				P.Valor_Produto,
				P.Prod_Serv,				
				CONCAT(IFNULL(P.Nome_Prod,""), " - R$ ", IFNULL(P.Valor_Produto,"")) AS NomeProduto
            FROM 
                Tab_Produtos AS P
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prod_Serv = "P"
			ORDER BY
				P.Nome_Prod ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['NomeProduto']),
        );
    } 
    
}

elseif ($_GET['q'] == 202) {

    $result = mysql_query('
            SELECT
                P.idTab_Produtos,
				P.Nome_Prod,
				P.Valor_Produto,				
				CONCAT(IFNULL(P.Nome_Prod,""), " - R$ ", IFNULL(P.Valor_Produto,"")) AS NomeProduto
            FROM 
                Tab_Produtos AS P 
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prod_Serv = "S"
			ORDER BY
				P.Nome_Prod ASC
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produtos'],
            'name' => utf8_encode($row['NomeProduto']),
        );
    } 
    
}

elseif ($_GET['q'] == 2) {

    $result = mysql_query('
            SELECT
                idTab_Produto,
                CONCAT(IFNULL(Produtos,"")) AS NomeProduto,
                ValorCompraProduto
            FROM 
                Tab_Produto 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Produto'],
            'name' => utf8_encode($row['NomeProduto']),
            'value' => $row['ValorCompraProduto'],
        );
    } 
    
}

elseif ($_GET['q'] == 90) {
	
	$nivel = ($_SESSION['Usuario']['Nivel'] == 2) ? 'AND V.TipoPreco = "V"' : FALSE;
	$filtro1 = ($_GET['tipo_orca'] == "B") ? ' AND ((V.Desconto = "1" AND 
													V.VendaBalcaoPreco = "S") OR 
													(V.Desconto = "2" AND 
													TPM.VendaBalcao = "S" AND 
													TPM.DataInicioProm <= "' . $dataatual . '" AND 
													TPM.DataFimProm >= "' . $dataatual . '" AND 
													TD.id_Dia_Prom = ' . $dia_da_semana . ' AND 
													TD.Aberto_Prom = "S")
													)': 
												' AND ((V.Desconto = "1" AND 
													V.VendaSitePreco = "S") OR 
													(V.Desconto = "2" AND 
													TPM.VendaSite = "S" AND 
													TPM.DataInicioProm <= "' . $dataatual . '" AND 
													TPM.DataFimProm >= "' . $dataatual . '" AND
													TD.id_Dia_Prom = ' . $dia_da_semana . ' AND 
													TD.Aberto_Prom = "S")
													)';
    
	$result = mysql_query('
            SELECT
                V.idTab_Valor,
				V.idTab_Produtos,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				V.Convdesc,
				V.Desconto,
				V.TipoPreco,
				TDS.Desconto,
				TPM.Promocao,
				TPM.VendaBalcao,
				TPM.VendaSite,
				TPM.DataInicioProm,
				TPM.DataFimProm,
				TD.*,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,""), " - ", IFNULL(P.Cod_Barra,""), " - ", IFNULL(V.QtdProdutoIncremento,""), " UNID - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - R$", IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Dia_Prom AS TD ON TD.idTab_Promocao = TPM.idTab_Promocao
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				P.Prod_Serv = "P"
				' . $filtro1 . '
				' . $nivel . '
			ORDER BY
				TDS.Desconto ASC,
				P.Nome_Prod ASC,
				TPM.Promocao ASC
        ');

    while ($row = mysql_fetch_assoc($result)) {
		if($row['TipoPreco'] == "V"){
			$row['TipoPreco'] = "CHEIO";
		}elseif($row['TipoPreco'] == "R"){
			$row['TipoPreco'] = "REVENDA";
		}else{
			$row['TipoPreco'] = "";
		}
        $event_array[] = array(
            'id' => $row['idTab_Valor'],
			'id_produto' => $row['idTab_Produtos'],
            #'name' => utf8_encode($row['NomeProduto']),
            #'name' => $row['NomeProduto'],
            'name' => mb_convert_encoding($row['NomeProduto'].' - '.$row['TipoPreco'], "UTF-8", "ISO-8859-1"),
            'value' => $row['ValorProduto'],
        );
    }

}

elseif ($_GET['q'] == 902) {
	
	$nivel = ($_SESSION['Usuario']['Nivel'] == 2) ? 'AND V.TipoPreco = "V"' : FALSE;
	$filtro1 = ($_GET['tipo_orca'] == "B") ? ' AND ((V.Desconto = "1" AND 
													V.VendaBalcaoPreco = "S") OR 
													(V.Desconto = "2" AND 
													TPM.VendaBalcao = "S" AND 
													TPM.DataInicioProm <= "' . $dataatual . '" AND 
													TPM.DataFimProm >= "' . $dataatual . '" AND
													TD.id_Dia_Prom = ' . $dia_da_semana . ' AND 
													TD.Aberto_Prom = "S")
													)': 
												' AND ((V.Desconto = "1" AND 
													V.VendaSitePreco = "S") OR 
													(V.Desconto = "2" AND 
													TPM.VendaSite = "S" AND  
													TPM.DataInicioProm <= "' . $dataatual . '" AND 
													TPM.DataFimProm >= "' . $dataatual . '" AND
													TD.id_Dia_Prom = ' . $dia_da_semana . ' AND 
													TD.Aberto_Prom = "S")
													)';
    $result = mysql_query('
            SELECT
                V.idTab_Valor,
				V.idTab_Produtos,
                V.ValorProduto,
				V.QtdProdutoIncremento,
				V.Convdesc,
				V.Desconto,
				V.TipoPreco,
				TDS.Desconto,
				TPM.Promocao,
				TPM.VendaBalcao,
				TPM.VendaSite,
				TPM.DataInicioProm,
				TPM.DataFimProm,
				TD.*,
				CONCAT(IFNULL(P.Nome_Prod,""), " - ", IFNULL(V.Convdesc,""), " - ", IFNULL(P.Cod_Barra,""), " - ", IFNULL(V.QtdProdutoIncremento,""), " UNID - ", IFNULL(TDS.Desconto,""), " - ", IFNULL(TPM.Promocao,""), " - R$ ",  IFNULL(V.ValorProduto,"")) AS NomeProduto
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
					LEFT JOIN Tab_Dia_Prom AS TD ON TD.idTab_Promocao = TPM.idTab_Promocao				
            WHERE
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				P.Prod_Serv = "S"
				' . $filtro1 . '
				' . $nivel . '
			ORDER BY
				TDS.Desconto ASC,
				P.Nome_Prod ASC,
				TPM.Promocao ASC
        ');

    while ($row = mysql_fetch_assoc($result)) {
		if($row['TipoPreco'] == "V"){
			$row['TipoPreco'] = "CHEIO";
		}elseif($row['TipoPreco'] == "R"){
			$row['TipoPreco'] = "REVENDA";
		}else{
			$row['TipoPreco'] = "";
		}
        $event_array[] = array(
            'id' => $row['idTab_Valor'],
			'id_produto' => $row['idTab_Produtos'],
            #'name' => utf8_encode($row['NomeProduto']),
            #'name' => $row['NomeProduto'],
            'name' => mb_convert_encoding($row['NomeProduto'].' - '.$row['TipoPreco'], "UTF-8", "ISO-8859-1"),
            'value' => $row['ValorProduto'],
        );
    }

}

elseif ($_GET['q'] == 70) {

    $result = mysql_query(
            'SELECT
				idTab_FormaPag,
				FormaPag
            FROM
                Tab_FormaPag
			ORDER BY 
				FormaPag DESC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_FormaPag'],
            'name' => utf8_encode($row['FormaPag']),
        );
    }

}

elseif ($_GET['q'] == 6) {

    $result = mysql_query(
            'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '
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
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				((3 = ' . $_SESSION['log']['Nivel'] . ' OR 
				4 = ' . $_SESSION['log']['Nivel'] . ' ) AND
				idTab_Convenio = "53") OR 
				(6 = ' . $_SESSION['log']['Nivel'] . ' AND
				(idTab_Convenio = "53" OR 
				idTab_Convenio = "54"))
				
			ORDER BY Convenio ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Convenio'],
            'name' => utf8_encode($row['Convenio']),
        );
    }

}

elseif ($_GET['q'] == 5) {

    $result = mysql_query(
            'SELECT
				idApp_Fornecedor,
				NomeFornecedor
            FROM
                App_Fornecedor
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
			ORDER BY 
				NomeFornecedor ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Fornecedor'],
            'name' => utf8_encode($row['NomeFornecedor']),
        );
    }

}

elseif ($_GET['q'] == 7) {

    $result = mysql_query(
            'SELECT
				idTab_Prioridade,
				Prioridade
            FROM
                Tab_Prioridade
			ORDER BY 
				idTab_Prioridade ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Prioridade'],
            'name' => utf8_encode($row['Prioridade']),
        );
    }

}

elseif ($_GET['q'] == 8) {
	
    $result = mysql_query(
            'SELECT
				idTab_Desconto,
				Desconto
            FROM
                Tab_Desconto
			ORDER BY 
				idTab_Desconto ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Desconto'],
            'name' => utf8_encode($row['Desconto']),
        );
    }

}

elseif ($_GET['q'] == 10) {

    $result = mysql_query(
            'SELECT
				idTab_Statustarefa,
				Statustarefa
            FROM
                Tab_Statustarefa
			ORDER BY 
				idTab_Statustarefa ASC'
    );

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Statustarefa'],
            'name' => utf8_encode($row['Statustarefa']),
        );
    }

}

elseif ($_GET['q'] == 3) {

    $result = mysql_query('
            SELECT
				P.idSis_Usuario,
				CONCAT(IFNULL(F.Funcao,""), " -- ", IFNULL(P.Nome,"")) AS Nome
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

        $event_array[] = array(
            'id' => $row['idSis_Usuario'],
            'name' => utf8_encode($row['Nome']),
        );
    }

}

elseif ($_GET['q'] == 95) {
//// daqui, Esp/Tamanho, eu pego o Fator de Multiplicação
    $result = mysql_query('
            SELECT
				P.idTab_Promocao,
				P.Promocao,
				P.Descricao,
				CONCAT(IFNULL(P.Promocao,""), " - ", IFNULL(P.Descricao,"")) AS Promocao
            FROM
                Tab_Promocao AS P
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				P.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
			ORDER BY 
				P.Promocao ASC
				
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Promocao'],
            'name' => utf8_encode($row['Promocao']),
        );
    }

}

elseif ($_GET['q'] == 101) {

    $permissao1 = isset($_SESSION['Atributos'][1]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][1] : 'AND idTab_Atributo = "0"';
	
	$result = mysql_query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
				' . $permissao1 . '
			ORDER BY 
				Opcao ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Opcao'],
            'name' => utf8_encode($row['Opcao']),
        );
    } 
    
}

elseif ($_GET['q'] == 102) {

    $permissao2 = isset($_SESSION['Atributos'][2]) ? 'AND idTab_Atributo = ' . $_SESSION['Atributos'][2] : 'AND idTab_Atributo = "0"';
	
	$result = mysql_query('
            SELECT
                idTab_Opcao,
				idTab_Atributo,
				idTab_Catprod,
                CONCAT(IFNULL(Opcao,"")) AS Opcao
            FROM 
                Tab_Opcao 
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '	AND
				idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
				' . $permissao2 . '
			ORDER BY 
				Opcao ASC	
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idTab_Opcao'],
            'name' => utf8_encode($row['Opcao']),
        );
    } 
    
}

elseif  ($_GET['q']==1000) {

    $result = mysql_query('
		SELECT *
        FROM
            App_Consulta
        WHERE
			idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
			DataInicio = "' . $_GET['idCliente'] . '"
    ');

    while ($row = mysql_fetch_assoc($result)) {

        $event_array[] = array(
            'id' => $row['idApp_Consulta'],
            'dataehora' => $row['DataInicio'],
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
