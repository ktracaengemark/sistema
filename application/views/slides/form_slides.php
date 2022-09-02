<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Slides'])) { ?>
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
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<a href="<?php echo base_url() . 'relatorio/slides/'; ?>">
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Slides']['Slide1'] . ''; ?>" 
													class="img-responsive" width='300'>
												</a>
											</div>
											<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">	
												<label for="Texto_Slide1">Texto:</label>
												<input type="text" class="form-control"  maxlength="200" name="Texto_Slide1" value="<?php echo $query['Texto_Slide1'] ?>">
											</div>
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">												
												<label for="Ativo">Slide Ativo?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['Ativo'] as $key => $row) {
														if (!$query['Ativo']) $query['Ativo'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($query['Ativo'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="Ativo_' . $hideshow . '">'
															. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="Ativo_' . $hideshow . '">'
															. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
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
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<label for="Arquivo">Arquivo: *</label>
												<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
													   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<br>
						</div>
					</div>
					<input type="hidden" name="idSis_Empresa" value="<?php echo $file['idSis_Empresa']; ?>">
					<input type="hidden" name="idApp_Slides" value="<?php echo $query['idApp_Slides']; ?>">
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
					<div class="form-group">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
							<div class="row">
								<button class="btn btn-lg btn-primary btn-block" id="inputDb" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
							<div class="row">
								<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url() . 'relatorio/site/'?>">
									<span class="glyphicon glyphicon-file"></span> Voltar
								</a>
							</div>
						</div>								
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
							<div class="row">
								<button  type="button" class="btn btn-lg btn-danger btn-block" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
									<span class="glyphicon glyphicon-trash"></span> Excluir
								</button>
							</div>
						</div>
						<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
									</div>
									<div class="modal-body">
										<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
									</div>
									<div class="modal-footer">
										<div class="col-md-6 text-left">
											<button type="button" class="btn btn-warning" data-dismiss="modal">
												<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<a class="btn btn-danger" href="<?php echo base_url() . 'slides/excluir/' . $query['idApp_Slides'] ?>" role="button">
												<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<?php } ?>					
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
<?php } ?>
