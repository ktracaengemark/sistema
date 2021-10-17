<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-1 col-md-10">
		<?php echo form_open_multipart($form_open_path); ?>
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
												<a <?php if (preg_match("/usuario\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'usuario/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver Dados do Usuário
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
											<!--
											<li role="separator" class="divider"></li>
											<li>
												<a <?php #if (preg_match("/usuario\/alterar2\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php #echo base_url() . 'usuario/alterar2/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Alterar Senha do Usuário
													</a>
												</a>
											</li>
											-->
										</ul>
									</div>
								</div>
								<div class="panel-body">
									<div class="panel panel-info">
										<div class="panel-heading">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
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
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">	
														<label for="idSis_Empresa">Empresa:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> readonly=""
																id="idSis_Empresa" name="idSis_Empresa">

															<?php
															foreach ($select['idSis_Empresa'] as $key => $row) {
																if ($query['idSis_Empresa'] == $key) {
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
														<?php echo form_error('Permissao'); ?>
													</div>													
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-12 text-left">	
																<label  for="Funcao">Funçao:</label>
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																		id="Funcao" name="Funcao">
																	<option value="">-- Sel. Função --</option>
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
														</div>	
														<div class="row">
															<div class="col-md-6 text-left">
																<label class="sr-only" for="Cadastrar">Cadastrar no BD</label>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Cadastrar'] as $key => $row) {
																		if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';

																		($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($cadastrar['Cadastrar'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
																			. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
																			. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																
																</div>
																<?php echo form_error('Funcao'); ?>
															</div>
														</div>	
														<div class="row">														
															<div class="col-md-6 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
																<div class="row">	
																	<div class="col-md-6 text-left">	
																		<label >Funcao</label><br>
																		<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#addFuncaoModal">
																			Cad./Edit./Excl.
																		</button>
																	</div>
																	<div class="col-md-6 text-left">
																		<label >Recarregar</label><br>
																		<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																				<span class="glyphicon glyphicon-refresh"></span>Recarregar
																		</button>
																	</div>	
																</div>
																<!--
																<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>funcao2/cadastrar3/" role="button"> 
																	<span class="glyphicon glyphicon-plus"></span>Fu
																</a>
																
																<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																		<span class="glyphicon glyphicon-refresh"></span>
																</button>
																-->
																<?php echo form_error('Cadastrar'); ?>
															</div>
														</div>
														
													</div>
													<!--
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
													-->
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="CpfUsuario">Cpf:</label>
														<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
															   name="CpfUsuario" value="<?php echo $query['CpfUsuario']; ?>">
													<?php echo form_error('CpfUsuario'); ?>
													</div>
													<!--
													<div class="col-md-3">
														<label for="Senha">Senha:</label>
														<input type="password" class="form-control" id="Senha" maxlength="45"
															   name="Senha" value="<?php #echo $query['Senha']; ?>">
														<?php #echo form_error('Senha'); ?>
													</div>
													<div class="col-md-3">
														<label for="Senha">Confirmar Senha:</label>
														<input type="password" class="form-control" id="Confirma" maxlength="45"
															   name="Confirma" value="<?php #echo $query['Confirma']; ?>">
														<?php #echo form_error('Confirma'); ?>
													</div>
													-->
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
												<!--
												<div class="form-group">
													<div class="row">		
														
														<div class="col-md-3">
															<label for="Usuario">Usuário:</label>
															<input type="text" class="form-control" id="Usuario" maxlength="45" 
																   name="Usuario" value="<?php echo $query['Usuario']; ?>">
															<?php #echo form_error('Usuario'); ?>
														</div>
														
													</div>
												</div>
												-->
											</div>	
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
											<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
											<?php if ($metodo == 2) { ?>

												<div class="col-md-6">
													<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
												<!--
												<div class="col-md-6 text-right">
													<button  type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
														<span class="glyphicon glyphicon-trash"></span> Excluir
													</button>
												</div>
												-->
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
																	<a class="btn btn-danger" href="<?php echo base_url() . 'usuario/excluir/' . $query['idSis_Usuario'] ?>" role="button">
																		<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>

											<?php } elseif ($metodo == 3) { ?>
												<div class="col-md-12 text-center">
													<button class="btn btn-sm btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
														<span class="glyphicon glyphicon-trash"></span> Excluir
													</button>
													<button class="btn btn-sm btn-warning" id="inputDb" onClick="history.go(-1);
															return true;">
														<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
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
										<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header bg-success text-center">
														<h4 class="modal-title" id="visulClienteModalLabel">Cadastrado com sucesso!</h4>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														  <span aria-hidden="true">&times;</span>
														</button>
													</div>
													<!--
													<div class="modal-body">
														Cliente cadastrado com sucesso!
													</div>
													-->
													<div class="modal-footer">
														<div class="col-md-6">	
															<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
																<span class="glyphicon glyphicon-filter"></span> Fechar
															</button>
															<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
																Aguarde um instante! Estamos processando sua solicitação!
															</div>
														</div>
														<!--<button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>-->
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
		</form>	
		</div>
	</div>	
</div>

<div id="addFuncaoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addFuncaoModalLabel">Cadastrar Funcao</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-funcao"></span>
				<form method="post" id="insert_funcao_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Funcao</label>
						<div class="col-sm-10">
							<input name="Novo_Funcao" type="text" class="form-control" id="Novo_Funcao" placeholder="Funcao">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Abrev</label>
						<div class="col-sm-10">
							<input name="Novo_Abrev" type="text" class="form-control" id="Novo_Abrev" placeholder="Abrev">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharFuncao" id="botaoFecharFuncao">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadFuncao" id="botaoCadFuncao" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarFuncao" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list3)) echo $list3; ?>
			</div>
		</div>
	</div>
</div>	

<div id="alterarFuncao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarFuncaoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarFuncaoLabel">Funcao</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-funcao"></span>
				<form method="post" id="alterar_funcao_form">
					<div class="form-group">
						<label for="Nome_Funcao" class="control-label">Funcao:</label>
						<input type="text" class="form-control" name="Nome_Funcao" id="Nome_Funcao">
					</div>
					<div class="form-group">
						<label for="Nome_Abrev" class="control-label">Abrev:</label>
						<input type="text" class="form-control" name="Nome_Abrev" id="Nome_Abrev">
					</div>
					<input type="hidden" name="id_Funcao" id="id_Funcao">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarFuncao" id="CancelarFuncao" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarFuncao" id="AlterarFuncao" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarFuncao" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="excluirFuncao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirFuncaoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="excluirFuncaoLabel">Funcao</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-excluir-funcao"></span>
				<form method="post" id="excluir_funcao_form">
					<div class="form-group">
						<label for="ExcluirFuncao" class="control-label">Funcao:</label>
						<input type="text" class="form-control" name="ExcluirFuncao" id="ExcluirFuncao" readonly="">
					</div>
					<div class="form-group">
						<label for="ExcluirAbrev" class="control-label">Abrev:</label>
						<input type="text" class="form-control" name="ExcluirAbrev" id="ExcluirAbrev" readonly="">
					</div>
					<input type="hidden" name="id_ExcluirFuncao" id="id_ExcluirFuncao">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarExcluirFuncao" id="CancelarExcluirFuncao" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="Excluirtributo" id="ExcluirFuncao" >Apagar</button>	
						<div class="col-md-12 alert alert-warning aguardarExcluirFuncao" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php } ?>