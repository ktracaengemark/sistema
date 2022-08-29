<?php include_once '../../conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cobrancas</title>
	<head>
	<body>
		<?php
			if(isset($_SESSION['log']['idSis_Empresa']) && isset($_SESSION['FiltroCobrancas'])) {
				
				//Selecionar os itens da Tabela
				$data = $_SESSION['FiltroCobrancas'];

				$date_inicio_orca = ($data['DataInicio']) ? 'OT.DataOrca >= "' . $data['DataInicio'] . '" AND ' : FALSE;
				$date_fim_orca = ($data['DataFim']) ? 'OT.DataOrca <= "' . $data['DataFim'] . '" AND ' : FALSE;
				
				$date_inicio_entrega = ($data['DataInicio2']) ? 'PRDS.DataConcluidoProduto >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
				$date_fim_entrega = ($data['DataFim2']) ? 'PRDS.DataConcluidoProduto <= "' . $data['DataFim2'] . '" AND ' : FALSE;

				$hora_inicio_entrega_prd = ($data['HoraInicio5']) ? 'PRDS.HoraConcluidoProduto >= "' . $data['HoraInicio5'] . '" AND ' : FALSE;
				$hora_fim_entrega_prd = ($data['HoraFim5']) ? 'PRDS.HoraConcluidoProduto <= "' . $data['HoraFim5'] . '" AND ' : FALSE;
											
				$date_inicio_vnc = ($data['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
				$date_fim_vnc = ($data['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $data['DataFim3'] . '" AND ' : FALSE;
				
				$date_inicio_vnc_prc = ($data['DataInicio4']) ? 'PR.DataVencimento >= "' . $data['DataInicio4'] . '" AND ' : FALSE;
				$date_fim_vnc_prc = ($data['DataFim4']) ? 'PR.DataVencimento <= "' . $data['DataFim4'] . '" AND ' : FALSE;
				
				$date_inicio_pag_prc = ($data['DataInicio5']) ? 'PR.DataPago >= "' . $data['DataInicio5'] . '" AND ' : FALSE;
				$date_fim_pag_prc = ($data['DataFim5']) ? 'PR.DataPago <= "' . $data['DataFim5'] . '" AND ' : FALSE;
			
				$date_inicio_lan_prc = ($data['DataInicio8']) ? 'PR.DataLanc >= "' . $data['DataInicio8'] . '" AND ' : FALSE;
				$date_fim_lan_prc = ($data['DataFim8']) ? 'PR.DataLanc <= "' . $data['DataFim8'] . '" AND ' : FALSE;
				
				$date_inicio_cadastro = ($data['DataInicio6']) ? 'C.DataCadastroCliente >= "' . $data['DataInicio6'] . '" AND ' : FALSE;
				$date_fim_cadastro = ($data['DataFim6']) ? 'C.DataCadastroCliente <= "' . $data['DataFim6'] . '" AND ' : FALSE;
				
				$orcamento = ($data['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $data['Orcamento'] : FALSE;

				$tipofinanceiro = ($data['TipoFinanceiro']) ? ' AND OT.TipoFinanceiro = ' . $data['TipoFinanceiro'] : FALSE;
				$tipord = ($data['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $data['idTab_TipoRD'] : ' AND OT.idTab_TipoRD = 2';
				$campo = (!$data['Campo']) ? 'OT.idApp_OrcaTrata' : $data['Campo'];
				$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
				$filtro1 = ($data['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $data['AprovadoOrca'] . '" AND ' : FALSE;
				$filtro2 = ($data['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $data['QuitadoOrca'] . '" AND ' : FALSE;
				$filtro3 = ($data['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $data['ConcluidoOrca'] . '" AND ' : FALSE;
				$filtro4 = ($data['Quitado']) ? 'PR.Quitado = "' . $data['Quitado'] . '" AND ' : FALSE;
				$filtro14 = ($data['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $data['ConcluidoProduto'] . '" AND ' : FALSE;
				$filtro5 = ($data['Modalidade']) ? 'OT.Modalidade = "' . $data['Modalidade'] . '" AND ' : FALSE;
				$filtro6 = ($data['FormaPagamento']) ? 'OT.FormaPagamento = "' . $data['FormaPagamento'] . '" AND ' : FALSE;
				$filtro7 = ($data['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $data['Tipo_Orca'] . '" AND ' : FALSE;
				$filtro8 = ($data['TipoFrete']) ? 'OT.TipoFrete = "' . $data['TipoFrete'] . '" AND ' : FALSE;
				$filtro9 = ($data['AVAP']) ? 'OT.AVAP = "' . $data['AVAP'] . '" AND ' : FALSE;
				$filtro10 = ($data['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $data['FinalizadoOrca'] . '" AND ' : FALSE;
				$filtro11 = ($data['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $data['CanceladoOrca'] . '" AND ' : FALSE;
				$filtro13 = ($data['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $data['CombinadoFrete'] . '" AND ' : FALSE;

				if($_SESSION['log']['idSis_Empresa'] != 5){
					if($data['Cliente']){
						$cliente = ' AND OT.idApp_Cliente = ' . $data['Cliente'];
					}else{
						$cliente = FALSE;
					}
					if($data['idApp_Cliente']){
						$id_cliente = ' AND OT.idApp_Cliente = ' . $data['idApp_Cliente'];
					}else{
						$id_cliente = FALSE;
					}				
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
					$cliente = FALSE;
					$id_cliente = FALSE;
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

				$groupby = ($data['Agrupar']) ? 'GROUP BY ' . $data['Agrupar'] . '' : 'GROUP BY PR.idApp_Parcelas';

				$querylimit = FALSE;
				
				$complemento = FALSE;

				$filtro_base = '
						' . $date_inicio_orca . '
						' . $date_fim_orca . '
						' . $date_inicio_entrega . '
						' . $date_fim_entrega . '
						' . $hora_inicio_entrega_prd . '
						' . $hora_fim_entrega_prd . '
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
						' . $parcelas . '
						OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
						OT.idTab_TipoRD = 2
						' . $orcamento . '
						' . $cliente . '
						' . $id_cliente . '
						' . $tipofinanceiro . '
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
						OT.idApp_Cliente,
						OT.Tipo_Orca,
						OT.idSis_Usuario,
						OT.idTab_TipoRD,
						OT.AprovadoOrca,
						OT.CombinadoFrete,
						CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
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
						TFP.FormaPag,
						TR.TipoFinanceiro,
						C.NomeCliente,
						C.CelularCliente,
						C.Telefone,
						C.Telefone2,
						C.Telefone3,
						PR.idApp_Parcelas,
						PR.Parcela,
						PR.DataVencimento,
						PR.ValorParcela,
						PR.DataPago,
						PR.DataLanc,
						PR.Quitado,
						PR.FormaPagamentoParcela
					FROM
						App_OrcaTrata AS OT
							LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
							LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
							LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
							LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
							LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
							LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
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
				$tipo = 'Cobrancas';
				
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
					
					$html .= '<td><b>Pedido</b></td>';
					$html .= '<td><b>DtPedido</b></td>';
					$html .= '<td><b>Cliente</b></td>';
					$html .= '<td><b>Tel</b></td>';
					$html .= '<td><b>Entr.</b></td>';
					$html .= '<td><b>Pago.</b></td>';
					$html .= '<td><b>Pagam.</b></td>';
					$html .= '<td><b>Form.Pag.</b></td>';
					$html .= '<td><b>Pc</b></td>';
					$html .= '<td><b>R$</b></td>';
					$html .= '<td><b>Quitada</b></td>';
					$html .= '<td><b>Vencimento</b></td>';

				$html .= '</tr>';
				
				//Alocando os itens na Tabela
				while($row = mysqli_fetch_assoc($resultado_msg_contatos)){

					$row["ValorParcela"] = number_format($row["ValorParcela"], 2, ',', '.');

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
						$html .= '<td>'.$row['DataOrca'] . '</td>';
						$html .= '<td>'.utf8_encode($row["NomeCliente"]).'</td>';
						$html .= '<td>'.$row['CelularCliente'] . ' / '.$row['Telefone'] . ' / '.$row['Telefone2'] . ' / '.$row['Telefone3'] . '</td>';
						$html .= '<td>'.$row['ConcluidoOrca'] . '</td>';
						$html .= '<td>'.$row['QuitadoOrca'] . '</td>';
						$html .= '<td>'.$row['AVAP'] . '</td>';
						$html .= '<td>'.$row['FormaPag'] . '</td>';
						$html .= '<td>'.$row['Parcela'] . '.</td>';
						$html .= '<td>'.$row['ValorParcela'] . '</td>';
						$html .= '<td>'.$row['Quitado'] . '</td>';
						$html .= '<td>'.$row['DataVencimento'] . '</td>';
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