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
							<th class="active" scope="col">Im.CT</th>
							<th class="active">Id.CT</th>
							<th class="active" scope="col">Im.Prom</th>
							<th class="active">Id</th>
							<th class="active" scope="col">Editar</th>
							<th class="active">Ativo</th>
							<th class="active">Tipo</th>
							<th class="active">Categoria</th>
							<th class="active">Titulo</th>
							<th class="active">Descricao</th>
							<th class="active">Valor</th>
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'promocao/alterarlogo/' . $row['idTab_Promocao'] . ''; ?>">-->
						<tr>
							<td class="notclickable">
								<a class="notclickable" href="<?php echo base_url() . 'promocao/alterarlogocatprom/' . $row['idTab_Catprom'] . ''; ?>">
									<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $row['ArquivoCatprom'] . ''; ?> "class="img-circle img-responsive" width='50'>
								</a>
							</td>
							<td><?php echo $row['idTab_Catprom'] ?></td>	
							<td class="notclickable">
								<a class="notclickable" href="<?php echo base_url() . 'promocao/alterarlogo/' . $row['idTab_Promocao'] . ''; ?>">
									<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $row['ArquivoPromocao'] . ''; ?> "class="img-circle img-responsive" width='50'>
								</a>
							</td>
							<td><?php echo $row['idTab_Promocao'] ?></td>
							<td class="notclickable">
								<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'promocao/tela_promocao/' . $row['idTab_Promocao'] . ''; ?>">
									<span class="glyphicon glyphicon-edit notclickable"></span>
								</a>
							</td>						
							<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->
							<td><?php echo $row['Ativo'] ?></td>
							<td><?php echo $row['Desconto'] ?></td>
							<td><?php echo $row['Catprom'] ?></td>
							<td><?php echo $row['Promocao'] ?></td>
							<td><?php echo $row['Descricao'] ?></td>
							<td>R$<?php echo $row['SubTotal2'] ?></td>
						</tr>
						<?php } ?>						
					</tbody>

				</table>
								
			</div>

		

	</div>
</div>
