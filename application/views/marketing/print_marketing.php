<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">	
			<?php echo form_open_multipart($form_open_path); ?>
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<?php echo validation_errors(); ?>
			<div style="overflow: auto; height: auto; ">		
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="row">	
						<div class="panel panel-<?php echo $panel2; ?>">
							<div class="panel-heading">
								<div class="panel-body">
									<h3 class="text-left"><b><?php echo $titulo; ?> - Nº</b> <?php echo $marketing['idApp_Marketing']; ?></h3>
									<?php if($marketing['idApp_Cliente'] != 0) { ?>								
										<h3 class="text-left"><b>Cliente</b>: <?php echo '' . $cliente['NomeCliente'] . '' ?> - <b>ID</b>: <?php echo '' . $cliente['idApp_Cliente'] . '' ?> </h3>
									<?php }?>
									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<?php if($metodo == 2 || $metodo == 4) { ?>
													<th class="col-md-2" scope="col"><?php echo $titulo; ?></th>
												<?php } ?>
												<th class="col-md-2" scope="col">Relato</th>
												<th class="col-md-2" scope="col">Data</th>
												<th class="col-md-2" scope="col">Hora</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<?php if($metodo == 2 || $metodo == 4) { ?>
													<td><?php echo $marketing['Categoria'.$titulo] ?></td>
												<?php } ?>
												<td><?php echo $marketing['Marketing'] ?></td>
												<td><?php echo $marketing['DataMarketing'] ?></td>
												<td><?php echo $marketing['HoraMarketing'] ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</div>
	</div>
</div>