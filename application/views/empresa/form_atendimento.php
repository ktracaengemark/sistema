<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php echo validation_errors(); ?>
						<?php echo form_open_multipart($form_open_path); ?>
						<div class="panel panel-<?php echo $panel; ?>">
							<div class="panel-heading">
									<?php echo $titulo; ?>
							</div>			
							<div class="panel-body">				
								<div class="panel panel-info">
									<div class="panel-heading">	
										<!--App_Atendimento-->
										<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>
										<?php
										for ($i=1; $i <= $count['PRCount']; $i++) {
										?>
											<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idApp_Atendimento<?php echo $i ?>" value="<?php echo $atendimento[$i]['idApp_Atendimento']; ?>"/>
											<?php } ?>
											<div class="form-group" id="21div<?php echo $i ?>">
												<div class="panel panel-warning">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-4">
																<div class="row">
																	<div class="col-md-3">
																		<label for="id_Dia">Dia:</label><br>
																		<div class="form-group" >
																			<input type="text" class="form-control " readonly="" id="id_Dia<?php echo $i ?>"
																				   name="id_Dia<?php echo $i ?>" value="<?php echo $atendimento[$i]['id_Dia'] ?>">
																		</div>
																	</div>
																	<div class="col-md-6">
																		<label for="Dia_Semana">Dia da Semana:</label><br>
																		<div class="form-group" >
																			<input type="text" class="form-control " readonly="" id="Dia_Semana<?php echo $i ?>"
																				   name="Dia_Semana<?php echo $i ?>" value="<?php echo $atendimento[$i]['Dia_Semana'] ?>">
																		</div>
																	</div>
																</div>
															</div>	
															<div class="col-md-8">
																<div class="form-group">
																	<div class="row">
																		<div class="col-md-3">
																			<label for="Aberto_Atend">Balcao_Aberto?</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['Aberto_Atend'] as $key => $row) {
																					(!$atendimento[$i]['Aberto_Atend']) ? $atendimento[$i]['Aberto_Atend'] = 'S' : FALSE;
																					if ($atendimento[$i]['Aberto_Atend'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_Aberto_Atend' . $i . '" id="radiobutton_Aberto_Atend' . $i .  $key . '">'
																						. '<input type="radio" name="Aberto_Atend' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_Aberto_Atend' . $i . '" id="radiobutton_Aberto_Atend' . $i .  $key . '">'
																						. '<input type="radio" name="Aberto_Atend' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																		<div class="col-md-4">
																			<label for="Hora">Balcao Abre dàs:</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																					   accept="" name="Hora_Abre_Atend<?php echo $i ?>" id="Hora_Abre_Atend<?php echo $i ?>" value="<?php echo $atendimento[$i]['Hora_Abre_Atend']; ?>">
																			</div>
																			<?php echo form_error('Hora_Abre_Atend'); ?>
																		</div>
																		<div class="col-md-4">
																			<label for="Hora"> Até às:</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																					   accept="" name="Hora_Fecha_Atend<?php echo $i ?>" id="Hora_Fecha_Atend<?php echo $i ?>" value="<?php echo $atendimento[$i]['Hora_Fecha_Atend']; ?>">
																			</div>
																			<?php echo form_error('Hora_Fecha_Atend'); ?>
																		</div>
																	</div>
																</div>
																<div class="form-group">	
																	<div class="row">
																		<div class="col-md-3">
																			<label for="Aberto">Site_Aberto?</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['Aberto'] as $key => $row) {
																					(!$atendimento[$i]['Aberto']) ? $atendimento[$i]['Aberto'] = 'S' : FALSE;
																					if ($atendimento[$i]['Aberto'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_Aberto' . $i . '" id="radiobutton_Aberto' . $i .  $key . '">'
																						. '<input type="radio" name="Aberto' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_Aberto' . $i . '" id="radiobutton_Aberto' . $i .  $key . '">'
																						. '<input type="radio" name="Aberto' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																		<div class="col-md-4">
																			<label for="Hora">Site Abre dàs:</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																					   accept="" name="Hora_Abre<?php echo $i ?>" id="Hora_Abre<?php echo $i ?>" value="<?php echo $atendimento[$i]['Hora_Abre']; ?>">
																			</div>
																			<?php echo form_error('Hora_Abre'); ?>
																		</div>
																		<div class="col-md-4">
																			<label for="Hora">Até às:</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																					   accept="" name="Hora_Fecha<?php echo $i ?>" id="Hora_Fecha<?php echo $i ?>" value="<?php echo $atendimento[$i]['Hora_Fecha']; ?>">
																			</div>
																			<?php echo form_error('Hora_Fecha'); ?>
																		</div>
																	</div>
																</div>	
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php
										}
										?>
										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-primary">
													<div class="panel-heading">
														<div class="btn-group">
															<button class="btn btn-sm btn-default" id="inputDb" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>
								<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>">
							</div>	
						</div>
						</form>
					</div>
				</div>
			</div>					
		</div>
	</div>
<?php } ?>	
