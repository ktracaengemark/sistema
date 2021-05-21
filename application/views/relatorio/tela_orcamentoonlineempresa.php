<?php if ($msg) echo $msg; ?>


<div class="col-md-12 ">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<?php echo form_open('relatorio/orcamentoonlineempresa', 'role="form"'); ?>
			<div class="btn-group">
				<a type="button" class="btn btn-md btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span> Filtrar Ordenamento
				</a>
			</div>			
		</div>
		<div class="panel-body">
			
				<?php echo (isset($list)) ? $list : FALSE ?>
			
		</div>
	</div>
</div>
	
<?php echo form_open('relatorio/orcamentoonlineempresa', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
			</div>
			<div class="modal-footer">
				<div class="panel panel-info">
					<div class="panel-heading">							
						<div class="form-group text-left">	
							<div class="row">		
								<div class="col-md-12 text-left">
									<label for="Ordenamento">Cliente:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="NomeCliente" name="NomeCliente">
										<?php
										foreach ($select['NomeCliente'] as $key => $row) {
											if ($query['NomeCliente'] == $key) {
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
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6 text-left">
								<label for="DataInicio">Data Início:</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
										   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									
								</div>
							</div>
							<div class="col-md-6 text-left">
								<label for="DataFim">Data Fim:</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									
								</div>
							</div>
						</div>
						<div class="row">								
							<div class="col-md-12 text-left">
								<label for="Ordenamento">Ordenamento:</label>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen " 
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
											<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen" 
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
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3 text-left">
						<div class="form-footer ">
							<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>									
	</div>
</div>	
