<?php

session_start();

$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
#$link = mysql_connect('159.203.125.243', 'usuario', '20UtpJ15');
#$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('Não foi possível selecionar banco de dados: ' . mysql_error());
}

#echo 'Conexão bem sucedida';

//Acho que as próximas linhas são redundantes, verificar
$query = ($_SESSION['Agendamentos']['NomeUsuario'] && isset($_SESSION['Agendamentos']['NomeUsuario'])) ? 'AND A.idSis_Associado = ' . $_SESSION['Agendamentos']['NomeUsuario'] . '  ' : FALSE;
//$query = ($_SESSION['Agendamentos']['NomeUsuario'] && isset($_SESSION['Agendamentos']['NomeUsuario'])) ? 'AND A.idSis_Usuario = ' . $_SESSION['Agendamentos']['NomeUsuario'] . '  ' : FALSE;	
//$query3 = ($_SESSION['Agendamentos']['NomeCliente'] && isset($_SESSION['Agendamentos']['NomeCliente'])) ? 'AND C.idApp_Cliente = ' . $_SESSION['Agendamentos']['NomeCliente'] . '  ' : FALSE;	
$query3 = ($_SESSION['Agendamentos']['idApp_Cliente'] && isset($_SESSION['Agendamentos']['idApp_Cliente'])) ? 'AND C.idApp_Cliente = ' . $_SESSION['Agendamentos']['idApp_Cliente'] . '  ' : FALSE;
$query4 = ($_SESSION['Agendamentos']['idApp_ClientePet'] && isset($_SESSION['Agendamentos']['idApp_ClientePet'])) ? 'AND C.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet'] . '  ' : FALSE;
$query42 = ($_SESSION['Agendamentos']['idApp_ClientePet2'] && isset($_SESSION['Agendamentos']['idApp_ClientePet2'])) ? 'AND C.idApp_ClientePet = ' . $_SESSION['Agendamentos']['idApp_ClientePet2'] . '  ' : FALSE;
$query5 = ($_SESSION['Agendamentos']['idApp_ClienteDep'] && isset($_SESSION['Agendamentos']['idApp_ClienteDep'])) ? 'AND C.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep'] . '  ' : FALSE;
$query52 = ($_SESSION['Agendamentos']['idApp_ClienteDep2'] && isset($_SESSION['Agendamentos']['idApp_ClienteDep2'])) ? 'AND C.idApp_ClienteDep = ' . $_SESSION['Agendamentos']['idApp_ClienteDep2'] . '  ' : FALSE;
$query6 = ($_SESSION['Agendamentos']['Recorrencia'] && isset($_SESSION['Agendamentos']['Recorrencia'])) ? 'AND C.Recorrencia = "' . $_SESSION['Agendamentos']['Recorrencia'] . '"  ' : FALSE;
#$query2 = ($_SESSION['log']['NomeUsuario'] && isset($_SESSION['log']['NomeUsuario'])) ? 'C.idApp_Cliente = ' . $_SESSION['log']['NomeUsuario'] . ' AND ' : FALSE;
$query7 = ($_SESSION['Agendamentos']['Repeticao'] && isset($_SESSION['Agendamentos']['Repeticao'])) ? 'AND C.Repeticao = "' . $_SESSION['Agendamentos']['Repeticao'] . '"  ' : FALSE;

($_SESSION['Agendamentos']['DataInicio']) ? $date_inicio = $_SESSION['Agendamentos']['DataInicio'] : FALSE;
($_SESSION['Agendamentos']['DataFim']) ? $date_fim = date('Y-m-d', strtotime('+1 days', strtotime($_SESSION['Agendamentos']['DataFim']))) : FALSE;

$date_inicio_cons 	= ($_SESSION['Agendamentos']['DataInicio']) ? 'DataInicio >= "' . $date_inicio . '" AND ' : FALSE;
$date_fim_cons 		= ($_SESSION['Agendamentos']['DataFim']) ? 'DataInicio <= "' . $date_fim . '" AND ' : FALSE;
		

