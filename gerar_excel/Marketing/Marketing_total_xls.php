<?php
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Marketing</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela
		$date_inicio_prc = ($_SESSION['FiltroMarketing']['DataInicio9']) ? 'PRC.DataMarketing >= "' . $_SESSION['FiltroMarketing']['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($_SESSION['FiltroMarketing']['DataFim9']) ? 'PRC.DataMarketing <= "' . $_SESSION['FiltroMarketing']['DataFim9'] . '" AND ' : FALSE;
		
		$date_inicio_sub_prc = ($_SESSION['FiltroMarketing']['DataInicio10']) ? 'SPRC.DataSubMarketing >= "' . $_SESSION['FiltroMarketing']['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($_SESSION['FiltroMarketing']['DataFim10']) ? 'SPRC.DataSubMarketing <= "' . $_SESSION['FiltroMarketing']['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($_SESSION['FiltroMarketing']['HoraInicio9']) ? 'PRC.HoraMarketing >= "' . $_SESSION['FiltroMarketing']['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($_SESSION['FiltroMarketing']['HoraFim9']) ? 'PRC.HoraMarketing <= "' . $_SESSION['FiltroMarketing']['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($_SESSION['FiltroMarketing']['HoraInicio10']) ? 'SPRC.HoraSubMarketing >= "' . $_SESSION['FiltroMarketing']['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($_SESSION['FiltroMarketing']['HoraFim10']) ? 'SPRC.HoraSubMarketing <= "' . $_SESSION['FiltroMarketing']['HoraFim10'] . '" AND ' : FALSE;
		
		$data['Dia'] = ($_SESSION['FiltroMarketing']['Dia']) ? ' AND DAY(PRC.DataMarketing) = ' . $_SESSION['FiltroMarketing']['Dia'] : FALSE;
		$data['Mesvenc'] = ($_SESSION['FiltroMarketing']['Mesvenc']) ? ' AND MONTH(PRC.DataMarketing) = ' . $_SESSION['FiltroMarketing']['Mesvenc'] : FALSE;
		$data['Ano'] = ($_SESSION['FiltroMarketing']['Ano']) ? ' AND YEAR(PRC.DataMarketing) = ' . $_SESSION['FiltroMarketing']['Ano'] : FALSE;
		$data['Campo'] = (!$_SESSION['FiltroMarketing']['Campo']) ? 'PRC.DataMarketing' : $_SESSION['FiltroMarketing']['Campo'];
		$data['Ordenamento'] = (!$_SESSION['FiltroMarketing']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroMarketing']['Ordenamento'];
		
		$filtro10 = ($_SESSION['FiltroMarketing']['ConcluidoMarketing'] != '#') ? 'PRC.ConcluidoMarketing = "' . $_SESSION['FiltroMarketing']['ConcluidoMarketing'] . '" AND ' : FALSE;
		
		$filtro21 = ($_SESSION['FiltroMarketing']['idTab_TipoRD'] == 1) ? 'AND (OT.idTab_TipoRD = "1" OR F.idApp_Fornecedor = PRC.idApp_Fornecedor)' : FALSE;
		$filtro22 = ($_SESSION['FiltroMarketing']['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
		
		$data['idApp_Marketing'] = ($_SESSION['FiltroMarketing']['idApp_Marketing']) ? ' AND PRC.idApp_Marketing = ' . $_SESSION['FiltroMarketing']['idApp_Marketing'] . '  ': FALSE;		
		$data['Sac'] = ($_SESSION['FiltroMarketing']['Sac']) ? ' AND PRC.Sac = ' . $_SESSION['FiltroMarketing']['Sac'] . '  ': FALSE;		
		$data['CategoriaMarketing'] = ($_SESSION['FiltroMarketing']['CategoriaMarketing']) ? ' AND PRC.CategoriaMarketing = ' . $_SESSION['FiltroMarketing']['CategoriaMarketing'] . '  ': FALSE;
		$data['Orcamento'] = ($_SESSION['FiltroMarketing']['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $_SESSION['FiltroMarketing']['Orcamento'] . '  ': FALSE;
		$data['Cliente'] = ($_SESSION['FiltroMarketing']['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['Cliente'] . '' : FALSE;
		$data['idApp_Cliente'] = ($_SESSION['FiltroMarketing']['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['idApp_Cliente'] . '' : FALSE;
		$data['Fornecedor'] = ($_SESSION['FiltroMarketing']['Fornecedor']) ? ' AND PRC.idApp_Fornecedor = ' . $_SESSION['FiltroMarketing']['Fornecedor'] . '' : FALSE;
		$data['idApp_Fornecedor'] = ($_SESSION['FiltroMarketing']['idApp_Fornecedor']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroMarketing']['idApp_Fornecedor'] . '' : FALSE;        
		$filtro17 = ($_SESSION['FiltroMarketing']['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $_SESSION['FiltroMarketing']['NomeUsuario'] . '" AND ' : FALSE;        
		$filtro18 = ($_SESSION['FiltroMarketing']['Compartilhar']) ? 'PRC.Compartilhar = "' . $_SESSION['FiltroMarketing']['Compartilhar'] . '" AND ' : FALSE;		
		
		$data['TipoMarketing'] = $_SESSION['FiltroMarketing']['TipoMarketing'];

		$groupby = ($_SESSION['FiltroMarketing']['Agrupar'] && $_SESSION['FiltroMarketing']['Agrupar'] != "0") ? 'GROUP BY PRC.' . $_SESSION['FiltroMarketing']['Agrupar'] . '' : FALSE;
		

			
		$result_msg_contatos = '
            SELECT
				PRC.idSis_Empresa,
				PRC.idApp_Marketing,
                PRC.Marketing,
				PRC.DataMarketing,
				PRC.HoraMarketing,
				PRC.ConcluidoMarketing,
				PRC.idApp_Cliente,
				PRC.idApp_Fornecedor,
				PRC.idApp_OrcaTrata,
				PRC.Compartilhar,
				PRC.Sac,
				PRC.CategoriaMarketing,
				SPRC.SubMarketing,
				SPRC.ConcluidoSubMarketing,
				SPRC.DataSubMarketing,
				SPRC.HoraSubMarketing,
				OT.idTab_TipoRD,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
				CONCAT(IFNULL(F.NomeFornecedor,"")) AS NomeFornecedor,
				U.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				SU.idSis_Usuario,
				SU.Nome AS NomeSubUsuario,
				AU.idSis_Usuario,
				AU.Nome AS NomeCompartilhar
            FROM
				App_Marketing AS PRC
					LEFT JOIN App_SubMarketing AS SPRC ON SPRC.idApp_Marketing = PRC.idApp_Marketing
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
					LEFT JOIN App_Fornecedor AS F ON F.idApp_Fornecedor = PRC.idApp_Fornecedor
					LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = PRC.idSis_Usuario
					LEFT JOIN Sis_Usuario AS AU ON AU.idSis_Usuario = PRC.Compartilhar
					LEFT JOIN Sis_Usuario AS SU ON SU.idSis_Usuario = SPRC.idSis_Usuario
            WHERE
                ' . $date_inicio_prc . '
                ' . $date_fim_prc . '
                ' . $date_inicio_sub_prc . '
                ' . $date_fim_sub_prc . '
                ' . $hora_inicio_prc . '
                ' . $hora_fim_prc . '
                ' . $hora_inicio_sub_prc . '
                ' . $hora_fim_sub_prc . '
				' . $filtro10 . '
				' . $filtro17 . '
				' . $filtro18 . '
				PRC.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
				PRC.idApp_OrcaTrata = 0 AND 
				PRC.idApp_Cliente != 0 AND 
				PRC.idApp_Fornecedor = 0 AND 
				PRC.Sac = 0 AND 
				PRC.CategoriaMarketing != 0 
                ' . $filtro21 . ' 
                ' . $filtro22 . '
                ' . $data['idApp_Marketing'] . '
                ' . $data['Sac'] . '
                ' . $data['CategoriaMarketing'] . '
                ' . $data['Orcamento'] . '
                ' . $data['Cliente'] . '
                ' . $data['Fornecedor'] . '
                ' . $data['idApp_Cliente'] . '
                ' . $data['idApp_Fornecedor'] . '
			' . $groupby . '
            ORDER BY
                ' . $data['Campo'] . ' 
				' . $data['Ordenamento'] . '
		';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Marketing_total_' . date('d-m-Y') . '.xls';

		// Título da Tabela
		$html = '';
		$html .= '<table border="1">';
		/*
		$html .= '<tr>';
		$html .= '<td colspan="2">Planilha de Sac</tr>';
		$html .= '</tr>';
		*/
		// Campos da Tabela
		$html .= '<tr>';
			$html .= '<td><b>Quem_Cadastrou</b></td>';
			$html .= '<td><b>Data</b></td>';
			$html .= '<td><b>Hora</b></td>';
			$html .= '<td><b>id_Mark</b></td>';
			$html .= '<td><b>Tipo</b></td>';
			$html .= '<td><b>id_Cliente</b></td>';
			$html .= '<td><b>Cliente</b></td>';
			$html .= '<td><b>Descrição</b></td>';
			$html .= '<td><b>Quem_Fazer</b></td>';
			$html .= '<td><b>Concluída?</b></td>';
			$html .= '<td><b>Ação</b></td>';
			$html .= '<td><b>Data</b></td>';
			$html .= '<td><b>Hora</b></td>';
			$html .= '<td><b>Quem_Fez</b></td>';
			$html .= '<td><b>Concluída?</b></td>';					
		$html .= '</tr>';
		
		//Alocando os itens na Tabela
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){

			if($row_msg_contatos["CategoriaMarketing"] == 1){
				$row_msg_contatos["CategoriaMarketing"] = 'Atualização';
			}elseif($row_msg_contatos["CategoriaMarketing"] == 2){
				$row_msg_contatos["CategoriaMarketing"] = 'Pesquisa';
			}elseif($row_msg_contatos["CategoriaMarketing"] == 3){
				$row_msg_contatos["CategoriaMarketing"] = 'Retorno';
			}elseif($row_msg_contatos["CategoriaMarketing"] == 4){
				$row_msg_contatos["CategoriaMarketing"] = 'Promoções';
			}elseif($row_msg_contatos["CategoriaMarketing"] == 5){
				$row_msg_contatos["CategoriaMarketing"] = 'Felicitações';
			}			
			
			$html .= '<tr>';
				$html .= '<td>'.$row_msg_contatos['NomeUsuario'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['DataMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['HoraMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['idApp_Marketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['CategoriaMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['idApp_Cliente'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['NomeCliente'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['Marketing'] . '</td>';	
				$html .= '<td>'.$row_msg_contatos['NomeCompartilhar'] . '</td>';					
				$html .= '<td>'.$row_msg_contatos['ConcluidoMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['SubMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['DataSubMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['HoraSubMarketing'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['NomeSubUsuario'] . '</td>';							
				$html .= '<td>'.$row_msg_contatos['ConcluidoSubMarketing'] . '</td>';		
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
