<?php if (isset($msg)) echo $msg; ?>

<div class="col-md-1 "></div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 ">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>

			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="input-group col-md-3">
						<h4><?php echo $titulo; ?></h4>
						<span class="input-group-btn">
							<button class="btn btn-primary btn-md" id="inputDb" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-save"></span> Salvar 
							</button>
						</span>
					</div>
				</div>
				<div class="panel-body">

					<div class="panel-group">
						<div  style="overflow: auto; height: 456px; ">
								
							<div class="panel-body">
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
													<div class="col-md-2">
														<label for="id_Dia">Dia:</label><br>
														<div class="form-group" >
															<input type="text" class="form-control " readonly="" id="id_Dia<?php echo $i ?>"
																   name="id_Dia<?php echo $i ?>" value="<?php echo $atendimento[$i]['id_Dia'] ?>">
														</div>
													</div><div class="col-md-2">
														<label for="Dia_Semana">Dia da Semana:</label><br>
														<div class="form-group" >
															<input type="text" class="form-control " readonly="" id="Dia_Semana<?php echo $i ?>"
																   name="Dia_Semana<?php echo $i ?>" value="<?php echo $atendimento[$i]['Dia_Semana'] ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="Aberto">Aberto?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Aberto'] as $key => $row) {
																	(!$atendimento[$i]['Aberto']) ? $atendimento[$i]['Aberto'] = 'N' : FALSE;

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
													</div>
													
													<div class="col-md-2">
														<label for="Hora">Abre às:</label>
														<div class="input-group <?php echo $timepicker; ?>">
															<span class="input-group-addon">
																<span class="glyphicon glyphicon-time"></span>
															</span>
															<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																   accept="" name="Hora_Abre<?php echo $i ?>" id="Hora_Abre<?php echo $i ?>" value="<?php echo $atendimento[$i]['Hora_Abre']; ?>">
														</div>
													<?php echo form_error('Hora_Abre'); ?>
													</div>
													<div class="col-md-2">
														<label for="Hora">Fecha às:</label>
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

								<?php
								}
								?>
							</div>
						</div>									
						
					</div>
					<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
