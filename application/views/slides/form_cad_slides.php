<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
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
								<div class="form-group">
									<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
										<label for="Texto_Slide1">Texto:</label>
										<input type="text" class="form-control"  maxlength="45" id="Texto_Slide1"name="Texto_Slide1" value="">
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
								<div class="form-group">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="Arquivo">Arquivo: *</label>
										<input type="file" class="file" multiple="false" data-show-upload="false" data-show-caption="true" 
											   name="Arquivo" value="<?php echo $file['Arquivo']; ?>">
									</div>
								</div>								
							</div>
							<br>
						</div>
					</div>
					<input type="hidden" name="idSis_Empresa" value="<?php echo $file['idSis_Empresa']; ?>">
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
									<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'relatorio/slides/'?>">
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
		<div class="col-md-1"></div>
	</div>
</div>
<?php } ?>
