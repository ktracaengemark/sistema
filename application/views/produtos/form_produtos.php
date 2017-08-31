<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">			
		<!--
		<div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">												
			<div class="col-md-12 text-center t">
				<label for="">Tarefa:</label>
				<div class="row">	
					<a class="btn btn-lg btn-success" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
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
			<?php echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong></strong>
						<div class="text-left ">											
							<span class="glyphicon glyphicon-pencil"></span> Tarefa 
							<a class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
								<span class="glyphicon glyphicon-list"></span> Listar
							</a>
							<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>agenda" role="button"> 
								<span class="glyphicon glyphicon-calendar"></span> Agenda
							</a>
						</div>					
				</div>
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

					<!--App_Tarefa-->

					<div class="form-group">
						<div class="panel panel-info">
							<div class="panel-heading">	
								<div class="row">
									<div class="col-md-4">
										<label for="ObsTarefa">Nova Tarefa/ Missão:</label>
										<textarea class="form-control" id="ObsTarefa" <?php echo $readonly; ?>
											autofocus name="ObsTarefa"><?php echo $tarefa['ObsTarefa']; ?></textarea>
									</div>								
									<!--
									<div class="col-md-3">
										<label for="ProfissionalTarefa">Responsável da Tarefa:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="ProfissionalTarefa" name="ProfissionalTarefa">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['Profissional'] as $key => $row) {
												if ($tarefa['ProfissionalTarefa'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									-->
									<div class="col-md-8" >
										<div class="form-group">
											<div class="row">
												<div class="col-md-4 text-left">
													<label for="DataTarefa">Criada em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataTarefa" value="<?php echo $tarefa['DataTarefa']; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
												<div class="col-md-4 text-left">
													<label for="DataPrazoTarefa">Prazo de Concl.:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataPrazoTarefa" value="<?php echo $tarefa['DataPrazoTarefa']; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div>	
						</div>		
					</div>

						<hr>
						
					
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

							<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">

									<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

									<div class="input_fields_wrap3">

									<?php
									for ($i=1; $i <= $count['PTCount']; $i++) {
									?>

									<?php if ($metodo > 1) { ?>
									<input type="hidden" name="idApp_Procedtarefa<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_Procedtarefa']; ?>"/>
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
																if ($procedtarefa[$i]['Profissional'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													-->
													<div class="col-md-4">
														<label for="Procedtarefa<?php echo $i ?>">Ação:</label>
														<textarea class="form-control" id="Procedtarefa<?php echo $i ?>" <?php echo $readonly; ?>
																  name="Procedtarefa<?php echo $i ?>"><?php echo $procedtarefa[$i]['Procedtarefa']; ?></textarea>
													</div>
													<div class="col-md-3">
														<label for="DataProcedtarefa<?php echo $i ?>">Data da Ação:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataProcedtarefa<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataProcedtarefa']; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
														</div>
													</div>
													<div class="col-md-3">
														<label for="ConcluidoProcedtarefa">Ação. Concl.? </label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['ConcluidoProcedtarefa'] as $key => $row) {
																	(!$procedtarefa[$i]['ConcluidoProcedtarefa']) ? $procedtarefa[$i]['ConcluidoProcedtarefa'] = 'N' : FALSE;

																	if ($procedtarefa[$i]['ConcluidoProcedtarefa'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedtarefa' . $i . '" id="radiobutton_ConcluidoProcedtarefa' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoProcedtarefa' . $i . '" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedtarefa' . $i . '" id="radiobutton_ConcluidoProcedtarefa' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoProcedtarefa' . $i . '" id="radiobuttondinamico" '
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

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<a class="add_field_button3 btn btn-xs btn-warning" onclick="adicionaProcedtarefa()">
													<span class="glyphicon glyphicon-plus"></span> Adicionar Ação
												</a>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<div class="col-md-2 text-left">
								<label for="Rotina">Rotina?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['Rotina'] as $key => $row) {
											(!$tarefa['Rotina']) ? $tarefa['Rotina'] = 'N' : FALSE;

											if ($tarefa['Rotina'] == $key) {
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
							<div class="col-md-2 text-left" >
								<label for="Prioridade">Prioridade?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['Prioridade'] as $key => $row) {
											(!$tarefa['Prioridade']) ? $tarefa['Prioridade'] = 'N' : FALSE;

											if ($tarefa['Prioridade'] == $key) {
												echo ''
												. '<label class="btn btn-warning active" name="radiobutton_Prioridade" id="radiobutton_Prioridade' . $key . '">'
												. '<input type="radio" name="Prioridade" id="radiobutton" '
												. 'autocomplete="off" value="' . $key . '" checked>' . $row
												. '</label>'
												;
											} else {
												echo ''
												. '<label class="btn btn-default" name="radiobutton_Prioridade" id="radiobutton_Prioridade' . $key . '">'
												. '<input type="radio" name="Prioridade" id="radiobutton" '
												. 'autocomplete="off" value="' . $key . '" >' . $row
												. '</label>'
												;
											}
										}
										?>
									</div>
								</div>
							</div>
							<div class="col-md-2 form-inline">
								<label for="TarefaConcluida">Tarefa Concl.?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['TarefaConcluida'] as $key => $row) {
											if (!$tarefa['TarefaConcluida'])
												$tarefa['TarefaConcluida'] = 'N';

											($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

											if ($tarefa['TarefaConcluida'] == $key) {
												echo ''
												. '<label class="btn btn-warning active" name="TarefaConcluida_' . $hideshow . '">'
												. '<input type="radio" name="TarefaConcluida" id="' . $hideshow . '" '
												. 'autocomplete="off" value="' . $key . '" checked>' . $row
												. '</label>'
												;
											} else {
												echo ''
												. '<label class="btn btn-default" name="TarefaConcluida_' . $hideshow . '">'
												. '<input type="radio" name="TarefaConcluida" id="' . $hideshow . '" '
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
								<div id="TarefaConcluida" <?php echo $div['TarefaConcluida']; ?>>																								
									<div class="col-md-3">
										<label for="DataConclusao">Data da Conclusão:</label>
										<div class="input-group <?php echo $datepicker; ?>">
											<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
												   name="DataConclusao" value="<?php echo $tarefa['DataConclusao']; ?>">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataRetorno">Data do Retorno:</label>
										<div class="input-group <?php echo $datepicker; ?>">
											<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
												   name="DataRetorno" value="<?php echo $tarefa['DataRetorno']; ?>">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>   													
							</div>
						</div>					
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
							<input type="hidden" name="idApp_Tarefa" value="<?php echo $tarefa['idApp_Tarefa']; ?>">
							<?php if ($metodo > 1) { ?>
							<!--<input type="hidden" name="idApp_Procedtarefa" value="<?php echo $procedtarefa['idApp_Procedtarefa']; ?>">
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
													<a class="btn btn-danger" href="<?php echo base_url() . 'tarefa/excluir/' . $tarefa['idApp_Tarefa'] ?>" role="button">
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
		<div class="col-md-2"></div>
	</div>
</div>	