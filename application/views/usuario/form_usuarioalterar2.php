<?php if ( !isset($evento) && isset($_SESSION['Revendedor'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-sm-offset-1 col-md-10">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $titulo; ?>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">	
										<?php if (isset($msg)) echo $msg; ?>
										<?php echo validation_errors(); ?>
										<?php echo form_open_multipart($form_open_path); ?>
										<div class="panel panel-info">
											<div class="panel-heading">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label for="Nome">Nome do Revendedor:</label>
															<input type="text" class="form-control" id="Nome" maxlength="45" 
																	autofocus name="Nome"  value="<?php echo $query['Nome']; ?>">
															<?php echo form_error('Nome'); ?>
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
																<div class="col-md-12 text-left">
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
																<div class="col-md-12 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
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
												<input type="hidden" id="idSis_Usuario" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
												<?php if ($metodo == 2) { ?>
													<div class="col-md-6">
														<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
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
								</form>	
							</div>
						</div>
					</div>
				</div>	
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