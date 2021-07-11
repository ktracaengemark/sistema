<?php if ($msg) echo $msg; ?>
<?php #echo form_open('relatorio/cobrancas', 'role="form"'); ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>	
<div class="col-md-12">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-<?php echo $panel; ?>">
		<?php if($paginacao == "N") { ?>
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-4 text-left">
						<label  id="NomeClienteAuto1">Cliente: <?php echo $cadastrar['NomeClienteAuto']; ?></label>
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-info btn-md" type="submit">
									<span class="glyphicon glyphicon-search"></span> 
								</button>
							</span>
							<input type="text" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
							<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
							<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
							<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
						</div>
					</div>	
					<!--
					<div class="col-md-4 text-left">
						<label>Cliente</label>
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
									<span class="glyphicon glyphicon-search"></span> 
								</button>
							</span>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="clientePet(this.value),clienteDep(this.value),this.form.submit()"
									id="idApp_Cliente" name="idApp_Cliente">
								<?php
								/*
								foreach ($select['idApp_Cliente'] as $key => $row) {
									if ($query['idApp_Cliente'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								*/
								?>
							</select>
						</div>
					</div>
					-->
					<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
						
						<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
						<div class="col-md-4 text-left">
							<label  for="idApp_ClienteDep">Dep</label>
							<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
								<option value=""></option>
							</select>
							<span class="modal-title" id="Dep"></span>
						</div>
						<!--
						<div class="col-md-4 text-left">
							<label>Dependente</label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php #echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
										id="idApp_ClienteDep" name="idApp_ClienteDep">
									<?php
									/*
									foreach ($select['idApp_ClienteDep'] as $key => $row) {
										if ($query['idApp_ClienteDep'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									*/
									?>
								</select>
							</div>
						</div>
						-->
					<?php } ?>
					<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>		
						
						<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
						<div class="col-md-4 text-left">
							<label  for="idApp_ClientePet">Pet</label>
							<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
								<option value=""></option>
							</select>
							<span class="modal-title" id="Pet"></span>
						</div>
						<!--			
						<div class="col-md-4 text-left">
							<label>Pet</label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php #echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
										id="idApp_ClientePet" name="idApp_ClientePet">
									<?php
									/*
									foreach ($select['idApp_ClientePet'] as $key => $row) {
										if ($query['idApp_ClientePet'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									*/
									?>
								</select>
							</div>
						</div>
						-->
					<?php } ?>
					<div class="col-md-4">
						<div class="col-md-4">
							<label>Filtros</label>
							<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
						<?php if ($editar == 1) { ?>
							<?php if ($print == 1) { ?>	
								<div class="col-md-4">
									<label>Imprimir</label>
									<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
										<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
											<span class="glyphicon glyphicon-print"></span>
										</button>
									</a>
								</div>
							<?php } ?>	
						<?php } ?>	
					</div>
				</div>	
			</div>
		<?php } ?>
		<?php echo (isset($list1)) ? $list1 : FALSE ?>
	</div>
</div>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-<?php echo $panel; ?>">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das <?php echo $titulo1; ?></h4>
			</div>
			<div class="modal-footer">

				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">
						<div class="row">
							<div class="col-md-3">
								<label for="DataInicio"><?php echo $Data;?> Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim"><?php echo $Data;?> Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">						
						<div class="row">				
							<div class="col-md-6 text-left">
								<label for="Ordenamento">Ordenamento:</label>
								<div class="form-group btn-block">
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
							<div class="form-footer col-md-3">
							<label></label><br>
								<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-filter"></span> Filtrar
								</button>
							</div>
							<div class="form-footer col-md-3">
							<label></label><br>
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
