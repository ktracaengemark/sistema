<?php
	
include_once '../../conexao.php';

		$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;
		
		$date_inicio_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataInicio4']) ? 'PR.DataVencimento >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio4'] . '" AND ' : FALSE;
		$date_fim_vnc_prc = ($_SESSION['FiltroAlteraParcela']['DataFim4']) ? 'PR.DataVencimento <= "' . $_SESSION['FiltroAlteraParcela']['DataFim4'] . '" AND ' : FALSE;
		
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

		
		$id_empresa = ($_SESSION['log']['idSis_Empresa'] != 5) ? ' OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '  ': ' OT.Tipo_Orca = "O" ';
		
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
		
		$orcamento = ($_SESSION['FiltroAlteraParcela']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcamento'] . '  ': FALSE;
		$cliente = ($_SESSION['FiltroAlteraParcela']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['Cliente'] . '' : FALSE;
		$id_cliente = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] . '' : FALSE;
		$fornecedor = ($_SESSION['FiltroAlteraParcela']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['Fornecedor'] . '' : FALSE;
		$id_fornecedor = ($_SESSION['FiltroAlteraParcela']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['FiltroAlteraParcela']['idApp_Fornecedor'] . '' : FALSE;		
		$dia = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
		$mesvenc = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
		$mespag = ($_SESSION['FiltroAlteraParcela']['Mespag']) ? ' AND MONTH(PR.DataPago) = ' . $_SESSION['FiltroAlteraParcela']['Mespag'] : FALSE;
		$ano = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(PR.DataVencimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;
		$tipofinanceiro = ($_SESSION['FiltroAlteraParcela']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroAlteraParcela']['TipoFinanceiro'] : FALSE;
		$id_tipord = ($_SESSION['FiltroAlteraParcela']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['FiltroAlteraParcela']['idTab_TipoRD'] : FALSE;
		$obsorca = ($_SESSION['FiltroAlteraParcela']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['ObsOrca'] : FALSE;
		$orcarec = ($_SESSION['FiltroAlteraParcela']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroAlteraParcela']['Orcarec'] : FALSE;
		$campo = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroAlteraParcela']['Campo'];
		$ordenamento = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
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
		
		$limit = $_SESSION['FiltroAlteraParcela']['Limit'];
		$start = $_SESSION['FiltroAlteraParcela']['Start'];
		
		$querylimit = '';
        if ($limit)
            $querylimit = 'LIMIT ' . $start . ', ' . $limit;

		$result = ('
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
						' . $id_empresa . '
						' . $orcamento . '
						' . $cliente . '
						' . $fornecedor . '
						' . $id_cliente . '
						' . $id_fornecedor . '
						' . $tipofinanceiro . ' 
						' . $id_tipord . '
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
						' . $campo . '
						' . $ordenamento . '
					' . $querylimit . '
		');	
			
		//echo json_encode($result);
		//Seleciona os registros com $conn
		$read_empresa = mysqli_query($conn, $result);
		foreach($read_empresa as $row){		
			
			$data[] 	= array(
				
				'id_cliente' 		=> $row['idApp_Cliente'],
				'nomecliente' 		=> utf8_encode ($row['Cliente']),
				'celularcliente' 		=> $row['CelularCliente'],
				
			);			
		}
		echo json_encode($data);

mysqli_close($conn);
