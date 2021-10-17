<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-primary">
				<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados da Empresa
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
						</ul>
					</div>
				</div>
				<?php } ?>
				<div class="panel-body">	
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/usuario\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
											<a href="<?php echo base_url() . 'usuario/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usuário
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/usuario\/atuacoes\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'usuario/atuacoes/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Atuações do Usuário
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/usuario\/permissoes\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'usuario/permissoes/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Permissões do Usuário
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/usuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'usuario/alterar/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usuário
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/usuario\/alterar2\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'usuario/alterar2/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Senha do Usuário
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/usuario\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'usuario/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Foto
											</a>
										</a>
									</li>									
								</ul>
							</div>
						</div>	
						<?php } ?>
						<div class="panel-body">

							<div style="overflow: auto; height: 500px; ">
								<div class="form-group">	
									<div class="row">
										<div class=" col-md-6">	
											<div class="row">	
												<div class="col-sm-offset-2 col-md-10 " align="left">
													<a href="<?php echo base_url() . 'usuario/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $_SESSION['Usuario']['Arquivo'] . ''; ?>" 
														class="img-circle img-responsive" width='200'>
													</a>
												</div>
											</div>		
										</div>
										<div class=" col-md-6">
											<table class="table table-user-information">
												<tbody>

													<?php

													if ($query['Nome']) {

													echo '
													<tr>
														<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Usuário:</td>
														<td>' . $query['Nome'] . '</td>
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

													if ($query['CelularUsuario']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
														<td>' . $query['CelularUsuario'] . '</td>
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

													if ($query['Email']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
														<td>' . $query['Email'] . '</td>
													</tr>
													';

													}
													
													if ($query['CpfUsuario']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-envelope"></span> CPF:</td>
														<td>' . $query['CpfUsuario'] . '</td>
													</tr>
													';

													}
													
													if ($query['RgUsuario']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-envelope"></span> RG:</td>
														<td>' . $query['RgUsuario'] . '</td>
													</tr>
													';

													}


													if ($query['Permissao']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-alert"></span> Nível:</td>
														<td>' . $query['Permissao'] . '</td>
													</tr>
													';

													}

													if ($query['Funcao']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-alert"></span> Função:</td>
														<td>' . $query['Funcao'] . '</td>
													</tr>
													';

													}

													if ($query['Inativo']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-alert"></span> Ativo?:</td>
														<td>' . $query['Inativo'] . '</td>
													</tr>
													';

													}
													
													if ($query['CompAgenda']) {

													echo '
													<tr>
														<td><span class="glyphicon glyphicon-alert"></span> Comp. Agd.?</td>
														<td>' . $query['CompAgenda'] . '</td>
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
													<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
														<span class="glyphicon glyphicon-file"></span> Contatos <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li>
															<a <?php if (preg_match("/contatousuario\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar/    ?>>
																<a href="<?php echo base_url() . 'contatousuario/cadastrar/' ?>">
																	<span class="glyphicon glyphicon-plus"></span> Cadastrar Contato
																</a>
															</a>
														</li>
													</ul>
												</div>
											</div>											
											
											<div class="panel-body">

												<?php
												if (!$list) {
												?>
													<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>contatousuario/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Novo Contato
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
