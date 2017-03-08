	
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="col-md-2">
				<label for="DataFim">Total dos Orçamentos:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Despesas" value="<?php echo $report->soma->somadespesa ?>">
				</div>
			</div>

		</div>
	</div>
<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">N.Desp.</th>
                        <th class="active">Despesa</th>
                        <th class="active">Tipo de Desp.</th>
                        <th class="active">Data da Desp.</th>                       
						<th class="active">Valor da Desp.</th>
						<th class="active">Forma de Pag.</th>
						<th class="active">Fornecedor</th>

                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'despesa/alterar/' . $row['idApp_Despesa'] . '">';
                            echo '<td>' . $row['idApp_Despesa'] . '</td>';

                            echo '<td>' . $row['Despesa'] . '</td>';
                            echo '<td>' . $row['TipoDespesa'] . '</td>';
                            echo '<td>' . $row['DataDesp'] . '</td>';							
                            echo '<td class="text-left">R$ ' . $row['ValorTotalDesp'] . '</td>';
							echo '<td>' . $row['FormaPag'] . '</td>';
							echo '<td>' . $row['Empresa'] . '</td>';
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

