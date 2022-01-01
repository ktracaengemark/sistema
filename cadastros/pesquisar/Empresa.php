<?php
	
include_once '../../conexao.php';

if (isset($_GET['empresa'])) {
	

	$empresa 	= $_GET['empresa'];
	
	//echo true;
	//echo json_encode($empresa);
	
	$empresax = explode(' ', $empresa);

	if (isset($empresax[2]) && $empresax[2] != ''){
		
		$empresa2 = $empresax[2];
		
		if (isset($empresa2)){
		
			$query2 = '(EP.NomeEmpresa like "%' . $empresa2 . '%" OR '
						. 'EP.Atuacao like "%' . $empresa2 . '%"  )';
			
		}	
		$filtro2 = ' AND ' . $query2 ;
	} else {
		$filtro2 = FALSE ;
	}

	if (isset($empresax[1]) && $empresax[1] != ''){
		$empresa0 = $empresax[0];
		$empresa1 = $empresax[1];
		
		if (isset($empresa1)){	
			
			$query1 = '(EP.NomeEmpresa like "%' . $empresa1 . '%" OR '
						. 'EP.Atuacao like "%' . $empresa1 . '%"  )';
			
		}	
		$filtro1 = ' AND ' . $query1 ;
		
	}else{
		$empresa0 = $empresa;
		$filtro1 = FALSE;
	}

	$query0 = '(EP.NomeEmpresa like "%' . $empresa0 . '%" OR '
				. 'EP.Atuacao like "%' . $empresa0 . '%"  )';
	
	
	/*
	$query = '(EP.NomeEmpresa like "%' . $empresa . '%" OR '
				. 'EP.Atuacao like "%' . $empresa . '%"  )';
	*/			
	if(!empty($empresa)){
			
		$result = ('
			SELECT
				EP.idSis_Empresa,
				EP.NomeEmpresa,
				EP.Atuacao,
				EP.Site,
				EP.Inativo,
				EP.Arquivo AS Arquivo_Empresa
			FROM
				Sis_Empresa AS EP 

			WHERE 
				(' . $query0 . ' ' . $filtro1 . ' ' . $filtro2 . ') AND
				EP.idSis_Empresa != "1" AND
				EP.idSis_Empresa != "5"  AND
				EP.Inativo = 0
			ORDER BY 
				EP.NomeEmpresa ASC
			LIMIT 50
		');	
			
		//echo json_encode($result);
		//Seleciona os registros com $conn
		$read_empresa = mysqli_query($conn, $result);
		foreach($read_empresa as $row){		
			
			$data[] 	= array(
				
				'id_empresa' 		=> $row['idSis_Empresa'],
				'nomeempresa' 		=> utf8_encode ($row['NomeEmpresa']),
				'atuacao' 			=> utf8_encode ($row['Atuacao']),
				'site' 				=> $row['Site'],
				'arquivo_empresa' 	=> $row['Arquivo_Empresa'],
				
			);			
		}
		echo json_encode($data);
		
	}else{
	
		//echo json_encode($data);
		echo false;
	}
	
	
}else{
	
	//echo json_encode('socorro');
	echo false;
	
}

mysqli_close($conn);
