<div class="panel panel-default">
    <div class="panel-body">

		<div class="col-md-1"></div>
        <div class="col-md-3">
            <label for="DataFim">Total dos Orçamentos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Despesasmentos" value="<?php echo $report->soma->somaorcamento ?>">
            </div>
        </div>
		<div class="col-md-3">
            <label for="DataFim">Total dos Descontos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Descontos" value="<?php echo $report->soma->somadesconto ?>">
            </div>
        </div>
		<div class="col-md-3">
            <label for="DataFim">Total A Receber:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Restante" value="<?php echo $report->soma->somarestante ?>">
            </div>
        </div>
		<div class="col-md-1"></div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div>
			<table class="table table-bordered table-condensed table-striped">
				<tfoot>
                    <tr>
                        <th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>

						<!--<th class="active">Cliente</th>-->
						<th class="active">Devol.</th>
						<th class="active">Orçam.</th>
						<th class="active">Cliente</th>
                        <th class="active">Data da Devol.</th>
						<!--<th class="active">Valid. do Orçam.</th>-->
                        <th class="active">Valor da Devol.</th>
						<th class="active">Valor do Desconto</th>
						<th class="active">Valor A Receber</th>
						<th class="active">Forma de Pag.</th>
						<th class="active">Devol. Apv/Fech?</th>
						<th class="active">Prd Entreg.?</th>
						<th class="active">Devol. Quit.?</th>                       
                        <th class="active">Data Conclusão</th>
                        <th class="active">Data Retorno</th>
                        <th class="active">Prof.</th>
                        <th class="active"></th>
                    </tr>
                </thead>
				<tbody>
                    <?php
                    foreach ($report->result_array() as $row) {
                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'devolucao/alterar/' . $row['idApp_Despesas'] . '">';

                            #echo '<div class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_Despesas'] . '">';
							#echo '<td>' . $row['NomeCliente'] . '</td>';
							echo '<td>' . $row['idApp_Despesas'] . '</td>';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							echo '<td>' . $row['NomeCliente'] . '</td>';
                            echo '<td>' . $row['DataDespesas'] . '</td>';
							#echo '<td>' . $row['DataEntradaDespesas'] . '</td>';
                            echo '<td class="text-left">R$ ' . $row['ValorDespesas'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorEntradaDespesas'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorRestanteDespesas'] . '</td>';
							echo '<td>' . $row['FormaPag'] . '</td>';
							echo '<td>' . $row['AprovadoDespesas'] . '</td>';
							echo '<td>' . $row['ServicoConcluidoDespesas'] . '</td>';
							echo '<td>' . $row['QuitadoDespesas'] . '</td>';                           
                            echo '<td>' . $row['DataConclusaoDespesas'] . '</td>';
                            echo '<td>' . $row['DataRetornoDespesas'] . '</td>';
							echo '<td>' . $row['Nome'] . '</td>';
                            #echo '</div>';
                            echo '<td class="notclickable">
                                    <a class="btn btn-md btn-info notclickable" target="_blank" href="' . base_url() . 'DespesasPrint/imprimir/' . $row['idApp_Despesas'] . '">
                                        <span class="glyphicon glyphicon-print notclickable"></span>
                                    </a>
                                </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
