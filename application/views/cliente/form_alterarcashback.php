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
								
								<div class="panel panel-primary">

									<div  style="overflow: auto; height: 456px; ">
									
										<div class="panel-body">
											<!--App_parcelasRec-->
											<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

											<div class="input_fields_wrap21">

											<?php
											$linha =  $_SESSION['Per_Page']*$_SESSION['Pagina'];
											for ($i=1; $i <= $count['PRCount']; $i++) {
												$contagem = ($linha + $i);
											?>

												
												<input type="hidden" name="idApp_Cliente<?php echo $i ?>" value="<?php echo $orcamento[$i]['idApp_Cliente']; ?>"/>
												<input type="hidden" name="NomeCliente<?php echo $i ?>" value="<?php echo $orcamento[$i]['NomeCliente']; ?>"/>
												<div class="form-group" id="21div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label for="DataVencimentoOrca">Cliente:</label><br>
																	<span><?php echo $contagem ?>
																		- <?php echo $orcamento[$i]['idApp_Cliente'] ?> - 
																		<?php echo $orcamento[$i]['NomeCliente'] ?>
																	</span>
																</div>
																<div class="col-md-2">
																	<label for="Valor">Valor:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="Valor<?php echo $i ?>" readonly="" maxlength="10" placeholder="0,00" 
																			   name="Valor<?php echo $i ?>" value="<?php echo $orcamento[$i]['Valor'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="addCashBackCliente">addCashBackCliente:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">% / R$</span>
																		<input type="text" class="form-control Valor" id="addCashBackCliente<?php echo $i ?>" maxlength="10" placeholder="0,00" 
																			   name="addCashBackCliente<?php echo $i ?>" value="<?php echo $orcamento[$i]['addCashBackCliente'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="CashBackCliente">CashBackCliente:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="CashBackCliente<?php echo $i ?>" maxlength="10" placeholder="0,00" 
																			   name="CashBackCliente<?php echo $i ?>" value="<?php echo $orcamento[$i]['CashBackCliente'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="PrazoCashBack">PrazoCashBack:</label><br>
																	<div class="input-group" id="txtHint">
																		<input type="text" class="form-control Numero" id="PrazoCashBack<?php echo $i ?>" maxlength="2" placeholder="Ex.: 7 dias" 
																			   name="PrazoCashBack<?php echo $i ?>" value="<?php echo $orcamento[$i]['PrazoCashBack'] ?>">
																		<span class="input-group-addon" id="basic-addon1">Dias</span>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValidadeCashBack">ValidadeCashBack:</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" id="ValidadeCashBack<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																			   name="ValidadeCashBack<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValidadeCashBack'] ?>" >																
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
									<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
									<div class="col-md-2 text-left">
										<label for="AlterarTodos">Alterar Todos?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['AlterarTodos'] as $key => $row) {
												if (!$query['AlterarTodos'])$query['AlterarTodos'] = 'N';

												($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($query['AlterarTodos'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="AlterarTodos_' . $hideshow . '">'
													. '<input type="radio" name="AlterarTodos" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="AlterarTodos_' . $hideshow . '">'
													. '<input type="radio" name="AlterarTodos" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
										<?php echo form_error('AlterarTodos'); ?>
									</div>
									<div class="col-md-2 text-left">
										<label for="TipoAdd">Tipo de Add</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['TipoAdd'] as $key => $row) {
												(!$query['TipoAdd']) ? $query['TipoAdd'] = 'V' : FALSE;

												if ($query['TipoAdd'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_TipoAdd" id="radiobutton_TipoAdd' . $key . '">'
													. '<input type="radio" name="TipoAdd" id="radiobutton" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_TipoAdd" id="radiobutton_TipoAdd' . $key . '">'
													. '<input type="radio" name="TipoAdd" id="radiobutton" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
									</div>
									<div id="AlterarTodos" <?php echo $div['AlterarTodos']; ?>>
										<div class="col-md-2">
											<label for="ValorAddCashBack">ValorAddCashBack:</label><br>
											<div class="input-group">
												<span class="input-group-addon">% / R$</span>
												<input type="text" class="form-control Valor" id="ValorAddCashBack" maxlength="10" placeholder="0,00" 
													   name="ValorAddCashBack" value="<?php echo $query['ValorAddCashBack'] ?>">
											</div>
											<?php echo form_error('ValorAddCashBack'); ?>
										</div>
										<div class="col-md-2">
											<label for="PrazoGeralCashBack">PrazoGeralCashBack:</label><br>
											<div class="input-group">
												<input type="text" class="form-control Numero" id="PrazoGeralCashBack" maxlength="2" placeholder="Ex.: 7 dias" 
													   name="PrazoGeralCashBack" value="<?php echo $query['PrazoGeralCashBack'] ?>" onkeyup="SomaDias(this.value)">
												<span class="input-group-addon" >Dias</span>
											</div>
											<?php echo form_error('PrazoGeralCashBack'); ?>
										</div>
										
										<div class="col-md-2">
											<label for="ValidadeGeralCashBack">ValidadeGeral:</label>
											<div class="input-group DatePicker">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" id="ValidadeGeralCashBack" maxlength="10" placeholder="DD/MM/AAAA"
													   name="ValidadeGeralCashBack" value="<?php echo $query['ValidadeGeralCashBack'] ?>" readonly="">																
											</div>
										</div>
										
									</div>
									<div class="col-md-2 text-left">
										<label>Salvar:</label><br>
										<button  type="button" class="btn btn-md btn-primary" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
														<button class="btn btn-md btn-primary" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" data-loading-text="Aguarde..." type="submit">
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
