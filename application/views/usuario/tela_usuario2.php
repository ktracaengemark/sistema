<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-offset-2 col-md-8">
	
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/usuario2\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'usuario2/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usuário
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
								<li>
									<a <?php if (preg_match("/usuario2\/associadoalterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/associadoalterar/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usuário
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/usuario2\/permissoes\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/permissoes/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Permissões do Usuário
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a <?php if (preg_match("/usuario2\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/alterarsenha/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Senha
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
							<?php } ?>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarconta\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarconta/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Conta Comissão
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Foto
									</a>
								</a>
							</li>									
						</ul>
					</div>
				</div>	

				<div class="panel-body">

					<div style="overflow: auto; height: auto; ">
						<div class="form-group">	
							<div class="row">
								<div class=" col-md-6">	
									<div class="row">	
										<div class="col-sm-offset-2 col-md-10 " align="left"> 
											<a href="<?php echo base_url() . 'usuario2/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
												<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/usuarios/miniatura/' . $query['Arquivo'] . ''; ?>" 
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
											
											if ($query['Banco']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-pencil"></span> Banco</td>
												<td>' . $query['Banco'] . '</td>
											</tr>
											';

											}
											
											if ($query['Agencia']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-pencil"></span> Agencia</td>
												<td>' . $query['Agencia'] . '</td>
											</tr>
											';

											}
											
											if ($query['Conta']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-pencil"></span> Conta</td>
												<td>' . $query['Conta'] . '</td>
											</tr>
											';

											}

											?>

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
<?php } ?>
