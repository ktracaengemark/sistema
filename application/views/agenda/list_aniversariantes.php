<div style="overflow: auto; height: auto; ">
	<div class="container-fluid">
		<div class="row">
			<?php if($paginacao == "S") { ?>
				<div class="col-md-3">
					<label></label><br>
					<a href="<?php echo base_url() . $caminho; ?>">
						<button class="btn btn-warning btn-md btn-block" type="button">
							<span class="glyphicon glyphicon-filter"></span>Filtros
						</button>
					</a>
				</div>
			<?php } ?>
			<!--
			<div class="col-md-6">
				<label></label><br>
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php #echo $report->num_rows(); ?> / <?php #echo $total_rows; ?>">
				</div>
			</div>
			-->
			<div class="col-md-9 text-left">
				<?php echo $pagination; ?>
			</div>
		</div>	
		<div class="row">

				<!--
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Aniversariantes: <?php #echo $report->num_rows(); ?>/<?php #echo $total_rows; ?> </th>
						</tr>
					</tfoot>
				</table>
				-->
				<table class="table  table-condensed table-striped">
					<thead>
						<tr>
							<!--<th class="active">Prior.</th>-->
							<th class="active">cont</th>
							<th class="active">Clientes - <?php echo $report->num_rows(); ?>/<?php echo $total_rows; ?></th>
							<th class="active">Aniv</th>
							<th class="active">Celular</th>
						</tr>
					</thead>

					<tbody>

						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {
							$contagem = $linha + $count;
							#echo '<tr>';
							$url = base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'];
							echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
													data-toggle="tooltip" data-placement="center" title="">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">';

								/*
									echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/alterarprocedimento/' . $row['idSis_Empresa'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								*/
								
								echo '<td>' . $contagem . '</td>';
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['DataNascimento'] . '</td>';
								echo '<td>' . $row['CelularCliente'] . '</td>';
							echo '</tr>';
							$count++;
						}
						?>

					</tbody>

				</table>

			

		</div>

	</div>
</div>