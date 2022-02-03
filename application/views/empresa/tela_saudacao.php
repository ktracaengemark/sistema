<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Saudacao'])) { ?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-2 col-md-8">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
										<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-file"> </span> Ver Dados da Empresa
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/atendimento\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/atendimento/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Horario de Atendimento
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Alterar Logo
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/saudacao\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/saudacao/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Saudacoes
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/empresa\/pagseguro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'empresa/pagseguro/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Pag Seguro
										</a>
									</a>
								</li>								
							</ul>
						</div>
					</div>
					<div class="panel-body">
						<div style="overflow: auto; height: auto; ">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="form-group">	
										<div class="row">
											<div class=" col-md-6">	
												<div class="row">	
													<div class="col-sm-offset-2 col-md-10 " align="left"> 	
															<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"
															class="img-circle img-responsive" width='200'>
													</div>
												</div>		
											</div>
										</div>
										<h3>Agendamento</h3>
										<div class="row">	
											<div class=" col-md-12">							
												<table class="table table-user-information">
													<tbody>
														<tr>
															<td>
																<span class="glyphicon glyphicon-pencil"></span>
																<?php echo $saudacao['TextoAgenda_1']; ?>
																<?php if($saudacao['ClienteAgenda'] == "S") echo '<b>Nome do Cliente</b>'; ?>
																<?php echo $saudacao['TextoAgenda_2']; ?>
																<?php if($saudacao['ProfAgenda'] == "S") echo '<b>Nome do Profissional</b>'; ?>
																<?php echo $saudacao['TextoAgenda_3']; ?>
																<?php if($saudacao['DataAgenda'] == "S") echo '<b>Data & Hora</b>'; ?>
																<?php echo $saudacao['TextoAgenda_4']; ?>
																<?php if($saudacao['SiteAgenda'] == "S") echo '<b>Site da Empresa</b>'; ?>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<h3>Pedido</h3>
										<div class="row">	
											<div class=" col-md-12">							
												<table class="table table-user-information">
													<tbody>
														<tr>
															<td>
																<span class="glyphicon glyphicon-pencil"></span>
																<?php echo $saudacao['TextoPedido_1']; ?>
																<?php if($saudacao['ClientePedido'] == "S") echo '<b>Nome do Cliente</b>'; ?>
																<?php echo $saudacao['TextoPedido_2']; ?>
																<?php if($saudacao['idClientePedido'] == "S") echo '<b>N do Cliente</b>'; ?>
																<?php echo $saudacao['TextoPedido_3']; ?>
																<?php if($saudacao['idPedido'] == "S") echo '<b>N do Pedido</b>'; ?>
																<?php echo $saudacao['TextoPedido_4']; ?>
																<?php if($saudacao['SitePedido'] == "S") echo '<b>Site da Empresa</b>'; ?>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>		
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="btn-group">
														<a type="button" class="btn btn-sm btn-default" href="<?php echo base_url() . 'empresa/alterarsaudacao/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
															<span class="glyphicon glyphicon-edit"></span> Editar Saudacoes
														</a>
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
	</div>
<?php } ?>
