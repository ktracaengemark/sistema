<?php if ($msg) echo $msg; ?>
<?php #echo form_open('relatorio/cobrancas', 'role="form"'); ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>	
<div class="col-md-12">		
	<?php echo validation_errors(); ?>
	<?php if($paginacao == "N") { ?>
		<div class="panel panel-<?php echo $panel; ?>">
			<div class="panel-heading">
				<div class="row">
					<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-left" >
							<label class="" for="Ordenamento">Profissional:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="NomeUsuario" name="NomeUsuario"><!--onchange="this.form.submit()"-->
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
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 text-left" >
							<label class="" for="Tipo">Agendamento:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Tipo" name="Tipo">
								<?php
								foreach ($select['Tipo'] as $key => $row) {
									if ($query['Tipo'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 text-left" >
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
					<?php } ?>
					<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 text-left">	
						<label for="Recorrencia">Recor.</label>
						<input type="text" class="form-control " maxlength="7" placeholder="Ex: 4/4, 2/2" name="Recorrencia" id="Recorrencia" value="<?php echo set_value('Recorrencia', $query['Recorrencia']); ?>">
					</div>
					<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 text-left">	
						<label for="Repeticao">Repeticao</label>
						<input type="text" class="form-control " name="Repeticao" id="Repeticao" value="<?php echo set_value('Repeticao', $query['Repeticao']); ?>">
					</div>
				</div>	
				<div class="row">
					<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 text-left">
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
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
							
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left" >
								<label  for="idApp_ClientePet">Pet</label>
								<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet" onchange="this.form.submit()">
									<option value=""></option>
								</select>
								<span class="modal-title" id="Pet"></span>
							</div>
							<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
							
							<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-left">
								<label>Busca Pet:</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-primary btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" class="form-control" name="id_ClientePet_Auto" id="id_ClientePet_Auto" value="<?php echo $cadastrar['id_ClientePet_Auto']; ?>"  placeholder="Pesquisar Pet">
								</div>
								<span class="modal-title" id="NomeClientePetAuto1"><?php echo $cadastrar['NomeClientePetAuto']; ?></span>
								<input type="hidden" id="NomeClientePetAuto" name="NomeClientePetAuto" value="<?php echo $cadastrar['NomeClientePetAuto']; ?>" />
								<input type="hidden" id="Hidden_id_ClientePet_Auto" name="Hidden_id_ClientePet_Auto" value="<?php echo $query['idApp_ClientePet2']; ?>" />
								<input type="hidden" name="idApp_ClientePet2" id="idApp_ClientePet2" value="<?php echo $query['idApp_ClientePet2']; ?>" class="form-control" readonly= "">
							</div>
						<?php } else { ?>
							<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
								
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left" >
									<label  for="idApp_ClienteDep">Dep</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep" onchange="this.form.submit()">
										<option value=""></option>
									</select>
									<span class="modal-title" id="Dep"></span>
								</div>
								<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
								
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-left">
									<label>Busca Dep:</label>
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-primary btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
										<input type="text" class="form-control" name="id_ClienteDep_Auto" id="id_ClienteDep_Auto" value="<?php echo $cadastrar['id_ClienteDep_Auto']; ?>"  placeholder="Pesquisar Dep">
									</div>
									<span class="modal-title" id="NomeClienteDepAuto1"><?php echo $cadastrar['NomeClienteDepAuto']; ?></span>
									<input type="hidden" id="NomeClienteDepAuto" name="NomeClienteDepAuto" value="<?php echo $cadastrar['NomeClienteDepAuto']; ?>" />
									<input type="hidden" id="Hidden_id_ClienteDep_Auto" name="Hidden_id_ClienteDep_Auto" value="<?php echo $query['idApp_ClienteDep2']; ?>" />
									<input type="hidden" name="idApp_ClienteDep2" id="idApp_ClienteDep2" value="<?php echo $query['idApp_ClienteDep2']; ?>" class="form-control" readonly= "">
								</div>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>	
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-left">	
						<label for="DataInicio"><?php echo $Data;?> Inc.</label>
						<div class="input-group DatePicker">
							<span class="input-group-addon" disabled>
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-left">	
						<label for="DataFim"><?php echo $Data;?> Fim</label>
						<div class="input-group DatePicker">
							<span class="input-group-addon" disabled>
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
						</div>
					</div>	
					<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
						<label>Filtros</label>
						<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span>
						</button>	
					</div>
				</div>	
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
								<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left" >
											<label class="text-left">Texto Whatsapp:</label>
											<div class="row text-left">
												<div class="col-lg-9 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label>t1</label><br>
													<input type="text" class="form-control" maxlength="200" placeholder="Ex. Olá" 
														name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
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
											</div>	
											<div class="row text-left">
												<div class="col-lg-9 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label>t2</label><br>
													<input type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
														name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label for="datahora">Data & Hora?</label><br>
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['datahora'] as $key => $row) {
															if (!$query['datahora']) $query['datahora'] = 'N';
															($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
															if ($query['datahora'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="datahora_' . $hideshow . '">'
																. '<input type="radio" name="datahora" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="datahora_' . $hideshow . '">'
																. '<input type="radio" name="datahora" id="' . $hideshow . '" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="row text-left">
												<div class="col-lg-9 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label>t3</label><br>
													<input type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
														name="Texto3" id="Texto3" value="<?php echo set_value('Texto3', $query['Texto3']); ?>">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label for="id<?php echo $nome?>">id do <?php echo $nome?>?</label><br>
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
											</div>
											<div class="row text-left">
												<div class="col-lg-9 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label>t4</label><br>
													<input type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
														name="Texto4" id="Texto4" value="<?php echo set_value('Texto4', $query['Texto4']); ?>">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label for="numerodopedido">id-Agenda?</label><br>
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
											</div>
											<div class="row text-left">
												<div class="col-lg-9 col-md-3 col-sm-12 col-xs-12 text-left" >
													<label>t5</label><br>
													<input type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" 
														name="Texto5" id="Texto5" value="<?php echo set_value('Texto5', $query['Texto5']); ?>">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
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
											</div>		
											<div class="row text-left">
												
													<div class="col-lg-12 col-md-3 col-sm-12 col-xs-12 text-left" >
														<label></label><br>
														<span >https://enkontraki.com.br/<?php echo $_SESSION['Empresa']['Site']; ?></span>
													</div>
												
											</div>
										</div>	
									</div>
									<br>
								<?php } ?>					
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
	<?php } ?>
	<?php echo (isset($list1)) ? $list1 : FALSE ?>
</div>

</form>
