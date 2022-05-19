<?php
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Agendamentos Parcial</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela
		
		$permissao_agenda = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'CO.idApp_Agenda = ' . $_SESSION['log']['Agenda'] . ' AND ' : FALSE;

		if($_SESSION['Empresa']['CadastrarPet'] == "S"){
			$sub_cliente = 1;
		}elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){
			$sub_cliente = 2;
		}else{
			$sub_cliente = 0;
		}

		$tipo = (isset($_SESSION['Agendamentos']['Tipo'])) ? $_SESSION['Agendamentos']['Tipo'] : '0';		
		if(isset($tipo)){
			if($tipo == 2){
				$tipoevento	= 'AND CO.Tipo = 2';	
			}elseif($tipo == 1){
				$tipoevento	= 'AND CO.Tipo = 1';
			}else{
				$tipoevento	= FALSE;
			}
		}else{
			$tipoevento	= FALSE;
		}

		$cliente = ($_SESSION['Agendamentos']['idApp_Cliente'] && isset($_SESSION['Agendamentos']['idApp_Cliente'])) ? 'AND CO.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] . '  ' : FALSE;
		$clientepet = ($_SESSION['Agendamentos']['idApp_ClientePet'] && isset($_SESSION['Agendamentos']['idApp_ClientePet'])) ? 'AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] . '  ' : FALSE;
		$clientepet2 = ($_SESSION['Agendamentos']['idApp_ClientePet2'] && isset($_SESSION['Agendamentos']['idApp_ClientePet2'])) ? 'AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet2'] . '  ' : FALSE;
		$clientedep = ($_SESSION['Agendamentos']['idApp_ClienteDep'] && isset($_SESSION['Agendamentos']['idApp_ClienteDep'])) ? 'AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep'] . '  ' : FALSE;
		$clientedep2 = ($_SESSION['Agendamentos']['idApp_ClienteDep2'] && isset($_SESSION['Agendamentos']['idApp_ClienteDep2'])) ? 'AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep2'] . '  ' : FALSE;		
		$usuario 	= ($_SESSION['Agendamentos']['NomeUsuario']) ? ' AND ASS.idSis_Associado = ' . $_SESSION['Agendamentos']['NomeUsuario'] : FALSE;
		$recorrencia = ($_SESSION['Agendamentos']['Recorrencia'] && isset($_SESSION['Agendamentos']['Recorrencia'])) ? 'AND CO.Recorrencia = "' . $_SESSION['Agendamentos']['Recorrencia'] . '"  ' : FALSE;	
		$repeticao = ($_SESSION['Agendamentos']['Repeticao'] && isset($_SESSION['Agendamentos']['Repeticao'])) ? 'AND CO.Repeticao = "' . $_SESSION['Agendamentos']['Repeticao'] . '"  ' : FALSE;
				
		($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
		($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;

		$date_inicio_orca 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
		$date_fim_orca 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

		if(isset($_SESSION['Agendamentos']['Agrupar'])){
			if($_SESSION['Agendamentos']['Agrupar'] == 1){
				$agrupar = 'CO.idApp_Consulta';
			}elseif($_SESSION['Agendamentos']['Agrupar'] == 2){
				$agrupar = 'P.idApp_Produto';
			}else{
				$agrupar = 'CO.idApp_Consulta';
			}
		}else{
			$agrupar = 'CO.idApp_Consulta';
		}
		
		$groupby = (isset($agrupar)) ? 'GROUP BY ' . $agrupar . '' : 'GROUP BY CO.idApp_Consulta';
		
		$campo 			=  'CO.DataInicio';
		$ordenamento 	=  'ASC';
		
		$result_msg_contatos = '
								SELECT
									CO.*,
									CO.idSis_Empresa AS Empresa,
									DATE_FORMAT(CO.DataInicio, "%Y-%m-%d") AS DataInicio,
									DATE_FORMAT(CO.DataInicio, "%H:%i") AS HoraInicio,
									DATE_FORMAT(CO.DataFim, "%Y-%m-%d") AS DataFim,
									DATE_FORMAT(CO.DataFim, "%H:%i") AS HoraFim,
									P.idApp_Produto,
									P.NomeProduto,
									P.QtdProduto,
									P.ValorProduto,
									CONCAT(IFNULL(P.ObsProduto,"")) AS ObsProduto,
									(P.QtdProduto*P.ValorProduto) AS SubTotalProduto,
									DATE_FORMAT(P.DataConcluidoProduto, "%Y-%m-%d") AS DataProduto,
									DATE_FORMAT(P.HoraConcluidoProduto, "%H:%i") AS HoraProduto,
									CONCAT(IFNULL(TCAT.Catprod,"")) AS Catprod,
									C.idApp_Cliente AS id_Cliente,
									CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
									CP.*,
									CONCAT(IFNULL(CP.NomeClientePet,"")) AS NomeClientePet,
									RP.RacaPet,
									PEP.PeloPet,
									POP.PortePet,
									EPP.EspeciePet,
									CD.*,
									CONCAT(IFNULL(CD.NomeClienteDep,"")) AS NomeClienteDep,
									ASS.Nome
								FROM
									App_Consulta AS CO
										LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = CO.idApp_OrcaTrata
										LEFT JOIN App_Produto AS P ON P.idApp_OrcaTrata = OT.idApp_OrcaTrata
										
										LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = P.idTab_Produtos_Produto
										LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
										LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
										
										LEFT JOIN App_Agenda AS A ON A.idApp_Agenda = CO.idApp_Agenda
										LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
										LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
										LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
										LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CP.RacaPet
										LEFT JOIN Tab_PeloPet AS PEP ON PEP.idTab_PeloPet = CP.PeloPet
										LEFT JOIN Tab_PortePet AS POP ON POP.idTab_PortePet = CP.PortePet
										LEFT JOIN Tab_EspeciePet AS EPP ON EPP.idTab_EspeciePet = CP.EspeciePet
										LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = CO.idApp_ClienteDep
								WHERE
									' . $date_inicio_orca . '
									' . $date_fim_orca . '
									' . $permissao_agenda . '
									CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
									' . $tipoevento . '
									' . $cliente . '
									' . $clientepet . '
									' . $clientepet2 . '
									' . $clientedep . '
									' . $clientedep2 . '
									' . $recorrencia . '
									' . $repeticao . '
									' . $usuario . '
								' . $groupby . '
								ORDER BY
									' . $campo . '
									' . $ordenamento . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Agendamentos_parc_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="2">Agendamentos Parcial</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Repeticao</b></td>';
		$html .= '<td><b>Recor</b></td>';
		$html .= '<td><b>Evento</b></td>';
		$html .= '<td><b>Data Ini</b></td>';
		$html .= '<td><b>Hora Ini</b></td>';
		$html .= '<td><b>Cliente</b></td>';
		if($sub_cliente == 1){
			$html .= '<td><b>Pet</b></td>';
			$html .= '<td><b>Raca</b></td>';
		}elseif($sub_cliente == 2){
			$html .= '<td><b>Dep</b></td>';
		}
		$html .= '<td><b>O.S.</b></td>';
		$html .= '<td><b>Categoria</b></td>';
		$html .= '<td><b>Produto</b></td>';
		$html .= '<td><b>ObsProduto</b></td>';
		$html .= '<td><b>Valor</b></td>';
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["Repeticao"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Recorrencia"].'.</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["DataInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraInicio"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
			if($sub_cliente == 1){
				$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClientePet"]).'</td>';
				$html .= '<td>'.utf8_encode($row_msg_contatos["RacaPet"]).'</td>';
			}elseif($sub_cliente == 2){
				$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClienteDep"]).'</td>';
			}
			$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Catprod"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeProduto"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ObsProduto"]).'</td>';
			$html .= '<td>'.number_format($row_msg_contatos["SubTotalProduto"], 2, ',', '.'). '</td>';
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
