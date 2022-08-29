<?php if (isset($msg)) echo $msg; ?>
<div class="col-md-12 ">
	<?php echo form_open($form_open_path, 'role="form"'); ?>	
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<?php if($paginacao == "N") { ?>
			<div class="panel-heading">
				<div class="btn-group " role="group" aria-label="...">
					<div class="row text-left">
						<div class="col-lg-3 col-md-5 col-sm-5 col-xs-12 text-left">
							<label>Pesquisar Cliente Direto</label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" autofocus name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
							</div>
							<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
							<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
							<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
							<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
						</div>
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-left" >
								<label  for="idApp_ClientePet">Pet</label>
								<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet" onchange="this.form.submit()">
									<option value=""></option>
								</select>
								<span class="modal-title" id="Pet"></span>
							</div>
							<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-left">
								<label>Busca Pet:</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-info btn-md" type="submit">
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
						<?php }else{ ?>
							<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-left" >
									<label  for="idApp_ClienteDep">Dep</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep" onchange="this.form.submit()">
										<option value=""></option>
									</select>
									<span class="modal-title" id="Dep"></span>
								</div>
								<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-left">
									<label>Busca Dep:</label>
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-info btn-md" type="submit">
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
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left">
							<label>Pesquisar lista</label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" placeholder="Pesquisar Cliente" class="form-control btn-md " name="Pesquisa" id="Pesquisa" value="<?php echo set_value('Pesquisa', $query['Pesquisa']); ?>">
							</div>
						</div>	
						<div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 text-left">
							<label>Filtros</label><br>
							<button  class="btn btn-md btn-warning btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
						<div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 text-left">
							<label>Cadastrar</label><br>
							<button  class="btn btn-md btn-danger btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-plus"></span> Novo
							</button>
						</div>	
					</div>
				</div>
			</div>

			<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros dos Clientes</h4>
						</div>
						<div class="modal-footer">
							<div class="form-group">					
								<div class="row text-left">
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Dia">Aniv.Dia:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
												id="Dia" name="Dia">
											<?php
											foreach ($select['Dia'] as $key => $row) {
												if ($query['Dia'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Mes">Aniv.Mês:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
												id="Mes" name="Mes">
											<?php
											foreach ($select['Mes'] as $key => $row) {
												if ($query['Mes'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Ano">Aniv.Ano:</label>
										<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA" name="Ano" id="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Sexo">Sexo:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Sexo" name="Sexo">
											<?php
											foreach ($select['Sexo'] as $key => $row) {
												if ($query['Sexo'] == $key) {
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
							<div class="form-group">
								<div class="row text-left">
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="DataInicio">Dt.Cad.Ini</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
										</div>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="DataFim">Dt.Cad.Fim</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
										</div>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Ativo">Ativo?</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Ativo" name="Ativo">
											<?php
											foreach ($select['Ativo'] as $key => $row) {
												if ($query['Ativo'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Motivo">Motivo de Inativo</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Motivo" name="Motivo">
											<?php
											foreach ($select['Motivo'] as $key => $row) {
												if ($query['Motivo'] == $key) {
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
							<div class="form-group">	
								<div class="row text-left">
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="DataInicio3">Dt.Ult.Pdd.Ini: </label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
										</div>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="DataFim3">Dt.Ult.Pdd.Fim:</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
										   name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
										</div>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="DataInicio2">Dt.Cash.Iní: </label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
										</div>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="DataFim2">Dt.Cash.Fim:</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
										   name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
										</div>
									</div>
								</div>
							</div>	
							<div class="form-group">	
								<div class="row text-left">
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Pedidos">Pedidos:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Pedidos" name="Pedidos">
											<?php
											foreach ($select['Pedidos'] as $key => $row) {
												if ($query['Pedidos'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<label for="Agrupar">Agrupar Por:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Agrupar" name="Agrupar">
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
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label for="Ordenamento">Ordenamento:</label>
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
							<div class="form-group text-left">
								<label class="text-left">Texto Whatsapp:</label>
								<div class="row text-left">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-left" >
										<div class="input-group">
											<span class="input-group-addon" disabled>Tx1</span>
											<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. Olá" name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>"><?php echo set_value('Texto1', $query['Texto1']); ?></textarea>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-left" >
										<div class="">
											<input type="text" class="form-control" placeholder="Nome do Cliente" readonly="">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-left" >
										<div class="input-group">
											<span class="input-group-addon" disabled>Tx2</span>
											<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. Passando para te desejar feliz aniversário!" name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>"><?php echo set_value('Texto2', $query['Texto2']); ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row text-left">
								<br>
								<div class="form-group col-md-3">
									<div class="form-footer ">
										<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
											<span class="glyphicon glyphicon-search"></span> Pesquisar
										</button>
									</div>
								</div>
								<div class="form-group col-md-3">
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

			<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Evite cadastrar Cliente REPETIDO!<br>
													"Pesquise" os Clientes Cadastradas!</h4>
						</div>
						<div class="modal-footer">
							<div class="form-group col-md-4">
								<div class="form-footer ">
									<button type="button" class="btn btn-warning btn-block" data-dismiss="modal">
										<span class="glyphicon glyphicon-remove"></span> Pesquisar
									</button>
								</div>
							</div>
							<div class="form-group col-md-4 text-right">
								<div class="form-footer">		
									<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>cliente/cadastrar" role="button">
										<span class="glyphicon glyphicon-plus"></span> Novo Cliente
									</a>
								</div>	
							</div>
							<div class="form-group col-md-4">
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

		<?php } ?>
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</div>	

