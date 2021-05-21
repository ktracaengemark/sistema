<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>

<div class="container-fluid">
	<div class="row">
		
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			
			<?php if ($_SESSION['Empresa']['idSis_Empresa'] != 1 ) { ?>
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<a class="navbar-brand">
						<?php echo '<small>' . $_SESSION['Empresa']['idSis_Empresa'] . '</small> - <small>' . $_SESSION['Empresa']['NomeEmpresa'] . '.</small>' ?> 
					</a>
				</div>

			  </div>
			</nav>
			<?php } ?>
<?php } ?>
			
			<div class="row">

				<div class="col-md-12 col-lg-12">
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong>Mensagem - </strong><?php echo $orcatrata['idApp_Procedimento'] ?></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<!--<div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="true">-->
							<div class="panel-group">	
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="col-md-1"></div>
										<div class="form-group text-left">
											<div class="row">
												<div class="col-md-10">
													<label for="ProcedimentoCli">Pergunta:</label>
													<textarea class="form-control" id="ProcedimentoCli" <?php echo $readonly; ?>
															  name="ProcedimentoCli"><?php echo $orcatrata['ProcedimentoCli']; ?></textarea>
												</div>
											</div>
										</div>
										<!--
										<div class="col-md-1"></div>
										<div class="form-group text-left">
											<div class="row">
												<div class="col-md-3">
													<label for="DataProcedimentoCli">Data:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																name="DataProcedimentoCli" value="<?php echo $orcatrata['DataProcedimentoCli']; ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-1"></div>
										
										<div class="form-group text-left">
											<div class="row">
												<div class="col-md-3 form-inline">
													<label for="ConcluidoProcedimentoCli">Concluído?</label><br>
													<div class="form-group">
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['ConcluidoProcedimentoCli'] as $key => $row) {
																(!$orcatrata['ConcluidoProcedimentoCli']) ? $orcatrata['ConcluidoProcedimentoCli'] = 'N' : FALSE;

																if ($orcatrata['ConcluidoProcedimentoCli'] == $key) {
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
										</div>
										-->
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['Empresa']['idSis_Empresa']; ?>">
									<input type="hidden" name="idApp_Procedimento" value="<?php echo $orcatrata['idApp_Procedimento']; ?>">
									<?php if ($metodo > 1) { ?>
									<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
									<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
									<?php } ?>
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'empresacli/excluirproc/' . $orcatrata['idApp_Procedimento'] ?>" role="button">
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
		<div class="col-md-2"></div>
	</div>
</div>
