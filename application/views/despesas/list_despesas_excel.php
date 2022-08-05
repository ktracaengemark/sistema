	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Despesas</title>
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
				foreach ($report->result_array() as $row) {

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