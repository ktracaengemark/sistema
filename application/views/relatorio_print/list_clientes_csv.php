<?php
	
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

		foreach ($report->result_array() as $row) {	

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
		
		// Move back to beginning of file 
		fseek($f, 0); 
		 
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		 
		//output all remaining data on a file pointer 
		fpassthru($f);
		fclose($f);
	
	exit; 
?>