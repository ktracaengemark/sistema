<?php 
 
// Load the database configuration file  
include_once '../../conexao.php';
 
    // Fetch records from database 
			
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
	
	$result_query = '
					SELECT 
						C.*,
						DATE_FORMAT(C.DataNascimento, "%d/%m/%Y") AS Aniversario,
						DATE_FORMAT(C.DataCadastroCliente, "%d/%m/%Y") AS Cadastro,
						E.NomeEmpresa
					FROM 
						App_Cliente AS C
							LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = C.idSis_Empresa
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
		

	/*
	$result_query = "SELECT * FROM App_Cliente WHERE idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . "";
	*/
	$query = mysqli_query($conn , $result_query);
	/*	
	echo "<pre>";
	print_r($query);
	echo "</pre>";
	exit();
	*/	
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "Clientes_" . date('d-m-Y') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Group Membership',
					'Name',
					'Notes',
					'Birthday',
					'Phone 1 - Value',
					'Phone 2 - Value',
					'Organization 1 - Name'
					); 
    fputcsv($f, $fields, $delimiter); 
	 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        //$status = ($row['status'] == 1)?'Active':'Inactive'; 
		/*
		echo "<pre>";
		print_r($row["NomeEmpresa"].' - '.$row["NomeCliente"].' - '.$row["Aniversario"].' - '.$row["CelularCliente"].' - '.$row["Telefone"]);
		echo "</pre>";
		*/
		
		//$row["NomeCliente"] = utf8_encode($row["NomeCliente"]);
		//$row["NomeEmpresa"] = utf8_encode($row["NomeEmpresa"]);
		
        $lineData = array(	'* myContacts',
							$row["NomeCliente"],
							$row["idApp_Cliente"],
							$row["Aniversario"],
							$row["CelularCliente"],
							$row["Telefone"],
							$row["NomeEmpresa"]
						); 
        fputcsv($f, $lineData, $delimiter); 
    } 
	//exit();
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f);
	fclose($f);
} 
mysqli_close($conn);
exit; 
 
?>
