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
				}else{
					$permissao_orcam = FALSE;
					$permissao = FALSE;
					$nivel = FALSE;
					$rede = FALSE;
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
											' . $permissao . '
											' . $permissao_orcam . '
											OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
											OT.idTab_TipoRD = 2
											' . $nivel . '
										GROUP BY 
											OT.idApp_OrcaTrata
										ORDER BY
											OT.idApp_OrcaTrata
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