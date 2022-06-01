<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-md-12">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>	
				<?php if ($nav_secundario) echo $nav_secundario; ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12 ">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<div class="col-sm-offset-3 col-md-6 ">	
				<div class="panel panel-<?php echo $panel; ?>">			
					<div class="panel-body">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h4>
									<b>
										Orcamento: <?php echo $_SESSION['Arquivos']['idApp_OrcaTrata'] ?><br>
										Arquivo: <?php echo $_SESSION['Arquivos']['idApp_Arquivos'] ?>
									</b>
								</h4>	
								<div class="row">																
									<div class="col-md-6">
										<label for="Texto_Arquivos">Texto:*</label><br>
										<input type="text" class="form-control" maxlength="200"
												name="Texto_Arquivos" value="<?php echo $arquivos['Texto_Arquivos'] ?>">
									</div>
									<div class="col-md-6 text-left">
										<label for="Ativo_Arquivos">Slide Ativo_Arquivos?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['Ativo_Arquivos'] as $key => $row) {
												if (!$arquivos['Ativo_Arquivos']) $arquivos['Ativo_Arquivos'] = 'N';

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($arquivos['Ativo_Arquivos'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="Ativo_Arquivos_' . $hideshow . '">'
													. '<input type="radio" name="Ativo_Arquivos" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="Ativo_Arquivos_' . $hideshow . '">'
													. '<input type="radio" name="Ativo_Arquivos" id="' . $hideshow . '" '
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
						

						<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
						<div class="form-group">
							<div class="row">
								<input type="hidden" name="idApp_Arquivos" value="<?php echo $arquivos['idApp_Arquivos']; ?>">
								<?php if ($metodo == 2) { ?>
									<div class="col-md-6">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
									<div class="col-md-4 text-center">
											<a class="btn btn-warning btn-lg" href="<?php echo base_url() . 'orcatrata/arquivos/' . $_SESSION['Arquivos']['idApp_OrcaTrata'] ?>" role="button">
												<span class="glyphicon glyphicon-file"></span> Voltar
											</a>
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
						<?php } ?>
						</form>

					</div>

				</div>

			</div>
		</div>
	</div>
</div>