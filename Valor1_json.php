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
$result = mysql_query(
        'SELECT
            V.idTab_Modulo,
			V.idSis_Empresa,
			V.idTab_Valor,
			V.idTab_Produtos,
			V.ValorProduto,
			V.QtdProdutoDesconto,
			V.QtdProdutoIncremento,
			V.Convdesc,
			V.ComissaoVenda,
			V.ComissaoServico,
			V.ComissaoCashBack,
			V.TempoDeEntrega,
			P.Nome_Prod,
			P.NomeProdutos,
			P.Cod_Prod,
			P.Arquivo,
			P.Prod_Serv,
			TDS.Desconto,
			TPM.Promocao,
			CONCAT(IFNULL(P.Nome_Prod,"")," - ",IFNULL(V.Convdesc,"")) AS NomeProduto
        FROM
            Tab_' . $_GET['tabela'] . ' AS V
				LEFT JOIN Tab_Promocao AS TPM ON TPM.idTab_Promocao = V.idTab_Promocao
				LEFT JOIN Tab_Desconto AS TDS ON TDS.idTab_Desconto = V.Desconto
				LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
        WHERE
			V.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
');

if ($_GET['tabela']) {
	if ($_GET['recorrencias']) {
		$recorrencias = $_GET['recorrencias'];
	}else{
		$recorrencias = 1;
	}
    while ($row = mysql_fetch_assoc($result)) {
		$qtdincinteiro	= $row['QtdProdutoIncremento'];
		$qtdincdividido	= intval($qtdincinteiro/$recorrencias);
		if($qtdincdividido < 1){
			$qtdinccorrigido = 1;
		}else{
			$qtdinccorrigido = $qtdincdividido;
		}
		$valorinteiro 	= $row['ValorProduto'];
		//$valordividido 	= $valorinteiro/$recorrencias;
		$valordividido 	= $valorinteiro/1;
		$valordividido 	= number_format($valordividido, 2, ",", ".");
        $event_array[] 	= array(
            'id' => $row['idTab_' . $_GET['tabela']],
            //'valor' => str_replace(".", ",", $row['ValorProduto']),
			'valor' => str_replace(".", ",", $valordividido),
			'comissaoprod' => $row['ComissaoVenda'],
			'comissaoservico' => $row['ComissaoServico'],
			'comissaocashback' => $row['ComissaoCashBack'],
			'prazoprod' => $row['TempoDeEntrega'],
			'nomeprod' => $row['NomeProduto'],
			'qtdprod' => $row['QtdProdutoDesconto'],
			'qtdinc' => $qtdinccorrigido,
			'id_produto' => $row['idTab_Produtos'],
			'id_valor' => $row['idTab_Valor'],
			'prod_serv' => $row['Prod_Serv'],
        );
    }
}
else {
	if ($_GET['recorrencias']) {
		$recorrencias = $_GET['recorrencias'];
	}else{
		$recorrencias = 1;
	}
    while ($row = mysql_fetch_assoc($result)) {
		$qtdincinteiro	= $row['QtdProdutoIncremento'];
		$qtdincdividido	= intval($qtdincinteiro/$recorrencias);
		if($qtdincdividido < 1){
			$qtdinccorrigido = 1;
		}else{
			$qtdinccorrigido = $qtdincdividido;
		}
		$valorinteiro 	= $row['ValorProduto'];
		//$valordividido 	= $valorinteiro/$recorrencias;
		$valordividido 	= $valorinteiro/1;
		$valordividido 	= number_format($valordividido, 2, ",", ".");
        $event_array[] = array(
            'id' => $row['idTab_Valor'],
            //'valor' => str_replace(".", ",", $row['ValorProduto']),
			'valor' => str_replace(".", ",", $valordividido),
			'comissaovenda' => str_replace(".", ",", $row['ComissaoVenda']),
			'comissaoservico' => str_replace(".", ",", $row['ComissaoServico']),
			'comissaocashback' => str_replace(".", ",", $row['ComissaoCashBack']),
			'nomeprod' => $row['NomeProduto'],
			'qtdprod' => $row['QtdProdutoDesconto'],
			'qtdinc' => $qtdinccorrigido,
			'id_produto' => $row['idTab_Produtos'],
			'id_valor' => $row['idTab_Valor'],
			'prod_serv' => $row['Prod_Serv'],
        );
    }

}

echo json_encode($event_array);
mysql_close($link);
?>
