<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente']) && isset($alterarcliente) && $alterarcliente == 2) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
								<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
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
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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

			<?php #echo validation_errors(); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<?php echo $titulo; ?>
					<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>agenda" role="button">
						<span class="glyphicon glyphicon-calendar"></span>Agenda
					</a>
				</div>
				<div class="panel-body">
					<div class="panel panel-info">
						<div class="panel-heading">
						<?php echo form_open_multipart($form_open_path); ?>
							<div class="row">
								<div class="col-md-4">
									<label for="idApp_Agenda">Profissional:*</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
											id="idApp_Agenda" name="idApp_Agenda">
										<!--<option value="">-- Selecione um Profissional --</option>-->												
										<?php echo $select['option']; ?>
										<?php
										foreach ($select['idApp_Agenda'] as $key => $row) {
											if ($query['idApp_Agenda'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
									<?php echo form_error('idApp_Agenda'); ?>
								</div>
								
								<input type="hidden" id="exibir_id" value="<?php echo $exibir_id; ?>" />
								<input type="hidden" id="Caminho2" name="Caminho2" value="<?php echo $caminho2; ?>">
								<?php if($alterarcliente == 1){?>	
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-12 text-left">	
												<label  for="idApp_Cliente">Cliente:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="buscaEnderecoCliente(this.value),clientePet(this.value),clienteDep(this.value),clienteOT(this.value)"
														id="idApp_Cliente" name="idApp_Cliente">
													<option value="">-- Sel. Cliente --</option>
													<?php
													foreach ($select['idApp_Cliente'] as $key => $row) {
														if ($query['idApp_Cliente'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('idApp_Cliente'); ?>
											</div>
										</div>
									</div>
									<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
										<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
										<div class="col-md-4 text-left">
											<label  for="idApp_ClienteDep">Dep</label>
											<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
												<option value=""></option>
											</select>
											<span class="modal-title" id="Dep"></span>
										</div>
										<!--
										<div class="col-md-4 text-left">	
											<label  for="idApp_ClienteDep">Dependente:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php #echo $readonly; ?>
													id="idApp_ClienteDep" name="idApp_ClienteDep">
												<option value="">-- Sel. Dependente --</option>
												<?php
												/*
												foreach ($select['idApp_ClienteDep'] as $key => $row) {
													if ($query['idApp_ClienteDep'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												*/
												?>
											</select>
											<?php #echo form_error('idApp_ClienteDep'); ?>
										</div>
										-->
									<?php } ?>
									<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
										<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
										<div class="col-md-4 text-left">
											<label  for="idApp_ClientePet">Pet</label>
											<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
												<option value=""></option>
											</select>
											<span class="modal-title" id="Pet"></span>
										</div>
									<?php } ?>
								<?php }elseif($alterarcliente == 2){?>	
									<div class="col-md-4">
										<label >Cliente</label>
										<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Cliente']['NomeCliente']; ?>">
									</div>
									<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
										<!--
										<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
										<div class="col-md-4 text-left">
											<label  for="idApp_ClienteDep">Dep</label>
											<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
												<option value=""></option>
											</select>
											<span class="modal-title" id="Dep"></span>
										</div>
										-->
										
										<div class="col-md-4 text-left">	
											<label  for="idApp_ClienteDep">Dependente:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
													id="idApp_ClienteDep" name="idApp_ClienteDep">
												<option value="">-- Sel. Dependente --</option>
												<?php
												
												foreach ($select['idApp_ClienteDep'] as $key => $row) {
													if ($query['idApp_ClienteDep'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												
												?>
											</select>
											<?php echo form_error('idApp_ClienteDep'); ?>
										</div>
										
									<?php } ?>
									<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
										<!--
										<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
										<div class="col-md-4 text-left">
											<label  for="idApp_ClientePet">Pet</label>
											<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
												<option value=""></option>
											</select>
											<span class="modal-title" id="Pet"></span>
										</div>
										-->
										<div class="col-md-4 text-left">	
											<label  for="idApp_ClientePet">Pet:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
													id="idApp_ClientePet" name="idApp_ClientePet">
												<option value="">-- Sel. Pet --</option>
												<?php
												
												foreach ($select['idApp_ClientePet'] as $key => $row) {
													if ($query['idApp_ClientePet'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												
												?>
											</select>
											<?php echo form_error('idApp_ClientePet'); ?>
										</div>
										
									<?php } ?>	
								<?php } ?>
							</div>
							
							<div class="row">
								<div class="col-md-4 text-left">
									<label for="Cadastrar">Encontrou Cliente?</label><br>
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
								<div class="col-md-8 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
									<div class="row">	
										<div class="col-md-4 text-left">	
											<label for="Cadastrar">Cliente</label><br>
											<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addClienteModal">
												<span class="glyphicon glyphicon-plus"></span>Cadastrar
											</button>
										</div>
										<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
											<div class="col-md-4 text-left">
												<label >Pet</label><br>
												<button type="button" class="btn btn-success btn-block" id="addPet" data-toggle="modal" data-target="#addClientePetModal">
													<span class="glyphicon glyphicon-plus"></span>Cadastrar
												</button>
											</div>
										<?php }else{ ?>	
											<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
												<div class="col-md-4 text-left">
													<label >Dependente</label><br>
													<button type="button" class="btn btn-success btn-block" id="addDep"  data-toggle="modal" data-target="#addClienteDepModal">
														<span class="glyphicon glyphicon-plus"></span>Cadastrar
													</button>
												</div>
											<?php } ?>
										<?php } ?>	
										<div class="col-md-4 text-left">
											<label >Recarregar</label><br>
											<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
													<span class="glyphicon glyphicon-refresh"></span>Recarregar
											</button>
										</div>
									</div>	
									<?php echo form_error('Cadastrar'); ?>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">	
												<div class="col-md-12 text-left">
													<label for="Obs">Obs:</label>
													<textarea class="form-control" id="Obs" name="Obs"><?php echo $query['Obs']; ?></textarea>
												</div>
											</div>	
											<div class="row">		
												<div class="col-md-6">	
													<label for="Data">Data Início : </label>												
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="Data" id="Data" value="<?php echo $query['Data']; ?>" onchange="ocorrencias()" onkeyup="ocorrencias()">
													</div>
													<?php echo form_error('Data'); ?>
												</div>	
												<div class="col-md-6">
													<label for="Hora">Dàs :</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
															   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
													</div>
													<?php echo form_error('HoraInicio'); ?>
												</div>
											</div>	
											<div class="row">		
												<div class="col-md-6">	
													<label for="Data2">Data Fim : </label>												
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="Data2" id="Data2" value="<?php echo $query['Data2']; ?>">
													</div>
													<?php echo form_error('Data2'); ?>
												</div>
												<div class="col-md-6">		
													<label for="Hora">Às :</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
															   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
													</div>
													<?php echo form_error('HoraFim'); ?>
												</div>
											</div>
											<br>
											<div class="row">	
												<div class="col-md-6 form-inline text-left">
													<label for="idTab_TipoConsulta">Agendamento de:</label><br>
													<div class="btn-block" data-toggle="buttons">
														<?php
														foreach ($select['TipoConsulta'] as $key => $row) {
															(!$query['idTab_TipoConsulta']) ? $query['idTab_TipoConsulta'] = '1' : FALSE;

															if ($query['idTab_TipoConsulta'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radio_idTab_TipoConsulta" id="radiogeral' . $key . '">'
																. '<input type="radio" name="idTab_TipoConsulta" id="radiogeral" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radio_idTab_TipoConsulta" id="radiogeral' . $key . '">'
																. '<input type="radio" name="idTab_TipoConsulta" id="radiogeral" '
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
								<div class="col-md-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
										
										<?php if ($metodo == 1) { ?>			
											<div class="row text-left">
												<div class="col-md-8 ">
													<label for="Repetir">Repetir Agendamento?</label><br>
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Repetir'] as $key => $row) {
															if (!$cadastrar['Repetir']) $cadastrar['Repetir'] = 'N';

															($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

															if ($cadastrar['Repetir'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="Repetir_' . $hideshow . '">'
																. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																. 'onchange="ocorrencias(this.value)" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="Repetir_' . $hideshow . '">'
																. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																. 'onchange="ocorrencias(this.value)" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>

													</div>
													<?php echo form_error('Repetir'); ?>
												</div>
												<div class="col-md-4">	
													<label for="Recorrencias">Ocorrências: </label>
														<input type="text" class="form-control" name="Recorrencias" id="Recorrencias" value="<?php echo $query['Recorrencias']; ?>" onkeyup="ocorrencias()">
													<?php echo form_error('Recorrencias'); ?>	
												</div>
											</div>	
											<div class="row text-left">	
												<div class="col-md-12 text-left" id="Repetir" <?php echo $div['Repetir']; ?>>
													<br>
													<div class="row">	
														<div class="col-md-4">
															<label for="Intervalo">Repetir a cada:</label><br>
															<input type="text" class="form-control Numero" id="Intervalo" maxlength="3" placeholder="Ex: '5' dias."
																   name="Intervalo" onkeyup="ocorrencias()" value="<?php echo $query['Intervalo'] ?>">
															<?php echo form_error('Intervalo'); ?>		
														</div>
														<div class="col-md-4 ">
															<label for="Tempo">Período</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																	id="Tempo" name="Tempo" onchange="ocorrencias()">
																<!--<option value="">-- Selecione uma opção --</option>-->
																<?php
																foreach ($select['Tempo'] as $key => $row) {
																	if ($query['Tempo'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-4">	
															<label for="DataMinima">Próxima: </label>
																<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																	   name="DataMinima" id="DataMinima" value="<?php echo $cadastrar['DataMinima']; ?>" >
															<?php echo form_error('DataMinima'); ?>	
														</div>
													</div>	
													<div class="row">	
														<div class="col-md-4">
															<label for="Periodo">Durante:</label><br>
															<input type="text" class="form-control Numero" id="Periodo" maxlength="3" placeholder="Ex: '30' dias."
																   name="Periodo" value="<?php echo $query['Periodo'] ?>" onkeyup="dateTermina()">
															<?php echo form_error('Periodo'); ?>		
														</div>
														<div class="col-md-4 ">
															<label for="Tempo2">Período</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																	id="Tempo2" name="Tempo2" onchange="dateTermina()">
																<!--<option value="">-- Selecione uma opção --</option>-->
																<?php
																foreach ($select['Tempo'] as $key => $row) {
																	if ($query['Tempo2'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-4">	
															<label for="DataTermino">Última: </label>
																<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																	   name="DataTermino" id="DataTermino" value="<?php echo $query['DataTermino']; ?>" >
															<?php echo form_error('DataTermino'); ?>	
														</div>
													</div>
												</div>
											</div>
										<?php } else { ?>
											<div class="row text-left">	
												<div class="col-md-3">
													<label>Ocorrência</label>
													<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencia']; ?>">
												</div>	
												<div class="col-md-4">
													<label>Termina em</label>
													<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['DataTermino']; ?>">
												</div>
												<div class="col-md-5 ">
													<label for="Quais">Alterar Quais?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
															id="Quais" name="Quais">
														<!--<option value="">-- Selecione uma opção --</option>-->
														<?php
														foreach ($select['Quais'] as $key => $row) {
															if ($alterar['Quais'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('Quais'); ?>
												</div>
											</div>
										<?php } ?>	
											<br>
											<div class="row">
												<div class="col-md-12 text-left">
													<label for="idTab_Status">Status:</label><br>
													<div class=" " data-toggle="buttons">
														<?php
														foreach ($select['Status'] as $key => $row) {
															if (!$query['idTab_Status'])
																$query['idTab_Status'] = 1;

															if ($query['idTab_Status'] == $key) {
																echo ''
																. '<label class="btn btn-' . $this->basico->tipo_status_cor($key) . ' active" name="radio" id="radio' . $key . '">'
																. '<input type="radio" name="idTab_Status" id="radio" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																. '<input type="radio" name="idTab_Status" id="radio" class="idTab_Status" '
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
								
								<div class="col-md-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">
												<?php if ($vincular == "S") { ?>
													<div class="col-md-4 ">
														<label for="Vincular">Vincular O.S.?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Vincular'] as $key => $row) {
																if (!$cadastrar['Vincular']) $cadastrar['Vincular'] = 'N';

																($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																if ($cadastrar['Vincular'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="Vincular_' . $hideshow . '">'
																	. '<input type="radio" name="Vincular" id="' . $hideshow . '" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="Vincular_' . $hideshow . '">'
																	. '<input type="radio" name="Vincular" id="' . $hideshow . '" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
													<div id="Vincular" <?php echo $div['Vincular']; ?>>
														<div class="col-md-4 ">
															<label for="NovaOS">Nova O.S.?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['NovaOS'] as $key => $row) {
																	if (!$cadastrar['NovaOS']) $cadastrar['NovaOS'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($cadastrar['NovaOS'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="NovaOS_' . $hideshow . '">'
																		. '<input type="radio" name="NovaOS" id="' . $hideshow . '" '
																		. 'onchange="fechaBuscaOS(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="NovaOS_' . $hideshow . '">'
																		. '<input type="radio" name="NovaOS" id="' . $hideshow . '" '
																		. 'onchange="fechaBuscaOS(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
														
														<div id="NovaOS" <?php echo $div['NovaOS']; ?>>
															<div class="col-md-4 ">
																<?php if ($porconsulta == "S") { ?>
																	<label for="PorConsulta">1.OS.Por/Ocor?</label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['PorConsulta'] as $key => $row) {
																			if (!$cadastrar['PorConsulta']) $cadastrar['PorConsulta'] = 'N';

																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($cadastrar['PorConsulta'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="PorConsulta_' . $hideshow . '">'
																				. '<input type="radio" name="PorConsulta" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="PorConsulta_' . $hideshow . '">'
																				. '<input type="radio" name="PorConsulta" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																	
																<?php }else{ ?>
																	<label for="PorConsulta">Gerar 1 OS</label>
																<?php } ?>
															</div>
														</div>
														<input type="hidden" id="Hidden_NovaOS" name="Hidden_NovaOS" value="<?php echo $cadastrar['NovaOS']; ?>" />
														<input type="hidden" id="Hidden_idApp_OrcaTrata" name="Hidden_idApp_OrcaTrata" value="<?php echo $query['idApp_OrcaTrata']; ?>" />
														<?php if($alterarcliente == 1){?>
															<div class="col-md-12 text-left hnovaos"  >
																<label  for="idApp_OrcaTrata">O.S.</label>
																<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_OrcaTrata" name="idApp_OrcaTrata">
																	<option value=""></option>
																</select>
															</div>
														<?php } elseif($alterarcliente == 2){?>	
															<div class="col-md-12 text-left hnovaos">	
																<label  for="idApp_OrcaTrata">O.S.:</label>
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																		id="idApp_OrcaTrata" name="idApp_OrcaTrata">
																	<option value="">-- Sel. Orcamento --</option>
																	<?php
																	foreach ($select['idApp_OrcaTrata'] as $key => $row) {
																		if ($query['idApp_OrcaTrata'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
																<?php echo form_error('idApp_OrcaTrata'); ?>
															</div>
														<?php } ?>
														
													</div>
												<?php }else{ ?>
													<div class="col-md-12 ">
														<label for="NovaOS">O.S.Vinculada</label><br>
														<a class="btn btn-md btn-info btn-block" href="<?php echo base_url() ?>orcatrata/alterarstatus/<?php echo $_SESSION['Consulta']['idApp_OrcaTrata'];?>" role="button">
															<span class="glyphicon glyphicon-pencil"></span> Ver O.S.
														</a>
													</div>
												<?php } ?>
											</div>
											<br>
											<div class="row">
												
												<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
												<?php if ($alterarcliente == 2) { ?>
													<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
												<?php } ?>
												<!--
												<input type="hidden" name="Evento" value="1">
												-->
												
												<div class="col-md-12 text-center">
													<?php if ($metodo == 2) { ?>
														<div class="row">
															<div class="btn-block">
																<span class="input-group-btn">
																	<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																		<span class="glyphicon glyphicon-save"></span>Save
																	</button>
																</span>
																<?php if ($_SESSION['Consulta']['idApp_OrcaTrata'] > 0) { ?>
																	<span class="input-group-btn">
																		<a class="btn btn-lg btn-info " name="submeter5" id="submeter5" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $query['idApp_OrcaTrata']; ?>">
																			<span class="glyphicon glyphicon-print"></span>										
																		</a>
																	</span>
																<?php } ?>
																<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>
																	<span class="input-group-btn">
																		<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="quais(),DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																			<span class="glyphicon glyphicon-trash"></span>Exc
																		</button>
																	</span>
																<?php } ?>	
															</div>
															<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																Aguarde um instante! Estamos processando sua solicitação!
															</div>
														</div>
													<?php } else { ?>
														<button type="submit" class="btn btn-lg btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>	
														<div class="col-md-12 alert alert-warning aguardar" role="alert" >
															Aguarde um instante! Estamos processando sua solicitação!
														</div>
													<?php } ?>
													
													<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header bg-success text-center">
																	<h4 class="modal-title" id="visulClienteDepModalLabel">Cadastrado com sucesso!</h4>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
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
<?php if ($metodo == 2) { ?>
<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<form method="POST" action="../../excluir/<?php echo $query['idApp_Consulta'];?>">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
				</div>
				<div class="modal-body">
					<p>Ao confirmar esta operação os dados serão excluídos permanentemente do sistema.
						Esta operação é irreversível.</p>
				</div>
				<div class="modal-footer">
					<div class="row text-left">
						<input type="hidden" id="Quais_Excluir" name="Quais_Excluir">	
						<span id="Texto_Excluir"></span>
						<div class="col-md-5 text-left">
							<label for="DeletarOS">Deseja Apagar as O.S.Vinculas?</label><br>
							<div class="btn-group" data-toggle="buttons">
								<?php
								foreach ($select['DeletarOS'] as $key => $row) {
									if (!$alterar['DeletarOS']) $alterar['DeletarOS'] = 'N';

									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

									if ($alterar['DeletarOS'] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="DeletarOS_' . $hideshow . '">'
										. '<input type="radio" name="DeletarOS" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="DeletarOS_' . $hideshow . '">'
										. '<input type="radio" name="DeletarOS" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" >' . $row
										. '</label>'
										;
									}
								}
								?>
							</div>
						</div>	
					</div>
					<div id="DeletarOS" <?php echo $div['DeletarOS']; ?>>
						<br>
						<div class="row text-left ">	
							<div class="col-md-12 bg-danger">
								<h4 for="DeletarOS"><span class="glyphicon glyphicon-alert"></span> Atenção!! Caso as O.S., vinculadas aos agendamentos selecionados, não pertençam a nenhum outro agendamento, elas também serão apagadas?<span class="glyphicon glyphicon-alert"></span></h4>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-6 text-left">
							<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotaoExcluir()" data-dismiss="modal">
								<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
							</button>
						</div>
						<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>	
							<div class="col-md-6 text-right">
								<button type="submit" class="btn btn-md btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" data-loading-text="Aguarde..." >
									<span class="glyphicon glyphicon-trash"></span> Excluir
								</button>
							</div>	
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php } ?>

<div id="addClienteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addClienteModalLabel">Cadastrar Cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-cliente"></span>
				<form method="post" id="insert_cliente_form">
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="NomeCliente">Nome do Cliente: *</label>
								<input name="NomeCliente" type="text" class="form-control" id="NomeCliente" maxlength="255" placeholder="Nome do Cliente">
							</div>
							<div class="col-md-3">
								<label for="CelularCliente">Celular: *</label>
								<input type="text" class="form-control Celular" id="CelularCliente" maxlength="11" name="CelularCliente" placeholder="(XX)999999999">
							</div>
							<div class="col-md-3">
								<label for="DataNascimento">Data do Aniversário:</label>
								<input type="text" class="form-control Date" maxlength="10" name="DataNascimento" placeholder="DD/MM/AAAA">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 ">
								<h4 class="mb-3">Sexo</h4>
								<div class="col-md-3 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="Sexo" class="custom-control-input "  id="Retirada" value="M">
										<label class="custom-control-label" for="Masculino">Mas</label>
									</div>
								</div>
								<div class="col-md-3 mb-3 ">	
									<div class="custom-control custom-radio">
										<input type="radio" name="Sexo" class="custom-control-input " id="Combinar" value="F">
										<label class="custom-control-label" for="Feminino">Fem </label>
									</div>
								</div>
								<div class="col-md-3 mb-3 ">
									<div class="custom-control custom-radio">
										<input type="radio" name="Sexo" class="custom-control-input " id="Correios" value="O" checked>
										<label class="custom-control-label" for="Outros">Outros</label>
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
					<div class="collapse" id="DadosComplementares">
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label for="CepCliente">Cep:</label>
									<input type="text" class="form-control Numero" id="CepCliente" maxlength="8" name="CepCliente">
								</div>
								<div class="col-md-6">
									<label for="EnderecoCliente">Endreço:</label>
									<input type="text" class="form-control" id="EnderecoCliente" maxlength="100" name="EnderecoCliente">
								</div>
								<div class="col-md-3">
									<label for="NumeroCliente">Numero:</label>
									<input type="text" class="form-control" id="NumeroCliente" maxlength="100" name="NumeroCliente">
								</div>
							</div>	
							<div class="row">
								<div class="col-md-3">
									<label for="ComplementoCliente">Complemento:</label>
									<input type="text" class="form-control" id="ComplementoCliente" maxlength="100" name="ComplementoCliente" >
								</div>	
								<div class="col-md-3">
									<label for="BairroCliente">Bairro:</label>
									<input type="text" class="form-control" id="BairroCliente" maxlength="100" name="BairroCliente" >
								</div>
								<div class="col-md-3">
									<label for="CidadeCliente">Município:</label>
									<input type="text" class="form-control" id="CidadeCliente" maxlength="100" name="CidadeCliente" >
								</div>
								<div class="col-md-3">
									<label for="EstadoCliente">Estado:</label>
									<input type="text" class="form-control" id="EstadoCliente" maxlength="2" name="EstadoCliente" >
								</div>
							</div>	
							<div class="row">
								<div class="col-md-3 ">
									<label class="" for="ReferenciaCliente">Referencia:</label>
									<textarea class="form-control " id="ReferenciaCliente" name="ReferenciaCliente"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharCliente" id="botaoFecharCliente">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadCliente" id="botaoCadCliente" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarCliente" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="msgClienteExiste" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
	<div id="addClientePetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<span class="modal-title" id="addClientePetModalLabel"></span>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="msg-error-clientepet"></span>
					<form method="post" id="insert_clientepet_form">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="NomeClientePet">Nome do Pet: *</label>
									<input name="NomeClientePet" type="text" class="form-control" id="NomeClientePet" maxlength="255" placeholder="Nome do Pet">
								</div>
								<div class="col-md-3">
									<label for="DataNascimentoPet">Data de Nascimento:</label>
									<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoPet" placeholder="DD/MM/AAAA">
								</div>
								<div class="col-lg-3 ">
									<h4 class="mb-3">Gênero</h4>
									<div class="row">
										<div class="col-md-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoPet" class="custom-control-input "  id="Retirada" value="M" checked>
												<label class="custom-control-label" for="Masculino">MACHO</label>
											</div>
										</div>
										<div class="col-md-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoPet" class="custom-control-input " id="Combinar" value="F">
												<label class="custom-control-label" for="Feminino">FÊMEA</label>
											</div>
										</div>
									</div>	
								</div>
								<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" >
							</div>
							<div class="row">
								<!--
								<div class="col-md-3">
									<label for="EspeciePet">Especie: *</label>
									<input name="EspeciePet" type="text" class="form-control" id="EspeciePet" maxlength="45" placeholder="Especie do Pet">
								</div>
								-->
								<div class="col-md-3 text-left">
									<label for="EspeciePet">Especie:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="EspeciePet" name="EspeciePet">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['EspeciePet'] as $key => $row) {
											if ($cadastrar['EspeciePet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="RacaPet">Raca:</label>
									<input name="RacaPet" type="text" class="form-control" id="RacaPet" maxlength="45" placeholder="Raca do Pet">
								</div>
								<div class="col-md-3 text-left">
									<label for="PeloPet">Pelo:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="PeloPet" name="PeloPet">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['PeloPet'] as $key => $row) {
											if ($cadastrar['PeloPet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<!--
								<div class="col-md-3">
									<label for="PeloPet">Pelo: *</label>
									<input name="PeloPet" type="text" class="form-control" id="PeloPet" maxlength="45" placeholder="Pelo do Pet">
								</div>
								-->
								<div class="col-md-3 text-left">
									<label for="PortePet">Porte:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="PortePet" name="PortePet">
										<option value="">-- Selecione uma opção --</option>
										<?php
										foreach ($select['PortePet'] as $key => $row) {
											if ($cadastrar['PortePet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<!--
								<div class="col-md-3">
									<label for="PortePet">Porte: *</label>
									<input name="PortePet" type="text" class="form-control" id="PortePet" maxlength="45" placeholder="Porte do Pet">
								</div>
								-->
							</div>
							<div class="row">
								<div class="col-md-3">
									<label for="CorPet">Cor:</label>
									<input name="CorPet" type="text" class="form-control" id="CorPet" maxlength="45" placeholder="Cor do Pet">
								</div>
								<div class="col-md-3">
								</div>
								<div class="col-md-6">
									<label for="ObsPet">Obs:</label>
									<input name="ObsPet" type="text" class="form-control" id="ObsPet" maxlength="255" placeholder="Observacao">
								</div>
							</div>								
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<br>
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>
							</div>	
							<div class="col-sm-6">
								<br>
								<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
									<span class="glyphicon glyphicon-plus"></span> Cadastrar
								</button>
							</div>	
							<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
								Aguarde um instante! Estamos processando sua solicitação!
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php }else{ ?>
	<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
		<div id="addClienteDepModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<span class="modal-title" id="addClienteDepModalLabel"></span>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span id="msg-error-clientedep"></span>
						<form method="post" id="insert_clientedep_form">
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="NomeClienteDep">Nome do Dependente: *</label>
										<input name="NomeClienteDep" type="text" class="form-control" id="NomeClienteDep" maxlength="255" placeholder="Nome do Dependente">
									</div>
									<div class="col-md-3">
										<label for="DataNascimentoDep">Data de Nascimento:</label>
										<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoDep" placeholder="DD/MM/AAAA">
									</div>
									<div class="col-lg-3 ">
										<h4 class="mb-3">Sexo</h4>
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoDep" class="custom-control-input "  id="Retirada" value="M">
												<label class="custom-control-label" for="Masculino">Mas</label>
											</div>
										</div>
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoDep" class="custom-control-input " id="Combinar" value="F">
												<label class="custom-control-label" for="Feminino">Fem </label>
											</div>
										</div>
										<div class="col-md-4 mb-3 ">
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoDep" class="custom-control-input " id="Correios" value="O" checked>
												<label class="custom-control-label" for="Outros">Outros</label>
											</div>
										</div>
									</div>
									<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" >
								</div>
								<div class="row">					
									<div class="col-md-6">
										<label for="RelacaoDep">Relação</label>
										<select data-placeholder="Selecione uma opção..." class="form-control"
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
									<div class="col-md-6">
										<label for="ObsDep">Obs: *</label>
										<input name="ObsDep" type="text" class="form-control" id="ObsDep" maxlength="255" placeholder="Observacao">
									</div>
								</div>								
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<br>
									<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
										<span class="glyphicon glyphicon-remove"></span> Fechar
									</button>
								</div>	
								<div class="col-sm-6">
									<br>
									<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
										<span class="glyphicon glyphicon-plus"></span> Cadastrar
									</button>
								</div>	
								<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
									Aguarde um instante! Estamos processando sua solicitação!
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } ?>