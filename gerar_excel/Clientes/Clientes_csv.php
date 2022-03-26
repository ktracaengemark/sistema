<?php 
 
// Load the database configuration file  
include_once '../../conexao.php';
 
// Fetch records from database 

	$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'C.DataCadastroCliente >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
	$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'C.DataCadastroCliente <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;

	$date_inicio_cash = ($_SESSION['FiltroAlteraParcela']['DataInicio2']) ? 'C.ValidadeCashBack >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio2'] . '" AND ' : FALSE;
	$date_fim_cash = ($_SESSION['FiltroAlteraParcela']['DataFim2']) ? 'C.ValidadeCashBack <= "' . $_SESSION['FiltroAlteraParcela']['DataFim2'] . '" AND ' : FALSE;

	$date_inicio_ultimo = ($_SESSION['FiltroAlteraParcela']['DataInicio3']) ? 'C.UltimoPedido >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio3'] . '" AND ' : FALSE;
	$date_fim_ultimo = ($_SESSION['FiltroAlteraParcela']['DataFim3']) ? 'C.UltimoPedido <= "' . $_SESSION['FiltroAlteraParcela']['DataFim3'] . '" AND ' : FALSE;		

	$data['Dia'] = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
	$data['Mesvenc'] = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
	$data['Ano'] = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;

	if(isset($_SESSION['FiltroAlteraParcela']['Sexo'])){
		if($_SESSION['FiltroAlteraParcela']['Sexo'] == 0){
			$sexo = FALSE;
		}elseif($_SESSION['FiltroAlteraParcela']['Sexo'] == 1){
			$sexo = 'C.Sexo = "M" AND ';
		}elseif($_SESSION['FiltroAlteraParcela']['Sexo'] == 2){
			$sexo = 'C.Sexo = "F" AND ';
		}elseif($_SESSION['FiltroAlteraParcela']['Sexo'] == 3){
			$sexo = 'C.Sexo = "O" AND ';
		}
	}else{
		$sexo = FALSE;
	}
			
	if(isset($_SESSION['FiltroAlteraParcela']['Pedidos'])){
		if($_SESSION['FiltroAlteraParcela']['Pedidos'] == 0){
			$pedidos = FALSE;
		}elseif($_SESSION['FiltroAlteraParcela']['Pedidos'] == 1){
			$pedidos = 'C.UltimoPedido = "0000-00-00" AND ';
		}elseif($_SESSION['FiltroAlteraParcela']['Pedidos'] == 2){
			$pedidos = 'C.UltimoPedido != "0000-00-00" AND ';
		}
	}else{
		$pedidos = FALSE;
	}
	
	//$data['NomeCliente'] = ($_SESSION['FiltroAlteraParcela']['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] : FALSE;
	$data['idApp_Cliente'] = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] : FALSE;
	$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'C.NomeCliente' : $_SESSION['FiltroAlteraParcela']['Campo'];
	$data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
	$filtro10 = ($_SESSION['FiltroAlteraParcela']['Ativo'] != '#') ? 'C.Ativo = "' . $_SESSION['FiltroAlteraParcela']['Ativo'] . '" AND ' : FALSE;
	$filtro20 = ($_SESSION['FiltroAlteraParcela']['Motivo'] != '0') ? 'C.Motivo = "' . $_SESSION['FiltroAlteraParcela']['Motivo'] . '" AND ' : FALSE;
	$groupby = ($_SESSION['FiltroAlteraParcela']['Agrupar'] != "0") ? 'GROUP BY C.' . $_SESSION['FiltroAlteraParcela']['Agrupar'] . '' : FALSE;
		
		
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
