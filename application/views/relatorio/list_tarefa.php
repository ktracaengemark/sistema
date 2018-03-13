<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>                       											
						<!--<th class="active">Responsável da Tarefa</th>-->
						<th class="active">Nº</th>
						<th class="active">Tarefa / Missão</th>																	                       
						<th class="active">Data da Tarefa:</th>
						<th class="active">Prazo de Conclusão</th>
						<th class="active">Tarefa Concluída?</th>
						<th class="active">Data da Conclusão da Tarefa</th>
						<th class="active">Rotina?:</th>
						<th class="active">Prioridade?</th>						
						<!--<th class="active">Responsável da Ação</th>-->						
						<!--<th class="active">Ação</th>
						<th class="active">Data da Ação</th>
						<th class="active">Ação Concluída?</th>-->
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Tarefa'] . '">';
                           
							#echo '<td>' . $row['NomeProfissional'] . '</td>';
							echo '<td>' . $row['idApp_Tarefa'] . '</td>';
							echo '<td>' . $row['ObsTarefa'] . '</td>'; //  = Tarefa
							echo '<td>' . $row['DataTarefa'] . '</td>';
							echo '<td>' . $row['DataPrazoTarefa'] . '</td>';
							echo '<td>' . $row['TarefaConcluida'] . '</td>'; // = Tarefa Concluída?
							echo '<td>' . $row['DataConclusao'] . '</td>';
							echo '<td>' . $row['Rotina'] . '</td>'; // = Rotina
							echo '<td>' . $row['Prioridade'] . '</td>'; // = Prioridade								
							#echo '<td>' . $row['Profissional'] . '</td>';							
							#echo '<td>' . $row['Procedtarefa'] . '</td>';
							#echo '<td>' . $row['DataProcedtarefa'] . '</td>';
							#echo '<td>' . $row['ConcluidoProcedtarefa'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

