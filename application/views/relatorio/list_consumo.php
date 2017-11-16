<div class="container-fluid">
    <div class="row">
        <div>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <!--<th class="active">D/C</th>-->
						<th class="active">Id do Consumo</th>
						<th class="active">Consumo</th>
						<th class="active">Tipo de Consumo.</th>
                        <th class="active">Data do Consumo</th>
						<th class="active">Quant.</th>
						<th class="active">Categoria</th>
						<th class="active">Produto</th>
						<th class="active">Aux1</th>
						<th class="active">Aux2</th>
						<th class="active">Obs.</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'consumo/alterar/' . $row['idApp_Despesas'] . '">';
                            #echo '<td>' . $row['TipoProduto'] . '</td>';
							echo '<td>' . $row['idApp_Despesas'] . '</td>';
							echo '<td>' . $row['Despesa'] . '</td>';
							echo '<td>' . $row['TipoConsumo'] . '</td>';
                            echo '<td>' . $row['DataDespesas'] . '</td>';
							echo '<td>' . $row['QtdCompraProduto'] . '</td>';
							echo '<td>' . $row['Prodaux3'] . '</td>';
							echo '<td>' . $row['Produtos'] . '</td>';
							echo '<td>' . $row['Prodaux1'] . '</td>';
							echo '<td>' . $row['Prodaux2'] . '</td>';
							echo '<td>' . $row['ObsProduto'] . '</td>';
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
