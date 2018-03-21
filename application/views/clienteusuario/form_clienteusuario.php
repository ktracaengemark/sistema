<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Clienteusuario'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Clienteusuario']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Clienteusuario']['idSis_Usuario'] . '</small>' ?></strong></div>
				<div class="panel-body">
			
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Usuário & Contatos:</label>
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'clienteusuario/prontuario/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>
											<a <?php if (preg_match("/clienteusuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'clienteusuario/alterar/' . $_SESSION['Clienteusuario']['idSis_Usuario']; ?>">
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
								<h3><?php echo '<strong>' . $_SESSION['Clienteusuario']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Clienteusuario']['idSis_Usuario'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<?php } ?>
					
					<div class="row">
						<div class="col-md-12 col-lg-12">	
							
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Cliente</strong></div>
								<div class="panel-body">

									<?php echo form_open_multipart($form_open_path); ?>

									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label for="Nome">Nome do Cliente:</label>
												<input type="text" class="form-control" id="Nome" maxlength="45" 
														name="Nome" autofocus value="<?php echo $query['Nome']; ?>">
											</div>																		
											<div class="col-md-3">
												<label for="Celular">Tel.- Fixo ou Celular*</label>
												<input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="11" <?php echo $readonly; ?>
													   name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
											</div>
											<div class="col-md-3">
												<label for="DataNascimento">Data de Nascimento:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
											</div>						
											<div class="col-md-3">
												<label for="Sexo">Sexo:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="Sexo" name="Sexo">
													<option value="">--Selec. o Sexo--</option>
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
										</div>
									</div>
									<div class="form-group">
										<div class="row">
										
											<div class="col-md-3">
												<label for="Email">E-mail:</label>
												<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
													   name="Email" value="<?php echo $query['Email']; ?>">
											</div>
											<div class="col-md-2">
												<label for="Inativo">Ativo?</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Inativo'] as $key => $row) {
															(!$query['Inativo']) ? $query['Inativo'] = 'S' : FALSE;

															if ($query['Inativo'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																. '<input type="radio" name="Inativo" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																. '<input type="radio" name="Inativo" id="radiobutton" '
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
											<div class="col-md-3">
												<label for="Usuario">Usuário:</label>
												<input type="text" class="form-control" id="Usuario" maxlength="45" 
													   autofocus name="Usuario" value="<?php echo $query['Usuario']; ?>">
												<?php echo form_error('Usuario'); ?>
											</div>						
											<div class="col-md-3">
												<label for="Senha">Senha:</label>
												<input type="password" class="form-control" id="Senha" maxlength="45"
													   name="Senha" value="<?php echo $query['Senha']; ?>">
												<?php echo form_error('Senha'); ?>
											</div>
											<div class="col-md-3">
												<label for="Senha">Confirmar Senha:</label>
												<input type="password" class="form-control" id="Confirma" maxlength="45"
													   name="Confirma" value="<?php echo $query['Confirma']; ?>">
												<?php echo form_error('Confirma'); ?>
											</div>
											-->
										</div>
									</div>
									<!--
									<div class="form-group">
										<div class="row">
											
											<div class="col-md-6">
												<label for="Permissao">Nível / Permissão:*</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="Permissao" name="Permissao">
													<option value="">-- Selecione uma Permissao --</option>
													<?php
													foreach ($select['Permissao'] as $key => $row) {
														if ($query['Permissao'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>   
												</select>          
											</div>
											
											<div class="col-md-6">
												<label for="Funcao">Funcao:*</label>
												<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>funcao/cadastrar/funcao" role="button"> 
													<span class="glyphicon glyphicon-plus"></span> <b>Nova Funcao</b>
												</a>
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="Funcao" name="Funcao">
													<option value="">-- Selecione uma Funcao --</option>
													<?php
													foreach ($select['Funcao'] as $key => $row) {
														if ($query['Funcao'] == $key) {
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
									-->
									<br>

									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
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
																	<a class="btn btn-danger" href="<?php echo base_url() . 'clienteusuario/excluir/' . $query['idSis_Usuario'] ?>" role="button">
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
			</div>		
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>
