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
							<th class="active" scope="col">Atuação</th>
							<th class="active">Nome</th>
							<th class="active">Texto</th>
							<th class="active">Ativo</th>
							<th class="active" scope="col">Editar</th>
						</tr>
					</thead>

					<tbody>
						<?php
						foreach ($report->result_array() as $row) {?>

					<!--<tr class="clickable-row" data-href="<?php echo base_url() . 'atuacao/alterar_atuacao/' . $row['idApp_Atuacao'] . ''; ?>">-->
					<tr>	
						<td><?php echo $row['idApp_Atuacao'] ?></td>						
						<td class="notclickable">
							<a class="notclickable" href="<?php echo base_url() . 'atuacao/alterar_atuacao/' . $row['idApp_Atuacao'] . ''; ?>">
								<img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo_Atuacao'] . ''; ?> "class="img-responsive" width='100'>
							</a>
						</td>
						<td><?php echo $row['Nome_Atuacao'] ?></td>
						<td><?php echo $row['Texto_Atuacao'] ?></td>
						<td><?php echo $row['Ativo_Atuacao'] ?></td>
						<td class="notclickable">
							<a class="btn btn-md btn-info notclickable" href="<?php echo base_url() . 'atuacao/alterar/' . $row['idApp_Atuacao'] . ''; ?>">
								<span class="glyphicon glyphicon-edit notclickable"></span>
							</a>
						</td>						
						<!--<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $row['Arquivo_Atuacao'] . ''; ?> "class="img-circle img-responsive" width='100'></td>-->

						<?php } ?>						
					</tbody>

				</table>
								
			</div>

	</div>
</div>
