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
									<li role="presentation"><a style="color:green" href="#atualizacao_concl" aria-controls="atualizacao_concl" role="tab" data-toggle="tab">Atualiz. <?php echo $atualizacao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#pesquisa_concl" aria-controls="pesquisa_concl" role="tab" data-toggle="tab">Pesquisa <?php echo $pesquisa_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#retorno_concl" aria-controls="retorno_concl" role="tab" data-toggle="tab">Retorno <?php echo $retorno_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#promocao_concl" aria-controls="promocao_concl" role="tab" data-toggle="tab">Promoção <?php echo $promocao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#felicitacao_concl" aria-controls="felicitacao_concl" role="tab" data-toggle="tab">Felicitacao <?php echo $felicitacao_concl->num_rows(); ?></a></li>
									<li role="presentation"	class="active"><a style="color:red" href="#atualizacao_nao_concl" aria-controls="atualizacao_nao_concl" role="tab" data-toggle="tab">Atualiz. <?php echo $atualizacao_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#pesquisa_nao_concl" aria-controls="pesquisa_nao_concl" role="tab" data-toggle="tab">Pesquisa <?php echo $pesquisa_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#retorno_nao_concl" aria-controls="retorno_nao_concl" role="tab" data-toggle="tab">Retorno <?php echo $retorno_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#promocao_nao_concl" aria-controls="promocao_nao_concl" role="tab" data-toggle="tab">Promocao <?php echo $promocao_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#felicitacao_nao_concl" aria-controls="felicitacao_nao_concl" role="tab" data-toggle="tab">Felicitacao <?php echo $felicitacao_nao_concl->num_rows(); ?></a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<!-- atualizacao_concl-->
									<div role="tabpanel" class="tab-pane" id="atualizacao_concl">

										<?php
										if ($atualizacao_concl) {

											foreach ($atualizacao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- atualizacao_nao_concl -->
									<div role="tabpanel" class="tab-pane active" id="atualizacao_nao_concl">

										<?php
										if ($atualizacao_nao_concl) {

											foreach ($atualizacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- pesquisa_concl-->
									<div role="tabpanel" class="tab-pane" id="pesquisa_concl">

										<?php
										if ($pesquisa_concl) {

											foreach ($pesquisa_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- pesquisa_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="pesquisa_nao_concl">

										<?php
										if ($pesquisa_nao_concl) {

											foreach ($pesquisa_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- retorno_concl-->
									<div role="tabpanel" class="tab-pane" id="retorno_concl">

										<?php
										if ($retorno_concl) {

											foreach ($retorno_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- retorno_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="retorno_nao_concl">

										<?php
										if ($retorno_nao_concl) {

											foreach ($retorno_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- promocao_concl-->
									<div role="tabpanel" class="tab-pane" id="promocao_concl">

										<?php
										if ($promocao_concl) {

											foreach ($promocao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- promocao_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="promocao_nao_concl">

										<?php
										if ($promocao_nao_concl) {

											foreach ($promocao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- felicitacao_concl-->
									<div role="tabpanel" class="tab-pane" id="felicitacao_concl">

										<?php
										if ($felicitacao_concl) {

											foreach ($felicitacao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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

									<!-- felicitacao_nao_concl -->
									<div role="tabpanel" class="tab-pane" id="felicitacao_nao_concl">

										<?php
										if ($felicitacao_nao_concl) {

											foreach ($felicitacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'marketing/imprimir_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'marketing/tela_Marketing/' . $row['idApp_Marketing']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'marketing/alterar_Marketing/' . $row['idApp_Marketing'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Campanha
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Marketing']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataMarketing']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Marketing:</b> <?php echo nl2br($row['Marketing']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoMarketing']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoMarketing']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Concluído em:</b> <?php echo $row['DataConcluidoMarketing']; ?>
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
