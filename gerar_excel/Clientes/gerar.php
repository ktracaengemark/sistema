<?php
	
include_once '../../conexao.php';
 
//CSV
//fonte: https://www.php.net/manual/pt_BR/function.fputcsv.php
//criando o conjunto de valores a ser gravado
/*
$lista = array (
    array('Nome', 'Telefone', 'Endereço'),
    array('Pessoa1', '456', 'Rua XXX'),
    array('Pessoa2', '789', 'Rua yyy')
);
*/

	$date_inicio_orca = ($_SESSION['FiltroAlteraParcela']['DataInicio']) ? 'C.DataCadastroCliente >= "' . $_SESSION['FiltroAlteraParcela']['DataInicio'] . '" AND ' : FALSE;
	$date_fim_orca = ($_SESSION['FiltroAlteraParcela']['DataFim']) ? 'C.DataCadastroCliente <= "' . $_SESSION['FiltroAlteraParcela']['DataFim'] . '" AND ' : FALSE;		

	$data['Dia'] = ($_SESSION['FiltroAlteraParcela']['Dia']) ? ' AND DAY(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Dia'] : FALSE;
	$data['Mesvenc'] = ($_SESSION['FiltroAlteraParcela']['Mesvenc']) ? ' AND MONTH(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Mesvenc'] : FALSE;
	$data['Ano'] = ($_SESSION['FiltroAlteraParcela']['Ano']) ? ' AND YEAR(C.DataNascimento) = ' . $_SESSION['FiltroAlteraParcela']['Ano'] : FALSE;

	//$data['NomeCliente'] = ($_SESSION['FiltroAlteraParcela']['NomeCliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['NomeCliente'] : FALSE;
	$data['idApp_Cliente'] = ($_SESSION['FiltroAlteraParcela']['idApp_Cliente']) ? ' AND C.idApp_Cliente = ' . $_SESSION['FiltroAlteraParcela']['idApp_Cliente'] : FALSE;
	$data['Campo'] = (!$_SESSION['FiltroAlteraParcela']['Campo']) ? 'C.NomeCliente' : $_SESSION['FiltroAlteraParcela']['Campo'];
	$data['Ordenamento'] = (!$_SESSION['FiltroAlteraParcela']['Ordenamento']) ? 'ASC' : $_SESSION['FiltroAlteraParcela']['Ordenamento'];
	$filtro10 = ($_SESSION['FiltroAlteraParcela']['Ativo'] != '#') ? 'C.Ativo = "' . $_SESSION['FiltroAlteraParcela']['Ativo'] . '" AND ' : FALSE;
	$filtro20 = ($_SESSION['FiltroAlteraParcela']['Motivo'] != '0') ? 'C.Motivo = "' . $_SESSION['FiltroAlteraParcela']['Motivo'] . '" AND ' : FALSE;
	$groupby = ($_SESSION['FiltroAlteraParcela']['Agrupar'] != "0") ? 'GROUP BY C.' . $_SESSION['FiltroAlteraParcela']['Agrupar'] . '' : FALSE;
	
	$result_lista = '
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
						' . $filtro10 . '
						' . $filtro20 . '
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
//$result_lista = "SELECT * FROM App_Cliente WHERE idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . "";

$lista = mysqli_query($conn , $result_lista);

$delimiter = ","; 
$filename = "Clientes_" . date('d-m-Y') . ".csv";
//definindo o nome do arquivo e abrindo o mesmo para escrita (write)
$fp = fopen("contatos.csv", 'w');
//percorrendo o conjunto de valores e gravando no arquivo

$fields = array('Group Membership',
				'Name',
				'Notes',
				'Birthday',
				'Event 1 - Value',
				'Phone 1 - Value',
				'Phone 2 - Value',
				'Organization 1 - Name'
				); 
fputcsv($fp, $fields, $delimiter); 
	 

foreach ($lista as $linha) {

		
		echo "<pre>";
		print_r($linha["NomeEmpresa"].' - '.$linha["NomeCliente"].' - '.$linha["Aniversario"].' - '.$linha["CelularCliente"].' - '.$linha["Telefone"]);
		echo "</pre>";
        $lineData = array(	'* myContacts',
							$linha["NomeCliente"],
							$linha["idApp_Cliente"],
							$linha["Aniversario"],
							$linha["Cadastro"],
							$linha["CelularCliente"],
							$linha["Telefone"],
							$linha["NomeEmpresa"]
						); 
        fputcsv($fp, $lineData, $delimiter); 		
	
    //fputcsv($fp, $linha,";");
}
    /*
	fseek($fp, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($fp);
	*/
//fechando o arquivo
fclose($fp);
mysqli_close($conn);
?>