<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">

			<div class="row">

				<div class="col-md-12 col-lg-12">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-12 ">
									<div class="col-md-2 text-left">
										<br>
										<a type= "button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() . $relatorio; ?>" role="button">
											<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo; ?>
										</a>
									</div>
									<div class="col-md-2 text-left">	
										<br>
										<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
											<?php echo $_SESSION['FiltroComissao']['Contagem'];?> / <?php echo $_SESSION['FiltroComissao']['Total_Rows'];?> Resultados
										</a>
									</div>
									<div class="col-md-2 text-left">	
										<br>
										<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
											<span class="glyphicon glyphicon-usd"></span>R$ <?php if(isset($_SESSION['FiltroComissao']['SomaTotal'])) echo $_SESSION['FiltroComissao']['SomaTotal']; ?> / <?php echo $_SESSION['FiltroComissao']['ComissaoTotal'] ?>
										</a>
									</div>
									<div class="col-md-4 text-left">
										<?php echo $_SESSION['FiltroComissao']['Pagination']; ?>
									</div>
									<div class="col-md-2 text-left">	
										<br>
										<a type= "button" class="btn btn-md btn-info btn-block" type="button" href="<?php echo base_url() . $imprimir; ?>">
											<span class="glyphicon glyphicon-list"></span> Lista
										</a>
									</div>
								</div>
							</div>	
						</div>
						<div class="panel-body">

							<div class="panel-group">	
								
								<div class="panel panel-primary">

									<div  style="overflow: auto; height: 456px; ">
									
										<div class="panel-body">
											<!--App_parcelasRec-->
											<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

											<div class="input_fields_wrap21">

											<?php
											$linha =  $_SESSION['FiltroComissao']['Per_Page']*$_SESSION['FiltroComissao']['Pagina'];
											for ($i=1; $i <= $count['PRCount']; $i++) {
												$contagem = ($linha + $i);
											?>
												<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $orcamento[$i]['idApp_OrcaTrata']; ?>"/>
												<div class="form-group" id="21div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label >Cont - Pedido - Local:</label><br>
																	<span><?php echo $contagem ?>
																		- <?php echo $orcamento[$i]['idApp_OrcaTrata'] ?>
																		
																		- <?php if($_SESSION['Orcamento'][$i]['Tipo_Orca'] == "O") {
																					echo 'On Line';
																				} elseif($_SESSION['Orcamento'][$i]['Tipo_Orca'] == "B"){
																					echo 'Na Loja';
																				}else{
																					echo 'Outros';
																				}?>
																	</span><br>
																	<label><?php echo $nomeusuario; ?>:</label><br>
																	<span><?php echo $_SESSION['Orcamento'][$i][$nomeusuario] ?></span>
																</div>
																<!--<input type="hidden" name="DataVencimentoOrca<?php #echo $i ?>" value="<?php #echo $orcamento[$i]['DataVencimentoOrca']; ?>"/>-->
																<div class="col-md-2">
																	<label for="DataOrca">Receita</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" readonly="" id="DataOrca<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['DataOrca'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorRestanteOrca">Prd+Srv:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" readonly="" maxlength="10" placeholder="0,00" id="ValorRestanteOrca<?php echo $i ?>"
																			   name="ValorRestanteOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorRestanteOrca'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorComissao">Comissao:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor"  maxlength="10" placeholder="0,00" id="ValorComissao<?php echo $i ?>"
																			   name="ValorComissao<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorComissao'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="<?php echo $statuscomissao; ?>">Pago?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select[$statuscomissao] as $key => $row) {
																				if (!$orcamento[$i][$statuscomissao])$orcamento[$i][$statuscomissao] = 'N';
																				($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																				if ($orcamento[$i][$statuscomissao] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="' . $statuscomissao . $i . '_' . $hideshow . '">'
																					. '<input type="radio" name="' . $statuscomissao . $i . '" id="' . $hideshow . '" '
																					//. 'onchange="carregaDataPagoComissaoOrca(this.value,this.name,'.$i.',1)" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="' . $statuscomissao . $i . '_' . $hideshow . '">'
																					. '<input type="radio" name="' . $statuscomissao . $i . '" id="' . $hideshow . '" '
																					//. 'onchange="carregaDataPagoComissaoOrca(this.value,this.name,'.$i.',1)" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div id="<?php echo $statuscomissao; ?><?php echo $i ?>" <?php echo $div[$statuscomissao . $i]; ?>>
																	<div class="col-md-2">
																		<label for="DataPagoComissaoOrca">DataPago</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" id="DataPagoComissaoOrca<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																				   name="DataPagoComissaoOrca<?php echo $i ?>" value="<?php echo $orcamento[$i]['DataPagoComissaoOrca'] ?>">																
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
						
							<div class="form-group">
								<div class="row">
									<!--<input type="hidden" name="idApp_Cliente" value="<?php #echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
									<!--<input type="hidden" name="idSis_Empresa" value="<?php #echo $_SESSION['log']['idSis_Empresa']; ?>">-->
									<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
									
									<div class="col-md-4 text-left">
										<label for="QuitadoComissão">Todas as Comissões Quitadas?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['QuitadoComissão'] as $key => $row) {
												(!$query['QuitadoComissão']) ? $query['QuitadoComissão'] = 'N' : FALSE;

												if ($query['QuitadoComissão'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_QuitadoComissão' . '" id="radiobutton_QuitadoComissão' .  $key . '">'
													. '<input type="radio" name="QuitadoComissão' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_QuitadoComissão' .  '" id="radiobutton_QuitadoComissão' .  $key . '">'
													. '<input type="radio" name="QuitadoComissão' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
										<?php #echo form_error('QuitadoComissão'); ?>
									</div>
									<div class="col-md-4 text-left">
										<label for="DataPagoComissãoPadrao">Data do Pagamento Padrao</label>
										<div class="input-group <?php echo $datepicker; ?>">
											<span class="input-group-addon" disabled>
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
													id="DataPagoComissãoPadrao" name="DataPagoComissãoPadrao" value="<?php echo $query['DataPagoComissãoPadrao']; ?>">
										</div>
										<?php echo form_error('DataPagoComissãoPadrao'); ?>
									</div>
									<div class="col-md-4 text-right">
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
