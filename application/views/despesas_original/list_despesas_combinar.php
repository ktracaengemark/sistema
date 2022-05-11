<div style="overflow: auto; height: auto; ">
	<div class="container-fluid">
		<div class="row">
			<div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="5" class="active">Total encontrado: <?php echo $report_combinar->num_rows(); ?> resultado(s)</th>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="active">Pedido</th>
							<th class="active">idFornec</th>
							<th class="active">Fornec</th>
							<th class="active">Entrega</th>
							<th class="active">Hora</th>
							<th class="active">Forma</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($report_combinar->result_array() as $row) {
							#echo '<tr>';
							echo '<tr class="clickable-row bg-danger" data-href="' . base_url() . 'Orcatrata/alterardesp/' . $row['idApp_OrcaTrata'] . '">';
								echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
								echo '<td>' . $row['idApp_Fornecedor'] . '</td>';	
								echo '<td>' . $row['NomeFornecedor'] . '</td>';
								echo '<td>' . $row['DataEntregaOrca'] . '</td>';
								echo '<td>' . $row['HoraEntregaOrca'] . '</td>';
								echo '<td>' . $row['TipoFrete'] . '</td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>