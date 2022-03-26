<?php
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>CashBack</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		//$arquivo = 'clientes.xls';
		$arquivo = 'CashBack_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="3">Planilha de CashBack</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Empresa</b></td>';
		$html .= '<td><b>Ficha</b></td>';
		$html .= '<td><b>id_Cliente</b></td>';
		$html .= '<td><b>Cliente</b></td>';
		$html .= '<td><b>Nasc.</b></td>';
		$html .= '<td><b>Sexo</b></td>';
		$html .= '<td><b>Celular</b></td>';
		$html .= '<td><b>Telefone</b></td>';
		$html .= '<td><b>Telefone2</b></td>';
		$html .= '<td><b>Telefone3</b></td>';
		$html .= '<td><b>CepCliente</b></td>';
		$html .= '<td><b>Endereço</b></td>';
		$html .= '<td><b>NumeroCliente</b></td>';
		$html .= '<td><b>ComplementoCliente</b></td>';
		$html .= '<td><b>Bairro</b></td>';
		$html .= '<td><b>Cidade</b></td>';
		$html .= '<td><b>EstadoCliente</b></td>';
		$html .= '<td><b>ReferenciaCliente</b></td>';
		$html .= '<td><b>Email</b></td>';
		$html .= '<td><b>Obs</b></td>';
		$html .= '<td><b>Ativo</b></td>';
		$html .= '<td><b>Motivo</b></td>';
		$html .= '<td><b>Cadast.</b></td>';
		$html .= '<td><b>Qtd.Pedidos</b></td>';
		$html .= '<td><b>Total</b></td>';
		$html .= '<td><b>Ult.Pdd.</b></td>';
		$html .= '<td><b>ValorCash</b></td>';
		$html .= '<td><b>Valid.Cash</b></td>';
		$html .= '</tr>';
		
		//Selecionar os itens da Tabela
		$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'TOT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		$date_inicio_orca = ($_SESSION['FiltroRankingVendas']['DataInicio']) ? 'TOT.DataOrca >= "' . $_SESSION['FiltroRankingVendas']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroRankingVendas']['DataFim']) ? 'TOT.DataOrca <= "' . $_SESSION['FiltroRankingVendas']['DataFim'] . '" AND ' : FALSE;
		$date_inicio_cash = ($_SESSION['FiltroRankingVendas']['DataInicio2']) ? 'TC.ValidadeCashBack >= "' . $_SESSION['FiltroRankingVendas']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_cash = ($_SESSION['FiltroRankingVendas']['DataFim2']) ? 'TC.ValidadeCashBack <= "' . $_SESSION['FiltroRankingVendas']['DataFim2'] . '" AND ' : FALSE;
		$date_inicio_ultimo = ($_SESSION['FiltroRankingVendas']['DataInicio3']) ? 'TC.UltimoPedido >= "' . $_SESSION['FiltroRankingVendas']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_ultimo = ($_SESSION['FiltroRankingVendas']['DataFim3']) ? 'TC.UltimoPedido <= "' . $_SESSION['FiltroRankingVendas']['DataFim3'] . '" AND ' : FALSE;
		$pedidos_de = ($_SESSION['FiltroRankingVendas']['Pedidos_de']) ? 'F.ContPedidos >= "' . $_SESSION['FiltroRankingVendas']['Pedidos_de'] . '" AND ' : FALSE;
		$pedidos_ate = ($_SESSION['FiltroRankingVendas']['Pedidos_ate']) ? 'F.ContPedidos <= "' . $_SESSION['FiltroRankingVendas']['Pedidos_ate'] . '" AND ' : FALSE;
		$valor_de = ($_SESSION['FiltroRankingVendas']['Valor_de']) ? 'F.Valor >= "' . $_SESSION['FiltroRankingVendas']['Valor_de'] . '" AND ' : FALSE;
		$valor_ate = ($_SESSION['FiltroRankingVendas']['Valor_ate']) ? 'F.Valor <= "' . $_SESSION['FiltroRankingVendas']['Valor_ate'] . '" AND ' : FALSE;
		$valor_cash_de = ($_SESSION['FiltroRankingVendas']['Valor_cash_de']) ? 'F.CashBackCliente >= "' . $_SESSION['FiltroRankingVendas']['Valor_cash_de'] . '" AND ' : FALSE;
		$valor_cash_ate = ($_SESSION['FiltroRankingVendas']['Valor_cash_ate']) ? 'F.CashBackCliente <= "' . $_SESSION['FiltroRankingVendas']['Valor_cash_ate'] . '" AND ' : FALSE;
        $idapp_cliente = ($_SESSION['FiltroRankingVendas']['idApp_Cliente']) ? ' AND TC.idApp_Cliente = ' . $_SESSION['FiltroRankingVendas']['idApp_Cliente'] : FALSE;
        $campo = (!$_SESSION['FiltroRankingVendas']['Campo']) ? 'F.Valor' : $_SESSION['FiltroRankingVendas']['Campo'];
        $ordenamento = (!$_SESSION['FiltroRankingVendas']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroRankingVendas']['Ordenamento'];

        $result_msg_contatos = '
			SELECT
				F.*
			FROM
				(SELECT
					TC.*,
					TOT.DataOrca,
					COUNT(TOT.idApp_OrcaTrata) AS ContPedidos,
					SUM(TOT.ValorFinalOrca) AS Valor
				FROM
					App_Cliente AS TC
						INNER JOIN App_OrcaTrata AS TOT ON TOT.idApp_Cliente = TC.idApp_Cliente
				WHERE
					' . $permissao_orcam . '
					' . $date_inicio_orca . '
					' . $date_fim_orca . '
					' . $date_inicio_cash . '
					' . $date_fim_cash . '
					' . $date_inicio_ultimo . '
					' . $date_fim_ultimo . '
					TOT.CanceladoOrca = "N" AND
					TC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
					' . $idapp_cliente . '
				GROUP BY
					TC.idApp_Cliente
				) AS F
			WHERE
				' . $pedidos_de . '
				' . $pedidos_ate . '
				' . $valor_de . '
				' . $valor_ate . '
				' . $valor_cash_de . '
				' . $valor_cash_ate . '
				F.idApp_Cliente != 0
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
        ';

		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["idSis_Empresa"].'</td>';
			$html .= '<td>'.$row_msg_contatos["RegistroFicha"].'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_Cliente"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
			$data_nasc = date('d/m/Y',strtotime($row_msg_contatos["DataNascimento"]));
			$html .= '<td>'.$data_nasc.'</td>';
			$html .= '<td>'.$row_msg_contatos["Sexo"].'</td>';
			$html .= '<td>'.$row_msg_contatos["CelularCliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Telefone"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Telefone2"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Telefone3"].'</td>';
			$html .= '<td>'.$row_msg_contatos["CepCliente"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["EnderecoCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NumeroCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ComplementoCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["BairroCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["CidadeCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["EstadoCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ReferenciaCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Email"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Ativo"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["Motivo"].'</td>';
			$data_cad = date('d/m/Y',strtotime($row_msg_contatos["DataCadastroCliente"]));
			$html .= '<td>'.$data_cad.'</td>';
			$html .= '<td>'.$row_msg_contatos["ContPedidos"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Valor"].'</td>';
			if(!isset($row_msg_contatos["UltimoPedido"]) || $row_msg_contatos["UltimoPedido"] == "0000-00-00"){
				$dt_ult_pdd = NULL;
			}else{
				$dt_ult_pdd = date('d/m/Y',strtotime($row_msg_contatos["UltimoPedido"]));
			}
			$html .= '<td>'.$dt_ult_pdd.'</td>';
			$html .= '<td>'.$row_msg_contatos["CashBackCliente"].'</td>';
			$data_val = date('d/m/Y',strtotime($row_msg_contatos["ValidadeCashBack"]));
			$html .= '<td>'.$data_val.'</td>';
			$html .= '</tr>';
		}
		
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		
		// Envia o conteúdo do arquivo
		echo $html;
		exit; 
		?>
	</body>
</html>
