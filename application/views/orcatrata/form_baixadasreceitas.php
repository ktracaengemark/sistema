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
											<?php echo $_SESSION['FiltroReceitas']['Contagem'];?> / <?php echo $_SESSION['FiltroReceitas']['TotalRows'];?> Resultados
										</a>
									</div>	
										<!--
										<a class="btn btn-md btn-warning" type="button" href="<?php echo base_url() . $imprimir . $_SESSION['log']['idSis_Empresa']; ?>">
											<span class="glyphicon glyphicon-print"></span> Print.
										</a>
										-->
									<div class="col-md-2 text-left">	
										<br>
										<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
											<span class="glyphicon glyphicon-usd"></span>R$ <?php echo $_SESSION['FiltroReceitas']['SomaTotal']; ?> / <?php echo $_SESSION['FiltroReceitas']['FinalTotal'] ?>
										</a>
									</div>
									<div class="col-md-6 text-left">
										<?php echo $_SESSION['FiltroReceitas']['Pagination']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<div class="panel-group">
								
									<div  style="overflow: auto; height: auto; ">
										
											<!--App_parcelasRec-->
											<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

											<div class="input_fields_wrap21">

											<?php
											$linha =  $_SESSION['FiltroReceitas']['Per_Page']*$_SESSION['FiltroReceitas']['Pagina'];
											for ($i=1; $i <= $count['PRCount']; $i++) {
												$contagem = ($linha + $i);
											?>
												<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $orcamento[$i]['idApp_OrcaTrata']; ?>"/>
												<div class="form-group" id="21div<?php echo $i ?>">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label for="DataVencimentoOrca">Cont - Pedido - Local:</label><br>
																	<span><?php echo $contagem ?>
																		- <?php echo $orcamento[$i]['idApp_OrcaTrata'] ?>
																		
																		- <?php if($_SESSION['Orcamento'][$i]['Tipo_Orca'] == "O") {
																					echo 'On Line';
																				} elseif($_SESSION['Orcamento'][$i]['Tipo_Orca'] == "B"){
																					echo 'Na Loja';
																				}else{
																					echo 'Outros';
																				}?><br>
																		- <?php echo $_SESSION['Orcamento'][$i]['Nome' . $nome] ?>
																	</span>
																</div>
																<div class="col-md-2">
																	<label><?php echo $nomeusuario; ?>:</label><br>
																	<span><?php echo $_SESSION['Orcamento'][$i][$nomeusuario] ?></span>	
																</div>
																<div class="col-md-2">
																	<label for="DataOrca">Dt.Pedido:</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['DataOrca'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="DataEntregaOrca">Dt.Entrega:</label>
																	<div class="input-group DatePicker">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['DataEntregaOrca'] ?>">																
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ValorFinalOrca">Valor:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['ValorFinalOrca'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="FinalizadoOrca">Finalizado?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['FinalizadoOrca'] as $key => $row) {
																				(!$orcamento[$i]['FinalizadoOrca']) ? $orcamento[$i]['FinalizadoOrca'] = 'N' : FALSE;

																				if ($orcamento[$i]['FinalizadoOrca'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_FinalizadoOrca' . $i . '" id="radiobutton_FinalizadoOrca' . $i .  $key . '">'
																					. '<input type="radio" name="FinalizadoOrca' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_FinalizadoOrca' . $i . '" id="radiobutton_FinalizadoOrca' . $i .  $key . '">'
																					. '<input type="radio" name="FinalizadoOrca' . $i . '" id="radiobuttondinamico" '
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
						
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
									<div class="col-md-4 text-left">
										<label for="QuitadoComissao">Todas as Receitas Finalizadas?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['QuitadoComissao'] as $key => $row) {
												(!$query['QuitadoComissao']) ? $query['QuitadoComissao'] = 'N' : FALSE;

												if ($query['QuitadoComissao'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_QuitadoComissao' . '" id="radiobutton_QuitadoComissao' .  $key . '">'
													. '<input type="radio" name="QuitadoComissao' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_QuitadoComissao' .  '" id="radiobutton_QuitadoComissao' .  $key . '">'
													. '<input type="radio" name="QuitadoComissao' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>
										</div>
										<?php #echo form_error('QuitadoComissao'); ?>
									</div>
									<!--
									<div class="col-md-4 text-left">
										<label for="Cadastrar">Cadastrar</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											/*
											foreach ($select['Cadastrar'] as $key => $row) {
												(!$query['Cadastrar']) ? $query['Cadastrar'] = 'S' : FALSE;
												if ($query['Cadastrar'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_Cadastrar' . '" id="radiobutton_Cadastrar' .  $key . '">'
													. '<input type="radio" name="Cadastrar' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_Cadastrar' .  '" id="radiobutton_Cadastrar' .  $key . '">'
													. '<input type="radio" name="Cadastrar' . '" id="radiobuttondinamico" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											*/
											?>
										</div>
										<?php #echo form_error('Cadastrar'); ?>
									</div>
									-->
									<div class="col-md-4 text-right">
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
