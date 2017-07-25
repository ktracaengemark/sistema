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
						<th class="active">Produto.</th>
						<th class="active">Fornec.</th>
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
							#echo '<td>' . $row['idTab_Produto'] . '</td>';
							echo '<td>' . $row['ProdutoBase'] . '</td>';
							echo '<td>' . $row['NomeEmpresa'] . '</td>';
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
