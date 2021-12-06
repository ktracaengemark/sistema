
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ( !isset($evento) && ($_SESSION['log']['idSis_Empresa'] != 5 || $_SESSION['log']['idSis_Empresa'] == $orcatrata['idSis_Empresa'])) { ?>
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
											<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
														</a>
													</a>
												</li>
											<?php } ?>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
													</a>
												</a>
											</li>
											<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
														</a>
													</a>
												</li>
											<?php } ?>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
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
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">		
										<a href="https://api.whatsapp.com/send?phone=55<?php echo $_SESSION['Cliente']['CelularCliente'];?>&text=" target="_blank" style="">
											<svg enable-background="new 0 0 512 512" width="30" height="30" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
										</a>
									</div>
								</li>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo '<small>' . $titulo . '</small> <strong>' . $_SESSION['Cliente']['NomeCompleto'] . '</strong> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?>
							
						</div>
						<div class="panel-body">
							
							<div>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<!--<li role="presentation" class="active" ><a style="color:green" href="#combinado" aria-controls="combinado" role="tab" data-toggle="tab">Combinados <?php #echo $combinado->num_rows(); ?></a></li>-->
									<li role="presentation" ><a style="color:red" href="#naocombinado" aria-controls="naocombinado" role="tab" data-toggle="tab">Não Comb Ent <?php echo $naocombinado->num_rows(); ?></a></li>
									<li role="presentation" ><a style="color:red" href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">Não Comb Pag <?php echo $naoaprovado->num_rows(); ?></a></li>
									<li role="presentation" class="active" ><a style="color:green" href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Comb Pag <?php echo $aprovado->num_rows(); ?></a></li>
									<li role="presentation" ><a style="color:green" href="#finalizado" aria-controls="finalizado" role="tab" data-toggle="tab">Finalizado <?php echo $finalizado->num_rows(); ?></a></li>
									<!--<li role="presentation" ><a style="color:red" href="#naofinalizado" aria-controls="naofinalizado" role="tab" data-toggle="tab">Não Finalizado <?php #echo $naofinalizado->num_rows(); ?></a></li>-->
									<li role="presentation" ><a style="color:black" href="#cancelado" aria-controls="cancelado" role="tab" data-toggle="tab">Cancelado <?php echo $cancelado->num_rows(); ?></a></li>
									<!--<li role="presentation" ><a style="color:black" href="#naocancelado" aria-controls="naocancelado" role="tab" data-toggle="tab">Não Cancelado <?php #echo $naocancelado->num_rows(); ?></a></li>-->
									<li role="presentation"><a style="color:green" href="#concluido_orc" aria-controls="concluido_orc" role="tab" data-toggle="tab">Procedimentos <?php echo $concluido_orc->num_rows(); ?></a></li>
									<li role="presentation"><a style="color:red" href="#nao_concluido_orc" aria-controls="nao_concluido_orc" role="tab" data-toggle="tab">Procedimentos <?php echo $nao_concluido_orc->num_rows(); ?></a></li>
								</ul>
								
								<!-- Tab panes -->
								<div class="tab-content">

									<!-- Combinados -->
									<div role="tabpanel" class="tab-pane " id="combinado">

										<?php
										if ($combinado) {

											foreach ($combinado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>
											
											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>

											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>
									
									<!-- Não Combinados -->
									<div role="tabpanel" class="tab-pane" id="naocombinado">

										<?php
										if ($naocombinado) {

											foreach ($naocombinado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-down"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Aprovados -->
									<div role="tabpanel" class="tab-pane active" id="proxima">

										<?php
										if ($aprovado) {

											foreach ($aprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>
											

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>
											
											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>

											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Aprovados -->
									<div role="tabpanel" class="tab-pane " id="anterior">

										<?php
										if ($naoaprovado) {

											foreach ($naoaprovado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-down"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Finalizados -->
									<div role="tabpanel" class="tab-pane " id="finalizado">

										<?php
										if ($finalizado) {

											foreach ($finalizado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Finalizados -->
									<div role="tabpanel" class="tab-pane " id="naofinalizado">

										<?php
										if ($naofinalizado) {

											foreach ($naofinalizado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Cancelado -->
									<div role="tabpanel" class="tab-pane " id="cancelado">

										<?php
										if ($cancelado) {

											foreach ($cancelado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>

									<!-- Não Cancelado -->
									<div role="tabpanel" class="tab-pane " id="naocancelado">

										<?php
										if ($naocancelado) {

											foreach ($naocancelado->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>
											<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
												<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados
												</a>
											<?php } ?>
											
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Entrega
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'OrcatrataPrint/imprimircobranca/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão Cobranca
											</a>
												
											<a class="btn btn-md btn-info"  href="<?php echo base_url() . 'Orcatrata/arquivos/' . $row['idApp_OrcaTrata']; ?>" role="button">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Nº Orç.:</b> <?php echo $row['idApp_OrcaTrata']; ?>
											</h4>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Orçamento:</b> <?php echo $row['DataOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data da Entrega:</b> <?php echo $row['DataEntregaOrca']; ?>
											</h5>
											<h5>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data do Venc.:</b> <?php echo $row['DataVencimentoOrca']; ?>
											</h5>

											<p>
												<?php if ($row['ProfissionalOrca']) { ?>
												<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
												<?php } if ($row['AprovadoOrca']) { ?>
												<span class="glyphicon glyphicon-thumbs-up"></span> <b>Orç. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Entregue?</b> <?php echo $row['ConcluidoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['QuitadoOrca']) { ?>
												<span class="glyphicon glyphicon-usd"></span> <b>Orç. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['FinalizadoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Finalizado?</b> <?php echo $row['FinalizadoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['CanceladoOrca']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Orç. Cancelado?</b> <?php echo $row['CanceladoOrca']; ?>
												<?php } ?>
											</p>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Motivo:</b> <?php echo nl2br($row['ObsOrca']); ?>
											</p>

										</div>

										<?php
											}
										} else {
											echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
										}
										?>

									</div>


									<!-- Concluido-Orç -->
									<div role="tabpanel" class="tab-pane " id="concluido_orc">

										<?php
										if ($concluido_orc) {

											foreach ($concluido_orc->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

											<a class="btn btn-success" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											
											<!--	
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão para Impressão
											</a>
											-->

											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Orçam.:</b> <?php echo $row['idApp_OrcaTrata']; ?><br>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b> <?php echo $row['idApp_Procedimento']; ?> 
											</h4>
											<br>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>											
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data Conclusão</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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

									<!-- Não Concluido-Orç -->
									<div role="tabpanel" class="tab-pane " id="nao_concluido_orc">

										<?php
										if ($nao_concluido_orc) {

											foreach ($nao_concluido_orc->result_array() as $row) {
										?>

										<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

											<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $row['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados
											</a>
											<!--
											<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_Procedimento']; ?>" role="button">
												<span class="glyphicon glyphicon-print"></span> Versão para Impressão
											</a>
											-->
											<br><br>

											<h4>
												<span class="glyphicon glyphicon-tags"></span> <b>Orçam.:</b> <?php echo $row['idApp_OrcaTrata']; ?><br>
												<span class="glyphicon glyphicon-tags"></span> <b>Procd.:</b><?php echo $row['idApp_Procedimento']; ?>
											</h4>
											<br>
											<p>
												<span class="glyphicon glyphicon-pencil"></span> <b>Procedimento:</b> <?php echo nl2br($row['Procedimento']); ?>
											</p>											
											<p>
												<?php if ($row['DataProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Cadastro</b> <?php echo $row['DataProcedimento']; ?>
												<?php } ?>
											</p>
											<p>
												<?php if ($row['ConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-ok"></span> <b>Concluído:</b> <?php echo $row['ConcluidoProcedimento']; ?>
												<?php }?>
											</p>
											<p>
												<?php if ($row['DataConcluidoProcedimento']) { ?>
												<span class="glyphicon glyphicon-calendar"></span> <b>Data Conclusão</b> <?php echo $row['DataConcluidoProcedimento']; ?>
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
		<div class="col-md-1"></div>
	</div>	
</div>
