<div class="container-fluid">
    <div class="row">

        <div>

            <table class="table table-bordered table-condensed table-hover">

                <thead>
                    <tr>
                        <th class="active">Cliente</th>
						<th class="active">Orçam.</th>                       
                        <th class="active">Data do Orçam.</th>
						<th class="active">Aprovado?</th>                       
						<th class="active">Qtd Venda</th>
						<th class="active">Produto</th>
						<th class="active">Valor Venda</th>
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
							echo '<td>' . $row['QtdVendaProduto'] . '</td>';
							echo '<td>' . $row['NomeProduto'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorVendaProduto'] . '</td>';
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
<!--
<div class="panel panel-default">
    <div class="panel-body">

        <div class="col-md-2">
            <label for="DataFim">Total dos Orçamentos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Orcamentos" value="<?php echo $report->soma->somaorcamento ?>">
            </div>
        </div>

    </div>
</div>
-->
