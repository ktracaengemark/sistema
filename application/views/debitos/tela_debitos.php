<?php if ($msg) echo $msg; ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>	
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
	<?php echo validation_errors(); ?>
	<?php if($paginacao == "N") { ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
				<div class="panel panel-<?php echo $panel; ?>">
					<div class="panel-heading">	
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-left">
								<label><?php echo $titulo1;?> Despesas</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" placeholder="Pesquisar Pedido" class="form-control Numero btn-sm" autofocus name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
								</div>
							</div>	
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left">
									<label  ><?php echo $nome; ?>:</label>
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
										<input type="hidden" name="Fornecedor" id="Fornecedor" value="">
									<?php } ?>
								</div>
							<?php }else{ ?>
								<input type="hidden" name="idApp_Fornecedor" id="idApp_Fornecedor" value=""/>
								<input type="hidden" name="idApp_Fornecedor" id="idApp_Fornecedor" value=""/>
								<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
								<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-left">
								<label>Filtros</label>
								<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-left">
								<label>Balanco</label><br>
								<a href="<?php echo base_url() . 'Relatorio/balanco'; ?>">
									<button type='button' class='btn btn-md btn-primary btn-block'>
										<span class="glyphicon glyphicon-usd"></span>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>	
		<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-<?php echo $panel; ?>">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Parcelas</h4>
					</div>
					<div class="modal-footer">
						<div class="panel panel-<?php echo $panel; ?>">
							<div class="panel-heading text-left">
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<div class="row">	
									<div class="col-md-3">
										<label for="CombinadoFrete">Aprovado Entrega</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<label for="AprovadoOrca">Aprovado Pagam</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
											<label for="ConcluidoProduto">Status dos Produtos</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
									<?php }else{ ?>	
										<input type="hidden" name="ConcluidoProduto" id="ConcluidoProduto" value="0"/>
									<?php } ?>
									<div class="col-md-3 text-left">
										<label for="Quitado">Status das Parcelas</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
												id="Quitado" name="Quitado">
											<?php
											foreach ($select['Quitado'] as $key => $row) {
												if ($query['Quitado'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
										<div class="col-md-3">
											<label for="FinalizadoOrca">Finalizado</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<label for="Ordenamento">Local da Compra</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
										<label for="Ordenamento">Forma de Pagamento</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
								<?php } ?>
								<div class="row">
									<input type="hidden" name="idTab_TipoRD" id="idTab_TipoRD" value="<?php echo $TipoRD; ?>"/>
									<div class="col-md-3 text-left">
										<label for="Ordenamento">Tipo de <?php echo $TipoFinanceiro; ?>:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
										<label for="Modalidade">Dividido / Mensal</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
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
										<label for="Produtos">Produtos & Servi�os:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
									<div class="col-md-3">
										<label for="Parcelas">Parcelas:</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
												id="Parcelas" name="Parcelas">
											<?php
											foreach ($select['Parcelas'] as $key => $row) {
												if ($query['Parcelas'] == $key) {
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
									<div class="col-md-3">
										<label for="HoraInicio5">Hora Inc.</label>
										<div class="input-group TimePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-time"></span>
											</span>
											<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM"
													name="HoraInicio5" value="<?php echo set_value('HoraInicio5', $query['HoraInicio5']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="HoraFim5">Hora Fim</label>
										<div class="input-group TimePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-time"></span>
											</span>
											<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM"
													name="HoraFim5" value="<?php echo set_value('HoraFim5', $query['HoraFim5']); ?>">
										</div>
									</div>
									<?php }else{ ?>
									<input type="hidden" name="DataInicio2" id="DataInicio2" value=""/>
									<input type="hidden" name="DataFim2" id="DataFim2" value=""/>
									<?php } ?>
								</div>	
								<div class="row">
									<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
									<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
									<div class="col-md-3">
										<label for="DataInicio4">Vencimento Inc.</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataInicio4" value="<?php echo set_value('DataInicio4', $query['DataInicio4']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataFim4">Vencimento Fim</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim4" value="<?php echo set_value('DataFim4', $query['DataFim4']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataInicio5">Pagamento Inc.</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataInicio5" value="<?php echo set_value('DataInicio5', $query['DataInicio5']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataFim5">Pagamento Fim</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim5" value="<?php echo set_value('DataFim5', $query['DataFim5']); ?>">
										</div>
									</div>
									
									<div class="col-md-3">
										<label for="DataInicio8">Lancamento Inc.</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataInicio8" value="<?php echo set_value('DataInicio8', $query['DataInicio8']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataFim8">Lancamento Fim</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim8" value="<?php echo set_value('DataFim8', $query['DataFim8']); ?>">
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<div class="panel panel-<?php echo $panel; ?>">
							<div class="panel-heading text-left">
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
									<div class="row">	
										<div class="col-md-3">
											<label for="Agrupar">Agrupar Por:</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
									<br>
									<label class="text-left">Texto Whatsapp:</label>
									<div class="row text-left">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
											<div class="input-group">
												<span class="input-group-addon" disabled>Tx1</span>
												<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. Ol�" name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>"><?php echo set_value('Texto1', $query['Texto1']); ?></textarea>
											</div>
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
										<!--
										<div class="text-left" id="nomedoFornecedor" <?php #echo $div['nomedoFornecedor']; ?>>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
												<div class="">
													<input type="text" class="form-control" placeholder="Nome do Fornecedor" readonly="">
												</div>
											</div>
										</div>
										-->
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
											<div class="input-group">
												<span class="input-group-addon" disabled>Tx2</span>
												<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>"><?php echo set_value('Texto2', $query['Texto2']); ?></textarea>
											</div>
										</div>
										<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
											<label for="numerodopedido">Numero do Pedido?</label><br>
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
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
											<div class="input-group">
												<span class="input-group-addon" disabled>Tx3</span>
												<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" name="Texto3" id="Texto3" value="<?php echo set_value('Texto3', $query['Texto3']); ?>"><?php echo set_value('Texto3', $query['Texto3']); ?></textarea>
											</div>
										</div>
									</div>
									<br>
								<?php }else{ ?>
									<input type="hidden" name="Agrupar" id="Agrupar" value=""/>
									<input type="hidden" name="Ultimo" id="Ultimo" value=""/>
									<input type="hidden" name="DataInicio6" id="DataInicio6" value=""/>
									<input type="hidden" name="DataFim6" id="DataFim6" value=""/>
								<?php } ?>						
								<div class="row">				
									<div class="col-md-6 text-left">
										<label for="Ordenamento">Ordenamento:</label>
										<div class="form-group btn-block">
											<div class="row">
												<div class="col-md-6">
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
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
													<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
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

