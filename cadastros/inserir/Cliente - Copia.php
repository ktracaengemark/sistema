<?php

include_once '../../conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$cliente0 = filter_var($dados['NomeCliente'], FILTER_SANITIZE_STRING);
$sexo0 = filter_var($dados['Sexo'], FILTER_SANITIZE_STRING);
$cep0 = filter_var($dados['CepCliente'], FILTER_SANITIZE_STRING);
$endereco0 = filter_var($dados['EnderecoCliente'], FILTER_SANITIZE_STRING);
$numero0 = filter_var($dados['NumeroCliente'], FILTER_SANITIZE_STRING);
$complemento0 = filter_var($dados['ComplementoCliente'], FILTER_SANITIZE_STRING);
$bairro0 = filter_var($dados['BairroCliente'], FILTER_SANITIZE_STRING);
$cidade0 = filter_var($dados['CidadeCliente'], FILTER_SANITIZE_STRING);
$estado0 = filter_var($dados['EstadoCliente'], FILTER_SANITIZE_STRING);
$referencia0 = filter_var($dados['ReferenciaCliente'], FILTER_SANITIZE_STRING);

if(empty($dados['DataNascimento'])){
	$data = "0000-00-00";
}else{
	$data = $dados['DataNascimento'];
	
	if ($data) {
		
		if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data) && checkdate(substr($data, 3, 2), substr($data, 0, 2), substr($data, 6, 4))){
			
			if (preg_match("/[0-9]{2,4}(\/|-)[0-9]{2,4}(\/|-)[0-9]{2,4}/", $data)) {
				
				if ($data) {
					$data = DateTime::createFromFormat('d/m/Y', $data);
					$data = $data->format('Y-m-d');
				}else{
					//$data = NULL;
					$data = "0000-00-00";
				}
			}					
		}else{
			$data = "0000-00-00";
		}
	}else{
		$data = "0000-00-00";
	}
}

//$celular = filter_var($dados['CelularCliente'], FILTER_VALIDATE_INT);

$celular = $dados['CelularCliente'];


$caracteres_sem_acento = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'N'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'n'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    'a'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'A'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
);

$cliente1 = preg_replace("/[^a-zA-Z]/", " ", strtr($cliente0, $caracteres_sem_acento));
$cliente = trim(mb_strtoupper($cliente1, 'ISO-8859-1'));

$endereco1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($endereco0, $caracteres_sem_acento));
$endereco = trim(mb_strtoupper($endereco1, 'ISO-8859-1'));

$cep1 = preg_replace("/[^0-9]/", " ", strtr($cep0, $caracteres_sem_acento));
$cep = trim(mb_strtoupper($cep1, 'ISO-8859-1'));

$numero1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($numero0, $caracteres_sem_acento));
$numero = trim(mb_strtoupper($numero1, 'ISO-8859-1'));

$complemento1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($complemento0, $caracteres_sem_acento));
$complemento = trim(mb_strtoupper($complemento1, 'ISO-8859-1'));

$bairro1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($bairro0, $caracteres_sem_acento));
$bairro = trim(mb_strtoupper($bairro1, 'ISO-8859-1'));

$cidade1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($cidade0, $caracteres_sem_acento));
$cidade = trim(mb_strtoupper($cidade1, 'ISO-8859-1'));

$estado1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($estado0, $caracteres_sem_acento));
$estado = trim(mb_strtoupper($estado1, 'ISO-8859-1'));

$referencia1 = preg_replace("/[^a-zA-Z0-9]/", " ", strtr($referencia0, $caracteres_sem_acento));
$referencia = trim(mb_strtoupper($referencia1, 'ISO-8859-1'));

$sexo = trim(mb_strtoupper($sexo0, 'ISO-8859-1'));

$usuario 	= $_SESSION['log']['idSis_Usuario'];
$empresa 	= $_SESSION['log']['idSis_Empresa'];
$modulo 	= $_SESSION['log']['idTab_Modulo'];
$datacad	= date('Y-m-d H:i:s', time());


$result_usuario = "SELECT * FROM Sis_Usuario WHERE CelularUsuario='". $dados['CelularCliente'] ."' AND idSis_Empresa = '5'";
$resultado_usuario = mysqli_query($conn, $result_usuario);
$row_resultado_usuario = mysqli_fetch_array($resultado_usuario, MYSQLI_ASSOC);

