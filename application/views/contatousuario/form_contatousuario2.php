<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Revendedor'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-sm-offset-1 col-md-10">
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
												<div class="form-group">
													<h3 class="text-left">Dados do Contato  </h3>
													<div class="row">
														<div class="col-md-4">
															<label for="NomeContatoUsuario">Nome do Contato: *</label>
															<input type="text" class="form-control" id="NomeContatoUsuario" maxlength="255" <?php echo $readonly; ?>
																   name="NomeContatoUsuario" autofocus value="<?php echo $query['NomeContatoUsuario']; ?>">
														</div>
														<div class="col-md-4">
															<label for="TelefoneContatoUsuario">Telefone Principal: *</label>
															<input type="text" class="form-control Celular CelularVariavel" id="TelefoneContatoUsuario" maxlength="14" <?php echo $readonly; ?>
															name="TelefoneContatoUsuario" placeholder="(XX)999999999" value="<?php echo $query['TelefoneContatoUsuario']; ?>">
														</div>
														<div class="col-md-4">
															<label for="DataNascimento">Data de Nascimento:</label>
															<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
																   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
														</div>                        													 
														<!--
														<div class="col-md-2 form-inline">
															<label for="StatusVida">Status de Vida:</label><br>
															<div class="form-group">
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	/*
																	foreach ($select['StatusVida'] as $key => $row) {
																		if (!$query['StatusVida'])
																			$query['StatusVida'] = 'V';

																		if ($query['StatusVida'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="radio_StatusVida" id="radiogeral' . $key . '">'
																			. '<input type="radio" name="StatusVida" id="radiogeral" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radio_StatusVida" id="radiogeral' . $key . '">'
																			. '<input type="radio" name="StatusVida" id="radiogeral" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	*/
																	?>  
																</div>
															</div>
														</div>
														-->
													</div>
												</div> 

												<div class="form-group">
													<div class="row">
														<div class="col-md-4">
															<label for="Sexo">Sexo:</label>
															<select data-placeholder="Selecione uma Op��o..." class="form-control" <?php echo $readonly; ?>
																	id="Sexo" name="Sexo">
																<option value="">-- Selecione uma op��o --</option>
																<?php
																foreach ($select['Sexo'] as $key => $row) {
																	if ($query['Sexo'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>   
															</select>
														</div>						
														<div class="col-md-4">
															<label for="Relacao">Rela��o*</label>
															<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																	id="Relacao" name="Relacao">
																<option value="">-- Selecione uma Rela��o --</option>
																<?php
																foreach ($select['Relacao'] as $key => $row) {
																	if ($query['Relacao'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>   
															</select>          
														</div>
														<div class="col-md-4">
															<label for="Obs">OBS:</label>
															<textarea class="form-control" id="Obs" <?php echo $readonly; ?>
																	  name="Obs"><?php echo $query['Obs']; ?></textarea>
														</div>
														<div class="col-md-2">
															<label for="Ativo">Ativo?</label><br>
															<div class="form-group">
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Ativo'] as $key => $row) {
																		(!$query['Ativo']) ? $query['Ativo'] = 'S' : FALSE;

																		if ($query['Ativo'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																			. '<input type="radio" name="Ativo" id="radiobutton" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																			. '<input type="radio" name="Ativo" id="radiobutton" '
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
									</div>
								</div>
								<?php if ($metodo > 1) { ?>
									<input type="hidden" name="idApp_ContatoUsuario" value="<?php echo $query['idApp_ContatoUsuario']; ?>">
								<?php } ?>
								<div class="form-group">
									<div class="row"> 
										<?php if ($metodo == 2) { ?>
											<div class="col-md-6">
												<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
													<span class="glyphicon glyphicon-save"></span> Salvar
												</button>
											</div>
											<div class="col-md-6 text-right">
												<button  type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
															<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
																Esta opera��o � irrevers�vel.</p>
														</div>
														<div class="modal-footer">
															<div class="col-md-6 text-left">
																<button type="button" class="btn btn-warning" data-dismiss="modal">
																	<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																</button>
															</div>
															<div class="col-md-6 text-right">
																<a class="btn btn-danger" href="<?php echo base_url() . 'contatousuario2/excluir/' . $query['idApp_ContatoUsuario'] ?>" role="button">
																	<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

										<?php } else { ?>
											<div class="col-md-6">
												<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
													<span class="glyphicon glyphicon-save"></span> Salvar
												</button>
											</div>
										<?php } ?>
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