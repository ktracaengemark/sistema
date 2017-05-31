<div class="panel panel-default">
    <div class="panel-body">

        <div class="col-md-1"></div>
		<div class="col-md-2">
            <label for="DataFim">Total Pago:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somapago ?>">
            </div>
        </div>
		<div class="col-md-2">
            <label for="DataFim">Total a Pagar:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somapagar ?>">
            </div>
        </div>      

        <div class="col-md-2">
            <label for="DataFim">Total do Período:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->balanco2 ?>">
            </div>
        </div>

        <div class="col-md-1"></div>

    </div>	
	
</div>

<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">Id Despesa</th>
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
                            echo '<td>' . $row['idApp_Despesas'] . '</td>';
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

<div class="panel panel-default">
    <div class="panel-body">

        <div class="col-md-1"></div>

		<div class="col-md-2">
            <label for="DataFim">Total Recebido:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
            </div>
        </div>
		<div class="col-md-2">
            <label for="DataFim">Total a Receber:</label>
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

<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">id do Orçam.</th>
                        <th class="active">Parcela</th>
                        <th class="active">Data do Venc.</th>
                        <th class="active">Valor À Receber</th>
                        <th class="active">Data do Pagam.</th>
                        <th class="active">Valor Recebido</th>
                        <th class="active">Parc. Quit.?</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';
                            echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
                            echo '<td>' . $row['ParcelaRecebiveis'] . '</td>';
                            echo '<td>' . $row['DataVencimentoRecebiveis'] . '</td>';
                            echo '<td class="text-right">R$ ' . $row['ValorParcelaRecebiveis'] . '</td>';
                            echo '<td>' . $row['DataPagoRecebiveis'] . '</td>';
                            echo '<td class="text-right">R$ ' . $row['ValorPagoRecebiveis'] . '</td>';
                            echo '<td>' . $row['QuitadoRecebiveis'] . '</td>';
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
