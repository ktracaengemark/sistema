<div class="panel panel-default">
    <div class="panel-body">

        <div class="col-md-3">
            <label for="DataFim">Total Entrada/À vista:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somaentrada ?>">
            </div>
        </div>

        <div class="col-md-3">
            <label for="DataFim">Total Pago:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somapago ?>">
            </div>
        </div>

        <div class="col-md-3">
            <label for="DataFim">Total a receber:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somareceber ?>">
            </div>
        </div>

        <div class="col-md-3">
            <label for="DataFim">Balanço do Período:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->balanco ?>">
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
                        <th class="active">#</th>
                        <th class="active">Cliente</th>
                        <th class="active">Aprovado?</th>
                        <th class="active">Data do Orçamento</th>
                        <th class="active">Data Entrada</th>
                        <th class="active">Valor Entrada</th>
                        <th class="active">Parcela</th>
                        <th class="active">Vencimento</th>
                        <th class="active">À receber</th>
                        <th class="active">Data Pgto</th>
                        <th class="active">Valor Pago</th>
                        <th class="active">Quitado?</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';
                            echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';

                            echo '<td>' . $row['NomeCliente'] . '</td>';
                            echo '<td>' . $row['AprovadoOrca'] . '</td>';
                            echo '<td>' . $row['DataOrca'] . '</td>';
                            echo '<td>' . $row['DataEntradaOrca'] . '</td>';
                            echo '<td class="text-right">R$ ' . $row['ValorEntradaOrca'] . '</td>';

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
                        <th colspan="12" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
            </table>

        </div>

    </div>

</div>
