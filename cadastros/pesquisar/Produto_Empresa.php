<?php
	
include_once '../../conexao.php';

if (isset($_GET['produto'])) {
	
	//$id_empresa = $_GET['id_empresa'];
	$produto 	= $_GET['produto'];
	//echo json_encode($produto);
	
	$produtox = explode(' ', $produto);

	if (isset($produtox[2]) && $produtox[2] != ''){
		
		$produto2 = $produtox[2];
		
		if (isset($produto2)){
		
			$query2 = '(TPS.Nome_Prod like "%' . $produto2 . '%"  OR '
						. 'TV.Convdesc like "%' . $produto2 . '%"  OR '
						. 'TPS.Produtos_Descricao like "%' . $produto2 . '%"  OR '
						. 'TPS.Cod_Prod like "%' . $produto2 . '%"  OR '
						. 'TPS.Cod_Barra like "%' . $produto2 . '%" )';
			
		}	
		$filtro2 = ' AND ' . $query2 ;
	} else {
		$filtro2 = FALSE ;
	}

	if (isset($produtox[1]) && $produtox[1] != ''){
		$produto0 = $produtox[0];
		$produto1 = $produtox[1];
		
		if (isset($produto1)){	
			
			$query1 = '(TPS.Nome_Prod like "%' . $produto1 . '%"  OR '
						. 'TV.Convdesc like "%' . $produto1 . '%"  OR '
						. 'TPS.Produtos_Descricao like "%' . $produto1 . '%"  OR '
						. 'TPS.Cod_Prod like "%' . $produto1 . '%"  OR '
						. 'TPS.Cod_Barra like "%' . $produto1 . '%"  )';
			
		}	
		$filtro1 = ' AND ' . $query1 ;
		
	}else{
		$produto0 = $produto;
		$filtro1 = FALSE;
	}

	$query0 = '(TPS.Nome_Prod like "%' . $produto0 . '%"  OR '
				. 'TV.Convdesc like "%' . $produto0 . '%"  OR '
				. 'TPS.Produtos_Descricao like "%' . $produto0 . '%"  OR '
				. 'TPS.Cod_Prod like "%' . $produto0 . '%"  OR '
				. 'TPS.Cod_Barra like "%' . $produto0 . '%"  )';
	
	/*
	$query = '(TPS.Nome_Prod like "%' . $produto . '%"  OR '
				. 'TPS.Produtos_Descricao like "%' . $produto . '%"  OR '
				. 'TPS.Cod_Prod like "%' . $produto . '%"  OR '
				. 'TPS.Cod_Barra like "%' . $produto . '%"  )';
	*/			
	if(!empty($produto)){
			
		$result = ('
			SELECT 
				TV.idTab_Valor,
				TV.idTab_Produto,
				TV.ValorProduto,
				TV.QtdProdutoDesconto,
				TV.QtdProdutoIncremento,
				TV.Convdesc,
				TV.idTab_Promocao,
				TV.Desconto,
				TV.ComissaoVenda,
				TV.ComissaoCashBack,
				TV.TempoDeEntrega,
				TV.Convdesc,
				TPS.idTab_Produtos,
				TPS.idTab_Produto,
				TPS.Nome_Prod,
				IFNULL(TPS.Produtos_Descricao,"") AS DescProd,
				TPS.Arquivo AS Arquivo_Produto,
				TPS.Valor_Produto,
				TPS.ContarEstoque,
				TPS.Estoque,
				TPS.Cod_Prod,
				TPS.Cod_Barra,
				CONCAT(IFNULL(TPS.Nome_Prod,""), " " ,IFNULL(TV.Convdesc,"")) AS Nome_Produto,
				EP.idSis_Empresa,
				EP.NomeEmpresa,
				EP.Site,
				EP.Inativo,
				EP.Arquivo AS Arquivo_Empresa
			FROM 
				Tab_Valor AS TV
					LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = TV.idTab_Produtos
					LEFT JOIN Sis_Empresa AS EP ON EP.idSis_Empresa = TPS.idSis_Empresa

			WHERE
				TV.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND 
				(' . $query0 . '' . $filtro1 . '' . $filtro2 . ') AND
				TV.Desconto = "1" AND
				TV.AtivoPreco = "S"
			ORDER BY 
				TPS.Nome_Prod ASC
			LIMIT 50
		');	
			
		//echo json_encode($result);
		//Seleciona os registros com $conn
		$read_produto = mysqli_query($conn, $result);
		foreach($read_produto as $row){		
			
			$data[] = array(
				
				'id_empresa' 		=> $row['idSis_Empresa'],
				'nomeempresa' 		=> utf8_encode ($row['NomeEmpresa']),
				'site' 				=> $row['Site'],
				'arquivo_empresa' 	=> $row['Arquivo_Empresa'],
				'id_produto' 		=> $row['idTab_Produtos'],
				'nomeprod' 			=> utf8_encode ($row['Nome_Produto']),
				'descprod' 			=> utf8_encode ($row['DescProd']),
				'arquivo_produto' 	=> $row['Arquivo_Produto'],
				'contarestoque' 	=> $row['ContarEstoque'],
				'estoque' 			=> $row['Estoque'],
				'id_valor' 			=> $row['idTab_Valor'],
				'qtdinc' 			=> $row['QtdProdutoIncremento'],
				'valor' 			=> str_replace(".", ",", $row['ValorProduto']),
				'codprod' 			=> $row['Cod_Prod'],
				'codbarra' 			=> $row['Cod_Barra'],
				
			);			
		}
		echo json_encode($data);
		
	}else{
	
		//echo json_encode($data);
		echo false;
	}
	
}else{
	
	//echo json_encode('socorro');
	echo false;
	
}

mysqli_close($conn);
