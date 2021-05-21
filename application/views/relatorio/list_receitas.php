<div style="overflow: auto; height: 350px; ">		
	<div class="panel panel-default">
		<div class="panel-body">

			<div class="col-md-1"></div>
			<div class="col-md-3">
				<label for="DataFim">Total:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Entrada" value="<?php echo $report->soma->balanco ?>">
				</div>
			</div>		
			<div class="col-md-3">
				<label for="DataFim">À Receber:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total a receber" value="<?php echo $report->soma->somareceber ?>">
				</div>
			</div>
			<div class="col-md-3">
				<label for="DataFim">Recebido:</label>
				<div class="input-group">
					<span class="input-group-addon">R$</span>
					<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
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
							<!--<th class="active">Empresa</th>-->
							<th class="active">Receita</th>	
							<th class="active">Pc/Qt</th>
							<th class="active">Dt.Venc</th>
							<th class="active">À Receber</th>
							<th class="active">Dt.Pag</th>
							<th class="active">Recebido</th>
							<!--<th class="active">Valor Recebido</th>
							
							<th class="active">Orç.</th>
							<th class="active">Prod. Entr.?</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';
								#echo '<td>' . $row['idSis_Empresa'] . '</td>';
								echo '<td>' . $row['Descricao'] . '</td>';
								echo '<td>' . $row['Parcela'] . '  ' . $row['Quitado'] . '</td>';
								echo '<td>' . $row['DataVencimento'] . '</td>';
								echo '<td class="text-left">' . $row['ValorParcela'] . '</td>';
								echo '<td>' . $row['DataPago'] . '</td>';
								echo '<td class="text-left">' . $row['ValorPago'] . '</td>';
								#echo '<td>' . $row['DataVencimento'] . ' R$' . $row['ValorParcela'] . '</td>';
								#echo '<td>' . $row['DataPago'] . ' R$' . $row['ValorPago'] . '</td>';
								#echo '<td class="text-left">R$ ' . $row['ValorParcela'] . '</td>';
								#echo '<td class="text-left">R$ ' . $row['ValorPago'] . '</td>';
								#echo '<td>' . $row['DataOrca'] . '</td>';
								#echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								#echo '<td>' . $row['ConcluidoOrca'] . '</td>';						
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>