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

				$data = $_SESSION['FiltroReceitas'];
				if($data){

					$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
					$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
					
					$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
					$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
					
					$date_inicio_entrega_prd = ($data['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
					$date_fim_entrega_prd = ($data['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim5'] . '" AND ' : FALSE;

					$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
					$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;
									
					$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
					$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
					
					if(isset($data['Quitado']) && $data['Quitado'] == "S"){
						$dataref = 'PR.DataPago';
					}else{
						$dataref = 'PR.DataVencimento';
					}
					
					$date_inicio_vnc_prc = ($data['DataInicio4']) ? ''.$dataref.' >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
					$date_fim_vnc_prc = ($data['DataFim4']) ? ''.$dataref.' <= "' . $data['DataFim4'] . '" AND ' : FALSE;
					
					if($data['nome']){
						if($data['nome'] == "Cliente"){
							$cadastro = "C.DataCadastroCliente";
							$aniversario = "C.DataNascimento";
						}
					}else{
						echo "Não existe data de cadastro";
					}
					
					$date_inicio_cadastro = ($data['DataInicio6']) ? '' . $cadastro . ' >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
					$date_fim_cadastro = ($data['DataFim6']) ? '' . $cadastro . ' <= "' . $data['DataFim6'] . '" AND ' : FALSE;

					$DiaAniv = ($data['DiaAniv']) ? ' AND DAY(' . $aniversario . ') = ' . $data['DiaAniv'] : FALSE;
					$MesAniv = ($data['MesAniv']) ? ' AND MONTH(' . $aniversario . ') = ' . $data['MesAniv'] : FALSE;
					$AnoAniv = ($data['AnoAniv']) ? ' AND YEAR(' . $aniversario . ') = ' . $data['AnoAniv'] : FALSE;

					$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
					$cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
					$id_cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
					$tipofinandeiro = ($data['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
					$idtipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : FALSE;
					$campo = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
					$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
					$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
					$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
					$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
					$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
					$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
					$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
					$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
					$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
					$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
					$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
					$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;

					$permissao2 = ($data['NomeEmpresa']) ? 'OT.idSis_Empresa = "' . $data['NomeEmpresa'] . '" AND ' : FALSE;
					$filtro17 = ($data['NomeUsuario']) ? 'OT.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;

					$groupby = ($data['Agrupar'] != "0") ? 'GROUP BY OT.' . $data['Agrupar'] . '' : FALSE;

					if($_SESSION['log']['idSis_Empresa'] != 5){
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
						if($data['Produtos'] != "0"){
							$produtos = 'PRDS.idSis_Empresa ' . $data['Produtos'] . ' AND';
						}else{
							$produtos = FALSE;
						}
						if($data['Parcelas'] != "0"){
							$parcelas = 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND';
						}else{
							$parcelas = FALSE;
						}
					}else{
						$permissao_orcam = FALSE;
						if($data['metodo'] == 3){
							$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
						}else{
							$permissao = FALSE;
						}
						$nivel = FALSE;
						$produtos = FALSE;
						$parcelas = FALSE;
						$rede = FALSE;
					}		
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
											OT.DataEntregaOrca,
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
											OT.idApp_Cliente,
											CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
											CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
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
												' . $rede . '
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
											' . $orcamento . '
											' . $cliente . '
											' . $id_cliente . '
											' . $tipofinandeiro . ' 
											' . $idtipord . '
											' . $DiaAniv . '
											' . $MesAniv . '
											' . $AnoAniv . '
											' . $nivel . '
										' . $groupby . '
										ORDER BY
											' . $campo . '
											' . $ordenamento . '
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
				$tipo = 'Receitas com Filtros';
				
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