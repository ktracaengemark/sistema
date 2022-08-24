	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Comissão</title>
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
				foreach ($report->result_array() as $row) {

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
			
			?>
		</body>
	</html>