<div class="container-fluid">
	<div class="row">
		<?php if($paginacao == "S") { ?>
			<div class="col-md-1">
				<label></label><br>
				<a href="<?php echo base_url() . $caminho; ?>">
					<button class="btn btn-warning btn-md btn-block" type="button">
						<span class="glyphicon glyphicon-filter"></span> Filtros
					</button>
				</a>
			</div>
			<?php if ($editar == 1) { ?>
				<?php if ($print == 1) { ?>	
					<div class="col-md-1">
						<label></label><br>
						<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
							<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
								<span class="glyphicon glyphicon-print"></span> Imprimir
							</button>
						</a>
					</div>
				<?php } ?>	
			<?php } ?>
		<?php } ?>
		<div class="col-md-2">
			<label></label><br>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input type="text" class="form-control" disabled aria-label="Contagem" value="<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>">
			</div>
		</div>
		<div class="col-md-6 text-left">
			<?php echo $pagination; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-left">
			<div style="overflow: auto; height: 550px; ">            
				<table class="table table-bordered table-condensed table-striped">
					<thead>
						<tr>
							<th class="active">Ver</th>
							<th class="active">Cont.</th>
							<th class="active">id</th>
							<th class="active">Cliente</th>
							<th class="active">Data</th>
							<th class="active">Inicio</th>
							<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
								<th class="active">Pet</th>
							<?php } ?>
							<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
								<th class="active">Dep</th>
							<?php } ?>
							<th class="active">Evento</th>							
						</tr>
					</thead>
					<tbody>
						<?php
						$linha =  $per_page*$pagina;
						$count = 1;
						foreach ($report->result_array() as $row) {
							echo '<tr>';
								echo '<td class="notclickable">
										<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $edit . $row['id_Cliente'] . '/' . $row['idApp_Consulta'] . '">
											<span class="glyphicon glyphicon-calendar notclickable"></span>
										</a>
									</td>';
								echo '<td>' . ($linha + $count) . '</td>';	
								echo '<td>' . $row['idApp_Consulta'] . '</td>';
								echo '<td>' . $row['NomeCliente'] . '</td>';
								echo '<td>' . $row['DataInicio'] . '</td>';
								echo '<td>' . $row['HoraInicio'] . '/' . $row['HoraFim'] . '</td>';
								if($_SESSION['Empresa']['CadastrarPet'] == "S"){	
									echo '<td>' . $row['NomeClientePet'] . ' / Especie: ' . $row['Especie'] . ' / Raca: ' . $row['RacaPet'] . '
												/ Gen: ' . $row['Sexo'] . ' / Pelo: ' . $row['Pelo'] . ' / Porte: ' . $row['Porte'] . ' 
												/ Alrg: ' . $row['AlergicoPet'] . ' / Obs: ' . $row['ObsPet'] . '</td>';
								}
								if($_SESSION['Empresa']['CadastrarDep'] == "S"){	
									echo '<td>' . $row['NomeClientePet'] . '</td>';
								}				
								echo '<td>' . $row['Obs'] . '</td>';
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
