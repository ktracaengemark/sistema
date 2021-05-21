<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-3"></div>
		<div class="col-md-6">
		
			<div class="row">
				<div class="col-md-12 col-lg-12">	
					
					<?php #echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
							<?php echo $titulo; ?>
							<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>agenda" role="button">
								<span class="glyphicon glyphicon-search"></span>Agenda
							</a>
						</div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="form-group">
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="row">	
											<div class="col-md-6">
												<label for="idSis_Empresa">para a Empresa:*</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> readonly=""
														id="idSis_Empresa" autofocus name="idSis_Empresa">
													<option value="">-- Selec. uma Empresa --</option>
													<?php
													foreach ($select['idSis_Empresa'] as $key => $row) {
														if ($query['idSis_Empresa'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
										</div>	
										<?php echo form_error('idSis_Empresa'); ?>
										<div class="row">
											<div class="col-md-12">
												<label for="ProcedimentoCli">Mensagem:</label>
												<textarea class="form-control" id="ProcedimentoCli" <?php echo $readonly; ?>
														  name="ProcedimentoCli"><?php echo $query['ProcedimentoCli']; ?></textarea>
											</div>
										</div>	
										<!--
										<div class="row">	
											<div class="col-md-6">
												<label for="DataProcedimentoCli">Data:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataProcedimentoCli" placeholder="DD/MM/AAAA" value="<?php echo $query['DataProcedimentoCli']; ?>">
											</div>
										</div>	
										
										<div class="row">	
											<div class="col-md-4">
												<label for="ConcluidoProcedimentoCli">Concluída</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['ConcluidoProcedimentoCli'] as $key => $row) {
															(!$query['ConcluidoProcedimentoCli']) ? $query['ConcluidoProcedimentoCli'] = 'S' : FALSE;

															if ($query['ConcluidoProcedimentoCli'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedimentoCli" id="radiobutton_ConcluidoProcedimentoCli' . $key . '">'
																. '<input type="radio" name="ConcluidoProcedimentoCli" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedimentoCli" id="radiobutton_ConcluidoProcedimentoCli' . $key . '">'
																. '<input type="radio" name="ConcluidoProcedimentoCli" id="radiobutton" '
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
										-->
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Procedimento" value="<?php echo $query['idApp_Procedimento']; ?>">
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'empresacli/excluirproc/' . $query['idApp_Procedimento'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

									<?php } elseif ($metodo == 3) { ?>
										<div class="col-md-12 text-center">
											<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
												<span class="glyphicon glyphicon-trash"></span> Excluir
											</button>
											<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
													return true;">
												<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
											</button>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
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
		<div class="col-md-4"></div>
	</div>	
</div>
