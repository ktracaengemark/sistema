<div class="container-fluid">
	<div class="row">

		<table class="table table-bordered table-condensed table-striped">	
			<tfoot>
				<tr>
					<th colspan="4" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
				</tr>
			</tfoot>
		</table>
			
		<div style="overflow: auto; height: 400px; ">	
			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<th class="col-md-2" scope="col">LogoMarca</th>
						<th class="active">Empresa</th>
						<th class="active">Nº</th>
						<th class="active">Categoria</th>
						<th class="active">Site</th>
					</tr>
				</thead>
				
				<tbody>

					<?php
					foreach ($report->result_array() as $row) {
					?>
					<tr>
					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'empresacli2/prontuario/' . $row['idSis_Empresa'] . ''; ?>">-->
						<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$row['Site'].'/' . $row['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>
						<td><?php echo $row['NomeEmpresa'] ?></td>
						<td><?php echo $row['idSis_Empresa'] ?></td>
						<td><?php echo $row['CategoriaEmpresa'] ?></td>
						<td class="notclickable">
							<a href="https://www.enkontraki.com.br/<?php echo '' . $row['Site'] . '' ?> "target="_blank">
								<button type="button" class="btn btn-info">
									<h4><span class="glyphicon glyphicon-picture"></span> Site </h4>
								</button>
							</a>
						</td>						
					</tr>						

					<?php
					}
					?>

				</tbody>

			</table>

		</div>

	</div>

</div>
