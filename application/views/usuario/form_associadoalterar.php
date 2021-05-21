<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				<div class="panel-body">
					
					<div class="row">
							
						<div class="col-md-12">	
							<?php #echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

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
											<?php } ?>
											<li>
												<a <?php if (preg_match("/usuario2\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'usuario2/alterarsenha/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Senha
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
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
									<div class="panel panel-info">
										<div class="panel-heading">
											<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<label for="Nome">Nome do Usuário:</label>
														<input type="text" class="form-control" id="Nome" maxlength="45" 
																autofocus name="Nome"  value="<?php echo $query['Nome']; ?>">
														<?php echo form_error('Nome'); ?>
													</div>
													<!--
													<div class="col-md-3">
														<label for="CelularUsuario">Tel.- Fixo ou Celular*</label>
														<input type="text" class="form-control Celular CelularVariavel" id="CelularUsuario" maxlength="11" <?php #echo $readonly; ?>
															   name="CelularUsuario" placeholder="(XX)999999999" value="<?php #echo $query['CelularUsuario']; ?>">
														<?php #echo form_error('CelularUsuario'); ?>
													</div>
													-->
													<div class="col-md-3">
														<label for="DataNascimento">Data de Nascimento:</label>
														<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
															   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
													</div>						
													<div class="col-md-3">
														<label for="Sexo">Sexo:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="Sexo" name="Sexo">
															<option value="">--Selec. o Sexo--</option>
															<?php
															foreach ($select['Sexo'] as $key => $row) {
																if ($query['Sexo'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>						
												</div>
											</div>
											<!--
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">	
														<label for="idSis_Empresa">Empresa:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> readonly=""
																id="idSis_Empresa" name="idSis_Empresa">

															<?php
															/*
															foreach ($select['idSis_Empresa'] as $key => $row) {
																if ($query['idSis_Empresa'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															*/
															?>
														</select>
													</div>
												</div>
											</div>
											-->
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="CpfUsuario">Cpf:</label>
														<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
															   name="CpfUsuario" value="<?php echo $query['CpfUsuario']; ?>">
													<?php echo form_error('CpfUsuario'); ?>
													</div>
													<div class="col-md-3">
														<label for="Email">E-mail:</label>
														<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
															   name="Email" value="<?php echo $query['Email']; ?>">
														<?php echo form_error('Email'); ?>
													</div>
													<div class="col-md-3">
														<label for="Inativo">Ativo?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Inativo'] as $key => $row) {
																	(!$query['Inativo']) ? $query['Inativo'] = '0' : FALSE;

																	if ($query['Inativo'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																		. '<input type="radio" name="Inativo" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																		. '<input type="radio" name="Inativo" id="radiobutton" '
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
											<div class="form-group">
												<div class="row">
													<div class="col-md-12 text-center">
														<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
															<span class="glyphicon glyphicon-menu-down"></span> Completar Dados
														</button>
													</div>
												</div>
											</div>
											<div <?php echo $collapse; ?> id="DadosComplementares">
												<div class="form-group">
													<div class="row">		
														<div class="col-md-3">
															<label for="RgUsuario">RG:</label>
															<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
																   name="RgUsuario" value="<?php echo $query['RgUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="OrgaoExpUsuario">Orgão Exp.:</label>
															<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
																   name="OrgaoExpUsuario" value="<?php echo $query['OrgaoExpUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="DataEmUsuario">Data de Emissão:</label>
															<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
																   name="DataEmUsuario" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmUsuario']; ?>">
														</div>
														<div class="col-md-1">
															<label for="EstadoEmUsuario">Est.:</label>
															<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																   name="EstadoEmUsuario" value="<?php echo $query['EstadoEmUsuario']; ?>">
														</div>
													</div>
												</div>	
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label for="EnderecoUsuario">Endreço:</label>
															<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																   name="EnderecoUsuario" value="<?php echo $query['EnderecoUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="BairroUsuario">Bairro:</label>
															<input type="text" class="form-control"  maxlength="100" <?php echo $readonly; ?>
																   name="BairroUsuario" value="<?php echo $query['BairroUsuario']; ?>">
														</div>
														<div class="col-md-3">
															<label for="MunicipioUsuario">Municipio:</label>
															<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																   name="MunicipioUsuario" value="<?php echo $query['MunicipioUsuario']; ?>">
														</div>												
														<div class="col-md-1">
															<label for="EstadoUsuario">Estado:</label>
															<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																   name="EstadoUsuario" value="<?php echo $query['EstadoUsuario']; ?>">
														</div>
														<div class="col-md-2">
															<label for="CepUsuario">Cep:</label>
															<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
																   name="CepUsuario" value="<?php echo $query['CepUsuario']; ?>">
														</div>
													</div>
												</div>
											</div>	
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idSis_Usuario" value="<?php echo $_SESSION['Query']['idSis_Usuario']; ?>">
											<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['Query']['idSis_Empresa']; ?>">
											<!--<input type="hidden" name="idSis_Usuario" value="<?php #echo $query['idSis_Usuario']; ?>">
											<input type="hidden" name="idSis_Empresa" value="<?php #echo $query['idSis_Empresa']; ?>">-->
											<?php if ($metodo == 2) { ?>

												<div class="col-md-6">
													<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>

											<?php } else { ?>
												<div class="col-md-6">
													<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
											<?php } ?>
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