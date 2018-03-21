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
$query = ($_SESSION['log']['NomeUsuario'] && isset($_SESSION['log']['NomeUsuario'])) ?
    #'P.idSis_Usuario = ' . $_SESSION['log']['NomeUsuario'] . ' AND ' : FALSE;
	'A.idSis_Usuario = ' . $_SESSION['log']['NomeUsuario'] . ' AND ' : FALSE;

$permissao = ($_SESSION['log']['Permissao'] > 2) ?
	'A.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;

$result = mysql_query(
        'SELECT
            A.idApp_Agenda,
			A.idSis_Usuario,
            U.Nome AS NomeProfissional,
			C.idApp_Consulta,
            C.idApp_Cliente,
            R.NomeCliente,
			R.Telefone1,
            D.NomeContatoCliente,
            P.Nome AS NomeUsuario,
			P.Permissao,
            C.DataInicio,
            C.DataFim,
            C.Procedimento,
            C.Paciente,
            C.Obs,
            C.idTab_Status,
            TC.TipoConsulta,
            C.Evento
        FROM
            App_Agenda AS A
                LEFT JOIN app.Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario,
            App_Consulta AS C
                LEFT JOIN app.App_Cliente AS R ON R.idApp_Cliente = C.idApp_Cliente
                LEFT JOIN app.App_ContatoCliente AS D ON D.idApp_ContatoCliente = C.idApp_ContatoCliente
                LEFT JOIN app.Sis_Usuario AS P ON P.idSis_Usuario = C.idSis_Usuario
                LEFT JOIN app.Tab_TipoConsulta AS TC ON TC.idTab_TipoConsulta = C.idTab_TipoConsulta

        WHERE
			C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
           	C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
			' . $query . '
            ' . $permissao . '
            A.idApp_Agenda = C.idApp_Agenda
        ORDER BY C.DataInicio ASC'
);

while ($row = mysql_fetch_assoc($result)) {

    if ($row['Evento']) {

        $c = '_evento';
        //(strlen(utf8_encode($row['Obs'])) > 20) ? $title = substr(utf8_encode($row['Obs']), 0, 20).'...' : $title = utf8_encode($row['Obs']);
        $title = mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1");
		#$title = utf8_encode($row['NomeUsuario']);
		#$title = utf8_encode($row['idSis_Usuario']);
		$subtitle = mb_convert_encoding($row['NomeUsuario'], "UTF-8", "ISO-8859-1");

		#$profissional = utf8_encode($row['NomeUsuario']);
		#$profissional = utf8_encode($row['idApp_Agenda']);
		$profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");

	}
	else {

        $c = '/' . $row['idApp_Cliente'];

        if ($row['Paciente'] == 'D') {
            $title = mb_convert_encoding($row['NomeContatoCliente'], "UTF-8", "ISO-8859-1");
            $subtitle = mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1");

			#$profissional = utf8_encode($row['NomeUsuario']);
			#$profissional = utf8_encode($row['idApp_Agenda']);
			$profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");

			$telefone1 = mb_convert_encoding($row['Telefone1'], "UTF-8", "ISO-8859-1");
        }
        else {

            #$title = utf8_encode($row['NomeCliente']);
            $title = mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1");
            #$title = $row['NomeCliente'];
            #'name' => mb_convert_encoding($row['NomeProduto'], "UTF-8", "ISO-8859-1"),

			#$title = utf8_encode($row['NomeUsuario']);
			#$subtitle = utf8_encode($row['NomeUsuario']);
            $subtitle = mb_convert_encoding($row['NomeUsuario'], "UTF-8", "ISO-8859-1");

			#$profissional = utf8_encode($row['NomeUsuario']);
			#$profissional = utf8_encode($row['idApp_Agenda']);
			#$profissional = utf8_encode($row['idSis_Usuario']);
            $profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");

			#$telefone1 = utf8_encode($row['Telefone1']);
            $telefone1 = mb_convert_encoding($row['Telefone1'], "UTF-8", "ISO-8859-1");

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
    }
    else {

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
        'id' => $row['idApp_Consulta'],
        'title' => $title,
        'subtitle' => $subtitle,
        'start' => str_replace('', 'T', $row['DataInicio']),
        'end' => str_replace('', 'T', $row['DataFim']),
        'allDay' => false,
        'url' => $url,
        'color' => $status,
        'textColor' => $textColor,
        'TipoConsulta' => mb_convert_encoding($row['TipoConsulta'], "UTF-8", "ISO-8859-1"),
        'Procedimento' => mb_convert_encoding($row['Procedimento'], "UTF-8", "ISO-8859-1"),
		'Telefone1' => mb_convert_encoding($row['Telefone1'], "UTF-8", "ISO-8859-1"),
        'Obs' => mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1"),
        'Evento' => $row['Evento'],
        'Paciente' => $row['Paciente'],
        #   'ContatoCliente' => $contatocliente,
        'Profissional' => $profissional,
    );
}

echo json_encode($event_array);
mysql_close($link);
?>
