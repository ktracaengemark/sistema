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
											<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Associado'] . '</small>' ?> <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/associado\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'associado/prontuario/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
														<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usuário
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
												<li>
													<a <?php if (preg_match("/associado\/associadoalterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
														<a href="<?php echo base_url() . 'associado/associadoalterar/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
															<span class="glyphicon glyphicon-edit"></span> Editar Dados do Usuário
														</a>
													</a>
												</li>
												<li role="separator" class="divider"></li>
												<!--
												<li>
													<a <?php #if (preg_match("/associado\/permissoes\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
														<a href="<?php #echo base_url() . 'associado/permissoes/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
															<span class="glyphicon glyphicon-edit"></span> Editar Permissões do Usuário
														</a>
													</a>
												</li>
												<li role="separator" class="divider"></li>
												-->
											<?php } ?>
											<li>
												<a <?php if (preg_match("/associado\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'associado/alterarsenha/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Senha
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/associado\/alterarconta\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'associado/alterarconta/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar Conta Comissão
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/associado\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'associado/alterarlogo/' . $_SESSION['Usuario']['idSis_Associado']; ?>">
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
														<label for="Nome">Nome do Associado:</label>
														<input type="text" class="form-control" id="Nome" maxlength="45" 
																autofocus name="Nome"  value="<?php echo $query['Nome']; ?>">
														<?php echo form_error('Nome'); ?>
													</div>
													<!--
													<div class="col-md-3">
														<label for="CelularAssociado">Celular*</label>
														<input type="text" class="form-control Celular CelularVariavel" id="CelularAssociado" maxlength="11" <?php #echo $readonly; ?>
															   name="CelularAssociado" placeholder="(XX)999999999" value="<?php #echo $query['CelularAssociado']; ?>">
														<?php #echo form_error('CelularAssociado'); ?>
													</div>
													-->
													<div class="col-md-3">
														<label for="DataNascimento">Data de Nascimento:</label>
														<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
															   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
														<?php echo form_error('DataNascimento'); ?>
													</div>						
												</div>
											</div>
											<div class="form-group">
												<div class="row">
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
													<div class="col-md-3">
														<label for="CpfAssociado">Cpf:</label>
														<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
															   name="CpfAssociado" value="<?php echo $query['CpfAssociado']; ?>">
													<?php echo form_error('CpfAssociado'); ?>
													</div>
													<div class="col-md-3">
														<label for="Email">E-mail:</label>
														<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
															   name="Email" value="<?php echo $query['Email']; ?>">
														<?php echo form_error('Email'); ?>
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
															<label for="RgAssociado">RG:</label>
															<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
																   name="RgAssociado" value="<?php echo $query['RgAssociado']; ?>">
														</div>
														<div class="col-md-3">
															<label for="OrgaoExpAssociado">Orgão Exp.:</label>
															<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
																   name="OrgaoExpAssociado" value="<?php echo $query['OrgaoExpAssociado']; ?>">
														</div>
														<div class="col-md-3">
															<label for="DataEmAssociado">Data de Emissão:</label>
															<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
																   name="DataEmAssociado" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmAssociado']; ?>">
															<?php echo form_error('DataEmAssociado'); ?>
														</div>
														<div class="col-md-1">
															<label for="EstadoEmAssociado">Est.:</label>
															<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																   name="EstadoEmAssociado" value="<?php echo $query['EstadoEmAssociado']; ?>">
														</div>
													</div>
												</div>	
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label for="EnderecoAssociado">Endreço:</label>
															<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																   name="EnderecoAssociado" value="<?php echo $query['EnderecoAssociado']; ?>">
														</div>
														<div class="col-md-3">
															<label for="BairroAssociado">Bairro:</label>
															<input type="text" class="form-control"  maxlength="100" <?php echo $readonly; ?>
																   name="BairroAssociado" value="<?php echo $query['BairroAssociado']; ?>">
														</div>
														<div class="col-md-3">
															<label for="MunicipioAssociado">Municipio:</label>
															<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																   name="MunicipioAssociado" value="<?php echo $query['MunicipioAssociado']; ?>">
														</div>												
														<div class="col-md-1">
															<label for="EstadoAssociado">Estado:</label>
															<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																   name="EstadoAssociado" value="<?php echo $query['EstadoAssociado']; ?>">
														</div>
														<div class="col-md-2">
															<label for="CepAssociado">Cep:</label>
															<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
																   name="CepAssociado" value="<?php echo $query['CepAssociado']; ?>">
														</div>
													</div>
												</div>
											</div>	
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idSis_Associado" value="<?php echo $_SESSION['Query']['idSis_Associado']; ?>">
											<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['Query']['idSis_Empresa']; ?>">
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