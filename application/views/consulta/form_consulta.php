<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Cliente & Contatos:</label>
									<div class="form-group">
										<div class="row">	
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>				
											<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
										</div>
									</div>	
								</div>

								<div class="col-md-4 text-center">
									<label for="">Consultas:</label>
									<div class="form-group">
										<div class="row">
											<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-list-alt"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>	
									</div>	
								</div>

								<div class="col-md-4 text-right">
									<label for="">Orçamentos:</label>
									<div class="form-group ">
										<div class="row">
											<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-list-alt"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>		
									</div>	
								</div>
							</div>	
						</div>	
					</div>
					<!--		
					<div class="form-group">		
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<div class="row">
						
						<div class="col-md-12 col-lg-12">
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong></strong></div>
								<div class="panel-body">

									<?php echo form_open_multipart($form_open_path); ?>

									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="Data">Data: *</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="Data" value="<?php echo $query['Data']; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
											<div class="col-md-7 form-inline">
												<div class="form-group">
													<label for="Hora">Hora: *</label><br>
													De
													<div class="col-md-4 input-group <?php echo $timepicker; ?>">
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
															   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
													</div>

													Até
													<div class="col-md-4 input-group <?php echo $timepicker; ?>">
														<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
															   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
												</div>
											</div>


										</div>

									</div>

									<hr>

									<div class="form-group">
										<div class="row">					
											<div class="col-md-10 form-inline">
												<label for="idTab_Status">Status:</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
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
									<!--
									<div class="form-group">
										<div class="row">								
											<div class="col-md-4">
												<label for="idApp_Profissional">Profissional: *</label>
												<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
													<span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
												</a>
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="idApp_Profissional" name="idApp_Profissional">
													<option value="">-- Selecione um Profissional --</option>
													<?php
													foreach ($select['Profissional'] as $key => $row) {
														if ($query['idApp_Profissional'] == $key) {
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
										
									
									<hr>				
									-->
									<hr>

									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="idTab_TipoConsulta">Tipo de Consulta:</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
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
											<div class="col-md-4">
												<label for="Obs">Obs:</label>
												<textarea class="form-control" id="Obs"
														  name="Obs"><?php echo $query['Obs']; ?></textarea>
											</div>
										</div>
									</div>


									<hr>
									<!--<br>-->

									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
											<input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">
											<input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
											<?php if ($metodo == 2) { ?>

												<div class="col-md-6">
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
												<div class="col-md-6 text-right">
													<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
																	<button type="button" class="btn btn-warning" data-dismiss="modal">
																		<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																	</button>
																</div>
																<div class="col-md-6 text-right">
																	<a class="btn btn-danger" href="<?php echo base_url() . 'consulta/excluir/' . $query['idApp_Consulta'] ?>" role="button">
																		<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>

											<?php } else { ?>
												<div class="col-md-6">
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
											<?php } ?>
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
		<div class="col-md-2"></div>
	</div>	
</div>
	<?php } ?>

