<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php if ( !isset($evento)&& $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente']) && ($metodo == 2 || $metodo == 3)) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span> 
								</button>
								<div class="btn-menu btn-group">
									<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
										<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
												<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
												</a>
											</a>
										</li>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
												</a>
											</a>
										</li>
									</ul>
								</div>
								<!--
									<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?>
									</a>
								-->
							</div>
							<div class="collapse navbar-collapse" id="myNavbar">
								<ul class="nav navbar-nav navbar-center">
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
														</a>
													</a>
												</li>
												<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
													<li role="separator" class="divider"></li>
													<li>
														<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
															<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
																<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
															</a>
														</a>
													</li>
												<?php } ?>
											</ul>
										</div>									
									</li>								
									<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
										<li class="botoesnav" role="toolbar" aria-label="...">
											<div class="btn-group">
												<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
													<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
															<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
																<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
															</a>
														</a>
													</li>
													<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
														<li role="separator" class="divider"></li>
														<li>
															<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
																<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
																	<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
																</a>
															</a>
														</li>
													<?php } ?>
												</ul>
											</div>
										</li>
									<?php } ?>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/procedimento\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
														</a>
													</a>
												</li>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/procedimento\/cadastrar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'procedimento/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Nova Chamada
														</a>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li class="botoesnav" role="toolbar" aria-label="...">
										<div class="btn-group">
											<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
												<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a <?php if (preg_match("/procedimento\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
														<a href="<?php echo base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
														</a>
													</a>
												</li>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/procedimento\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'procedimento/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Nova Campanha
														</a>
													</a>
												</li>
											</ul>
										</div>
									</li>	
								</ul>
							</div>
						</div>
					</nav>
				<?php } ?>
			<?php } ?>			
			
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">	
					<?php echo form_open_multipart($form_open_path); ?>
					<?php echo validation_errors(); ?>
					
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-body">
							<?php if ($metodo != 3) { ?>
								
								<?php if ($_SESSION['Empresa']['CadastrarDep'] == 'S' && $metodo == 1 ) { ?>
									<div class="form-group">
										<div class="row">	
											<div class="col-md-3 text-left">
												<label for="Responsavel">Tipo:</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
														foreach ($select['Responsavel'] as $key => $row) {
															if (!$cadastrar['Responsavel']) $cadastrar['Responsavel'] = 'S';
															
															($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
															
															if ($cadastrar['Responsavel'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="Responsavel_' . $hideshow . '">'
																. '<input type="radio" name="Responsavel" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
																} else {
																echo ''
																. '<label class="btn btn-default" name="Responsavel_' . $hideshow . '">'
																. '<input type="radio" name="Responsavel" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
													?>
													
												</div>
											</div>
											<div id="Responsavel" <?php echo $div['Responsavel']; ?>>
												<div class="col-md-9">	
													<div class="row">
														<div class="col-md-8">
															<label for="idApp_Responsavel">Responsável:</label><br>
															<select data-placeholder="Selecione um Titular..." class="form-control Chosen" <?php echo $disabled; ?>
															id="idApp_Responsavel" name="idApp_Responsavel">
																<option value="">-- Selec.um Responsável --</option>
																<?php
																	foreach ($select['idApp_Responsavel'] as $key => $row) {
																		if ($cadastrar['idApp_Responsavel'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																?>
															</select>
															<?php echo form_error('idApp_Responsavel'); ?>
														</div>					
														<div class="col-md-4">
															<label for="RelacaoDep">Relação</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
															id="RelacaoDep" name="RelacaoDep">
																<option value="">-- Selecione uma Relação --</option>
																<?php
																	foreach ($select['RelacaoDep'] as $key => $row) {
																		if ($cadastrar['RelacaoDep'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																?>   
															</select>
															<?php echo form_error('RelacaoDep'); ?>          
														</div>	
														<div class="col-md-4 text-left">
															<label for="CadastrarResp">Encontrado Responsável?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																	foreach ($select['CadastrarResp'] as $key => $row) {
																		if (!$cadastrar['CadastrarResp']) $cadastrar['CadastrarResp'] = 'S';
																		
																		($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																		
																		if ($cadastrar['CadastrarResp'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="CadastrarResp_' . $hideshow . '">'
																			. '<input type="radio" name="CadastrarResp" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																			} else {
																			echo ''
																			. '<label class="btn btn-default" name="CadastrarResp_' . $hideshow . '">'
																			. '<input type="radio" name="CadastrarResp" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																?>
																
															</div>
														</div>
														
														<div class="col-md-8 text-left" id="CadastrarResp" <?php echo $div['CadastrarResp']; ?>>
															<div class="col-md-6">	
																<label for="CadastrarResp">Responsavel</label><br>
																<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addResponsavelModal">
																	Cadastrar
																</button>
															</div>	
															<div class="col-md-6">	
																<label for="CadastrarResp">Recarregar</label><br>
																<button type="submit" class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." >
																	<span class="glyphicon glyphicon-refresh"></span>Recarregar
																</button>
															</div>	
															<span id="msg"></span>
															<?php echo form_error('CadastrarResp'); ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="NomeCliente">Nome do Cliente: *</label>
											<input type="text" class="form-control" id="NomeCliente" maxlength="255" <?php echo $readonly; ?>
											name="NomeCliente" autofocus value="<?php echo $query['NomeCliente']; ?>">
											<?php echo form_error('NomeCliente'); ?>
										</div>
										<div class="col-md-3">
											<label for="DataNascimento">Data de Nascimento:</label>
											<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
											name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
										</div>
										<div class="col-md-3">
											<label for="CelularCliente">Celular *</label>
											<input type="text" class="form-control Celular" id="CelularCliente" maxlength="11" <?php echo $readonly; ?>
											name="CelularCliente" placeholder="(XX)999999999" value="<?php echo $query['CelularCliente']; ?>">
											<?php echo form_error('CelularCliente'); ?>
										</div>
									</div>	
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
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<!--
										<div class="col-md-3">
											<label for="CepCliente">Cep:</label>
											<input type="text" class="form-control" id="CepCliente" maxlength="8" <?php #echo $readonly; ?>
											name="CepCliente" value="<?php #echo $query['CepCliente']; ?>">
										</div>
										-->
										<div class="col-md-3 ">
											<label for="CepCliente">Cep:</label><br>
											<div class="input-group">
												<input type="text" class="form-control btn-sm Numero" maxlength="8" <?php echo $readonly; ?> id="CepCliente" name="CepCliente" value="<?php echo $query['CepCliente']; ?>">
												<span class="input-group-btn">
													<button class="btn btn-success btn-md" type="button" onclick="BuscaEndCliente()">
														Buscar
													</button>
												</span>
											</div>
										</div>
										<div class="col-md-6">
											<label for="EnderecoCliente">Endreço:</label>
											<input type="text" class="form-control" id="EnderecoCliente" maxlength="100" <?php echo $readonly; ?>
											name="EnderecoCliente" value="<?php echo $query['EnderecoCliente']; ?>">
										</div>
										<div class="col-md-3">
											<label for="NumeroCliente">Numero:</label>
											<input type="text" class="form-control" id="NumeroCliente" maxlength="100" <?php echo $readonly; ?>
											name="NumeroCliente" value="<?php echo $query['NumeroCliente']; ?>">
										</div>
									</div>	
									<div class="row">
										<div class="col-md-3">
											<label for="ComplementoCliente">Complemento:</label>
											<input type="text" class="form-control" id="ComplementoCliente" maxlength="100" <?php echo $readonly; ?>
											name="ComplementoCliente" value="<?php echo $query['ComplementoCliente']; ?>">
										</div>	
										<div class="col-md-3">
											<label for="BairroCliente">Bairro:</label>
											<input type="text" class="form-control" id="BairroCliente" maxlength="100" <?php echo $readonly; ?>
											name="BairroCliente" value="<?php echo $query['BairroCliente']; ?>">
										</div>
										<div class="col-md-3">
											<label for="CidadeCliente">Município:</label>
											<input type="text" class="form-control" id="CidadeCliente" maxlength="100" <?php echo $readonly; ?>
											name="CidadeCliente" value="<?php echo $query['CidadeCliente']; ?>">
										</div>
										<div class="col-md-3">
											<label for="EstadoCliente">Estado:</label>
											<input type="text" class="form-control" id="EstadoCliente" maxlength="2" <?php echo $readonly; ?>
											name="EstadoCliente" value="<?php echo $query['EstadoCliente']; ?>">
										</div>
										<!--
											<div class="col-md-3">
											<label for="MunicipioCliente">Município:</label><br>
											<select data-placeholder="Selecione um Município..." class="form-control Chosen" <?php echo $disabled; ?>
											id="MunicipioCliente" name="MunicipioCliente">
											<option value="">-- Selec.um Município --</option>
											<?php
												foreach ($select['MunicipioCliente'] as $key => $row) {
													if ($query['MunicipioCliente'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
											?>
											</select>
											</div>
										-->
									</div>	
									<div class="row">
										<div class="col-md-3 ">
											<label class="" for="ReferenciaCliente">Referencia:</label>
											<textarea class="form-control " id="ReferenciaCliente" <?php echo $readonly; ?>
											name="ReferenciaCliente"><?php echo $query['ReferenciaCliente']; ?>
											</textarea>
										</div>
										<div class="col-md-3">
											<label for="ClienteConsultor">Cliente Consultor?</label><br>
											<div class="form-group">
												<div class="btn-group" data-toggle="buttons">
													<?php
														foreach ($select['ClienteConsultor'] as $key => $row) {
															(!$query['ClienteConsultor']) ? $query['ClienteConsultor'] = 'N' : FALSE;
															
															if ($query['ClienteConsultor'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_ClienteConsultor" id="radiobutton_ClienteConsultor' . $key . '">'
																. '<input type="radio" name="ClienteConsultor" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
																} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_ClienteConsultor" id="radiobutton_ClienteConsultor' . $key . '">'
																. '<input type="radio" name="ClienteConsultor" id="radiobutton" '
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
												<label for="CpfCliente">CPF:</label>
												<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
												name="CpfCliente" value="<?php echo $query['CpfCliente']; ?>">
												<?php echo form_error('CpfCliente'); ?>
											</div>
											<div class="col-md-3">
												<label for="Telefone">Tel.1 - Fixo ou Celular:</label>
												<input type="text" class="form-control Celular CelularVariavel" id="Telefone" maxlength="11" <?php echo $readonly; ?>
												name="Telefone" placeholder="(XX)999999999" value="<?php echo $query['Telefone']; ?>">
											</div>
											<div class="col-md-3">
												<label for="Telefone2">Tel.2 - Fixo ou Celular:</label>
												<input type="text" class="form-control Celular CelularVariavel" id="Telefone2" maxlength="11" <?php echo $readonly; ?>
												name="Telefone2" placeholder="(XX)999999999" value="<?php echo $query['Telefone2']; ?>">
											</div>
											<div class="col-md-3">
												<label for="Telefone3">Tel.3 - Fixo ou Celular:</label>
												<input type="text" class="form-control Celular CelularVariavel" id="Telefone3" maxlength="11" <?php echo $readonly; ?>
												name="Telefone3" placeholder="(XX)999999999" value="<?php echo $query['Telefone3']; ?>">
											</div>												
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											
											<div class="col-md-3">
												<label for="Rg">RG:</label>
												<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
												name="Rg" value="<?php echo $query['Rg']; ?>">
											</div>
											<div class="col-md-3">
												<label for="OrgaoExp">Orgão Exp.:</label>
												<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
												name="OrgaoExp" value="<?php echo $query['OrgaoExp']; ?>">
											</div>
											<div class="col-md-3">
												<label for="EstadoExp">Estado Emissor:</label>
												<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
												name="EstadoExp" value="<?php echo $query['EstadoExp']; ?>">
											</div>
											<div class="col-md-3">
												<label for="DataEmissao">Data de Emissão:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
												name="DataEmissao" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmissao']; ?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">							
											<div class="col-md-3">
												<label for="Email">E-mail:</label>
												<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
												name="Email" value="<?php echo $query['Email']; ?>">
											</div>											
											<!--
												<div class="col-md-3">
												<label for="DataCadastroCliente">Cadastrado em:</label>													
												<input type="text" class="form-control Date"  maxlength="10" <?php echo $readonly; ?>
												name="DataCadastroCliente" placeholder="DD/MM/AAAA" value="<?php echo $query['DataCadastroCliente']; ?>">													
												</div>
											-->
											<div class="col-md-3">
												<label for="RegistroFicha">Ficha Nº:</label>
												<input type="text" class="form-control Numero" maxlength="5" <?php echo $readonly; ?>
												name="RegistroFicha" value="<?php echo $query['RegistroFicha']; ?>">
											</div>
											<div class="col-md-4">
												<label for="Obs">OBS:</label>
												<textarea class="form-control" id="Obs" <?php echo $readonly; ?>
												name="Obs"><?php echo $query['Obs']; ?></textarea>
											</div>
										</div>
									</div>								
								</div>
							<?php } ?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-3 text-left">
										<label for="Ativo">Ativo?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
												foreach ($select['Ativo'] as $key => $row) {
													if (!$query['Ativo']) $query['Ativo'] = 'S';
													
													($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
													
													if ($query['Ativo'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="Ativo_' . $hideshow . '">'
														. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
														} else {
														echo ''
														. '<label class="btn btn-default" name="Ativo_' . $hideshow . '">'
														. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
											?>
											
										</div>
									</div>
									<div id="Ativo" <?php echo $div['Ativo']; ?>>
										<div class="col-md-3">
											<label for="Motivo">Motivo:</label><br>
											<select data-placeholder="Selecione um Motivo..." class="form-control Chosen" <?php echo $disabled; ?>
											id="Motivo" name="Motivo">
												<option value="">-- Selec.um Motivo --</option>
												<?php
													foreach ($select['Motivo'] as $key => $row) {
														if ($query['Motivo'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
												?>
											</select>
											<?php echo form_error('Motivo'); ?>
										</div>
										<div class="col-md-2 text-left">
											<label for="Cadastrar">Motivo Encontrado?</label><br>
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
										<div class="col-md-4 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
											<label for="Cadastrar">Motivo</label><br>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addMotivoModal">
												Cadastrar/Editar
											</button>
											
											<!--
												<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>motivo2/cadastrar3/" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Motivo
												</a>
											-->
											<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-refresh"></span>Recarregar
											</button>
											<span id="msg"></span>
											<?php echo form_error('Cadastrar'); ?>
										</div>
									</div>	
								</div>
							</div>
							
							<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
							<?php if ($metodo != 1) { ?>
								<input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
							<?php } ?>
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
								<div class="form-group">
									<div class="row">
										
										<?php if ($metodo == 2 || $metodo == 3) { ?>
											
											<div class="col-md-6">
												<!--
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
													<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												-->
												<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
													<span class="glyphicon glyphicon-save"></span> Salvar
												</button>
											</div>
											<!--
												<div class="col-md-6 text-right">
												
												<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
																<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotao()" data-dismiss="modal">
																	<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																</button>
															</div>
															<div class="col-md-6 text-right">
																<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'cliente/excluir/' . $query['idApp_Cliente'] ?>" role="button">
																	<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<?php } elseif ($metodo == 5) { ?>
											<div class="col-md-12 text-center">
												<!--
													<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
													<span class="glyphicon glyphicon-trash"></span> Excluir
													</button>
												-->
												<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1); return true;">
													<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
												</button>
											</div>
											<?php } else { ?>
											<div class="col-md-6">
												<!--
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
													<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												-->
												<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
													<span class="glyphicon glyphicon-save"></span> Salvar
												</button>											
											</div>
										<?php } ?>
										
										<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header bg-success text-center">
														<h4 class="modal-title" id="visulUsuarioModalLabel">Cadastrado com sucesso!</h4>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<!--
														<div class="modal-body">
														Motivo cadastrado com sucesso!
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
</div>	
</div>

<div id="addResponsavelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addResponsavelModalLabel">Cadastrar Responsavel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-responsavel"></span>
				<form method="post" id="insert_responsavel_form">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="NomeResponsavel">Nome do Responsavel: *</label>
								<input name="NomeResponsavel" type="text" class="form-control" id="NomeResponsavel" maxlength="255" placeholder="Nome do Responsavel">
							</div>
							<div class="col-md-3">
								<label for="CelularResponsavel">Celular: *</label>
								<input type="text" class="form-control Celular" id="CelularResponsavel" maxlength="11" name="CelularResponsavel" placeholder="(XX)999999999">
							</div>
							<div class="col-md-3">
								<label for="DataNascimentoResponsavel">Data do Aniversário:</label>
								<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoResponsavel" placeholder="DD/MM/AAAA">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 ">
								<h4 class="mb-3">Sexo</h4>
								<div class="col-md-3 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="SexoResponsavel" class="custom-control-input "  id="Retirada" value="M">
										<label class="custom-control-label" for="Masculino">Mas</label>
									</div>
								</div>
								<div class="col-md-3 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="SexoResponsavel" class="custom-control-input " id="Combinar" value="F">
										<label class="custom-control-label" for="Feminino">Fem </label>
									</div>
								</div>
								<div class="col-md-3 mb-3 ">
									<div class="custom-control custom-radio">
										<input type="radio" name="SexoResponsavel" class="custom-control-input " id="Correios" value="O" checked>
										<label class="custom-control-label" for="Outros">Outros</label>
									</div>
								</div>
							</div>
						</div>								
					</div>
					<div class="form-group">
						<div class="row">
							<!--
							<div class="col-md-3">
								<label for="CepResponsavel">Cep:</label>
								<input type="text" class="form-control Numero" id="CepResponsavel" maxlength="8" name="CepResponsavel">
							</div>
							-->
							<div class="col-md-3 ">
								<label for="CepResponsavel">Cep:</label><br>
								<div class="input-group">
									<input type="text" class="form-control btn-sm Numero" maxlength="8" <?php echo $readonly; ?> id="CepResponsavel" name="CepResponsavel" >
									<span class="input-group-btn">
										<button class="btn btn-success btn-md" type="button" onclick="BuscaEndResponsavel()">
											Buscar
										</button>
									</span>
								</div>
							</div>
										
							<div class="col-md-6">
								<label for="EnderecoResponsavel">Endreço:</label>
								<input type="text" class="form-control" id="EnderecoResponsavel" maxlength="100" name="EnderecoResponsavel">
							</div>
							<div class="col-md-3">
								<label for="NumeroResponsavel">Numero:</label>
								<input type="text" class="form-control" id="NumeroResponsavel" maxlength="100" name="NumeroResponsavel">
							</div>
						</div>	
						<div class="row">
							<div class="col-md-3">
								<label for="ComplementoResponsavel">Complemento:</label>
								<input type="text" class="form-control" id="ComplementoResponsavel" maxlength="100" name="ComplementoResponsavel" >
							</div>	
							<div class="col-md-3">
								<label for="BairroResponsavel">Bairro:</label>
								<input type="text" class="form-control" id="BairroResponsavel" maxlength="100" name="BairroResponsavel" >
							</div>
							<div class="col-md-3">
								<label for="CidadeResponsavel">Município:</label>
								<input type="text" class="form-control" id="CidadeResponsavel" maxlength="100" name="CidadeResponsavel" >
							</div>
							<div class="col-md-3">
								<label for="EstadoResponsavel">Estado:</label>
								<input type="text" class="form-control" id="EstadoResponsavel" maxlength="2" name="EstadoResponsavel" >
							</div>
						</div>	
						<div class="row">
							<div class="col-md-3 ">
								<label class="" for="ReferenciaResponsavel">Referencia:</label>
								<textarea class="form-control " id="ReferenciaResponsavel" name="ReferenciaResponsavel"></textarea>
							</div>
						</div>
					</div>
					
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadResponsavel" id="botaoCadResponsavel" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharResponsavel" id="botaoFecharResponsavel">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarResponsavel" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="msgResponsavelExiste" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning text-center">
				<h5 class="modal-title" id="existeClienteModalLabel">Atenção</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Este Celular já é Cadastrado!
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<div id="addMotivoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addMotivoModalLabel">Cadastrar Motivo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-motivo"></span>
				<form method="post" id="insert_motivo_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Motivo</label>
						<div class="col-sm-10">
							<input name="Novo_Motivo" type="text" class="form-control" id="Novo_Motivo" placeholder="Motivo">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Descrição</label>
						<div class="col-sm-10">
							<input name="Desc_Motivo" type="text" class="form-control" id="Desc_Motivo" placeholder="Descrição">
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
				</form>
				<?php if (isset($list_motivo)) echo $list_motivo; ?>
			</div>
		</div>
	</div>
</div>

<div id="alterarMotivo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarMotivoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarMotivoLabel">Motivo</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-motivo"></span>
				<form method="post" id="alterar_motivo_form">
					<div class="form-group">
						<label for="MotivoAlterar" class="control-label">Motivo:</label>
						<input type="text" class="form-control" name="MotivoAlterar" id="MotivoAlterar">
					</div>
					<div class="form-group">
						<label for="DescMotivoAlterar" class="control-label">Descricao:</label>
						<input type="text" class="form-control" name="DescMotivoAlterar" id="DescMotivoAlterar">
					</div>
					<input type="hidden" name="id_Motivo" id="id_Motivo">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarMotivo" id="CancelarMotivo" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarMotivo" id="AlterarMotivo" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarMotivo" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
