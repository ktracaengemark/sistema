<?php if ($msg) echo $msg; ?>
<!--<?php #echo form_open('relatorio/comissao', 'role="form"'); ?>-->
<?php echo form_open($form_open_path, 'role="form"'); ?>
<div class="col-md-12 ">		
	<?php echo validation_errors(); ?>
	<div class="row">	
		<div class="col-md-12 ">
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-2 text-left">
							<label><?php echo $titulo;?></label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" placeholder="Nº Pedido" class="form-control Numero btn-sm" name="Orcamento" id="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
							</div>
						</div>
						<div class="col-md-4 text-left">
							<!--<label><?php #echo $nome; ?></label>-->
							<label  id="Nome<?php echo $nome; ?>Auto1"><?php echo $nome; ?>: <?php echo $cadastrar['Nome'.$nome.'Auto']; ?></label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" name="id_<?php echo $nome; ?>_Auto" id="id_<?php echo $nome; ?>_Auto" value="<?php echo $cadastrar['id_'.$nome.'_Auto']; ?>" class="form-control" placeholder="Pesquisar <?php echo $nome; ?>">
								<input type="hidden" id="Nome<?php echo $nome; ?>Auto" name="Nome<?php echo $nome; ?>Auto" value="<?php echo $cadastrar['Nome'.$nome.'Auto']; ?>" />
								<input type="hidden" id="Hidden_id_<?php echo $nome; ?>_Auto" name="Hidden_id_<?php echo $nome; ?>_Auto" value="<?php echo $query['idApp_'.$nome]; ?>" />
								<input type="hidden" name="idApp_<?php echo $nome; ?>" id="idApp_<?php echo $nome; ?>" value="<?php echo $query['idApp_'.$nome]; ?>" class="form-control" readonly= "">
								<?php if($TipoRD == 2) {?>
									<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
									<input type="hidden" name="Fornecedor" id="Fornecedor" value="">
								<?php }elseif($TipoRD == 1){ ?>	
									<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
									<input type="hidden" name="Cliente" id="Cliente" value="">
								<?php } ?>
							</div>
						</div>
						<!--
						<div class="col-md-3 text-left">
							<label  id="NomeClienteAuto1">Cliente: <?php echo $cadastrar['NomeClienteAuto']; ?></label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php #echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
								<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php #echo $cadastrar['NomeClienteAuto']; ?>" />
								<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php #echo $query['idApp_Cliente']; ?>" />
								<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php #echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
							</div>
						</div>
						-->
						<?php if ($_SESSION['log']['idSis_Empresa'] == 5) { ?>
							<div class="col-md-3 text-left">
								<label for="NomeEmpresa">Empresa:</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
											id="NomeEmpresa" name="NomeEmpresa">
										<?php
										foreach ($select['NomeEmpresa'] as $key => $row) {
											if ($query['NomeEmpresa'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>	
							</div>
							<input type="hidden" name="NomeAssociado" id="NomeAssociado" value=""/>
							<input type="hidden" name="NomeUsuario" id="NomeUsuario" value="0"/>
						<?php } else { ?>
							<?php if ($metodo == 1) { ?>
								<input type="hidden" name="NomeAssociado" id="NomeAssociado" value=""/>		
								<div class="col-md-3 text-left">
									<?php if ($_SESSION['Usuario']['Permissao_Comissao'] >= 2 ) { ?>
										<label for="Ordenamento">Colaborador:</label>
										<div class="input-group">
											<span class="input-group-btn">
												<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
													<span class="glyphicon glyphicon-search"></span> 
												</button>
											</span>
											<select data-placeholder="Selecione uma opção..." class="form-control" 
													id="NomeUsuario" name="NomeUsuario">
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
									<?php } ?>	
								</div>
							<?php } else if ($metodo == 2) { ?>	
								<input type="hidden" name="NomeUsuario" id="NomeUsuario" value="0"/>
								<div class="col-md-3 text-left">
									<?php if ($_SESSION['Usuario']['Permissao_Comissao'] >= 2 ) { ?>
										<label for="Ordenamento">Associado:</label>
										<div class="input-group">
											<span class="input-group-btn">
												<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
													<span class="glyphicon glyphicon-search"></span> 
												</button>
											</span>
											<input type="text" placeholder="Pesquisar Associado" class="form-control Numero btn-sm" name="NomeAssociado" id="NomeAssociado" value="<?php echo set_value('NomeAssociado', $query['NomeAssociado']); ?>">
										</div>
									<?php } ?>	
								</div>
							<?php } else if ($metodo == 3) { ?>
								<input type="hidden" name="NomeAssociado" id="NomeAssociado" value=""/>
								<input type="hidden" name="NomeUsuario" id="NomeUsuario" value="0"/>
							<?php } ?>
							<input type="hidden" name="NomeEmpresa" id="NomeEmpresa" value=""/>
						<?php } ?>	
						<div class="col-md-3">
							<div class="col-md-4">
								<label>Filtros</label>
								<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							
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
							<?php if($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") {?>
								<?php if ($editar == 1) { ?>
									<div class="col-md-4">
										<label>Todas</label>
										<a href="<?php echo base_url() . $baixatodas . $_SESSION['log']['idSis_Empresa']; ?>">
											<button class="btn btn-success btn-md btn-block" type="button">
												<span class="glyphicon glyphicon-edit"></span>
											</button>
										</a>
									</div>	
								<?php }elseif($editar == 2){ ?>
									<div class="col-md-4">
										<label>Baixa</label>
										<a href="<?php echo base_url() . $alterar; ?>">
											<button class="btn btn-danger btn-md btn-block" type="button">
												<span class="glyphicon glyphicon-alert"></span>
											</button>
										</a>
									</div>
								<?php } ?>
							<?php } ?>	
						</div>
					</div>	
				</div>
			</div>			
		</div>
	</div>	
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
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das <?php echo $titulo; ?></h4>
			</div>
			<div class="modal-footer">
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">
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
						<div class="row">
							<?php if ($metodo == 1) { ?>
								<div class="col-md-3 text-left">
								<input type="hidden" name="StatusComissaoOrca_Online" id="StatusComissaoOrca_Online" value="0"/>
									<label for="StatusComissaoOrca">Status Comissão:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="StatusComissaoOrca" name="StatusComissaoOrca">
										<?php
										foreach ($select['StatusComissaoOrca'] as $key => $row) {
											if ($query['StatusComissaoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							<?php } else if ($metodo == 2) { ?>
								<input type="hidden" name="StatusComissaoOrca" id="StatusComissaoOrca" value="0"/>
								<div class="col-md-3 text-left">
									<label for="StatusComissaoOrca_Online">Status Comissão Online:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="StatusComissaoOrca_Online" name="StatusComissaoOrca_Online">
										<?php
										foreach ($select['StatusComissaoOrca_Online'] as $key => $row) {
											if ($query['StatusComissaoOrca_Online'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							<?php } else if ($metodo == 3) { ?>
								<div class="col-md-3 text-left">
									<input type="hidden" name="StatusComissaoOrca" id="StatusComissaoOrca" value="0"/>
									<input type="hidden" name="StatusComissaoOrca_Online" id="StatusComissaoOrca_Online" value="0"/>
								</div>
							<?php } ?>	
							<div class="col-md-3 text-left">
								<input type="hidden" name="Quitado" id="Quitado" value="0"/>
								<!--
								<label for="Quitado">Status das Parcelas</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
										id="Quitado" name="Quitado">
									<?php
									/*
									foreach ($select['Quitado'] as $key => $row) {
										if ($query['Quitado'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									*/
									?>
								</select>
								-->
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
						</div>
					</div>
				</div>
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">	
						<div class="row">	
							<div class="col-md-3">
								<label for="Ordenamento">Local da Compra</label>
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
								<label for="Ordenamento">Local da Entrega</label>
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
								<label for="Ordenamento">Local do Pagamento</label>
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
							<!--
							<div class="col-md-4">
								<label for="Ordenamento">Entregador:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="Entregador" name="Entregador">
									<?php
									foreach ($select['Entregador'] as $key => $row) {
										if ($query['Entregador'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							-->
						</div>
						<div class="row">
							<input type="hidden" name="idTab_TipoRD" id="idTab_TipoRD" value="<?php echo $TipoRD; ?>"/>	
							<div class="col-md-3">
								<label for="Ordenamento">Forma de Pagamento</label>
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
							<div class="col-md-3 text-left">
								<label for="Ordenamento">Tipo de <?php echo $TipoFinanceiro; ?>:</label>
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
								<label for="Modalidade">Dividido / Mensal:</label>
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
									<?php 
										if(isset($_SESSION['DataInicio'])){
											//$datainicio = $_SESSION['DataInicio'];
											$datainicio = $this->basico->mascara_data($_SESSION['DataInicio'], 'barras');
										}else{
											$datainicio = $query['DataInicio'];
										}
									?>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $datainicio); ?>">
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
						<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
						<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
						<input type="hidden" name="DataInicio4" id="DataInicio4" value=""/>
						<input type="hidden" name="DataFim4" id="DataFim4" value=""/>
						<?php if($metodo == 1 || $metodo == 2) { ?>
						<div class="row">
							<div class="col-md-3">
								<label for="DataInicio7">Pago.Com.Inc.</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataInicio7" value="<?php echo set_value('DataInicio7', $query['DataInicio7']); ?>">
								</div>
							</div>
							<div class="col-md-3">
								<label for="DataFim7">Pago.Com.Fim</label>
								<div class="input-group DatePicker">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											name="DataFim7" value="<?php echo set_value('DataFim7', $query['DataFim7']); ?>">
								</div>
							</div>
						</div>
						<?php }else{ ?>
							<input type="hidden" name="DataInicio7" id="DataInicio7" value=""/>
							<input type="hidden" name="DataFim7" id="DataFim7" value=""/>
						<?php } ?>
					</div>
				</div>
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">
						<?php if($metodo != 1 && $metodo != 2) { ?>
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
								<div class="col-md-3">
									<label for="Ultimo">Agrupar Pelo:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Ultimo" name="Ultimo">
										<?php
										foreach ($select['Ultimo'] as $key => $row) {
											if ($query['Ultimo'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<input type="hidden" name="nome" id="nome" value="<?php echo $nome;?>"/>
								<div class="col-md-3">
									<label for="DataInicio6">Cad.Inicio</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataInicio6" value="<?php echo set_value('DataInicio6', $query['DataInicio6']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim6">Cad.Fim</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim6" value="<?php echo set_value('DataFim6', $query['DataFim6']); ?>">
									</div>
								</div>
							</div>
						<?php }else{ ?>
							<input type="hidden" name="Agrupar" id="Agrupar" value="idApp_OrcaTrata"/>
							<input type="hidden" name="Ultimo" id="Ultimo" value="0"/>
							<input type="hidden" name="DataInicio6" id="DataInicio6" value=""/>
							<input type="hidden" name="DataFim6" id="DataFim6" value=""/>
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
				<!--
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading text-left">
						
						<div class="row">	
							<div class="col-md-12 text-left">
								<label for="Ordenamento">Produtos:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
				-->
			</div>
		</div>									
	</div>
</div>																				




