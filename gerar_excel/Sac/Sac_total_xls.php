<?php
	include_once '../../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Sac</title>
	<head>
	<body>
		<?php
		
		//Selecionar os itens da Tabela
					
		$date_inicio_prc = ($_SESSION['FiltroSac']['DataInicio9']) ? 'PRC.DataSac >= "' . $_SESSION['FiltroSac']['DataInicio9'] . '" AND ' : FALSE;
		$date_fim_prc = ($_SESSION['FiltroSac']['DataFim9']) ? 'PRC.DataSac <= "' . $_SESSION['FiltroSac']['DataFim9'] . '" AND ' : FALSE;
		
		$date_inicio_sub_prc = ($_SESSION['FiltroSac']['DataInicio10']) ? 'SPRC.DataSubSac >= "' . $_SESSION['FiltroSac']['DataInicio10'] . '" AND ' : FALSE;
		$date_fim_sub_prc = ($_SESSION['FiltroSac']['DataFim10']) ? 'SPRC.DataSubSac <= "' . $_SESSION['FiltroSac']['DataFim10'] . '" AND ' : FALSE;

		$hora_inicio_prc = ($_SESSION['FiltroSac']['HoraInicio9']) ? 'PRC.HoraSac >= "' . $_SESSION['FiltroSac']['HoraInicio9'] . '" AND ' : FALSE;
		$hora_fim_prc = ($_SESSION['FiltroSac']['HoraFim9']) ? 'PRC.HoraSac <= "' . $_SESSION['FiltroSac']['HoraFim9'] . '" AND ' : FALSE;
		
		$hora_inicio_sub_prc = ($_SESSION['FiltroSac']['HoraInicio10']) ? 'SPRC.HoraSubSac >= "' . $_SESSION['FiltroSac']['HoraInicio10'] . '" AND ' : FALSE;
		$hora_fim_sub_prc = ($_SESSION['FiltroSac']['HoraFim10']) ? 'SPRC.HoraSubSac <= "' . $_SESSION['FiltroSac']['HoraFim10'] . '" AND ' : FALSE;
		
		$campo = (!$_SESSION['FiltroSac']['Campo']) ? 'PRC.DataSac' : $_SESSION['FiltroSac']['Campo'];
		$ordenamento = (!$_SESSION['FiltroSac']['Ordenamento']) ? 'DESC' : $_SESSION['FiltroSac']['Ordenamento'];
		
		$filtro10 = ($_SESSION['FiltroSac']['ConcluidoSac'] != '#') ? 'PRC.ConcluidoSac = "' . $_SESSION['FiltroSac']['ConcluidoSac'] . '" AND ' : FALSE;
		
		$filtro22 = ($_SESSION['FiltroSac']['idTab_TipoRD'] == 2) ? 'AND (OT.idTab_TipoRD = "2" OR C.idApp_Cliente = PRC.idApp_Cliente)' : FALSE;
		
		$id_sac = ($_SESSION['FiltroSac']['idApp_Sac']) ? ' AND PRC.idApp_Sac = ' . $_SESSION['FiltroSac']['idApp_Sac'] . '  ': FALSE;		
		$categoria_sac = ($_SESSION['FiltroSac']['CategoriaSac']) ? ' AND PRC.CategoriaSac = ' . $_SESSION['FiltroSac']['CategoriaSac'] . '  ': FALSE;		
		$marketing = ($_SESSION['FiltroSac']['Marketing']) ? ' AND PRC.Marketing = ' . $_SESSION['FiltroSac']['Marketing'] . '  ': FALSE;
		$orcamento = ($_SESSION['FiltroSac']['Orcamento']) ? ' AND PRC.idApp_OrcaTrata = ' . $_SESSION['FiltroSac']['Orcamento'] . '  ': FALSE;
		$cliente = ($_SESSION['FiltroSac']['Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroSac']['Cliente'] . '' : FALSE;
		$id_cliente = ($_SESSION['FiltroSac']['idApp_Cliente']) ? ' AND PRC.idApp_Cliente = ' . $_SESSION['FiltroSac']['idApp_Cliente'] . '' : FALSE;       
		$filtro17 = ($_SESSION['FiltroSac']['NomeUsuario']) ? 'PRC.idSis_Usuario = "' . $_SESSION['FiltroSac']['NomeUsuario'] . '" AND ' : FALSE;        
		$filtro18 = ($_SESSION['FiltroSac']['Compartilhar']) ? 'PRC.Compartilhar = "' . $_SESSION['FiltroSac']['Compartilhar'] . '" AND ' : FALSE;		

		$groupby = ($_SESSION['FiltroSac']['Agrupar'] && $_SESSION['FiltroSac']['Agrupar'] != "0") ? 'GROUP BY PRC.' . $_SESSION['FiltroSac']['Agrupar'] . '' : FALSE;

		$result_msg_contatos = '
            SELECT
				PRC.idSis_Empresa,
				PRC.idApp_Sac,
                PRC.Sac,
				PRC.DataSac,
				PRC.HoraSac,
				PRC.ConcluidoSac,
				PRC.idApp_Cliente,
				PRC.idApp_OrcaTrata,
				PRC.Compartilhar,
				PRC.CategoriaSac,
				PRC.Marketing,
				SPRC.SubSac,
				SPRC.ConcluidoSubSac,
				SPRC.DataSubSac,
				SPRC.HoraSubSac,
				OT.idTab_TipoRD,
				CONCAT(IFNULL(C.NomeCliente,"")) AS NomeCliente,
				U.idSis_Usuario,
				U.CpfUsuario,
				U.Nome AS NomeUsuario,
				SU.idSis_Usuario,
				SU.Nome AS NomeSubUsuario,
				AU.idSis_Usuario,
				AU.Nome AS NomeCompartilhar
            FROM
				App_Sac AS PRC
					LEFT JOIN App_SubSac AS SPRC ON SPRC.idApp_Sac = PRC.idApp_Sac
					LEFT JOIN App_OrcaTrata AS OT ON OT.idApp_OrcaTrata = PRC.idApp_OrcaTrata
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = PRC.idApp_Cliente
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
				PRC.CategoriaSac != 0 AND 
				PRC.Marketing = 0
                ' . $filtro22 . '
                ' . $id_sac . '
                ' . $categoria_sac . '
                ' . $marketing . '
                ' . $orcamento . '
                ' . $cliente . '
                ' . $id_cliente . '
			' . $groupby . '
            ORDER BY
                ' . $campo . ' 
				' . $ordenamento . '
		';
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);

		// Definimos o nome do arquivo que será exportado

		$arquivo = 'Sac_total_' . date('d-m-Y') . '.xls';

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
			$html .= '<td><b>id_Sac</b></td>';
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

			if($row_msg_contatos["CategoriaSac"] == 1){
				$row_msg_contatos["CategoriaSac"] = 'Solicitação';
			}elseif($row_msg_contatos["CategoriaSac"] == 2){
				$row_msg_contatos["CategoriaSac"] = 'Elogio';
			}elseif($row_msg_contatos["CategoriaSac"] == 3){
				$row_msg_contatos["CategoriaSac"] = 'Reclamação';
			}

			$html .= '<tr>';
				$html .= '<td>'.$row_msg_contatos['NomeUsuario'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['DataSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['HoraSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['idApp_Sac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['CategoriaSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['idApp_Cliente'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['NomeCliente'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['Sac'] . '</td>';	
				$html .= '<td>'.$row_msg_contatos['NomeCompartilhar'] . '</td>';					
				$html .= '<td>'.$row_msg_contatos['ConcluidoSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['SubSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['DataSubSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['HoraSubSac'] . '</td>';
				$html .= '<td>'.$row_msg_contatos['NomeSubUsuario'] . '</td>';							
				$html .= '<td>'.$row_msg_contatos['ConcluidoSubSac'] . '</td>';	
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
