<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryUsuario'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">	
					<?php echo form_open_multipart($form_open_path); ?>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $titulo; ?>
							</div>
							<div class="panel-body">
								<?php #echo validation_errors(); ?>
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Setor</h4>
										<div class="row">
											<div class="col-md-3">
												<label for="Agenda">Agenda?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Agenda'] as $key => $row) {
															(!$query['Agenda']) ? $query['Agenda'] = 'N' : FALSE;

															if ($query['Agenda'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Agenda" id="radiobutton_Agenda' . $key . '">'
																. '<input type="radio" name="Agenda" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Agenda" id="radiobutton_Agenda' . $key . '">'
																. '<input type="radio" name="Agenda" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label for="Vendas">Vendas?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Vendas'] as $key => $row) {
															(!$query['Vendas']) ? $query['Vendas'] = 'N' : FALSE;

															if ($query['Vendas'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Vendas" id="radiobutton_Vendas' . $key . '">'
																. '<input type="radio" name="Vendas" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Vendas" id="radiobutton_Vendas' . $key . '">'
																. '<input type="radio" name="Vendas" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label for="Servicos">Servicos?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Servicos'] as $key => $row) {
															(!$query['Servicos']) ? $query['Servicos'] = 'N' : FALSE;

															if ($query['Servicos'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Servicos" id="radiobutton_Servicos' . $key . '">'
																. '<input type="radio" name="Servicos" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Servicos" id="radiobutton_Servicos' . $key . '">'
																. '<input type="radio" name="Servicos" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label for="Entregas">Entregas?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Entregas'] as $key => $row) {
															(!$query['Entregas']) ? $query['Entregas'] = 'N' : FALSE;

															if ($query['Entregas'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Entregas" id="radiobutton_Entregas' . $key . '">'
																. '<input type="radio" name="Entregas" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Entregas" id="radiobutton_Entregas' . $key . '">'
																. '<input type="radio" name="Entregas" id="radiobutton" '
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
								
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Procedimentos</h4>
										<div class="row">
											<div class="col-md-3">
												<label for="Sac">Sac?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Sac'] as $key => $row) {
															(!$query['Sac']) ? $query['Sac'] = 'N' : FALSE;

															if ($query['Sac'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Sac" id="radiobutton_Sac' . $key . '">'
																. '<input type="radio" name="Sac" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Sac" id="radiobutton_Sac' . $key . '">'
																. '<input type="radio" name="Sac" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label for="Marketing">Marketing?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Marketing'] as $key => $row) {
															(!$query['Marketing']) ? $query['Marketing'] = 'N' : FALSE;

															if ($query['Marketing'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Marketing" id="radiobutton_Marketing' . $key . '">'
																. '<input type="radio" name="Marketing" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Marketing" id="radiobutton_Marketing' . $key . '">'
																. '<input type="radio" name="Marketing" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label for="Procedimentos">Procedimentos?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Procedimentos'] as $key => $row) {
															(!$query['Procedimentos']) ? $query['Procedimentos'] = 'N' : FALSE;

															if ($query['Procedimentos'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Procedimentos" id="radiobutton_Procedimentos' . $key . '">'
																. '<input type="radio" name="Procedimentos" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Procedimentos" id="radiobutton_Procedimentos' . $key . '">'
																. '<input type="radio" name="Procedimentos" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label for="Tarefas">Tarefas?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Tarefas'] as $key => $row) {
															(!$query['Tarefas']) ? $query['Tarefas'] = 'N' : FALSE;

															if ($query['Tarefas'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Tarefas" id="radiobutton_Tarefas' . $key . '">'
																. '<input type="radio" name="Tarefas" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Tarefas" id="radiobutton_Tarefas' . $key . '">'
																. '<input type="radio" name="Tarefas" id="radiobutton" '
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

								<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
									<div class="panel panel-primary">
										 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
											<h4 class="panel-title">
												<a class="accordion-toggle">
													<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
													Funções
												</a>
											</h4>
										</div>

										
											<div class="panel-body">

												<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

												<div class="input_fields_wrap3">

												<?php
												for ($i=1; $i <= $count['PTCount']; $i++) {
												?>
												
												<?php if ($metodo == 2) { ?>
													<input type="hidden" name="idApp_Funcao<?php echo $i ?>" id="idApp_Funcao<?php echo $i ?>" value="<?php echo $funcao[$i]['idApp_Funcao']; ?>"/>
												<?php } ?>

												<div class="form-group" id="3div<?php echo $i ?>">
													<div class="panel panel-info">
														<div class="panel-heading">			
															<div class="row">
																<input type="hidden" name="idSis_Usuario<?php echo $i ?>" id="idSis_Usuario<?php echo $i ?>" value="<?php echo $funcao[$i]['idSis_Usuario']; ?>"/>
																
																<div class="col-md-4">
																	<label for="idTab_Funcao<?php echo $i ?>">Funcao <?php echo $i ?>:</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen3"
																			 id="listadinamicad<?php echo $i ?>" name="idTab_Funcao<?php echo $i ?>">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select['idTab_Funcao'] as $key => $row) {
																			//(!$funcao['idTab_Funcao']) ? $funcao['idTab_Funcao'] = $_SESSION['log']['idTab_Funcao']: FALSE;
																			if ($funcao[$i]['idTab_Funcao'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="col-md-3">
																	<label for="Comissao_Funcao">Comissao_Funcao</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="Comissao_Funcao <?php echo $i ?>" maxlength="10" placeholder="0,00"
																			name="Comissao_Funcao<?php echo $i ?>" value="<?php echo $funcao[$i]['Comissao_Funcao'] ?>">
																	</div>
																</div>
																<div class="col-md-3">
																	<label for="Ativo_Funcao">Ativo? </label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['Ativo_Funcao'] as $key => $row) {
																			if (!$funcao[$i]['Ativo_Funcao'])$funcao[$i]['Ativo_Funcao'] = 'S';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																			if ($funcao[$i]['Ativo_Funcao'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="Ativo_Funcao' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="Ativo_Funcao' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaAtivoFuncao(this.value,this.name,'.$i.',0)" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="Ativo_Funcao' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="Ativo_Funcao' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaAtivoFuncao(this.value,this.name,'.$i.',0)" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
																<!--
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>
																-->
															</div>	
															<div class="row">
																<!--
																<div class="col-md-4">
																	<div id="ConcluidoFuncao<?php echo $i ?>" <?php echo $div['ConcluidoFuncao' . $i]; ?>>
																		<div class="row">	
																			<div class="col-md-6">
																				<label for="DataConcluidoFuncao<?php echo $i ?>">Data Concl</label>
																				<div class="input-group <?php echo $datepicker; ?>">
																					<span class="input-group-addon" disabled>
																						<span class="glyphicon glyphicon-calendar"></span>
																					</span>
																					<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly="" maxlength="10" placeholder="DD/MM/AAAA"
																						   name="DataConcluidoFuncao<?php echo $i ?>" id="DataConcluidoFuncao<?php echo $i ?>" value="<?php echo $funcao[$i]['DataConcluidoFuncao']; ?>">
																				</div>
																			</div>
																			<div class="col-md-6">
																				<label for="HoraConcluidoFuncao<?php echo $i ?>">Hora Concl</label>
																				<div class="input-group <?php echo $timepicker; ?>">
																					<span class="input-group-addon" disabled>
																						<span class="glyphicon glyphicon-time"></span>
																					</span>
																					<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																						   name="HoraConcluidoFuncao<?php echo $i ?>" id="HoraConcluidoFuncao<?php echo $i ?>" value="<?php echo $funcao[$i]['HoraConcluidoFuncao']; ?>">
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																-->
															</div>
														</div>	
													</div>		
												</div>

												<?php
												}
												?>

												</div>

												<div class="row">
													<div class="col-md-4">
														<a class="btn btn-xs btn-warning" onclick="adicionaFuncao()">
															<span class="glyphicon glyphicon-plus"></span> Adicionar Função
														</a>
													</div>
												</div>
											</div>
										
									</div>
								</div>									
								
								<div class="form-group">
									<div class="row">
										<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
										<!--<input type="hidden" name="idSis_Empresa" value="<?php #echo $query['idSis_Empresa']; ?>">-->
										<div class="col-md-6">
											<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
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
<?php } ?>