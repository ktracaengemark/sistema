<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="btn-menu btn-group">
								<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
											</a>
										</a>
									</li>
								</ul>
							</div>
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Or�s. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Or�amentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Or�amento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Campanha
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>			
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo '<small>' . $titulo . '</small> <strong>' . $_SESSION['Cliente']['NomeCompleto'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?>
						</div>
						<div class="panel-body">

							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation"><a style="color:green" href="#informacao_concl" aria-controls="informacao_concl" role="tab" data-toggle="tab">Solicita��es <?php echo $informacao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#elogio_concl" aria-controls="elogio_concl" role="tab" data-toggle="tab">Elogios <?php echo $elogio_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:green" href="#reclamacao_concl" aria-controls="reclamacao_concl" role="tab" data-toggle="tab">Reclama��es <?php echo $reclamacao_concl->num_rows(); ?></a></li>
									<li role="presentation"	class="active"><a style="color:red" href="#informacao_nao_concl" aria-controls="informacao_nao_concl" role="tab" data-toggle="tab">Solicita��es <?php echo $informacao_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#elogio_nao_concl" aria-controls="elogio_nao_concl" role="tab" data-toggle="tab">Elogios <?php echo $elogio_nao_concl->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#reclamacao_nao_concl" aria-controls="reclamacao_nao_concl" role="tab" data-toggle="tab">Reclama��es <?php echo $reclamacao_nao_concl->num_rows(); ?> </a></li>
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
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'procedimento/imprimir_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'procedimento/tela_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterar_Sac/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'procedimento/imprimir_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'procedimento/tela_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterar_Sac/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'procedimento/imprimir_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'procedimento/tela_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterar_Sac/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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

									<!-- elogio n�o concl -->
									<div role="tabpanel" class="tab-pane" id="elogio_nao_concl">

										<?php
										if ($elogio_nao_concl) {

											foreach ($elogio_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'procedimento/imprimir_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'procedimento/tela_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterar_Sac/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'procedimento/imprimir_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'procedimento/tela_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterar_Sac/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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

									<!-- elogio n�o concl -->
									<div role="tabpanel" class="tab-pane" id="reclamacao_nao_concl">

										<?php
										if ($reclamacao_nao_concl) {

											foreach ($reclamacao_nao_concl->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
												
											<a class="btn btn-md btn-info" href="<?php echo base_url() . 'procedimento/imprimir_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Resumida
											</a>	
											<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'procedimento/tela_Sac/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Completa
											</a>
											<a class="btn btn-success" href="<?php echo base_url() . 'procedimento/alterar_Sac/' . $row['idApp_Procedimento'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastrado em:</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Conclu�do:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Conclu�do em:</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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
