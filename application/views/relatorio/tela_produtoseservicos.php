<?php if ($msg) echo $msg; ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>	
<div class="col-md-12">		
	<?php echo validation_errors(); ?>
	<?php if($paginacao == "N") { ?>	
		<div class="row">
			<div class="col-md-12 ">
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-2 text-left">
								<label><?php echo $titulo1;?></label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" placeholder="Pesquisar Pedido" class="form-control Numero btn-sm" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
								</div>
							</div>	
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left">
									<label  ><?php echo $nome; ?>: </label>
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
										<input type="text" name="id_<?php echo $nome; ?>_Auto" id="id_<?php echo $nome; ?>_Auto" value="<?php echo $cadastrar['id_'.$nome.'_Auto']; ?>" class="form-control" placeholder="Pesquisar <?php echo $nome; ?>">
									</div>
									<span class="modal-title" id="Nome<?php echo $nome; ?>Auto1"><?php echo $cadastrar['Nome'.$nome.'Auto']; ?></span>
									<input type="hidden" id="Nome<?php echo $nome; ?>Auto" name="Nome<?php echo $nome; ?>Auto" value="<?php echo $cadastrar['Nome'.$nome.'Auto']; ?>" />
									<input type="hidden" id="Hidden_id_<?php echo $nome; ?>_Auto" name="Hidden_id_<?php echo $nome; ?>_Auto" value="<?php echo $query['idApp_'.$nome]; ?>" />
									<input type="hidden" name="idApp_<?php echo $nome; ?>" id="idApp_<?php echo $nome; ?>" value="<?php echo $query['idApp_'.$nome]; ?>" class="form-control" readonly= "">										
									<?php if($metodo == 2) {?>
										<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
										<input type="hidden" name="Fornecedor" id="Fornecedor" value="">
									<?php }elseif($metodo == 1){ ?>	
										<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
										<input type="hidden" name="Cliente" id="Cliente" value="">
									<?php } ?>
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
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left">
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
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-left" >
											<label  for="idApp_ClienteDep">Dep</label>
											<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep" onchange="this.form.submit()">
												<option value=""></option>
											</select>
											<span class="modal-title" id="Dep"></span>
										</div>
										<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left">
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
							<?php }else{ ?>
								<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value=""/>
								<input type="hidden" name="idApp_Fornecedor" id="idApp_Fornecedor" value=""/>
								<input type="hidden" name="Cliente" id="Cliente" value=""/>
								<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
								<input type="hidden" name="idApp_ClientePet" id="idApp_ClientePet" value="" />
								<input type="hidden" name="idApp_ClienteDep" id="idApp_ClienteDep" value="" />
								<input type="hidden" name="idApp_ClientePet2" id="idApp_ClientePet2" value="" />
								<input type="hidden" name="idApp_ClienteDep2" id="idApp_ClienteDep2" value="" />
							<?php } ?>
							<div class="col-md-2">
								<label>Filtros</label>
								<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							<?php if ($editar == 1) { ?>
								<?php if ($print == 1) { ?>	
									<div class="col-md-2">
										<label>Imprimir</label>
										<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
											<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
												<span class="glyphicon glyphicon-print"></span>
											</button>
										</a>
									</div>
								<?php } ?>	
								<div class="col-md-2">
									<label>Baixa</label>
									<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
										<button class="btn btn-success btn-md btn-block" type="button">
											<span class="glyphicon glyphicon-edit"></span>
										</button>
									</a>
								</div>	
							<?php } ?>	
						</div>
					</div>
				</div>
			</div>	
		</div>
	<?php } ?>	
	<div class="row">	
		<div class="col-md-12 ">
			<?php echo (isset($list1)) ? $list1 : FALSE ?>
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
						<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
						<div class="row">	
							<div class="col-md-3">
								<label for="CombinadoFrete">Combinado</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="CombinadoFrete" name="CombinadoFrete">
									<?php
									foreach ($select['CombinadoFrete'] as $key => $row) {
										if ($query['CombinadoFrete'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="AprovadoOrca">Aprovado</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="AprovadoOrca" name="AprovadoOrca">
									<?php
									foreach ($select['AprovadoOrca'] as $key => $row) {
										if ($query['AprovadoOrca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="ConcluidoOrca">Entregue</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="ConcluidoOrca" name="ConcluidoOrca">
									<?php
									foreach ($select['ConcluidoOrca'] as $key => $row) {
										if ($query['ConcluidoOrca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="QuitadoOrca">Pago</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="QuitadoOrca" name="QuitadoOrca">
									<?php
									foreach ($select['QuitadoOrca'] as $key => $row) {
										if ($query['QuitadoOrca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<?php }else{ ?>
							<input type="hidden" name="CombinadoFrete" id="CombinadoFrete" value="0"/>
							<input type="hidden" name="AprovadoOrca" id="AprovadoOrca" value="0"/>
							<input type="hidden" name="ConcluidoOrca" id="ConcluidoOrca" value="0"/>
							<input type="hidden" name="QuitadoOrca" id="QuitadoOrca" value="0"/>
						<?php } ?>
						<div class="row">
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<div class="col-md-3 text-left">
									<label for="Prod_Serv_Produto">Prod/Serv</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="Prod_Serv_Produto" name="Prod_Serv_Produto">
										<?php
										foreach ($select['Prod_Serv_Produto'] as $key => $row) {
											if ($query['Prod_Serv_Produto'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="ConcluidoProduto">Stts Ent Prod/Serv</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="ConcluidoProduto" name="ConcluidoProduto">
										<?php
										foreach ($select['ConcluidoProduto'] as $key => $row) {
											if ($query['ConcluidoProduto'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="FinalizadoOrca">Finalizado</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="FinalizadoOrca" name="FinalizadoOrca">
										<?php
										foreach ($select['FinalizadoOrca'] as $key => $row) {
											if ($query['FinalizadoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>	
								<div class="col-md-3">
									<label for="CanceladoOrca">Cancelado</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="CanceladoOrca" name="CanceladoOrca">
										<?php
										foreach ($select['CanceladoOrca'] as $key => $row) {
											if ($query['CanceladoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							<?php }else{ ?>
								<input type="hidden" name="Prod_Serv_Produto" id="Prod_Serv_Produto" value="0"/>
								<input type="hidden" name="ConcluidoProduto" id="ConcluidoProduto" value="0"/>
								<input type="hidden" name="FinalizadoOrca" id="FinalizadoOrca" value="0"/>
								<input type="hidden" name="CanceladoOrca" id="CanceladoOrca" value="0"/>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">	
						<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
						<div class="row">	
							<div class="col-md-3">
								<label for="Ordenamento">Compra</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="Tipo_Orca" name="Tipo_Orca">
									<?php
									foreach ($select['Tipo_Orca'] as $key => $row) {
										if ($query['Tipo_Orca'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Ordenamento">Entrega</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="TipoFrete" name="TipoFrete">
									<?php
									foreach ($select['TipoFrete'] as $key => $row) {
										if ($query['TipoFrete'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>	
							<div class="col-md-3">
								<label for="Ordenamento">Pagamento</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="AVAP" name="AVAP">
									<?php
									foreach ($select['AVAP'] as $key => $row) {
										if ($query['AVAP'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="Ordenamento">Forma de Pag.</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="FormaPagamento" name="FormaPagamento">
									<?php
									foreach ($select['FormaPagamento'] as $key => $row) {
										if ($query['FormaPagamento'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<?php }else{ ?>
							<input type="hidden" name="Tipo_Orca" id="Tipo_Orca" value="0"/>
							<input type="hidden" name="TipoFrete" id="TipoFrete" value="0"/>
							<input type="hidden" name="AVAP" id="AVAP" value="0"/>
							<input type="hidden" name="FormaPagamento" id="FormaPagamento" value="0"/>
						<?php } ?>
						<div class="row">
							<input type="hidden" name="idTab_TipoRD" id="idTab_TipoRD" value="<?php echo $TipoRD; ?>"/>
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Tipo <?php echo $TipoFinanceiro; ?>:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="TipoFinanceiro" name="TipoFinanceiro">
									<?php
									foreach ($select[$TipoFinanceiro] as $key => $row) {
										if ($query['TipoFinanceiro'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3 text-left">
								<label for="Modalidade">Modalidade:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Modalidade" name="Modalidade">
									<?php
									foreach ($select['Modalidade'] as $key => $row) {
										if ($query['Modalidade'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-3 text-left">
								<label for="Categoria">Categoria:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
										id="Categoria" name="Categoria">
									<?php
									foreach ($select['Categoria'] as $key => $row) {
										if ($query['Categoria'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>	
							</div>
							<div class="col-md-3 text-left">
								<label for="Produtos">Produto:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
										id="Produtos" name="Produtos">
									<?php
									foreach ($select['Produtos'] as $key => $row) {
										if ($query['Produtos'] == $key) {
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
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">
						<div class="row">
							<div class="col-md-3">
								<label for="DataInicio"><?php echo $TipoFinanceiro;?> Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim"><?php echo $TipoFinanceiro;?> Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
								</div>
							</div>
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
							<div class="col-md-3">
								<label for="DataInicio2">Entrega Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim2">Entrega Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-6"></div>
							<div class="col-md-3">
								<label for="DataInicio8">Data Entregue Prd Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio8" value="<?php echo set_value('DataInicio8', $query['DataInicio8']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim8">Data Entregue Prd Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim8" value="<?php echo set_value('DataFim8', $query['DataFim8']); ?>">
								</div>
							</div>
								<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
								<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
								<input type="hidden" name="DataInicio4" id="DataInicio4" value=""/>
								<input type="hidden" name="DataFim4" id="DataFim4" value=""/>
							<?php }else{ ?>
								<input type="hidden" name="DataInicio2" id="DataInicio2" value=""/>
								<input type="hidden" name="DataFim2" id="DataFim2" value=""/>
								<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
								<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
								<input type="hidden" name="DataInicio4" id="DataInicio4" value=""/>
								<input type="hidden" name="DataFim4" id="DataFim4" value=""/>
							<?php } ?>
						</div>
					</div>
				</div>
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
								<div class="row">
									<div class="col-md-6">
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
							<div class="form-footer col-md-3">
							<label></label><br>
								<button class="btn btn-<?php echo $panel;?> btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-search"></span> Filtrar
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
