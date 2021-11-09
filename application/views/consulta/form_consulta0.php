<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-3 col-md-6">

			<?php #echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					Agendamento
					<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>agenda" role="button">
						<span class="glyphicon glyphicon-calendar"></span>Agenda
					</a>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="panel panel-info">
							<div class="panel-heading">
							<?php echo form_open_multipart($form_open_path); ?>
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 panel-body">
											<label>Empresa:</label>
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">														
														<div class="col-md-12">
															<?php echo '<strong>' . $_SESSION['Consulta']['NomeEmpresa'] . '</strong>' ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 panel-body">
											<label>Profissional:</label>
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">														
														<div class="col-md-12">
															<?php echo '<strong>' . $_SESSION['Agenda']['Nome'] . '</strong>' ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 panel-body">
											<label  for="idApp_Cliente">Cliente:</label>
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">														
														<div class="col-md-12">
															<?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong>' ?>
														</div>
													</div>
												</div>
											</div>
										</div>										
									</div>
								</div>
								<div class="form-group">
									<div class="row">										
										<div class="col-md-12 form-group text-left">
											<label for="Obs">Obs:</label>
											<textarea class="form-control" id="Obs" readonly=''
													  name="Obs"><?php echo $query['Obs']; ?></textarea>
										</div>
									</div>
								</div>	
								<div class="form-group">
									<div class="row">		
										<div class="col-md-6">	
											<label for="Data">Data Início : </label>												
											<div class="input-group <?php echo $datepicker; ?>">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=''
													   name="Data" value="<?php echo $query['Data']; ?>">
											</div>
											<?php echo form_error('Data'); ?>
										</div>	
										
										<div class="col-md-6">
											<label for="Hora">Dàs :</label>
											<!--<div class="input-group <?php echo $timepicker; ?>">-->
												<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM" readonly=''
													   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
												<!--<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>-->
										<?php echo form_error('HoraInicio'); ?>
										</div>
									</div>
								</div>		
								<div class="form-group">
									<div class="row">		
										<div class="col-md-6">	
											<label for="Data2">Data Fim : </label>												
											<div class="input-group <?php echo $datepicker; ?>">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=''
													   name="Data2" value="<?php echo $query['Data2']; ?>">
											</div>
											<?php echo form_error('Data2'); ?>
										</div>
									
										<div class="col-md-6">		
											<label for="Hora">Às :</label>
											<!--<div class="input-group <?php echo $timepicker; ?>">-->
												<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM" readonly=''
													   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
												<!--<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>-->
										<?php echo form_error('HoraFim'); ?>
										</div>
									</div>
								</div>																						
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 form-inline text-left">
											<label for="idTab_TipoConsulta">Tipo de Consulta:</label><br>
											<div class="form-group">
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
								<div class="form-group">
									<div class="row">		
										<div class="col-md-12 form-inline text-left">
											<label for="idTab_Status">Status:</label><br>
											<div class="form-group">
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
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
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
