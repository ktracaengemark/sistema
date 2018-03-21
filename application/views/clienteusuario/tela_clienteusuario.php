<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Clienteusuario'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Clienteusuario']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Clienteusuario']['idSis_Usuario'] . '</small>' ?></strong></div>
				<div class="panel-body">

					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Usuário & Contatos:</label>
									<div class="form-group">
										<div class="row">
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'clienteusuario/prontuario/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>
											<a <?php if (preg_match("/clienteusuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'clienteusuario/alterar/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
										</div>
									</div>									
								</div>
								<div class="col-md-4 text-center">
									<label for="">Agendamentos:</label>
									<div class="form-group">
										<div class="row">
											<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-calendar"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>	
									</div>	
								</div>
								<div class="col-md-4 text-right">
									<label for="">Orçamentos:</label>
									<div class="form-group ">
										<div class="row">
											<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-usd"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>		
									</div>	
								</div>								
							</div>
						</div>
					</div>
					<!--
					<div class="form-group">
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Clienteusuario']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Clienteusuario']['idSis_Usuario'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<?php } ?>

					<div class="row">

						<div class="col-md-12 col-lg-12">

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Usuário</strong></div>
								<div class="panel-body">
									<table class="table table-user-information">
										<tbody>

											<?php

											if ($query['Empresa']) {

											echo '
											<tr>
												<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Empresa:</td>
												<td>' . $query['Empresa'] . '</td>
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

											if ($query['Celular']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
												<td>' . $query['Celular'] . '</td>
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

											/*
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
											*/
											if ($query['Inativo']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-alert"></span> Ativo?:</td>
												<td>' . $query['Inativo'] . '</td>
											</tr>
											';

											}

											?>

										</tbody>
									</table>

									<div class="row">

										<div class="col-md-12 col-lg-12">

											<div class="panel panel-primary">

												<div class="panel-heading"><strong>Contatos</strong></div>
												<div class="panel-body">

													<?php
													if (!$list) {
													?>
														<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatofunc/cadastrar" role="button">
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
		<div class="col-md-2"></div>
	</div>
</div>
