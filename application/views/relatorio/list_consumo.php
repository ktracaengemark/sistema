<div class="panel panel-default">
  
</div>

<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">Id Consumo</th>
                        <th class="active">Data do Consumo</th>
						<th class="active">Quant.</th>
						<th class="active">Produto.</th>

                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'consumo/alterar/' . $row['idApp_Consumo'] . '">';
                            echo '<td>' . $row['idApp_Consumo'] . '</td>';
                            echo '<td>' . $row['DataConsumo'] . '</td>';
							echo '<td>' . $row['QtdConsumoProduto'] . '</td>';
							echo '<td>' . $row['NomeProduto'] . '</td>';

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
