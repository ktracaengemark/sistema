<?php if (isset($msg)) echo $msg; ?>


<div class="container-fluid">
	<div class="row">

		<div class="col-md-1"></div>
		<div class="col-md-10 ">

			<div class="row">

				<div class="col-md-12 col-lg-12">
				
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>

					<div class="panel panel-primary panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<?php echo $titulo; ?>
							<!--<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-search"></span> <?php #echo $titulo; ?>
							</button>-->
							<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/parcelas" role="button">
								<span class="glyphicon glyphicon-search"></span> Parcelas
							</a>
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
							<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/fiado" role="button">
								<span class="glyphicon glyphicon-search"></span> Fiado
							</a>
							<?php } ?>
							<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/despesasparc" role="button">
								<span class="glyphicon glyphicon-search"></span>PcDesp
							</a>-->
						</div>
						<div class="panel-body">
							
							<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
								<div class="modal-dialog modal-md" role="document">
									<div class="modal-content">
										<div class="modal-header bg-danger">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Parcelas</h4>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-3 text-left">
													<label for="Quitado">Parc. Quit.</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
												<div class="col-md-3 text-left" >
													<label for="Ordenamento">Dia do Venc.:</label>
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
													<label for="Ordenamento">Mês do Venc.:</label>
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
													<label for="Ordenamento">Ano do Venc.:</label>
													<div>
														<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
															   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<br>
												<div class="form-group col-md-3 text-left">
													<div class="form-footer ">
														<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
															<span class="glyphicon glyphicon-filter"></span> Filtrar
														</button>
													</div>
												</div>
												<!--
												<div class="form-group col-md-3 text-left">
													<div class="form-footer ">
														<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
															<span class="glyphicon glyphicon-remove"> Fechar
														</button>
													</div>
												</div>
												-->
												<div class="form-group col-md-3 text-left">
													<div class="form-footer">		
														<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/despesas" role="button">
															<span class="glyphicon glyphicon-ok"></span> Despesas
														</a>
													</div>	
												</div>
											</div>
										</div>									
									</div>								
								</div>
							</div>
						
							<div class="panel-group">	
								
								<div class="panel panel-primary">

									<div  style="overflow: auto; height: 456px; ">
										
									
										
											<div class="panel-body">
												<!--App_parcelasRec-->
												<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

												<div class="input_fields_wrap21">

												<?php
												for ($i=1; $i <= $count['PRCount']; $i++) {
												?>

													<?php if ($metodo > 1) { ?>
													<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
													<?php } ?>

													<div class="form-group" id="21div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-4">
																		<label for="Parcela">Parcela <?php echo $i ?>:</label><br>
																		<input type="text" class="form-control" maxlength="6" readonly=""
																			   name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																	</div>
																	<div class="col-md-2">
																		<label for="ValorParcela">Valor Parcela:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>"
																				   name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="DataVencimento">Data Venc. Parc.</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																				   name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">																
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="Quitado">Quitado????</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['Quitado'] as $key => $row) {
																					(!$parcelasrec[$i]['Quitado']) ? $parcelasrec[$i]['Quitado'] = 'N' : FALSE;

																					if ($parcelasrec[$i]['Quitado'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_Quitado' . $i . '" id="radiobutton_Quitado' . $i .  $key . '">'
																						. '<input type="radio" name="Quitado' . $i . '" id="radiobuttondinamico" '
																						. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_Quitado' . $i . '" id="radiobutton_Quitado' . $i .  $key . '">'
																						. '<input type="radio" name="Quitado' . $i . '" id="radiobuttondinamico" '
																						. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
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
																<!--
																<div class="row">
																	<div class="col-md-10"></div>
																	<div class="col-md-2 text-right">
																		<label><br></label><br>
																		<button type="button" id="<?php echo $i ?>" class="remove_field21 btn btn-danger">
																			<span class="glyphicon glyphicon-trash"></span>
																		</button>
																	</div>
																</div>
																-->
															</div>
														</div>
													</div>

												<?php
												}
												?>
												</div>
												<!--
												<div class="panel panel-warning">
													<div class="panel-heading">										
														<div class="form-group">	
															<div class="row">	
																<div class="col-md-2 text-left">
																	<button class="btn btn-warning" type="button" data-toggle="collapse" onclick="adicionaParcelas()"
																			data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																		<span class="glyphicon glyphicon-plus"></span> Adicionar Parcelas
																	</button>
																</div>
															</div>
														</div>	
													</div>
												</div>
												-->
											</div>
										
										
									
									
									</div>
									<div class="col-md-3">
										<label for="QuitadoParcelas">Quitar Tds as Parcelas?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['QuitadoParcelas'] as $key => $row) {
												(!$query['QuitadoParcelas']) ? $query['QuitadoParcelas'] = 'N' : FALSE;

												if ($query['QuitadoParcelas'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_QuitadoParcelas' . '" id="radiobutton_QuitadoParcelas' .  $key . '">'
													. '<input type="radio" name="QuitadoParcelas' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_QuitadoParcelas' .  '" id="radiobutton_QuitadoParcelas' .  $key . '">'
													. '<input type="radio" name="QuitadoParcelas' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
										<?php #echo form_error('QuitadoParcelas'); ?>
									</div>									
								</div>
							</div>
						
							<div class="form-group">
								<div class="row">
									<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
									<input type="hidden" name="idSis_Empresa" value="<?php echo $orcatrata['idSis_Empresa']; ?>">
									<?php if ($metodo > 1) { ?>
									<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
									<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
									<?php } ?>
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<!--
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
												<span class="glyphicon glyphicon-trash"></span> Excluir
											</button>
										</div>
										-->
										<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header bg-danger">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
													</div>
													<div class="modal-body">
														<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
															Esta operação é irreversível.</p>
													</div>
													<div class="modal-footer">
														<div class="col-md-6 text-left">
															<button type="button" class="btn btn-warning" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
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
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
