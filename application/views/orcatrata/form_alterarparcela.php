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
										<?php if ($titulo == "Receitas" ) { ?>
											<a type= "button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() ?>relatorio/cobrancas" role="button">
												<span class="glyphicon glyphicon-pencil"></span> Parcelas das <?php echo $titulo; ?> 
											</a>							
										<?php } else if($titulo == "Despesas"){ ?>
											<a type= "button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() ?>relatorio/debitos" role="button">
												<span class="glyphicon glyphicon-pencil"></span> Parcelas das <?php echo $titulo; ?>
											</a>
										<?php } ?>
										
										
									</div>
									<div class="col-md-2 text-left">	
										<br>
										<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
											<?php echo $_SESSION['Total_Rows'];?> Resultados
										</a>
									</div>
									<div class="col-md-6 text-left">
										<?php echo $_SESSION['Pagination']; ?>
									</div>
								</div>
							</div>

						</div>
						<div class="panel-body">
							<div class="panel-group">
								
									<div  style="overflow: auto; height: 456px; ">
										
											
												<!--App_parcelasRec-->
												<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

												<?php
												$linha =  $_SESSION['Per_Page']*$_SESSION['Pagina'];
												for ($i=1; $i <= $count['PRCount']; $i++) {
													$contagem = ($linha + $i);
												?>

													<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
													
													<div class="form-group" id="21div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" id="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_OrcaTrata']; ?>"/>
																	<input type="hidden" name="Parcela<?php echo $i ?>" id="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela']; ?>"/>
																	<div class="col-md-1">
																		<label for="Parcela">Prcl <?php echo $contagem ?></label><br>
																		<span><?php echo $parcelasrec[$i]['Parcela'] ?></span>
																	</div>
																	<?php if ($titulo == "Receitas") { ?>
																	<div class="col-md-2">
																		<label for="Receita">Receita:</label><br>
																		<span><?php echo $_SESSION['Parcelasrec'][$i]['Receita'] ?></span>
																	</div>
																	<?php } else if($titulo == "Despesas"){ ?>
																	
																	<div class="col-md-2">
																		<label for="Despesa">Despesa:</label><br>
																		<span><?php echo $_SESSION['Parcelasrec'][$i]['Despesa'] ?></span>
																	</div>
																	<?php } ?>
																	<input type="hidden" name="FormaPagamentoParcela<?php echo $i ?>" id="FormaPagamentoParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['FormaPagamentoParcela']; ?>"/>
																	<div class="col-md-2">
																		<label for="ValorParcela">Valor Parcela / <?php echo $_SESSION['Parcelasrec'][$i]['Tipo'] ?></label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>" <?php echo $_SESSION['Parcelasrec'][$i]['readonly'] ?>
																				   name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="DataVencimento">Vencimento</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" 
																				   name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">																
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="Quitado">Quitado?</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['Quitado'] as $key => $row) {
																					if (!$parcelasrec[$i]['Quitado'])$parcelasrec[$i]['Quitado'] = 'N';
																					($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																					if ($parcelasrec[$i]['Quitado'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="Quitado' . $i . '_' . $hideshow . '">'
																						. '<input type="radio" name="Quitado' . $i . '" id="' . $hideshow . '" '
																						. 'onchange="carregaQuitado2(this.value,this.name,'.$i.',2)" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="Quitado' . $i . '_' . $hideshow . '">'
																						. '<input type="radio" name="Quitado' . $i . '" id="' . $hideshow . '" '
																						. 'onchange="carregaQuitado2(this.value,this.name,'.$i.',2)" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																	<div id="Quitado<?php echo $i ?>" <?php echo $div['Quitado' . $i]; ?>>
																		<div class="col-md-2">
																			<label for="DataPago">Pagamento</label>
																			<div class="input-group DatePicker">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" id="DataPago<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" 
																					   name="DataPago<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataPago'] ?>">																
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
						
							<div class="form-group">
								<div class="row">
									<!--<input type="hidden" name="idSis_Empresa" value="<?php #echo $_SESSION['log']['idSis_Empresa']; ?>">
									<input type="hidden" name="idSis_Empresa" value="<?php #echo $orcatrata['idSis_Empresa']; ?>">-->
									<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
									<div class="col-md-2 text-left">
										<label for="QuitadoParcelas">Quitar Todas as Parcelas?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['QuitadoParcelas'] as $key => $row) {
												if (!$query['QuitadoParcelas'])$query['QuitadoParcelas'] = 'N';

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($query['QuitadoParcelas'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="QuitadoParcelas_' . $hideshow . '">'
													. '<input type="radio" name="QuitadoParcelas" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="QuitadoParcelas_' . $hideshow . '">'
													. '<input type="radio" name="QuitadoParcelas" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
										<?php #echo form_error('QuitadoParcelas'); ?>
									</div>
									<div class="col-md-2 text-left">
										<div id="QuitadoParcelas" <?php echo $div['QuitadoParcelas']; ?>>
											<h4 style="color: #FF0000">Atenção</h4>
											<h5 style="color: #FF0000">Todas as Parcelas receberão:</h5>
											<h4 style="color: #FF0000">" Quitado = Sim "</h4>
										</div>
									</div>
									<div class="col-md-2 text-left">
										<label for="MostrarDataPagamento">Definir Data Pagamento?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['MostrarDataPagamento'] as $key => $row) {
												if (!$query['MostrarDataPagamento'])$query['MostrarDataPagamento'] = 'N';

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($query['MostrarDataPagamento'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="MostrarDataPagamento_' . $hideshow . '">'
													. '<input type="radio" name="MostrarDataPagamento" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="MostrarDataPagamento_' . $hideshow . '">'
													. '<input type="radio" name="MostrarDataPagamento" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
										<?php #echo form_error('MostrarDataPagamento'); ?>
									</div>
									<div class="col-md-4 text-left">
										<div id="MostrarDataPagamento" <?php echo $div['MostrarDataPagamento']; ?>>
											<div class="row">	
												<div class="col-md-6 text-left">
													<label for="DataPagamento">Data do Pagamento</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																id="DataPagamento" name="DataPagamento" value="<?php echo $query['DataPagamento']; ?>">
													</div>
													<?php echo form_error('DataPagamento'); ?>
												</div>
												<!--
												<div class="col-md-6 text-left">
													<label for="UltimaDataPagamento">Ultima Data Utilizada</label>
													<div class="input-group <?php #echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																id="UltimaDataPagamento" name="UltimaDataPagamento" value="<?php #echo $_SESSION['Query']['UltimaDataPagamento']; ?>">
													</div>
												</div>
												-->
											</div>	
										</div>
									</div>
									<div class="col-md-2 text-right">
										<button  type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
									<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-danger">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title">Tem certeza que deseja Salvar?</h4>
												</div>
												<div class="modal-body">
													<p>Ao confirmar esta operação todos os dados serão salvos no sistema.</p>
												</div>
												<div class="modal-footer">
													<div class="col-md-6 text-left">
														<button type="button" class="btn btn-warning" data-dismiss="modal">
															<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
														</button>
													</div>
													<div class="col-md-6 text-right">
														<button class="btn btn-lg btn-primary" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-save"></span> Salvar
														</button>
														<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
															Aguarde um instante! Estamos processando sua solicitação!
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
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
