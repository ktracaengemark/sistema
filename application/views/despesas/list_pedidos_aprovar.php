<div style="overflow: auto; height: auto; ">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 text-left">
				<?php echo $pagination; ?>
			</div>
		</div>
		<div class="row">
			<div>
				<table class="table table-hover">
					<!--
					<thead>
						<tr>
							<th colspan="5" class="active">Total encontrado: <?php #echo $report_aprovar->num_rows(); ?> resultado(s)</th>
						</tr>
					</thead>
					-->
					<thead>
						<tr>
							<th class="active">Cont</th>
							<th class="active">Pedido</th>
							<th class="active">idCli</th>
							<th class="active">Fornecedor</th>
							<th class="active">Compra</th>
							<th class="active">Despesa</th>
							<th class="active">Parcela</th>
							<th class="active">Vnc.Prc.</th>
							<th class="active">Pago?</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report_aprovar->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row bg-warning" data-href="' . base_url() . $status . $row['idApp_OrcaTrata'] . '">';
								echo '<td>' . ($linha + $count) . '</td>';
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';	
								echo '<td>' . $row['idApp_Fornecedor'] . '</td>';	
								echo '<td>' . $row['NomeFornecedor'] . '</td>';
								echo '<td>' . $row['Tipo_Orca'] . '</td>';	
								echo '<td>' . $row['TipoFinanceiro'] . '</td>';
								echo '<td>' . $row['Parcela'] . '</td>';
								echo '<td>' . $row['DataVencimento'] . '</td>';
								echo '<td>' . $row['Quitado'] . '</td>';
							echo '</tr>';
							$count++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>