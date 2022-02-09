<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Pets</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela

		$campo 			=  'CP.idApp_ClientePet';
		$ordenamento 	=  'ASC';

		$result_msg_contatos = '
								SELECT
									CP.*,
									CONCAT(IFNULL(CP.NomeClientePet,"")) AS NomeClientePet,
									C.idApp_Cliente AS id_Cliente,
									CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
									RP.RacaPet,
									PEP.PeloPet,
									POP.PortePet,
									EPP.EspeciePet
								FROM
									App_ClientePet AS CP
									LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CP.idApp_Cliente
									LEFT JOIN Tab_RacaPet AS RP ON RP.idTab_RacaPet = CP.RacaPet
									LEFT JOIN Tab_PeloPet AS PEP ON PEP.idTab_PeloPet = CP.PeloPet
									LEFT JOIN Tab_PortePet AS POP ON POP.idTab_PortePet = CP.PortePet
									LEFT JOIN Tab_EspeciePet AS EPP ON EPP.idTab_EspeciePet = CP.EspeciePet
								WHERE
									CP.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
								ORDER BY
									' . $campo . '
									' . $ordenamento . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Pets_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="2">Planilha de Pets</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Empresa</b></td>';
		$html .= '<td><b>id_Cliente</b></td>';
		$html .= '<td><b>id_Pet</b></td>';
		$html .= '<td><b>Cliente</b></td>';
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
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["idSis_Empresa"].'</td>';
			$html .= '<td>'.$row_msg_contatos["id_Cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_ClientePet"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
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
