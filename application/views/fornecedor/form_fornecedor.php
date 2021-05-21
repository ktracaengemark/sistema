<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php if ( !isset($evento) && $metodo == 2) { ?>
				<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
								<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</small> - <small>' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/fornecedor\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
												<span class="glyphicon glyphicon-file"></span> Ver Dados do Fornecedor
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/fornecedor\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'fornecedor/alterar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Fornecedor
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Fornecedor
											</a>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
			<?php } ?>
        
			<div class="row">
				<div class="col-md-12 col-lg-12">	
					
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong>Fornecedor</strong></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label for="NomeFornecedor">Fornecedor *</label>
										<input type="text" class="form-control" id="NomeFornecedor" maxlength="255" <?php echo $readonly; ?>
											   name="NomeFornecedor" autofocus value="<?php echo $query['NomeFornecedor']; ?>">
										<?php echo form_error('NomeFornecedor'); ?>
									</div>
									<div class="col-md-4">
										<label for="CelularFornecedor">Celular*</label>
										<input type="text" class="form-control Celular" id="CelularFornecedor" maxlength="11" <?php echo $readonly; ?>
											   name="CelularFornecedor" placeholder="(XX)999999999" value="<?php echo $query['CelularFornecedor']; ?>">
										<?php echo form_error('CelularFornecedor'); ?>
									</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-12 text-left">
												<label for="Atividade">Ativ.:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
														id="Atividade" name="Atividade">
													<option value="">-- Sel. Atividade --</option>
													<?php
													foreach ($select['Atividade'] as $key => $row) {
														if ($query['Atividade'] == $key) {
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
											</div>
										</div>	
										<div id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
											<div class="row text-left">
												<div class="col-md-12">
													<div class="row">	
														<div class="col-md-6">	
															<br>
															<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addAtividadeModal">
																<span class="glyphicon glyphicon-plus"></span>Cadastrar
															</button>
														</div>	
															<!--
															<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>atividade2/cadastrar3/" role="button"> 
																<span class="glyphicon glyphicon-plus"></span>Ativ.
															</a>
															-->
														<div class="col-md-6">		
															<br>
															<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-refresh"></span>Ref.
															</button>
														</div>
													</div>	
													<?php echo form_error('Cadastrar'); ?>
												</div>	
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
										<div class="col-md-4">
											<label for="Telefone1">Tel Principal: *</label>
											<input type="text" class="form-control Celular CelularVariavel" id="Telefone1" maxlength="14" <?php echo $readonly; ?>
												   name="Telefone1" placeholder="(XX)999999999" value="<?php echo $query['Telefone1']; ?>">
										</div>                      
										<div class="col-md-4">
											<label for="Telefone2">Telefone ou Celular:</label>
											<input type="text" class="form-control Celular CelularVariavel" id="Telefone2" maxlength="20" <?php echo $readonly; ?>
												   name="Telefone2" placeholder="(XX)999999999" value="<?php echo $query['Telefone2']; ?>">
										</div>
										<div class="col-md-4">
											<label for="Telefone3">Telefone ou Celular:</label>
											<input type="text" class="form-control Celular CelularVariavel" id="Telefone3" maxlength="20" <?php echo $readonly; ?>
												   name="Telefone3" placeholder="(XX)999999999" value="<?php echo $query['Telefone3']; ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4">
											<label for="EnderecoFornecedor">Endreço:</label>
											<textarea type="text" class="form-control" id="EnderecoFornecedor" maxlength="200" <?php echo $readonly; ?>
												   name="EnderecoFornecedor" value="<?php echo $query['EnderecoFornecedor']; ?>"><?php echo $query['EnderecoFornecedor']; ?></textarea>
										</div>
										<div class="col-md-4">
											<label for="NumeroFornecedor">Numero:</label>
											<input type="text" class="form-control" id="NumeroFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="NumeroFornecedor" value="<?php echo $query['NumeroFornecedor']; ?>">
										</div>
										<div class="col-md-4">
											<label for="ComplementoFornecedor">Complemento:</label>
											<input type="text" class="form-control" id="ComplementoFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="ComplementoFornecedor" value="<?php echo $query['ComplementoFornecedor']; ?>">
										</div>
									</div>	
									<div class="row">	
										<div class="col-md-4">
											<label for="BairroFornecedor">Bairro:</label>
											<input type="text" class="form-control" id="BairroFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="BairroFornecedor" value="<?php echo $query['BairroFornecedor']; ?>">
										</div>
										<div class="col-md-4">
											<label for="CidadeFornecedor">Cidade:</label>
											<input type="text" class="form-control" id="CidadeFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="CidadeFornecedor" value="<?php echo $query['CidadeFornecedor']; ?>">
										</div>
										<div class="col-md-4">
											<label for="EstadoFornecedor">Estado:</label>
											<input type="text" class="form-control" id="EstadoFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="EstadoFornecedor" value="<?php echo $query['EstadoFornecedor']; ?>">
										</div>
									</div>	
									<div class="row">
										<div class="col-md-4">
											<label for="CepFornecedor">Cep:</label>
											<input type="text" class="form-control" id="CepFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="CepFornecedor" value="<?php echo $query['CepFornecedor']; ?>">
										</div>	
										<div class="col-md-4">
											<label for="ReferenciaFornecedor">Referencia:</label>
											<textarea type="text" class="form-control" id="ReferenciaFornecedor" maxlength="100" <?php echo $readonly; ?>
												   name="ReferenciaFornecedor" value="<?php echo $query['ReferenciaFornecedor']; ?>"><?php echo $query['ReferenciaFornecedor']; ?></textarea>
										</div>
										<div class="col-md-4">
											<label for="Cnpj">Cnpj:</label>
											<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
												   name="Cnpj" value="<?php echo $query['Cnpj']; ?>">
										</div>
									</div>
								</div> 
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="MunicipioFornecedor">Município:</label><br>
											<select data-placeholder="Selecione um Município..." class="form-control Chosen" <?php echo $disabled; ?>
													id="MunicipioFornecedor" name="MunicipioFornecedor">
												<option value="">-- Selecione uma opção --</option>
												<?php
												foreach ($select['MunicipioFornecedor'] as $key => $row) {
													if ($query['MunicipioFornecedor'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-6">
											<label for="Email">E-mail:</label>
											<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
												   name="Email" value="<?php echo $query['Email']; ?>">
										</div>                        
									</div>
								</div> 
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="Obs">OBS:</label>
											<textarea class="form-control" id="Obs" <?php echo $readonly; ?>
													  name="Obs"><?php echo $query['Obs']; ?></textarea>
										</div>
										<div class="col-md-3">
											<label for="Ativo">Ativo?</label><br>
											<div class="form-group">
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['Ativo'] as $key => $row) {
														(!$query['Ativo']) ? $query['Ativo'] = 'S' : FALSE;

														if ($query['Ativo'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
															. '<input type="radio" name="Ativo" id="radiobutton" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
															. '<input type="radio" name="Ativo" id="radiobutton" '
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
							</div>                                    
							<br>               
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
							<div class="form-group">
								<div class="row">
								
									<input type="hidden" name="idApp_Fornecedor" value="<?php echo $query['idApp_Fornecedor']; ?>">
									
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
															<button type="button" class="btn btn-warning"  name="submeter4" id="submeter4" onclick="DesabilitaBotao()" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'fornecedor/excluir/' . $query['idApp_Fornecedor'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>										
										
									<?php } else { ?>
										<div class="col-md-6">
											<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
									<?php } ?>
									<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-success text-center">
													<h5 class="modal-title" id="visulUsuarioModalLabel">Atividade</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													Atividade cadastrada com sucesso!
												</div>
												<div class="modal-footer">
													<div class="col-md-6">	
														<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
															<span class="glyphicon glyphicon-filter"></span> Fechar
														</button>
														<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
															Aguarde um instante! Estamos processando sua solicitação!
														</div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
							</form>
						</div>
					</div>							
				</div>
			</div>	
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>

<div id="addAtividadeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addAtividadeModalLabel">Cadastrar Atividade</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-atividade"></span>
				<form method="post" id="insert_atividade_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Atividade</label>
						<div class="col-sm-10">
							<input name="Novo_Atividade" type="text" class="form-control" id="Novo_Atividade" placeholder="Atividade">
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
					<?php if (isset($list_atividade)) echo $list_atividade; ?>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="alterarAtividade" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarAtividadeLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarAtividadeLabel">Atividade</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-atividade"></span>
				<form method="post" id="alterar_atividade_form">
					<div class="form-group">
						<label for="AtividadeAlterar" class="control-label">Atividade:</label>
						<input type="text" class="form-control" name="AtividadeAlterar" id="AtividadeAlterar">
					</div>
					<input type="hidden" name="id_Atividade" id="id_Atividade">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarAtividade" id="CancelarAtividade" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarAtividade" id="AlterarAtividade" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarAtividade" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
