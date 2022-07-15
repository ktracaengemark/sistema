
<div class="container-fluid">
    <div class="row">
        <div>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th colspan="6" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						<th colspan="2" class="active"> <?php echo $report->soma->quantidade ?> Produtos</th>
					</tr>
				</thead>
				<thead>
                    <tr>
						<th class="active">Cliente</th>
						<th class="active">Id do Or�am.</th>
                        <th class="active">Data do Or�am.</th>
						<th class="active">Or�. Apv.?</th>
						<th class="active">Fornec</th>
						<th class="active">C�digo</th>
						<th class="active">Qtd.</th>
						<th class="active">Categoria</th>
						<th class="active">Produto</th>						
						<th class="active">Aux1</th>
						<th class="active">Aux2</th>
						<th class="active">Valor</th>
						<!--<th class="active">Valor do Or�.</th>
						<th class="active">Obs</th>-->
						<th class="active">Entrega</th>
						<th class="active">Forma de Pag.</th>
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
							echo '<td>' . $row['AprovadoOrca'] . '</td>';
							echo '<td>' . $row['NomeFornecedor'] . '</td>';
							echo '<td>' . $row['CodProd'] . '</td>';
							echo '<td>' . $row['QtdVendaProduto'] . '</td>';
							echo '<td>' . $row['Prodaux3'] . '</td>';
							echo '<td>' . $row['Produtos'] . '</td>';							
							echo '<td>' . $row['Prodaux1'] . '</td>';
							echo '<td>' . $row['Prodaux2'] . '</td>';
							echo '<td>' . $row['ValorVendaProduto'] . '</td>';
							#echo '<td>' . $row['ValorOrca'] . '</td>';
							#echo '<td>' . $row['ObsProduto'] . '</td>';
							echo '<td>' . $row['DataValidadeProduto'] . '</td>';							
							echo '<td>' . $row['FormaPag'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
						<th colspan="6" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
						<th colspan="2" class="active"> <?php echo $report->soma->quantidade ?> Produtos</th>
					</tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
