<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">

		<div class="col-sm-3 col-md-2 sidebar">
			<?php echo $nav_secundario; ?>
		</div>

		<div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">

			<?php echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

					<!--App_Tarefa-->

					<div class="form-group">
						<div class="row">
						
							<div class="col-md-4">
								<label for="ObsTarefa">Tarefa:</label>
								<textarea class="form-control" id="ObsTarefa" <?php echo $readonly; ?>
								autofocus name="ObsTarefa"><?php echo $tarefa['ObsTarefa']; ?></textarea>
							</div>
						
							<div class="col-md-2">
								<label for="DataTarefa">Data Limite:</label>
								<div class="input-group <?php echo $datepicker; ?>">
									<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
										   autofocus name="DataTarefa" value="<?php echo $tarefa['DataTarefa']; ?>">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>

							<div class="col-md-4">
								<label for="ProfissionalTarefa">Gerente da Tarefa:</label>
								<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
									<span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
								</a>
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
						</div>
					</div>

						<hr>

					<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
						<div class="panel panel-info">
							<div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
								<h4 class="panel-title">
									<a class="accordion-toggle">
										<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> Ações									</a>
								</h4>
							</div>

							<div id="collapse3" class="panel-collapse collapse <?php echo $tratamentosin ?>" role="tabpanel" aria-labelledby="heading3">
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
										<div class="row">
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
												<label for="Profissional<?php echo $i ?>">Profissional:</label>
												<?php if ($i == 1) { ?>
												<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
													<span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
												</a>
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
											<div class="col-md-4">
												<label for="Procedtarefa<?php echo $i ?>">Ação:</label>
												<textarea class="form-control" id="Procedtarefa<?php echo $i ?>" <?php echo $readonly; ?>
														  name="Procedtarefa<?php echo $i ?>"><?php echo $procedtarefa[$i]['Procedtarefa']; ?></textarea>
											</div>
											<div class="col-md-1">
												<label><br></label><br>
												<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
													<span class="glyphicon glyphicon-trash"></span>
												</button>
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
							<div class="col-md-2">
								<label for="DataRetorno">Retomar à Tarefa:</label>
								<div class="input-group <?php echo $datepicker; ?>">
									<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
										   name="DataRetorno" value="<?php echo $tarefa['DataRetorno']; ?>">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>									
							</div>
							
							<div class="col-md-2 form-inline">
								<label for="AprovadoTarefa">Tarefa Concl.?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['AprovadoTarefa'] as $key => $row) {
											if (!$tarefa['AprovadoTarefa'])
												$tarefa['AprovadoTarefa'] = 'N';

											($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

											if ($tarefa['AprovadoTarefa'] == $key) {
												echo ''
												. '<label class="btn btn-warning active" name="AprovadoTarefa_' . $hideshow . '">'
												. '<input type="radio" name="AprovadoTarefa" id="' . $hideshow . '" '
												. 'autocomplete="off" value="' . $key . '" checked>' . $row
												. '</label>'
												;
											} else {
												echo ''
												. '<label class="btn btn-default" name="AprovadoTarefa_' . $hideshow . '">'
												. '<input type="radio" name="AprovadoTarefa" id="' . $hideshow . '" '
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

								<div id="AprovadoTarefa" <?php echo $div['AprovadoTarefa']; ?>>
									<!--
									<div class="col-md-2 form-inline">
										<label for="QuitadoTarefa">Orçam. Quitado?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['QuitadoTarefa'] as $key => $row) {
													(!$tarefa['QuitadoTarefa']) ? $tarefa['QuitadoTarefa'] = 'N' : FALSE;

													if ($tarefa['QuitadoTarefa'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_QuitadoTarefa" id="radiobutton_QuitadoTarefa' . $key . '">'
														. '<input type="radio" name="QuitadoTarefa" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_QuitadoTarefa" id="radiobutton_QuitadoTarefa' . $key . '">'
														. '<input type="radio" name="QuitadoTarefa" id="radiobutton" '
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
										<label for="ServicoConcluido">Serviço Concluído?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['ServicoConcluido'] as $key => $row) {
													(!$tarefa['ServicoConcluido']) ? $tarefa['ServicoConcluido'] = 'N' : FALSE;

													if ($tarefa['ServicoConcluido'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_ServicoConcluido" id="radiobutton_ServicoConcluido' . $key . '">'
														. '<input type="radio" name="ServicoConcluido" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_ServicoConcluido" id="radiobutton_ServicoConcluido' . $key . '">'
														. '<input type="radio" name="ServicoConcluido" id="radiobutton" '
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
								   
									<div class="col-md-2">
										<label for="DataConclusao">Data da Concl.:</label>
										<div class="input-group <?php echo $datepicker; ?>">
											<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
												   name="DataConclusao" value="<?php echo $tarefa['DataConclusao']; ?>">
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
							<!--<input type="hidden" name="idApp_Profissional" value="<?php echo $_SESSION['Profissional']['idApp_Profissional']; ?>">-->
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

	</div>
</div>
