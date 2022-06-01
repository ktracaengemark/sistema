
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">	
			<?php echo form_open_multipart($form_open_path); ?>
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<?php echo validation_errors(); ?>
			<div style="overflow: auto; height: auto; ">		
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="row">
					<?php if (isset($msg)) echo $msg; ?>
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
												<?php if($metodo == 1 || $metodo == 3) { ?>
													<th class="col-md-2" scope="col"><?php echo 'Tipo '.$titulo; ?></th>
												<?php } ?>
												<th class="col-md-2" scope="col">Relato</th>
												<th class="col-md-2" scope="col">Data</th>
												<th class="col-md-2" scope="col">Hora</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<?php if($metodo == 1 || $metodo == 3) { ?>
													<td><?php echo $marketing['Categoria'.$titulo] ?></td>
												<?php } ?>
												<td><?php echo $marketing['Marketing'] ?></td>
												<td><?php echo $marketing['DataMarketing'] ?></td>
												<td><?php echo $marketing['HoraMarketing'] ?></td>
											</tr>
										</tbody>
									</table>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<?php if( isset($count['PMCount']) ) { ?>
									<h3 class="text-left"><b>Ações</b></h3>

									<table class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="col-md-2" scope="col">Ação</th>
												<th class="col-md-2" scope="col">Data</th>
												<th class="col-md-2" scope="col">Hora</th>
											</tr>
										</thead>

										<tbody>

											<?php
											for ($i=1; $i <= $count['PMCount']; $i++) {
												
											?>

											<tr>
												<td class="col-md-2" scope="col"><?php echo $i ?>) <?php echo $submarketing[$i]['SubMarketing'] ?></td>
												<td class="col-md-2" scope="col"><?php echo $submarketing[$i]['DataSubMarketing'] ?></td>
												<td class="col-md-2" scope="col"><?php echo $submarketing[$i]['HoraSubMarketing'] ?></td>
											</tr>
											
											<?php
											}
											?>
										</tbody>
									</table>
									<?php } else echo '<h3 class="text-left">S/Ações</h3>';{?>
									<?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</div>
	</div>
</div>