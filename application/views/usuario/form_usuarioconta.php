<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Usuario'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">	
						<div class="panel panel-<?php echo $panel; ?>">
							<div class="panel-heading">
								<?php echo $titulo; ?>
							</div>
							<div class="panel-body">
								<?php if (isset($msg)) echo $msg; ?>
								<?php echo validation_errors(); ?>
								<?php echo form_open_multipart($form_open_path); ?>
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="form-group">
											<div class="row">
												<div class="col-md-8">
													<label for="Nome">Nome do Usuario:</label>
													<input type="text" class="form-control" readonly='' value="<?php echo $_SESSION['Usuario']['Nome']; ?>">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-4">
													<label for="Conta">Chave PIX / Conta:</label>
													<input type="text" class="form-control" id="Conta" maxlength="100"
															autofocus name="Conta"  value="<?php echo $query['Conta']; ?>">
													<?php echo form_error('Conta'); ?>
												</div>
												<div class="col-md-4">
													<label for="Banco">Banco:</label>
													<input type="text" class="form-control" id="Banco" maxlength="100"
															 name="Banco"  value="<?php echo $query['Banco']; ?>">
													<?php echo form_error('Banco'); ?>
												</div>
												<div class="col-md-4">
													<label for="Agencia">Agencia:</label>
													<input type="text" class="form-control" id="Agencia" maxlength="100" 
															 name="Agencia"  value="<?php echo $query['Agencia']; ?>">
													<?php echo form_error('Agencia'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
										<div class="col-md-6">
											<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
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
<?php } ?>