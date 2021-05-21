<div style="overflow: auto; height: 550px; ">	
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
						<th class="active">id</th>
						<th class="active">Empresa</th>
						<th class="active">Admin.</th>
						<th class="active">Celular</th>
						<th class="active">Criaçao</th>
						<th class="active">Validade</th>
						<th class="active">Nivel</th>
						<th class="active">Ativo?</th>

					</tr>
				</thead>

				<tbody>

					<?php
					foreach ($report->result_array() as $row) {

						#echo '<tr>';
						#echo '<tr class="clickable-row" data-href="' . base_url() . 'empresa/prontuario/' . $row['idSis_Empresa'] . '">';
							echo '<td>' . $row['idSis_Empresa'] . '</td>';
							echo '<td>' . $row['NomeEmpresa'] . '</td>';
							echo '<td>' . $row['NomeAdmin'] . '</td>';
							echo '<td>' . $row['CelularAdmin'] . '</td>';
							echo '<td>' . $row['DataCriacao'] . '</td>';
							echo '<td>' . $row['DataDeValidade'] . '</td>';
							echo '<td>' . $row['NivelEmpresa'] . '</td>';
							echo '<td>' . $row['StatusSN'] . '</td>';
						echo '</tr>';
					}
					?>

				</tbody>

			</table>

		</div>
	</div>
</div>