<div class="panel panel-default">
    <div class="panel-body">

        <div class="col-md-1"></div>

        <!--<div class="col-md-2">
            <label for="DataFim">Total de Desconto:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->somaentrada ?>">
            </div>
        </div>-->
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
        <!--<div class="col-md-2">
            <label for="DataFim">Total Real/Caixa:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Real" value="<?php echo $report->soma->somareal ?>">
            </div>
        </div>-->

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

<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
                        <th class="active">D/C</th>
						<th class="active">Id Despesa</th>
						<th class="active">Despesa</th>
						<th class="active">Tipo de Desp.</th>
                        <th class="active">Data da Despesa</th>
                        <!--<th class="active">Data Entrada</th>
                        <th class="active">Valor Entrada</th>-->
						<th class="active">Desp. Aprov.?</th>
						<th class="active">Desp. Concl.?</th>
						<th class="active">Desp. Quit.?</th>						
                        <th class="active">Parcela</th>
                        <th class="active">Data do Venc.</th>
                        <th class="active">Valor À Pagar</th>
                        <th class="active">Data do Pagam.</th>
                        <th class="active">Valor Pago</th>
                        <th class="active">Parc. Quit.?</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'despesas/alterar/' . $row['idApp_Despesas'] . '">';
                            echo '<td>' . $row['TipoProduto'] . '</td>';
							echo '<td>' . $row['idApp_Despesas'] . '</td>';
							echo '<td>' . $row['Despesa'] . '</td>';
							echo '<td>' . $row['TipoDespesa'] . '</td>';
                            echo '<td>' . $row['DataDespesas'] . '</td>';
                           # echo '<td>' . $row['DataEntradaOrca'] . '</td>';
                           # echo '<td class="text-right">R$ ' . $row['ValorEntradaOrca'] . '</td>';
							echo '<td>' . $row['AprovadoDespesas'] . '</td>';
							echo '<td>' . $row['ServicoConcluidoDespesas'] . '</td>';
							echo '<td>' . $row['QuitadoDespesas'] . '</td>';							
                            echo '<td>' . $row['ParcelaPagaveis'] . '</td>';
                            echo '<td>' . $row['DataVencimentoPagaveis'] . '</td>';
                            echo '<td class="text-left">R$ ' . $row['ValorParcelaPagaveis'] . '</td>';
                            echo '<td>' . $row['DataPagoPagaveis'] . '</td>';
                            echo '<td class="text-left">R$ ' . $row['ValorPagoPagaveis'] . '</td>';
                            echo '<td>' . $row['QuitadoPagaveis'] . '</td>';
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
