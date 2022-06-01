
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
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
									<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
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
											<a <?php if (preg_match("/cliente\/alterar_status\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a href="<?php echo base_url() . 'cliente/alterar_status/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Alterar Status do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/contatocliente\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
												</a>
											</a>
										</li>
										<?php if ($_SESSION['Empresa']['CadastrarPet'] == 'S') { ?>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/clientepet\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-user"></span> Pets do Cliente
													</a>
												</a>
											</li>
										<?php } ?>	
										<?php if ($_SESSION['Empresa']['CadastrarDep'] == 'S') { ?>	
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/clientedep\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-user"></span> Dependentes do Cliente
													</a>
												</a>
											</li>
										<?php } ?>
									</ul>
								</div>
									<!--
									<a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<?php echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>|<small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?>
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
												<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
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
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<?php if ($msg) echo $msg; ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<strong>Cliente: </strong>
							<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?>
						</div>
						<div class="panel-body">				
							<div style="overflow: auto; height: 500px; ">																											 
								<div class="form-group">	
									<div class="row">
										
										<div class=" col-md-6">	
											<div class="row">	
												<div class="col-sm-offset-2 col-md-10 " align="left"> 
													<a href="<?php echo base_url() . 'cliente/alterarlogo/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $_SESSION['Cliente']['Arquivo'] . ''; ?>" class="img-circle img-responsive" width='200'>
													</a>													
												</div>
											</div>		
										</div>
										
										<div class=" col-md-6">								
											<table class="table table-user-information">
												<tbody>
													
													<?php 
														
														if ($query['idSis_Empresa']) {
															
															echo ' 
															<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-home"></span> Empresa:</td>
															<td>' . $query['idSis_Empresa'] . '</td>
															</tr>  
															';
															
														}
														
														if ($query['NomeCliente']) {
															
															echo ' 
															<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Cliente:</td>
															<td>' . $query['NomeCliente'] . '</td>
															</tr>  
															';
															
														}
														
														if ($query['RegistroFicha']) {
															
															echo ' 
															<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Ficha N°:</td>
															<td>' . $query['RegistroFicha'] . '</td>
															</tr>  
															';
															
														}
														
														if ($query['DataNascimento']) {
															
															echo '                         
															<tr>
															<td><span class="glyphicon glyphicon-gift"></span> Data de Nascimento:</td>
															<td>' . $query['DataNascimento'] . '</td>
															</tr>
															<tr>
															<td><span class="glyphicon glyphicon-gift"></span> Idade:</td>
															<td>' . $query['Idade'] . ' anos</td>
															</tr>                        
															';
															
														}
														
														if ($query['Telefone']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
															<td>' . $query['Telefone'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['Sexo']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
															<td>' . $query['Sexo'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['CepCliente']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-envelope"></span> Cep:</td>
															<td>' . $query['CepCliente'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['EnderecoCliente'] || 
														$query['NumeroCliente'] ||  
														$query['ComplementoCliente'] ||  
														$query['BairroCliente'] ||   
														$query['MunicipioCliente'] ||
														$query['EstadoCliente']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-home"></span>Endereço:</td>
															<td>' . $query['EnderecoCliente'] . 
															' - ' . $query['NumeroCliente'] .
															' - ' . $query['ComplementoCliente'] .
															' - ' . $query['BairroCliente'] . 
															' - ' . $query['MunicipioCliente'] . 
															' - ' . $query['EstadoCliente'] .
															'</td>
															</tr>
															';
															
														}
														
														if ($query['ReferenciaCliente']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Ref.:</td>
															<td>' . $query['ReferenciaCliente'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['CpfCliente']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> CpfCliente:</td>
															<td>' . $query['CpfCliente'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['Rg'] || $query['OrgaoExp'] || $query['EstadoCliente'] || $query['DataEmissao']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Rg:</td>
															<td>' . $query['Rg'] . ' - ' . $query['OrgaoExp'] . ' - ' . $query['EstadoCliente'] . ' - ' . $query['DataEmissao'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['Email']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
															<td>' . $query['Email'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['Obs']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-file"></span> Obs:</td>
															<td>' . nl2br($query['Obs']) . '</td>
															</tr>
															';
															
														}
														
														if ($query['Profissional']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-user"></span> Profissional:</td>
															<td>' . $query['Profissional'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['ClienteConsultor']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-alert"></span> Cliente Consultor:</td>
															<td>' . $query['ClienteConsultor'] . '</td>
															</tr>
															';
															
														}
														
														if ($query['Ativo']) {
															
															echo '                                                 
															<tr>
															<td><span class="glyphicon glyphicon-alert"></span> Ativo:</td>
															<td>' . $query['Ativo'] . '</td>
															</tr>
															';
															
														}
													?>
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="row">
									
									<div class="col-md-12 col-lg-12">
										
										<div class="panel panel-primary">
											
											<div class="panel-heading"><strong>Contato</strong></div>
											<div class="panel-body">
												
												
												<?php
													if (!$list) {
													?>
													<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>contatocliente/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Cad.
													</a>
													<br><br>
													<div class="alert alert-info" role="alert"><b>Nenhum Cad.</b></div>
													<?php
														} else {
														echo $list;
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
	</div>	
</div>




