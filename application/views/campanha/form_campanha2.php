<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">			
		<!--
		<div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">												
			<div class="col-md-12 text-center t">
				<label for="">Campanha:</label>
				<div class="row">	
					<a class="btn btn-lg btn-success" href="<?php echo base_url() ?>relatorio/campanha" role="button"> 
						<span class="glyphicon glyphicon-list"></span> Listar
					</a>
					<a class="btn btn-lg btn-info" href="<?php echo base_url() ?>agenda" role="button"> 
						<span class="glyphicon glyphicon-calendar"></span> Agenda
					</a>
				</div>	
			</div>	
		</div>
		-->
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			<?php #echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong></strong>
						<div class="text-left ">											
							<span class="glyphicon glyphicon-pencil"></span> <?php echo $titulo; ?> : <?php echo $campanha['idApp_Campanha'] ?> 
							<!--
							<a class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/campanha" role="button"> 
								<span class="glyphicon glyphicon-list"></span> Listar
							</a>
							-->
							<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>agenda" role="button"> 
								<span class="glyphicon glyphicon-calendar"></span> Agenda
							</a>
						</div>					
				</div>
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

					<!--App_Campanha-->

					<div class="form-group">
						<div class="panel panel-info">
							<div class="panel-heading">	
								<div class="row">
									<div class="col-md-2">
										<label  for="Campanha">Campanha:</label>
										<textarea class="form-control" id="Campanha" <?php echo $readonly; ?> maxlength="40"
												  name="Campanha"><?php echo $campanha['Campanha']; ?></textarea>
									<?php echo form_error('Campanha'); ?>
									</div>									
									<div class="col-md-2">
										<div class="row">
											<div class="col-md-12 " >
												<label for="TipoCampanha">TipoCampanha:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
														id="TipoCampanha" name="TipoCampanha">
													<option value="">- Selecione uma TipoCampanha -</option>	
													<?php
													foreach ($select['TipoCampanha'] as $key => $row) {
														if ($campanha['TipoCampanha'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												
											</div>
										</div>	
										<div class="row">
											<div class="col-md-12 text-left">
												<label class="sr-only" for="Cadastrar">Cadastrar no BD</label>
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
												<?php echo form_error('TipoCampanha'); ?>
											</div>
										</div>	
										<div id="Cadastrar" <?php echo $div['Cadastrar']; ?>>	
											<div class="row">											
												<div class="col-md-12 text-left">
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>categoria2/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span>TipoCampanha
													</a>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12 text-left">
													<button class="btn btn-md btn-primary"  id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-refresh"></span>Ref.
													</button>
													<?php echo form_error('Cadastrar'); ?>
												</div>											
											</div>
										</div>	
									</div>									
									<!--
									<div class="col-md-2">
										<label for="Campanha">Campanha:</label>
										<input type="text" class="form-control" id="Campanha" <?php echo $readonly; ?> maxlength="20"
											autofocus name="Campanha" value="<?php echo $campanha['Campanha'] ?>">
									
									</div>								
									
									<div class="col-md-3">
										<label for="ProfissionalCampanha">Responsável da Campanha:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="ProfissionalCampanha" name="ProfissionalCampanha">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['Profissional'] as $key => $row) {
												if ($campanha['ProfissionalCampanha'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									-->
									<div class="col-md-2 ">
										<label for="Prioridade">Prioridade:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="Prioridade" name="Prioridade">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['Prioridade'] as $key => $row) {
												if ($campanha['Prioridade'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
										<?php echo form_error('Prioridade'); ?>
									</div>
									<div class="col-md-4" >
										<div class="form-group">
											<div class="row">
												<div class="col-md-6 text-left">
													<label for="DataCampanha">Iniciar em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataCampanha" value="<?php echo $campanha['DataCampanha']; ?>">
														
													</div>
													<?php echo form_error('DataCampanha'); ?>
												</div>
												<div class="col-md-6 text-left">
													<label for="DataCampanhaLimite">Concluir em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataCampanhaLimite" value="<?php echo $campanha['DataCampanhaLimite']; ?>">
														
													</div>
													<?php echo form_error('DataCampanhaLimite'); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<label for="Statuscampanha">StatusTRF:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="Statuscampanha" name="Statuscampanha">
											<!--<option value="">-- Selecione uma opção --</option>-->
											<?php
											foreach ($select['Statuscampanha'] as $key => $row) {
												if ($campanha['Statuscampanha'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>									
									<!--
									<div class="col-md-2 form-inline">
										<label for="AtivoCampanha">Campanha Concl.?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['AtivoCampanha'] as $key => $row) {
													if (!$campanha['AtivoCampanha'])
														$campanha['AtivoCampanha'] = 'N';

													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

													if ($campanha['AtivoCampanha'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="AtivoCampanha_' . $hideshow . '">'
														. '<input type="radio" name="AtivoCampanha" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="AtivoCampanha_' . $hideshow . '">'
														. '<input type="radio" name="AtivoCampanha" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>

											</div>
										</div>
									</div>
									-->
									<!--
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
									<div class="col-md-3 " >
										<label for="Compartilhar">Compartilhar:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
												id="Compartilhar" name="Compartilhar">
												
											<?php
											foreach ($select['Compartilhar'] as $key => $row) {
												if ($campanha['Compartilhar'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<?php } ?>
									-->
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

									<?php if ($metodo > 1) { ?>
									<input type="hidden" name="idApp_SubCampanha<?php echo $i ?>" value="<?php echo $procedcampanha[$i]['idApp_SubCampanha']; ?>"/>
									<?php } ?>

									<div class="form-group" id="3div<?php echo $i ?>">
										<div class="panel panel-info">
											<div class="panel-heading">			
												<div class="row">																					
													<!--
													<div class="col-md-3">
														<label for="Profissional<?php echo $i ?>">Profissional:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma opção..." class="form-control"
																 id="listadinamicac<?php echo $i ?>" name="Profissional<?php echo $i ?>">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['Profissional'] as $key => $row) {
																if ($procedcampanha[$i]['Profissional'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													-->
													<div class="col-md-3">
														<label for="SubCampanha<?php echo $i ?>">Ação:</label>
														<textarea class="form-control" id="SubCampanha<?php echo $i ?>" <?php echo $readonly; ?>
																  name="SubCampanha<?php echo $i ?>"><?php echo $procedcampanha[$i]['SubCampanha']; ?></textarea>
													</div>
													<div class="col-md-2">
														<label for="Prioridade<?php echo $i ?>">Prioridade:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma opção..." class="form-control" 
																 id="listadinamicad<?php echo $i ?>" name="Prioridade<?php echo $i ?>">
															
															<?php
															foreach ($select['Prioridade'] as $key => $row) {
																if ($procedcampanha[$i]['Prioridade'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-2">
														<label for="DataSubCampanha<?php echo $i ?>">Iniciar em:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>															
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataSubCampanha<?php echo $i ?>" value="<?php echo $procedcampanha[$i]['DataSubCampanha']; ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="DataSubCampanhaLimite<?php echo $i ?>">Concluir em:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>															
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataSubCampanhaLimite<?php echo $i ?>" value="<?php echo $procedcampanha[$i]['DataSubCampanhaLimite']; ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="Statussubcampanha<?php echo $i ?>">StatusAção:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma opção..." class="form-control" 
																 id="listadinamicad<?php echo $i ?>" name="Statussubcampanha<?php echo $i ?>">
															
															<?php
															foreach ($select['Statussubcampanha'] as $key => $row) {
																if ($procedcampanha[$i]['Statussubcampanha'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>													
													<!--
													<div class="col-md-2">
														<label for="ConcluidoSubCampanha">Ação. Concl.? </label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['ConcluidoSubCampanha'] as $key => $row) {
																	(!$procedcampanha[$i]['ConcluidoSubCampanha']) ? $procedcampanha[$i]['ConcluidoSubCampanha'] = 'N' : FALSE;

																	if ($procedcampanha[$i]['ConcluidoSubCampanha'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_ConcluidoSubCampanha' . $i . '" id="radiobutton_ConcluidoSubCampanha' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoSubCampanha' . $i . '" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_ConcluidoSubCampanha' . $i . '" id="radiobutton_ConcluidoSubCampanha' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoSubCampanha' . $i . '" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
													</div>
													-->
													<div class="col-md-1">
														<label><br></label><br>
														<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
															<span class="glyphicon glyphicon-trash"></span>
														</button>
													</div>
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
											<a class="btn btn-xs btn-warning" onclick="adicionaSubCampanha()">
												<span class="glyphicon glyphicon-plus"></span> Adicionar Ação
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
							
							<div class="col-md-2 text-left">
								<label for="Rotina">Rotina?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['Rotina'] as $key => $row) {
											(!$campanha['Rotina']) ? $campanha['Rotina'] = 'N' : FALSE;

											if ($campanha['Rotina'] == $key) {
												echo ''
												. '<label class="btn btn-warning active" name="radiobutton_Rotina" id="radiobutton_Rotina' . $key . '">'
												. '<input type="radio" name="Rotina" id="radiobutton" '
												. 'autocomplete="off" value="' . $key . '" checked>' . $row
												. '</label>'
												;
											} else {
												echo ''
												. '<label class="btn btn-default" name="radiobutton_Rotina" id="radiobutton_Rotina' . $key . '">'
												. '<input type="radio" name="Rotina" id="radiobutton" '
												. 'autocomplete="off" value="' . $key . '" >' . $row
												. '</label>'
												;
											}
										}
										?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div id="AtivoCampanha" <?php echo $div['AtivoCampanha']; ?>>																								
									<div class="col-md-3">
										<label for="DataConclusao">Data da Conclusão:</label>
										<div class="input-group <?php echo $datepicker; ?>">
											<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
												   name="DataConclusao" value="<?php echo $campanha['DataConclusao']; ?>">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataRetorno">Data do Retorno:</label>
										<div class="input-group <?php echo $datepicker; ?>">
											<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
												   name="DataRetorno" value="<?php echo $campanha['DataRetorno']; ?>">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>   													
							</div>
							
						</div>					
					</div>
					-->
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
					<div class="row">
						<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
						<input type="hidden" name="idApp_Campanha" value="<?php echo $campanha['idApp_Campanha']; ?>">
						<?php if ($metodo > 1) { ?>
						<!--<input type="hidden" name="idApp_SubCampanha" value="<?php echo $procedcampanha['idApp_SubCampanha']; ?>">
						<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
						<?php } ?>
						<?php if ($metodo == 2) { ?>
							<!--
							<div class="col-md-12 text-center">
								<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
									<span class="glyphicon glyphicon-trash"></span> Excluir
								</button>
								<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
											return true;">
									<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
								</button>
							</div>
							<button type="button" class="btn btn-danger">
								<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
							</button>                        -->

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
											<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
										</div>
										<div class="modal-footer">
											<div class="col-md-6 text-left">
												<button type="button" class="btn btn-warning" data-dismiss="modal">
													<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
												</button>
											</div>
											<div class="col-md-6 text-right">
												<a class="btn btn-danger" href="<?php echo base_url() . 'campanha/excluir2/' . $campanha['idApp_Campanha'] ?>" role="button">
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
					<?php } ?>

					</form>

				</div>

			</div>

		</div>
		<div class="col-md-2"></div>
	</div>
</div>	