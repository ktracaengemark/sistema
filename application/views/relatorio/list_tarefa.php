<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>                       											
						<th class="active">Responsável da Tarefa</th>
						<th class="active">Tarefa / Missão</th>																	                       
						<th class="active">Data da Tarefa:</th>
						<th class="active">Prazo de Conclusão</th>
						<th class="active">Rotina?:</th>
						<th class="active">Prioridade?</th>
						<th class="active">Tarefa Concluída?</th>
						<th class="active">Data da Conclusão da Tarefa</th>
						<th class="active">Responsável da Ação</th>						
						<th class="active">Ação</th>
						<th class="active">Data da Ação</th>
						<th class="active">Ação Concluída?</th>																	
						<!--<th class="active">N.Tarefa</th>-->
																		
						
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Tarefa'] . '">';
                           
							echo '<td>' . $row['NomeProfissional'] . '</td>';
							echo '<td>' . $row['ObsTarefa'] . '</td>'; //  = Tarefa
							echo '<td>' . $row['DataTarefa'] . '</td>';
							echo '<td>' . $row['DataPrazoTarefa'] . '</td>';
							echo '<td>' . $row['ServicoConcluido'] . '</td>'; // = Rotina
							echo '<td>' . $row['QuitadoTarefa'] . '</td>'; // = Prioridade	
							echo '<td>' . $row['AprovadoTarefa'] . '</td>'; // = Tarefa Concluída?
							echo '<td>' . $row['DataConclusao'] . '</td>';
							echo '<td>' . $row['Profissional'] . '</td>';							
							echo '<td>' . $row['Procedtarefa'] . '</td>';
							echo '<td>' . $row['DataProcedtarefa'] . '</td>';
							echo '<td>' . $row['ConcluidoProcedtarefa'] . '</td>';																																															
							#echo '<td>' . $row['idApp_Tarefa'] . '</td>';
																					
							
                        echo '</tr>';
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
            </table>

        </div>

    </div>

</div>
<!--
<div class="panel panel-default">
    <div class="panel-body">

        <div class="col-md-2">
            <label for="DataFim">Total dos Orçamentos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Tarefamentos" value="<?php echo $report->soma->somatarefa ?>">
            </div>
        </div>

    </div>
</div>
-->
