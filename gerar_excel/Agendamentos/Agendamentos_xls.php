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

		$tipoevento = 'CO.Tipo = ' . $_SESSION['Agendamentos']['TipoEvento'];
		
		$tipo = $_SESSION['Agendamentos']['TipoEvento'];
		
		$cliente 	= ($_SESSION['Agendamentos']['idApp_Cliente']) ? ' AND CO.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] : FALSE;
		$clientepet = ($_SESSION['Empresa']['CadastrarPet'] == "S" && $_SESSION['Agendamentos']['idApp_ClientePet']) ? ' AND CO.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] : FALSE;
		$clientedep = ($_SESSION['Empresa']['CadastrarDep'] == "S" && $_SESSION['Agendamentos']['idApp_ClienteDep']) ? ' AND CO.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep'] : FALSE;

		$usuario 	= ($_SESSION['Agendamentos']['NomeUsuario']) ? ' AND ASS.idSis_Associado = ' . $_SESSION['Agendamentos']['NomeUsuario'] : FALSE;
		
		if($_SESSION['Agendamentos']['TipoEvento'] == 2){
			$campo 	= (!$_SESSION['Agendamentos']['Campo']) ? 'TCAT.Catprod' : $_SESSION['Agendamentos']['Campo'];
		}else{
			$campo 	= (!$_SESSION['Agendamentos']['Campo']) ? 'CO.DataInicio' : $_SESSION['Agendamentos']['Campo'];
		}
		$ordenamento 	= (!$_SESSION['Agendamentos']['Ordenamento']) ? 'ASC' : $_SESSION['Agendamentos']['Ordenamento'];

		($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
		($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;

		$date_inicio_orca 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
		$date_fim_orca 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;

		$groupby = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['Agendamentos']['Agrupar'] != "0") ? 'GROUP BY ' . $_SESSION['Agendamentos']['Agrupar'] . '' : 'GROUP BY CO.idApp_Consulta';

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
									ASS.Nome,
									PRD.NomeProduto,
									PRD.ValorProduto,
									PRD.ObsProduto,
									TCAT.Catprod
								FROM
									App_Consulta AS CO
										LEFT JOIN App_Agenda AS A ON A.idApp_Agenda = CO.idApp_Agenda
										LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
										LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CO.idApp_Cliente
										LEFT JOIN App_ClientePet AS CP ON CP.idApp_ClientePet = CO.idApp_ClientePet
										LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CP.RacaPet
										LEFT JOIN Tab_PeloPet AS PEP ON PEP.idTab_PeloPet = CP.PeloPet
										LEFT JOIN Tab_PortePet AS POP ON POP.idTab_PortePet = CP.PortePet
										LEFT JOIN Tab_EspeciePet AS EPP ON EPP.idTab_EspeciePet = CP.EspeciePet
										LEFT JOIN App_ClienteDep AS CD ON CD.idApp_ClienteDep = CO.idApp_ClienteDep
										LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = CO.idApp_OrcaTrata
										LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
										LEFT JOIN Tab_Produtos AS TPRDS ON TPRDS.idTab_Produtos = PRD.idTab_Produtos_Produto
										LEFT JOIN Tab_Produto AS TPRD ON TPRD.idTab_Produto = TPRDS.idTab_Produto
										LEFT JOIN Tab_Catprod AS TCAT ON TCAT.idTab_Catprod = TPRD.idTab_Catprod
								WHERE
									' . $date_inicio_orca . '
									' . $date_fim_orca . '
									' . $permissao_agenda . '
									CO.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
									' . $tipoevento . '
									' . $cliente . '
									' . $clientepet . '
									' . $clientedep . '
									' . $usuario . '
								' . $groupby . '
								ORDER BY
									' . $campo . '
									' . $ordenamento . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado
		if($tipo == 2){
			$arquivo = 'Agendamentos_Cli_' . date('d-m-Y') . '.xls';
		}else{
			$arquivo = 'Agendamentos_' . date('d-m-Y') . '.xls';
		}
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="2">Planilha de Agendamentos</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Empresa</b></td>';
		$html .= '<td><b>id_Agenda</b></td>';
		$html .= '<td><b>Recor</b></td>';
		$html .= '<td><b>Prof</b></td>';
		$html .= '<td><b>Data Ini</b></td>';
		$html .= '<td><b>Data Fim</b></td>';
		$html .= '<td><b>Hora Ini</b></td>';
		$html .= '<td><b>Hora Fim</b></td>';
		$html .= '<td><b>Evento</b></td>';
		
		if($tipo == 2){
			
			$html .= '<td><b>id_Cliente</b></td>';
			$html .= '<td><b>Cliente</b></td>';
			
			if($sub_cliente == 1){
				
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
				$html .= '<td><b>ObsPet</b></td>';
			
			}elseif($sub_cliente == 2){
				
				$html .= '<td><b>id_Dep</b></td>';
				$html .= '<td><b>Dep</b></td>';
			
			}
			$html .= '<td><b>id_OS</b></td>';
			$html .= '<td><b>Categoria</b></td>';
			$html .= '<td><b>Produto</b></td>';
			$html .= '<td><b>Valor</b></td>';
			$html .= '<td><b>Obs O.S.</b></td>';
			
		}
		
		
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["Empresa"].'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_Consulta"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Recorrencia"].'.</td>';
			$html .= '<td>'.$row_msg_contatos["Nome"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DataInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["DataFim"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraInicio"].'</td>';
			$html .= '<td>'.$row_msg_contatos["HoraFim"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Obs"]).'</td>';
			
			if($tipo == 2){
				
				$html .= '<td>'.$row_msg_contatos["id_Cliente"].'</td>';
				$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
				
				if($sub_cliente == 1){
					
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
				
				}elseif($sub_cliente == 2){
					
					$html .= '<td>'.$row_msg_contatos["idApp_ClienteDep"].'</td>';
					$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClienteDep"]).'</td>';
				
				}
				$html .= '<td>'.$row_msg_contatos["idApp_OrcaTrata"].'</td>';
				$html .= '<td>'.$row_msg_contatos["Catprod"].'</td>';
				$html .= '<td>'.$row_msg_contatos["NomeProduto"].'</td>';
				$html .= '<td>'.$row_msg_contatos["ValorProduto"].'</td>';
				$html .= '<td>'.$row_msg_contatos["ObsProduto"].'</td>';
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