$result_cliente = "SELECT * FROM App_Cliente WHERE CelularCliente='". $dados['CelularCliente'] ."' AND idSis_Empresa = '" .$empresa. "'";
$resultado_cliente = mysqli_query($conn, $result_cliente);
$row_resultado_cliente = mysqli_fetch_array($resultado_cliente, MYSQLI_ASSOC);

if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
	//  Encontrou o Usuario da empresa 5
	
	if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
		//  Encontrou o Cliente da empresa em questão
		$cadastrar = 1;
	} else {
		// Não Encontrou o Cliente da empresa em questão
		$cadastrar = 2;
	}
	
} else {
	//Não Encontoru o Usuario da Empresa 5
	
	if(($resultado_cliente) AND ($resultado_cliente->num_rows != 0)){
		// Encontrou o Cliente da empresa em questão
		$cadastrar = 3;
	} else {
		// Não Encontrou o Cliente da empresa em questão
		$cadastrar = 4;
	}
	
}

if($cadastrar == 1){
	//Encontrou o Usuario da empresa 5 e Encontrou o Cliente da empresa em questão!! Não Cadastra Ninguém
	echo '5';
	
}elseif($cadastrar == 2){
	//Encontrou o Usuario da empresa 5 e Não Encontrou o  Cliente da empresa em questão!! Pega os Dados do Usuário e Cadastra o Cliente

	$CodInterno = md5(time() . rand());
	$DataCadastroCliente = date('Y-m-d', time());
	
	$result_cliente = "INSERT INTO App_Cliente (idSis_Empresa, 
												idTab_Modulo, 
												idSis_Usuario, 
												idSis_Usuario_5, 
												NomeCliente, 
												CelularCliente,
												DataNascimento,
												Sexo,
												CepCliente,
												EnderecoCliente,
												NumeroCliente,
												ComplementoCliente,
												BairroCliente,
												CidadeCliente,
												EstadoCliente,
												ReferenciaCliente,
												CodInterno, 
												Codigo, 
												DataCadastroCliente, 
												LocalCadastroCliente, 
												usuario, 
												senha) 
												VALUES (
												'" .$empresa. "',
												'1',
												'" .$usuario. "',
												'" .$row_resultado_usuario['idSis_Usuario']. "',
												'" .$row_resultado_usuario['Nome']. "',
												'" .$row_resultado_usuario['CelularUsuario']. "',
												'" .$data. "',
												'" .$sexo. "',
												'" .$cep. "',
												'" .$endereco. "',
												'" .$numero. "',
												'" .$complemento. "',
												'" .$bairro. "',
												'" .$cidade. "',
												'" .$estado. "',
												'" .$referencia. "',
												'" .$CodInterno. "',
												'" .$row_resultado_usuario['Codigo']. "',
												'" .$DataCadastroCliente. "',
												'L',
												'" .$row_resultado_usuario['CelularUsuario']. "',
												'" .$row_resultado_usuario['Senha']. "'
												)";
	$resultado_cliente = mysqli_query($conn, $result_cliente);
	$id_cliente = mysqli_insert_id($conn);
	
	if($id_cliente){
		echo true;
	}else{
		echo false;
	}
	
}elseif($cadastrar == 3){
	// Não Encontrou o Usuario da empresa 5 e Encontrou o  Cliente!! Pega os Dados do Cliente e Cadastra o Usuario. Depois faço Update no cliente
		
	$Codigo = md5(time() . rand());
	$DataCriacao = date('Y-m-d', time());
	
	$result_usuario = "INSERT INTO Sis_Usuario (idSis_Empresa, 
												idTab_Modulo, 
												NomeEmpresa, 
												Nome, 
												CelularUsuario, 
												Codigo, 
												DataCriacao, 
												Usuario, 
												Senha, 
												Permissao, 
												Inativo) 
												VALUES (
												'5',
												'1',
												'CONTA PESSOAL',
												'" .$row_resultado_cliente['NomeCliente']. "',
												'" .$row_resultado_cliente['CelularCliente']. "',
												'" .$Codigo. "',
												'" .$DataCriacao. "',
												'" .$row_resultado_cliente['CelularCliente']. "',
												'" .$row_resultado_cliente['senha']. "',
												'3',
												'0'
												)";
	$resultado_usuario = mysqli_query($conn, $result_usuario);		
	$id_usuario_5 = mysqli_insert_id($conn);
	
	if($id_usuario_5){
	
		$result_agenda = "INSERT INTO App_Agenda (idSis_Empresa, 
												idSis_Usuario, 
												NomeAgenda) 
												VALUES (
						'5',
						'" .$id_usuario_5. "',
						'Cliente'
						)";
		$resultado_agenda = mysqli_query($conn, $result_agenda);
		$id_agenda = mysqli_insert_id($conn);		
	
		$update_cliente = "UPDATE 
								App_Cliente 
							SET 
								idSis_Usuario_5 = '".$id_usuario_5."',
								Codigo = '".$Codigo."'
							WHERE 
								idApp_Cliente = '".$row_resultado_cliente['idApp_Cliente']."'
							";
							mysqli_query($conn, $update_cliente);					
	
		if($id_agenda){
			echo true;
		}else{
			echo false;
		}
		
	}else{
		echo false;
	}
	
}elseif($cadastrar == 4){
	//Não Encontrou o Usuario e Não Encontrou o Cliente!!Então Cadastra os Dois

	$dados['NomeCliente'] = trim(mb_strtoupper($dados['NomeCliente'], 'ISO-8859-1'));
	$senha = md5($dados['CelularCliente']);
	$CodInterno = md5(time() . rand());
	$DataCadastroCliente = date('Y-m-d', time());
	$Codigo = md5(time() . rand());
	
	$result_usuario = "INSERT INTO Sis_Usuario (idSis_Empresa, 
												idTab_Modulo, 
												NomeEmpresa, 
												Nome, 
												CelularUsuario, 
												Codigo, 
												DataCriacao, 
												Usuario, 
												Senha, 
												Permissao, 
												Inativo) 
												VALUES (
												'5',
												'1',
												'CONTA PESSOAL',
												'" .$cliente. "',
												'" .$dados['CelularCliente']. "',
												'" .$Codigo. "',
												'" .$DataCadastroCliente. "',
												'" .$dados['CelularCliente']. "',
												'" .$senha. "',
												'3',
												'0'
												)";
	$resultado_usuario = mysqli_query($conn, $result_usuario);		
	$id_usuario_5 = mysqli_insert_id($conn);
	
	if($id_usuario_5){
	
		$result_agenda = "INSERT INTO App_Agenda (idSis_Empresa, 
												idSis_Usuario, 
												NomeAgenda) 
												VALUES (
												'5',
												'" .$id_usuario_5. "',
												'Cliente'
												)";
		$resultado_agenda = mysqli_query($conn, $result_agenda);
		$id_agenda = mysqli_insert_id($conn);
		
		$result_cliente = "INSERT INTO App_Cliente (idSis_Empresa, 
													idTab_Modulo, 
													idSis_Usuario, 
													idSis_Usuario_5, 
													NomeCliente, 
													CelularCliente,
													DataNascimento,
													Sexo,
													CepCliente,
													EnderecoCliente,
													NumeroCliente,
													ComplementoCliente,
													BairroCliente,
													CidadeCliente,
													EstadoCliente,
													ReferenciaCliente,
													CodInterno, 
													Codigo, 
													DataCadastroCliente, 
													LocalCadastroCliente, 
													usuario, 
													senha) 
													VALUES (
													'" .$empresa. "',
													'1',
													'" .$usuario. "',
													'" .$id_usuario_5. "',
													'" .$cliente. "',
													'" .$dados['CelularCliente']. "',
													'" .$data. "',
													'" .$sexo. "',
													'" .$cep. "',
													'" .$endereco. "',
													'" .$numero. "',
													'" .$complemento. "',
													'" .$bairro. "',
													'" .$cidade. "',
													'" .$estado. "',
													'" .$referencia. "',
													'" .$CodInterno. "',
													'" .$Codigo. "',
													'" .$DataCadastroCliente. "',
													'L',
													'" .$dados['CelularCliente']. "',
													'" .$senha. "'
													)";
		$resultado_cliente = mysqli_query($conn, $result_cliente);
		$id_cliente = mysqli_insert_id($conn);
		
		if($id_cliente){
			echo true;
		}else{
			echo false;
		}
	}else{
		echo false;
	}
} else{
	echo false;
}

unset($usuario, $empresa, $modulo, $datacad);
//echo json_encode($event_array);
//mysql_close($link);
mysqli_close($conn);
