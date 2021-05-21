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

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">#</th>
                        <th class="active">Cliente</th>                      
                        <th class="active">Data do Orçamento</th>
                        <!--<th class="active">Data Entrada</th>
                        <th class="active">Valor Entrada</th>-->
						<th class="active">Orç. Aprovado?</th>
						<th class="active">Orç. Quitado?</th>
						<th class="active">Serv. Concl.?</th>
                        <th class="active">Parcela</th>
                        <th class="active">Vencimento</th>
                        <th class="active">À Receber</th>
                        <th class="active">Data Recebido</th>
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
                            echo '<td>' . $row['NomeCliente'] . '</td>';                           
                            echo '<td>' . $row['DataOrca'] . '</td>';
                           # echo '<td>' . $row['DataEntradaOrca'] . '</td>';
                           # echo '<td class="text-right">R$ ' . $row['ValorEntradaOrca'] . '</td>';
						    echo '<td>' . $row['AprovadoOrca'] . '</td>';
							echo '<td>' . $row['QuitadoOrca'] . '</td>';
							echo '<td>' . $row['ConcluidoOrca'] . '</td>';
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
