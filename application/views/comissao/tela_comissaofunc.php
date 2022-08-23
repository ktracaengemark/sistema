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
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-left">
								<label>id_Recibo</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" placeholder="Nº Recibo" class="form-control Numero btn-sm" name="id_ComissaoFunc" id="id_ComissaoFunc" value="<?php echo set_value('id_ComissaoFunc', $query['id_ComissaoFunc']); ?>">
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-left">
								<label for="Recibo">Recibo:</label>
								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
										id="Recibo" name="Recibo">
									<?php
									foreach ($select['Recibo'] as $key => $row) {
										if ($query['Recibo'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<?php if ($_SESSION['Usuario']['Permissao_Comissao'] >= 2 ) { ?>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-left">
									<label for="id_Usuario">Supervisor:</label>
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
												id="id_Usuario" name="id_Usuario">
											<?php
											foreach ($select['id_Usuario'] as $key => $row) {
												if ($query['id_Usuario'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>	
								</div>
							<?php } ?>
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-left">
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
									<?php if($TipoRD == 2) {?>
										<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
										<input type="hidden" name="Fornecedor" id="Fornecedor" value="">
									<?php }elseif($TipoRD == 1){ ?>	
										<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
										<input type="hidden" name="Cliente" id="Cliente" value="">
									<?php } ?>
								</div>
							<?php }else{ ?>
								<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value=""/>
								<input type="hidden" name="idApp_Fornecedor" id="idApp_Fornecedor" value=""/>
								<input type="hidden" name="Cliente" id="Cliente" value=""/>
								<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
								<label>Filtros</label>
								<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-left">
								<label>Excel</label><br>
								<a href="<?php echo base_url() . 'Comissao/comissao_excel/1'; ?>">
									<button type='button' class='btn btn-md btn-success btn-block'>
										S/<span class="glyphicon glyphicon-filter"></span>
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
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das <?php echo $titulo; ?></h4>
					</div>
					<div class="modal-footer">
						<?php 
							if($_SESSION['log']['idSis_Empresa'] != 5) {
								$none = '';
							}else{
								$none = 'none';
							}
						?>
						<div class="panel panel-<?php echo $panel; ?>">
							<div class="panel-heading text-left">
								<div class="row">	
									<div class="col-md-3" style="display:<?php echo $none; ?>">
										<label for="CombinadoFrete">Aprovado Entrega</label>
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
									<div class="col-md-3"  style="display:<?php echo $none; ?>">
										<label for="AprovadoOrca">Aprovado Pagam</label>
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
									<div class="col-md-3"  style="display:<?php echo $none; ?>">
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
									<div class="col-md-3 text-left">
										<label for="StatusComissaoFunc">Status Comissão:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
												id="StatusComissaoFunc" name="StatusComissaoFunc">
											<?php
											foreach ($select['StatusComissaoFunc'] as $key => $row) {
												if ($query['StatusComissaoFunc'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-md-3" style="display:<?php echo $none; ?>">
									</div>
									<div class="col-md-3" style="display:<?php echo $none; ?>">
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
									<div class="col-md-3" style="display:<?php echo $none; ?>">
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
									<div class="col-md-3" style="display:<?php echo $none; ?>">
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
									<div class="col-md-3" style="display:<?php echo $none; ?>">
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
									<div class="col-md-3" style="display:<?php echo $none; ?>">
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
								</div>
								<div class="row">
									<input type="hidden" name="idTab_TipoRD" id="idTab_TipoRD" value="<?php echo $TipoRD; ?>"/>	
									<div class="col-md-3 text-left">
										<label for="TipoFinanceiro">Tipo de <?php echo $TipoFinanceiro; ?>:</label>
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
									<div class="col-md-3" style="display:<?php echo $none; ?>">
										<label for="Produtos">Produtos & Serviços:</label>
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
									<div class="col-md-3">
										<label for="Parcelas">Parcelas:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
								<div class="row" style="display:<?php echo $none; ?>">
									<div class="col-md-3">
										<label for="DataInicio5">Entrega</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataInicio5" value="<?php echo set_value('DataInicio5', $query['DataInicio5']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataFim5">Entrega</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim5" value="<?php echo set_value('DataFim5', $query['DataFim5']); ?>">
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
								</div>
								<div class="row">
									<div class="col-md-3">
										<label for="DataInicio4">Vencimento</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataInicio4" value="<?php echo set_value('DataInicio4', $query['DataInicio4']); ?>">
										</div>
									</div>
									<div class="col-md-3">
										<label for="DataFim4">Vencimento</label>
										<div class="input-group DatePicker">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
													name="DataFim4" value="<?php echo set_value('DataFim4', $query['DataFim4']); ?>">
										</div>
									</div>
								</div>
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
								<input type="hidden" name="DataInicio2" id="DataInicio2" value=""/>
								<input type="hidden" name="DataFim2" id="DataFim2" value=""/>
								<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
								<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
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
										<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit" >
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




