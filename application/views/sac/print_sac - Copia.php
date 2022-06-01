<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">	
			<?php echo form_open_multipart($form_open_path); ?>
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
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $query['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
												<a href="<?php echo base_url() . 'cliente/alterar/' . $query['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $query['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
												</a>
											</a>
										</li>
									</ul>
								</div>
								<!--
								<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $query['idApp_Cliente']; ?>">
									<?php #echo '<small>' . $query['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
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
														<a href="<?php echo base_url() . 'consulta/listar/' . $query['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
														</a>
													</a>
												</li>
												<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
													<li role="separator" class="divider"></li>
													<li>
														<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
															<a href="<?php echo base_url() . 'consulta/cadastrar/' . $query['idApp_Cliente']; ?>">
																<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
															</a>
														</a>
													</li>
												<?php } ?>
											</ul>
										</div>									
									</li>								
									<?php if ($query['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'orcatrata/listar/' . $query['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
														</a>
													</a>
												</li>
												<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
													<li role="separator" class="divider"></li>
													<li>
														<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
															<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $query['idApp_Cliente']; ?>">
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
											<button type="button" class="btn btn-md btn-<?php echo $cor_Sac; ?>  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/sac\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'sac/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
														</a>
													</a>
												</li>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/sac\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'sac/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Nova Chamada
														</a>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<button type="button" class="btn btn-md btn-<?php echo $cor_Marketing; ?>  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/sac\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'sac/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
														</a>
													</a>
												</li>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/sac\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'sac/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Nova Campanha
														</a>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
										<li class="botoesnav" role="toolbar" aria-label="...">
											<div class="btn-group">
												<a type="button" class="btn btn-md btn-default " href="<?php echo base_url() . 'sac/alterar_' . $alterar . '/' . $query['idApp_Sac']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Editar
												</a>
											</div>									
										</li>
									<?php } ?>	
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<a type="button" class="btn btn-md btn-default " href="<?php echo base_url() . 'sac/tela_' . $imprimir . '/' . $query['idApp_Sac']; ?>">
												<span class="glyphicon glyphicon-pencil"></span> Versão Completa
											</a>
										</div>									
									</li>	
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<a href="javascript:window.print()">
												<button type="button" class="btn btn-md btn-default ">
													<span class="glyphicon glyphicon-print"></span> Imprimir
												</button>
											</a>
										</div>									
									</li>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<!--<a href="https://api.whatsapp.com/send?phone=55<?php #echo $_SESSION['Cliente']['CelularCliente'];?>&text=" target="_blank" style="">-->
											<a href="javascript:window.open('https://api.whatsapp.com/send?phone=55<?php echo $_SESSION['Cliente']['CelularCliente'];?>&text=','1366002941508','width=700,height=250,top=300')">
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
			
			<?php echo validation_errors(); ?>
				
			<div style="overflow: auto; height: auto; ">		
				<div class="col-sm-offset-1 col-md-10 ">
					<div class="row">	
						<div class="panel panel-<?php echo $panel2; ?>">
							<div class="panel-heading">
								<div class="panel-body">
									<h3 class="text-left"><b><?php echo $titulo; ?> - Nº</b> <?php echo $sac['idApp_Sac']; ?></h3>
									<?php if($sac['idApp_Cliente'] != 0) { ?>								
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
													<td><?php echo $sac[$titulo] ?></td>
												<?php } ?>
												<td><?php echo $sac['Sac'] ?></td>
												<td><?php echo $sac['DataSac'] ?></td>
												<td><?php echo $sac['HoraSac'] ?></td>
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