<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Funcionariomatriz'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Funcionariomatriz']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Funcionariomatriz']['idSis_UsuarioMatriz'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						  </button>
						  <a class="navbar-brand" href="#">Menu </a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
						
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">

									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-user"></span> Funcionário <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'funcionariomatriz/prontuario/' . $_SESSION['Funcionariomatriz']['idSis_UsuarioMatriz']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/funcionariomatriz\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'funcionariomatriz/alterar/' . $_SESSION['Funcionariomatriz']['idSis_UsuarioMatriz']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Edit.
													</a>
												</a>
											</li>
										</ul>
									</div>
									<div class="btn-group" role="group" aria-label="..."> </div>
								</li>
							</ul>
							<!--
							<ul class="nav navbar-nav navbar-right">
								<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
								<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
							</ul>
							-->
						</div>
					  </div>
					</nav>
					
					<!--
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Funcionário:</label>
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'funcionariomatriz/prontuario/' . $_SESSION['Funcionariomatriz']['idSis_UsuarioMatriz']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>
											<a <?php if (preg_match("/funcionariomatriz\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'funcionariomatriz/alterar/' . $_SESSION['Funcionariomatriz']['idSis_UsuarioMatriz']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
										</div>
									</div>	
								</div>
							</div>	
						</div>
					</div>					
					-->

					<?php } ?>
					
					<div class="row">
						<div class="col-md-12 col-lg-12">	
							
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Funcionário</strong></div>
								<div class="panel-body">
									<div class="panel panel-info">
										<div class="panel-heading">
											<?php echo form_open_multipart($form_open_path); ?>

											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="Nome">Nome do Funcionário:</label>
														<input type="text" class="form-control" id="Nome" maxlength="45" 
																name="Nome" autofocus value="<?php echo $query['Nome']; ?>">
													</div>																		
													<div class="col-md-3">
														<label for="Celular">Tel.- Fixo ou Celular*</label>
														<input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="11" <?php echo $readonly; ?>
															   name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
													</div>
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
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="CpfUsuario">Cpf:</label>
														<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
															   name="CpfUsuario" value="<?php echo $query['CpfUsuario']; ?>">
													</div>
													<div class="col-md-3">
														<label for="RgUsuario">RG:</label>
														<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
															   name="RgUsuario" value="<?php echo $query['RgUsuario']; ?>">
													</div>
													<div class="col-md-2">
														<label for="OrgaoExpUsuario">Orgão Exp.:</label>
														<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
															   name="OrgaoExpUsuario" value="<?php echo $query['OrgaoExpUsuario']; ?>">
													</div>
													<div class="col-md-1">
														<label for="EstadoEmUsuario">Est. Exp:</label>
														<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
															   name="EstadoEmUsuario" value="<?php echo $query['EstadoEmUsuario']; ?>">
													</div>
													<div class="col-md-3">
														<label for="DataEmUsuario">Data de Emissão:</label>
														<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
															   name="DataEmUsuario" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmUsuario']; ?>">
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
											<div class="form-group">
												<div class="row">
												
													<div class="col-md-3">
														<label for="Email">E-mail:</label>
														<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
															   name="Email" value="<?php echo $query['Email']; ?>">
													</div>
													<div class="col-md-2">
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
													<!--
													<div class="col-md-3">
														<label for="UsuarioMatriz">Usuário:</label>
														<input type="text" class="form-control" id="UsuarioMatriz" maxlength="45" 
															   autofocus name="UsuarioMatriz" value="<?php echo $query['UsuarioMatriz']; ?>">
														<?php echo form_error('UsuarioMatriz'); ?>
													</div>						
													<div class="col-md-3">
														<label for="Senha">Senha:</label>
														<input type="password" class="form-control" id="Senha" maxlength="45"
															   name="Senha" value="<?php echo $query['Senha']; ?>">
														<?php echo form_error('Senha'); ?>
													</div>
													<div class="col-md-3">
														<label for="Senha">Confirmar Senha:</label>
														<input type="password" class="form-control" id="Confirma" maxlength="45"
															   name="Confirma" value="<?php echo $query['Confirma']; ?>">
														<?php echo form_error('Confirma'); ?>
													</div>
													-->
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="Funcao">Funcao:*</label>
														<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>funcao/cadastrar/funcao" role="button"> 
															<span class="glyphicon glyphicon-plus"></span> <b>Nova Funcao</b>
														</a>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="Funcao" name="Funcao">
															<option value="">-- Selecione uma Funcao --</option>
															<?php
															foreach ($select['Funcao'] as $key => $row) {
																if ($query['Funcao'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>   
														</select>          
													</div>
													<div class="col-md-3">
														<label for="Permissao">Acesso às Agendas:*</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="Permissao" name="Permissao">
															<option value="">-- Selecione uma Permissao --</option>
															<?php
															foreach ($select['Permissao'] as $key => $row) {
																if ($query['Permissao'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>   
														</select>          
													</div>
													<div class="col-md-2">
														<label for="CompAgenda">Comp. Agenda?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['CompAgenda'] as $key => $row) {
																	(!$query['CompAgenda']) ? $query['CompAgenda'] = 'N' : FALSE;

																	if ($query['CompAgenda'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																		. '<input type="radio" name="CompAgenda" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																		. '<input type="radio" name="CompAgenda" id="radiobutton" '
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
											<br>
											<div class="form-group">
												<div class="row">
													<input type="hidden" name="idSis_UsuarioMatriz" value="<?php echo $query['idSis_UsuarioMatriz']; ?>">
													<?php if ($metodo == 2) { ?>

														<div class="col-md-6">
															<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																<span class="glyphicon glyphicon-trash"></span> Excluir
															</button>
														</div>

														<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header bg-danger">
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
																	</div>
																	<div class="modal-body">
																		<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
																			Esta operação é irreversível.</p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6 text-left">
																			<button type="button" class="btn btn-warning" data-dismiss="modal">
																				<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																			</button>
																		</div>
																		<div class="col-md-6 text-right">
																			<a class="btn btn-danger" href="<?php echo base_url() . 'funcionariomatriz/excluir/' . $query['idSis_UsuarioMatriz'] ?>" role="button">
																				<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																			</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>

													<?php } elseif ($metodo == 3) { ?>
														<div class="col-md-12 text-center">
															<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
																<span class="glyphicon glyphicon-trash"></span> Excluir
															</button>
															<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
																	return true;">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
													<?php } else { ?>
														<div class="col-md-6">
															<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
													<?php } ?>
												</div>
											</div>

											</form>
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
