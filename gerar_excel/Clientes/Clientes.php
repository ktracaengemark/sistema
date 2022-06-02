<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Clientes</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		//$arquivo = 'clientes.xls';
		$arquivo = 'Clientes_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="3">Planilha de Clientes</tr>';
		$html .= '</tr>';
		
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
		$html .= '</tr>';
		
		//Selecionar os itens da Tabela
			
		if($_SESSION['FiltroClientes']['Pesquisa']){
			if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $_SESSION['FiltroClientes']['Pesquisa'])) {
				$pesquisa = '(DataNascimento = "' . $this->basico->mascara_data($_SESSION['FiltroClientes']['Pesquisa'], 'mysql') . '" OR '
						. 'DataCadastroCliente = "' . $this->basico->mascara_data($_SESSION['FiltroClientes']['Pesquisa'], 'mysql') . '" )';
			}elseif (is_numeric($_SESSION['FiltroClientes']['Pesquisa'])) {
				if($date === TRUE) {
					$pesquisa = '(DataNascimento = "' . substr($_SESSION['FiltroClientes']['Pesquisa'], 4, 4).'-'.substr($_SESSION['FiltroClientes']['Pesquisa'], 2, 2).'-'.substr($_SESSION['FiltroClientes']['Pesquisa'], 0, 2) . '" OR '
							. 'DataCadastroCliente = "' . substr($_SESSION['FiltroClientes']['Pesquisa'], 4, 4).'-'.substr($_SESSION['FiltroClientes']['Pesquisa'], 2, 2).'-'.substr($_SESSION['FiltroClientes']['Pesquisa'], 0, 2) . '" )';
				}else{
					if((strlen($_SESSION['FiltroClientes']['Pesquisa'])) < 6){
						$pesquisa = 'RegistroFicha like "' . $_SESSION['FiltroClientes']['Pesquisa'] . '"';
					}elseif(strlen($_SESSION['FiltroClientes']['Pesquisa']) >= 6 && strlen($_SESSION['FiltroClientes']['Pesquisa']) <= 7){
						$pesquisa = 'idApp_Cliente like "' . $_SESSION['FiltroClientes']['Pesquisa'] . '"';
						
					}else{
						$pesquisa = '(CelularCliente like "%' . $_SESSION['FiltroClientes']['Pesquisa'] . '%" OR '
								. 'Telefone like "%' . $_SESSION['FiltroClientes']['Pesquisa'] . '%" OR '
								. 'Telefone2 like "%' . $_SESSION['FiltroClientes']['Pesquisa'] . '%" OR '
								. 'Telefone3 like "%' . $_SESSION['FiltroClientes']['Pesquisa'] . '%" )';
					}
				}			
			}else{
				$pesquisa = '(NomeCliente like "%' . $_SESSION['FiltroClientes']['Pesquisa'] . '%" )';
			}
			$pesquisar = 'AND ' . $pesquisa;
		}else{
			$pesquisar = FALSE;
		}
				
		$date_inicio_orca = ($_SESSION['FiltroClientes']['DataInicio']) ? 'C.DataCadastroCliente >= "' . $_SESSION['FiltroClientes']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['FiltroClientes']['DataFim']) ? 'C.DataCadastroCliente <= "' . $_SESSION['FiltroClientes']['DataFim'] . '" AND ' : FALSE;

		$date_inicio_cash = ($_SESSION['FiltroClientes']['DataInicio2']) ? 'C.ValidadeCashBack >= "' . $_SESSION['FiltroClientes']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_cash = ($_SESSION['FiltroClientes']['DataFim2']) ? 'C.ValidadeCashBack <= "' . $_SESSION['FiltroClientes']['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_ultimo = ($_SESSION['FiltroClientes']['DataInicio3']) ? 'C.UltimoPedido >= "' . $_SESSION['FiltroClientes']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_ultimo = ($_SESSION['FiltroClientes']['DataFim3']) ? 'C.UltimoPedido <= "' . $_SESSION['FiltroClientes']['DataFim3'] . '" AND ' : FALSE;		

		$data['Dia'] = ($_SESSION['FiltroClientes']['Dia']) ? ' AND DAY(C.DataNascimento) = ' . $_SESSION['FiltroClientes']['Dia'] : FALSE;
		$data['Mesvenc'] = ($_SESSION['FiltroClientes']['Mesvenc']) ? ' AND MONTH(C.DataNascimento) = ' . $_SESSION['FiltroClientes']['Mesvenc'] : FALSE;
		$data['Ano'] = ($_SESSION['FiltroClientes']['Ano']) ? ' AND YEAR(C.DataNascimento) = ' . $_SESSION['FiltroClientes']['Ano'] : FALSE;

		if(isset($_SESSION['FiltroClientes']['Sexo'])){
			if($_SESSION['FiltroClientes']['Sexo'] == 0){
				$sexo = FALSE;
			}elseif($_SESSION['FiltroClientes']['Sexo'] == 1){
				$sexo = 'C.Sexo = "M" AND ';
			}elseif($_SESSION['FiltroClientes']['Sexo'] == 2){
				$sexo = 'C.Sexo = "F" AND ';
			}elseif($_SESSION['FiltroClientes']['Sexo'] == 3){
				$sexo = 'C.Sexo = "O" AND ';
			}
		}else{
			$sexo = FALSE;
		}
		
		if(isset($_SESSION['FiltroClientes']['Pedidos'])){
			if($_SESSION['FiltroClientes']['Pedidos'] == 0){
				$pedidos = FALSE;
			}elseif($_SESSION['FiltroClientes']['Pedidos'] == 1){
				$pedidos = 'C.UltimoPedido = "0000-00-00" AND ';
			}elseif($_SESSION['FiltroClientes']['Pedidos'] == 2){
				$pedidos = 'C.UltimoPedido != "0000-00-00" AND ';
			}
		}else{
			$pedidos = FALSE;
		}
		
		//$data['NomeCliente'] = ($_SESSION['FiltroClientes']['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroClientes']['NomeCliente'] : FALSE;
		$data['idApp_Cliente'] = ($_SESSION['FiltroClientes']['idApp_Cliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroClientes']['idApp_Cliente'] : FALSE;
		$data['Campo'] = (!$_SESSION['FiltroClientes']['Campo']) ? 'C.NomeCliente' : $_SESSION['FiltroClientes']['Campo'];
		$data['Ordenamento'] = (!$_SESSION['FiltroClientes']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroClientes']['Ordenamento'];
		$filtro10 = ($_SESSION['FiltroClientes']['Ativo'] != '#') ? 'C.Ativo = "' . $_SESSION['FiltroClientes']['Ativo'] . '" AND ' : FALSE;
		$filtro20 = ($_SESSION['FiltroClientes']['Motivo'] != '0') ? 'C.Motivo = "' . $_SESSION['FiltroClientes']['Motivo'] . '" AND ' : FALSE;
		$groupby = ($_SESSION['FiltroClientes']['Agrupar'] != "0") ? 'GROUP BY C.' . $_SESSION['FiltroClientes']['Agrupar'] . '' : FALSE;

		$result_msg_contatos = '
								SELECT * 
								FROM 
									App_Cliente AS C
								WHERE
									' . $date_inicio_orca . '
									' . $date_fim_orca . '
									' . $date_inicio_cash . '
									' . $date_fim_cash . '
									' . $date_inicio_ultimo . '
									' . $date_fim_ultimo . '
									' . $filtro10 . '
									' . $filtro20 . '
									' . $pedidos . '
									' . $sexo . '
									C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
									' . $data['idApp_Cliente'] . ' 
									' . $data['Dia'] . ' 
									' . $data['Mesvenc'] . '
									' . $data['Ano'] . '
									' . $pesquisar . '
								' . $groupby . '
								ORDER BY
									' . $data['Campo'] . '
									' . $data['Ordenamento'] . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);
		
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
			$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Ativo"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["Motivo"].'</td>';
			$data_cad = date('d/m/Y',strtotime($row_msg_contatos["DataCadastroCliente"]));
			$html .= '<td>'.$data_cad.'</td>';
			if(!isset($row_msg_contatos["UltimoPedido"]) || $row_msg_contatos["UltimoPedido"] == "0000-00-00"){
				$dt_ult_pdd = NULL;
			}else{
				$dt_ult_pdd = date('d/m/Y',strtotime($row_msg_contatos["UltimoPedido"]));
			}
			$html .= '<td>'.$dt_ult_pdd.'</td>';
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
		exit; 
		?>
	</body>
</html>
