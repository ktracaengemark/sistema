<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10 ">
			<?php #echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong></strong>
						<div class="text-left ">											
							<span class="glyphicon glyphicon-pencil"></span> 
							<?php echo $titulo; ?>
							<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>campanha" role="button"> 
								<span class="glyphicon glyphicon-list"></span> Campanhas
							</a>
						</div>					
				</div>
				<div class="panel-body">
					<?php echo form_open_multipart($form_open_path); ?>
					<?php 
						if ($metodo > 1) { 
							$Cod_campanha	= $campanha['idApp_Campanha'];
						}else{
							$Cod_campanha	= False;
						}
					?> 
					<!--App_Campanha-->
					<div class="form-group">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="row">
									<?php if ($metodo == 1) { ?>
										<div class="col-md-3 form-inline">
											<label for="TipoCampanha">Tipo</label><br>
											<div class="form-group">
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['TipoCampanha'] as $key => $row) {
														if (!$campanha['TipoCampanha']) $campanha['TipoCampanha'] = '1';
														($key == '2') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($campanha['TipoCampanha'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="TipoCampanha_' . $hideshow . '">'
															. '<input type="radio" name="TipoCampanha" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="TipoCampanha_' . $hideshow . '">'
															. '<input type="radio" name="TipoCampanha" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
									<?php } elseif ($metodo == 2) { ?>
										<div class="col-md-3">
											<input type="hidden" name="TipoCampanha" id="TipoCampanha" value="<?php echo $campanha['TipoCampanha']; ?>"/>
											<label for="TipoCampanha">Tipo</label>
											<input type="text" class="form-control" readonly="" value="<?php echo $Tipo; ?>"/>
										</div>
									<?php } ?>
									<div id="TipoCampanha" <?php echo $div['TipoCampanha']; ?>>
										<?php if ($metodo == 1) { ?>
											<div class="col-md-3 form-inline">
												<label for="TipoDescCampanha">Tipo Desc</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['TipoDescCampanha'] as $key => $row) {
															if (!$campanha['TipoDescCampanha']) $campanha['TipoDescCampanha'] = 'V';
															($key == 'P') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
															if ($campanha['TipoDescCampanha'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="TipoDescCampanha_' . $hideshow . '">'
																. '<input type="radio" name="TipoDescCampanha" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="TipoDescCampanha_' . $hideshow . '">'
																. '<input type="radio" name="TipoDescCampanha" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
										<?php } elseif ($metodo == 2) { ?>
											<div class="col-md-3">
												<input type="hidden" name="TipoDescCampanha" id="TipoDescCampanha" value="<?php echo $campanha['TipoDescCampanha']; ?>"/>
												<label for="TipoDescCampanha">Tipo Desc</label>
												<input type="text" class="form-control" readonly="" value="<?php echo $TipoDesc; ?>"/>
											</div>
										<?php } ?>
										<div class="col-md-3">	
											<label for="ValorDesconto">Valor Desconto:</label><br>
											<div class="input-group" id="txtHint">
												<span class="input-group-addon" id="basic-addon1">??</span>
												<input type="text" class="form-control text-left Valor" id="ValorDesconto" maxlength="10" placeholder="0,00" 
													   name="ValorDesconto" value="<?php echo $campanha['ValorDesconto'] ?>">
											</div>
											<?php echo form_error('ValorDesconto'); ?>
										</div>
										<div class="col-md-3">	
											<label for="ValorMinimo">Valor Minimo:</label><br>
											<div class="input-group" id="txtHint">
												<span class="input-group-addon" id="basic-addon1">R$</span>
												<input type="text" class="form-control text-left Valor" id="ValorMinimo" maxlength="10" placeholder="0,00" 
													   name="ValorMinimo" value="<?php echo $campanha['ValorMinimo'] ?>">
											</div>
											<?php echo form_error('ValorMinimo'); ?>
										</div>
									</div>
								</div>	
								<div class="row">
									<div class="col-md-3">
										<label  for="Campanha">Campanha: <?php echo $Cod_campanha; ?></label>
										<input class="form-control" id="Campanha" <?php echo $readonly; ?> maxlength="200"
												  name="Campanha" value="<?php echo $campanha['Campanha']; ?>">
										<?php echo form_error('Campanha'); ?>
									</div>
									<div class="col-md-6">
										<label  for="DescCampanha">Premio/Regras:</label>
										<textarea class="form-control" id="DescCampanha" <?php echo $readonly; ?> maxlength="200"
												  name="DescCampanha"><?php echo $campanha['DescCampanha']; ?></textarea>
										<?php echo form_error('DescCampanha'); ?>
									</div>
								</div>								
								<div class="row">
									<div class="col-md-6" >
										<div class="row">
											<div class="col-md-6 text-left">
												<label for="DataCampanha">Inicia em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="DataCampanha" value="<?php echo $campanha['DataCampanha']; ?>">
													
												</div>
												<?php echo form_error('DataCampanha'); ?>
											</div>
											<div class="col-md-6 text-left">
												<label for="DataCampanhaLimite">Termina em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
														   name="DataCampanhaLimite" value="<?php echo $campanha['DataCampanhaLimite']; ?>">
													
												</div>
												<?php echo form_error('DataCampanhaLimite'); ?>
											</div>
										</div>
									</div>
									<div class="col-md-3 form-inline">
										<label for="AtivoCampanha">Ativa?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['AtivoCampanha'] as $key => $row) {
													if (!$campanha['AtivoCampanha'])
														$campanha['AtivoCampanha'] = 'N';

													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

													if ($campanha['AtivoCampanha'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="AtivoCampanha_' . $hideshow . '">'
														. '<input type="radio" name="AtivoCampanha" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="AtivoCampanha_' . $hideshow . '">'
														. '<input type="radio" name="AtivoCampanha" id="' . $hideshow . '" '
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
						</div>		
					</div>
					<?php if ($metodo > 1) { ?>
						<input type="hidden" name="idApp_Campanha" value="<?php echo $campanha['idApp_Campanha']; ?>">
					<?php } ?>
					<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
						<div class="row">
							<div class="col-md-6">
								<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>
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
