<div style="overflow: auto; height: auto; ">	
	<div class="container-fluid">
		<div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
					<tr>
						<th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</tfoot>
			</table>
			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<th class="active">N�Grupo.</th>
						<th class="active">Data</th>
						<th class="active">Valor</th>
						<th class="active">Descri��o</th>
					</tr>
				</thead>
				<tbody>

					<?php
					foreach ($report->result_array() as $row) {

						echo '<tr>';
						//echo '<tr class="clickable-row" data-href="' . base_url() . 'OrcatrataPrint/imprimirgrupo/' . $row['idApp_OrcaTrata'] . '">';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['ValorExtraOrca'] . '</td>';
							echo '<td>' . $row['Descricao'] . '</td>';
						echo '</tr>';
					}
					?>

				</tbody>
			</table>
		</div>
	</div>
</div>