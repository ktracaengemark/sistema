<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo '<small>' . $titulo . '</small> <strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?>
						</div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation"><a style="color:green" href="#informacao_concl" aria-controls="informacao_concl" role="tab" data-toggle="tab">Solicitações <?php echo $informacao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#elogio_concl" aria-controls="elogio_concl" role="tab" data-toggle="tab">Elogios <?php echo $elogio_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#reclamacao_concl" aria-controls="reclamacao_concl" role="tab" data-toggle="tab">Reclamações <?php echo $reclamacao_concl->num_rows(); ?></a></li>
									<li role="presentation"	class="active"><a style="color:red" href="#informacao_nao_concl" aria-controls="informacao_nao_concl" role="tab" data-toggle="tab">Solicitações <?php echo $informacao_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#elogio_nao_concl" aria-controls="elogio_nao_concl" role="tab" data-toggle="tab">Elogios <?php echo $elogio_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#reclamacao_nao_concl" aria-controls="reclamacao_nao_concl" role="tab" data-toggle="tab">Reclamações <?php echo $reclamacao_nao_concl->num_rows(); ?> </a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<!-- informacao_concl -->
									<div role="tabpanel" class="tab-pane " id="informacao_concl">

										<?php
										if ($informacao_concl) {

											foreach ($informacao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'sac/imprimir_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'sac/tela_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'sac/alterar_Sac/' . $row['idApp_Sac'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Sac']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataSac']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Sac:</b> <?php echo nl2br($row['Sac']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoSac']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoSac']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- informacao_nao_concl -->
									<div role="tabpanel" class="tab-pane active" id="informacao_nao_concl">

										<?php
										if ($informacao_nao_concl) {

											foreach ($informacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'sac/imprimir_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'sac/tela_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'sac/alterar_Sac/' . $row['idApp_Sac'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Sac']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataSac']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Sac:</b> <?php echo nl2br($row['Sac']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoSac']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoSac']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- elogio concl -->
									<div role="tabpanel" class="tab-pane " id="elogio_concl">

										<?php
										if ($elogio_concl) {

											foreach ($elogio_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'sac/imprimir_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'sac/tela_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'sac/alterar_Sac/' . $row['idApp_Sac'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Sac']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataSac']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Sac:</b> <?php echo nl2br($row['Sac']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoSac']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoSac']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- elogio não concl -->
									<div role="tabpanel" class="tab-pane" id="elogio_nao_concl">

										<?php
										if ($elogio_nao_concl) {

											foreach ($elogio_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'sac/imprimir_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'sac/tela_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'sac/alterar_Sac/' . $row['idApp_Sac'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Sac']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataSac']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Sac:</b> <?php echo nl2br($row['Sac']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoSac']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoSac']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- elogio concl -->
									<div role="tabpanel" class="tab-pane " id="reclamacao_concl">

										<?php
										if ($reclamacao_concl) {

											foreach ($reclamacao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'sac/imprimir_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'sac/tela_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'sac/alterar_Sac/' . $row['idApp_Sac'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Sac']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataSac']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Sac:</b> <?php echo nl2br($row['Sac']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoSac']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoSac']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- elogio não concl -->
									<div role="tabpanel" class="tab-pane" id="reclamacao_nao_concl">

										<?php
										if ($reclamacao_nao_concl) {

											foreach ($reclamacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'sac/imprimir_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'sac/tela_Sac/' . $row['idApp_Sac']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'sac/alterar_Sac/' . $row['idApp_Sac'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Sac']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataSac']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Sac:</b> <?php echo nl2br($row['Sac']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoSac']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoSac']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoSac']; ?>
												<?php } ?>
											</p>
										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
