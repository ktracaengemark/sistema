
<?php echo validation_errors(); ?> 
	<?php echo form_open($form_open_path, 'role="form"'); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
		<div class="row">	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 text-left">
								<div class="row">
									<?php if($paginacao == "N") { ?>
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-left">
											<label>Pesquisar Despesa</label><br>	
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn btn-danger btn-md" type="submit">
														<span class="glyphicon glyphicon-search"></span> 
													</button>
												</span>
												<input type="text" class="form-control Numero" placeholder="N� Pedido" autofocus name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
											</div>
										</div>	
										<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
											<input type="hidden" class="form-control Numero" placeholder="Pesquisar Fornecedor"  name="Fornecedor" value="<?php echo set_value('Fornecedor', $query['Fornecedor']); ?>">
											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
												<label>Pesquisar Fornecedor</label><br>	
												<div class="input-group">
													<span class="input-group-btn">
														<button class="btn btn-danger btn-md" type="submit">
															<span class="glyphicon glyphicon-search"></span> 
														</button>
													</span>
													<input type="text" name="id_Fornecedor_Auto" id="id_Fornecedor_Auto" value="<?php echo $cadastrar['id_Fornecedor_Auto']; ?>" class="form-control" placeholder="Pesquisar Fornecedor">
													
												</div>
												<span class="modal-title" id="NomeFornecedorAuto1"><?php echo $cadastrar['NomeFornecedorAuto']; ?></span>
												<input type="hidden" id="NomeFornecedorAuto" name="NomeFornecedorAuto" value="<?php echo $cadastrar['NomeFornecedorAuto']; ?>" />
												<input type="hidden" id="Hidden_id_Fornecedor_Auto" name="Hidden_id_Fornecedor_Auto" value="<?php echo $query['idApp_Fornecedor']; ?>" />
												<input type="hidden" name="idApp_Fornecedor" id="idApp_Fornecedor" value="<?php echo $query['idApp_Fornecedor']; ?>" class="form-control" readonly= "">
											</div>
										<?php }else{ ?>
											<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
										<?php } ?>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
											<label>Filtros</label><br>
											<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
												<span class="glyphicon glyphicon-filter"></span>
											</button>
										</div>
										<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header bg-info">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Despesas</h4>
													</div>
													<div class="modal-footer">
														<div class="panel panel-info">
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
																		<label for="AprovadoOrca">Aprovado Pagamento</label>
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
														<div class="panel panel-info">
															<div class="panel-heading text-left">	
																<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
																<div class="row">	
																	<div class="col-md-3">
																		<label for="Ordenamento">Compra</label>
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
																		<label for="Ordenamento">Entrega</label>
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
																		<label for="Ordenamento">Local do Pagam</label>
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
																		<label for="Ordenamento">Forma do Pagam</label>
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
																	<div class="col-md-3 text-left">
																		<label for="Ordenamento">Tipo Despesa:</label>
																		<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
																				id="TipoFinanceiroD" name="TipoFinanceiroD">
																			<?php
																			foreach ($select['TipoFinanceiroD'] as $key => $row) {
																				if ($query['TipoFinanceiroD'] == $key) {
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
														<div class="panel panel-info">
															<div class="panel-heading text-left">
																<div class="row">
																	<div class="col-md-3">
																		<label for="DataInicio">Pedido Inc.</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																					autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="DataFim">Pedido Fim</label>
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
																</div>	
																<div class="row">
																		<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
																		<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
																	<?php }else{ ?>
																		<input type="hidden" name="DataInicio2" id="DataInicio2" value=""/>
																		<input type="hidden" name="DataFim2" id="DataFim2" value=""/>
																		<input type="hidden" name="DataInicio3" id="DataInicio3" value=""/>
																		<input type="hidden" name="DataFim3" id="DataFim3" value=""/>
																	<?php } ?>
																	<div class="col-md-3">
																		<label for="DataInicio4">Vnc. Inc.</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																					name="DataInicio4" value="<?php echo set_value('DataInicio4', $query['DataInicio4']); ?>">
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label for="DataFim4">Vnc. Fim</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																					name="DataFim4" value="<?php echo set_value('DataFim4', $query['DataFim4']); ?>">
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-info">
															<div class="panel-heading text-left">
																<div class="row">
																	<div class="col-md-3 text-left">
																		<label></label><br>
																		<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
																			<span class="glyphicon glyphicon-filter"></span> Filtrar
																		</button>
																	</div>
																	<div class="col-md-3 text-left">
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
									<?php }else{ ?>
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-left">
											<label>Pesquisar Pedido</label><br>
											<a class="btn btn-md btn-info btn-block" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos" role="button"> 
												<span class="glyphicon glyphicon-search"></span> Pesquisar Pedido
											</a>
										</div>
										<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
											<label>Pesquisar Fornecedor</label><br>
											<a class="btn btn-md btn-info btn-block" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos" role="button"> 
												<span class="glyphicon glyphicon-search"></span> Pesquisar Fornecedor
											</a>
										</div>
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-left">
											<label>Filtros</label><br>
											<a class="btn btn-md btn-info btn-block" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos" role="button"> 
												<span class="glyphicon glyphicon-filter"></span> Filtros
											</a>
										</div>
										<input type="hidden" name="Fornecedor" id="Fornecedor" value=""/>
									<?php } ?>
								</div>	
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
								<label>Gestor <b><?php echo $titulo; ?></b> de Despesas</label><br>
								<?php if($_SESSION['log']['idSis_Empresa'] == 5){ ?>
										<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrardesp" role="button"> 
											<span class="glyphicon glyphicon-plus"></span> Nova Compra / Despesa
										</a>
								<?php }else{ ?>
									<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
											<a class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrardesp" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Nova Compra / Despesa
											</a>
									<?php } ?>
								<?php } ?>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<?php if ($msg) {?>
			<div class="row">
				<div class="col-md-12">
					<?php echo $msg; ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
		<div class="row">
			<div class="col-md-12">
				<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
					<label>Fase de Or�amento</label>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-danger">
								<?php
									if($alert_combinar){
										if(isset($list_combinar)){
											$cont_combinar = $total_rows;
										}else{
											$cont_combinar = $report_combinar;
										}
										if($cont_combinar > 0){
											$flash_combinar = 'flash';
										}else{
											$flash_combinar = '';
										}
									}else{
										$flash_combinar = '';
									}	
									/*
									echo '<pre>';
									echo '<br>';
									print_r($flash_combinar);
									echo '</pre>';
									*/
								?>
								<div class=" <?php echo $flash_combinar ?> panel-heading">
									<a class="  text-center" style="color: #DC143C" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos_combinar_pag" role="button">
										<?php if(isset($list_combinar)){ ?>
											<h5 class="text-left"><b>Aguardando Aprovar</b> Entrega  - <?php echo $report_combinar->num_rows(); ?> / <?php echo $total_rows; ?> resultado(s)</h5>
										<?php }else { ?>
											<h5 class="text-left"><b>Aguardando Aprovar</b> Entrega  - <?php echo $report_combinar; ?> resultado(s)</h5>
										<?php } ?>
									</a>
								</div>
								<?php if(isset($list_combinar)){ ?>
									<div class="panel-body">
										<?php echo $list_combinar; ?>
									</div>
								<?php } ?>			
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-danger">
								<?php
									if($alert_aprovar){
										if(isset($list_aprovar)){
											$cont_aprovar = $total_rows;
										}else{
											$cont_aprovar = $report_aprovar;
										}
										if($cont_aprovar > 0){
											$flash_aprovar = 'flash';
										}else{
											$flash_aprovar = '';
										}
									}else{
										$flash_aprovar = '';
									}
								?>
								<div class=" <?php echo $flash_aprovar ?> panel-heading">
									<a class="text-center" style="color: #DC143C"  href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos_aprovar_pag" role="button">
										<?php if(isset($list_aprovar)){ ?>
											<h5 class="text-left"><b>Aguardando Aprovar</b> Pagamento  - <?php echo $report_aprovar->num_rows(); ?> / <?php echo $total_rows; ?> resultado(s)</h5>
										<?php }else { ?>
											<h5 class="text-left"><b>Aguardando Aprovar</b> Pagamento - <?php echo $report_aprovar; ?> resultado(s)</h5>
										<?php } ?>
									</a>
								</div>
								<?php if(isset($list_aprovar)){ ?>
									<div class="panel-body">
										<?php echo $list_aprovar; ?>
									</div>
								<?php } ?>	
							</div>
						</div>
					</div>
					<label>Fase de Pedido</label>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<a class="text-center" style="color: #00008B" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos_producao_pag" role="button">
										<?php if(isset($list_producao)){ ?>
											<h5 class="text-left">Aguardando <b>Produ��o</b>  - <?php echo $report_producao->num_rows(); ?> / <?php echo $total_rows; ?> resultado(s)</h5>
										<?php }else { ?>
											<h5 class="text-left">Aguardando <b>Produ��o</b> - <?php echo $report_producao; ?> resultado(s)</h5>
										<?php } ?>
									</a>
								</div>
								<?php if(isset($list_producao)){ ?>
									<div class="panel-body">
										<?php echo $list_producao; ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">			
						<div class="col-md-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<a class="text-center" style="color: #3CB371" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos_envio_pag" role="button">
										<?php if(isset($list_envio)){ ?>
											<h5 class="text-left">Aguardando <b>Envio</b>  - <?php echo $report_envio->num_rows(); ?> / <?php echo $total_rows; ?> resultado(s)</h5>
										<?php }else { ?>
											<h5 class="text-left">Aguardando <b>Envio</b> - <?php echo $report_envio; ?> resultado(s)</h5>
										<?php } ?>
									</a>
								</div>
								<?php if(isset($list_envio)){ ?>
									<div class="panel-body">
										<?php echo $list_envio; ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<a class="text-center" style="color: #B8860B" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos_entrega_pag" role="button">
										<?php if(isset($list_entrega)){ ?>
											<h5 class="text-left">Aguardando <b>Entrega</b>  - <?php echo $report_entrega->num_rows(); ?> / <?php echo $total_rows; ?> resultado(s)</h5>
										<?php }else { ?>
											<h5 class="text-left">Aguardando <b>Entrega</b> - <?php echo $report_entrega; ?> resultado(s)</h5>
										<?php } ?>
									</a>
								</div>
								<?php if(isset($list_entrega)){ ?>
									<div class="panel-body">
										<?php echo $list_entrega; ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">			
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<a class="text-center" style="color: #B8860B" href="<?php echo base_url() ?><?php echo $pedidos; ?>/pedidos_pagamento_pag" role="button">
										<?php if(isset($list_pagamento)){ ?>
											<h5 class="text-left">Aguardando <b>Pagamento</b>  - <?php echo $report_pagamento->num_rows(); ?> / <?php echo $total_rows; ?> resultado(s)</h5>
										<?php }else { ?>
											<h5 class="text-left">Aguardando <b>Pagamento</b> - <?php echo $report_pagamento; ?> resultado(s)</h5>
										<?php } ?>
									</a>
								</div>
								<?php if(isset($list_pagamento)){ ?>
									<div class="panel-body">
										<?php echo $list_pagamento; ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>	
		</div>
	</div>	
</form>
