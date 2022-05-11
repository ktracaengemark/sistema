<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">	
	<div class="row">
	
		<div class="col-md-1"></div>
		<div class="col-md-10 ">

			<?php echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

					<!--App_Despesas-->

						<div class="form-group">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div class="row">														
										<!--<div class="col-md-2">
											<label for="DataEntradaDespesas">Validade do Or�.:</label>
											<div class="input-group <?php echo $datepicker; ?>">
												<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
													   name="DataEntradaDespesas" value="<?php echo $despesas['DataEntradaDespesas']; ?>">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
										<div class="col-md-3">
											<label for="ProfissionalDespesas">Profissional:</label>
											<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
												<span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
											</a>
											<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
													id="ProfissionalDespesas" autofocus name="ProfissionalDespesas">
												<option value="">-- Selecione uma op��o --</option>
												<?php
												foreach ($select['Profissional'] as $key => $row) {
													if ($despesas['ProfissionalDespesas'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										-->
										<div class="col-md-4">
											<label for="TipoDespesa">Tipo de Devolu��o</label>
											<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>tipodespesa/cadastrar/tipodespesa" role="button">
												<span class="glyphicon glyphicon-plus"></span> <b>Forma Pag</b>
											</a>-->
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
													id="TipoDespesa" name="TipoDespesa">
												<option value="">-- Sel. Tipo de Devolu��o --</option>
												<?php
												foreach ($select['TipoDespesa'] as $key => $row) {
													if ($despesas['TipoDespesa'] == $key) {
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
											<label for="idApp_Cliente">Cliente</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
													id="idApp_Cliente" name="idApp_Cliente">
												<option value="">-- Sel. um Cliente --</option>
												<?php
												foreach ($select['idApp_Cliente'] as $key => $row) {
													if ($despesas['idApp_Cliente'] == $key) {
														echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
													} else {
														echo '<option value="' . $key . '">' . $row . '</option>';
													}
												}
												?>
											</select>
										</div>
										-->
										<div class="col-md-4">
											<label for="Despesa">Descri��o</label><br>
											<input type="text" class="form-control" maxlength="200"
													name="Despesa" value="<?php echo $despesas['Despesa'] ?>">
										</div>
										<div class="col-md-4">
											<label for="idApp_OrcaTrata">Or�am</label>
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
													id="idApp_OrcaTrata" name="idApp_OrcaTrata">
												<option value="">-- Sel. um Or�am. --</option>
												<?php
												foreach ($select['idApp_OrcaTrata'] as $key => $row) {
													if ($despesas['idApp_OrcaTrata'] == $key) {
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
											
						<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
							<div class="panel panel-info">
								<div class="panel-heading collapsed" role="tab" id="heading1" data-toggle="collapse" data-parent="#accordion1" data-target="#collapse1" aria-expanded="false">								<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Produtos
										</a>
									</h4>
								</div>

								<div id="collapse1" class="panel-collapse" role="tabpanel" aria-labelledby="heading1" aria-expanded="false">
									<div class="panel-body">

										<!--#######################################-->

										<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

										<div class="input_fields_wrap5">

										<?php
										for ($i=1; $i <= $count['SCount']; $i++) {
										?>

										<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_ServicoCompra<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_ServicoCompra']; ?>"/>
										<?php } ?>

										<div class="form-group" id="5div<?php echo $i ?>">
											<div class="panel panel-info">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-2">
															<label for="QtdCompraServico">Qtd:</label>
															<input type="text" class="form-control Numero" maxlength="3" id="QtdCompraServico<?php echo $i ?>" placeholder="0"
																	onkeyup="calculaSubtotalCompra(this.value,this.name,'<?php echo $i ?>','QTD','Servico')"
																	autofocus name="QtdCompraServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdCompraServico'] ?>">
														</div>
														<div class="col-md-4">
															<label for="idTab_Servico">Servi�o:</label>
															<?php if ($i == 1) { ?>
															<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button">
																<span class="glyphicon glyphicon-plus"></span> <b>Novo Servi�o</b>
															</a>
															<?php } ?>
															<select data-placeholder="Selecione uma op��o..." class="form-control" onchange="buscaValorCompra(this.value,this.name,'Servico',<?php echo $i ?>)" <?php echo $readonly; ?>
																	id="lista" name="idTab_Servico<?php echo $i ?>">
																<option value="">-- Selecione uma op��o --</option>
																<?php
																foreach ($select['Servico'] as $key => $row) {
																	if ($servico[$i]['idTab_Servico'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-3">
															<label for="ValorCompraServico">Valor do Servi�o:</label>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																	onkeyup="calculaSubtotalCompra(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
																	name="ValorCompraServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorCompraServico'] ?>">
															</div>

														</div>												
														<div class="col-md-3">
															<label for="SubtotalServico">Subtotal:</label>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
																	   name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalServico'] ?>">
															</div>
														</div>													
													</div>
													<div class="row">
														<div class="col-md-6">
															<label for="ObsServico<?php echo $i ?>">Obs:</label><br>
															<input type="text" class="form-control" id="ObsServico<?php echo $i ?>" maxlength="250"
																   name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsServico'] ?>">
														</div>
														<div class="col-md-3">
															<label for="ConcluidoServico">Conclu�do? </label><br>
															<div class="form-group">
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['ConcluidoServico'] as $key => $row) {
																		(!$servico[$i]['ConcluidoServico']) ? $servico[$i]['ConcluidoServico'] = 'N' : FALSE;

																		if ($servico[$i]['ConcluidoServico'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="radiobutton_ConcluidoServico' . $i . '" id="radiobutton_ConcluidoServico' . $i .  $key . '">'
																			. '<input type="radio" name="ConcluidoServico' . $i . '" id="radiobuttondinamico" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radiobutton_ConcluidoServico' . $i . '" id="radiobutton_ConcluidoServico' . $i .  $key . '">'
																			. '<input type="radio" name="ConcluidoServico' . $i . '" id="radiobuttondinamico" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<label><br></label><br>
															<button type="button" id="<?php echo $i ?>" class="remove_field5 btn btn-danger">
																<span class="glyphicon glyphicon-trash"></span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>

										<?php
										}
										?>

										</div>
										<!--
										<div class="form-group">
											<div class="row">
												<div class="col-md-4">
													<a class="btn btn-xs btn-warning" onclick="adicionaServicoCompra()">
														<span class="glyphicon glyphicon-plus"></span> Adicionar Servi�o
													</a>
												</div>
											</div>
										</div>
										
										<hr>
										-->
										<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>

										<div class="input_fields_wrap6">

										<?php
										for ($i=1; $i <= $count['PCount']; $i++) {
										?>

										<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_ProdutoCompra<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_ProdutoCompra']; ?>"/>
										<?php } ?>

										<div class="form-group" id="6div<?php echo $i ?>">
											<div class="panel panel-danger">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-1">
															<label for="QtdCompraProduto">Qtd:</label>
															<input type="text" class="form-control Numero" maxlength="3" id="QtdCompraProduto<?php echo $i ?>" placeholder="0"
																	onkeyup="calculaSubtotalCompra(this.value,this.name,'<?php echo $i ?>','QTD','Produto')"
																	autofocus name="QtdCompraProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdCompraProduto'] ?>">
														</div>
														<div class="col-md-4">
															<label for="idTab_Produto">Produto:</label>
															<?php if ($i == 1) { ?>
															<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
																<span class="glyphicon glyphicon-plus"></span> <b>Novo Produto</b>
															</a>-->
															<?php } ?>
															<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" onchange="buscaValorCompra(this.value,this.name,'Produto',<?php echo $i ?>)" <?php echo $readonly; ?>
																	 id="listadinamicab<?php echo $i ?>" name="idTab_Produto<?php echo $i ?>">
																<option value="">-- Selecione uma op��o --</option>
																<?php
																foreach ($select['Produto'] as $key => $row) {
																	if ($produto[$i]['idTab_Produto'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>

														<div class="col-md-2">
															<label for="ValorCompraProduto">Valor do Produto:</label>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																	onkeyup="calculaSubtotalCompra(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
																	name="ValorCompraProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorCompraProduto'] ?>">
															</div>
														</div>													
														<div class="col-md-2">
															<label for="SubtotalProduto">Subtotal:</label>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																	   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<label for="DataValidadeProduto<?php echo $i ?>">Val. do Produto:</label>
															<div class="input-group <?php echo $datepicker; ?>">
																<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																	   name="DataValidadeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataValidadeProduto']; ?>">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
															</div>
														</div>
														<div class="col-md-1">
															<label><br></label><br>
															<button type="button" id="<?php echo $i ?>" class="remove_field6 btn btn-danger">
																<span class="glyphicon glyphicon-trash"></span>
															</button>
														</div>														
													</div>										
												</div>
											</div>
										</div>

										<?php
										}
										?>

										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-md-4">
													<a class="add_field_button6 btn btn-danger">
														<span class="glyphicon glyphicon-plus"></span> Adic. Produtos
													</a>
												</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
						</div>
			<!--#######################################-->					
						
						<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
							<div class="panel panel-info">
								<div class="panel-heading collapsed" role="tab" id="heading4" data-toggle="collapse" data-parent="#accordion4" data-target="#collapse4" aria-expanded="false">								<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Or�amento & Forma de Pagam.
										</a>
									</h4>
								</div>

								<div id="collapse4" class="panel-collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
									<div class="panel-body">
										<div class="form-group">
											<div class="panel panel-danger">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-3">
															<label for="ValorDespesas">Valor da Devol.:</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorDespesas" maxlength="10" placeholder="0,00" 
																	   name="ValorDespesas" value="<?php echo $despesas['ValorDespesas'] ?>">
															</div>
														</div>
														
														<div class="col-md-3">
															<label for="ValorEntradaDespesas">Desconto</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorEntradaDespesas" maxlength="10" placeholder="0,00"
																	onkeyup="calculaRestaDespesas(this.value)"
																	name="ValorEntradaDespesas" value="<?php echo $despesas['ValorEntradaDespesas'] ?>">
															</div>
														</div>
														
														<div class="col-md-3">
															<label for="ValorRestanteDespesas">Valor A Pagar:</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="ValorRestanteDespesas" maxlength="10" placeholder="0,00" readonly=""
																	   name="ValorRestanteDespesas" value="<?php echo $despesas['ValorRestanteDespesas'] ?>">
															</div>
														</div>
													</div>
												</div>
											</div>	
										</div>		
									</div>
									<div class="panel-body">	
										<div class="form-group">
											<div class="panel panel-danger">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-3">
															<label for="QtdParcelasDespesas">Qtd. Parc.:</label><br>
															<input type="text" class="form-control Numero" id="QtdParcelasDespesas" maxlength="3" placeholder="0"
																   name="QtdParcelasDespesas" value="<?php echo $despesas['QtdParcelasDespesas'] ?>">
														</div>
														<div class="col-md-3">
															<label for="FormaPagamentoDespesas">Forma de Pagamento:</label>
															<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
																	id="FormaPagamentoDespesas" name="FormaPagamentoDespesas">
																<option value="">-- Selecione uma op��o --</option>
																<?php
																foreach ($select['FormaPagamentoDespesas'] as $key => $row) {
																	if ($despesas['FormaPagamentoDespesas'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>															
														<div class="col-md-3">
															<label for="DataVencimentoDespesas">Data do 1� Venc.</label>
															<div class="input-group <?php echo $datepicker; ?>">
																<input type="text" class="form-control Date" id="DataVencimentoDespesas" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																	   name="DataVencimentoDespesas" value="<?php echo $despesas['DataVencimentoDespesas']; ?>">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
															</div>
														</div>
														<br>
														<div class="form-group">
															<div class="col-md-3 text-center">
																<button class="btn btn-danger" type="button" data-toggle="collapse" onclick="calculaParcelasPagaveis()"
																		data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																	<span class="glyphicon glyphicon-menu-down"></span> Gerar Parcelas
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
							<div class="panel panel-info">
								<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Parcelas
										</a>
									</h4>
								</div>
								<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">									
									

									<!--App_parcelasRec-->
									<div class="panel-body">
										<div class="input_fields_parcelas">

										<?php
										for ($i=1; $i <= $despesas['QtdParcelasDespesas']; $i++) {
										?>

											<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idApp_ParcelasPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['idApp_ParcelasPagaveis']; ?>"/>
											<?php } ?>
											<div class="form-group">
												<div class="panel panel-danger">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-2">
																<label for="ParcelaPagaveis">Parcela:</label><br>
																<input type="text" class="form-control" maxlength="6" readonly=""
																	   name="ParcelaPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['ParcelaPagaveis'] ?>">
															</div>
															<div class="col-md-2">
																<label for="ValorParcelaPagaveis">Valor Parcela:</label><br>
																<div class="input-group" id="txtHint">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcelaPagaveis<?php echo $i ?>"
																		   name="ValorParcelaPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['ValorParcelaPagaveis'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="DataVencimentoPagaveis">Data Venc. Parc.</label>
																<div class="input-group DatePicker">
																	<input type="text" class="form-control Date" id="DataVencimentoPagaveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataVencimentoPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['DataVencimentoPagaveis'] ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																</div>
															</div>
															<div class="col-md-2">
																<label for="ValorPagoPagaveis">Valor Pago:</label><br>
																<div class="input-group" id="txtHint">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorPagoPagaveis<?php echo $i ?>"
																		   name="ValorPagoPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['ValorPagoPagaveis'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="DataPagoPagaveis">Data Pag.</label>
																<div class="input-group DatePicker">
																	<input type="text" class="form-control Date" id="DataPagoPagaveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataPagoPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['DataPagoPagaveis'] ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																</div>
															</div>
															<div class="col-md-2">
																<label for="QuitadoPagaveis">Quitado?</label><br>
																<div class="form-group">
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['QuitadoPagaveis'] as $key => $row) {
																			(!$parcelaspag[$i]['QuitadoPagaveis']) ? $parcelaspag[$i]['QuitadoPagaveis'] = 'N' : FALSE;

																			if ($parcelaspag[$i]['QuitadoPagaveis'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="radiobutton_QuitadoPagaveis' . $i . '" id="radiobutton_QuitadoPagaveis' . $i .  $key . '">'
																				. '<input type="radio" name="QuitadoPagaveis' . $i . '" id="radiobuttondinamico" '
																				. 'onchange="carregaQuitadoDespesas(this.value,this.name,'.$i.')" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="radiobutton_QuitadoPagaveis' . $i . '" id="radiobutton_QuitadoPagaveis' . $i .  $key . '">'
																				. '<input type="radio" name="QuitadoPagaveis' . $i . '" id="radiobuttondinamico" '
																				. 'onchange="carregaQuitadoDespesas(this.value,this.name,'.$i.')" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
															</div>
														</div>														
													</div>
												</div>	
											</div>
										<?php
										}
										?>
										</div>

									</div>
								</div>
							</div>
						</div>														
						<div class="col-md-1"></div>
						<div class="form-group text-center">
							<div class="row">									
								<div class="col-md-3 form-inline">
									<label for="AprovadoDespesas">Devol. Aprov./Fech.?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['AprovadoDespesas'] as $key => $row) {
												if (!$despesas['AprovadoDespesas'])
													$despesas['AprovadoDespesas'] = 'N';

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($despesas['AprovadoDespesas'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="AprovadoDespesas_' . $hideshow . '">'
													. '<input type="radio" name="AprovadoDespesas" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="AprovadoDespesas_' . $hideshow . '">'
													. '<input type="radio" name="AprovadoDespesas" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>

										</div>
									</div>
								</div>
								<div class="col-md-3 form-inline">
									<label for="ServicoConcluidoDespesas">Devol. Conclu�da?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['ServicoConcluidoDespesas'] as $key => $row) {
												(!$despesas['ServicoConcluidoDespesas']) ? $despesas['ServicoConcluidoDespesas'] = 'N' : FALSE;

												if ($despesas['ServicoConcluidoDespesas'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_ServicoConcluidoDespesas" id="radiobutton_ServicoConcluidoDespesas' . $key . '">'
													. '<input type="radio" name="ServicoConcluidoDespesas" id="radiobutton" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_ServicoConcluidoDespesas" id="radiobutton_ServicoConcluidoDespesas' . $key . '">'
													. '<input type="radio" name="ServicoConcluidoDespesas" id="radiobutton" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
									</div>
								</div>									
								<div class="col-md-3 text-center form-inline">
									<label for="QuitadoDespesas">Devol. Quitada?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['QuitadoDespesas'] as $key => $row) {
												(!$despesas['QuitadoDespesas']) ? $despesas['QuitadoDespesas'] = 'N' : FALSE;
												

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																							
												if ($despesas['QuitadoDespesas'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="QuitadoDespesas_' . $hideshow . '">'
													. '<input type="radio" name="QuitadoDespesas" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="QuitadoDespesas_' . $hideshow . '">'
													. '<input type="radio" name="QuitadoDespesas" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
												
											}
											?>
										</div>
									</div>
								</div>																																
									
								<!--
								<div class="form-group">

									<div id="AprovadoDespesas" <?php echo $div['AprovadoDespesas']; ?>>									
										
										<div class="col-md-2 form-inline">
											<label for="QuitadoDespesas">Despesa Quitada?</label><br>
											<div class="form-group">
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['QuitadoDespesas'] as $key => $row) {
														(!$despesas['QuitadoDespesas']) ? $despesas['QuitadoDespesas'] = 'N' : FALSE;
														

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																									
														if ($despesas['QuitadoDespesas'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="QuitadoDespesas_' . $hideshow . '">'
															. '<input type="radio" name="QuitadoDespesas" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="QuitadoDespesas_' . $hideshow . '">'
															. '<input type="radio" name="QuitadoDespesas" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
														
													}
													?>
												</div>
											</div>
										</div>	
										<div id="QuitadoDespesas" <?php echo $div['QuitadoDespesas']; ?>>	
											
										</div>
										<!--																					
										<br>
										<br>								
									</div>
									
								</div>
								-->
							</div>
						</div>	
						<div class="col-md-1"></div>
						<div class="form-group text-center">
							<div class="row">
								<div class="col-md-3">
									<label for="DataDespesas">Data da Devol.:</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
											   name="DataDespesas" value="<?php echo $despesas['DataDespesas']; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataConclusaoDespesas">Data da Conclus�o:</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
											   name="DataConclusaoDespesas" value="<?php echo $despesas['DataConclusaoDespesas']; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataRetornoDespesas">Data do Retorno:</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
											   name="DataRetornoDespesas" value="<?php echo $despesas['DataRetornoDespesas']; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>						
						<div class="col-md-1"></div>
						<div class="form-group text-center">
							<div class="row">
								<div class="col-md-9">
								<label for="ObsDespesas">Obs:</label>
								<textarea class="form-control" id="ObsDespesas" <?php echo $readonly; ?>
										  name="ObsDespesas"><?php echo $despesas['ObsDespesas']; ?></textarea>
								</div>
							</div>
						</div>						

						<hr>

						<div class="form-group">
							<div class="row">
								<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
								<input type="hidden" name="idApp_Despesas" value="<?php echo $despesas['idApp_Despesas']; ?>">
								<?php if ($metodo > 1) { ?>
								<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
								<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelaspag['idApp_ParcelasRec']; ?>">-->
								<?php } ?>
								<?php if ($metodo == 2) { ?>
									<!--
									<div class="col-md-12 text-center">
										<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
											<span class="glyphicon glyphicon-trash"></span> Excluir
										</button>
										<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
													return true;">
											<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
										</button>
									</div>
									<button type="button" class="btn btn-danger">
										<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
									</button>                        -->

									<div class="col-md-6">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
									<div class="col-md-6 text-right">
										<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
											<span class="glyphicon glyphicon-trash"></span> Excluir
										</button>
									</div>

									<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-danger">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
												</div>
												<div class="modal-body">
													<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema. 
														Esta opera��o � irrevers�vel.</p>
												</div>
												<div class="modal-footer">
													<div class="col-md-6 text-left">
														<button type="button" class="btn btn-warning" data-dismiss="modal">
															<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
														</button>
													</div>
													<div class="col-md-6 text-right">
														<a class="btn btn-danger" href="<?php echo base_url() . 'devolucao/excluir/' . $despesas['idApp_Despesas'] ?>" role="button">
															<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="col-md-3">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>								
								<?php } ?>
							</div>
						</div>

						</form>

				</div>


			</div>

		</div>
		<div class="col-md-1"></div>
	</div>
</div>