$tipo = (isset($_SESSION['Agendamentos']['Tipo'])) ? $_SESSION['Agendamentos']['Tipo'] : '0';		
if(isset($tipo)){
	if($tipo == 2){
		$tipoevento	= 'AND C.Tipo = 2';	
	}elseif($tipo == 1){
		$tipoevento	= 'AND C.Tipo = 1';
	}else{
		$tipoevento	= FALSE;
	}
}else{
	$tipoevento	= FALSE;
}
			
if($_SESSION['log']['idSis_Empresa'] != 5){
	//$permissao = ($_SESSION['log']['Permissao'] >= 3 ) ? 'AND U.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
	if($_SESSION['Usuario']['Nivel'] == 0 || $_SESSION['Usuario']['Nivel'] == 1){
		$nivel = 'C.NivelAgenda = "1" AND';
	}else{
		$nivel = 'C.NivelAgenda = "2" AND';
	}
	$permissao = ($_SESSION['log']['Permissao'] >= 3 ) ? 'AND C.idApp_Agenda = ' . $_SESSION['log']['Agenda'] . '  ' : FALSE;
	$permissao5 = FALSE;
}else{
	$permissao = FALSE;
	$nivel = FALSE;
	$permissao5 = 'AND A.idSis_Associado = ' . $_SESSION['log']['idSis_Usuario'] . '';
}

