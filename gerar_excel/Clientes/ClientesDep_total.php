<?php
	//session_start();
	//include_once('conexao.php');
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Deps</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela

		$campo 			=  'CD.idApp_ClienteDep';
		$ordenamento 	=  'ASC';

		$result_msg_contatos = '
								SELECT
									CD.*,
									CONCAT(IFNULL(CD.NomeClienteDep,"")) AS NomeClienteDep,
									C.idApp_Cliente AS id_Cliente,
									CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
									RE.Relacao
								FROM
									App_ClienteDep AS CD
									LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = CD.idApp_Cliente
									LEFT JOIN Tab_Relacao AS RE ON RE.idTab_Relacao = CD.RelacaoDep
								WHERE
									CD.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '
								ORDER BY
									' . $campo . '
									' . $ordenamento . '
								';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Deps_' . date('d-m-Y') . '.xls';
		
		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="2">Planilha de Deps</tr>';
		$html .= '</tr>';
		
		// Campos da Tabela
		$html .= '<tr>';
		$html .= '<td><b>Empresa</b></td>';
		$html .= '<td><b>id_Cliente</b></td>';
		$html .= '<td><b>id_Dep</b></td>';
		$html .= '<td><b>Cliente</b></td>';
		$html .= '<td><b>Dep</b></td>';
		$html .= '<td><b>Sexo</b></td>';
		$html .= '<td><b>Relacao</b></td>';
		$html .= '<td><b>Obs</b></td>';
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["idSis_Empresa"].'</td>';
			$html .= '<td>'.$row_msg_contatos["id_Cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["idApp_ClienteDep"].'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeCliente"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["NomeClienteDep"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["SexoDep"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["Relacao"]).'</td>';
			$html .= '<td>'.utf8_encode($row_msg_contatos["ObsDep"]).'</td>';
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
