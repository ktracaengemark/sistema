
<div class="col-md-1"></div>
<div class="col-md-10">
	
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<?php echo form_open('campanha', 'role="form"'); ?>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
					<label  class="" for="">Campanhas</label>
					<div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
						<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
							<span class="input-group-btn">
								<a class="btn btn-md btn-danger" href="<?php echo base_url() ?>campanha/cadastrar" role="button"> 
									<span class="glyphicon glyphicon-plus"></span>Nova
								</a>
							</span>
						<?php } ?>
						<span class="input-group-btn">
							<a type="button" class="btn btn-md btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>Filtrar
							</a>
						</span>
					</div>	
				</div>
			</div>
		</div>
															
		<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro de Campanhas</h4>
					</div>
					<div class="modal-footer">
						<div class="form-group">	
							<div class="row">	
								<div class="col-md-3 text-left">
									<label for="Ordenamento">TipoCampanha:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="TipoCampanha" name="TipoCampanha">
										<?php
										foreach ($select['TipoCampanha'] as $key => $row) {
											if ($query['TipoCampanha'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="AtivoCampanha">Ativa</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
											id="AtivoCampanha" name="AtivoCampanha">
										<?php
										foreach ($select['AtivoCampanha'] as $key => $row) {
											if ($query['AtivoCampanha'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<br>
							<div class="row text-left">
								<div class="col-md-3">
									<label for="DataInicio">Incia (de:).</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim">Inicia (até:)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataInicio2">Termina (de:)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim2">Termina (até:)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
									</div>
								</div>
							</div>
							<br>
							<div class="row">	
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
														id="Campo" name="Campo">
													<?php
													foreach ($select['Campo'] as $key => $row) {
														if ($query['Campo'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-6">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
														id="Ordenamento" name="Ordenamento">
													<?php
													foreach ($select['Ordenamento'] as $key => $row) {
														if ($query['Ordenamento'] == $key) {
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
								</div>								
							</div>
							<br>
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-filter"></span> Filtrar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
											<span class="glyphicon glyphicon-remove"></span> Fechar
										</button>
									</div>
								</div>
							</div>
						</div>											
					</div>
				</div>
			</div>
		</div>
	
		</form>		
		<?php if (isset($msg)) echo $msg; ?>
		<div <?php echo $collapse; ?> id="Campanhas">	
			<div class="panel-body">
				
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>

</div>
