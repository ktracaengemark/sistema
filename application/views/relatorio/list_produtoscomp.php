<!--
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-1"></div>
		<div class="col-md-2">
            <label for="DataFim">Total Pago:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
            </div>
        </div>
		<div class="col-md-2">
            <label for="DataFim">Total a Pagar:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somareceber ?>">
            </div>
        </div>      
        <div class="col-md-2">
            <label for="DataFim">Total do Período:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->balanco ?>">
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>	
</div>
-->
<div class="container-fluid">
    <div class="row">
        <div>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <!--<th class="active">D/C</th>-->
						<th class="active">Id da Despesa</th>
						<th class="active">Despesa</th>
						<th class="active">Tipo de Despesa.</th>
                        <th class="active">Data da Despesa</th>
						<th class="active">Quant.</th>
						<th class="active">Produto.</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'despesas/alterar/' . $row['idApp_Despesas'] . '">';
                            #echo '<td>' . $row['TipoProduto'] . '</td>';
							echo '<td>' . $row['idApp_Despesas'] . '</td>';
							echo '<td>' . $row['Despesa'] . '</td>';
							echo '<td>' . $row['TipoDespesa'] . '</td>';
                            echo '<td>' . $row['DataDespesas'] . '</td>';
							echo '<td>' . $row['QtdCompraProduto'] . '</td>';
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
