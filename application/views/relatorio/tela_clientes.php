<?php if (isset($msg)) echo $msg; ?>
<div class="col-md-12 ">
<?php #echo form_open('relatorio/clientes', 'role="form"'); ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>	
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<?php if($paginacao == "N") { ?>
			<div class="panel-heading">
				<div class="btn-group " role="group" aria-label="...">
					<div class="row text-left">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left">
							<label>Filtros</label>
							<button  class="btn btn-md btn-warning btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
						<!--
						<div class="col-md-2 text-left">
							<label></label><br>
							<a href="<?php echo base_url() . 'gerar_excel/Clientes/Clientes.php'; ?>">
								<button type='button' class='btn btn-md btn-success btn-block'>
									Exprtar Excel
								</button>
							</a>
						</div>
						
						<div class="col-md-2 text-left">
							<label></label><br>
							<a href="<?php echo base_url() . 'gerar_excel/Clientes/export.php'; ?>">
								<button type='button' class='btn btn-md btn-success btn-block'>
									Gerar XLSX
								</button>
							</a>
						</div>
						-->
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
							<label >Cliente:</label>
							<div class="input-group">
								<input type="text" autofocus name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
							</div>
							<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
							<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
							<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
							<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
						</div>
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 text-left">
								<label >Pet:</label>
								<div class="input-group">
									<input type="text" name="id_ClientePet_Auto" id="id_ClientePet_Auto" value="<?php echo $cadastrar['id_ClientePet_Auto']; ?>" class="form-control" placeholder="Pesquisar ClientePet">
									<span class="input-group-btn">
										<button class="btn btn-info btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
								</div>
								<span class="modal-title" id="NomeClientePetAuto1"><?php echo $cadastrar['NomeClientePetAuto']; ?></span>
								<input type="hidden" id="NomeClientePetAuto" name="NomeClientePetAuto" value="<?php echo $cadastrar['NomeClientePetAuto']; ?>" />
								<input type="hidden" id="Hidden_id_Cliente_AutoPet" name="Hidden_id_Cliente_AutoPet" value="<?php echo $query['idApp_ClientePet']; ?>" />
								<input type="hidden" name="idApp_ClientePet" id="idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" class="form-control" readonly= "">
							</div>
						<?php }else{ ?>
							<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 text-left">
									<label >Dep:</label>
									<div class="input-group">
										<input type="text" name="id_ClienteDep_Auto" id="id_ClienteDep_Auto" value="<?php echo $cadastrar['id_ClienteDep_Auto']; ?>" class="form-control" placeholder="Pesquisar ClienteDep">
										<span class="input-group-btn">
											<button class="btn btn-info btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
									</div>
									<span class="modal-title" id="NomeClienteDepAuto1"><?php echo $cadastrar['NomeClienteDepAuto']; ?></span>
									<input type="hidden" id="NomeClienteDepAuto" name="NomeClienteDepAuto" value="<?php echo $cadastrar['NomeClienteDepAuto']; ?>" />
									<input type="hidden" id="Hidden_id_Cliente_AutoDep" name="Hidden_id_Cliente_AutoDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
									<input type="hidden" name="idApp_ClienteDep" id="idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" class="form-control" readonly= "">
								</div>
							<?php } ?>
						<?php } ?>
						<!--
						<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span> Novo Cliente
						</button>
						-->
					</div>
				</div>
			</div>
		<?php } ?>
		<?php echo (isset($list)) ? $list : FALSE ?>	
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
						
												
					
						<!--
						<div class="col-md-8">
							<label for="NomeCliente">Cliente</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()" id="NomeCliente" autofocus name="NomeCliente">
								<?php
								/*
								foreach ($select['NomeCliente'] as $key => $row) {
									if ($query['NomeCliente'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								*/
								?>
							</select>
						</div>
						-->
					</div>
				</div>
						
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Aniversario">Aniversário:</label>					
							<div class="row text-left">
								<div class="col-md-3 text-left" >
									<label for="Dia">Dia:</label>
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
								<div class="col-md-3 text-left" >
									<label for="Mesvenc">Mês:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Mesvenc" name="Mesvenc">
										<?php
										foreach ($select['Mesvenc'] as $key => $row) {
											if ($query['Mesvenc'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left" >
									<label for="Ano">Ano:</label>
									<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
											   name="Ano" id="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Cadastro">Cadastro:</label>
							<div class="row text-left">
								<div class="col-md-3">
									<label for="DataInicio">Incício</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim">Fim</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									</div>
								</div>
								<div class="col-md-3 text-left">
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
								<div class="col-md-3 text-left">
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
					</div>
				</div>
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Ordenamento">Ordenamento:</label>
							<div class="row">
								<div class="col-md-3">
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

								<div class="col-md-3">
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

				<div class="row text-left">
					<br>
					<div class="form-group col-md-3">
						<div class="form-footer ">
							<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-search"></span> Pesquisar
							</button>
						</div>
					</div>
					<!--
					<div class="form-group col-md-4">
						<div class="form-footer">		
							<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/aniversario" role="button">
								<span class="glyphicon glyphicon-search"></span> Aniversário
							</a>
						</div>	
					</div>
					-->
					<!--
					<div class="form-group col-md-3">
						<div class="form-footer">		
							<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-plus"></span> Novo Cliente
							</button>							
						</div>	
					</div>
					-->
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
			<!--
			<div class="modal-body">
				<p>Pesquise os Produtos Cadastrados!!</p>
			</div>
			-->
			<div class="modal-footer">
				<div class="form-group col-md-4 text-left">
					<div class="form-footer">
						<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
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
	

