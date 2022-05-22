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
		
		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;
					
		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		$date_inicio_pag_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio5']) ? 'PR.DataPago >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_pag_prc = ($_SESSION['FiltroAlteraParcela']['DataFim5']) ? 'PR.DataPago <= "' . $_SESSION['FiltroAlteraParcela']['DataFim5'] . '" AND ' : FALSE;
		
		$date_inicio_lan_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio8']) ? 'PR.DataLanc >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_lan_prc = ($_SESSION['FiltroAlteraParcela']['DataFim8']) ? 'PR.DataLanc <= "' . $_SESSION['FiltroAlteraParcela']['DataFim8'] . '" AND ' : FALSE;
					
		$date_inicio_cadastro = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? 'C.DataCadastroCliente >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio6'] . '" AND ' : FALSE;
		$date_fim_cadastro = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? 'C.DataCadastroCliente <= "' . $_SESSION['FiltroAlteraParcela']['DataFim6'] . '" AND ' : FALSE;
		
		$data['Orcamento'] = ($_SESSION['FiltroAlteraParcela']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcamento'] : FALSE;
		$data['Cliente'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['Cliente'] : FALSE;
		$data['idApp_Cliente'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] : FALSE;
		$data['Fornecedor'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] : FALSE;
		$data['idApp_Fornecedor'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] : FALSE;
		$data['Dia'] = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
		$data['Mesvenc'] = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
		$data['Mespag'] = ($_SESSION['FiltroAlteraParcela']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroAlteraParcela']['Mespag'] : FALSE;
		$data['Ano'] = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;
		$data['TipoFinanceiro'] = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] : FALSE;
		$data['idTab_TipoRD'] = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . ' AND PR.idTab_TipoRD = ' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] : FALSE;
		$data['ObsOrca'] = ($_SESSION['FiltroAlteraParcela']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($_SESSION['FiltroAlteraParcela']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcarec'] : FALSE;
		$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
		$data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
		$filtro1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($_SESSION['FiltroAlteraParcela']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$filtro14 = ($_SESSION['FiltroAlteraParcela']['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro5 = ($_SESSION['FiltroAlteraParcela']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($_SESSION['FiltroAlteraParcela']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($_SESSION['FiltroAlteraParcela']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		if($_SESSION['log']['idSis_Empresa'] != 5){
			$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		}else{
			$permissao_orcam = FALSE;
		}			

		$groupby = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Agrupar'] != "0") ? 'GROUP BY ' . $_SESSION['FiltroAlteraParcela']['Agrupar'] . '' : 'GROUP BY PR.idApp_Parcelas';
		
		$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Produtos'] . ' AND' : FALSE;

		$_SESSION['FiltroAlteraParcela']['nome'] = $_SESSION['FiltroAlteraParcela']['nome'];


			
		$result_msg_contatos = '
            SELECT
				CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,""), " - " ,IFNULL(C.CelularCliente,""), " - " ,IFNULL(C.Telefone,""), " - " ,IFNULL(C.Telefone2,""), " - " ,IFNULL(C.Telefone3,"") ) AS NomeCliente,
                CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
                C.CelularCliente,
				CONCAT(IFNULL(C.CelularCliente,""), " - " ,IFNULL(C.Telefone,""), " - " ,IFNULL(C.Telefone2,""), " - " ,IFNULL(C.Telefone3,"") ) AS TelCliente,
				C.DataCadastroCliente,
				CONCAT(IFNULL(F.idApp_Fornecedor,""), " - " ,IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
                CONCAT(IFNULL(F.NomeFornecedor,"")) AS Fornecedor,
				F.CelularFornecedor,
				F.DataCadastroFornecedor,
				OT.idApp_OrcaTrata,
				OT.idApp_Cliente,
				OT.idApp_Fornecedor,
				OT.Tipo_Orca,
				OT.idSis_Usuario,
				OT.idTab_TipoRD,
                OT.AprovadoOrca,
                OT.CombinadoFrete,
				OT.ObsOrca,
				CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
                OT.DataOrca,
                OT.DataEntradaOrca,
                OT.DataEntregaOrca,
                OT.DataVencimentoOrca,
                OT.ValorEntradaOrca,
				OT.QuitadoOrca,
				OT.ConcluidoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.Modalidade,
				TR.TipoFinanceiro,
				MD.Modalidade,
                PR.idApp_Parcelas,
                PR.idSis_Empresa,
				PR.idSis_Usuario,
				PR.idApp_Cliente,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                PR.DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.DataLanc,
                PR.ValorPago,
                PR.Quitado,
				PR.idTab_TipoRD,
				PRDS.DataConcluidoProduto,
				PRDS.ConcluidoProduto,
				TAV.AVAP,
				TTF.TipoFrete,
				TFP.FormaPag
            FROM
                App_OrcaTrata AS OT
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
					LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
            WHERE
                ' . $date_inicio_orca . '
                ' . $date_fim_orca . '
                ' . $date_inicio_entrega . '
                ' . $date_fim_entrega . '
                ' . $date_inicio_vnc . '
                ' . $date_fim_vnc . '
                ' . $date_inicio_vnc_prc . '
                ' . $date_fim_vnc_prc . '
                ' . $date_inicio_pag_prc . '
                ' . $date_fim_pag_prc . '
                ' . $date_inicio_lan_prc . '
                ' . $date_fim_lan_prc . '
                ' . $date_inicio_cadastro . '
                ' . $date_fim_cadastro . '
                OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				' . $permissao . '
				' . $permissao_orcam . '
				' . $filtro1 . '
				' . $filtro2 . '
				' . $filtro3 . '
				' . $filtro4 . '
				' . $filtro14 . '
				' . $filtro5 . '
				' . $filtro6 . '
				' . $filtro7 . '
				' . $filtro8 . '
				' . $filtro9 . '
				' . $filtro10 . '
				' . $filtro11 . '
				' . $filtro13 . '
				' . $produtos . '
                PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['idApp_Fornecedor'] . '
				' . $data['TipoFinanceiro'] . '
				' . $data['idTab_TipoRD'] . '
			' . $groupby . '
			ORDER BY
				' . $data['Campo'] . '
				' . $data['Ordenamento'] . '
		';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Parcelas_Rec_total_' . date('d-m-Y') . '.xls';

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
			$html .= '<td><b>Entr.</b></td>';
			$html .= '<td><b>Pago.</b></td>';
			$html .= '<td><b>Pagam.</b></td>';
		
		$html .= '<td><b>Form.Pag.</b></td>';
		$html .= '<td><b>Pc</b></td>';
		
		$html .= '<td><b>Parc.R$</b></td>';
		$html .= '<td><b>Quitada</b></td>';
		$html .= '<td><b>Vencimento</b></td>';	

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
			
			$html .= '<tr>';

			$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';	
			$html .= '<td>'.$row_msg_contatos['DataOrca'] . '</td>';
			
				$html .= '<td>'.$row_msg_contatos['DataEntregaOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['idApp_Cliente'] . '</td>';

				$html .= '<td>'.utf8_encode($row_msg_contatos["Cliente"]).'</td>';
				$html .= '<td>'.$row_msg_contatos['TelCliente'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['ConcluidoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['QuitadoOrca'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['AVAP'] . '</td>';
			
			$html .= '<td>'.$row_msg_contatos['FormaPag'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['Parcela'] . '.</td>';
			
			$html .= '<td>'.$row_msg_contatos['ValorParcela'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['Quitado'] . '</td>';
			$html .= '<td>'.$row_msg_contatos['DataVencimento'] . '</td>';			
			
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
