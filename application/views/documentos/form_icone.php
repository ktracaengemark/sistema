<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Documentos'])) { ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-lg-3 col-md-2 col-sm-1"></div>
		<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-body">
					<?php if (isset($msg)) echo $msg; ?>
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-info">
						<div class="panel-heading">						
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo base_url() . 'relatorio/site/'; ?>">
											<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Documentos']['Icone'] . ''; ?>" 
											class="img-responsive" width='300'>
										</a>										
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
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
					<input type="hidden" name="idSis_Empresa" value="<?php echo $file['idSis_Empresa']; ?>">
					<input type="hidden" name="idApp_Documentos" value="<?php echo $query['idApp_Documentos']; ?>">
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<button class="btn btn-lg btn-primary btn-block" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url() . 'relatorio/site/'?>">
										<span class="glyphicon glyphicon-file"></span> Voltar
									</a>
								</div>
							</div>
						</div>
					<?php } ?>					
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-2 col-sm-1"></div>
	</div>
</div>
<?php } ?>
