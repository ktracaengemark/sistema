	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Clientes</title>
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
					$html .= '<td><b>Obs</b></td>';
					$html .= '<td><b>Ativo</b></td>';
					$html .= '<td><b>Motivo</b></td>';
					$html .= '<td><b>Cadast.</b></td>';
					$html .= '<td><b>Ult.Pdd.</b></td>';
					$html .= '<td><b>ValorCash</b></td>';
					$html .= '<td><b>Valid.Cash</b></td>';
					
					if(isset($aparecer)){
						if($aparecer == 1){	
							if($_SESSION['Empresa']['CadastrarPet'] == "S"){
								$html .= '<td><b>id_Pet</b></td>';
								$html .= '<td><b>Pet</b></td>';
							}else{
								if($_SESSION['Empresa']['CadastrarDep'] == "S"){
									$html .= '<td><b>id_Dep</b></td>';
									$html .= '<td><b>Dep</b></td>';
								}
							}
						}	
					}else{
						if($_SESSION['Empresa']['CadastrarPet'] == "S"){
							$html .= '<td><b>id_Pet</b></td>';
							$html .= '<td><b>Pet</b></td>';
						}else{
							if($_SESSION['Empresa']['CadastrarDep'] == "S"){
								$html .= '<td><b>id_Dep</b></td>';
								$html .= '<td><b>Dep</b></td>';
							}
						}
					}
				$html .= '</tr>';
				
				//Alocando os itens na Tabela
				foreach ($report->result_array() as $row) {

					$html .= '<tr>';
						
						$html .= '<td>'.$row["idSis_Empresa"].'</td>';
						$html .= '<td>'.$row["RegistroFicha"].'</td>';
						$html .= '<td>'.$row["idApp_Cliente"].'</td>';
						$html .= '<td>'.utf8_encode($row["NomeCliente"]).'</td>';
						$data_nasc = date('d/m/Y',strtotime($row["DataNascimento"]));
						$html .= '<td>'.$data_nasc.'</td>';
						$html .= '<td>'.$row["Sexo"].'</td>';
						$html .= '<td>'.$row["CelularCliente"].'</td>';
						$html .= '<td>'.$row["Telefone"].'</td>';
						$html .= '<td>'.$row["Telefone2"].'</td>';
						$html .= '<td>'.$row["Telefone3"].'</td>';
						
						$html .= '<td>'.$row["CepCliente"].'</td>';
						$html .= '<td>'.utf8_encode($row["EnderecoCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["NumeroCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["ComplementoCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["BairroCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["CidadeCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["EstadoCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["ReferenciaCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["Email"]).'</td>';
						$html .= '<td>'.utf8_encode($row["Obs"]).'</td>';
						$html .= '<td>'.utf8_encode($row["Ativo"]).'</td>';
						$html .= '<td>'.$row["Motivo"].'</td>';
						$data_cad = date('d/m/Y',strtotime($row["DataCadastroCliente"]));
						$html .= '<td>'.$data_cad.'</td>';
						if(!isset($row["UltimoPedido"]) || $row["UltimoPedido"] == "0000-00-00"){
							$dt_ult_pdd = NULL;
						}else{
							$dt_ult_pdd = date('d/m/Y',strtotime($row["UltimoPedido"]));
						}
						$html .= '<td>'.$dt_ult_pdd.'</td>';
						$html .= '<td>'.$row["CashBackCliente"].'</td>';
						$data_val = date('d/m/Y',strtotime($row["ValidadeCashBack"]));
						$html .= '<td>'.$data_val.'</td>';
						
						if(isset($aparecer)){
							if($aparecer == 1){
								if($_SESSION['Empresa']['CadastrarPet'] == "S"){
									$html .= '<td>'.$row["idApp_ClientePet"].'</td>';
									$html .= '<td>'.utf8_encode($row["NomeClientePet"]).'</td>';
								}else{
									if($_SESSION['Empresa']['CadastrarDep'] == "S"){
										$html .= '<td>'.$row["idApp_ClienteDep"].'</td>';
										$html .= '<td>'.utf8_encode($row["NomeClienteDep"]).'</td>';
									}
								}
							}	
						}else{
							if($_SESSION['Empresa']['CadastrarPet'] == "S"){
								$html .= '<td>'.$row["idApp_ClientePet"].'</td>';
								$html .= '<td>'.utf8_encode($row["NomeClientePet"]).'</td>';
							}else{
								if($_SESSION['Empresa']['CadastrarDep'] == "S"){
									$html .= '<td>'.$row["idApp_ClienteDep"].'</td>';
									$html .= '<td>'.utf8_encode($row["NomeClienteDep"]).'</td>';
								}
							}
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