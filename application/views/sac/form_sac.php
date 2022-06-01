<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong><?php echo $titulo; ?> </strong><?php echo $_SESSION['Cliente']['NomeCliente']; ?> - <?php echo $_SESSION['Cliente']['idApp_Cliente']; ?></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>
							<!--App_Sac-->
							<div class="panel-group">	
								<div class="panel panel-<?php echo $panel2; ?>">
									<div class="panel-heading">
										<div class="row text-left">
											<div class="col-md-3 " >
												<label for="<?php echo $titulo; ?>">
												<?php echo $titulo; ?> Nº 
												<?php 
													if ($metodo !=1 && $metodo !=3) {
															echo $orcatrata['idApp_Sac']; 
													}
												?> - Tipo:
												</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Categoria<?php echo $titulo; ?>" name="Categoria<?php echo $titulo; ?>">
													<option value="">- Selec. Tipo <?php echo $titulo; ?> -</option>	
													<?php
													foreach ($select['Categoria'.$titulo] as $key => $row) {
														if ($orcatrata['Categoria'.$titulo] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('Categoria'.$titulo); ?>
											</div>
											
											<div class="col-md-6">
												<input type="hidden" name="idSis_Usuario" id="idSis_Usuario" value="<?php echo $orcatrata['idSis_Usuario']; ?>"/>
												<?php 
													if ($metodo == 1 || $metodo == 3) { 
														$nomecadatrou = $_SESSION['log']['Nome'];
													}elseif(isset($orcatrata['idSis_Usuario']) && ($metodo == 2 || $metodo == 4)){
														$nomecadatrou = $_SESSION['Orcatrata']['NomeCadastrou'];
													}else{
														$nomecadatrou = false;
													}
												?>
												<label for="Sac">Relato do Cliente - Cacastrado por : <?php echo $nomecadatrou; ?></label>
												<textarea class="form-control" name="Sac" id="Sac" <?php echo $readproc; ?>><?php echo $orcatrata['Sac']; ?></textarea>
												<?php echo form_error('Sac'); ?>		  
											</div>
											
											<!--
											<?php if ($metodo == 1) { ?>
												<div class="col-md-3">
													<label for="Compartilhar">Quem Fazer?</label>		
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Compartilhar" name="Compartilhar">
														<option value="">- Selec. Quem Fazer-</option>	
														<?php
														/*
														foreach ($select['Compartilhar'] as $key => $row) {
															if ($orcatrata['Compartilhar'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														*/
														?>
													</select>
												</div>
											<?php } elseif ($metodo == 2){ ?>
												<div class="col-md-3">
													<input type="hidden" name="Compartilhar" id="Compartilhar" value="<?php echo $orcatrata['Compartilhar']; ?>"/>
													<label for="Compartilhar">Quem Fazer</label>
													<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Orcatrata']['NomeCompartilhar']; ?>"/>
												</div>
											<?php } ?>
											-->
											
											<div class="col-md-3">
												<label for="Compartilhar">Quem Fazer?</label>		
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Compartilhar" name="Compartilhar">
													<option value="">- Selec. Quem Fazer-</option>	
													<?php
													foreach ($select['Compartilhar'] as $key => $row) {
														if ($orcatrata['Compartilhar'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('Compartilhar'); ?>
											</div>	
										</div>	
										<div class="row">		
											<div class="col-md-3">
												<label for="DataSac">Cadastrado em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly=""
															name="DataSac" id="DataSac" value="<?php echo $orcatrata['DataSac']; ?>">
												</div>
											</div>		
											<div class="col-md-2">
												<label for="HoraSac">ÀS:</label>
												<div class="input-group <?php echo $timepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-time"></span>
													</span>
													<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
															name="HoraSac" id="HoraSac" value="<?php echo $orcatrata['HoraSac']; ?>">
												</div>
											</div>
											<div class="col-md-2 text-left">
												<label for="ConcluidoSac">Concluído?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ConcluidoSac'] as $key => $row) {
														if (!$orcatrata['ConcluidoSac'])$orcatrata['ConcluidoSac'] = 'N';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($orcatrata['ConcluidoSac'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="ConcluidoSac_' . $hideshow . '">'
															. '<input type="radio" name="ConcluidoSac" id="' . $hideshow . '" '
															. 'onchange="carregaConcluidoSac(this.value,this.name,0)" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="ConcluidoSac_' . $hideshow . '">'
															. '<input type="radio" name="ConcluidoSac" id="' . $hideshow . '" '
															. 'onchange="carregaConcluidoSac(this.value,this.name,0)" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
											<div id="ConcluidoSac" <?php echo $div['ConcluidoSac']; ?>>
												<div class="col-md-3">
													<label for="DataConcluidoSac">Concluído em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=""
																name="DataConcluidoSac" id="DataConcluidoSac" value="<?php echo $orcatrata['DataConcluidoSac']; ?>">
													</div>
													<?php echo form_error('DataConcluidoSac'); ?>
												</div>		
												<div class="col-md-2">
													<label for="HoraConcluidoSac">ÀS:</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
																name="HoraConcluidoSac" id="HoraConcluidoSac" value="<?php echo $orcatrata['HoraConcluidoSac']; ?>">
													</div>
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
												Ações
											</a>
										</h4>
									</div>

									<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
										<div class="panel-body">

											<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

											<div class="input_fields_wrap3">

											<?php
											for ($i=1; $i <= $count['PTCount']; $i++) {
											?>

											<?php if ($metodo == 2 || $metodo == 4) { ?>
											<!--<input type="hidden" name="idApp_SubSac<?php echo $i ?>" id="idApp_SubSac<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_SubSac']; ?>"/>-->
											<?php } ?>

											<div class="form-group" id="3div<?php echo $i ?>">
												<div class="panel panel-info">
													<div class="panel-heading">			
														<div class="row">
															<input type="hidden" name="idSis_Usuario<?php echo $i ?>" id="idSis_Usuario<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idSis_Usuario']; ?>"/>
															<div class="col-md-6">
																<label for="SubSac<?php echo $i ?>">
																	Ação <?php echo $i ?>: 
																	<?php if ($procedtarefa[$i]['idSis_Usuario']) { ?>
																		<?php echo $_SESSION['Procedtarefa'][$i]['NomeCadastrou'];?>
																	<?php } ?>
																</label>
																<textarea class="form-control" id="SubSac<?php echo $i ?>" <?php echo $readonly; ?> readonly=""
																		  name="SubSac<?php echo $i ?>"><?php echo $procedtarefa[$i]['SubSac']; ?></textarea>
															</div>
														</div>	
														<div class="row">
															<div class="col-md-2">
																<label for="DataSubSac<?php echo $i ?>">Cadastrado em:</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>															
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly=""
																		   name="DataSubSac<?php echo $i ?>" id="DataSubSac<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubSac']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="HoraSubSac<?php echo $i ?>">Às</label>
																<div class="input-group <?php echo $timepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-time"></span>
																	</span>
																	<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																		   name="HoraSubSac<?php echo $i ?>" id="HoraSubSac<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['HoraSubSac']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="ConcluidoSubSac">Concluído? </label><br>
																<div class="form-group">
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['ConcluidoSubSac'] as $key => $row) {
																			if (!$procedtarefa[$i]['ConcluidoSubSac'])$procedtarefa[$i]['ConcluidoSubSac'] = 'N';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																			if ($procedtarefa[$i]['ConcluidoSubSac'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="ConcluidoSubSac' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="ConcluidoSubSac' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaConclSubSac(this.value,this.name,'.$i.',0)" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="ConcluidoSubSac' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="ConcluidoSubSac' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaConclSubSac(this.value,this.name,'.$i.',0)" '
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
																<div id="ConcluidoSubSac<?php echo $i ?>" <?php echo $div['ConcluidoSubSac' . $i]; ?>>
																	<div class="row">	
																		<div class="col-md-6">
																			<label for="DataConcluidoSubSac<?php echo $i ?>">Data Concl</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly="" maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataConcluidoSubSac<?php echo $i ?>" id="DataConcluidoSubSac<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataConcluidoSubSac']; ?>">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<label for="HoraConcluidoSubSac<?php echo $i ?>">Hora Concl</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																					   name="HoraConcluidoSubSac<?php echo $i ?>" id="HoraConcluidoSubSac<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['HoraConcluidoSubSac']; ?>">
																			</div>
																		</div>
																	</div>
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
													</div>	
												</div>		
											</div>

											<?php
											}
											?>

											</div>

											<div class="row">
												<div class="col-md-4">
													<a class="btn btn-xs btn-warning" onclick="adicionaSubSac()">
														<span class="glyphicon glyphicon-plus"></span> Adicionar Ação
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
									
									<?php if ($metodo !=1 && $metodo !=3) { ?>
										
										<input type="hidden" name="idApp_Sac" value="<?php echo $orcatrata['idApp_Sac']; ?>">
										
										<!--<input type="hidden" name="idApp_Sac" value="<?php echo $sac['idApp_Sac']; ?>">
										<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
										
									<?php } ?>
									<?php if ($metodo == 2 || $metodo == 4) { ?>
									
										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<!--
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
															<button type="button" class="btn btn-warning" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" href="<?php echo base_url() . 'sac/excluirproc/' . $orcatrata['idApp_Sac'] ?>" role="button">
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
