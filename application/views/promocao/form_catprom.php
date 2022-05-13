<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Catprom'])) { ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-body">
					<?php if (isset($msg)) echo $msg; ?>
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-info">
						<div class="panel-heading">						
							<div class="row">
								<div class="col-md-12 ">
									<div class="col-md-6 ">	
										<div class="row">
											<div class="col-md-12 ">
												<div class="row">
													<label>Categoria: Dimensão 300 x 300</label>
													<a href="<?php echo base_url() . 'relatorio/promocao/'; ?>">
														<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Catprom']['Arquivo'] . ''; ?>" 
														class="img-responsive" width='300'>
													</a>
												</div>	
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<strong><?php echo $_SESSION['Catprom']['Catprom']; ?></strong>
												</div>
											</div>
										</div>	
									</div>	
									<div class="col-md-6 ">	
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label for="Arquivo">Arquivo: *</label>
													<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
														   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>								
							</div>
							<br>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $file['idSis_Empresa']; ?>">
							<input type="hidden" name="idTab_Catprom" value="<?php echo $file['idTab_Catprom']; ?>">
							<div class="col-md-6">                            
								<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>                            
							</div>
						</div>
					</div>                
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
<?php } ?>
