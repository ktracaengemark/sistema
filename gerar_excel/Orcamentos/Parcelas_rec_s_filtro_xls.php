<?php
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Parcelas das Redeitas</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela
	
			if($_SESSION['log']['idSis_Empresa'] != 5){
				$cliente = FALSE;
				$id_cliente = FALSE;				
				if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
					$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
				}else{
					$permissao_orcam = FALSE;
				}
				if($_SESSION['Empresa']['Rede'] == "S"){
					if($_SESSION['Usuario']['Nivel'] == 2){
						$nivel = 'AND OT.NivelOrca = 2';
						$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
						$rede = FALSE;
					}elseif($_SESSION['Usuario']['Nivel'] == 1){
						$nivel = FALSE;
						$permissao = '(OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' OR US.QuemCad = ' . $_SESSION['log']['idSis_Usuario'] . ') AND ';
						$rede = 'LEFT JOIN Sis_Usuario AS QUS ON QUS.QuemCad = US.idSis_Usuario';
					}else{
						$nivel = FALSE;
						$permissao = FALSE;
						$rede = FALSE;
					}
				}else{
					$nivel = FALSE;
					$permissao = FALSE;
					$rede = FALSE;
				}
				$produtos = FALSE;
				$groupby = 'GROUP BY PR.idApp_Parcelas';
			}else{
				$cliente = FALSE;
				$id_cliente = FALSE;
				$permissao_orcam = FALSE;
				$permissao = FALSE;
				$nivel = FALSE;
				$produtos = FALSE;
				$rede = FALSE;
				$groupby = 'GROUP BY PR.idApp_Parcelas';
			}

		$result_msg_contatos = '
            SELECT
                C.NomeCliente,
                C.CelularCliente,
                C.Telefone,
                C.Telefone2,
                C.Telefone3,
				C.DataCadastroCliente,
				C.EnderecoCliente,
				C.NumeroCliente,
				C.ComplementoCliente,
				C.BairroCliente,
				C.CidadeCliente,
				C.EstadoCliente,
				C.ReferenciaCliente,
				OT.idApp_OrcaTrata,
				OT.idApp_Cliente,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
                OT.CombinadoFrete,
				OT.Descricao,
                OT.DataOrca,
                OT.DataEntregaOrca,
                OT.DataVencimentoOrca,
				OT.ValorFinalOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.Modalidade,
				OT.AVAP,
				OT.TipoFrete,
				OT.NomeRec,
				OT.ParentescoRec,
				OT.FormaPagamento,
				TR.TipoFinanceiro,
                PR.idApp_Parcelas,
                PR.idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Cliente,
				PR.Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.DataLanc,
                PR.ValorPago,
                PR.Quitado,
				PR.idTab_TipoRD,
				PR.FormaPagamentoParcela,
				PRDS.DataConcluidoProduto,
				PRDS.ConcluidoProduto,
				TFP.FormaPag
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					' . $rede . '
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
            WHERE
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				OT.idTab_TipoRD = 2 AND
				' . $permissao . '
				' . $permissao_orcam . '
				' . $produtos . '
                PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
                ' . $cliente . '
                ' . $id_cliente . '
				' . $nivel . '
			' . $groupby . '
			ORDER BY
				OT.idApp_OrcaTrata
		';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Parcelas_Rec_S_Filtros_' . date('d-m-Y') . '.xls';

		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		/*
		$html .= '<tr>';
		$html .= '<td colspan="2">Planilha de Produtos e Serviços</tr>';
		$html .= '</tr>';
		*/
		// Campos da Tabela
		$html .= '<tr>';

		$html .= '<td><b>Pedido</b></td>';
		$html .= '<td><b>DtPedido</b></td>';
		
			$html .= '<td><b>DtEntrega</b></td>';
			$html .= '<td><b>id_Cliente</b></td>';
		
			$html .= '<td><b>Cliente</b></td>';
			$html .= '<td><b>Tel</b></td>';
			$html .= '<td><b>Comb.Ent</b></td>';
			$html .= '<td><b>Comb.Pag</b></td>';
			$html .= '<td><b>Entr.</b></td>';
			$html .= '<td><b>Pago.</b></td>';
			$html .= '<td><b>Final.</b></td>';
			$html .= '<td><b>Cancel.</b></td>';
			$html .= '<td><b>Compra</b></td>';
			$html .= '<td><b>Entrega</b></td>';
			$html .= '<td><b>Pagam.</b></td>';
		
		$html .= '<td><b>Form.Pag.</b></td>';
		$html .= '<td><b>Pc</b></td>';
		
		$html .= '<td><b>Parc.R$</b></td>';
		$html .= '<td><b>Quitada</b></td>';
		$html .= '<td><b>Vencimento</b></td>';
		$html .= '<td><b>Pagamento</b></td>';
		$html .= '<td><b>Lancamento</b></td>';		

		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			
			if(!isset($row_msg_contatos["DataVencimento"]) || $row_msg_contatos["DataVencimento"] == "0000-00-00"){
				$row_msg_contatos["DataVencimento"] = "";
			}
			if(!isset($row_msg_contatos["DataPago"]) || $row_msg_contatos["DataPago"] == "0000-00-00"){
				$row_msg_contatos["DataPago"] = "";
			}
			if(!isset($row_msg_contatos["DataLanc"]) || $row_msg_contatos["DataLanc"] == "0000-00-00"){
				$row_msg_contatos["DataLanc"] = "";
			}				

			if($row_msg_contatos["Tipo_Orca"] == "B"){
				$row_msg_contatos["Tipo_Orca"] = "Na Loja";
			}elseif($row_msg_contatos["Tipo_Orca"] == "O"){
				$row_msg_contatos["Tipo_Orca"] = "On Line";
			}else{
				$row_msg_contatos["Tipo_Orca"] = "Outros";
			}	
			
			if($row_msg_contatos["Modalidade"] == "P"){
				$row_msg_contatos["Modalidade"] = "Dividido";
			}elseif($row_msg_contatos["Modalidade"] == "M"){
				$row_msg_contatos["Modalidade"] = "Mensal";
			}else{
				$row_msg_contatos["Modalidade"] = "Outros";
			}
		
			if($row_msg_contatos["AVAP"] == "V"){
				$row_msg_contatos["AVAP"] = "NaLoja";
			}elseif($row_msg_contatos["AVAP"] == "O"){
				$row_msg_contatos["AVAP"] = "OnLine";
			}elseif($row_msg_contatos["AVAP"] == "P"){
				$row_msg_contatos["AVAP"] = "NaEntr";
			}else{
				$row_msg_contatos["AVAP"] = "Outros";
			}

			if($row_msg_contatos["TipoFrete"] == 1){
				$row_msg_contatos["TipoFrete"] = "Retirar/NaLoja";
			}elseif($row_msg_contatos["TipoFrete"] == 2){
				$row_msg_contatos["TipoFrete"] = "EmCasa/PelaLoja";
			}elseif($row_msg_contatos["TipoFrete"] == 3){
				$row_msg_contatos["TipoFrete"] = "EmCasa/PeloCorreio";
			}else{
				$row_msg_contatos["TipoFrete"] = "Outros";
			}

			$html .= '<tr>';

			$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';	
			$html .= '<td>'.$row_msg_contatos['DataOrca'] . '</td>';
			
				$html .= '<td>'.$row_msg_contatos['DataEntregaOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['idApp_Cliente'] . '</td>';

				$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
				$html .= '<td>'.$row_msg_contatos['CelularCliente'] . ' / '.$row_msg_contatos['Telefone'] . ' / '.$row_msg_contatos['Telefone2'] . ' / '.$row_msg_contatos['Telefone3'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['CombinadoFrete'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['AprovadoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['ConcluidoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['QuitadoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['FinalizadoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['CanceladoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['Tipo_Orca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['TipoFrete'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['AVAP'] . '</td>';
			
			$html .= '<td>'.$row_msg_contatos['FormaPag'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['Parcela'] . '.</td>';
			
			$html .= '<td>'.$row_msg_contatos['ValorParcela'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['Quitado'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['DataVencimento'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['DataPago'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['DataLanc'] . '</td>';			
			
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
