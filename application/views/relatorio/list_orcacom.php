<div class="container-fluid">
    <div class="row">
        <div>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
                        <th class="active">Orçam.</th>                       
                        <th class="active">Data do Orçamento</th>
						<th class="active">Profissional</th>

                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcacom/alterar/' . $row['idApp_OrcaTrata'] . '">';
                            echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';                          
                            echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['NomeProfissional'] . '</td>';						
                        echo '</tr>';
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
            </table>

        </div>

    </div>

</div>