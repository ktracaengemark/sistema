<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-03-21 03:09:16 --> Severity: Warning --> mysqli::real_connect(): MySQL server has gone away C:\xampp\htdocs\sistema\system\database\drivers\mysqli\mysqli_driver.php 133
ERROR - 2017-03-21 03:09:23 --> Severity: Warning --> mysqli::real_connect(): MySQL server has gone away C:\xampp\htdocs\sistema\system\database\drivers\mysqli\mysqli_driver.php 133
ERROR - 2017-03-21 03:10:06 --> Severity: Warning --> mysqli::real_connect(): MySQL server has gone away C:\xampp\htdocs\sistema\system\database\drivers\mysqli\mysqli_driver.php 133
ERROR - 2017-03-21 03:10:14 --> Severity: Notice --> Undefined index: Profissional C:\xampp\htdocs\sistema\application\views\tarefa\form_tarefa.php 330
ERROR - 2017-03-21 03:10:22 --> Severity: Warning --> mysqli::real_connect(): MySQL server has gone away C:\xampp\htdocs\sistema\system\database\drivers\mysqli\mysqli_driver.php 133
ERROR - 2017-03-21 03:10:34 --> Query error: Unknown column 'PC.ConcluidoProcedimento' in 'field list' - Invalid query: 
            SELECT
                C.NomeCliente,

                OT.idApp_OrcaTrata,
                OT.AprovadoOrca,
                OT.DataOrca,
                OT.ValorOrca,

                OT.ServicoConcluido,
                OT.QuitadoOrca,
                OT.DataConclusao,
                OT.DataRetorno,
				
				PC.DataProcedimento,
				PC.Profissional,				
				PC.Procedimento,
				PC.ConcluidoProcedimento

			FROM
                App_Cliente AS C,
                App_OrcaTrata AS OT
					LEFT JOIN App_Procedimento AS PC ON OT.idApp_OrcaTrata = PC.idApp_OrcaTrata	
					
			WHERE
                C.idSis_Usuario = 33 AND
                ((OT.DataOrca >= "2017-01-01")) AND
                
                
				
				
                C.idApp_Cliente = OT.idApp_Cliente

            ORDER BY
                C.NomeCliente ASC
        
ERROR - 2017-03-21 03:11:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2017-03-21 03:11:11 --> Severity: Warning --> mysqli::real_connect(): MySQL server has gone away C:\xampp\htdocs\sistema\system\database\drivers\mysqli\mysqli_driver.php 133
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: ConcluidoProcedimento C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 561
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: ConcluidoProcedimento C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 561
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: ConcluidoProcedimento C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 561
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: ConcluidoProcedimento C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 561
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: ConcluidoProcedimento C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 561
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: idApp_Procedimento C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 757
ERROR - 2017-03-21 03:11:19 --> Severity: Notice --> Undefined index: idApp_ParcelasRec C:\xampp\htdocs\sistema\application\views\orcatrata\form_orcatrata.php 758
