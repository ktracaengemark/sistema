<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
						<strong>Dependente do Cliente: <?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?></strong>
						</div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label for="NomeClienteDep">Nome do Dependente: *</label>
										<input type="text" class="form-control" id="NomeClienteDep" maxlength="255" <?php echo $readonly; ?>
											   name="NomeClienteDep" autofocus value="<?php echo $query['NomeClienteDep']; ?>">
										<?php echo form_error('NomeClienteDep'); ?> 
									</div>
									<div class="col-md-4">
										<label for="DataNascimentoDep">Data de Nascimento:</label>
										<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
											   name="DataNascimentoDep" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimentoDep']; ?>">
									</div> 
									<div class="col-md-4">
										<label for="SexoDep">Sexo:</label>
										<select data-placeholder="Selecione uma Opção..." class="form-control" <?php echo $readonly; ?>
												id="SexoDep" name="SexoDep">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['SexoDep'] as $key => $row) {
												if ($query['SexoDep'] == $key) {
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
									<div class="col-md-4">
										<label for="RelacaoDep">Relação</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="RelacaoDep" name="RelacaoDep">
											<option value="">-- Selecione uma Relação --</option>
											<?php
											foreach ($select['RelacaoDep'] as $key => $row) {
												if ($query['RelacaoDep'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>   
										</select>
										<?php echo form_error('RelacaoDep'); ?>           
									</div>
									<div class="col-md-4">
										<label for="ObsDep">OBS:</label>
										<textarea class="form-control" id="ObsDep" <?php echo $readonly; ?>
												  name="ObsDep"><?php echo $query['ObsDep']; ?></textarea>
									</div>
									<div class="col-md-2">
										<label for="AtivoDep">Ativo?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['AtivoDep'] as $key => $row) {
													(!$query['AtivoDep']) ? $query['AtivoDep'] = 'S' : FALSE;

													if ($query['AtivoDep'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_AtivoDep" id="radiobutton_AtivoDep' . $key . '">'
														. '<input type="radio" name="AtivoDep" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_AtivoDep" id="radiobutton_AtivoDep' . $key . '">'
														. '<input type="radio" name="AtivoDep" id="radiobutton" '
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
							
									<!--<div class="col-md-3 form-inline">
										<label for="StatusVidaDep">Status de Vida:</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['StatusVidaDep'] as $key => $row) {
													if (!$query['StatusVidaDep'])
														$query['StatusVidaDep'] = 'V';

													if ($query['StatusVidaDep'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radio_StatusVidaDep" id="radiogeral' . $key . '">'
														. '<input type="radio" name="StatusVidaDep" id="radiogeral" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radio_StatusVidaDep" id="radiogeral' . $key . '">'
														. '<input type="radio" name="StatusVidaDep" id="radiogeral" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>  
											</div>
										</div>
									</div>-->

							<br>
										
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>"> 
									<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>"> 
									<?php } ?>
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<!--
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
												<span class="glyphicon glyphicon-trash"></span> Excluir
											</button>
										</div>
										-->
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'clientedep/excluir/' . $query['idApp_ClienteDep'] ?>" role="button">
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
	

