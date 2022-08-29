<?php
	include_once '../../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Clientes</title>
	<head>
	<body>
		<?php
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
				 
				$result = '
						SELECT
							C.idApp_Cliente,
							C.idSis_Empresa,
							C.idSis_Associado,
							C.NomeCliente,
							' . $cp_id_clientepet . '
							' . $cp_nomeclientepet . '
							' . $cd_id_clientedep . '
							' . $cd_nomeclientedep . '
							C.Arquivo,
							C.Ativo,
							C.Motivo,
							C.DataNascimento,
							C.DataCadastroCliente,
							DATE_FORMAT(C.DataNascimento, "%d/%m/%Y") AS Aniversario,
							DATE_FORMAT(C.DataCadastroCliente, "%d/%m/%Y") AS Cadastro,
							C.CelularCliente,
							C.Telefone,
							C.Telefone2,
							C.Telefone3,
							C.Sexo,
							C.EnderecoCliente,
							C.NumeroCliente,
							C.ComplementoCliente,
							C.BairroCliente,
							C.CidadeCliente,
							C.EstadoCliente,
							C.ReferenciaCliente,
							C.CepCliente,
							C.Obs,
							C.Email,
							C.RegistroFicha,
							C.usuario,
							C.senha,
							C.CodInterno,
							C.CashBackCliente,
							C.ValidadeCashBack,
							C.id_UltimoPedido,
							C.UltimoPedido,
							MT.Motivo
						FROM
							App_Cliente AS C
								LEFT JOIN Tab_Motivo AS MT ON  MT.idTab_Motivo = C.Motivo
								' . $clientepet . '
								' . $clientedep . '
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
				$resultado = mysqli_query($conn , $result);

				// Definimos o nome do arquivo que será exportado
				//$arquivo = 'clientes.xls';
				$arquivo = 'Clientes_' . date('d-m-Y') . '.xls';
				
				// Título da Tabela
				$html = '';
				$html .= '<table border="1">';
				/*
				$html .= '<tr>';
				$html .= '<td colspan="3">Planilha de Clientes</tr>';
				$html .= '</tr>';
				*/
				// Campos da Tabela
				$html .= '<tr>';
					$html .= '<td><b>Empresa</b></td>';
					$html .= '<td><b>Ficha</b></td>';
					$html .= '<td><b>id_Cliente</b></td>';
					$html .= '<td><b>Cliente</b></td>';
					$html .= '<td><b>Nasc.</b></td>';
					$html .= '<td><b>Sexo</b></td>';
					$html .= '<td><b>Celular</b></td>';
					$html .= '<td><b>Telefone</b></td>';
					$html .= '<td><b>Telefone2</b></td>';
					$html .= '<td><b>Telefone3</b></td>';
					$html .= '<td><b>CepCliente</b></td>';
					$html .= '<td><b>Endereço</b></td>';
					$html .= '<td><b>NumeroCliente</b></td>';
					$html .= '<td><b>ComplementoCliente</b></td>';
					$html .= '<td><b>Bairro</b></td>';
					$html .= '<td><b>Cidade</b></td>';
					$html .= '<td><b>EstadoCliente</b></td>';
					$html .= '<td><b>ReferenciaCliente</b></td>';
					$html .= '<td><b>Email</b></td>';
					$html .= '<td><b>Ativo</b></td>';
					$html .= '<td><b>Motivo</b></td>';
					$html .= '<td><b>Cadast.</b></td>';
					$html .= '<td><b>Ult.Pdd.</b></td>';
					$html .= '<td><b>ValorCash</b></td>';
					$html .= '<td><b>Valid.Cash</b></td>';
					//$html .= '<td><b>Obs</b></td>';
					if(!$_SESSION['FiltroClientes']['Agrupar']){
						if($_SESSION['Empresa']['CadastrarPet'] == "S"){
							$html .= '<td><b>id_Pet</b></td>';
							$html .= '<td><b>Pet</b></td>';
						}else{
							if($_SESSION['Empresa']['CadastrarDep'] == "S"){
								$html .= '<td><b>id_Dep</b></td>';
								$html .= '<td><b>Dep</b></td>';
							}
						}
					}
				$html .= '</tr>';
				
				while($row = mysqli_fetch_assoc($resultado)){
					
					$data_nasc = date('d/m/Y',strtotime($row["DataNascimento"]));
					$data_cad = date('d/m/Y',strtotime($row["DataCadastroCliente"]));
					
					if(!isset($row["UltimoPedido"]) || $row["UltimoPedido"] == "0000-00-00"){
						$dt_ult_pdd = NULL;
					}else{
						$dt_ult_pdd = date('d/m/Y',strtotime($row["UltimoPedido"]));
					}
					$data_val = date('d/m/Y',strtotime($row["ValidadeCashBack"]));
					
					$html .= '<tr>';
						$html .= '<td>'.$row["idSis_Empresa"].'</td>';
						$html .= '<td>'.$row["RegistroFicha"].'</td>';
						$html .= '<td>'.$row["idApp_Cliente"].'</td>';
						$html .= '<td>'.utf8_encode($row["NomeCliente"]).'</td>';
						$html .= '<td>'.$data_nasc.'</td>';
						$html .= '<td>'.$row["Sexo"].'</td>';
						$html .= '<td>'.$row["CelularCliente"].'</td>';
						$html .= '<td>'.$row["Telefone"].'</td>';
						$html .= '<td>'.$row["Telefone2"].'</td>';
						$html .= '<td>'.$row["Telefone3"].'</td>';
						$html .= '<td>'.$row["CepCliente"].'</td>';
						$html .= '<td>'.utf8_encode($row["EnderecoCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["NumeroCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["ComplementoCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["BairroCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["CidadeCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["EstadoCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["ReferenciaCliente"]).'</td>';
						$html .= '<td>'.utf8_encode($row["Email"]).'</td>';
						$html .= '<td>'.utf8_encode($row["Ativo"]).'</td>';
						$html .= '<td>'.$row["Motivo"].'</td>';
						$html .= '<td>'.$data_cad.'</td>';
						$html .= '<td>'.$dt_ult_pdd.'</td>';
						$html .= '<td>'.$row["CashBackCliente"].'</td>';
						$html .= '<td>'.$data_val.'</td>';
						//$html .= '<td>'.utf8_encode($row["Obs"]).'</td>';
						if(!$_SESSION['FiltroClientes']['Agrupar']){
							if($_SESSION['Empresa']['CadastrarPet'] == "S"){
								$html .= '<td>'.$row["idApp_ClientePet"].'</td>';
								$html .= '<td>'.utf8_encode($row["NomeClientePet"]).'</td>';
							}else{
								if($_SESSION['Empresa']['CadastrarDep'] == "S"){
									$html .= '<td>'.$row["idApp_ClienteDep"].'</td>';
									$html .= '<td>'.utf8_encode($row["NomeClienteDep"]).'</td>';
								}
							}
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
				mysqli_close($conn);
				exit;
			}
		?>
	</body>
</html>
