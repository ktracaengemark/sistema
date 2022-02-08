<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Agendamentos</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela

		$tipo = 2;
		$campo 			=  'CO.DataInicio';
		$ordenamento 	=  'ASC';

		if($_SESSION['Empresa']['CadastrarPet'] == "S"){
			$sub_cliente = 1;
		}elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){
			$sub_cliente = 2;
		}else{
			$sub_cliente = 0;
		}
		
		$permissao_agenda = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'CO.idApp_Agenda = ' . $_SESSION['log']['Agenda'] . ' AND ' : FALSE;
		
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
									(P.QtdProduto*P.ValorProduto) AS SubTotalProduto,
									DATE_FORMAT(P.DataConcluidoProduto, "%Y-%m-%d") AS DataProduto,
									DATE_FORMAT(P.HoraConcluidoProduto, "%H:%i") AS HoraProduto,
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
									' . $permissao_agenda . '
									CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
								ORDER BY
									' . $campo . '
									' . $ordenamento . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Agendamentos_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="2">Planilha de Agendamentos</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Empresa</b></td>';
		$html .= '<td><b>Tipo</b></td>';
		$html .= '<td><b>id_Agenda</b></td>';
		$html .= '<td><b>id_Cliente</b></td>';
		if($sub_cliente == 1){
			$html .= '<td><b>id_Pet</b></td>';
		}elseif($sub_cliente == 2){
			$html .= '<td><b>id_Dep</b></td>';
		}
		$html .= '<td><b>id_OS</b></td>';
		$html .= '<td><b>id_Produto</b></td>';
		$html .= '<td><b>Prof</b></td>';
		$html .= '<td><b>Recorrencia</b></td>';
		$html .= '<td><b>Data Ini</b></td>';
		$html .= '<td><b>Data Fim</b></td>';
		$html .= '<td><b>Hora Ini</b></td>';
		$html .= '<td><b>Hora Fim</b></td>';

		$html .= '<td><b>Cliente</b></td>';
		
		if($sub_cliente == 1){
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
		}elseif($sub_cliente == 2){
			$html .= '<td><b>Dep</b></td>';
		}

		$html .= '<td><b>Evento</b></td>';
		$html .= '<td><b>Produto</b></td>';
		$html .= '<td><b>Valor</b></td>';
		$html .= '<td><b>DataProduto</b></td>';
		$html .= '<td><b>HoraProduto</b></td>';
		
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["Empresa"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Tipo"].'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_Consulta"].'</td>';
			$html .= '<td>'.$row_msg_contatos["id_Cliente"].'</td>';
			if($sub_cliente == 1){
				$html .= '<td>'.$row_msg_contatos["idApp_ClientePet"].'</td>';
			}elseif($sub_cliente == 2){
				$html .= '<td>'.$row_msg_contatos["idApp_ClienteDep"].'</td>';
			}
			$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_Produto"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Nome"]).'</td>';
			$html .= '<td>'.$row_msg_contatos["Recorrencia"].'.</td>';
			$html .= '<td>'.$row_msg_contatos["DataInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DataFim"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraFim"].'</td>';

			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
			
			if($sub_cliente == 1){
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
			}elseif($sub_cliente == 2){
				$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClienteDep"]).'</td>';
			}

			$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeProduto"]).'</td>';
			$html .= '<td>'.number_format($row_msg_contatos["SubTotalProduto"], 2, ',', '.'). '</td>';
			$html .= '<td>'.$row_msg_contatos["DataProduto"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraProduto"].'</td>';
			
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
