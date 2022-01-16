<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<label class="sr-only" for="idApp_Agenda">Agenda do Profis.:*</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
											id="idApp_Agenda" name="idApp_Agenda">
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
							</div>
							<br>
							<div class="row">	
								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
													<label for="Obs">Evento:</label>
													<textarea class="form-control" id="Obs" name="Obs" rows="1"><?php echo $query['Obs']; ?></textarea>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-11 col-sm-7 col-md-7 col-lg-6">	
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
												<div class="col-xs-12 col-sm-5 col-md-5 col-lg-6">
													<label for="Hora">Dàs :</label>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
															   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>" onchange="dataehora('null', this.value)" onkeyup="dataehora('null', this.value)" >
													
													<?php echo form_error('HoraInicio'); ?>
												</div>
											</div>
											<div class="row">											
												<div class="col-xs-11 col-sm-7 col-md-7 col-lg-6">	
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
												<div class="col-xs-12 col-sm-5 col-md-5 col-lg-6">		
													<label for="Hora">Às :</label>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
															   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
													
												<?php echo form_error('HoraFim'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-left">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-12 text-left">
													<label for="idTab_Status">Status:</label><br>
													<div class="btn-block" data-toggle="buttons">
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
											<?php if ($metodo == 1) { ?>
												<div class="row text-left">
													<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
														<label for="Repetir">Repetir?</label><br>
														<div class="btn-larg-right btn-group" data-toggle="buttons">
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
													</div>
													<div class="text-left" id="Repetir" <?php echo $div['Repetir']; ?>>
															<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">	
																<label for="Recorrencias">Vez(es)</label>
																	<input type="text" class="form-control" name="Recorrencias" id="Recorrencias" value="<?php echo $query['Recorrencias']; ?>" onkeyup="ocorrencias()">
																<?php echo form_error('Recorrencias'); ?>	
															</div>	
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																<div class="row">
																	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
																		<label for="Intervalo">A cada:</label><br>
																		<input type="text" class="form-control Numero" id="Intervalo" maxlength="3" placeholder="Ex'5'dias"
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
																		<input type="text" class="form-control Numero" id="Periodo" maxlength="3" placeholder="Ex'30'dias"
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
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
																<label for="DataMinima">Próxima: </label>
																	<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataMinima" id="DataMinima" value="<?php echo $cadastrar['DataMinima']; ?>" >
																<?php echo form_error('DataMinima'); ?>	
															</div>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
																<label for="DataTermino">Última: </label>
																	<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataTermino" id="DataTermino" value="<?php echo $query['DataTermino']; ?>" >
																<?php echo form_error('DataTermino'); ?>	
															</div>
														
														<?php echo form_error('Repetir'); ?>
													</div>
												</div>
											<?php } else { ?>
												<div class="row text-left">	
													<div class="col-xs-5 col-sm-6 col-md-6 col-lg-3">
														<label>Vez(es)</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['Recorrencia']; ?>">
													</div>	
													<div class="col-xs-7 col-sm-6 col-md-6 col-lg-4">
														<label>Término</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Consulta']['DataTermino']; ?>">
													</div>
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
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
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
									<div class="row">
										<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
										<?php } ?>
										<!--<input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">-->
										<input type="hidden" name="Evento" value="1">
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>	
											<?php if ($metodo == 2) { ?>
												<div class="col-md-12">
													<div class="col-md-12 btn-block">
														<span class="input-group-btn">
															<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																<span class="glyphicon glyphicon-save"></span>Save
															</button>
														</span>
														<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
															<span class="input-group-btn">
																<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="quais(),DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																	<span class="glyphicon glyphicon-trash"></span>Exc
																</button>
															</span>
														<?php }else{ ?>	
															<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>
																<span class="input-group-btn">
																	<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="quais(),DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																		<span class="glyphicon glyphicon-trash"></span>Exc
																	</button>
																</span>
															<?php } ?>	
														<?php } ?>	
													</div>
													<div class="col-md-12 alert alert-warning aguardar" role="alert" >
														Aguarde um instante! Estamos processando sua solicitação!
													</div>
												</div>
											<?php } else { ?>
												<div class="col-md-12">
													<button type="submit" class="btn btn-lg btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>	
													<div class="col-md-12 alert alert-warning aguardar" role="alert" >
														Aguarde um instante! Estamos processando sua solicitação!
													</div>
												</div>
											<?php } ?>
										<?php } ?>
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
		<form method="POST" action="../excluir_evento/<?php echo $query['idApp_Consulta'];?>">
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
					</div>	
					<div class="row">
						<div class="col-md-6 text-left">
							<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotaoExcluir()" data-dismiss="modal">
								<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
							</button>
						</div>
						<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
							<div class="col-md-6 text-right">
								<button type="submit" class="btn btn-md btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" data-loading-text="Aguarde..." >
									<span class="glyphicon glyphicon-trash"></span> Excluir
								</button>
							</div>	
						<?php }else{ ?>
							<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>	
								<div class="col-md-6 text-right">
									<button type="submit" class="btn btn-md btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" data-loading-text="Aguarde..." >
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>
								</div>	
							<?php } ?>
						<?php } ?>	
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php } ?>