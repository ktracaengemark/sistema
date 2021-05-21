
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
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
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?>
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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


      

