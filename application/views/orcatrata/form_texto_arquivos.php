<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-12">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>	
			<?php if ( !isset($evento) && isset($orcatrata) && ($_SESSION['log']['idSis_Empresa'] != 5 || $_SESSION['log']['idSis_Empresa'] == $orcatrata['idSis_Empresa'])) { ?>
				<?php if ($orcatrata['idApp_Cliente'] != 150001 && $orcatrata['idApp_Cliente'] != 1 && $orcatrata['idApp_Cliente'] != 0) { ?>
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
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $orcatrata['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
												<a href="<?php echo base_url() . 'cliente/alterar/' . $orcatrata['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $orcatrata['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
												</a>
											</a>
										</li>
									</ul>
								</div>
								<!--
								<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $orcatrata['idApp_Cliente']; ?>">
									<?php #echo '<small>' . $orcatrata['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
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
														<a href="<?php echo base_url() . 'consulta/listar/' . $orcatrata['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
														</a>
													</a>
												</li>
												<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
													<li role="separator" class="divider"></li>
													<li>
														<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
															<a href="<?php echo base_url() . 'consulta/cadastrar/' . $orcatrata['idApp_Cliente']; ?>">
																<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
															</a>
														</a>
													</li>
												<?php } ?>
											</ul>
										</div>									
									</li>								
									<?php if ($orcatrata['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-usd"></span> Orcs. <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'orcatrata/listar/' . $orcatrata['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
														</a>
													</a>
												</li>
												<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
													<li role="separator" class="divider"></li>
													<li>
														<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
															<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $orcatrata['idApp_Cliente']; ?>">
																<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
															</a>
														</a>
													</li>
												<?php } ?>
											</ul>
										</div>
									</li>
									<?php } ?>
									<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
										<li class="botoesnav" role="toolbar" aria-label="...">
											<div class="btn-group">
												<a type="button" class="btn btn-md btn-default " href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $orcatrata['idApp_OrcaTrata']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Editar
												</a>
											</div>									
										</li>
									<?php } ?>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<a type="button" class="btn btn-md btn-warning " href="<?php echo base_url() . 'orcatrata/arquivos/' . $orcatrata['idApp_OrcaTrata']; ?>">
												<span class="glyphicon glyphicon-picture"></span> Arquivos
											</a>
										</div>									
									</li>	
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<a type="button" class="btn btn-md btn-default " href="<?php echo base_url() . 'orcatrataprint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Impressao
											</a>
										</div>									
									</li>
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
				<?php } else if ($orcatrata['idApp_OrcaTrata'] != 1 && $orcatrata['idApp_OrcaTrata'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<a class="navbar-brand" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $orcatrata['idApp_OrcaTrata']; ?>">
								<span class="glyphicon glyphicon-edit"></span> Atualizar Status	"<?php echo $orcatrata['Tipo_Orca'];?>"									
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar btn-lg navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group " role="group" aria-label="...">
										<a href="javascript:window.print()">
											<button type="button" class="btn btn-md btn-default ">
												<span class="glyphicon glyphicon-print"></span>
											</button>
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
					<div class="col-md-12 ">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
		
		
		
			<div class="col-sm-offset-3 col-md-6 ">	

				<div class="panel panel-<?php echo $panel; ?>">			
					<div class="panel-body">
						
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4>
									<b>
										Orcamento: <?php echo $_SESSION['Arquivos']['idApp_OrcaTrata'] ?><br>
										Arquivo: <?php echo $_SESSION['Arquivos']['idApp_Arquivos'] ?>
									</b>
								</h4>	
								<div class="row">																
									<div class="col-md-6">
										<label for="Texto_Arquivos">Texto:*</label><br>
										<input type="text" class="form-control" maxlength="200"
												name="Texto_Arquivos" value="<?php echo $arquivos['Texto_Arquivos'] ?>">
									</div>
									<div class="col-md-6 text-left">
										<label for="Ativo_Arquivos">Slide Ativo_Arquivos?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['Ativo_Arquivos'] as $key => $row) {
												if (!$arquivos['Ativo_Arquivos']) $arquivos['Ativo_Arquivos'] = 'N';

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($arquivos['Ativo_Arquivos'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="Ativo_Arquivos_' . $hideshow . '">'
													. '<input type="radio" name="Ativo_Arquivos" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="Ativo_Arquivos_' . $hideshow . '">'
													. '<input type="radio" name="Ativo_Arquivos" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
									</div>							
								</div>
							</div>	
						</div>		
						

						<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
						<div class="form-group">
							<div class="row">
								<input type="hidden" name="idApp_Arquivos" value="<?php echo $arquivos['idApp_Arquivos']; ?>">
								<?php if ($metodo == 2) { ?>
									<div class="col-md-6">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
									<div class="col-md-4 text-center">
											<a class="btn btn-warning btn-lg" href="<?php echo base_url() . 'orcatrata/arquivos/' . $_SESSION['Arquivos']['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-file"></span> Voltar
											</a>
									</div>
								<?php } else { ?>
									<div class="col-md-6">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
						</form>

					</div>

				</div>

			</div>
		</div>
	</div>
</div>