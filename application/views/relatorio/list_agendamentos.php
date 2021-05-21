<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: 550px; ">            
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th class="active">Ver</th>
						<th class="active">Cont.</th>
						<th class="active">id</th>
						<th class="active">Data</th>
						<th class="active">Inicio</th>
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
							<th class="active">Pet</th>
						<?php } ?>
						<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
							<th class="active">Dep</th>
						<?php } ?>
						<th class="active">Cliente</th>
						<th class="active">Evento</th>							
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					foreach ($report->result_array() as $row) {
						echo '<tr>';
							echo '<td class="notclickable">
									<a class="btn btn-md btn-' . $panel . ' notclickable" href="' . base_url() . $edit . $row['id_Cliente'] . '/' . $row['idApp_Consulta'] . '">
										<span class="glyphicon glyphicon-calendar notclickable"></span>
									</a>
								</td>';
							echo '<td>' . $count . '</td>';	
							echo '<td>' . $row['idApp_Consulta'] . '</td>';
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
							echo '<td>' . $row['NomeCliente'] . '</td>';
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
