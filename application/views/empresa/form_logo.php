<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryEmpresa'])) { ?>
	<div class="container-fluid">	
		<div class="row">
			<div class="col-md-12">
				<?php #if ($nav_secundario) echo $nav_secundario; ?>
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
										<h3 class="text-left">Dados do Empresa  </h3>
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<!--<label for="NomeEmpresa">NomeEmpresa do Empresa:</label>-->
													<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" readonly=''
															name="NomeEmpresa"  value="<?php echo $_SESSION['QueryEmpresa']['NomeEmpresa']; ?>">
												</div>

											</div>
										</div>				
										<?php if ($metodo != 3) { ?>
										<div class="form-group">
											<div class="row">
												<div class="col-md-12 "> 
													<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['QueryEmpresa']['idSis_Empresa']; ?>">
														<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['QueryEmpresa']['Arquivo'] . ''; ?>" 
														class="img-circle img-responsive" width='200'>
													</a>												
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label for="Arquivo">Arquivo: *</label>
													<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
														   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
												</div>
											</div>
										</div>

										<?php } else { ?>

										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label for="Arquivo">Arquivo: *</label><br>
													<a href="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $file['Arquivo']?>" target="_blank" class="btn btn-info">
														<span class="glyphicon glyphicon-file"></span> Visualizar
													</a>
													<?php echo $file['Arquivo']; ?>
												</div>
											</div>
										</div>                
										
										<?php } ?>
										
										<br>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
										<!--<input type="hidden" name="idSis_Empresa" value="<?php #echo $file['idSis_Empresa']; ?>">-->
										<?php if ($metodo == 3) { ?>
											<input type="hidden" name="idSis_Arquivo" value="<?php echo $file['idSis_Arquivo']; ?>">
											<input type="hidden" name="Arquivo" value="<?php echo $file['Arquivo']; ?>">                       
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
<?php } ?>
