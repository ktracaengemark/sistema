<div style="overflow: auto; height: 350px; ">	
	<div class="container-fluid">
		<div class="row">

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
							<th class="active">Nº</th>
							<th class="active">Associado</th>				
							<th class="active">Telefone</th>
							<th class="active">Criação</th>
							<th class="active">Ativo?</th>
							<th class="active">Site</th>
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'associado/prontuario/' . $row['idSis_Usuario'] . '">';
								echo '<td>' . $row['idSis_Empresa'] . '</td>';
								echo '<td>' . $row['NomeEmpresa'] . '</td>';							
								echo '<td>' . $row['Celular'] . '</td>';
								echo '<td>' . $row['DataCriacao'] . '</td>';
								echo '<td>' . $row['StatusSN'] . '</td>';
								echo '<td>' . $row['Site'] . '</td>';
							echo '</tr>';
						}
						?>

					</tbody>

				</table>

			</div>

		</div>

	</div>
</div>