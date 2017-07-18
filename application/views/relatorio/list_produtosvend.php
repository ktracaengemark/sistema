<div class="container-fluid">
    <div class="row">
        <div>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
						<th class="active">Cliente</th>
						<th class="active">Id do Orçam.</th>
                        <th class="active">Data do Orçam.</th>
						<th class="active">Qtd.</th>
						<!--<th class="active">idApp_ProdutoVenda.</th>
						<th class="active">idTab_Produto.</th>
						<th class="active">idTab_ProdutoBase.</th>-->
						<th class="active">ProdutoBase.</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';
							echo '<td>' . $row['NomeCliente'] . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
                            echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['QtdVendaProduto'] . '</td>';
							#echo '<td>' . $row['idApp_ProdutoVenda'] . '</td>';
							#echo '<td>' . $row['idTab_Produto'] . '</td>';
							#echo '<td>' . $row['idTab_ProdutoBase'] . '</td>';
							echo '<td>' . $row['ProdutoBase'] . '</td>';

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
