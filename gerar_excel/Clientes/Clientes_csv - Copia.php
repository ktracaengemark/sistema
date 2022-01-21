<?php 
 
// Load the database configuration file  
include_once '../../conexao.php';
 
// Fetch records from database 

$result_query = "SELECT * FROM App_Cliente WHERE idSis_Empresa = " . $_SESSION['log']['idSis_Empresa'] . "";
$query = mysqli_query($conn , $result_query);

if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "Clientes_" . date('d-m-Y') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Empresa',
					'Ficha',
					'ID',
					'Cliente',
					'Nasc.',
					'Sexo',
					'Celular',
					'Telefone',
					'Telefone2',
					'Telefone3',
					'CepCliente',
					'Endereço',
					'NumeroCliente',
					'ComplementoCliente',
					'Bairro',
					'Cidade',
					'EstadoCliente',
					'ReferenciaCliente',
					'Email',
					'Obs',
					'Ativo',
					'Motivo',
					'Cadast.',
					'ValorCash',
					'Valid.Cash'
					); 
    fputcsv($f, $fields, $delimiter); 
	 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        //$status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array(	$row["idSis_Empresa"],
							$row["RegistroFicha"],
							$row["idApp_Cliente"],
							$row["NomeCliente"],
							$row["DataNascimento"],
							$row["Sexo"],
							$row["CelularCliente"],
							$row["Telefone"],
							$row["Telefone2"],
							$row["Telefone3"],
							$row["CepCliente"],
							$row["EnderecoCliente"],
							$row["NumeroCliente"],
							$row["ComplementoCliente"],
							$row["BairroCliente"],
							$row["CidadeCliente"],
							$row["EstadoCliente"],
							$row["ReferenciaCliente"],
							$row["Email"],
							$row["Obs"],
							$row["Ativo"],
							$row["Motivo"],
							$row["DataCadastroCliente"],
							$row["CashBackCliente"],
							$row["ValidadeCashBack"]
						); 
        fputcsv($f, $lineData, $delimiter); 
    } 

    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>
