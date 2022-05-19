<?php if ($msg) echo $msg; ?>
<?php #echo form_open('relatorio/cobrancas', 'role="form"'); ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>	
<div class="col-md-12">		
	<?php echo validation_errors(); ?>
	<div class="panel panel-<?php echo $panel; ?>">
		<?php if($paginacao == "N") { ?>
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left" >
						<label>Profissional:</label>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="NomeUsuario" name="NomeUsuario" onchange="this.form.submit()">
							<?php
							foreach ($select['NomeUsuario'] as $key => $row) {
								if ($query['NomeUsuario'] == $key) {
									echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
								} else {
									echo '<option value="' . $key . '">' . $row . '</option>';
								}
							}
							?>
						</select>
					</div>
					<?php if($TipoEvento == 2){?>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">
							<label>Cliente: </label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
							</div>
							<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
							<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
							<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
							<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
						</div>
						<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
							
							<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left">
								<label  for="idApp_ClienteDep">Dep</label>
								<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
									<option value=""></option>
								</select>
								<span class="modal-title" id="Dep"></span>
							</div>
						<?php } ?>
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>		
							
							<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left">
								<label  for="idApp_ClientePet">Pet</label>
								<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
									<option value=""></option>
								</select>
								<span class="modal-title" id="Pet"></span>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label>Filtros</label>
								<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							<?php if ($editar == 1) { ?>
								<?php if ($print == 1) { ?>
									<!--
									<div class="col-md-4">
										<label>Imprimir</label>
										<a href="<?php #echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
											<button class="btn btn-<?php #echo $panel; ?> btn-md btn-block" type="button">
												<span class="glyphicon glyphicon-print"></span>
											</button>
										</a>
									</div>
									-->
								<?php } ?>	
							<?php } ?>
						</div>	
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
				

				<?php if($TipoEvento == 2){ ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading text-left">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left" >
									<label class="text-left">Texto Whatsapp:</label>
									<div class="row text-left">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
											<label>Pt1</label><br>
											<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. Olá" 
												name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>" rows="1">
												<?php echo set_value('Texto1', $query['Texto1']); ?>
											</textarea>
										</div>
										<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
											<label for="nomedo<?php echo $nome?>">Nome do <?php echo $nome?>?</label><br>
											<div class="btn-larg-right btn-group" data-toggle="buttons">
												<?php
												foreach ($select['nomedo' . $nome] as $key => $row) {
													if (!$query['nomedo' . $nome]) $query['nomedo' . $nome] = 'N';
													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
													if ($query['nomedo' . $nome] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="nomedo' . $nome . '_' . $hideshow . '">'
														. '<input type="radio" name="nomedo' . $nome . '" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="nomedo' . $nome . '_' . $hideshow . '">'
														. '<input type="radio" name="nomedo' . $nome . '" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
										</div>
										<div id="nomedo<?php echo $nome; ?>" <?php echo $div['nomedo'.$nome]; ?>>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
												<label>Pt2</label><br>
												<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
													name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>" rows="1">
													<?php echo set_value('Texto2', $query['Texto2']); ?>
												</textarea>
											</div>
										</div>
									</div>	
									<div class="row text-left">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" ></div>
										<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
											<label for="id<?php echo $nome?>">Nº do <?php echo $nome?>?</label><br>
											<div class="btn-larg-right btn-group" data-toggle="buttons">
												<?php
												foreach ($select['id' . $nome] as $key => $row) {
													if (!$query['id' . $nome]) $query['id' . $nome] = 'N';
													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
													if ($query['id' . $nome] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="id' . $nome . '_' . $hideshow . '">'
														. '<input type="radio" name="id' . $nome . '" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="id' . $nome . '_' . $hideshow . '">'
														. '<input type="radio" name="id' . $nome . '" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
										</div>
										<div id="id<?php echo $nome; ?>" <?php echo $div['id'.$nome]; ?>>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
												<label>Pt3</label><br>
												<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
													name="Texto3" id="Texto3" value="<?php echo set_value('Texto3', $query['Texto3']); ?>" rows="1">
													<?php echo set_value('Texto3', $query['Texto3']); ?>
												</textarea>
											</div>
										</div>
									</div>	
									<div class="row text-left">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" ></div>
										<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
											<label for="numerodopedido">Nº do Agend.?</label><br>
											<div class="btn-larg-right btn-group" data-toggle="buttons">
												<?php
												foreach ($select['numerodopedido'] as $key => $row) {
													if (!$query['numerodopedido']) $query['numerodopedido'] = 'N';
													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
													if ($query['numerodopedido'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="numerodopedido_' . $hideshow . '">'
														. '<input type="radio" name="numerodopedido" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="numerodopedido_' . $hideshow . '">'
														. '<input type="radio" name="numerodopedido" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
										</div>
										<div id="numerodopedido" <?php echo $div['numerodopedido']; ?>>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
												<label>Pt4</label><br>
												<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
													name="Texto4" id="Texto4" value="<?php echo set_value('Texto4', $query['Texto4']); ?>" rows="1">
													<?php echo set_value('Texto4', $query['Texto4']); ?>
												</textarea>
											</div>
										</div>
									</div>	
									<div class="row text-left">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" ></div>
										<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
											<label for="site">Seu Site?</label><br>
											<div class="btn-larg-right btn-group" data-toggle="buttons">
												<?php
												foreach ($select['site'] as $key => $row) {
													if (!$query['site']) $query['site'] = 'N';
													($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
													if ($query['site'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="site_' . $hideshow . '">'
														. '<input type="radio" name="site" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="site_' . $hideshow . '">'
														. '<input type="radio" name="site" id="' . $hideshow . '" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
										</div>
										
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
												<label></label><br>
												<span >https://enkontraki.com.br/<?php echo $_SESSION['Empresa']['Site']; ?></span>
											</div>
										
									</div>
								</div>	
							</div>	
						</div>
					</div>
				<?php } ?>	
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">
						<div class="row">
							<div class="col-md-3">
								<label for="Agrupar">Agrupar Por:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="Agrupar" name="Agrupar">
									<?php
									foreach ($select['Agrupar'] as $key => $row) {
										if ($query['Agrupar'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
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
