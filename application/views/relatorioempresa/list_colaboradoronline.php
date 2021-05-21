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
							<th class="active">id</th>
							<!--<th class="active">id_USU</th>-->
							<th class="active">Colaborador</th>
							<th class="active">Dta Cadastro</th>
							<th class="active">Ativo</th>
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'usuario/alteraronline/' . $row['idSis_Usuario_Online'] . '">';
								echo '<td>' . $row['idSis_Usuario_Online'] . '</td>';
								#echo '<td>' . $row['idSis_Usuario'] . '</td>';
								echo '<td>' . $row['Nome'] . '</td>';
								echo '<td>' . $row['DataCriacao'] . '</td>';
								echo '<td>' . $row['StatusSN'] . '</td>';
							echo '</tr>';
						}
						?>

					</tbody>

				</table>

			</div>

		</div>

	</div>
</div>