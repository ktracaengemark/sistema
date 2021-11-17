<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['PagSeguro'])) { ?>
	
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
														<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">	
															<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"
															class="img-circle img-responsive" width='200'>
														</a>
													</div>
												</div>		
											</div>
										</div>
										<h3>Status do PagSeguro</h3>
										<div class="row">	
											<div class=" col-md-12">							
												<table class="table table-user-information">
													<tbody>

														<?php
														
														if ($pagseguro['Ativo_Pagseguro'] == "N") {

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-down"></span> Ativo_Pagseguro:</td>
															<td>NAO</td>
														</tr>
														';

														} else if($pagseguro['Ativo_Pagseguro'] == "S"){

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-up"></span> Ativo_Pagseguro:</td>
															<td>SIM</td>
														</tr>
														';
														}
														
														if ($pagseguro['Email_Loja']) {

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email_Loja:</td>
															<td>' . $pagseguro['Email_Loja'] . '</td>
														</tr>
														';

														} else {
														
														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email da Loja:</td>
															<td>Nao existe E-Mail Cadastrado</td>
														</tr>
														';
														}
														
														if ($pagseguro['Email_Pagseguro']) {

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email_Pagseguro:</td>
															<td>' . $pagseguro['Email_Pagseguro'] . '</td>
														</tr>
														';

														} else {
														
														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-envelope"></span> Email do PagSeguro:</td>
															<td>Nao existe E-Mail Cadastrado</td>
														</tr>
														';
														}
														
														if ($pagseguro['Token_Sandbox']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Token_Sandbox:</td>
															<td>' . $pagseguro['Token_Sandbox'] . '</td>
														</tr>
														';

														} else {
														
														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-pencil"></span> Token do Sandbox:</td>
															<td>Nao existe Token do Sandbox Cadastrado</td>
														</tr>
														';
														}

														if ($pagseguro['Prod_PagSeguro'] == "N") {

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-down"></span> Prod_PagSeguro:</td>
															<td>NAO</td>
														</tr>
														';

														} else if($pagseguro['Prod_PagSeguro'] == "S"){

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-thumbs-up"></span> Prod_PagSeguro:</td>
															<td>SIM</td>
														</tr>
														';
														}
														
														if ($pagseguro['Token_Producao']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Token_Producao:</td>
															<td>' . $pagseguro['Token_Producao'] . '</td>
														</tr>
														';

														} else {
														
														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-pencil"></span> Token do PagSeguro:</td>
															<td>Nao existe Token do PagSeguro Cadastrado</td>
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
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="btn-group">
														<a type="button" class="btn btn-sm btn-default" href="<?php echo base_url() . 'empresa/alterarpagseguro/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
															<span class="glyphicon glyphicon-edit"></span> Editar Pag Seguro
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
