<?php include_once '../../conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Comissao Supervisor</title>
	<head>
	<body>
		<?php
			if(isset($_SESSION['log']['idSis_Empresa']) && isset($_SESSION['FiltroComissaoFunc'])) {
				
				//Selecionar os itens da Tabela
				$data = $_SESSION['FiltroComissaoFunc'];

				$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
				$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
				
				$date_inicio_entrega = ($data['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
				$date_fim_entrega = ($data['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $data['DataFim2'] . '" AND ' : FALSE;
				
				$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
				$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
				
				if(isset($data['Quitado']) && $data['Quitado'] == "S"){
					$dataref = 'PR.DataPago';
				}else{
					$dataref = 'PR.DataVencimento';
				}
				
				$date_inicio_vnc_prc = ($data['DataInicio4']) ? ''.$dataref.' >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
				$date_fim_vnc_prc = ($data['DataFim4']) ? ''.$dataref.' <= "' . $data['DataFim4'] . '" AND ' : FALSE;
				
				$date_inicio_entrega_prd = ($data['DataInicio5']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
				$date_fim_entrega_prd = ($data['DataFim5']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim5'] . '" AND ' : FALSE;

				$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
				$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;

				$date_inicio_pag_com = ($data['DataInicio7']) ? 'OT.DataPagoComissaoFunc >= "' . $data['DataInicio7'] . '" AND ' : FALSE;
				$date_fim_pag_com = ($data['DataFim7']) ? 'OT.DataPagoComissaoFunc <= "' . $data['DataFim7'] . '" AND ' : FALSE;

				$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] . '  ': FALSE;
				$id_comissaofunc = ($data['id_ComissaoFunc']) ? ' AND OT.id_ComissaoFunc = ' . $data['id_ComissaoFunc'] . '  ': FALSE;
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
				$filtro12 = ($data['StatusComissaoFunc']) ? 'OT.StatusComissaoFunc = "' . $data['StatusComissaoFunc'] . '" AND ' : FALSE;
				$filtro17 = ($data['id_Usuario']) ? 'OT.idSis_Usuario = "' . $data['id_Usuario'] . '" AND ' : FALSE;

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

					if(isset($data['Recibo']) && $data['Recibo'] != 0){
						if($data['Recibo'] == 1){
							$recibo = 'OT.id_ComissaoFunc != 0 AND';
						}elseif($data['Recibo'] == 2){
							$recibo = 'OT.id_ComissaoFunc = 0 AND';
						}else{
							$recibo = FALSE;
						}
					}else{
						$recibo = FALSE;
					}

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
					$recibo = FALSE;
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
						' . $date_inicio_pag_com . '
						' . $date_fim_pag_com . '
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
						' . $filtro12 . '
						' . $produtos . '
						' . $parcelas . '
						' . $recibo . '
						OT.idSis_Empresa= ' . $_SESSION['log']['idSis_Empresa'] . '
						' . $orcamento . '
						' . $id_comissaofunc . '
						' . $cliente . '
						' . $id_cliente . '
						' . $tipofinandeiro . ' 
						' . $idtipord . '
						' . $nivel . '
						' . $complemento . '
					' . $groupby . '
					ORDER BY
						' . $campo . '
						' . $ordenamento . '
					' . $querylimit . '
				';

				$result = '
					SELECT
						OT.idApp_OrcaTrata,
						OT.idSis_Usuario,
						US.Nome,
						CONCAT(IFNULL(US.idSis_Usuario,""), " - " ,IFNULL(US.Nome,"")) AS NomeColaborador,
						OT.id_Associado,
						CONCAT(IFNULL(ASS.idSis_Associado,""), " - " ,IFNULL(ASS.Nome,"")) AS NomeAssociado,
						OT.id_Funcionario,
						CONCAT(IFNULL(UF.idSis_Usuario,""), " - " ,IFNULL(UF.Nome,"")) AS NomeFuncionario,
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
						OT.ValorComissao,
						OT.StatusComissaoOrca,
						OT.DataPagoComissaoOrca,
						OT.id_Comissao,
						OT.ValorComissaoFunc,
						OT.StatusComissaoFunc,
						OT.DataPagoComissaoFunc,
						OT.id_ComissaoFunc,
						OT.Modalidade,
						OT.AVAP,
						OT.TipoFrete,
						OT.idApp_Cliente,
						CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,"")) AS NomeCliente,
						CONCAT(IFNULL(C.NomeCliente,"")) AS Cliente,
						C.CelularCliente,
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
							LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
							LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = OT.id_Associado
							LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
							LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
							LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
							LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					WHERE
						' . $filtro_base . '
				';
				
				$resultado = mysqli_query($conn , $result);
				/*		
				//echo $this->db->last_query();
				echo "<pre>";
				print_r($resultado);
				echo "</pre>";
				exit();
				*/
				
				// Definimos o nome do arquivo que será exportado
				$nome = 'Cliente';
				$tipo = 'Comissão Supervisor';
				
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
					$html .= '<td><b>Compra</b></td>';
					$html .= '<td><b>id_'.$nome.'</b></td>';
					$html .= '<td><b>'.$nome.'</b></td>';

					$html .= '<td><b>Comb.Ent</b></td>';
					$html .= '<td><b>Comb.Pag</b></td>';
					$html .= '<td><b>Entr.</b></td>';
					$html .= '<td><b>Pago</b></td>';
					$html .= '<td><b>Final</b></td>';
					$html .= '<td><b>Canc</b></td>';

					$html .= '<td><b>Prd/Srv</th>';
					
					$html .= '<td><b>Supervisor</th>';
					$html .= '<td><b>ComFunc</th>';
					$html .= '<td><b>Status</th>';
					$html .= '<td><b>DataPago</th>';
					$html .= '<td><b>RecSuper</th>';

					$html .= '<td><b>Func/Vend</b></td>';
					$html .= '<td><b>Ass/Vend</b></td>';
					$html .= '<td><b>Comissao</b></td>';
					$html .= '<td><b>Status</b></td>';
					$html .= '<td><b>DataPago</b></td>';
					$html .= '<td><b>Recibo</b></td>';
				$html .= '</tr>';
				
				//Alocando os itens na Tabela
				while($row = mysqli_fetch_assoc($resultado)){

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
						$html .= '<td>'.$row["Tipo_Orca"].'</td>';
						$html .= '<td>'.$row["idApp_".$nome].'</td>';
						$html .= '<td>'.utf8_encode($row[$nome]).'</td>';

						$html .= '<td>'.$row["CombinadoFrete"].'</td>';
						$html .= '<td>'.$row["AprovadoOrca"].'</td>';
						$html .= '<td>'.$row["ConcluidoOrca"].'</td>';
						$html .= '<td>'.$row["QuitadoOrca"].'</td>';
						$html .= '<td>'.$row["FinalizadoOrca"].'</td>';
						$html .= '<td>'.$row["CanceladoOrca"].'</td>';
						
						$html .= '<td>'.$row['ValorRestanteOrca'].'</td>';
						
						$html .= '<td>'.utf8_encode($row["NomeColaborador"]).'</td>';
						$html .= '<td>'.$row['ValorComissaoFunc'] . '</td>';
						$html .= '<td>'.$row['StatusComissaoFunc'] . '</td>';
						$html .= '<td>'.$row['DataPagoComissaoFunc'] . '</td>';
						$html .= '<td>'.$row['id_ComissaoFunc'] . '</td>';

						$html .= '<td>'.utf8_encode($row["NomeFuncionario"]).'</td>';
						$html .= '<td>'.utf8_encode($row["NomeAssociado"]).'</td>';
						$html .= '<td>'.$row["ValorComissao"].'</td>';
						$html .= '<td>'.$row["StatusComissaoOrca"].'</td>';
						$html .= '<td>'.$row["DataPagoComissaoOrca"].'</td>';
						$html .= '<td>'.$row["id_Comissao"].'</td>';
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
			}
		?>
	</body>
</html>