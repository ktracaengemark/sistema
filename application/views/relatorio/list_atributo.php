<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		<div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
					<tr>
						<th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
					</tr>
				</tfoot>
			</table>

			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>                       																	

						<th class="active" scope="col">Editar</th>
						<th class="active">Id.</th>
						<th class="active">Categoria</th>
						<th class="active">Atributo</th>
						<th class="active">Opcao</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($report->result_array() as $row) {?>

					<tr>	
						<td class="notclickable">
							<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'atributo/alterar2/' . $row['idTab_Atributo'] . ''; ?>">
								<span class="glyphicon glyphicon-edit notclickable"></span>
							</a>
						</td>
						<td><?php echo $row['idTab_Atributo'] ?></td>
						<td><?php echo $row['Catprod'] ?></td>
						<td><?php echo $row['Atributo'] ?></td>
						<td><?php echo $row['Opcao'] ?></td>
					</tr>
					<?php } ?>						
				</tbody>

			</table>
							
		</div>
	</div>
</div>
