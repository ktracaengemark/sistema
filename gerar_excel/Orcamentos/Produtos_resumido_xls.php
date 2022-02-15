<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Produtos e Servicos</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela
		
		$date_inicio_orca = ($_SESSION['Filtro_Vendidos']['DataInicio']) ? 'OT.DataOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($_SESSION['Filtro_Vendidos']['DataFim']) ? 'OT.DataOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim'] . '" AND ' : FALSE;
		
		$date_inicio_entrega = ($_SESSION['Filtro_Vendidos']['DataInicio2']) ? 'OT.DataEntregaOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_entrega = ($_SESSION['Filtro_Vendidos']['DataFim2']) ? 'OT.DataEntregaOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim2'] . '" AND ' : FALSE;
		
		$date_inicio_vnc = ($_SESSION['Filtro_Vendidos']['DataInicio3']) ? 'OT.DataVencimentoOrca >= "' . $_SESSION['Filtro_Vendidos']['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_vnc = ($_SESSION['Filtro_Vendidos']['DataFim3']) ? 'OT.DataVencimentoOrca <= "' . $_SESSION['Filtro_Vendidos']['DataFim3'] . '" AND ' : FALSE;

		$date_inicio_prd_entr = ($_SESSION['Filtro_Vendidos']['DataInicio8']) ? 'PRDS.DataConcluidoProduto >= "' . $_SESSION['Filtro_Vendidos']['DataInicio8'] . '" AND ' : FALSE;
		$date_fim_prd_entr = ($_SESSION['Filtro_Vendidos']['DataFim8']) ? 'PRDS.DataConcluidoProduto <= "' . $_SESSION['Filtro_Vendidos']['DataFim8'] . '" AND ' : FALSE;
		
		$data['Orcamento'] = ($_SESSION['Filtro_Vendidos']['Orcamento']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['Orcamento'] : FALSE;
		$data['Cliente'] = ($_SESSION['Filtro_Vendidos']['Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['Filtro_Vendidos']['Cliente'] : FALSE;
		$data['idApp_Cliente'] = ($_SESSION['Filtro_Vendidos']['idApp_Cliente']) ? ' AND OT.idApp_Cliente = ' . $_SESSION['Filtro_Vendidos']['idApp_Cliente'] : FALSE;
		$data['Fornecedor'] = ($_SESSION['Filtro_Vendidos']['Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['Filtro_Vendidos']['Fornecedor'] : FALSE;
		$data['idApp_Fornecedor'] = ($_SESSION['Filtro_Vendidos']['idApp_Fornecedor']) ? ' AND OT.idApp_Fornecedor = ' . $_SESSION['Filtro_Vendidos']['idApp_Fornecedor'] : FALSE;
		$data['Produtos'] = ($_SESSION['Filtro_Vendidos']['Produtos']) ? ' AND PRDS.idTab_Produtos_Produto = ' . $_SESSION['Filtro_Vendidos']['Produtos'] : FALSE;
		$data['Categoria'] = ($_SESSION['Filtro_Vendidos']['Categoria']) ? ' AND TCAT.idTab_Catprod = ' . $_SESSION['Filtro_Vendidos']['Categoria'] : FALSE;
		$data['TipoFinanceiro'] = ($_SESSION['Filtro_Vendidos']['TipoFinanceiro']) ? ' AND TR.idTab_TipoFinanceiro = ' . $_SESSION['Filtro_Vendidos']['TipoFinanceiro'] : FALSE;
		$data['idTab_TipoRD'] = ($_SESSION['Filtro_Vendidos']['idTab_TipoRD']) ? ' AND OT.idTab_TipoRD = ' . $_SESSION['Filtro_Vendidos']['idTab_TipoRD'] . ' AND PRDS.idTab_TipoRD = ' . $_SESSION['Filtro_Vendidos']['idTab_TipoRD'] : FALSE;
		//$data['ObsOrca'] = ($_SESSION['Filtro_Vendidos']['ObsOrca']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['ObsOrca'] : FALSE;
		$data['Orcarec'] = ($_SESSION['Filtro_Vendidos']['Orcarec']) ? ' AND OT.idApp_OrcaTrata = ' . $_SESSION['Filtro_Vendidos']['Orcarec'] : FALSE;
		$data['Campo'] = (!$_SESSION['Filtro_Vendidos']['Campo']) ? 'TCAT.Catprod' : $_SESSION['Filtro_Vendidos']['Campo'];
		$data['Ordenamento'] = (!$_SESSION['Filtro_Vendidos']['Ordenamento']) ? 'ASC' : $_SESSION['Filtro_Vendidos']['Ordenamento'];
		$filtro1 = ($_SESSION['Filtro_Vendidos']['AprovadoOrca']) ? 'OT.AprovadoOrca = "' . $_SESSION['Filtro_Vendidos']['AprovadoOrca'] . '" AND ' : FALSE;
		$filtro2 = ($_SESSION['Filtro_Vendidos']['QuitadoOrca']) ? 'OT.QuitadoOrca = "' . $_SESSION['Filtro_Vendidos']['QuitadoOrca'] . '" AND ' : FALSE;
		$filtro3 = ($_SESSION['Filtro_Vendidos']['ConcluidoOrca']) ? 'OT.ConcluidoOrca = "' . $_SESSION['Filtro_Vendidos']['ConcluidoOrca'] . '" AND ' : FALSE;
		$filtro17 = ($_SESSION['Filtro_Vendidos']['ConcluidoProduto']) ? 'PRDS.ConcluidoProduto = "' . $_SESSION['Filtro_Vendidos']['ConcluidoProduto'] . '" AND ' : FALSE;
		$filtro18 = ($_SESSION['Filtro_Vendidos']['Prod_Serv_Produto']) ? 'PRDS.Prod_Serv_Produto = "' . $_SESSION['Filtro_Vendidos']['Prod_Serv_Produto'] . '" AND ' : FALSE;
		$filtro5 = ($_SESSION['Filtro_Vendidos']['Modalidade']) ? 'OT.Modalidade = "' . $_SESSION['Filtro_Vendidos']['Modalidade'] . '" AND ' : FALSE;
		$filtro6 = ($_SESSION['Filtro_Vendidos']['FormaPagamento']) ? 'OT.FormaPagamento = "' . $_SESSION['Filtro_Vendidos']['FormaPagamento'] . '" AND ' : FALSE;
		$filtro7 = ($_SESSION['Filtro_Vendidos']['Tipo_Orca']) ? 'OT.Tipo_Orca = "' . $_SESSION['Filtro_Vendidos']['Tipo_Orca'] . '" AND ' : FALSE;
		$filtro8 = ($_SESSION['Filtro_Vendidos']['TipoFrete']) ? 'OT.TipoFrete = "' . $_SESSION['Filtro_Vendidos']['TipoFrete'] . '" AND ' : FALSE;
		$filtro9 = ($_SESSION['Filtro_Vendidos']['AVAP']) ? 'OT.AVAP = "' . $_SESSION['Filtro_Vendidos']['AVAP'] . '" AND ' : FALSE;
		$filtro10 = ($_SESSION['Filtro_Vendidos']['FinalizadoOrca']) ? 'OT.FinalizadoOrca = "' . $_SESSION['Filtro_Vendidos']['FinalizadoOrca'] . '" AND ' : FALSE;
		$filtro11 = ($_SESSION['Filtro_Vendidos']['CanceladoOrca']) ? 'OT.CanceladoOrca = "' . $_SESSION['Filtro_Vendidos']['CanceladoOrca'] . '" AND ' : FALSE;
		$filtro13 = ($_SESSION['Filtro_Vendidos']['CombinadoFrete']) ? 'OT.CombinadoFrete = "' . $_SESSION['Filtro_Vendidos']['CombinadoFrete'] . '" AND ' : FALSE;
		
		$query4 = ($_SESSION['Filtro_Vendidos']['idApp_ClientePet'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClientePet'])) ? 'AND OT.idApp_ClientePet = ' . $_SESSION['Filtro_Vendidos']['idApp_ClientePet'] . '  ' : FALSE;
		$query42 = ($_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClientePet2'])) ? 'AND OT.idApp_ClientePet = ' . $_SESSION['Filtro_Vendidos']['idApp_ClientePet2'] . '  ' : FALSE;
		$query5 = ($_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClienteDep'])) ? 'AND OT.idApp_ClienteDep = ' . $_SESSION['Filtro_Vendidos']['idApp_ClienteDep'] . '  ' : FALSE;
		$query52 = ($_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] && isset($_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'])) ? 'AND OT.idApp_ClienteDep = ' . $_SESSION['Filtro_Vendidos']['idApp_ClienteDep2'] . '  ' : FALSE;			
				
		$permissao = ($_SESSION['log']['idSis_Empresa'] == 5 ) ? 'OT.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ' AND ' : FALSE;
		//$groupby = (1 == 1) ? 'GROUP BY PRDS.idApp_Produto' : FALSE;		
		$groupby = ($_SESSION['Filtro_Vendidos']['Agrupar'] != "0") ? 'GROUP BY ' . $_SESSION['Filtro_Vendidos']['Agrupar'] . '' : FALSE;
		
		$result_msg_contatos = '
								SELECT
									CONCAT(IFNULL(C.idApp_Cliente,""), " - " ,IFNULL(C.NomeCliente,""), " - " ,IFNULL(C.CelularCliente,""), " - " ,IFNULL(C.Telefone,""), " - " ,IFNULL(C.Telefone2,""), " - " ,IFNULL(C.Telefone3,"") ) AS NomeCliente,
									C.NomeCliente AS Cliente,
									CONCAT(IFNULL(F.idApp_Fornecedor,""), " - " ,IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
									F.NomeFornecedor AS Fornecedor,
									OT.idApp_OrcaTrata,
									OT.Tipo_Orca,
									OT.idSis_Usuario,
									OT.idTab_TipoRD,
									OT.AprovadoOrca,
									OT.CombinadoFrete,
									OT.ObsOrca,
									CONCAT(IFNULL(OT.Descricao,"")) AS Descricao,
									OT.DataOrca,
									OT.DataEntradaOrca,
									OT.DataEntregaOrca,
									OT.DataVencimentoOrca,
									OT.ValorEntradaOrca,
									OT.QuitadoOrca,
									OT.ConcluidoOrca,
									OT.FinalizadoOrca,
									OT.CanceladoOrca,
									OT.Modalidade,
									OT.RecorrenciaOrca,
									CPT.NomeClientePet,
									RP.RacaPet,
									CDP.NomeClienteDep,
									TR.TipoFinanceiro,
									MD.Modalidade,
									PRDS.idApp_Produto,
									PRDS.idTab_TipoRD,
									PRDS.NomeProduto,
									PRDS.ValorProduto,
									PRDS.QtdProduto,
									PRDS.QtdIncrementoProduto,
									(PRDS.QtdProduto * PRDS.QtdIncrementoProduto) AS QuantidadeProduto,
									PRDS.ConcluidoProduto,
									PRDS.idTab_Produtos_Produto,
									PRDS.Prod_Serv_Produto,
									PRDS.DataConcluidoProduto AS DataConcluidoProduto,
									PRDS.HoraConcluidoProduto AS HoraConcluidoProduto,
									DATE_FORMAT(PRDS.HoraConcluidoProduto, "%H:%i") AS HoraInicio,
									PRDS.ObsProduto,
									TPRDS.idTab_Produtos,
									TPRDS.Nome_Prod,
									TCAT.idTab_Catprod,
									TCAT.Catprod,
									TAV.AVAP,
									TTF.TipoFrete,
									TFP.FormaPag
								FROM
									App_OrcaTrata AS OT
										LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
										LEFT JOIN App_ClientePet AS CPT ON CPT.idApp_ClientePet = OT.idApp_ClientePet
										LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CPT.RacaPet
										LEFT JOIN App_ClienteDep AS CDP ON CDP.idApp_ClienteDep = OT.idApp_ClienteDep
										LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = OT.idApp_Fornecedor
										LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = OT.idSis_Usuario
										LEFT JOIN App_Produto AS PRDS ON PRDS.idApp_OrcaTrata = OT.idApp_OrcaTrata
										LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRDS.idTab_Produtos_Produto
										LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
										LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
										LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
										LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
										LEFT JOIN Tab_TipoFrete AS TTF ON TTF.idTab_TipoFrete = OT.TipoFrete
										LEFT JOIN Tab_AVAP AS TAV ON TAV.Abrev2 = OT.AVAP
										LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
								WHERE
									' . $date_inicio_orca . '
									' . $date_fim_orca . '
									' . $date_inicio_entrega . '
									' . $date_fim_entrega . '
									' . $date_inicio_vnc . '
									' . $date_fim_vnc . '
									' . $date_inicio_prd_entr . '
									' . $date_fim_prd_entr . '
									' . $permissao . '
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
									' . $filtro18 . '
									OT.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
									PRDS.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' 
									' . $data['Orcamento'] . '
									' . $data['Cliente'] . '
									' . $data['Fornecedor'] . '
									' . $data['idApp_Cliente'] . '
									' . $data['idApp_Fornecedor'] . '
									' . $data['TipoFinanceiro'] . '
									' . $data['idTab_TipoRD'] . '
									' . $data['Produtos'] . '
									' . $data['Categoria'] . '
									' . $query4 . '
									' . $query42 . '
									' . $query5 . '
									' . $query52 . '
								' . $groupby . '
								ORDER BY				
									' . $data['Campo'] . '
									' . $data['Ordenamento'] . '
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

		$arquivo = 'Produtos_Servicos' . date('d-m-Y') . '.xls';

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
		$html .= '<td><b>Recor</b></td>';
		$html .= '<td><b>Categoria</b></td>';
		$html .= '<td><b>Data</b></td>';
		$html .= '<td><b>Hora</b></td>';
		$html .= '<td><b>Cliente</b></td>';
		if($_SESSION['Empresa']['CadastrarPet'] == "S"){
			$html .= '<td><b>Pet</b></td>';
			$html .= '<td><b>Raca</b></td>';
		}else{
			if($_SESSION['Empresa']['CadastrarDep'] == "S"){
				$html .= '<td><b>Dep</b></td>';
			}
		}		
		$html .= '<td><b>ProdServ</b></td>';
		$html .= '<td><b>Obs</b></td>';
		$html .= '<td><b>Valor</b></td>';
		
		
		/*
		$html .= '<td><b>Data Ini</b></td>';
		$html .= '<td><b>Data Fim</b></td>';
		$html .= '<td><b>Hora Ini</b></td>';
		$html .= '<td><b>Hora Fim</b></td>';
		$html .= '<td><b>id_Cliente</b></td>';
		$html .= '<td><b>Cliente</b></td>';
		$html .= '<td><b>id_Pet</b></td>';
		$html .= '<td><b>Pet</b></td>';
		$html .= '<td><b>Especie</b></td>';
		$html .= '<td><b>Sexo</b></td>';
		$html .= '<td><b>Raca</b></td>';
		$html .= '<td><b>Pelo</b></td>';
		$html .= '<td><b>Porte</b></td>';
		$html .= '<td><b>Cor</b></td>';
		$html .= '<td><b>Peso</b></td>';
		$html .= '<td><b>Aler.</b></td>';
		$html .= '<td><b>Obs</b></td>';
		$html .= '<td><b>Evento</b></td>';
		*/
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			/*
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$sub_cliente = $row_msg_contatos["NomeClientePet"];
			}else{
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$sub_cliente = $row_msg_contatos["NomeClienteDep"];
				}else{
					$sub_cliente = FALSE;
				}
			}
			*/
			/*
			echo "<pre>";
			print_r($row_msg_contatos["idApp_OrcaTrata"] . ' - ' . $row_msg_contatos["Catprod"] . ' - ' . $row_msg_contatos["DataConcluidoProduto"] . ' - ' . $row_msg_contatos["HoraConcluidoProduto"] . ' - ' . $sub_cliente . ' - ' . $row_msg_contatos["NomeProduto"]);
			echo "</pre>";
			*/
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';
			$html .= '<td>'.$row_msg_contatos["RecorrenciaOrca"].'.</td>';
			$html .= '<td>'.$row_msg_contatos["Catprod"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DataConcluidoProduto"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraInicio"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Cliente"]).'</td>';
			if($_SESSION['Empresa']['CadastrarPet'] == "S"){
				$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClientePet"]).'</td>';
				$html .= '<td>'.utf8_encode($row_msg_contatos["RacaPet"]).'</td>';
			}else{
				if($_SESSION['Empresa']['CadastrarDep'] == "S"){
					$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClienteDep"]).'</td>';
				}
			}
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeProduto"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ObsProduto"]).'</td>';
			$html .= '<td>'.number_format($row_msg_contatos["ValorProduto"], 2, ',', '.'). '</td>';
			/*
			$html .= '<td>'.$row_msg_contatos["DataInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DataFim"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraFim"].'</td>';
			$html .= '<td>'.$row_msg_contatos["id_Cliente"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_ClientePet"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClientePet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["EspeciePet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["SexoPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["RacaPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["PeloPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["PortePet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["CorPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["PesoPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["AlergicoPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ObsPet"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
			*/
			$html .= '</tr>';
		}
		/*
		exit();
		*/
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
