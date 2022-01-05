<div style="overflow: auto; height: 455px; ">
	<div class="container-fluid">
		<div class="row">
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
					<tr>
						<th colspan="9" class="active">Campanhas: <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</tfoot>
			</table>	
			<table class="table table-bordered table-condensed table-striped">								
				<thead>
					<tr>
						<th class="active">Cont/Edit</th>
						<th class="active">Codigo</th>
						<th class="active">Tipo</th>
						<th class="active">Campanha</th>
						<th class="active">Premio/Regras</th>
						<th class="active">Desconto</th>
						<th class="active">Minimo</th>
						<th class="active">Inicia</th>
						<th class="active">Termina</th>
						<th class="active">Ativa?</th>
						<th class="active">Ganhador</th>
					</tr>
				</thead>

				<tbody>

					<?php
					$count = 1;
					foreach ($report->result_array() as $row) {

						#echo '<tr>';
						#echo '<tr class="clickable-row" data-href="' . base_url() . 'campanha/alterar/' . $row['idApp_Campanha'] . '">';
							echo '<td class="notclickable">'. $count . '
									<a class="btn btn-md btn-primary notclickable" href="' . base_url() . 'campanha/alterar/' . $row['idApp_Campanha'] . '">
										<span class="glyphicon glyphicon-edit notclickable"></span>
									</a>
								</td>';
							echo '<td>' . $row['idApp_Campanha'] . '</td>';
							echo '<td>' . $row['TipoCampanha'] . '</td>';
							echo '<td>' . $row['Campanha'] . '</td>';
							echo '<td>' . $row['DescCampanha'] . '</td>';
							echo '<td>' . $row['ValorDesconto'] . '</td>';
							echo '<td>' . $row['ValorMinimo'] . '</td>';
							echo '<td>' . $row['DataCampanha'] . '</td>';
							echo '<td>' . $row['DataCampanhaLimite'] . '</td>';
							echo '<td>' . $row['AtivoCampanha'] . '</td>';
							echo '<td>' . $row['Ganhador'] . '</td>';
						echo '</tr>';
						$count++;
					}
					?>

				</tbody>
				
			</table>
		</div>
	</div>
</div>