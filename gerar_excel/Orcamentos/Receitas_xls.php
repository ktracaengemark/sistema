<?php include_once '../../conexao.php'; ?>

<?php if(isset($_SESSION['log']['idSis_Empresa']) && isset($_SESSION['FiltroReceitas'])) { ?>
	
	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Orcamentos</title>
		<head>
		<body>
			<?php
				//Selecionar os itens da Tabela
	
				
				$date_inicio_orca = ($_SESSION['FiltroReceitas']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['FiltroReceitas']['DataInicio'] . '" AND ' : FALSE;
				$date_fim_orca = ($_SESSION['FiltroReceitas']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['FiltroReceitas']['DataFim'] . '" AND ' : FALSE;
				
				$date_inicio_entrega = ($_SESSION['FiltroReceitas']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['FiltroReceitas']['DataInicio2'] . '" AND ' : FALSE;
				$date_fim_entrega = ($_SESSION['FiltroReceitas']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['FiltroReceitas']['DataFim2'] . '" AND ' : FALSE;
				
				$date_inicio_entrega_prd = ($_SESSION['FiltroReceitas']['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['FiltroReceitas']['DataInicio5'] . '" AND ' : FALSE;
				$date_fim_entrega_prd = ($_SESSION['FiltroReceitas']['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['FiltroReceitas']['DataFim5'] . '" AND ' : FALSE;

				$hora_inicio_entrega_prd = ($_SESSION['FiltroReceitas']['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $_SESSION['FiltroReceitas']['HoraInicio5'] . '" AND ' : FALSE;
				$hora_fim_entrega_prd = ($_SESSION['FiltroReceitas']['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $_SESSION['FiltroReceitas']['HoraFim5'] . '" AND ' : FALSE;
								
				$date_inicio_vnc = ($_SESSION['FiltroReceitas']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['FiltroReceitas']['DataInicio3'] . '" AND ' : FALSE;
				$date_fim_vnc = ($_SESSION['FiltroReceitas']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['FiltroReceitas']['DataFim3'] . '" AND ' : FALSE;
				
				if(isset($_SESSION['FiltroReceitas']['Quitado']) && $_SESSION['FiltroReceitas']['Quitado'] == "S"){
					$dataref = 'PR.DataPago';
				}else{
					$dataref = 'PR.DataVencimento';
				}
				
				$date_inicio_vnc_prc = ($_SESSION['FiltroReceitas']['DataInicio4']) ? ''.$dataref.' >= "' . $_SESSION['FiltroReceitas']['DataInicio4'] . '" AND ' : FALSE;
				$date_fim_vnc_prc = ($_SESSION['FiltroReceitas']['DataFim4']) ? ''.$dataref.' <= "' . $_SESSION['FiltroReceitas']['DataFim4'] . '" AND ' : FALSE;
				
				if($_SESSION['FiltroReceitas']['nome']){
					if($_SESSION['FiltroReceitas']['nome'] == "Cliente"){
						$cadastro = "C.DataCadastroCliente";
						$aniversario = "C.DataNascimento";
					}
				}else{
					echo "Não existe data de cadastro";
				}
				
				$date_inicio_cadastro = ($_SESSION['FiltroReceitas']['DataInicio6']) ? '' . $cadastro . ' >= "' . $_SESSION['FiltroReceitas']['DataInicio6'] . '" AND ' : FALSE;
				$date_fim_cadastro = ($_SESSION['FiltroReceitas']['DataFim6']) ? '' . $cadastro . ' <= "' . $_SESSION['FiltroReceitas']['DataFim6'] . '" AND ' : FALSE;
				
				$DiaAniv = ($_SESSION['FiltroReceitas']['DiaAniv']) ? ' AND DAY(' . $aniversario . ') = ' . $_SESSION['FiltroReceitas']['DiaAniv'] : FALSE;
				$MesAniv = ($_SESSION['FiltroReceitas']['MesAniv']) ? ' AND MONTH(' . $aniversario . ') = ' . $_SESSION['FiltroReceitas']['MesAniv'] : FALSE;
				$AnoAniv = ($_SESSION['FiltroReceitas']['AnoAniv']) ? ' AND YEAR(' . $aniversario . ') = ' . $_SESSION['FiltroReceitas']['AnoAniv'] : FALSE;			

				$data['Orcamento'] = ($_SESSION['FiltroReceitas']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['FiltroReceitas']['Orcamento'] . '  ': FALSE;
				$data['Cliente'] = ($_SESSION['FiltroReceitas']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroReceitas']['Cliente'] . '' : FALSE;
				$data['idApp_Cliente'] = ($_SESSION['FiltroReceitas']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['FiltroReceitas']['idApp_Cliente'] . '' : FALSE;
				$data['TipoFinanceiro'] = ($_SESSION['FiltroReceitas']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['FiltroReceitas']['TipoFinanceiro'] : FALSE;
				$data['idTab_TipoRD'] = ($_SESSION['FiltroReceitas']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['FiltroReceitas']['idTab_TipoRD'] : FALSE;
				$data['Campo'] = (!$_SESSION['FiltroReceitas']['Campo']) ? 'OT.idApp_OrcaTrata' : $_SESSION['FiltroReceitas']['Campo'];
				$data['Ordenamento'] = (!$_SESSION['FiltroReceitas']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroReceitas']['Ordenamento'];
				$filtro1 = ($_SESSION['FiltroReceitas']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['FiltroReceitas']['AprovadoOrca'] . '" AND ' : FALSE;
				$filtro2 = ($_SESSION['FiltroReceitas']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['FiltroReceitas']['QuitadoOrca'] . '" AND ' : FALSE;
				$filtro3 = ($_SESSION['FiltroReceitas']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['FiltroReceitas']['ConcluidoOrca'] . '" AND ' : FALSE;
				$filtro5 = ($_SESSION['FiltroReceitas']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['FiltroReceitas']['Modalidade'] . '" AND ' : FALSE;
				$filtro6 = ($_SESSION['FiltroReceitas']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['FiltroReceitas']['FormaPagamento'] . '" AND ' : FALSE;
				$filtro7 = ($_SESSION['FiltroReceitas']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['FiltroReceitas']['Tipo_Orca'] . '" AND ' : FALSE;
				$filtro8 = ($_SESSION['FiltroReceitas']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['FiltroReceitas']['TipoFrete'] . '" AND ' : FALSE;
				$filtro9 = ($_SESSION['FiltroReceitas']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['FiltroReceitas']['AVAP'] . '" AND ' : FALSE;
				$filtro10 = ($_SESSION['FiltroReceitas']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['FiltroReceitas']['FinalizadoOrca'] . '" AND ' : FALSE;
				$filtro11 = ($_SESSION['FiltroReceitas']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['FiltroReceitas']['CanceladoOrca'] . '" AND ' : FALSE;
				$filtro13 = ($_SESSION['FiltroReceitas']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['FiltroReceitas']['CombinadoFrete'] . '" AND ' : FALSE;
				$permissao = ($_SESSION['FiltroReceitas']['metodo'] == 3 && $_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;

				if($_SESSION['log']['idSis_Empresa'] != 5){
					$permissao_orcam = ($_SESSION['Usuario']['Permissao_Orcam'] == 1 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND PR.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
				}else{
					$permissao_orcam = FALSE;
				}			
				
				$permissao2 = ($_SESSION['FiltroReceitas']['NomeEmpresa']) ? 'OT.idSis_Empresa = "' . $_SESSION['FiltroReceitas']['NomeEmpresa'] . '" AND ' : FALSE;
				$filtro17 = ($_SESSION['FiltroReceitas']['NomeUsuario']) ? 'OT.idSis_Usuario = "' . $_SESSION['FiltroReceitas']['NomeUsuario'] . '" AND ' : FALSE;

				$groupby = ($_SESSION['FiltroReceitas']['Agrupar'] != "0") ? 'GROUP BY OT.' . $_SESSION['FiltroReceitas']['Agrupar'] . '' : FALSE;

				$produtos = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroReceitas']['Produtos'] != "0") ? 'PRDS.idSis_Empresa ' . $_SESSION['FiltroReceitas']['Produtos'] . ' AND' : FALSE;
				$parcelas = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['FiltroReceitas']['Parcelas'] != "0") ? 'PR.idSis_Empresa ' . $_SESSION['FiltroReceitas']['Parcelas'] . ' AND' : FALSE;

				if($_SESSION['Usuario']['Nivel'] == 0 || $_SESSION['Usuario']['Nivel'] == 1){
					$nivel = 'AND OT.NivelOrca = 1';
				}elseif($_SESSION['Usuario']['Nivel'] == 2){
					$nivel = 'AND OT.NivelOrca = 2';
				}else{
					$nivel = FALSE;
				}
	
				$result_msg_contatos = '
										SELECT
											OT.idApp_OrcaTrata,
											OT.idSis_Usuario,
											OT.CombinadoFrete,
											OT.AprovadoOrca,
											OT.FinalizadoOrca,
											OT.CanceladoOrca,
											OT.ConcluidoOrca,
											OT.QuitadoOrca,
											OT.DataOrca,
											DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
											OT.ValorRestanteOrca,
											OT.DescValorOrca,
											OT.ValorFinalOrca,
											OT.ValorFrete,
											OT.ValorExtraOrca,
											(OT.ValorExtraOrca + OT.ValorRestanteOrca + OT.ValorFrete) AS TotalOrca,
											OT.CashBackOrca,
											OT.idTab_TipoRD,
											OT.Tipo_Orca,
											OT.NomeRec,
											OT.ParentescoRec,
											OT.TelefoneRec,
											CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
											CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
											C.idApp_Cliente,
											C.CelularCliente,
											C.DataCadastroCliente,
											C.DataNascimento,
											C.Telefone,
											C.Telefone2,
											C.Telefone3,
											EMP.NomeEmpresa,
											EMP.Site,
											US.Nome,
											CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
											TFP.FormaPag,
											TR.TipoFinanceiro,
											OT.Modalidade,
											OT.AVAP,
											OT.TipoFrete
										FROM
											App_OrcaTrata AS OT
												LEFT JOIN Sis_Empresa AS EMP ON EMP.idSis_Empresa = OT.idSis_Empresa
												LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
												LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
												LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
												LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
												LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
												LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
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
											' . $permissao . '
											' . $permissao_orcam . '
											' . $permissao2 . '
											' . $filtro1 . '
											' . $filtro2 . '
											' . $filtro3 . '
											' . $filtro5 . '
											' . $filtro6 . '
											' . $filtro7 . '
											' . $filtro8 . '
											' . $filtro9 . '
											' . $filtro10 . '
											' . $filtro11 . '
											' . $filtro13 . '
											' . $filtro17 . '
											' . $produtos . '
											' . $parcelas . '
											OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '
											' . $data['Orcamento'] . '
											' . $data['Cliente'] . '
											' . $data['idApp_Cliente'] . '
											' . $data['TipoFinanceiro'] . ' 
											' . $data['idTab_TipoRD'] . '
											' . $DiaAniv . '
											' . $MesAniv . '
											' . $AnoAniv . '
											' . $nivel . '
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
				$nome = 'Cliente';
				$tipo = 'Receitas';
				
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

					$row_msg_contatos["ValorExtraOrca"] = number_format($row_msg_contatos["ValorExtraOrca"], 2, ',', '.');
					$row_msg_contatos["ValorRestanteOrca"] = number_format($row_msg_contatos["ValorRestanteOrca"], 2, ',', '.');
					$row_msg_contatos["ValorFrete"] = number_format($row_msg_contatos["ValorFrete"], 2, ',', '.');
					$row_msg_contatos["TotalOrca"] = number_format($row_msg_contatos["TotalOrca"], 2, ',', '.');
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
<?php } ?>