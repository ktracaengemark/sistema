<div class="container-fluid">
    <div class="row">
        <div>
            <table class="table table-bordered table-condensed table-striped">
				<thead>
                    <tr>
                        <th colspan="10" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </thead>                
				<thead>
                    <tr>
						<th class="active">Orç.</th>
                        <th class="active">Associado</th>
						<th class="active">Cliente</th>
						<!--<th class="active">Valid. do Orçam.</th>
						<th class="active">Prazo de Entrega</th>-->
                        <th class="active">Dt. Orç.</th>
                        <th class="active">Dt. Venc.</th>	
						<th class="active">Forma</th>						
						<th class="active">Valor/Produtos</th>
						<th class="active">Valor/Frete</th>
						<th class="active">Valor/Boleto</th>
						<th class="active">Valor/Fatura</th>
						<th class="active">Valor/Gateway</th>
						<th class="active">Valor/Enkontraki</th>
						<th class="active">Valor/Comissao</th>						
						<th class="active">Valor/Empresa</th>
                        <!--<th class="active"></th>-->
                    </tr>
                </thead>
				<tbody>
                    <?php
                    foreach ($report->result_array() as $row) {
                        #echo '<tr>';
                        #echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alteraronline/' . $row['idApp_OrcaTrata'] . '">';
						echo '<tr class="clickable-row" data-href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
                            echo '<td>' . $row['Nome'] . '</td>';
							echo '<td>' . $row['NomeCliente'] . '</td>';
							#echo '<td>' . $row['DataEntradaOrca'] . '</td>';
							#echo '<td>' . $row['DataPrazo'] . '</td>';
                            echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['DataVencimentoOrca'] . '</td>';	
                            echo '<td>' . $row['FormaPag'] . '</td>';							
							echo '<td class="text-left">R$ ' . $row['ValorRestanteOrca'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorFrete'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorBoleto'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorFatura'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorGateway'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorEnkontraki'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorComissao'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorEmpresa'] . '</td>';
							/*
							echo '<td class="notclickable">
                                    <a class="btn btn-md btn-info notclickable" target="_blank" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
                                        <span class="glyphicon glyphicon-print notclickable"></span>
                                    </a>
                                </td>';
							*/	
                        echo '</tr>';
                    }
                    ?>
                </tbody>
				<tfoot>
                    <tr>
						<th colspan="6" class="active text-right">Totais</th>
						<th colspan="1" class="active">R$ <?php echo $report->soma->somaorcamento ?></th>
						<th colspan="1" class="active">R$ <?php echo $report->soma->somacomissao ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
