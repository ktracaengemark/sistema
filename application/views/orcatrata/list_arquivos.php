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
							<th class="active">Id.</th>
							<th class="active" scope="col">Arquivo</th>
							<th class="active">Texto</th>
							<th class="active">Ativo</th>
							<th class="active" scope="col">Editar</th>
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'orcatrata/alterar_arquivos/' . $row['idApp_Arquivos'] . ''; ?>">-->
					<tr>	
						<td><?php echo $row['idApp_Arquivos'] ?></td>						
						<td class="notclickable">
							<a class="notclickable" href="<?php echo base_url() . 'orcatrata/alterar_arquivos/' . $row['idApp_Arquivos'] . ''; ?>">
								<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivos'] . ''; ?> "class="img-responsive" width='400'>
							</a>
						</td>
						<td><?php echo $row['Texto_Arquivos'] ?></td>
						<td><?php echo $row['Ativo_Arquivos'] ?></td>
						<td class="notclickable">
							<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'orcatrata/alterar_texto/' . $row['idApp_Arquivos'] . ''; ?>">
								<span class="glyphicon glyphicon-edit notclickable"></span>
							</a>
						</td>						
						<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivos'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->

						<?php } ?>						
					</tbody>

				</table>
								
			</div>

	</div>
</div>
