<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
	
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
						<div style="overflow: auto; height: 500px; ">
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
								<div class="row">	
									<div class=" col-md-12">							
										<table class="table table-user-information">
											<tbody>

												<?php
												
												if ($query['NomeAdmin']) {

												echo '
												<tr>
													<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Admin:</td>
													<td>' . $query['NomeAdmin'] . '</td>
												</tr>
												';

												}
												
												if ($query['CpfAdmin']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-phone-alt"></span> CPF:</td>
													<td>' . $query['CpfAdmin'] . '</td>
												</tr>
												';

												}

												if ($query['CelularAdmin']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
													<td>' . $query['CelularAdmin'] . '</td>
												</tr>
												';

												}
												
												if ($query['DataCriacao']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-gift"></span> Cadastro :</td>
														<td>' . $query['DataCriacao'] . '</td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-gift"></span> Tempo:</td>
														<td>' . $query['Idade'] . ' anos</td>
												</tr>
												';

												}

												/*
												if ($query['Sexo']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
													<td>' . $query['Sexo'] . '</td>
												</tr>
												';

												}
												*/
												
												if ($query['Email']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
													<td>' . $query['Email'] . '</td>
												</tr>
												';

												}
												
												if ($query['CategoriaEmpresa']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-pencil"></span> Categoria:</td>
													<td>' . $query['CategoriaEmpresa'] . '</td>
												</tr>
												';

												}
												
												if ($query['Atuacao']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-pencil"></span> Atuacao:</td>
													<td>' . $query['Atuacao'] . '</td>
												</tr>
												';

												}
												
												if ($query['SobreNos']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-pencil"></span> Sobre Nos:</td>
													<td>' . $query['SobreNos'] . '</td>
												</tr>
												';

												}
												
												if ($query['Atendimento']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-pencil"></span> Atendimento:</td>
													<td>' . $query['Atendimento'] . '</td>
												</tr>
												';

												}

												if ($query['Site']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-envelope"></span> Site:</td>
													<td>' . $query['Site'] . '</td>
												</tr>
												';

												}
												
												if ($query['Arquivo']) {

												echo '
												<tr>
													<td><span class="glyphicon glyphicon-pencil"></span> Arquivo:</td>
													<td>' . $query['Arquivo'] . '</td>
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
													<span class="glyphicon glyphicon-file"></span> Usuarios <span class="caret"></span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a href="<?php echo base_url() . 'relatorioempresa/funcionario/' ?>">
															<span class="glyphicon glyphicon-file"></span> Relatorio de Usuarios
														</a>
													</li>
												</ul>
											</div>
										</div>										
										<div class="panel-body">
											<div style="overflow: auto; height: 600px; ">
												<?php
												if (!$list) {
												?>
													<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>usuario/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Novo Usuario
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
<?php } ?>
