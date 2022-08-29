<?php  
	include_once '../../conexao.php';
	
	if(isset($_SESSION['log']['idSis_Empresa']) && isset($_SESSION['FiltroClientes'])) {
		
		//Selecionar os itens da Tabela
		$data = $_SESSION['FiltroClientes'];
		
		if($data['Pesquisa']){
			if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data['Pesquisa'])) {
				$pesquisa = '(DataNascimento = "' . $this->basico->mascara_data($data['Pesquisa'], 'mysql') . '" OR '
						. 'DataCadastroCliente = "' . $this->basico->mascara_data($data['Pesquisa'], 'mysql') . '" )';
			}elseif (is_numeric($data['Pesquisa'])) {
				if($date === TRUE) {
					$pesquisa = '(DataNascimento = "' . substr($data['Pesquisa'], 4, 4).'-'.substr($data['Pesquisa'], 2, 2).'-'.substr($data['Pesquisa'], 0, 2) . '" OR '
							. 'DataCadastroCliente = "' . substr($data['Pesquisa'], 4, 4).'-'.substr($data['Pesquisa'], 2, 2).'-'.substr($data['Pesquisa'], 0, 2) . '" )';
				}else{
					if((strlen($data['Pesquisa'])) < 6){
						$pesquisa = 'RegistroFicha like "' . $data['Pesquisa'] . '"';
					}elseif(strlen($data['Pesquisa']) >= 6 && strlen($data['Pesquisa']) <= 7){
						$pesquisa = 'idApp_Cliente like "' . $data['Pesquisa'] . '"';
						
					}else{
						$pesquisa = '(CelularCliente like "%' . $data['Pesquisa'] . '%" OR '
								. 'Telefone like "%' . $data['Pesquisa'] . '%" OR '
								. 'Telefone2 like "%' . $data['Pesquisa'] . '%" OR '
								. 'Telefone3 like "%' . $data['Pesquisa'] . '%" )';
					}
				}			
			}else{
				$pesquisa = '(NomeCliente like "%' . $data['Pesquisa'] . '%" )';
			}
			$pesquisar = 'AND ' . $pesquisa;
		}else{
			$pesquisar = FALSE;
		}		

		$date_inicio_orca = ($data['DataInicio']) ? 'C.DataCadastroCliente >= "' . $data['DataInicio'] . '" AND ' : FALSE;
		$date_fim_orca = ($data['DataFim']) ? 'C.DataCadastroCliente <= "' . $data['DataFim'] . '" AND ' : FALSE;

		$date_inicio_cash = ($data['DataInicio2']) ? 'C.ValidadeCashBack >= "' . $data['DataInicio2'] . '" AND ' : FALSE;
		$date_fim_cash = ($data['DataFim2']) ? 'C.ValidadeCashBack <= "' . $data['DataFim2'] . '" AND ' : FALSE;

		$date_inicio_ultimo = ($data['DataInicio3']) ? 'C.UltimoPedido >= "' . $data['DataInicio3'] . '" AND ' : FALSE;
		$date_fim_ultimo = ($data['DataFim3']) ? 'C.UltimoPedido <= "' . $data['DataFim3'] . '" AND ' : FALSE;		
		
		$dia = ($data['Dia']) ? ' AND DAY(C.DataNascimento) = ' . $data['Dia'] : FALSE;
		$mes = ($data['Mes']) ? ' AND MONTH(C.DataNascimento) = ' . $data['Mes'] : FALSE;
		$ano = ($data['Ano']) ? ' AND YEAR(C.DataNascimento) = ' . $data['Ano'] : FALSE;

		$id_cliente = ($data['idApp_Cliente']) ? ' AND C.idApp_Cliente = ' . $data['idApp_Cliente'] : FALSE;
		
		if($_SESSION['Empresa']['CadastrarPet'] == "S"){
			$id_clientepet = ($data['idApp_ClientePet']) ? ' AND CP.idApp_ClientePet = ' . $data['idApp_ClientePet'] : FALSE;
			$id_clientepet2 = ($data['idApp_ClientePet2']) ? 'AND CP.idApp_ClientePet = ' . $data['idApp_ClientePet2'] : FALSE;
			$id_clientedep = FALSE;
			$id_clientedep2 =  FALSE;
		}else{
			if($_SESSION['Empresa']['CadastrarDep'] == "S"){
				$id_clientedep = ($data['idApp_ClienteDep']) ? ' AND CD.idApp_ClienteDep = ' . $data['idApp_ClienteDep'] : FALSE;
				$id_clientedep2 = ($data['idApp_ClienteDep2']) ? 'AND CD.idApp_ClienteDep = ' . $data['idApp_ClienteDep2'] : FALSE;
			}else{	
				$id_clientedep = FALSE;
				$id_clientedep2 = FALSE;
			}
			$id_clientepet = FALSE;
			$id_clientepet2 = FALSE;
		}
		
		if(isset($data['Sexo'])){
			if($data['Sexo'] == 0){
				$sexo = FALSE;
			}elseif($data['Sexo'] == 1){
				$sexo = 'C.Sexo = "M" AND ';
			}elseif($data['Sexo'] == 2){
				$sexo = 'C.Sexo = "F" AND ';
			}elseif($data['Sexo'] == 3){
				$sexo = 'C.Sexo = "O" AND ';
			}
		}else{
			$sexo = FALSE;
		}
		if(isset($data['Pedidos'])){
			if($data['Pedidos'] == 0){
				$pedidos = FALSE;
			}elseif($data['Pedidos'] == 1){
				$pedidos = 'C.UltimoPedido = "0000-00-00" AND ';
			}elseif($data['Pedidos'] == 2){
				$pedidos = 'C.UltimoPedido != "0000-00-00" AND ';
			}
		}else{
			$pedidos = FALSE;
		}			
		$campo = (!$data['Campo']) ? 'C.NomeCliente' : $data['Campo'];
		$ordenamento = (!$data['Ordenamento']) ? 'ASC' : $data['Ordenamento'];
		$filtro10 = (isset($data['Ativo']) && $data['Ativo'] != '#') ? 'C.Ativo = "' . $data['Ativo'] . '" AND ' : FALSE;
		$filtro20 = (isset($data['Motivo']) && $data['Motivo'] != '0') ? 'C.Motivo = "' . $data['Motivo'] . '" AND ' : FALSE;

		$groupby = ($data['Agrupar']) ? 'GROUP BY C.idApp_Cliente' : FALSE;

		if($_SESSION['Empresa']['CadastrarPet'] == "S"){
			$clientepet = 'LEFT JOIN App_ClientePet AS CP ON CP.idApp_Cliente = C.idApp_Cliente';
			$cp_id_clientepet = 'CP.idApp_ClientePet,';
			$cp_nomeclientepet = 'CP.NomeClientePet,';
			$clientedep = FALSE;
			$cd_id_clientedep = FALSE;
			$cd_nomeclientedep = FALSE;
		}else{
			$clientepet = FALSE;
			$cp_id_clientepet = FALSE;
			$cp_nomeclientepet = FALSE;
			if($_SESSION['Empresa']['CadastrarDep'] == "S"){
				$clientedep = 'LEFT JOIN App_ClienteDep AS CD ON CD.idApp_Cliente = C.idApp_Cliente';
				$cd_id_clientedep = 'CD.idApp_ClienteDep,';
				$cd_nomeclientedep = 'CD.NomeClienteDep,';
			}else{
				$clientedep = FALSE;
				$cd_id_clientedep = FALSE;
				$cd_nomeclientedep = FALSE;
			}
		}

		if($_SESSION['Usuario']['Nivel'] == 2){
			$revendedor = 'AND (C.NivelCliente = "1" OR C.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . ')';
		}else{
			$revendedor = FALSE;
		}
		
		$querylimit = FALSE;
		 
		$result_query = '
			SELECT 
				C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
				C.Telefone,
				DATE_FORMAT(C.DataNascimento, "%d/%m/%Y") AS Aniversario,
				E.NomeEmpresa
			FROM 
				App_Cliente AS C
					LEFT JOIN Tab_Motivo AS MT ON  MT.idTab_Motivo = C.Motivo
					' . $clientepet . '
					' . $clientedep . '
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
				' . $id_cliente . ' 
				' . $id_clientepet . '
				' . $id_clientedep . '
				' . $id_clientepet2 . '
				' . $id_clientedep2 . '
				' . $dia . ' 
				' . $mes . '
				' . $ano . '
				' . $pesquisar . '
				' . $revendedor . '
			' . $groupby . '
			ORDER BY
				' . $campo . '
				' . $ordenamento . '
			' . $querylimit . '
		';

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
	}
?>
