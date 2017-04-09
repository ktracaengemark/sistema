<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        
						<th class="active">N.Orçam.</th>
						<th class="active">Aprovado?</th>
                        <th class="active">Cliente</th>												
						<th class="active">Quant.</th>
						<th class="active">Produto.</th>
						<th class="active">Procedimento.</th>
						<th class="active">Proc. Conc.?</th>
						
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                       echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';
                            echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							echo '<td>' . $row['AprovadoOrca'] . '</td>';							
                            echo '<td>' . $row['NomeCliente'] . '</td>';														
							echo '<td>' . $row['QtdVendaProduto'] . '</td>';
							echo '<td>' . $row['NomeProduto'] . '</td>';
							echo '<td>' . $row['Procedimento'] . '</td>';
							echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
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
