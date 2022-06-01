<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">			
		<!--
		<div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">												
			<div class="col-md-12 text-center t">
				<label for="">Procedimento:</label>
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
			<?php #echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong></strong>
						<div class="text-left ">											
							<span class="glyphicon glyphicon-pencil"></span> <?php echo $titulo; ?> : <?php echo $tarefa['idApp_Procedimento'] ?> 
							<!--
							<a class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
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

					<!--App_Procedimento-->

					<div class="form-group">
						<div class="panel panel-info">
							<div class="panel-heading">	
								<div class="row">
									<div class="col-md-2">
										<label  for="Procedimento">Tarefa:</label>
										<textarea class="form-control" id="Procedimento" <?php echo $readonly; ?> maxlength="40"
												  name="Procedimento"><?php echo $tarefa['Procedimento']; ?></textarea>
									<?php echo form_error('Procedimento'); ?>
									</div>									
									<div class="col-md-2">
										<div class="row">
											<div class="col-md-12 " >
												<label for="Categoria">Categoria:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
														id="Categoria" name="Categoria">
													<option value="">- Selecione uma Categoria -</option>	
													<?php
													foreach ($select['Categoria'] as $key => $row) {
														if ($tarefa['Categoria'] == $key) {
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
												<?php echo form_error('Categoria'); ?>
											</div>
										</div>	
										<div id="Cadastrar" <?php echo $div['Cadastrar']; ?>>	
											<div class="row">											
												<div class="col-md-12 text-left">
													<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>categoria2/cadastrar3/" role="button"> 
														<span class="glyphicon glyphicon-plus"></span>Categoria
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
										<label for="Procedimento">Tarefa:</label>
										<input type="text" class="form-control" id="Procedimento" <?php echo $readonly; ?> maxlength="20"
											autofocus name="Procedimento" value="<?php echo $tarefa['Procedimento'] ?>">
									
									</div>								
									
									<div class="col-md-3">
										<label for="ProfissionalProcedimento">Responsável da Procedimento:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="ProfissionalProcedimento" name="ProfissionalProcedimento">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['Profissional'] as $key => $row) {
												if ($tarefa['ProfissionalProcedimento'] == $key) {
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
												if ($tarefa['Prioridade'] == $key) {
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
													<label for="DataProcedimento">Iniciar em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataProcedimento" value="<?php echo $tarefa['DataProcedimento']; ?>">
														
													</div>
													<?php echo form_error('DataProcedimento'); ?>
												</div>
												<div class="col-md-6 text-left">
													<label for="DataProcedimentoLimite">Concluir em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataProcedimentoLimite" value="<?php echo $tarefa['DataProcedimentoLimite']; ?>">
														
													</div>
													<?php echo form_error('DataProcedimentoLimite'); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<label for="Statustarefa">StatusTRF:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="Statustarefa" name="Statustarefa">
											<!--<option value="">-- Selecione uma opção --</option>-->
											<?php
											foreach ($select['Statustarefa'] as $key => $row) {
												if ($tarefa['Statustarefa'] == $key) {
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
										<label for="ConcluidoProcedimento">Tarefa Concl.?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['ConcluidoProcedimento'] as $key => $row) {
													if (!$tarefa['ConcluidoProcedimento'])
														$tarefa['ConcluidoProcedimento'] = 'N';

													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

													if ($tarefa['ConcluidoProcedimento'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="ConcluidoProcedimento_' . $hideshow . '">'
														. '<input type="radio" name="ConcluidoProcedimento" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="ConcluidoProcedimento_' . $hideshow . '">'
														. '<input type="radio" name="ConcluidoProcedimento" id="' . $hideshow . '" '
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
												if ($tarefa['Compartilhar'] == $key) {
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
									<input type="hidden" name="idApp_SubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_SubProcedimento']; ?>"/>
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
													<div class="col-md-3">
														<label for="SubProcedimento<?php echo $i ?>">Ação:</label>
														<textarea class="form-control" id="SubProcedimento<?php echo $i ?>" <?php echo $readonly; ?>
																  name="SubProcedimento<?php echo $i ?>"><?php echo $procedtarefa[$i]['SubProcedimento']; ?></textarea>
													</div>
													<div class="col-md-2">
														<label for="Prioridade<?php echo $i ?>">Prioridade:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma opção..." class="form-control" 
																 id="listadinamicad<?php echo $i ?>" name="Prioridade<?php echo $i ?>">
															
															<?php
															foreach ($select['Prioridade'] as $key => $row) {
																if ($procedtarefa[$i]['Prioridade'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-2">
														<label for="DataSubProcedimento<?php echo $i ?>">Iniciar em:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>															
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubProcedimento']; ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="DataSubProcedimentoLimite<?php echo $i ?>">Concluir em:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>															
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataSubProcedimentoLimite<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubProcedimentoLimite']; ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="Statussubtarefa<?php echo $i ?>">StatusAção:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma opção..." class="form-control" 
																 id="listadinamicad<?php echo $i ?>" name="Statussubtarefa<?php echo $i ?>">
															
															<?php
															foreach ($select['Statussubtarefa'] as $key => $row) {
																if ($procedtarefa[$i]['Statussubtarefa'] == $key) {
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
														<label for="ConcluidoSubProcedimento">Ação. Concl.? </label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
																	(!$procedtarefa[$i]['ConcluidoSubProcedimento']) ? $procedtarefa[$i]['ConcluidoSubProcedimento'] = 'N' : FALSE;

																	if ($procedtarefa[$i]['ConcluidoSubProcedimento'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_ConcluidoSubProcedimento' . $i . '" id="radiobutton_ConcluidoSubProcedimento' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_ConcluidoSubProcedimento' . $i . '" id="radiobutton_ConcluidoSubProcedimento' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="radiobuttondinamico" '
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
											<a class="btn btn-xs btn-warning" onclick="adicionaSubProcedimento()">
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
							<div class="form-group">
								<div id="ConcluidoProcedimento" <?php echo $div['ConcluidoProcedimento']; ?>>																								
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
					-->
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
					<div class="row">
						<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
						<input type="hidden" name="idApp_Procedimento" value="<?php echo $tarefa['idApp_Procedimento']; ?>">
						<?php if ($metodo > 1) { ?>
						<!--<input type="hidden" name="idApp_SubProcedimento" value="<?php echo $procedtarefa['idApp_SubProcedimento']; ?>">
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
												<a class="btn btn-danger" href="<?php echo base_url() . 'tarefa/excluir2/' . $tarefa['idApp_Procedimento'] ?>" role="button">
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