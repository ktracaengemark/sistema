<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">			
		<!--
		<div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">												
			<div class="col-md-12 text-center t">
				<label for="">Tarefa:</label>
				<div class="row">	
					<a class="btn btn-lg btn-success" href="<?php #echo base_url() ?>relatorio/tarefa" role="button"> 
						<span class="glyphicon glyphicon-list"></span> Listar
					</a>
					<a class="btn btn-lg btn-info" href="<?php #echo base_url() ?>agenda" role="button"> 
						<span class="glyphicon glyphicon-calendar"></span> Agenda
					</a>
				</div>	
			</div>	
		</div>
		-->
		<div class="col-md-1"></div>
		<div class="col-md-10 ">
			<?php #echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong></strong>
						<div class="text-left ">											
							<span class="glyphicon glyphicon-pencil"></span> 
							<?php echo $titulo; ?> : 
							
							<?php 
								if ($metodo > 1) { 
									echo $tarefa['idApp_Tarefa'];
								}
							?> 
							<!--
							<a class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
								<span class="glyphicon glyphicon-list"></span> Listar
							</a>
							-->
							<a class="btn btn-md btn-success" href="<?php echo base_url() ?>tarefa" role="button"> 
								<span class="glyphicon glyphicon-calendar"></span> Tarefas
							</a>
						</div>					
				</div>
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

					<!--App_Tarefa-->
					<div class="form-group">
						<div class="panel panel-success">
							<div class="panel-heading">	
								<div class="row">
									<div class="col-md-4">
										<label  for="Tarefa">Tarefa:</label>
										<textarea class="form-control" id="Tarefa" <?php echo $readonly; ?> maxlength="200"
												  name="Tarefa"><?php echo $tarefa['Tarefa']; ?></textarea>
										<?php echo form_error('Tarefa'); ?>
									</div>
									<?php if ($metodo == 1) { ?>
										<div class="col-md-4">
											<div class="row">
												<div class="col-md-12 " >
													<label for="Categoria">Categoria:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
															id="Categoria" autofocus name="Categoria">
														<option value="">- Selec. Categoria -</option>	
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
													<div class="col-md-6 text-left">
														<!--<label for="Cadastrar">Cadastrar/Editar Motivo</label><br>-->
														<br>
														<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addCategoriaModal">
															<span class="glyphicon glyphicon-plus"></span>Cadastrar
														</button>
														<!--
														<a class="btn btn-md btn-info btn-block"   target="_blank" href="<?php echo base_url() ?>categoria2/cadastrar3/" role="button"> 
															<span class="glyphicon glyphicon-plus"></span>Cat
														</a>
														-->
													</div>
													<div class="col-md-6 text-left">
														<br>
														<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-refresh"></span>Recarregar
														</button>
													</div>											
												</div>
												<?php echo form_error('Cadastrar'); ?>
											</div>	
										</div>
									<?php } elseif ($metodo == 2) { ?>
										<div class="col-md-4">
											<input type="hidden" name="Categoria" id="Categoria" value="<?php echo $tarefa['Categoria']; ?>"/>
											<input type="hidden" name="Cadastrar" id="Cadastrar" value="S">
											<label for="Categoria">Categoria</label>
											<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Tarefa']['NomeCategoria']; ?>"/>
										</div>
									<?php } ?>
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
										<?php if ($metodo == 1) { ?>
											<div class="col-md-4">
												<label for="Compartilhar">Quem Fazer?</label>		
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
										<?php } elseif ($metodo == 2){ ?>
													
											<div class="col-md-4">
												<input type="hidden" name="Compartilhar" id="Compartilhar" value="<?php echo $tarefa['Compartilhar']; ?>"/>
												<label for="Compartilhar">Quem Fazer</label>
												<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Tarefa']['NomeCompartilhar']; ?>"/>
											</div>
										<?php } ?>	
									<?php } ?>
										
									<!--
									<div class="col-md-4">
										<label for="Prioridade">Prioridade:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="Prioridade" name="Prioridade">
											<option value="">-- Selecione uma opção --</option>
											<?php
											/*
											foreach ($select['Prioridade'] as $key => $row) {
												if ($tarefa['Prioridade'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											*/
											?>
										</select>
										<?php echo form_error('Prioridade'); ?>
									</div>
									-->
								</div>	
								<div class="row">
									<div class="col-md-8" >
										<div class="row">
											<div class="col-md-6 text-left">
												<label for="DataTarefa">Iniciar em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="DataTarefa" value="<?php echo $tarefa['DataTarefa']; ?>">
													
												</div>
												<?php echo form_error('DataTarefa'); ?>
											</div>
											<div class="col-md-6 text-left">
												<label for="DataTarefaLimite">Concluir em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="DataTarefaLimite" value="<?php echo $tarefa['DataTarefaLimite']; ?>">
													
												</div>
												<?php echo form_error('DataTarefaLimite'); ?>
											</div>
										</div>
									</div>
									<!--
									<div class="col-md-4 ">
										<label for="Statustarefa">StatusTRF:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="Statustarefa" name="Statustarefa">
											<option value="">-- Selecione uma opção --</option>
											<?php
											/*
											foreach ($select['Statustarefa'] as $key => $row) {
												if ($tarefa['Statustarefa'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											*/
											?>
										</select>
									</div>
									-->
									<div class="col-md-2 form-inline" style="<?php echo $display; ?>">
										<label for="ConcluidoTarefa">Tarefa Concl.?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['ConcluidoTarefa'] as $key => $row) {
													if (!$tarefa['ConcluidoTarefa'])
														$tarefa['ConcluidoTarefa'] = 'N';

													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

													if ($tarefa['ConcluidoTarefa'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="ConcluidoTarefa_' . $hideshow . '">'
														. '<input type="radio" name="ConcluidoTarefa" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="ConcluidoTarefa_' . $hideshow . '">'
														. '<input type="radio" name="ConcluidoTarefa" id="' . $hideshow . '" '
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
									<input type="hidden" name="idApp_SubTarefa<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_SubTarefa']; ?>"/>
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
													<input type="hidden" name="idSis_Usuario<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idSis_Usuario']; ?>"/>
													<div class="col-md-4">
														<!--<label for="SubTarefa<?php echo $i ?>">Ação:</label>-->
														<label for="SubTarefa<?php echo $i ?>">
															Ação <?php echo $i ?>: 
															<?php if ($procedtarefa[$i]['idSis_Usuario']) { ?>
																<?php echo $_SESSION['Procedtarefa'][$i]['NomeCadastrou'];?>
															<?php } ?>
														</label>
														<textarea class="form-control" id="SubTarefa<?php echo $i ?>" <?php echo $readonly; ?>
																  name="SubTarefa<?php echo $i ?>"><?php echo $procedtarefa[$i]['SubTarefa']; ?></textarea>
													</div>
													<div class="col-md-2">
														<label for="DataSubTarefa<?php echo $i ?>">Iniciar em:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>															
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataSubTarefa<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubTarefa']; ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="DataSubTarefaLimite<?php echo $i ?>">Concluir em:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>															
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataSubTarefaLimite<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubTarefaLimite']; ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="ConcluidoSubTarefa">Ação. Concl.? </label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['ConcluidoSubTarefa'] as $key => $row) {
																	(!$procedtarefa[$i]['ConcluidoSubTarefa']) ? $procedtarefa[$i]['ConcluidoSubTarefa'] = 'N' : FALSE;

																	if ($procedtarefa[$i]['ConcluidoSubTarefa'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_ConcluidoSubTarefa' . $i . '" id="radiobutton_ConcluidoSubTarefa' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoSubTarefa' . $i . '" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_ConcluidoSubTarefa' . $i . '" id="radiobutton_ConcluidoSubTarefa' . $i .  $key . '">'
																		. '<input type="radio" name="ConcluidoSubTarefa' . $i . '" id="radiobuttondinamico" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
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
											<a class="btn btn-xs btn-warning" onclick="adicionaSubTarefa()">
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
								<div id="ConcluidoTarefa" <?php echo $div['ConcluidoTarefa']; ?>>																								
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
					<?php if ($metodo > 1) { ?>
						<input type="hidden" name="idApp_Tarefa" value="<?php echo $tarefa['idApp_Tarefa']; ?>">
					<?php } ?>
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
					<div class="row">
						<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
						
						<?php if ($metodo > 1) { ?>
						<!--<input type="hidden" name="idApp_SubTarefa" value="<?php echo $procedtarefa['idApp_SubTarefa']; ?>">
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
							<?php if ($_SESSION['Tarefa']['idSis_Usuario'] == $_SESSION['log']['idSis_Usuario'] || $_SESSION['Tarefa']['CelularCadastrou'] == $_SESSION['log']['CelularUsuario']) { ?>
								<div class="col-md-6 text-right">
									<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
										<span class="glyphicon glyphicon-trash"></span> Excluir
									</button>
								</div>
							<?php } ?>
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
						<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-success text-center">
										<h5 class="modal-title" id="visulUsuarioModalLabel">Categoria</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										Categoria cadastrada com sucesso!
									</div>
									<div class="modal-footer">
										<div class="col-md-6">	
											<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
												<span class="glyphicon glyphicon-filter"></span> Fechar
											</button>
											<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
												Aguarde um instante! Estamos processando sua solicitação!
											</div>
										</div>	
										<!--<button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>-->
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>

					</form>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>

<div id="addCategoriaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCategoriaModalLabel">Cadastrar Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-categoria"></span>
				<form method="post" id="insert_categoria_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input name="Novo_Categoria" type="text" class="form-control" id="Novo_Categoria" placeholder="Categoria">
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list_categoria)) echo $list_categoria; ?>
			</div>
		</div>
	</div>
</div>

<div id="alterarCategoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarCategoriaLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarCategoriaLabel">Categoria</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-categoria"></span>
				<form method="post" id="alterar_categoria_form">
					<div class="form-group">
						<label for="CategoriaAlterar" class="control-label">Categoria:</label>
						<input type="text" class="form-control" name="CategoriaAlterar" id="CategoriaAlterar">
					</div>
					<input type="hidden" name="id_Categoria" id="id_Categoria">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarCategoria" id="CancelarCategoria" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarCategoria" id="AlterarCategoria" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarCategoria" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
