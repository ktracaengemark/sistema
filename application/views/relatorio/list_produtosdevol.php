<div class="container-fluid">
    <div class="row">
        <div>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <!--<th class="active">D/C</th>-->
						
						<th class="active">Nº da Devol.</th>
						<th class="active">Nº do Orçam.</th>
						<th class="active">Cliente</th>
						<!--<th class="active">Despesa</th>-->
						<th class="active">Data da Devol.</th>
						<th class="active">Tipo de Devol.</th>
						<th class="active">Devol. Apv.?</th>
						<th class="active">Código</th>
						<th class="active">Quant.</th>
						<th class="active">Categoria</th>
						<th class="active">Produto</th>
						<th class="active">Aux1</th>
						<th class="active">Aux2</th>
						<th class="active">Valor</th>
						<th class="active">Forma de Pag.</th>																																			
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'devolucao/alterar/' . $row['idApp_Despesas'] . '">';
                            #echo '<td>' . $row['TipoProduto'] . '</td>';
							
							echo '<td>' . $row['idApp_Despesas'] . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							echo '<td>' . $row['NomeCliente'] . '</td>';
							#echo '<td>' . $row['Despesa'] . '</td>';
							echo '<td>' . $row['DataDespesas'] . '</td>';							
							echo '<td>' . $row['TipoDespesa'] . '</td>'; 
							echo '<td>' . $row['AprovadoDespesas'] . '</td>';
							echo '<td>' . $row['CodProd'] . '</td>';
							echo '<td>' . $row['QtdCompraProduto'] . '</td>';
							echo '<td>' . $row['Prodaux3'] . '</td>';
							echo '<td>' . $row['Produtos'] . '</td>';
							echo '<td>' . $row['Prodaux1'] . '</td>';
							echo '<td>' . $row['Prodaux2'] . '</td>';
							echo '<td>' . $row['ValorCompraProduto'] . '</td>';
							echo '<td>' . $row['FormaPag'] . '</td>';																																			
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
