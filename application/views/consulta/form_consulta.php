
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php if (isset($alterarcliente) && $alterarcliente == 2) { ?>
				<?php if ($nav_secundario) echo $nav_secundario; ?>
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
					<?php if (isset($msg)) echo $msg; ?>
					<div class="panel panel-info">
						<div class="panel-heading">
						<?php echo form_open_multipart($form_open_path); ?>
							<input type="hidden" id="exibir_id" value="<?php echo $exibir_id; ?>" />
							<input type="hidden" id="Caminho2" name="Caminho2" value="<?php echo $caminho2; ?>">
							<input type="hidden" id="metodo" value="<?php echo $metodo; ?>">
							<input type="hidden" id="count_repet" value="<?php echo $count_repet; ?>">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
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
									<?php if($alterarcliente == 1){?>
										<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
											<label  >Cliente: </label>
											<input type="text" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
											<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
											<?php echo form_error('idApp_Cliente'); ?>
										</div>
										<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
										<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
										<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
										<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
											<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
												<label  for="idApp_ClienteDep">Dep</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
													<option value=""></option>
												</select>
												<span class="modal-title" id="Dep"></span>
											</div>
										<?php } ?>
										<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
											<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
												<label  for="idApp_ClientePet">Pet</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
													<option value=""></option>
												</select>
												<span class="modal-title" id="Pet"></span>
											</div>
										<?php } ?>
									<?php }elseif($alterarcliente == 2){?>	
										<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
											<label >Cliente</label>
											<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Cliente']['NomeCliente']; ?>">
										</div>
										<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
											<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
												<label  for="idApp_ClienteDep">Dep</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
													<option value=""></option>
												</select>
												<span class="modal-title" id="Dep"></span>
											</div>

										<?php } ?>
										<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
											<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
												<label  for="idApp_ClientePet">Pet</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
													<option value=""></option>
												</select>
												<span class="modal-title" id="Pet"></span>
											</div>
										<?php } ?>	
									<?php } ?>
								</div>
							</div>
							<?php if($this->Basico_model->get_dt_validade()) { ?>			
								<div class="row">
									<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 text-left">
										<label for="Cadastrar">Encontrou Cli/Pet/Dep?</label><br>
										<div class="btn-larg-right btn-group" data-toggle="buttons">
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
									<div id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
										<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 text-left">
											<label >Recarregar</label><br>
											<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
													<span class="glyphicon glyphicon-refresh"></span>Recar
											</button>
										</div>
										<?php if($alterarcliente == 1){?>
											<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">
													<label>Pesquisar Dep/Cliente:</label>
													<input type="text" class="form-control" name="id_ClienteDep_Auto" id="id_ClienteDep_Auto" value="<?php echo $cadastrar['id_ClienteDep_Auto']; ?>"  placeholder="Pesquisar Dep">
													<span class="modal-title" id="NomeClienteDepAuto1"><?php echo $cadastrar['NomeClienteDepAuto']; ?></span>
													<input type="hidden" id="NomeClienteDepAuto" name="NomeClienteDepAuto" value="<?php echo $cadastrar['NomeClienteDepAuto']; ?>" />
												</div>
											<?php } ?>
											<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">
													<label>Pesquisar Pet/Cliente:</label>
													<input type="text" class="form-control" name="id_ClientePet_Auto" id="id_ClientePet_Auto" value="<?php echo $cadastrar['id_ClientePet_Auto']; ?>"  placeholder="Pesquisar Pet">
													<span class="modal-title" id="NomeClientePetAuto1"><?php echo $cadastrar['NomeClientePetAuto']; ?></span>
													<input type="hidden" id="NomeClientePetAuto" name="NomeClientePetAuto" value="<?php echo $cadastrar['NomeClientePetAuto']; ?>" />
												</div>
											<?php } ?>
										<?php } ?>
										<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2 text-left">	
											<label for="Cadastrar">Cliente</label><br>
											<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addClienteModal">
												<span class="glyphicon glyphicon-plus"></span>Cad
											</button>
										</div>
										<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
											<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2 text-left">
												<label >Pet</label><br>
												<button type="button" class="btn btn-success btn-block" id="addPet" data-toggle="modal" data-target="#addClientePetModal">
													<span class="glyphicon glyphicon-plus"></span>Cad
												</button>
											</div>
										<?php }else{ ?>	
											<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
												<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2 text-left">
													<label >Dependente</label><br>
													<button type="button" class="btn btn-success btn-block" id="addDep"  data-toggle="modal" data-target="#addClienteDepModal">
														<span class="glyphicon glyphicon-plus"></span>Cad
													</button>
												</div>
											<?php } ?>
										<?php } ?>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
											<?php echo form_error('Cadastrar'); ?>
										</div>		
									</div>
								</div>
							<?php } ?>
							<br>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">	
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
													<label for="Obs">Evento:</label>
													<textarea class="form-control" id="Obs" name="Obs" rows="1"><?php echo $query['Obs']; ?></textarea>
												</div>
												<div class="col-xs-11 col-sm-7 col-md-7 col-lg-6 ">	
													<label for="Data">Data Início : </label>												
													<div class="btn-larg-right input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="Data" id="Data" value="<?php echo $query['Data']; ?>" onchange="ocorrencias(), dataehora(this.value, 'null')" onkeyup="ocorrencias(), dataehora(this.value, 'null')">
													</div>
													<?php echo form_error('Data'); ?>
												</div>	
												<div class="col-xs-12 col-sm-5 col-md-5 col-lg-6 ">
													<label for="Hora">Dàs :</label>
													
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
															   accept=""name="HoraInicio" id="HoraInicio" value="<?php echo $query['HoraInicio']; ?>" onchange="dataehora('null', this.value)" onkeyup="dataehora('null', this.value)">
													
													<?php echo form_error('HoraInicio'); ?>
												</div>
												<input type="hidden" id="Hidden_Data" value="<?php echo $query['Data']; ?>">
												<input type="hidden" id="Hidden_HoraInicio" value="<?php echo $query['HoraInicio']; ?>">		
												<div class="col-xs-11 col-sm-7 col-md-7 col-lg-6 ">	
													<label for="Data2">Data Fim : </label>												
													<div class="btn-larg-right input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   name="Data2" id="Data2" value="<?php echo $query['Data2']; ?>">
													</div>
													<?php echo form_error('Data2'); ?>
												</div>
												<div class="col-xs-12 col-sm-5 col-md-5 col-lg-6 ">		
													<label for="Hora">Às :</label>
													
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
															   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
													
													<?php echo form_error('HoraFim'); ?>
												</div>	
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6  form-inline text-left">
													<label for="idTab_TipoConsulta">Tipo:</label><br>
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
												<?php if ($metodo == 1) { ?>
													<?php if (isset($extra) && $extra == "S") { ?>	
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<label>Repeticao</label>
															<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Repeticao'];?> - <?php echo $_SESSION['Datas']['DataTermino'];?>">
															<?php echo form_error('Repeticao'); ?>
														</div>
													<?php  } else { ?>
														<!--
														<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
															<label for="Extra">Extra?</label><br>
															<div class="btn-larg-right btn-group" data-toggle="buttons">
																<?php
																/*
																foreach ($select['Extra'] as $key => $row) {
																	//if (!$cadastrar['Extra']) $cadastrar['Extra'] = 'N';
																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																	if ($cadastrar['Extra'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="Extra_' . $hideshow . '">'
																		. '<input type="radio" name="Extra" id="' . $hideshow . '" '
																		. 'onchange="extra(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="Extra_' . $hideshow . '">'
																		. '<input type="radio" name="Extra" id="' . $hideshow . '" '
																		. 'onchange="extra(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																*/
																?>
															</div>
															<?php #echo form_error('Extra'); ?>
														</div>
														<div id="Extra" <?php #echo $div['Extra']; ?>>
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left ">
																<label  for="Repeticao">Repeticao</label>
																<select data-placeholder="Selecione uma opção..." class="form-control" id="Repeticao" name="Repeticao" onchange="repeticaoSelecionada(this.value)">
																	<option value=""></option>
																</select>
																<?php #echo form_error('Repeticao'); ?>
															</div>
														</div>
														-->
													<?php  } ?>
													<input type="hidden" id="Hidden_StatusExtra" value="<?php echo $cadastrar['Extra']; ?>" readonly="" />
													<!--<input type="hidden" id="Hidden_Repeticao" name="Hidden_Repeticao" value="<?php echo $query['Repeticao']; ?>" readonly="" />-->
												<?php  } elseif($metodo == 2) { ?>
													<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
														<label>Repeticao</label><br>
														<a type="button" class="btn btn-md btn-info btn-block" data-loading-text="Aguarde..." href="<?php echo base_url() . 'Consulta/cadastrar_extra/' . $_SESSION['Consulta']['idApp_Cliente'] . '/' . $_SESSION['Consulta']['Repeticao']; ?>">
															<?php echo $_SESSION['Consulta']['Repeticao']; ?> / Cad Extra 										
														</a>
														<input type="hidden" id="Repeticao" name="Repeticao" readonly="" value="<?php echo $_SESSION['Consulta']['Repeticao']; ?>">
													</div>
													<input type="hidden" id="Hidden_StatusExtra" value="<?php echo $cadastrar['Extra']; ?>" readonly="" />
													<input type="hidden" id="Hidden_Repeticao" name="Hidden_Repeticao" value="<?php echo $_SESSION['Consulta']['Repeticao']; ?>" readonly="" />
												<?php  } ?>
												<input type="hidden" id="Hidden_Caso" name="Hidden_Caso" value="<?php echo $cadastrar['Hidden_Caso']; ?>" readonly="" />
												<input type="hidden" id="Hidden_RepeticaoCons" readonly="" />
												<input type="hidden" id="Hidden_RepeticaoOrca" readonly="" />
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-left">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
											<div class="panel panel-warning">
												<div class="panel-heading">	
													<div class="row">
														<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 text-left">
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
																		. 'onchange="hidden_status(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-' . $this->basico->tipo_status_cor($key) . ' " name="radio" id="radio' . $key . '">'
																		. '<input type="radio" name="idTab_Status" id="radio" class="idTab_Status" '
																		. 'onchange="hidden_status(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
														<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-left">
															<label for="status">Stt</label><br>
															<span id="botao_status"></span>
														</div>	
													</div>
													<input type="hidden" id="Hidden_status" name="Hidden_status" value="<?php echo $query['idTab_Status']; ?>">
													<?php if ($metodo == 1) { ?>			
														<div class="row text-left">
															<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
																<label for="Repetir">Repetir?</label><br>
																<div class="btn-larg-right btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Repetir'] as $key => $row) {
																		//if (!$cadastrar['Repetir']) $cadastrar['Repetir'] = 'N';
																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($cadastrar['Repetir'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Repetir_' . $hideshow . '">'
																			. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																			. 'onchange="statusRepetir(this.value)" '
																			//. 'onchange="ocorrencias(this.value)" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="Repetir_' . $hideshow . '">'
																			. '<input type="radio" name="Repetir" id="' . $hideshow . '" '
																			. 'onchange="statusRepetir(this.value)" '
																			//. 'onchange="ocorrencias(this.value)" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>

																</div>
																<?php echo form_error('Repetir'); ?>
															</div>
															<input type="hidden" id="Hidden_Status_Repetir" name="Hidden_Status_Repetir" value="<?php echo $cadastrar['Repetir']; ?>" />
															<div id="Repetir" <?php echo $div['Repetir']; ?>>
																<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">	
																	<label for="Recorrencias">Vez(es)</label>
																		<input type="text" class="form-control Numero" name="Recorrencias" id="Recorrencias" value="<?php echo $query['Recorrencias']; ?>" onkeyup="ocorrencias(), qtd_ocorrencias(), fechaBuscaOS()">
																	<?php echo form_error('Recorrencias'); ?>	
																</div>
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<div class="row">
																		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
																			<label for="Intervalo">A cada:</label><br>
																			<input type="text" class="form-control Numero" id="Intervalo" maxlength="3" placeholder="Ex:'5'dias"
																				   name="Intervalo" onkeyup="ocorrencias()" value="<?php echo $query['Intervalo'] ?>">
																			<?php echo form_error('Intervalo'); ?>		
																		</div>
																		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
																	</div>
																</div>
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<div class="row">		
																		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
																			<label for="Periodo">Durante:</label><br>
																			<input type="text" class="form-control Numero" id="Periodo" maxlength="3" placeholder="Ex:'30'dias"
																				   name="Periodo" value="<?php echo $query['Periodo'] ?>" onkeyup="dateTermina()">
																			<?php echo form_error('Periodo'); ?>		
																		</div>
																		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
																	</div>
																</div>
																<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">	
																	<label for="DataMinima">Próxima: </label>
																		<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataMinima" id="DataMinima" value="<?php echo $cadastrar['DataMinima']; ?>" >
																	<?php echo form_error('DataMinima'); ?>	
																</div>
																<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">	
																	<label for="DataTermino">Última: </label>
																		<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataTermino" id="DataTermino" value="<?php echo $query['DataTermino']; ?>" >
																	<?php echo form_error('DataTermino'); ?>	
																</div>
															</div>
														</div>
													<?php } else { ?>
														<div class="row text-left">	
															<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
																<label>Vez(es)</label>
																<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencia']; ?>">
															</div>
															<!--
															<div class="col-xs-7 col-sm-6 col-md-6 col-lg-4">
																<label>Término</label>
																<input class="form-control"<?php #echo $readonly; ?> readonly="" value="<?php #echo $_SESSION['Consulta']['DataTermino']; ?>">
															</div>
															-->
															<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row adicionar">
														<?php if ($vincular == "S" && ($_SESSION['Usuario']['Nivel'] == 0 || $_SESSION['Usuario']['Nivel'] == 1)) { ?>
															<div class="col-xs-12 col-sm-3 col-md-6 col-lg-6">
																<label for="Adicionar">Adicionar O.S.?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Adicionar'] as $key => $row) {
																		if (!$cadastrar['Adicionar']) $cadastrar['Adicionar'] = 'N';
																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																		if ($cadastrar['Adicionar'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Adicionar_' . $hideshow . '">'
																			. '<input type="radio" name="Adicionar" id="' . $hideshow . '" '
																			//. 'onchange="extra()" '
																			. 'onchange="statusAdicionar(this.value)" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="Adicionar_' . $hideshow . '">'
																			. '<input type="radio" name="Adicionar" id="' . $hideshow . '" '
																			//. 'onchange="extra()" '
																			. 'onchange="statusAdicionar(this.value)" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
																<?php echo form_error('Adicionar'); ?>
															</div>
															<div id="Adicionar" <?php echo $div['Adicionar']; ?>>
																<div class="col-xs-12 col-sm-3 col-md-6 col-lg-6">
																	<label class="porconsulta" for="PorConsulta">Gerar " <span id="Ocorrencias"></span> " O.S.</label><br>
																	<div class="btn-group porconsulta" data-toggle="buttons">
																		<?php
																		foreach ($select['PorConsulta'] as $key => $row) {
																			if (!$cadastrar['PorConsulta']) $cadastrar['PorConsulta'] = 'S';

																			($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($cadastrar['PorConsulta'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="PorConsulta_' . $hideshow . '">'
																				. '<input type="radio" name="PorConsulta" id="' . $hideshow . '" '
																				//. 'onchange="qtd_ocorrencias(this.value)" '
																				. 'onchange="statusPorConsulta(this.value)" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="PorConsulta_' . $hideshow . '">'
																				. '<input type="radio" name="PorConsulta" id="' . $hideshow . '" '
																				//. 'onchange="qtd_ocorrencias(this.value)" '
																				. 'onchange="statusPorConsulta(this.value)" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
																<div id="PorConsulta" <?php echo $div['PorConsulta']; ?>>
																	<div class="col-xs-12 col-sm-3 col-md-6 col-lg-6">
																		<label class="novaos" for="NovaOS">Gerar "1" O.S.</label><br>
																		<div class="btn-group novaos" data-toggle="buttons">
																			<?php
																			foreach ($select['NovaOS'] as $key => $row) {
																				if (!$cadastrar['NovaOS']) $cadastrar['NovaOS'] = 'S';

																				($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																				if ($cadastrar['NovaOS'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="NovaOS_' . $hideshow . '">'
																					. '<input type="radio" name="NovaOS" id="' . $hideshow . '" '
																					//. 'onchange="fechaBuscaOS(this.value)" '
																					. 'onchange="statusNovaOs(this.value)" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="NovaOS_' . $hideshow . '">'
																					. '<input type="radio" name="NovaOS" id="' . $hideshow . '" '
																					//. 'onchange="fechaBuscaOS(this.value)" '
																					. 'onchange="statusNovaOs(this.value)" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																	<div class="col-xs-12 col-sm-3 col-md-6 col-lg-6">
																		<label class="vincular " for="Vincular">Buscar O.S.?</label><br>
																		<div class="btn-group vincular " data-toggle="buttons">
																			<?php
																			foreach ($select['Vincular'] as $key => $row) {
																				if (!$cadastrar['Vincular']) $cadastrar['Vincular'] = 'S';

																				($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																				if ($cadastrar['Vincular'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="Vincular_' . $hideshow . '">'
																					. '<input type="radio" name="Vincular" id="' . $hideshow . '" '
																					. 'onchange="statusVincular(this.value)" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="Vincular_' . $hideshow . '">'
																					. '<input type="radio" name="Vincular" id="' . $hideshow . '" '
																					. 'onchange="statusVincular(this.value)" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																	<?php if($alterarcliente == 1){?>
																		<div id="Vincular" <?php echo $div['Vincular']; ?>>
																			<div class="hnovaos col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left ">
																				<label  for="idApp_OrcaTrata">O.S.</label>
																				<!--<span id="idApp_OrcaTrata"></span>-->
																				
																				<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_OrcaTrata" name="idApp_OrcaTrata" onchange="osSelecionada(this.value)">
																					<option value=""></option>
																				</select>
																				
																				<?php echo form_error('idApp_OrcaTrata'); ?>
																			</div>
																		</div>
																	<?php } elseif($alterarcliente == 2){?>	
																		<div id="Vincular" <?php echo $div['Vincular']; ?>>
																			<div class="hnovaos col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left ">
																				<label  for="idApp_OrcaTrata">O.S.</label>
																				<!--<span id="idApp_OrcaTrata"></span>-->
																				
																				<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_OrcaTrata" name="idApp_OrcaTrata" onchange="osSelecionada(this.value)">
																					<option value=""></option>
																				</select>
																				
																				<?php echo form_error('idApp_OrcaTrata'); ?>
																			</div>
																		</div>	
																	<?php } ?>
																</div>
															</div>
														<?php } ?>
													</div>
													<input type="hidden" id="Hidden_Status_Adicionar" value="<?php echo $cadastrar['Adicionar']; ?>" readonly="" />
													<input type="hidden" id="Hidden_Status_PorConsulta" value="<?php echo $cadastrar['PorConsulta']; ?>" readonly="" />
													<input type="hidden" id="Hidden_NovaOS" value="<?php echo $cadastrar['NovaOS']; ?>" readonly="" />
													<input type="hidden" id="Hidden_Status_Vincular" value="<?php echo $cadastrar['Vincular']; ?>" readonly="" />
													<input type="hidden" id="Hidden_idApp_OrcaTrata" name="Hidden_idApp_OrcaTrata" value="<?php echo $query['idApp_OrcaTrata']; ?>" readonly="" />
													<input type="hidden" id="OS" name="OS" value="<?php echo $query['OS']; ?>" readonly="" />
													<div class="row">
														<?php if ($metodo > 1) { ?>
															<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
														<?php } ?>
														<?php if ($alterarcliente == 2) { ?>
															<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $_SESSION['Consulta']['idApp_Cliente']; ?>">
														<?php } ?>
														<!--
														<input type="hidden" name="Evento" value="1">
														-->
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
															<?php if($this->Basico_model->get_dt_validade()) { ?>
																<?php if ($metodo == 2) { ?>
																	<br>
																	<button  type="button" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-salvar-modal-sm">
																		<span class="glyphicon glyphicon-save"></span> Salvar e acessar O.S. <b><?php echo $_SESSION['Consulta']['idApp_OrcaTrata'];?></b>
																	</button>
																	<!--
																	<button type="submit" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																		<span class="glyphicon glyphicon-save"></span>Salvar 
																	</button>
																	-->
																	<?php if ($_SESSION['Consulta']['idApp_OrcaTrata'] > 0) { ?>
																		<!--
																		<span class="input-group-btn">
																			<a class="btn btn-lg btn-info " name="submeter5" id="submeter5" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $query['idApp_OrcaTrata']; ?>">
																				<span class="glyphicon glyphicon-print"></span>										
																			</a>
																		</span>
																		-->
																	<?php } ?>
																	<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>
																		<br>
																		<button  type="button" class="btn btn-md btn-danger btn-block" name="submeter2" id="submeter2" onclick="quais(),DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																			<span class="glyphicon glyphicon-trash"></span>Exc
																		</button>
																	<?php } ?>
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning aguardar" role="alert" >
																		Aguarde um instante! Estamos processando sua solicitação!
																	</div>
																<?php } else { ?>
																	<br>
																	<button  type="button" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-salvar-modal-sm">
																		<span class="glyphicon glyphicon-save"></span>Salvar
																	</button>
																	<!--
																	<button type="submit" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																		<span class="glyphicon glyphicon-save"></span> Salvar
																	</button>
																	-->
																	<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																		Aguarde um instante! Estamos processando sua solicitação!
																	</div>
																<?php } ?>
															<?php } ?>
															<div class="modal fade bs-salvar-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header bg-danger">
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																			<h4 class="modal-title">Tem certeza que deseja Salvar?</h4>
																		</div>
																		<div class="modal-body">  
																			<span id="Horarios"></span>
																		</div>
																		<div class="modal-footer">
																			<div class="row">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
																					<label ></label><br>
																					<button type="button" class="btn btn-warning btn-block"  name="submeter7" id="submeter7" onclick="DesabilitaBotaoExcluir()" data-dismiss="modal">
																						<span class="glyphicon glyphicon-ban-circle"></span>Canc.
																					</button>
																				</div>
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<label for="Whatsapp">
																						Enviar <svg enable-background="new 0 0 512 512" width="20" height="20" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
																					</label>
																					<br>
																					<div class="btn-group" data-toggle="buttons">
																						<?php
																						foreach ($select['Whatsapp'] as $key => $row) {
																							if (!$cadastrar['Whatsapp']) $cadastrar['Whatsapp'] = 'N';

																							($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																							if ($cadastrar['Whatsapp'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="Whatsapp_' . $hideshow . '">'
																								. '<input type="radio" name="Whatsapp" id="' . $hideshow . '" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="Whatsapp_' . $hideshow . '">'
																								. '<input type="radio" name="Whatsapp" id="' . $hideshow . '" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>

																					</div>
																				</div>
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
																					<label ></label><br>
																					<button type="submit" class="btn btn-md btn-primary btn-block" name="submeter6" id="submeter6" onclick="DesabilitaBotaoExcluir(this.name)" data-loading-text="Aguarde..." value="1" >
																						<span class="glyphicon glyphicon-save"></span>Salvar
																					</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
																
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
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
											<?php if (isset($extra) && $extra == "S") { ?>
												<div class="panel panel-warning">
													<div class="panel-heading">									
														<div class="row text-left">	
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																<div style="overflow: auto; height: 350px; ">
																	<?php if( isset($count['POCount']) ) { ?>	
																		<?php for ($i=1; $i <= $count['POCount']; $i++) { ?>
																			<table class="table table-bordered table-condensed table-striped">
																				<thead>
																					<tr>
																						<td class="notclickable col-md-2">
																							<a class="btn btn-xs btn-info notclickable" href="<?php echo base_url() . 'consulta/alterar/'. $repeticao_cons[$i]['idApp_Cliente'] .'/' . $repeticao_cons[$i]['idApp_Consulta']; ?>">
																								<span class="glyphicon glyphicon-edit"></span> <?php echo '' . $repeticao_cons[$i]['Recorrencia'] . ''?>
																							</a>
																							<?php echo '' . $repeticao_cons[$i]['DataInicio'] . ''?>
																						</td>
																						<td class="col-md-3 text-left" scope="col"><?php echo '' . $repeticao_cons[$i]['idApp_OrcaTrata'] . ''?></td>
																						<td class="col-md-1 text-left" scope="col"></td>
																						<td class="col-md-2 text-left" scope="col"></td>
																					</tr>
																				</thead>
																				<!--
																				<thead>
																					<tr>
																						<th class="col-md-1" scope="col">Qtd</th>
																						<th class="col-md-3" scope="col">Produto</th>							
																						<th class="col-md-1" scope="col">R$</th>
																					</tr>
																				</thead>
																				-->
																				<tbody>
																				
																					<?php if( isset($count['PCount'][$i]) ) { ?>
																						<?php for ($k=1; $k <= $count['PCount'][$i]; $k++) { ?>
																								<tr>
																									<td class="col-md-2" scope="col"><?php echo $produto[$i][$k]['Qtd_Prod'] ?></td>
																									<td class="col-md-3" scope="col"><?php echo $produto[$i][$k]['NomeProduto'] ?> | <?php echo $produto[$i][$k]['ObsProduto'] ?></td>
																									<td class="col-md-1" scope="col">R$ <?php echo $produto[$i][$k]['SubtotalProduto'] ?></td>
																									<td class="col-md-2" scope="col"><?php echo $produto[$i][$k]['DataConcluidoProduto'] ?> | <?php echo $produto[$i][$k]['HoraConcluidoProduto'] ?></td>										
																								</tr>
																						<?php } ?>					
																					<?php } else { ?>
																						<tr>
																							<td class="col-md-2" scope="col"></td>
																							<td class="col-md-3" scope="col"></td>
																							<td class="col-md-1" scope="col"></td>
																							<td class="col-md-2" scope="col"></td>										
																						</tr>
																					<?php } ?>
																					
																				</tbody>
																			</table>
																		<?php } ?>
																	<?php } else {?>
																		<h3 class="text-center">Nenhum Orçamento!</h3>
																	<?php } ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php } ?>	
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
									if (!$alterar['DeletarOS']) $alterar['DeletarOS'] = 'S';

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
							<button type="button" class="btn btn-warning" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir()" data-dismiss="modal">
								<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
							</button>
						</div>
						<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>	
							<div class="col-md-6 text-right">
								<button type="submit" class="btn btn-md btn-danger" name="submeter4" id="submeter4" onclick="DesabilitaBotaoExcluir(this.name)" data-loading-text="Aguarde..." >
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
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<label for="NomeCliente">Nome do Cliente: *</label>
								<input name="NomeCliente" type="text" class="form-control" id="NomeCliente" maxlength="255" placeholder="Nome do Cliente">
							</div>
							<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
								<label for="CelularCliente">Celular: *</label>
								<input type="text" class="form-control Celular" id="CelularCliente" maxlength="11" name="CelularCliente" placeholder="(XX)999999999">
							</div>
							<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
								<label for="DataNascimento">Aniversário:</label>
								<input type="text" class="form-control Date" maxlength="10" name="DataNascimento" placeholder="DD/MM/AAAA">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
								<label for="Telefone">Telefone:</label>
								<input type="text" class="form-control Celular CelularVariavel" id="Telefone" maxlength="11" name="Telefone" placeholder="(XX)999999999">
							</div>							
							<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
								<label for="Email">E-mail:</label>
								<input type="text" class="form-control" id="Email" name="Email" maxlength="100"  >
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<h4 class="mb-3">Sexo</h4>
								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-3 ">	
										<div class="custom-control custom-radio">
											<input type="radio" name="Sexo" class="custom-control-input "  id="Retirada" value="M">
											<label class="custom-control-label" for="Masculino">Mas</label>
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-3 ">	
										<div class="custom-control custom-radio">
											<input type="radio" name="Sexo" class="custom-control-input " id="Combinar" value="F">
											<label class="custom-control-label" for="Feminino">Fem </label>
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-3 ">
										<div class="custom-control custom-radio">
											<input type="radio" name="Sexo" class="custom-control-input " id="Correios" value="O" checked>
											<label class="custom-control-label" for="Outros">Out</label>
										</div>
									</div>
								</div>
							</div>
						</div>								
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
								<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
									<span class="glyphicon glyphicon-menu-down"></span> Completar Dados
								</button>
							</div>
						</div>
					</div>
					<div class="collapse" id="DadosComplementares">
						<div class="form-group">
							<div class="row">
								<!--
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
									<label for="CepCliente">Cep:</label>
									<input type="text" class="form-control Numero" id="CepCliente" maxlength="8" name="CepCliente">
								</div>
								-->		
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
									<label for="CepCliente">Cep:</label><br>
									<div class="input-group">
										<input type="text" class="form-control btn-sm Numero" maxlength="8" id="CepCliente" name="CepCliente" >
										<span class="input-group-btn">
											<button class="btn btn-success btn-md" type="button" onclick="BuscaEndCliente()">
												Buscar
											</button>
										</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<label for="EnderecoCliente">Endreço:</label>
									<input type="text" class="form-control" id="EnderecoCliente" maxlength="100" name="EnderecoCliente">
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
									<label for="NumeroCliente">Numero:</label>
									<input type="text" class="form-control" id="NumeroCliente" maxlength="100" name="NumeroCliente">
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
									<label for="ComplementoCliente">Complemento:</label>
									<input type="text" class="form-control" id="ComplementoCliente" maxlength="100" name="ComplementoCliente" >
								</div>	
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
									<label for="BairroCliente">Bairro:</label>
									<input type="text" class="form-control" id="BairroCliente" maxlength="100" name="BairroCliente" >
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
									<label for="CidadeCliente">Município:</label>
									<input type="text" class="form-control" id="CidadeCliente" maxlength="100" name="CidadeCliente" >
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
									<label for="EstadoCliente">Estado:</label>
									<input type="text" class="form-control" id="EstadoCliente" maxlength="2" name="EstadoCliente" >
								</div>
								<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 ">
									<label class="" for="ReferenciaCliente">Referencia:</label>
									<textarea class="form-control " id="ReferenciaCliente" name="ReferenciaCliente"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharCliente" id="botaoFecharCliente">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadCliente" id="botaoCadCliente" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning aguardarCliente" role="alert" >
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
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="NomeClientePet">Nome*</label>
									<input name="NomeClientePet" type="text" class="form-control" id="NomeClientePet" maxlength="255" placeholder="Nome do Pet">
								</div>
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
									<label for="DataNascimentoPet">Nascimento:</label>
									<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoPet" placeholder="DD/MM/AAAA">
								</div>
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 ">
									<h4 class="mb-3">Gênero</h4>
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoPet" class="custom-control-input "  id="Retirada" value="M" checked>
												<label class="custom-control-label" for="Masculino">MACHO</label>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoPet" class="custom-control-input " id="Combinar" value="F">
												<label class="custom-control-label" for="Feminino">FÊMEA</label>
											</div>
										</div>
									</div>	
								</div>
								<?php if($alterarcliente == 1){?>
									<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" >
								<?php }elseif($alterarcliente == 2){?>
									<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $_SESSION['Consulta']['idApp_Cliente']; ?>" >
								<?php } ?>
							</div>
							<div class="row">
								<!--
								<div class="col-md-3">
									<label for="EspeciePet">Especie: *</label>
									<input name="EspeciePet" type="text" class="form-control" id="EspeciePet" maxlength="45" placeholder="Especie do Pet">
								</div>
								-->
								<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left">
									<label for="EspeciePet">Especie:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="EspeciePet" name="EspeciePet">
										<option value="">-- Especie --</option>
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
								<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left">
									<label for="RacaPet">Raca:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="RacaPet" name="RacaPet">
										<option value="">-- Raca --</option>
										<?php
										foreach ($select['RacaPet'] as $key => $row) {
											if ($cadastrar['RacaPet'] == $key) {
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
									<label for="RacaPet">Raca:</label>
									<input name="RacaPet" type="text" class="form-control" id="RacaPet" maxlength="45" placeholder="Raca do Pet">
								</div>
								-->
								<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left">
									<label for="PeloPet">Pelo:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="PeloPet" name="PeloPet">
										<option value="">-- Pelo --</option>
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
								<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
									<label for="CorPet">Cor: *</label>
									<input name="CorPet" type="text" class="form-control" id="CorPet" maxlength="45" placeholder="Cor do Pet">
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left">
									<label for="PortePet">Porte?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control"
											id="PortePet" name="PortePet">
										<option value="">-- Porte --</option>
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
								<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
									<label for="PesoPet">Peso: </label>
									<div class="input-group">
										<input name="PesoPet" type="text" class="form-control ValorPeso" id="PesoPet" maxlength="10" placeholder="0,000">
										<span class="input-group-addon">kg</span>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 ">
									<h4 class="mb-3">Alérgico</h4>
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="AlergicoPet" class="custom-control-input "  id="AlergicoPet_Nao" value="N" checked>
												<label class="custom-control-label" for="Nao">Não</label>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="AlergicoPet" class="custom-control-input " id="AlergicoPet_Sim" value="S">
												<label class="custom-control-label" for="Sim">Sim</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 ">
									<h4 class="mb-3">Castrado</h4>
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="CastradoPet" class="custom-control-input "  id="CastradoPet_Nao" value="N" checked>
												<label class="custom-control-label" for="Nao">Não</label>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="CastradoPet" class="custom-control-input " id="CastradoPet_Sim" value="S">
												<label class="custom-control-label" for="Sim">Sim</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
									<label for="ObsPet">Obs:</label>
									<textarea name="ObsPet" type="text" class="form-control" id="ObsPet" maxlength="255" placeholder="Observacao" rows="1"></textarea>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 text-left">	
									<label >Cadastrar Raca</label><br>
									<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#addRacaPetModal">
										Cad/Edit/Excl
									</button>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">	
								<br>
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>
							</div>	
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">	
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
	<div id="addRacaPetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRacaPetModalLabel">Cadastrar RacaPet</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="msg-error-racapet"></span>
					<form method="post" id="insert_racapet_form">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">RacaPet</label>
							<div class="col-sm-10">
								<input name="Novo_RacaPet" type="text" class="form-control" id="Novo_RacaPet" placeholder="RacaPet">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<br>
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharRacaPet" id="botaoFecharRacaPet">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>
							</div>	
							<div class="col-sm-6">
								<br>
								<button type="submit" class="btn btn-success btn-block" name="botaoCadRacaPet" id="botaoCadRacaPet" >
									<span class="glyphicon glyphicon-plus"></span> Cadastrar
								</button>
							</div>	
							<div class="col-md-12 alert alert-warning aguardarRacaPet" role="alert" >
								Aguarde um instante! Estamos processando sua solicitação!
							</div>
						</div>
					</form>
					<?php if (isset($list3)) echo $list3; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="alterarRacaPet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarRacaPetLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="alterarRacaPetLabel">Raca</h4>
				</div>
				<div class="modal-body">
					<span id="msg-error-alterar-racapet"></span>
					<form method="post" id="alterar_racapet_form">
						<div class="form-group">
							<label for="Nome_RacaPet" class="control-label">Raca:</label>
							<input type="text" class="form-control" name="Nome_RacaPet" id="Nome_RacaPet">
						</div>
						<input type="hidden" name="id_RacaPet" id="id_RacaPet">
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" name="CancelarRacaPet" id="CancelarRacaPet" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-danger" name="AlterarRacaPet" id="AlterarRacaPet" >Alterar</button>	
							<div class="col-md-12 alert alert-warning aguardarAlterarRacaPet" role="alert" >
								Aguarde um instante! Estamos processando sua solicitação!
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="excluirRacaPet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirRacaPetLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="excluirRacaPetLabel">Raca</h4>
				</div>
				<div class="modal-body">
					<span id="msg-error-excluir-racapet"></span>
					<form method="post" id="excluir_racapet_form">
						<div class="form-group">
							<label for="ExcluirRacaPet" class="control-label">Raca:</label>
							<input type="text" class="form-control" name="ExcluirRacaPet" id="ExcluirRacaPet" readonly="">
						</div>
						<input type="hidden" name="id_ExcluirRacaPet" id="id_ExcluirRacaPet">
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" name="CancelarExcluirRacaPet" id="CancelarExcluirRacaPet" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-danger" name="Excluirtributo" id="ExcluirRacaPet" >Apagar</button>	
							<div class="col-md-12 alert alert-warning aguardarExcluirRacaPet" role="alert" >
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
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-6">
										<label for="NomeClienteDep">Nome*</label>
										<input name="NomeClienteDep" type="text" class="form-control" id="NomeClienteDep" maxlength="255" placeholder="Nome do Dependente">
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
										<label for="DataNascimentoDep">Nascimento</label>
										<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoDep" placeholder="DD/MM/AAAA">
									</div>
									<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 ">
										<h4 class="mb-3">Sexo</h4>
										<div class="row">
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="SexoDep" class="custom-control-input "  id="Retirada" value="M">
													<label class="custom-control-label" for="Masculino">Mas</label>
												</div>
											</div>
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-3 ">	
												<div class="custom-control custom-radio">
													<input type="radio" name="SexoDep" class="custom-control-input " id="Combinar" value="F">
													<label class="custom-control-label" for="Feminino">Fem </label>
												</div>
											</div>
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-3 ">
												<div class="custom-control custom-radio">
													<input type="radio" name="SexoDep" class="custom-control-input " id="Correios" value="O" checked>
													<label class="custom-control-label" for="Outros">Out</label>
												</div>
											</div>
										</div>
									</div>
									<?php if($alterarcliente == 1){?>
										<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" >
									<?php }elseif($alterarcliente == 2){?>
										<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $_SESSION['Consulta']['idApp_Cliente']; ?>" >
									<?php } ?>
								</div>
								<div class="row">					
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<label for="ObsDep">Obs: *</label>
										<input name="ObsDep" type="text" class="form-control" id="ObsDep" maxlength="255" placeholder="Observacao">
									</div>
								</div>								
							</div>
							<div class="form-group row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<br>
									<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
										<span class="glyphicon glyphicon-remove"></span> Fechar
									</button>
								</div>	
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<br>
									<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
										<span class="glyphicon glyphicon-plus"></span> Cadastrar
									</button>
								</div>	
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning aguardar1" role="alert" >
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