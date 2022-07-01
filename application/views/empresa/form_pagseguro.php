<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryEmpresa']) && isset($_SESSION['PagSeguro'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php #if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php echo form_open_multipart($form_open_path); ?>
						<div class="panel panel-primary">
							<div class="panel-heading">
									<?php echo $titulo; ?>
							</div>			
							<div class="panel-body">
								<div class="row">	
									<div class="col-md-12">	
									
										<?php echo validation_errors(); ?>

										<div class="panel panel-info">
											<div class="panel-heading">
												<h3 class="text-left">Dados do Pag Seguro</h3>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3 text-left">
															<label for="Ativo_Pagseguro">Ativo_Pagseguro?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Ativo_Pagseguro'] as $key => $row) {
																	if (!$pagseguro['Ativo_Pagseguro'])$pagseguro['Ativo_Pagseguro'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($pagseguro['Ativo_Pagseguro'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="Ativo_Pagseguro_' . $hideshow . '">'
																		. '<input type="radio" name="Ativo_Pagseguro" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="Ativo_Pagseguro_' . $hideshow . '">'
																		. '<input type="radio" name="Ativo_Pagseguro" id="' . $hideshow . '" '
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
												<div id="Ativo_Pagseguro" <?php echo $div['Ativo_Pagseguro']; ?>>
													<div class="form-group">
														<div class="row">
															<div class="col-md-6">
																<label for="Email_Loja">E-mail da Loja:</label>
																<input type="text" class="form-control" id="Email_Loja" maxlength="100" <?php echo $readonly; ?>
																	   name="Email_Loja" value="<?php echo $pagseguro['Email_Loja']; ?>">
															</div>
															<div class="col-md-6">
																<label for="Email_Pagseguro">E-mail do PagSeguro:</label>
																<input type="text" class="form-control" id="Email_Pagseguro" maxlength="100" <?php echo $readonly; ?>
																	   name="Email_Pagseguro" value="<?php echo $pagseguro['Email_Pagseguro']; ?>">
															</div>
														</div>
													</div>	
													<div class="form-group">	
														<div class="row">	
															<div class="col-md-6">
																<label for="Token_Sandbox">Token Sandbox:</label>
																<input type="text" class="form-control " id="Token_Sandbox" maxlength="200" <?php echo $readonly; ?>
																	   name="Token_Sandbox" value="<?php echo $pagseguro['Token_Sandbox']; ?>">
															</div>
														</div>	
														<div class="row">
															<div class="col-md-2 text-left">
																<label for="Prod_PagSeguro">Prod_PagSeguro?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Prod_PagSeguro'] as $key => $row) {
																		if (!$pagseguro['Prod_PagSeguro'])$pagseguro['Prod_PagSeguro'] = 'N';

																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($pagseguro['Prod_PagSeguro'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Prod_PagSeguro_' . $hideshow . '">'
																			. '<input type="radio" name="Prod_PagSeguro" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="Prod_PagSeguro_' . $hideshow . '">'
																			. '<input type="radio" name="Prod_PagSeguro" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
														</div>	
														<div id="Prod_PagSeguro" <?php echo $div['Prod_PagSeguro']; ?>>
															<div class="row">		
																<div class="col-md-6">
																	<label for="Token_Producao">Token Producao:</label>
																	<input type="text" class="form-control " id="Token_Producao" maxlength="200" <?php echo $readonly; ?>
																		   name="Token_Producao" value="<?php echo $pagseguro['Token_Producao']; ?>">
																</div>
															</div>																			
														</div>
													</div>
												</div>	
												<!--<input type="hidden" name="idSis_Empresa" value="<?php #echo $_SESSION['QueryEmpresa']['idSis_Empresa']; ?>">-->
												<input type="hidden" name="idSis_Empresa" value="<?php echo $pagseguro['idSis_Empresa']; ?>">
												<input type="hidden" name="idApp_Documentos" value="<?php echo $pagseguro['idApp_Documentos']; ?>">
												<div class="row">
													<div class="col-md-12">
														<div class="panel panel-primary">
															<div class="panel-heading">
																<div class="btn-group">
																	<button class="btn btn-sm btn-default" id="inputDb" data-loading-text="Aguarde..." type="submit">
																		<span class="glyphicon glyphicon-save"></span> Salvar
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
						</form>
					</div>
				</div>	
			</div>
		</div>	
	</div>
<?php } ?>