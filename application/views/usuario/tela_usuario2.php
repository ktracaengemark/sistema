<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Usuario'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">	
						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $titulo; ?>
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
		</div>
	</div>
<?php } ?>
