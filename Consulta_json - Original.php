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

$query = ($_SESSION['FiltroAlteraProcedimento']['NomeUsuario'] && isset($_SESSION['FiltroAlteraProcedimento']['NomeUsuario'])) ? 'AND A.idSis_Usuario = ' . $_SESSION['FiltroAlteraProcedimento']['NomeUsuario'] . '  ' : FALSE;	
//$query3 = ($_SESSION['FiltroAlteraProcedimento']['NomeCliente'] && isset($_SESSION['FiltroAlteraProcedimento']['NomeCliente'])) ? 'AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraProcedimento']['NomeCliente'] . '  ' : FALSE;	
$query3 = ($_SESSION['FiltroAlteraProcedimento']['idApp_Cliente'] && isset($_SESSION['FiltroAlteraProcedimento']['idApp_Cliente'])) ? 'AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraProcedimento']['idApp_Cliente'] . '  ' : FALSE;
$query4 = ($_SESSION['FiltroAlteraProcedimento']['idApp_ClientePet'] && isset($_SESSION['FiltroAlteraProcedimento']['idApp_ClientePet'])) ? 'AND C.idApp_ClientePet = ' . $_SESSION['FiltroAlteraProcedimento']['idApp_ClientePet'] . '  ' : FALSE;
$query5 = ($_SESSION['FiltroAlteraProcedimento']['idApp_ClienteDep'] && isset($_SESSION['FiltroAlteraProcedimento']['idApp_ClienteDep'])) ? 'AND C.idApp_ClienteDep = ' . $_SESSION['FiltroAlteraProcedimento']['idApp_ClienteDep'] . '  ' : FALSE;
#$query2 = ($_SESSION['log']['NomeUsuario'] && isset($_SESSION['log']['NomeUsuario'])) ? 'C.idApp_Cliente = ' . $_SESSION['log']['NomeUsuario'] . ' AND ' : FALSE;
																				
$permissao = ($_SESSION['log']['Permissao'] >= 3 ) ? 'AND A.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
$permissao3 = ($_SESSION['log']['idSis_Empresa'] != 5 ) ? 'AND A.idSis_Empresa = ' . $_SESSION['log']['idSis_Empresa'] . '  ' : FALSE;
$permissao5 = ($_SESSION['log']['idSis_Empresa'] == 5) ? 'AND A.idSis_Usuario = ' . $_SESSION['log']['idSis_Usuario'] . '  ' : FALSE;
//$permissao1 = ($_SESSION['log']['idSis_Empresa'] == 5)  ? 'OR R.CelularCliente = ' . $_SESSION['log']['CelularUsuario'] . '  ' : FALSE;
//$permissao4 = ($_SESSION['log']['idSis_Empresa'] == 5)  ? 'OR U.CelularUsuario = ' . $_SESSION['log']['CelularUsuario'] . '  ' : FALSE;
//$permissao2 = ($_SESSION['log']['idSis_Empresa'] == 5)  ? 'U.CpfUsuario = ' . $_SESSION['log']['CpfUsuario'] . ' OR ' : FALSE;																																			

$result = mysql_query(
        'SELECT
            A.idApp_Agenda,
			A.idSis_Usuario,
            U.Nome AS NomeProfissional,
			U.CompAgenda,
			U.CpfUsuario,
			U.CelularUsuario,
			U.idSis_Empresa AS EmpresaUsu,
			U.NomeEmpresa AS NomeEmpresaUsu,
			U.Permissao,
			C.idApp_Consulta,
			C.idSis_Empresa AS EmpresaCon,
            C.idApp_Cliente,
            C.idApp_ClienteDep,
            C.idApp_ClientePet,
			C.idSis_Usuario,
            E.NomeEmpresa AS NomeEmpresaEmp,
            E.CadastrarPet,
            E.CadastrarDep,
			R.NomeCliente,
			R.CelularCliente,
			R.CpfCliente,
            D.NomeContatoCliente,
            DEP.NomeClienteDep,
            PET.NomeClientePet,
            C.DataInicio,
            C.DataFim,
            C.Procedimento,
            C.Paciente,
            C.Obs,
            C.idTab_Status,
            TC.TipoConsulta,
            C.Evento,
			C.Recorrencia,
			C.DataTermino,
			C.Repeticao,
			C.idApp_OrcaTrata
        FROM
			App_Consulta AS C
				LEFT JOIN App_Agenda AS A ON A.idApp_Agenda = C.idApp_Agenda
				LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario 
                LEFT JOIN App_Cliente AS R ON R.idApp_Cliente = C.idApp_Cliente
                LEFT JOIN App_ContatoCliente AS D ON D.idApp_ContatoCliente = C.idApp_ContatoCliente
                LEFT JOIN App_ClienteDep AS DEP ON DEP.idApp_ClienteDep = C.idApp_ClienteDep
                LEFT JOIN App_ClientePet AS PET ON PET.idApp_ClientePet = C.idApp_ClientePet
                LEFT JOIN Tab_TipoConsulta AS TC ON TC.idTab_TipoConsulta = C.idTab_TipoConsulta
				LEFT JOIN Sis_Empresa AS E ON E.idSis_Empresa = C.idSis_Empresa
        WHERE
			(C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' 
				
				' . $query . '
				' . $query3 . '
				' . $query4 . '
				' . $query5 . '
				' . $permissao . '
				' . $permissao3 . '
				' . $permissao5 . '
  
			)
		ORDER BY 
			C.DataInicio ASC'
);

while ($row = mysql_fetch_assoc($result)) {

    if ($row['Evento']) {

        $c = '_evento';
		
        //(strlen(utf8_encode($row['Obs'])) > 20) ? $title = substr(utf8_encode($row['Obs']), 0, 20).'...' : $title = utf8_encode($row['Obs']);
        $title = 'Prof: ' . mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1") . ' - Evento: ' . mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1");
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
    } else {

        //$url = 'consulta/alterar/'.$row['idApp_Paciente'].'/'.$row['idApp_Consulta'];
        $textColor = 'black';

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
    }

    $event_array[] = array(
        'id' 			=> $row['idApp_Consulta'],
		'title' 		=> $title,
		'titlecliente' 	=> $titlecliente,
        'subtitle' 		=> $subtitle,
        'start' 		=> str_replace('', 'T', $row['DataInicio']),
        'end' 			=> str_replace('', 'T', $row['DataFim']),
        'allDay' 		=> false,
        'url' 			=> $url,
        'color' 		=> $status,
        'textColor' 	=> $textColor,
        'TipoConsulta' 	=> mb_convert_encoding($row['TipoConsulta'], "UTF-8", "ISO-8859-1"),
        'Procedimento' 	=> mb_convert_encoding($row['Procedimento'], "UTF-8", "ISO-8859-1"),
		'CelularCliente'=> mb_convert_encoding($row['CelularCliente'], "UTF-8", "ISO-8859-1"),
		'CelularUsuario'=> mb_convert_encoding($row['CelularUsuario'], "UTF-8", "ISO-8859-1"),
        'Obs' 			=> mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1"),
		'CpfUsuario' 	=> mb_convert_encoding($row['CpfUsuario'], "UTF-8", "ISO-8859-1"),
		'CpfCliente' 	=> mb_convert_encoding($row['CpfCliente'], "UTF-8", "ISO-8859-1"),
		'EmpresaCon' 	=> mb_convert_encoding($row['EmpresaCon'], "UTF-8", "ISO-8859-1"),
		'EmpresaUsu' 	=> mb_convert_encoding($row['EmpresaUsu'], "UTF-8", "ISO-8859-1"),
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
