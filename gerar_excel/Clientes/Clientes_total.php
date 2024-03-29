<?php include_once '../../conexao.php';?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Clientes</title>
	<head>
	<body>
		<?php
			if(isset($_SESSION['log']['idSis_Empresa'])) {
				
				//Selecionar os itens da Tabela

				$result_msg_contatos = '
										SELECT * 
										FROM 
											App_Cliente AS C
										WHERE
											C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
										ORDER BY
											C.idApp_Cliente ASC
										';
				$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);
				// Definimos o nome do arquivo que será exportado
				//$arquivo = 'clientes.xls';
				$arquivo = 'Clientes_' . date('d-m-Y') . '.xls';
				
				// Título da Tabela
				$html = '';
				$html .= '<table border="1">';
				/*
				$html .= '<tr>';
				$html .= '<td colspan="3">Planilha de Clientes</tr>';
				$html .= '</tr>';
				*/
				// Campos da Tabela
				$html .= '<tr>';
				$html .= '<td><b>Empresa</b></td>';
				$html .= '<td><b>Ficha</b></td>';
				$html .= '<td><b>id_Cliente</b></td>';
				$html .= '<td><b>Cliente</b></td>';
				$html .= '<td><b>Nasc.</b></td>';
				$html .= '<td><b>Sexo</b></td>';
				$html .= '<td><b>Celular</b></td>';
				$html .= '<td><b>Telefone</b></td>';
				$html .= '<td><b>Telefone2</b></td>';
				$html .= '<td><b>Telefone3</b></td>';
				$html .= '<td><b>CepCliente</b></td>';
				$html .= '<td><b>Endereço</b></td>';
				$html .= '<td><b>NumeroCliente</b></td>';
				$html .= '<td><b>ComplementoCliente</b></td>';
				$html .= '<td><b>Bairro</b></td>';
				$html .= '<td><b>Cidade</b></td>';
				$html .= '<td><b>EstadoCliente</b></td>';
				$html .= '<td><b>ReferenciaCliente</b></td>';
				$html .= '<td><b>Email</b></td>';
				//$html .= '<td><b>Obs</b></td>';
				$html .= '<td><b>Ativo</b></td>';
				$html .= '<td><b>Motivo</b></td>';
				$html .= '<td><b>Cadast.</b></td>';
				$html .= '<td><b>ValorCash</b></td>';
				$html .= '<td><b>Valid.Cash</b></td>';
				$html .= '</tr>';
				
				while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
					$html .= '<tr>';
					$html .= '<td>'.$row_msg_contatos["idSis_Empresa"].'</td>';
					$html .= '<td>'.$row_msg_contatos["RegistroFicha"].'</td>';
					$html .= '<td>'.$row_msg_contatos["idApp_Cliente"].'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
					$data_nasc = date('d/m/Y',strtotime($row_msg_contatos["DataNascimento"]));
					$html .= '<td>'.$data_nasc.'</td>';
					$html .= '<td>'.$row_msg_contatos["Sexo"].'</td>';
					$html .= '<td>'.$row_msg_contatos["CelularCliente"].'</td>';
					$html .= '<td>'.$row_msg_contatos["Telefone"].'</td>';
					$html .= '<td>'.$row_msg_contatos["Telefone2"].'</td>';
					$html .= '<td>'.$row_msg_contatos["Telefone3"].'</td>';
					$html .= '<td>'.$row_msg_contatos["CepCliente"].'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["EnderecoCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["NumeroCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["ComplementoCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["BairroCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["CidadeCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["EstadoCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["ReferenciaCliente"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["Email"]).'</td>';
					//$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["Ativo"]).'</td>';
					$html .= '<td>'.$row_msg_contatos["Motivo"].'</td>';
					$data_cad = date('d/m/Y',strtotime($row_msg_contatos["DataCadastroCliente"]));
					$html .= '<td>'.$data_cad.'</td>';
					$html .= '<td>'.$row_msg_contatos["CashBackCliente"].'</td>';
					$data_val = date('d/m/Y',strtotime($row_msg_contatos["ValidadeCashBack"]));
					$html .= '<td>'.$data_val.'</td>';
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
				mysqli_close($conn);
				exit; 
			}	
		?>
	</body>
</html>