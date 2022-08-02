	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Cobrancas</title>
		<head>
		<body>
			<?php

				// Definimos o nome do arquivo que será exportado

				$arquivo = $titulo .'_'. date('d-m-Y') . '.xls';

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
					if($metodo != 3){
						$html .= '<td><b>DtEntrega</b></td>';
						$html .= '<td><b>id_Cliente</b></td>';
					}
					$html .= '<td><b>Cliente</b></td>';
					$html .= '<td><b>Tel</b></td>';
					if($metodo != 3){
						$html .= '<td><b>Comb.Ent</b></td>';
						$html .= '<td><b>Comb.Pag</b></td>';
					}	
					$html .= '<td><b>Entr.</b></td>';
					$html .= '<td><b>Pago.</b></td>';
					if($metodo != 3){	
						$html .= '<td><b>Final.</b></td>';
						$html .= '<td><b>Cancel.</b></td>';
						$html .= '<td><b>Compra</b></td>';
						$html .= '<td><b>Entrega</b></td>';
					}
					$html .= '<td><b>Pagam.</b></td>';
					$html .= '<td><b>Form.Pag.</b></td>';
					$html .= '<td><b>Pc</b></td>';
					$html .= '<td><b>R$</b></td>';
					$html .= '<td><b>Quitada</b></td>';
					$html .= '<td><b>Vencimento</b></td>';
					if($metodo != 3){
						$html .= '<td><b>Pagamento</b></td>';
						$html .= '<td><b>Lancamento</b></td>';
					}

				$html .= '</tr>';
				
				//Alocando os itens na Tabela
				foreach ($report->result_array() as $row) {

					$html .= '<tr>';
					
						$html .= '<td>'.$row["idApp_OrcaTrata"].'</td>';	
						$html .= '<td>'.$row['DataOrca'] . '</td>';
						if($metodo != 3){
							$html .= '<td>'.$row['DataEntregaOrca'] . '</td>';
							$html .= '<td>'.$row['idApp_Cliente'] . '</td>';
						}
						$html .= '<td>'.utf8_encode($row["NomeCliente"]).'</td>';
						$html .= '<td>'.$row['CelularCliente'] . ' / '.$row['Telefone'] . ' / '.$row['Telefone2'] . ' / '.$row['Telefone3'] . '</td>';
						if($metodo != 3){	
							$html .= '<td>'.$row['CombinadoFrete'] . '</td>';
							$html .= '<td>'.$row['AprovadoOrca'] . '</td>';
						}
						$html .= '<td>'.$row['ConcluidoOrca'] . '</td>';
						$html .= '<td>'.$row['QuitadoOrca'] . '</td>';
						if($metodo != 3){	
							$html .= '<td>'.$row['FinalizadoOrca'] . '</td>';
							$html .= '<td>'.$row['CanceladoOrca'] . '</td>';
							$html .= '<td>'.$row['Tipo_Orca'] . '</td>';
							$html .= '<td>'.$row['TipoFrete'] . '</td>';
						}
						$html .= '<td>'.$row['AVAP'] . '</td>';
						$html .= '<td>'.$row['FormaPag'] . '</td>';
						$html .= '<td>'.$row['Parcela'] . '.</td>';
						$html .= '<td>'.$row['ValorParcela'] . '</td>';
						$html .= '<td>'.$row['Quitado'] . '</td>';
						$html .= '<td>'.$row['DataVencimento'] . '</td>';
						if($metodo != 3){	
							$html .= '<td>'.$row['DataPago'] . '</td>';
							$html .= '<td>'.$row['DataLanc'] . '</td>';			
						}
						
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