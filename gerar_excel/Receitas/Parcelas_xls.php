<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Parcelas</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		//$arquivo = 'clientes.xls';
		$arquivo = 'Parcelas_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="4">Planilha de Parcelas</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Empresa</b></td>';
		$html .= '<td><b>id_Orc</b></td>';
		$html .= '<td><b>id_Cli</b></td>';
		$html .= '<td><b>Cliente</b></td>';
		/*
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
		$html .= '<td><b>ValorCash</b></td>';
		$html .= '<td><b>Valid.Cash</b></td>';
		*/
		$html .= '</tr>';
		
		//Selecionar os itens da Tabela
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim']) {
            $consulta =
				'(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '")';
        }
        else {
            $consulta =
                '(OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '")';
        }
		
		if ($_SESSION['FiltroAlteraParcela']['DataFim2']) {
            $consulta2 =
				'(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '")';
        }
        else {
            $consulta2 =
                '(OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '")';
        }

		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		$permissao30 = ($_SESSION['FiltroAlteraParcela']['Orcamento'] != "" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '" AND ' : FALSE;
		$permissao31 = ($_SESSION['FiltroAlteraParcela']['Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '" AND ' : FALSE;
		$permissao36 = ($_SESSION['FiltroAlteraParcela']['Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '" AND ' : FALSE;
		$permissao37 = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente'] != "" ) ? 'OT.idApp_Cliente = "' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '" AND ' : FALSE;
		$permissao38 = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] != "" ) ? 'OT.idApp_Fornecedor = "' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '" AND ' : FALSE;
		$permissao13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete'] != "0" ) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca'] != "0" ) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$permissao3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] != "0" ) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca'] != "0" ) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$permissao4 = ($_SESSION['FiltroAlteraParcela']['Quitado'] != "0" ) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$permissao10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] != "0" ) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$permissao11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca'] != "0" ) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		
		$permissao7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca'] != "0" ) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$permissao33 = ($_SESSION['FiltroAlteraParcela']['AVAP'] != "0" ) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$permissao34 = ($_SESSION['FiltroAlteraParcela']['TipoFrete'] != "0" ) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$permissao6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento'] != "0" ) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$permissao32 = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] != "0" ) ? 'OT.TipoFinanceiro = "' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] . '" AND ' : FALSE;
		$permissao35 = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] != "" ) ? 'OT.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND PR.idTab_TipoRD = "' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] . '" AND' : FALSE;
		
		$permissao26 = ($_SESSION['FiltroAlteraParcela']['Mesvenc'] != "0" ) ? 'MONTH(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] . '" AND ' : FALSE;
		$permissao27 = ($_SESSION['FiltroAlteraParcela']['Ano'] != "0" ) ? 'YEAR(PR.DataVencimento) = "' . $_SESSION['FiltroAlteraParcela']['Ano'] . '" AND ' : FALSE;
		$permissao25 = ($_SESSION['FiltroAlteraParcela']['Orcarec'] != "0" ) ? 'OT.idApp_OrcaTrata = "' . $_SESSION['FiltroAlteraParcela']['Orcarec'] . '" AND ' : FALSE;
		$permissao60 = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
        $permissao61 = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];

		$agrupar = $_SESSION['FiltroAlteraParcela']['Agrupar'];
		
		$groupby = ($agrupar != "0") ? 'GROUP BY OT.' . $agrupar . '' : FALSE;		
		
		$result_orcatrata = ('
								SELECT
									C.NomeCliente,
									C.CelularCliente,
									C.Telefone,
									C.Telefone2,
									C.Telefone3,
									C.EnderecoCliente,
									C.NumeroCliente,
									C.ComplementoCliente,
									C.BairroCliente,
									C.CidadeCliente,
									C.EstadoCliente,
									C.ReferenciaCliente,
									F.NomeFornecedor,
									OT.idSis_Empresa,
									OT.idApp_OrcaTrata,
									OT.CombinadoFrete,
									OT.AprovadoOrca,
									OT.ConcluidoOrca,
									OT.QuitadoOrca,
									OT.TipoFrete,
									OT.AVAP,
									OT.FinalizadoOrca,
									OT.CanceladoOrca,
									OT.DataOrca,
									OT.DataPrazo,
									OT.DataConclusao,
									OT.DataQuitado,				
									OT.DataRetorno,
									OT.DataEntradaOrca,
									OT.DataEntregaOrca,
									OT.idApp_Cliente,
									OT.idApp_Fornecedor,
									OT.ValorOrca,
									OT.ValorTotalOrca,
									OT.ValorFinalOrca,
									OT.ValorDev,
									OT.ValorDinheiro,
									OT.ValorTroco,
									OT.ValorEntradaOrca,
									OT.ValorRestanteOrca,
									OT.QtdParcelasOrca,
									OT.DataVencimentoOrca,
									OT.idSis_Usuario,
									OT.ObsOrca,
									OT.Descricao,
									OT.TipoFinanceiro,
									OT.Tipo_Orca,
									OT.NomeRec,
									OT.ParentescoRec,
									FP.FormaPag,				
									EF.NomeEmpresa,
									TAV.AVAP,
									TAV.Abrev2,
									TP.TipoFinanceiro,
									DATE_FORMAT(PR.DataVencimento, "%d/%m/%Y") AS DataVencimento
								FROM 
									App_OrcaTrata AS OT
									LEFT JOIN Sis_Empresa AS EF ON EF.idSis_Empresa = OT.idSis_Empresa
									LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = OT.FormaPagamento
									LEFT JOIN Tab_TipoFinanceiro AS TP ON TP.idTab_TipoFinanceiro = OT.TipoFinanceiro
									LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
									LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
									LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
									LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
								WHERE
									' . $permissao . '		
									' . $permissao1 . '
									' . $permissao2 . '
									' . $permissao3 . '
									' . $permissao4 . '
									' . $permissao6 . '
									' . $permissao7 . '
									' . $permissao10 . '
									' . $permissao11 . '
									' . $permissao13 . '
									' . $permissao30 . '
									' . $permissao31 . '
									' . $permissao32 . '
									' . $permissao33 . '
									' . $permissao34 . '
									' . $permissao35 . '
									' . $permissao36 . '
									' . $permissao37 . '
									' . $permissao38 . '
									' . $date_inicio_orca . '
									' . $date_fim_orca . '
									' . $date_inicio_entrega . '
									' . $date_fim_entrega . '
									' . $date_inicio_vnc . '
									' . $date_fim_vnc . '
									' . $date_inicio_vnc_prc . '
									' . $date_fim_vnc_prc . '
									OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
									PR.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
								' . $groupby . '
								ORDER BY
									' . $permissao60 . '
									' . $permissao61 . ' 
							');
		$resultado_orcatrata = mysqli_query($conn , $result_orcatrata);
		
		while($row_orcatrata = mysqli_fetch_assoc($resultado_orcatrata)){
			
			$result_produtos = ('
									SELECT  
										PV.idSis_Empresa,
										PV.idApp_OrcaTrata,
										PV.idTab_Produto,
										PV.QtdProduto,
										PV.QtdIncrementoProduto,
										(PV.QtdProduto * PV.QtdIncrementoProduto) AS Qtd_Prod,
										PV.DataValidadeProduto,
										PV.ObsProduto,
										PV.idApp_Produto,
										PV.ConcluidoProduto,
										PV.DevolvidoProduto,
										PV.ValorProduto,
										PV.NomeProduto,
										TPS.Nome_Prod
									FROM 
										App_Produto AS PV
											LEFT JOIN Tab_Produtos AS TPS ON TPS.idTab_Produtos = PV.idTab_Produtos_Produto
									WHERE 
										PV.idApp_OrcaTrata = ' . $row_orcatrata["idApp_OrcaTrata"] . ' 
									ORDER BY
										PV.idTab_Produto ASC
								');			
			$resultado_produtos = mysqli_query($conn , $result_produtos);
			
			$result_parcelas = ('
									SELECT  
										PR.idSis_Empresa,
										PR.idApp_OrcaTrata,
										PR.Parcela,
										PR.ValorParcela,
										PR.DataVencimento,
										PR.DataPago,
										PR.Quitado,
										FP.FormaPag
									FROM 
										App_Parcelas AS PR
											LEFT JOIN Tab_FormaPag AS FP ON FP.idTab_FormaPag = PR.FormaPagamentoParcela
									WHERE
										PR.idApp_OrcaTrata = ' . $row_orcatrata["idApp_OrcaTrata"] . ' 
									ORDER BY
										PR.DataVencimento ASC
								');			
			$resultado_parcelas = mysqli_query($conn , $result_parcelas);			

			$html .= '<tr>';
			$html .= '<td>'.$row_orcatrata["idSis_Empresa"].'</td>';
			$html .= '<td>'.$row_orcatrata["idApp_OrcaTrata"].'</td>';
			$html .= '<td>'.$row_orcatrata["idApp_Cliente"].'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["NomeCliente"]).'</td>';
			
			while($row_produtos = mysqli_fetch_assoc($resultado_produtos)){
				
				$html .= '<tr>';
				$html .= '<td></td>';
				$html .= '<td></td>';
				$html .= '<td>'.$row_produtos["Qtd_Prod"].'</td>';
				$html .= '<td>'.utf8_encode($row_produtos["NomeProduto"]).'</td>';
				$html .= '</tr>';
			}			
			
			while($row_parcelas = mysqli_fetch_assoc($resultado_parcelas)){
				
				$html .= '<tr>';
				$html .= '<td></td>';
				$html .= '<td></td>';
				$html .= '<td>'.$row_parcelas["Parcela"].'</td>';
				$html .= '<td>'.$row_parcelas["ValorParcela"].'</td>';
				$html .= '</tr>';
			}			
			/*
			$data_nasc = date('d/m/Y',strtotime($row_orcatrata["DataNascimento"]));
			$html .= '<td>'.$data_nasc.'</td>';
			$html .= '<td>'.$row_orcatrata["Sexo"].'</td>';
			$html .= '<td>'.$row_orcatrata["CelularCliente"].'</td>';
			$html .= '<td>'.$row_orcatrata["Telefone"].'</td>';
			$html .= '<td>'.$row_orcatrata["Telefone2"].'</td>';
			$html .= '<td>'.$row_orcatrata["Telefone3"].'</td>';
			$html .= '<td>'.$row_orcatrata["CepCliente"].'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["EnderecoCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["NumeroCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["ComplementoCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["BairroCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["CidadeCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["EstadoCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["ReferenciaCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["Email"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["Obs"]).'</td>';
			$html .= '<td>'.utf8_encode($row_orcatrata["Ativo"]).'</td>';
			$html .= '<td>'.$row_orcatrata["Motivo"].'</td>';
			$data_cad = date('d/m/Y',strtotime($row_orcatrata["DataCadastroCliente"]));
			$html .= '<td>'.$data_cad.'</td>';
			$html .= '<td>'.$row_orcatrata["CashBackCliente"].'</td>';
			$data_val = date('d/m/Y',strtotime($row_orcatrata["ValidadeCashBack"]));
			$html .= '<td>'.$data_val.'</td>';
			*/
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
