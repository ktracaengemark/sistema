<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-4"></div>
		<div class="col-md-4">
		
			<div class="row">
				<div class="col-md-12 col-lg-12">	
					
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong>Tarefas</strong></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="form-group">
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-12">
												<label for="idApp_Cliente">Cliente *</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
														id="idApp_Cliente" autofocus name="idApp_Cliente">
													<option value="">-- Sel. um Cliente --</option>
													<?php
													foreach ($select['idApp_Cliente'] as $key => $row) {
															(!$orcatrata['idApp_Cliente']) ? $orcatrata['idApp_Cliente'] = '1' : FALSE;
														if ($orcatrata['idApp_Cliente'] == $key) {
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
											<div class="col-md-10">
												<label for="Procedimento">Procedimento:</label>
												<textarea class="form-control" id="Procedimento" <?php echo $readonly; ?>
														  name="Procedimento"><?php echo $query['Procedimento']; ?></textarea>
											</div>
										</div>	
										<!--
										<div class="row">	
											<div class="col-md-6">
												<label for="DataProcedimento">Dt.Cadastro</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataProcedimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataProcedimento']; ?>">
											</div>
										</div>
										-->
										<div class="row">	
											<div class="col-md-6">
												<label for="DataProcedimentoLimite">Dt.Retorno</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
														   name="DataProcedimentoLimite" placeholder="DD/MM/AAAA" value="<?php echo $query['DataProcedimentoLimite']; ?>">
												</div>
											</div>
										</div>										
										<div class="row">	
											<div class="col-md-4">
												<label for="ConcluidoProcedimento">Concluída</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['ConcluidoProcedimento'] as $key => $row) {
															(!$query['ConcluidoProcedimento']) ? $query['ConcluidoProcedimento'] = 'N' : FALSE;

															if ($query['ConcluidoProcedimento'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedimento" id="radiobutton_ConcluidoProcedimento' . $key . '">'
																. '<input type="radio" name="ConcluidoProcedimento" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedimento" id="radiobutton_ConcluidoProcedimento' . $key . '">'
																. '<input type="radio" name="ConcluidoProcedimento" id="radiobutton" '
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

							<br>

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
															<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/excluir/' . $query['idApp_Procedimento'] ?>" role="button">
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
