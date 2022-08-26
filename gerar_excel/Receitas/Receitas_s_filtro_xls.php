<?php include_once '../../conexao.php'; ?>

<?php if(isset($_SESSION['log']['idSis_Empresa'])) { ?>
	
	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Receitas S/Filtros</title>
		<head>
		<body>
			<?php
				//Selecionar os itens da Tabela
				$data = FALSE;

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

				$date_inicio_cadastro = ($data['DataInicio6']) ? 'C.DataCadastroCliente >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
				$date_fim_cadastro = ($data['DataFim6']) ? 'C.DataCadastroCliente <= "' . $data['DataFim6'] . '" AND ' : FALSE;

				$DiaAniv = ($data['DiaAniv']) ? ' AND DAY(C.DataNascimento) = ' . $data['DiaAniv'] : FALSE;
				$MesAniv = ($data['MesAniv']) ? ' AND MONTH(C.DataNascimento) = ' . $data['MesAniv'] : FALSE;
				$AnoAniv = ($data['AnoAniv']) ? ' AND YEAR(C.DataNascimento) = ' . $data['AnoAniv'] : FALSE;

				$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
				$cliente = ($data['Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['Cliente'] . '' : FALSE;
				$id_cliente = ($data['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'] . '' : FALSE;
				$tipofinandeiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
				$idtipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 2';
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

				$filtro17 = ($data['NomeUsuario']) ? 'OT.idSis_Usuario = "' . $data['NomeUsuario'] . '" AND ' : FALSE;

				if($_SESSION['log']['idSis_Empresa'] != 5){
					if($_SESSION['Empresa']['Rede'] == "S"){
						if($_SESSION['Usuario']['Nivel'] == 2){
							$nivel = 'AND OT.NivelOrca = 2';
							$permissao = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
							$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
						}elseif($_SESSION['Usuario']['Nivel'] == 1){
							$nivel = FALSE;
							$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
							if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
								$permissao_orcam = 'OT.id_Funcionario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
							}else{
								$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
							}
						}else{
							$nivel = FALSE;
							$permissao = FALSE;
							$permissao_orcam = FALSE;
						}
					}else{
						if($_SESSION['Usuario']['Permissao_Orcam'] == 1){
							$permissao_orcam = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
						}else{
							$permissao_orcam = FALSE;
						}
						$nivel = FALSE;
						$permissao = FALSE;
					}
					$produtos = ($data['Produtos']) ? 'PRDS.idSis_Empresa ' . $data['Produtos'] . ' AND' : FALSE;
					$parcelas = ($data['Parcelas']) ? 'PR.idSis_Empresa ' . $data['Parcelas'] . ' AND' : FALSE;
				}else{
					$permissao_orcam = FALSE;
					if(isset($data['metodo']) && $data['metodo'] == 3){
						$permissao = 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ';
					}else{
						$permissao = FALSE;
					}
					$nivel = FALSE;
					$produtos = FALSE;
					$parcelas = FALSE;
				}

				$groupby = (isset($data['Agrupar']) && $data['Agrupar'] != "0") ? 'GROUP BY OT.' . $data['Agrupar'] . '' : 'GROUP BY OT.idApp_OrcaTrata';
		
				$querylimit = FALSE;
				
				$complemento = FALSE;

				$filtro_base = '
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
						OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . ' AND
						OT.idTab_TipoRD = 2
						' . $orcamento . '
						' . $cliente . '
						' . $id_cliente . '
						' . $tipofinandeiro . ' 
						' . $DiaAniv . '
						' . $MesAniv . '
						' . $AnoAniv . '
						' . $nivel . '
						' . $complemento . '
					' . $groupby . '
					ORDER BY
						' . $campo . '
						' . $ordenamento . '
					' . $querylimit . '
				';

				$result_msg_contatos = '
					SELECT
						OT.idApp_OrcaTrata,
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
						OT.Modalidade,
						OT.AVAP,
						OT.TipoFrete,
						OT.idSis_Usuario,
						US.Nome,
						CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
						OT.id_Funcionario,
						CONCAT(IFNULL(UF.idSis_Usuario,""), " - " ,IFNULL(UF.Nome,"")) AS NomeFuncionario,
						OT.id_Associado,
						CONCAT(IFNULL(ASS.idSis_Associado,""), " - " ,IFNULL(ASS.Nome,"")) AS NomeAssociado,
						OT.idApp_Cliente,
						CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
						CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
						C.CelularCliente,
						C.DataCadastroCliente,
						C.DataNascimento,
						C.Telefone,
						C.Telefone2,
						C.Telefone3,
						TFP.FormaPag,
						TR.TipoFinanceiro
					FROM
						App_OrcaTrata AS OT
							LEFT JOIN Sis_Usuario AS US ON US.idSis_Usuario = OT.idSis_Usuario
							LEFT JOIN Sis_Usuario AS UF ON UF.idSis_Usuario = OT.id_Funcionario
							LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = OT.id_Associado
							LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
							LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
							LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
							LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
							LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					WHERE
						' . $filtro_base . '
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
				$tipo = 'Receitas sem Filtros';
				
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
				while($row = mysqli_fetch_assoc($resultado_msg_contatos)){

					$row["ValorExtraOrca"] = number_format($row["ValorExtraOrca"], 2, ',', '.');
					$row["ValorRestanteOrca"] = number_format($row["ValorRestanteOrca"], 2, ',', '.');
					$row["ValorFrete"] = number_format($row["ValorFrete"], 2, ',', '.');
					$row["TotalOrca"] = number_format($row["TotalOrca"], 2, ',', '.');
					$row["DescValorOrca"] = number_format($row["DescValorOrca"], 2, ',', '.');
					$row["CashBackOrca"] = number_format($row["CashBackOrca"], 2, ',', '.');
					$row["ValorFinalOrca"] = number_format($row["ValorFinalOrca"], 2, ',', '.');

					if($row["Tipo_Orca"] == "B"){
						$row["Tipo_Orca"] = "Na Loja";
					}elseif($row["Tipo_Orca"] == "O"){
						$row["Tipo_Orca"] = "On Line";
					}else{
						$row["Tipo_Orca"] = "Outros";
					}	
					
					if($row["Modalidade"] == "P"){
						$row["Modalidade"] = "Dividido";
					}elseif($row["Modalidade"] == "M"){
						$row["Modalidade"] = "Mensal";
					}else{
						$row["Modalidade"] = "Outros";
					}
				
					if($row["AVAP"] == "V"){
						$row["AVAP"] = "NaLoja";
					}elseif($row["AVAP"] == "O"){
						$row["AVAP"] = "OnLine";
					}elseif($row["AVAP"] == "P"){
						$row["AVAP"] = "NaEntr";
					}else{
						$row["AVAP"] = "Outros";
					}

					if($row["TipoFrete"] == 1){
						$row["TipoFrete"] = "Retirar/NaLoja";
					}elseif($row["TipoFrete"] == 2){
						$row["TipoFrete"] = "EmCasa/PelaLoja";
					}elseif($row["TipoFrete"] == 3){
						$row["TipoFrete"] = "EmCasa/PeloCorreio";
					}else{
						$row["TipoFrete"] = "Outros";
					}
					
					$html .= '<tr>';
						$html .= '<td>'.$row["idApp_OrcaTrata"].'</td>';
						$html .= '<td>'.$row["DataOrca"].'</td>';
						
						$html .= '<td>'.$row["idApp_".$nome].'</td>';
						$html .= '<td>'.utf8_encode($row[$nome]).'</td>';
						$html .= '<td>'.utf8_encode($row["NomeRec"]).'</td>';
						$html .= '<td>'.$row["TelefoneRec"].'</td>';
						$html .= '<td>'.utf8_encode($row["ParentescoRec"]).'</td>';
						
						$html .= '<td>'.$row["ValorRestanteOrca"].'</td>';
						$html .= '<td>'.$row["ValorFrete"].'</td>';
						$html .= '<td>'.$row["ValorExtraOrca"].'</td>';
						
						$html .= '<td>'.$row["TotalOrca"].'</td>';
						$html .= '<td>'.$row["DescValorOrca"].'</td>';
						$html .= '<td>'.$row["CashBackOrca"].'</td>';
						
						$html .= '<td>'.$row["ValorFinalOrca"].'</td>';
						$html .= '<td>'.utf8_encode($row["NomeColaborador"]).'</td>';
						$html .= '<td>'.$row["CombinadoFrete"].'</td>';
						
						$html .= '<td>'.$row["AprovadoOrca"].'</td>';
						$html .= '<td>'.$row["ConcluidoOrca"].'</td>';
						$html .= '<td>'.$row["QuitadoOrca"].'</td>';
						
						$html .= '<td>'.$row["FinalizadoOrca"].'</td>';
						$html .= '<td>'.$row["CanceladoOrca"].'</td>';
						$html .= '<td>'.$row["Tipo_Orca"].'</td>';
						
						$html .= '<td>'.$row["TipoFrete"].'</td>';
						$html .= '<td>'.$row["AVAP"].'</td>';
						$html .= '<td>'.utf8_encode($row["FormaPag"]).'</td>';
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