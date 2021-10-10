<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Fornecedor'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</strong> - <small>Id.: ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Fornecedor & Contatos:</label>
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>								
											<a <?php if (preg_match("/fornecedor\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'fornecedor/alterar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
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
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</strong> - <small>Id.: ' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<?php } ?>

					<div class="row">
						
						<div class="col-md-12 col-lg-12">
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Contato</strong></div>
								<div class="panel-body">

									<?php echo form_open_multipart($form_open_path); ?>

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="NomeContatofornec">Nome do Contatofornec: *</label>
												<input type="text" class="form-control" id="NomeContatofornec" maxlength="255" <?php echo $readonly; ?>
													   name="NomeContatofornec" autofocus value="<?php echo $query['NomeContatofornec']; ?>">
											</div>
											<div class="col-md-4">
												<label for="TelefoneContatofornec">Telefone Principal: *</label>
												<input type="text" class="form-control Celular CelularVariavel" id="TelefoneContatofornec" maxlength="20" <?php echo $readonly; ?>
													   name="TelefoneContatofornec" placeholder="(XX)999999999" value="<?php echo $query['TelefoneContatofornec']; ?>">
											</div>
											<div class="col-md-4">
												<label for="DataNascimento">Data de Nascimento:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
											</div>
											<!--<div class="col-md-2 form-inline">
												<label for="StatusVida">Status de Vida:</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
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
														?>  
													</div>
												</div>
											</div>-->
										</div>
									</div> 

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="Sexo">Sexo:</label>
												<select data-placeholder="Selecione uma Opção..." class="form-control" <?php echo $readonly; ?>
														id="Sexo" name="Sexo">
													<option value="">-- Selecione uma opção --</option>
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
												<label for="Relacao">Relação*</label>
												<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>relacao/cadastrar/relacao" role="button"> 
													<span class="glyphicon glyphicon-plus"></span> <b>Nova Relação</b>
												</a>-->
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="Relacao" name="Relacao">
													<option value="">-- Selecione uma Relação --</option>
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
											<div class="col-md-3">
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
									<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_Contatofornec" value="<?php echo $query['idApp_Contatofornec']; ?>">
									<?php } ?>
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idApp_Fornecedor" value="<?php echo $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">  
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
																	<a class="btn btn-danger" href="<?php echo base_url() . 'contatofornec/excluir/' . $query['idApp_Contatofornec'] ?>" role="button">
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
			</div>		
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>