//$permissao3 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? 'AND A.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  ' : FALSE;
//$permissao3 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? 'AND C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  ' : FALSE;
//$permissao5 = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'AND A.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
//$permissao5 = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'AND A.idSis_Associado = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
//$permissao1 = ($_SESSION['log']['idSis_Empresa'] == 5)  ? 'OR R.CelularCliente = ' . $_SESSION['log']['CelularUsuario'] . '  ' : FALSE;
//$permissao4 = ($_SESSION['log']['idSis_Empresa'] == 5)  ? 'OR U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . '  ' : FALSE;
//$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5)  ? 'U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' OR ' : FALSE;																																			
          
		  
$result = mysql_query(
        'SELECT
			C.idApp_Consulta,
            C.idApp_Agenda,
			C.idSis_Empresa,
            C.idApp_Cliente,
            C.idApp_ClienteDep,
            C.idApp_ClientePet,
            C.DataInicio,
            C.DataFim,
            C.Procedimento,
            C.Paciente,
            C.Obs,
            C.idTab_Status,
            C.Evento,
			C.Recorrencia,
			C.DataTermino,
			C.Repeticao,
			C.idApp_OrcaTrata,
			A.idSis_Associado,
            ASS.Nome AS NomeProfissional,
			
            E.NomeEmpresa AS NomeEmpresaEmp,
            E.CadastrarPet,
            E.CadastrarDep,
			R.NomeCliente,
			R.CelularCliente,
			R.CpfCliente,
            DEP.NomeClienteDep,
            PET.NomeClientePet,
            TC.TipoConsulta
        FROM
			App_Consulta AS C
				LEFT JOIN App_Agenda AS A ON A.idApp_Agenda = C.idApp_Agenda
				LEFT JOIN Sis_Associado AS ASS ON ASS.idSis_Associado = A.idSis_Associado
                LEFT JOIN App_Cliente AS R ON R.idApp_Cliente = C.idApp_Cliente
                LEFT JOIN App_ClienteDep AS DEP ON DEP.idApp_ClienteDep = C.idApp_ClienteDep
                LEFT JOIN App_ClientePet AS PET ON PET.idApp_ClientePet = C.idApp_ClientePet
                LEFT JOIN Tab_TipoConsulta AS TC ON TC.idTab_TipoConsulta = C.idTab_TipoConsulta
				LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = C.idSis_Empresa
        WHERE

			' . $date_inicio_cons . '
			' . $date_fim_cons . '
			' . $nivel . '
			C.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . ' AND
			(C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				' . $tipoevento . ' 
				' . $query . '
				' . $query3 . '
				' . $query4 . '
				' . $query42 . '
				' . $query5 . '
				' . $query52 . '
				' . $query6 . '
				' . $query7 . '
				' . $permissao . '
				
				' . $permissao5 . '
  
			)
		
		ORDER BY 
			C.DataInicio ASC'
);
/*
echo '<br>';
echo "<pre>";
print_r($result);
echo "</pre>";
*/
while ($row = mysql_fetch_assoc($result)) {

    if ($row['Evento']) {

        $c = '_evento';
		
        //(strlen(utf8_encode($row['Obs'])) > 20) ? $title = substr(utf8_encode($row['Obs']), 0, 20).'...' : $title = utf8_encode($row['Obs']);
        /*
			$title = ' - Evento: ' . mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1");
		*/
		$title = mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1") . ' - ' . mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
		$titlecliente = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
		$subtitle = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
		$profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
        $recorrencia = mb_convert_encoding($row['Recorrencia'], "UTF-8", "ISO-8859-1");
        $repeticao = $row['Repeticao'];
        $datatermino = $row['DataTermino'];
        $OS = $row['idApp_OrcaTrata'];
		
	} else {

        $c = '/' . $row['idApp_Cliente'];

        if ($row['Paciente'] == 'D') {
            /*
				$title = ' - Evento: ' . mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1");
			*/
			$title = 'Cli: ' . mb_convert_encoding($row['NomeContatoCliente'], "UTF-8", "ISO-8859-1") . ' - Prf: ' . mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
            $titlecliente = mb_convert_encoding($row['NomeContatoCliente'], "UTF-8", "ISO-8859-1");
			$subtitle = mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1");
			#$profissional = utf8_encode($row['NomeUsuario']);
			#$profissional = utf8_encode($row['idApp_Agenda']);
			$profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
			$recorrencia = mb_convert_encoding($row['Recorrencia'], "UTF-8", "ISO-8859-1");
			$repeticao = $row['Repeticao'];
			$datatermino = $row['DataTermino'];
			$OS = $row['idApp_OrcaTrata'];
			$telefone1 = mb_convert_encoding($row['CelularCliente'], "UTF-8", "ISO-8859-1");
			
        } else {
			/*
				$title = ' - Evento: ' . mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1");
            */
			#$title = utf8_encode($row['NomeCliente']);
            if($row['CadastrarPet'] == "S"){
				$title =mb_convert_encoding($row['NomeClientePet'], "UTF-8", "ISO-8859-1") . ' - Cli: ' . mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1") . ' - Prf: ' . mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
			}else if($row['CadastrarDep'] == "S"){
				$title =mb_convert_encoding($row['NomeClienteDep'], "UTF-8", "ISO-8859-1") . ' - Cli: ' . mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1") . ' - Prf: ' . mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
			}else{
				$title ='Cli: ' . mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1") . ' - Prf: ' . mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
			}
				
			$titlecliente = mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1");
            $subtitle = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
            $profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");
			$recorrencia = mb_convert_encoding($row['Recorrencia'], "UTF-8", "ISO-8859-1");
			$repeticao = $row['Repeticao'];
			$datatermino = $row['DataTermino'];
			$OS = $row['idApp_OrcaTrata'];
			#$telefone1 = utf8_encode($row['CelularCliente']);
            $telefone1 = mb_convert_encoding($row['CelularCliente'], "UTF-8", "ISO-8859-1");
			
		}

    }

    $url = 'consulta/alterar' . $c . '/' . $row['idApp_Consulta'];

    if ($row['DataFim'] < date('Y-m-d H:i:s')) {

        //$url = false;
        $textColor = 'grey';
		/*
        if ($row['Evento'])
            $status = '#e6e6e6';
        else {
            if ($row['idTab_Status'] == 1)
                $status = '#EBCCA1';
            elseif ($row['idTab_Status'] == 2)
                $status = ' #95d095';
            elseif ($row['idTab_Status'] == 3)
                $status = '#99B6D0';
            else
                $status = '#E4BEBD';
        }
		*/
		if ($row['idTab_Status'] == 1)
			$status = '#EBCCA1';
		elseif ($row['idTab_Status'] == 2)
			$status = ' #95d095';
		elseif ($row['idTab_Status'] == 3)
			$status = '#99B6D0';
		else
			$status = '#E4BEBD';		
		
    } else {

        //$url = 'consulta/alterar/'.$row['idApp_Paciente'].'/'.$row['idApp_Consulta'];
        $textColor = 'black';
		/*
        if ($row['Evento'])
            $status = '#a6a6a6';
        else {
            if ($row['idTab_Status'] == 1)
                $status = '#f0ad4e';
            elseif ($row['idTab_Status'] == 2)
                $status = '#5cb85c';
            elseif ($row['idTab_Status'] == 3)
                $status = 'darken(#428bca, 6.5%)';
            else
                $status = '#d9534f';
        }
		*/
       
		if ($row['idTab_Status'] == 1)
			$status = '#f0ad4e';
		elseif ($row['idTab_Status'] == 2)
			$status = '#5cb85c';
		elseif ($row['idTab_Status'] == 3)
			$status = 'darken(#428bca, 6.5%)';
		else
			$status = '#d9534f';
        		
		
    }

    $event_array[] = array(
        'id' 			=> $row['idApp_Consulta'],
		'title' 		=> $title,
		'Obs' 			=> mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1"),
        'color' 		=> $status,
		'textColor' 	=> $textColor,
		'url' 			=> $url,
        'start' 		=> str_replace('', 'T', $row['DataInicio']),
        'end' 			=> str_replace('', 'T', $row['DataFim']),
        'allDay' 		=> false,
		'titlecliente' 	=> $titlecliente,
        'subtitle' 		=> $subtitle,
		'TipoConsulta' 	=> mb_convert_encoding($row['TipoConsulta'], "UTF-8", "ISO-8859-1"),
        'Procedimento' 	=> mb_convert_encoding($row['Procedimento'], "UTF-8", "ISO-8859-1"),
		'CelularCliente'=> mb_convert_encoding($row['CelularCliente'], "UTF-8", "ISO-8859-1"),
		//'CelularUsuario'=> mb_convert_encoding($row['CelularUsuario'], "UTF-8", "ISO-8859-1"),
		//'CpfUsuario' 	=> mb_convert_encoding($row['CpfUsuario'], "UTF-8", "ISO-8859-1"),
		'CpfCliente' 	=> mb_convert_encoding($row['CpfCliente'], "UTF-8", "ISO-8859-1"),
		//'EmpresaCon' 	=> mb_convert_encoding($row['EmpresaCon'], "UTF-8", "ISO-8859-1"),
		//'EmpresaUsu' 	=> mb_convert_encoding($row['EmpresaUsu'], "UTF-8", "ISO-8859-1"),
        'NomeEmpresaEmp'=> mb_convert_encoding($row['NomeEmpresaEmp'], "UTF-8", "ISO-8859-1"),
		'Evento' 		=> $row['Evento'],
        'Paciente' 		=> $row['Paciente'],
        #'ContatoCliente' => $contatocliente,
		'Profissional' 	=> $profissional,
        'Recorrencia' 	=> $recorrencia,
        'Repeticao' 	=> $repeticao,
        'DataTermino' 	=> $datatermino,
        'OS' 			=> $OS,
		'CadastrarPet' 	=> $row['CadastrarPet'],
		'CadastrarDep' 	=> $row['CadastrarDep'],
		'titledep' 		=> $row['NomeClienteDep'],
		'titlepet' 		=> $row['NomeClientePet'],
		
    );
}

echo json_encode($event_array);
mysql_close($link);
?>
