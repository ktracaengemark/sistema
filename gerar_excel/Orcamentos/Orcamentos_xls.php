<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Orcamentos</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela
		
		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;
			
		$date_inicio_entrega_prd = ($_SESSION['FiltroAlteraParcela']['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio5'] . '" AND ' : FALSE;
		$date_fim_entrega_prd = ($_SESSION['FiltroAlteraParcela']['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['DataFim5'] . '" AND ' : FALSE;

		$hora_inicio_entrega_prd = ($_SESSION['FiltroAlteraParcela']['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $_SESSION['FiltroAlteraParcela']['HoraInicio5'] . '" AND ' : FALSE;
		$hora_fim_entrega_prd = ($_SESSION['FiltroAlteraParcela']['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $_SESSION['FiltroAlteraParcela']['HoraFim5'] . '" AND ' : FALSE;
							
		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		if(isset($_SESSION['FiltroAlteraParcela']['Quitado']) && $_SESSION['FiltroAlteraParcela']['Quitado'] == "S"){
			$dataref = 'PR.DataPago';
		}else{
			$dataref = 'PR.DataVencimento';
		}
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? ''.$dataref.' >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? ''.$dataref.' <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
		if($_SESSION['FiltroAlteraParcela']['nome']){
			if($_SESSION['FiltroAlteraParcela']['nome'] == "Cliente"){
				$cadastro = "C.DataCadastroCliente";
				$aniversario = "C.DataNascimento";
			}elseif($_SESSION['FiltroAlteraParcela']['nome'] == "Fornecedor"){
				$cadastro = "F.DataCadastroFornecedor";
				$aniversario = "F.DataNascimento";
			}
		}else{
			echo "Não existe data de cadastro";
		}
		
		$date_inicio_cadastro = ($_SESSION['FiltroAlteraParcela']['DataInicio6']) ? '' . $cadastro . ' >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio6'] . '" AND ' : FALSE;
		$date_fim_cadastro = ($_SESSION['FiltroAlteraParcela']['DataFim6']) ? '' . $cadastro . ' <= "' . $_SESSION['FiltroAlteraParcela']['DataFim6'] . '" AND ' : FALSE;
		
		$DiaAniv = ($_SESSION['FiltroAlteraParcela']['DiaAniv']) ? ' AND DAY(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['DiaAniv'] : FALSE;
		$MesAniv = ($_SESSION['FiltroAlteraParcela']['MesAniv']) ? ' AND MONTH(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['MesAniv'] : FALSE;
		$AnoAniv = ($_SESSION['FiltroAlteraParcela']['AnoAniv']) ? ' AND YEAR(' . $aniversario . ') = ' . $_SESSION['FiltroAlteraParcela']['AnoAniv'] : FALSE;			
		
		$date_inicio_pag_com = ($_SESSION['FiltroAlteraParcela']['DataInicio7']) ? 'OT.DataPagoComissaoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio7'] . '" AND ' : FALSE;
		$date_fim_pag_com = ($_SESSION['FiltroAlteraParcela']['DataFim7']) ? 'OT.DataPagoComissaoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim7'] . '" AND ' : FALSE;

		
		$data['idSis_Empresa'] = ($_SESSION['log']['idSis_Empresa'] != 5) ? ' OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '  ': ' OT.Tipo_Orca = "O" ';
		
		if(isset($_SESSION['FiltroAlteraParcela']['Associado'])){
			if($_SESSION['FiltroAlteraParcela']['Associado'] == 0){
				$associado = ' AND OT.Associado = 0 ';
			}else{
				$associado = ' AND OT.Associado != 0 ';
			}
		}else{
			$associado = FALSE;
		}
		
		if(isset($_SESSION['FiltroAlteraParcela']['Vendedor'])){
			if($_SESSION['FiltroAlteraParcela']['Vendedor'] == 0){
				$vendedor = ' AND OT.idSis_Usuario = 0 ';
			}else{
				$vendedor = ' AND OT.idSis_Usuario != 0 ';
			}
		}else{
			$vendedor = FALSE;
		}			
		
		$data['Orcamento'] = ($_SESSION['FiltroAlteraParcela']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '  ': FALSE;
		$data['Cliente'] = ($_SESSION['FiltroAlteraParcela']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '' : FALSE;
		$data['idApp_Cliente'] = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '' : FALSE;
		$data['Fornecedor'] = ($_SESSION['FiltroAlteraParcela']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '' : FALSE;
		$data['idApp_Fornecedor'] = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '' : FALSE;		
		$data['Dia'] = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
		$data['Mesvenc'] = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
		$data['Mespag'] = ($_SESSION['FiltroAlteraParcela']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroAlteraParcela']['Mespag'] : FALSE;
		$data['Ano'] = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;
		$data['TipoFinanceiro'] = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] : FALSE;
		$data['idTab_TipoRD'] = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] : FALSE;
		$data['ObsOrca'] = ($_SESSION['FiltroAlteraParcela']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($_SESSION['FiltroAlteraParcela']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcarec'] : FALSE;
		$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
		$data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
		$filtro1 = ($_SESSION['FiltroAlteraParcela']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroAlteraParcela']['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($_SESSION['FiltroAlteraParcela']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroAlteraParcela']['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['FiltroAlteraParcela']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroAlteraParcela']['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro4 = ($_SESSION['FiltroAlteraParcela']['Quitado']) ? 'PR.Quitado = "' . $_SESSION['FiltroAlteraParcela']['Quitado'] . '" AND ' : FALSE;
		$filtro5 = ($_SESSION['FiltroAlteraParcela']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroAlteraParcela']['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($_SESSION['FiltroAlteraParcela']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroAlteraParcela']['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($_SESSION['FiltroAlteraParcela']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroAlteraParcela']['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($_SESSION['FiltroAlteraParcela']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroAlteraParcela']['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($_SESSION['FiltroAlteraParcela']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroAlteraParcela']['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($_SESSION['FiltroAlteraParcela']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroAlteraParcela']['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($_SESSION['FiltroAlteraParcela']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroAlteraParcela']['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($_SESSION['FiltroAlteraParcela']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroAlteraParcela']['CombinadoFrete'] . '" AND ' : FALSE;
		$permissao = ($_SESSION['FiltroAlteraParcela']['metodo'] == 3 && $_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

		if($_SESSION['log']['idSis_Empresa'] != 5){
			$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		}else{
			$permissao_orcam = FALSE;
		}			
		
		$permissao2 = ($_SESSION['FiltroAlteraParcela']['NomeEmpresa']) ? 'OT.idSis_Empresa = "' . $_SESSION['FiltroAlteraParcela']['NomeEmpresa'] . '" AND ' : FALSE;
		$filtro17 = ($_SESSION['FiltroAlteraParcela']['NomeUsuario']) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroAlteraParcela']['NomeUsuario'] . '" AND ' : FALSE;
		$filtro18 = ($_SESSION['FiltroAlteraParcela']['NomeAssociado']) ? 'OT.Associado = "' . $_SESSION['FiltroAlteraParcela']['NomeAssociado'] . '" AND ' : FALSE;
		$filtro12 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca']) ? 'OT.StatusComissaoOrca = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca'] . '" AND ' : FALSE;
		$filtro14 = ($_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online']) ? 'OT.StatusComissaoOrca_Online = "' . $_SESSION['FiltroAlteraParcela']['StatusComissaoOrca_Online'] . '" AND ' : FALSE;
		$groupby = ($_SESSION['FiltroAlteraParcela']['Agrupar'] != "0") ? 'GROUP BY OT.' . $_SESSION['FiltroAlteraParcela']['Agrupar'] . '' : FALSE;
		//$groupby = ($_SESSION['FiltroAlteraParcela']['Agrupar']) ? 'GROUP BY OT.' . $_SESSION['Agrupar'] . '' : FALSE;
		//$ultimopedido1 = ($_SESSION['FiltroAlteraParcela']['Ultimo'] != "0") ? 'LEFT JOIN App_OrcaTrata OT2 ON (OT.idApp_Cliente = OT2.idApp_Cliente AND OT.idApp_OrcaTrata < OT2.idApp_OrcaTrata)' : FALSE;
		//$ultimopedido2 = ($_SESSION['FiltroAlteraParcela']['Ultimo'] != "0") ? 'AND OT2.idApp_OrcaTrata IS NULL' : FALSE;

		$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Produtos'] . ' AND' : FALSE;
		$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroAlteraParcela']['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $_SESSION['FiltroAlteraParcela']['Parcelas'] . ' AND' : FALSE;

		$_SESSION['FiltroAlteraParcela']['nome'] = $_SESSION['FiltroAlteraParcela']['nome'];
		if($_SESSION['FiltroAlteraParcela']['Quitado']){
			if($_SESSION['FiltroAlteraParcela']['Quitado'] == "N"){
				$ref_data = 'DataVencimento';
			}elseif($_SESSION['FiltroAlteraParcela']['Quitado'] == "S"){	
				$ref_data = 'DataPago';
			}
		}else{
			$ref_data = 'DataVencimento';
		}
		if($_SESSION['log']['idSis_Empresa'] != 5){
			if($_SESSION['FiltroAlteraParcela']['Ultimo'] != 0){	
				if($_SESSION['FiltroAlteraParcela']['Ultimo'] == 1){	
					$ultimopedido1 = 'LEFT JOIN App_OrcaTrata AS OT2 ON (OT.idApp_' . $_SESSION['FiltroAlteraParcela']['nome'] . ' = OT2.idApp_' . $_SESSION['FiltroAlteraParcela']['nome'] . ' AND OT.idApp_OrcaTrata < OT2.idApp_OrcaTrata)';
					$ultimopedido2 = 'AND OT2.idApp_OrcaTrata IS NULL';
				}elseif($_SESSION['FiltroAlteraParcela']['Ultimo'] == 2){	
					$ultimopedido1 = 'LEFT JOIN App_Parcelas AS PR2 ON (PR.idApp_' . $_SESSION['FiltroAlteraParcela']['nome'] . ' = PR2.idApp_' . $_SESSION['FiltroAlteraParcela']['nome'] . ' AND PR.' . $ref_data . ' < PR2.' . $ref_data . ')';
					$ultimopedido2 = 'AND PR2.' . $ref_data . ' IS NULL';
				}
			}else{
				$ultimopedido1 = FALSE;
				$ultimopedido2 = FALSE;
			}	
		}else{
			$ultimopedido1 = FALSE;
			$ultimopedido2 = FALSE;
		}

		$comissao1 = ($_SESSION['FiltroAlteraParcela']['metodo'] == 1 && $_SESSION['Usuario']['Permissao_Comissao'] < 2 ) ? 'AND OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
		$comissao2 = ($_SESSION['FiltroAlteraParcela']['metodo'] == 2 && $_SESSION['log']['idSis_Empresa'] == 5 ) ? 'AND OT.Associado = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
		$comissao3 = ($_SESSION['FiltroAlteraParcela']['metodo'] == 2 && $_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Usuario']['Permissao_Comissao'] < 2 ) ? 'AND OT.Associado = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
			
		$result_msg_contatos = '
								SELECT
									CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,""), " - " ,IFNULL(C.CelularCliente,"") ) AS NomeCliente,
									CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
									C.CelularCliente,
									C.DataCadastroCliente,
									C.DataNascimento,
									CONCAT(IFNULL(F.idApp_Fornecedor,""), " - " ,IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
									CONCAT(IFNULL(F.NomeFornecedor,"")) AS Fornecedor,
									F.CelularFornecedor,
									F.DataCadastroFornecedor,
									F.DataNascimento,
									OT.Descricao,
									OT.idSis_Empresa,
									OT.idSis_Usuario,
									OT.idApp_OrcaTrata,
									OT.idApp_Cliente,
									OT.idApp_Fornecedor,
									OT.CombinadoFrete,
									OT.AprovadoOrca,
									OT.FinalizadoOrca,
									OT.CanceladoOrca,
									OT.DataOrca,
									OT.DataEntradaOrca,
									OT.DataEntregaOrca,
									DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
									OT.DataPrazo,
									OT.ValorOrca,
									OT.ValorDev,
									OT.ValorEntradaOrca,
									OT.ValorRestanteOrca,
									OT.ValorTotalOrca,
									OT.DescValorOrca,
									OT.ValorFinalOrca,
									OT.ValorFrete,
									OT.ValorExtraOrca,
									(OT.ValorExtraOrca + OT.ValorRestanteOrca) AS OrcamentoOrca,
									(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
									OT.DataVencimentoOrca,
									OT.ConcluidoOrca,
									OT.QuitadoOrca,
									OT.DataConclusao,
									OT.DataQuitado,
									OT.DataRetorno,
									OT.idTab_TipoRD,
									OT.FormaPagamento,
									OT.ObsOrca,
									OT.QtdParcelasOrca,
									OT.Tipo_Orca,
									OT.Associado,
									OT.ValorComissao,
									OT.CashBackOrca,
									OT.StatusComissaoOrca,
									OT.StatusComissaoOrca_Online,
									OT.DataPagoComissaoOrca,
									OT.NomeRec,
									OT.TelefoneRec,
									OT.ParentescoRec,
									PR.DataVencimento,
									PR.Quitado,
									EMP.NomeEmpresa,
									EMP.Site,
									US.Nome,
									CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
									USA.Nome,
									CONCAT(IFNULL(USA.idSis_Usuario,""), " - " ,IFNULL(USA.Nome,"")) AS NomeAssociado,
									MD.Modalidade,
									VP.Abrev2,
									VP.AVAP,
									TFP.FormaPag,
									TTF.TipoFrete,
									TR.TipoFinanceiro
								FROM
									App_OrcaTrata AS OT
									LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
									LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
									LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
									' . $ultimopedido1 . '
									LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
									LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
									LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
									LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
									LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
									LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = OT.idSis_Empresa
									LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
									LEFT JOIN Sis_Usuario AS USA ON USA.idSis_Usuario = OT.Associado
									LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
								WHERE
									' . $date_inicio_orca . '
									' . $date_fim_orca . '
									' . $date_inicio_entrega . '
									' . $date_fim_entrega . '
									' . $date_inicio_entrega_prd . '
									' . $date_fim_entrega_prd . '
									' . $hora_inicio_entrega_prd . '
									' . $hora_fim_entrega_prd . '
									' . $date_inicio_vnc . '
									' . $date_fim_vnc . '
									' . $date_inicio_vnc_prc . '
									' . $date_fim_vnc_prc . '
									' . $date_inicio_cadastro . '
									' . $date_fim_cadastro . '
									' . $date_inicio_pag_com . '
									' . $date_fim_pag_com . '
									' . $permissao . '
									' . $permissao_orcam . '
									' . $permissao2 . '
									' . $filtro1 . '
									' . $filtro2 . '
									' . $filtro3 . '
									' . $filtro4 . '
									' . $filtro5 . '
									' . $filtro6 . '
									' . $filtro7 . '
									' . $filtro8 . '
									' . $filtro9 . '
									' . $filtro10 . '
									' . $filtro11 . '
									' . $filtro13 . '
									' . $filtro12 . '
									' . $filtro14 . '
									' . $filtro17 . '
									' . $filtro18 . '
									' . $produtos . '
									' . $parcelas . '
									' . $data['idSis_Empresa'] . '
									' . $data['Orcamento'] . '
									' . $data['Cliente'] . '
									' . $data['Fornecedor'] . '
									' . $data['idApp_Cliente'] . '
									' . $data['idApp_Fornecedor'] . '
									' . $data['TipoFinanceiro'] . ' 
									' . $data['idTab_TipoRD'] . '
									' . $ultimopedido2 . '
									' . $comissao1 . '
									' . $comissao2 . '
									' . $comissao3 . '
									' . $associado . '
									' . $vendedor . '
									' . $DiaAniv . '
									' . $MesAniv . '
									' . $AnoAniv . '
								' . $groupby . '
								ORDER BY
									' . $data['Campo'] . '
									' . $data['Ordenamento'] . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);
		/*		
		//echo $this->db->last_query();
		echo "<pre>";
		print_r($resultado_msg_contatos);
		echo "</pre>";
		exit();
		*/
		// Definimos o nome do arquivo que será exportado

		if(isset($_SESSION['FiltroAlteraParcela']['idTab_TipoRD']) ){
			if($_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] == 1){
				$nome = 'Fornecedor';
				$tipo = 'Despesas';
			}else{
				$nome = 'Cliente';
				$tipo = 'Receitas';
			}
		}else{
			$nome = 'Cliente';
				$tipo = 'Receitas';
		}
		/*
		echo "<pre>";
		print_r($_SESSION['FiltroAlteraParcela']['idTab_TipoRD']);
		echo "<br>";
		print_r($nome);
		echo "</pre>";
		exit();	
		*/
		$arquivo = $tipo .'_'. date('d-m-Y') . '.xls';

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
		$html .= '<td><b>id_O.S.</b></td>';
		$html .= '<td><b>DtPedido</b></td>';
		
		$html .= '<td><b>id_'.$nome.'</b></td>';
		$html .= '<td><b>'.$nome.'</b></td>';
		$html .= '<td><b>Recebedor</b></td>';
		$html .= '<td><b>TelRec</b></td>';
		$html .= '<td><b>Relacao</b></td>';
		
		$html .= '<td><b>Prd/Srv</b></td>';
		$html .= '<td><b>Frete</b></td>';
		$html .= '<td><b>Extra</b></td>';
		
		$html .= '<td><b>Total</b></td>';
		$html .= '<td><b>Desc</b></td>';
		$html .= '<td><b>Cash</b></td>';
		
		$html .= '<td><b>Final</b></td>';
		$html .= '<td><b>Colab</b></td>';
		$html .= '<td><b>Comb.Ent</b></td>';
		
		$html .= '<td><b>Comb.Pag</b></td>';
		$html .= '<td><b>Entr.</b></td>';
		$html .= '<td><b>Pago</b></td>';
		
		$html .= '<td><b>Final</b></td>';
		$html .= '<td><b>Canc</b></td>';
		$html .= '<td><b>Compra</b></td>';
		
		$html .= '<td><b>Entrega</b></td>';
		$html .= '<td><b>Pagam.</b></td>';
		$html .= '<td><b>Form.Pag</b></td>';
		
		
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			/*
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$sub_cliente = $row_msg_contatos["NomeClientePet"];
			}else{
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$sub_cliente = $row_msg_contatos["NomeClienteDep"];
				}else{
					$sub_cliente = FALSE;
				}
			}
			
			echo "<pre>";
			print_r($row_msg_contatos["idApp_OrcaTrata"].' - '.$row_msg_contatos["idApp_Cliente"].' - '.$row_msg_contatos["Cliente"]);
			echo "</pre>";
			*/
				
			/*
			//$contagem = count($row->idApp_OrcaTrata);

			
			*/
			$row_msg_contatos["ValorExtraOrca"] = number_format($row_msg_contatos["ValorExtraOrca"], 2, ',', '.');

			$row_msg_contatos["ValorRestanteOrca"] = number_format($row_msg_contatos["ValorRestanteOrca"], 2, ',', '.');

			//$row->OrcamentoOrca = number_format($row->OrcamentoOrca, 2, ',', '.');

			$row_msg_contatos["ValorFrete"] = number_format($row_msg_contatos["ValorFrete"], 2, ',', '.');

			$row_msg_contatos["TotalOrca"] = number_format($row_msg_contatos["TotalOrca"], 2, ',', '.');

			//$row->ValorComissao = number_format($row->ValorComissao, 2, ',', '.');

			$row_msg_contatos["DescValorOrca"] = number_format($row_msg_contatos["DescValorOrca"], 2, ',', '.');

			$row_msg_contatos["CashBackOrca"] = number_format($row_msg_contatos["CashBackOrca"], 2, ',', '.');

			$row_msg_contatos["ValorFinalOrca"] = number_format($row_msg_contatos["ValorFinalOrca"], 2, ',', '.');
						
			
			
			
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DataOrca"].'</td>';
			
			$html .= '<td>'.$row_msg_contatos["idApp_".$nome].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos[$nome]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeRec"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["TelefoneRec"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ParentescoRec"]).'</td>';
			
			$html .= '<td>'.$row_msg_contatos["ValorRestanteOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorFrete"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorExtraOrca"].'</td>';
			
			$html .= '<td>'.$row_msg_contatos["TotalOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DescValorOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["CashBackOrca"].'</td>';
			
			$html .= '<td>'.$row_msg_contatos["ValorFinalOrca"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeColaborador"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["CombinadoFrete"].'</td>';
			
			$html .= '<td>'.$row_msg_contatos["AprovadoOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ConcluidoOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["QuitadoOrca"].'</td>';
			
			$html .= '<td>'.$row_msg_contatos["FinalizadoOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["CanceladoOrca"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Tipo_Orca"].'</td>';
			
			$html .= '<td>'.$row_msg_contatos["TipoFrete"].'</td>';
			$html .= '<td>'.$row_msg_contatos["AVAP"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["FormaPag"]).'</td>';
			
			
			$html .= '</tr>';
		}
		
		//exit();
		
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
