<div class="container-fluid">
	<div class="row">	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">			
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<h4 class="text-center"><b><?php echo $titulo; ?></b></h4>
							<?php if (isset($msg)) echo $msg; ?>
							<div style="overflow: auto; height: auto; ">
								<div class="panel-group">
									<div class="panel panel-success">
										<div class="panel-heading">
											<input type="hidden" id="AtivoCashBack" value="<?php echo $AtivoCashBack; ?>"/>
											<input type="hidden" id="metodo" value="<?php echo $metodo; ?>"/>
											<input type="hidden" id="exibir_id" value="<?php echo $exibir_id; ?>" />
											<input type="hidden" id="exibirExtraOrca" value="<?php echo $exibirExtraOrca; ?>" />
											<input type="hidden" id="exibirDescOrca" value="<?php echo $exibirDescOrca; ?>" />
											<input type="hidden" id="Recorrencias" name="Recorrencias" value="<?php echo $Recorrencias; ?>" />
											<input type="hidden" name="Negocio" id="Negocio" value="1"/>
											<input type="hidden" name="Empresa" id="Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>"/>
											<input type="hidden" name="NivelEmpresa" id="NivelEmpresa" value="<?php echo $_SESSION['log']['NivelEmpresa']; ?>"/>
											<input type="hidden" name="Bx_Pag" id="Bx_Pag" value="<?php echo $_SESSION['Usuario']['Bx_Pag']; ?>"/>
											<input type="hidden" name="Readonly_Cons" id="Readonly_Cons" value="<?php echo $alterar_campos; ?>"/>
											<div class="form-group">	
												<div class="row">
													<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">	
														<h4 class="mb-3"><b>Receita | Será Replicada em <?php echo $Recorrencias; ?> O.S.</b></h4>
													</div>	
													<?php if (isset($_SESSION['Consulta']['idApp_Consulta']) && $_SESSION['Consulta']['idApp_Consulta'] != 0){ ?>	
														<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
															<label >Agendamentos</label>
															<!--
															<a class="btn btn-md btn-info btn-block"  name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php #echo base_url() ?>consulta/alterar/<?php #echo $_SESSION['Consulta']['idApp_Cliente'];?>/<?php #echo $_SESSION['Consulta']['idApp_Consulta'];?>" role="button">
																<span class="glyphicon glyphicon-pencil"></span> <?php #echo $_SESSION['Consulta']['idApp_Consulta'];?>
															</a>
															-->
															<a class="btn btn-md btn-info btn-block"  name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() ?>agenda" role="button">
																<span class="glyphicon glyphicon-calendar"></span> 
															</a>
															<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																Aguarde um instante! Estamos processando sua solicitação!
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
											<div class="form-group">	
												<div class="row">
													<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
														<label for="TipoFinanceiro">Tipo de Receita</label>
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																id="TipoFinanceiro" name="TipoFinanceiro">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['TipoFinanceiro'] as $key => $row) {
																(!$orcatrata['TipoFinanceiro']) ? $orcatrata['TipoFinanceiro'] = '31' : FALSE;
																if ($orcatrata['TipoFinanceiro'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 text-left">
														<label for="DataOrca">Data do Pedido</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()"
																	id="DataOrca" name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>" readonly="">
														</div>
													</div>
													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
														<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-left">	
															<div class="row">
																<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4 text-left">
																	<label for="Cli_Forn_Orca">Com Cliente?</label><br>
																	<input type="text" class="form-control"id="Cli_Forn_Orca" name="Cli_Forn_Orca" value="<?php echo $orcatrata['Cli_Forn_Orca']; ?>" readonly="">
																</div>
																<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4 text-left">
																	<label for="Prd_Srv_Orca">Com Prd/Srv?</label><br>
																	<div class="btn-larg-right btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['Prd_Srv_Orca'] as $key => $row) {
																			if (!$orcatrata['Prd_Srv_Orca'])$orcatrata['Prd_Srv_Orca'] = 'S';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($orcatrata['Prd_Srv_Orca'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="Prd_Srv_Orca_' . $hideshow . '">'
																				. '<input type="radio" name="Prd_Srv_Orca" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="Prd_Srv_Orca_' . $hideshow . '">'
																				. '<input type="radio" name="Prd_Srv_Orca" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
																<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4 text-left">
																	<label for="Entrega_Orca">Com Entrega?</label><br>
																	<div class="btn-larg-right btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['Entrega_Orca'] as $key => $row) {
																			if (!$orcatrata['Entrega_Orca'])$orcatrata['Entrega_Orca'] = 'S';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($orcatrata['Entrega_Orca'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="Entrega_Orca_' . $hideshow . '">'
																				. '<input type="radio" name="Entrega_Orca" id="' . $hideshow . '" '
																				. 'onchange="comentrega(this.value)" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="Entrega_Orca_' . $hideshow . '">'
																				. '<input type="radio" name="Entrega_Orca" id="' . $hideshow . '" '
																				. 'onchange="comentrega(this.value)" '
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
													<?php }else{ ?>
														<input type="hidden" name="Cli_Forn_Orca" id="Cli_Forn_Orca" value="<?php echo $orcatrata['Cli_Forn_Orca']; ?>"/>
														<input type="hidden" name="Prd_Srv_Orca" id="Prd_Srv_Orca" value="<?php echo $orcatrata['Prd_Srv_Orca']; ?>"/>
														<input type="hidden" name="Entrega_Orca" id="Entrega_Orca" value="<?php echo $orcatrata['Entrega_Orca']; ?>"/>
													<?php } ?>
												</div>
												<input type="hidden" id="Hidden_Cli_Forn_Orca" value="<?php echo $orcatrata['Cli_Forn_Orca']; ?>"/>
												<input type="hidden" id="Hidden_Entrega_Orca" value="<?php echo $orcatrata['Entrega_Orca']; ?>"/>
											</div>
											<input type="hidden" id="Caminho2" name="Caminho2" value="<?php echo $caminho2; ?>">
											<div <?php echo $visivel; ?>>
												<div class="row">
													<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
														<label >Cliente</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Cliente']['NomeCliente']; ?>">
													</div>
													<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
														<?php if (isset($_SESSION['Consulta']['idApp_ClientePet']) && !empty($_SESSION['Consulta']['idApp_ClientePet']) && $_SESSION['Consulta']['idApp_ClientePet'] != 0) { ?>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
																<label >Pet</label>
																<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Pet']['NomeClientePet']; ?>">
																<span class="modal-title" id="Pet"></span>
															</div>
														<?php } ?>	
														<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $orcatrata['idApp_ClientePet']; ?>" />
													<?php }else{ ?>	
														<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
															<?php if (isset($_SESSION['Consulta']['idApp_ClienteDep']) && !empty($_SESSION['Consulta']['idApp_ClienteDep']) && $_SESSION['Consulta']['idApp_ClienteDep'] != 0) { ?>
																
																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
																	<label >Dependente</label>
																	<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Dep']['NomeClienteDep']; ?>">
																	<span class="modal-title" id="Dep"></span>
																</div>
															<?php } ?>
															<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $orcatrata['idApp_ClienteDep']; ?>" />
														<?php } ?>
													<?php } ?>	
													<!--
													<div class="col-md-4 text-left">
														<label  for="idApp_ClientePet">Pet</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
															<option value=""></option>
														</select>
														<span class="modal-title" id="Pet"></span>
													</div>
													-->
												</div>
											</div>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
												<div id="Prd_Srv_Orca" <?php echo $div['Prd_Srv_Orca']; ?>>	
													<h5 class="mb-3"><b>Produtos & Serviços</b></h5>
												
													<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>
													
													<div class="input_fields_wrap9">
														
														<?php
														$QtdSoma = $ProdutoSoma = 0;
														for ($i=1; $i <= $count['PCount']; $i++) {
														?>

														<?php if ($metodo > 1) { ?>
														<input type="hidden" name="idApp_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_Produto']; ?>"/>
														<?php } ?>

														<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

														<div class="form-group" id="9div<?php echo $i ?>">
															<div class="panel panel-warning">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
																			<input type="hidden" class="form-control " id="NomeProduto<?php echo $i ?>" name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Valor_Produto<?php echo $i ?>" name="idTab_Valor_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Valor_Produto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Produtos_Produto<?php echo $i ?>" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">
																			<input type="hidden" class="form-control " id="Prod_Serv_Produto<?php echo $i ?>" name="Prod_Serv_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['Prod_Serv_Produto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoProduto<?php echo $i ?>" name="ComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServicoProduto<?php echo $i ?>" name="ComissaoServicoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoCashBackProduto<?php echo $i ?>" name="ComissaoCashBackProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoCashBackProduto'] ?>">
																			<div class="row">
																				<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
																					<label for="idTab_Produto">Produto <?php echo $i ?></label>
																					<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="buscaValor1Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Produto',<?php echo $Recorrencias; ?>)" <?php echo $readonly; ?>
																							 id="listadinamicab<?php echo $i ?>" name="idTab_Produto<?php echo $i ?>">
																						<option value="">-- Selecione uma opção --</option>
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
																				<div id="FechaObsProduto<?php echo $i ?>">
																					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																						<label for="ObsProduto">Obs</label>
																						<textarea type="text" class="form-control"  id="ObsProduto<?php echo $i ?>" maxlength="200" placeholder="Observacao"
																								name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>" rows="1"><?php echo $produto[$i]['ObsProduto'] ?></textarea>
																					</div>
																				</div>
																			</div>
																			<div id="EscreverProduto<?php echo $i ?>">	
																				<div class="row">
																					<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
																						<label for="QtdProduto">Qtd.Item</label>
																						<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto<?php echo $i ?>" placeholder="0"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																								name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
																						<label for="QtdIncrementoProduto">Qtd.Embl</label>
																						<input type="text" class="form-control Numero" id="QtdIncrementoProduto<?php echo $i ?>" placeholder="0"
																							onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTDINC','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																							name="QtdIncrementoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdIncrementoProduto'] ?>">
																					</div>
																					<input type="hidden" class="form-control " id="SubtotalComissaoProduto<?php echo $i ?>" name="SubtotalComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoProduto'] ?>">
																					<input type="hidden" class="form-control " id="SubtotalComissaoServicoProduto<?php echo $i ?>" name="SubtotalComissaoServicoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoServicoProduto'] ?>">
																					<input type="hidden" class="form-control " id="SubtotalComissaoCashBackProduto<?php echo $i ?>" name="SubtotalComissaoCashBackProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoCashBackProduto'] ?>">
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<label for="SubtotalQtdProduto">Sub.Qtd</label>
																						<input type="text" class="form-control Numero text-left" maxlength="10" readonly="" id="SubtotalQtdProduto<?php echo $i ?>"
																							   name="SubtotalQtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalQtdProduto'] ?>">
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																						<label for="ValorProduto">ValorEmbl</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
																								name="ValorProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorProduto'] ?>">
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																						<label for="SubtotalProduto">Sub.Valor</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																								   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																			<div class="row">
																				<div id="EntregueProduto<?php echo $i ?>">
																					<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
																						<label for="DataConcluidoProduto">Data Entrega</label>
																						<div class="input-group DatePicker">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-calendar"></span>
																							</span>
																							<input type="text" class="form-control Date" id="DataConcluidoProduto<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" <?php echo $readonly_cons; ?>
																								   name="DataConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataConcluidoProduto'] ?>">
																						</div>
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																						<label for="HoraConcluidoProduto">Hora</label>
																						<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM" <?php echo $readonly_cons; ?>
																							   accept="" name="HoraConcluidoProduto<?php echo $i ?>" id="HoraConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['HoraConcluidoProduto']; ?>">
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																						<label for="PrazoProduto">Prazo</label>
																						<input type="text" class="form-control Numero" maxlength="3" placeholder="0" id="PrazoProduto<?php echo $i ?>" <?php echo $readonly_cons; ?>
																						onkeyup="calculaPrazoProdutos('PrazoProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')" 
																						name="PrazoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['PrazoProduto'] ?>">
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-6  col-lg-6 text-left">
																						<label for="ConcluidoProduto">Entregue? </label><br>
																						<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
																							<div class="btn-group" data-toggle="buttons">
																								<?php
																								foreach ($select['ConcluidoProduto'] as $key => $row) {
																									if (!$produto[$i]['ConcluidoProduto'])$produto[$i]['ConcluidoProduto'] = 'N';
																									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																									if ($produto[$i]['ConcluidoProduto'] == $key) {
																										echo ''
																										. '<label class="btn btn-warning active" name="ConcluidoProduto' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoProduto' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntreguePrd(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" checked>' . $row
																										. '</label>'
																										;
																									} else {
																										echo ''
																										. '<label class="btn btn-default" name="ConcluidoProduto' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoProduto' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntreguePrd(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" >' . $row
																										. '</label>'
																										;
																									}
																								}
																								?>
																							</div>
																						<?php }else{ ?>
																							<input type="hidden" name="ConcluidoProduto<?php echo $i ?>" id="ConcluidoProduto<?php echo $i ?>"  value="<?php echo $produto[$i]['ConcluidoProduto']; ?>"/>
																							<span>
																								<?php 
																									if($produto[$i]['ConcluidoProduto'] == "S") {
																											echo 'Sim';
																									} elseif($produto[$i]['ConcluidoProduto'] == "N"){
																										echo 'Não';
																									}else{
																										echo 'Não';
																									}
																								?>
																							</span>
																						<?php } ?>
																							
																					</div>
																					<div id="ConcluidoProduto<?php echo $i ?>" <?php echo $div['ConcluidoProduto' . $i]; ?>>
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 ">
																					</div>
																				</div>
																				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 ">
																					<label>Excluir</label><br>
																					<button type="button" id="<?php echo $i ?>" class="remove_field9 btn btn-danger btn-block"
																							onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																						<span class="glyphicon glyphicon-trash"></span>
																					</button>
																				</div>
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
														</div>

														<?php
														$QtdSoma+=$produto[$i]['QtdProduto'];
														$ProdutoSoma++;
														}
														?>
														
													</div>
													
													<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
													
													<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

													<div class="input_fields_wrap10">

														<?php
														$QtdSomaDev = $ServicoSoma = 0;
														for ($i=1; $i <= $count['SCount']; $i++) {
														?>

														<?php if ($metodo > 1) { ?>
														<input type="hidden" name="idApp_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_Produto']; ?>"/>
														<?php } ?>

														<input type="hidden" name="ServicoHidden" id="ServicoHidden<?php echo $i ?>" value="<?php echo $i ?>">
														
														<div class="form-group" id="10div<?php echo $i ?>">
															<div class="panel panel-danger">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
																			<input type="hidden" class="form-control " id="idTab_Valor_Servico<?php echo $i ?>" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Produto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Produtos_Servico<?php echo $i ?>" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Produto'] ?>">
																			<input type="hidden" class="form-control " id="Prod_Serv_Servico<?php echo $i ?>" name="Prod_Serv_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['Prod_Serv_Produto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServico<?php echo $i ?>" name="ComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServicoServico<?php echo $i ?>" name="ComissaoServicoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoCashBackServico<?php echo $i ?>" name="ComissaoCashBackServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoCashBackProduto'] ?>">
																			<input type="hidden" class="form-control " id="NomeServico<?php echo $i ?>" name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">
																			<div class="row">
																				<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
																					<label for="idTab_Servico">Serviço <?php echo $i ?>:</label>
																					<?php if ($i == 1) { ?>
																					<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button">
																						<span class="glyphicon glyphicon-plus"></span> <b>Novo Serviço</b>
																					</a>-->
																					<?php } ?>
																					<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="buscaValor1Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Servico',<?php echo $Recorrencias; ?>)" <?php echo $readonly; ?>
																							id="listadinamica<?php echo $i ?>" name="idTab_Servico<?php echo $i ?>">																					
																						<option value="">-- Selecione uma opção --</option>
																						<?php
																						foreach ($select['Servico'] as $key => $row) {
																							if ($servico[$i]['idTab_Produto'] == $key) {
																								echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																							} else {
																								echo '<option value="' . $key . '">' . $row . '</option>';
																							}
																						}
																						?>
																					</select>
																				</div>
																				<div id="FechaObsServico<?php echo $i ?>">
																					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																						<label for="ObsServico">Obs</label>
																						<textarea type="text" class="form-control" maxlength="200" id="ObsServico<?php echo $i ?>" placeholder="Observacao"
																								 name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsProduto'] ?>" rows="1"><?php echo $servico[$i]['ObsProduto'] ?></textarea>
																					</div>
																				</div>
																			</div>
																			<div id="EscreverServico<?php echo $i ?>">	
																				<div class="row">
																					<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
																						<label for="QtdServico">Qtd</label>
																						<input type="text" class="form-control Numero" maxlength="10" id="QtdServico<?php echo $i ?>" placeholder="0"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Servico'),calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',0,'ServicoHidden')"
																								 name="QtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdProduto'] ?>">
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
																						<label for="QtdIncrementoServico">Qtd.Embl</label>
																						<input type="text" class="form-control Numero" id="QtdIncrementoServico<?php echo $i ?>" name="QtdIncrementoServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdIncrementoProduto'] ?>" readonly="">
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<label for="SubtotalQtdServico">Sub.Qtd</label>
																						<input type="text" class="form-control Numero" id="SubtotalQtdServico<?php echo $i ?>" name="SubtotalQtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalQtdProduto'] ?>" readonly="">
																					</div>
																					<input type="hidden" class="form-control " id="SubtotalComissaoServico<?php echo $i ?>" name="SubtotalComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoProduto'] ?>">
																					<input type="hidden" class="form-control " id="SubtotalComissaoServicoServico<?php echo $i ?>" name="SubtotalComissaoServicoServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoServicoProduto'] ?>">
																					<input type="hidden" class="form-control " id="SubtotalComissaoCashBackServico<?php echo $i ?>" name="SubtotalComissaoCashBackServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoCashBackProduto'] ?>">
																					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																						<label for="ValorServico">ValorEmbl</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																								onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
																								name="ValorServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorProduto'] ?>">
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																						<label for="SubtotalServico">Sub.Valor</label>
																						<div class="input-group">
																							<span class="input-group-addon" id="basic-addon1">R$</span>
																							<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
																								   name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalProduto'] ?>">
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																			<div class="row">
																				<div id="EntregueServico<?php echo $i ?>">
																					<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
																						<label for="DataConcluidoServico">Data Entrega</label>
																						<div class="input-group DatePicker">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-calendar"></span>
																							</span>
																							<input type="text" class="form-control Date" id="DataConcluidoServico<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" <?php echo $readonly_cons; ?>
																								   name="DataConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataConcluidoProduto'] ?>">
																						</div>
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																						<label for="HoraConcluidoServico">Hora</label>
																						<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM" <?php echo $readonly_cons; ?>
																							   accept="" name="HoraConcluidoServico<?php echo $i ?>" id="HoraConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['HoraConcluidoProduto']; ?>">
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																						<label for="PrazoServico">Prazo</label>
																						<input type="text" class="form-control Numero" maxlength="3" placeholder="0"  id="PrazoServico<?php echo $i ?>" <?php echo $readonly_cons; ?>
																						onkeyup="calculaPrazoServicos('PrazoServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',0,'ServicoHidden')" 
																						name="PrazoServico<?php echo $i ?>" value="<?php echo $servico[$i]['PrazoProduto'] ?>">
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-6  col-lg-6 text-left">
																						<label for="ConcluidoServico">Entregue? </label><br>
																						<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
																							<div class="btn-group" data-toggle="buttons">
																								<?php
																								foreach ($select['ConcluidoServico'] as $key => $row) {
																									if (!$servico[$i]['ConcluidoProduto'])$servico[$i]['ConcluidoProduto'] = 'N';
																									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																									if ($servico[$i]['ConcluidoProduto'] == $key) {
																										echo ''
																										. '<label class="btn btn-warning active" name="ConcluidoServico' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoServico' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntregueSrv(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" checked>' . $row
																										. '</label>'
																										;
																									} else {
																										echo ''
																										. '<label class="btn btn-default" name="ConcluidoServico' . $i . '_' . $hideshow . '">'
																										. '<input type="radio" name="ConcluidoServico' . $i . '" id="' . $hideshow . '" '
																										. 'onchange="carregaEntregueSrv(this.value,this.name,'.$i.',0)" '
																										. 'autocomplete="off" value="' . $key . '" >' . $row
																										. '</label>'
																										;
																									}
																								}
																								?>
																							</div>
																						<?php }else{ ?>
																							<input type="hidden" name="ConcluidoServico<?php echo $i ?>" id="ConcluidoServico<?php echo $i ?>"  value="<?php echo $servico[$i]['ConcluidoProduto']; ?>"/>
																							<span>
																								<?php 
																									if($servico[$i]['ConcluidoProduto'] == "S") {
																											echo 'Sim';
																									} elseif($servico[$i]['ConcluidoProduto'] == "N"){
																										echo 'Não';
																									}else{
																										echo 'Não';
																									}
																								?>
																							</span>
																						<?php } ?>
																							
																					</div>
																					<div id="ConcluidoServico<?php echo $i ?>" <?php echo $div['ConcluidoServico' . $i]; ?>>
																					</div>
																					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																						<label for="ValorComissaoServico">Comissao</label>
																						<input type="text" class="form-control Valor" id="ValorComissaoServico<?php echo $i ?>" name="ValorComissaoServico<?php echo $i ?>" 
																							value="<?php echo $servico[$i]['ValorComissaoServico'] ?>" readonly="">
																					</div>
																				</div>
																				<div class="col-xs-6 col-sm-4 col-md-3  col-lg-3">
																					<label>Excluir</label><br>
																					<button type="button" id="<?php echo $i ?>" class="remove_field10 btn btn-danger btn-block"
																						onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',1,<?php echo $i ?>,'CountMax2',0,'ServicoHidden')">
																						<span class="glyphicon glyphicon-trash"></span>
																					</button>
																				</div>
																			</div>
																		</div>
																		<div id="FechaProfServico<?php echo $i ?>">
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" <?php echo $div['Prof_comissao']; ?>>
																				<div class="row">
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<div class="row">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<label for="ProfissionalServico_1<?php echo $i ?>">Profissional 1</label>
																								<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
																									id="listadinamica_prof_1<?php echo $i ?>" name="ProfissionalServico_1<?php echo $i ?>" 
																									onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',1)">
																									<option value="">-- Sel.Profis. --</option>
																									<?php
																									foreach ($select['ProfissionalServico_1'] as $key => $row) {
																										if ($servico[$i]['ProfissionalProduto_1'] == $key) {
																											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																										} else {
																											echo '<option value="' . $key . '">' . $row . '</option>';
																										}
																									}
																									?>
																								</select>
																							</div>
																							<input type="hidden" class="form-control " id="ProfissionalServico_1<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalProduto_1'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="idTFProf_Servico_1<?php echo $i ?>" name="idTFProf_Servico_1<?php echo $i ?>" value="<?php echo $servico[$i]['idTFProf_1'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="ComFunProf_Servico_1<?php echo $i ?>" name="ComFunProf_Servico_1<?php echo $i ?>" value="<?php echo $servico[$i]['ComFunProf_1'] ?>" readonly="">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<input type="text" class="form-control Valor" id="ValorComProf_Servico_1<?php echo $i ?>" name="ValorComProf_Servico_1<?php echo $i ?>" value="<?php echo $servico[$i]['ValorComProf_1'] ?>" 
																									onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)" <?php echo $cadastrar_servico[$i]['Hidden_readonly_1'];?>>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<div class="row">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<label for="ProfissionalServico_2<?php echo $i ?>">Profissional 2</label>
																								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																										 id="listadinamica_prof_2<?php echo $i ?>" name="ProfissionalServico_2<?php echo $i ?>" 
																										onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',2)">
																									<option value="">-- Sel.Profis. --</option>
																									<?php
																									foreach ($select['ProfissionalServico_2'] as $key => $row) {
																										if ($servico[$i]['ProfissionalProduto_2'] == $key) {
																											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																										} else {
																											echo '<option value="' . $key . '">' . $row . '</option>';
																										}
																									}
																									?>
																								</select>
																							</div>
																							<input type="hidden" class="form-control " id="ProfissionalServico_2<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalProduto_2'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="idTFProf_Servico_2<?php echo $i ?>" name="idTFProf_Servico_2<?php echo $i ?>" value="<?php echo $servico[$i]['idTFProf_2'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="ComFunProf_Servico_2<?php echo $i ?>" name="ComFunProf_Servico_2<?php echo $i ?>" value="<?php echo $servico[$i]['ComFunProf_2'] ?>" readonly="">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<input type="text" class="form-control Valor" id="ValorComProf_Servico_2<?php echo $i ?>" name="ValorComProf_Servico_2<?php echo $i ?>" value="<?php echo $servico[$i]['ValorComProf_2'] ?>" 
																									onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)" <?php echo $cadastrar_servico[$i]['Hidden_readonly_2'];?>>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<div class="row">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<label for="ProfissionalServico_3<?php echo $i ?>">Profissional 3</label>
																								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																										 id="listadinamica_prof_3<?php echo $i ?>" name="ProfissionalServico_3<?php echo $i ?>" 
																										onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',3)">
																									<option value="">-- Sel.Profis. --</option>
																									<?php
																									foreach ($select['ProfissionalServico_3'] as $key => $row) {
																										if ($servico[$i]['ProfissionalProduto_3'] == $key) {
																											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																										} else {
																											echo '<option value="' . $key . '">' . $row . '</option>';
																										}
																									}
																									?>
																								</select>
																							</div>
																							<input type="hidden" class="form-control " id="ProfissionalServico_3<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalProduto_3'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="idTFProf_Servico_3<?php echo $i ?>" name="idTFProf_Servico_3<?php echo $i ?>" value="<?php echo $servico[$i]['idTFProf_3'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="ComFunProf_Servico_3<?php echo $i ?>" name="ComFunProf_Servico_3<?php echo $i ?>" value="<?php echo $servico[$i]['ComFunProf_3'] ?>" readonly="">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<input type="text" class="form-control Valor" id="ValorComProf_Servico_3<?php echo $i ?>" name="ValorComProf_Servico_3<?php echo $i ?>" value="<?php echo $servico[$i]['ValorComProf_3'] ?>" 
																									onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)" <?php echo $cadastrar_servico[$i]['Hidden_readonly_3'];?>>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<div class="row">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<label for="ProfissionalServico_4<?php echo $i ?>">Profissional 4</label>
																								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																										 id="listadinamica_prof_4<?php echo $i ?>" name="ProfissionalServico_4<?php echo $i ?>" 
																										onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',4)">
																									<option value="">-- Sel.Profis. --</option>
																									<?php
																									foreach ($select['ProfissionalServico_4'] as $key => $row) {
																										if ($servico[$i]['ProfissionalProduto_4'] == $key) {
																											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																										} else {
																											echo '<option value="' . $key . '">' . $row . '</option>';
																										}
																									}
																									?>
																								</select>
																							</div>
																							<input type="hidden" class="form-control " id="ProfissionalServico_4<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalProduto_4'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="idTFProf_Servico_4<?php echo $i ?>" name="idTFProf_Servico_4<?php echo $i ?>" value="<?php echo $servico[$i]['idTFProf_4'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="ComFunProf_Servico_4<?php echo $i ?>" name="ComFunProf_Servico_4<?php echo $i ?>" value="<?php echo $servico[$i]['ComFunProf_4'] ?>" readonly="">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<input type="text" class="form-control Valor" id="ValorComProf_Servico_4<?php echo $i ?>" name="ValorComProf_Servico_4<?php echo $i ?>" value="<?php echo $servico[$i]['ValorComProf_4'] ?>" 
																									onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)" <?php echo $cadastrar_servico[$i]['Hidden_readonly_4'];?>>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<div class="row">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<label for="ProfissionalServico_5<?php echo $i ?>">Profissional 5</label>
																								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																										 id="listadinamica_prof_5<?php echo $i ?>" name="ProfissionalServico_5<?php echo $i ?>" 
																										onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',5)">
																									<option value="">-- Sel.Profis. --</option>
																									<?php
																									foreach ($select['ProfissionalServico_5'] as $key => $row) {
																										if ($servico[$i]['ProfissionalProduto_5'] == $key) {
																											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																										} else {
																											echo '<option value="' . $key . '">' . $row . '</option>';
																										}
																									}
																									?>
																								</select>
																							</div>
																							<input type="hidden" class="form-control " id="ProfissionalServico_5<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalProduto_5'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="idTFProf_Servico_5<?php echo $i ?>" name="idTFProf_Servico_5<?php echo $i ?>" value="<?php echo $servico[$i]['idTFProf_5'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="ComFunProf_Servico_5<?php echo $i ?>" name="ComFunProf_Servico_5<?php echo $i ?>" value="<?php echo $servico[$i]['ComFunProf_5'] ?>" readonly="">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<input type="text" class="form-control Valor" id="ValorComProf_Servico_5<?php echo $i ?>" name="ValorComProf_Servico_5<?php echo $i ?>" value="<?php echo $servico[$i]['ValorComProf_5'] ?>"
																									onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)" <?php echo $cadastrar_servico[$i]['Hidden_readonly_5'];?>>
																							</div>
																						</div>
																					</div>
																					<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																						<div class="row">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<label for="ProfissionalServico_6<?php echo $i ?>">Profissional 6</label>
																								<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																										 id="listadinamica_prof_6<?php echo $i ?>" name="ProfissionalServico_6<?php echo $i ?>" 
																										onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',6)">
																									<option value="">-- Sel.Profis. --</option>
																									<?php
																									foreach ($select['ProfissionalServico_6'] as $key => $row) {
																										if ($servico[$i]['ProfissionalProduto_6'] == $key) {
																											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																										} else {
																											echo '<option value="' . $key . '">' . $row . '</option>';
																										}
																									}
																									?>
																								</select>
																							</div>
																							<input type="hidden" class="form-control " id="ProfissionalServico_6<?php echo $i ?>" value="<?php echo $servico[$i]['ProfissionalProduto_6'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="idTFProf_Servico_6<?php echo $i ?>" name="idTFProf_Servico_6<?php echo $i ?>" value="<?php echo $servico[$i]['idTFProf_6'] ?>" readonly="">
																							<input type="hidden" class="form-control " id="ComFunProf_Servico_6<?php echo $i ?>" name="ComFunProf_Servico_6<?php echo $i ?>" value="<?php echo $servico[$i]['ComFunProf_6'] ?>" readonly="">
																							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																								<input type="text" class="form-control Valor" id="ValorComProf_Servico_6<?php echo $i ?>" name="ValorComProf_Servico_6<?php echo $i ?>" value="<?php echo $servico[$i]['ValorComProf_6'] ?>"
																									onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)" <?php echo $cadastrar_servico[$i]['Hidden_readonly_6'];?>>
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

														<?php
														$QtdSomaDev+=$servico[$i]['QtdProduto'];
														$ServicoSoma++;
														}
														?>
													</div>
													
													<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">
													
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<div class="col-xs-12 col-sm-4  col-md-4 col-lg-4 text-left">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<div class="row">	
																				<div class="col-md-12">
																					<div class="row">
																						<div class="col-md-4 text-left">
																							<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma; ?></span></b><br />
																						</div>
																						<div class="col-md-8 text-center">
																							<?php if($Recorrencias > 1) { ?>	
																								<a class="btn btn-warning btn-block">
																									<span class="glyphicon glyphicon-ban-circle"></span>
																								</a>
																							<?php }else{ ?>
																								<a class="add_field_button9 btn btn-warning btn-block"
																										onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																									<span class="glyphicon glyphicon-plus"></span> Adi.Produtos
																								</a>
																							<?php } ?>	
																						</div>
																						<!--
																						<div class="col-md-3 text-center">	
																							
																							<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma; ?></span></b>
																						</div>
																						-->
																					</div>
																					<br>
																					<div class="row">
																						<div class="col-md-4 text-left">	
																							<b>Produtos: </b> 
																						</div>
																						<div class="col-md-8">
																							<div  id="txtHint">
																								<input type="text" class="form-control text-left Numero" id="QtdPrdOrca" maxlength="10" readonly=""
																									   name="QtdPrdOrca" value="<?php echo $orcatrata['QtdPrdOrca'] ?>">
																							</div>
																						</div>
																					</div>	
																					<div class="row">	
																						<div class="col-md-4 text-left">	
																							<b>Valor:</b> 
																						</div>	
																						<div class="col-md-8">	
																							<!--<label for="ValorOrca">Sub Produtos:</label><br>-->
																							<div class="input-group" id="txtHint">
																								<span class="input-group-addon" id="basic-addon1">R$</span>
																								<input type="text" class="form-control text-left Valor" id="ValorOrca" maxlength="10" placeholder="0,00" readonly=""
																									   onkeyup="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)" onchange="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)"
																									   name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
																							</div>
																						</div>
																					</div>	
																					<div class="row">	
																						<div class="col-md-4 text-left">	
																							<b>Prazo:</b> 
																						</div>
																						<div class="col-md-8">
																							<div  class="input-group" id="txtHint">
																								<span class="input-group-addon" id="basic-addon1">Dias</span>
																								<input type="text" class="form-control text-left Numero"  readonly=""
																									   name="PrazoProdutos" id="PrazoProdutos" value="<?php echo $orcatrata['PrazoProdutos'] ?>">
																									   
																							</div>
																						</div>
																					</div>
																				</div>
																				<!--
																				<div class="col-md-3 text-center">
																					<label></label>
																					<a class="btn btn-md btn-danger" target="_blank" href="<?php echo base_url() ?>relatorio2/produtos2" role="button"> 
																						<span class="glyphicon glyphicon-plus"></span> Novo/ Editar/ Estoque
																					</a>
																				</div>
																				-->
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xs-12 col-sm-4  col-md-4 col-lg-4 text-left">
																	<div class="panel panel-danger">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-md-4 text-left">	
																					<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
																				</div>
																				<div class="col-md-8 text-center">
																					<a class="add_field_button10  btn btn-danger btn-block" 
																							onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',1,0)">
																						<span class="glyphicon glyphicon-plus"></span> Adi.Serviços
																					</a>
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<!--
																				<div class="col-md-6">
																					<div class="row">
																						<div class="col-md-12 text-left">	
																							<b>Serviços: <span class="text-right" id="QtdSomaDev"><?php echo $QtdSomaDev ?></span> </b>
																						</div>
																					</div>
																				</div>
																				-->
																				<div class="col-md-4 text-left">	
																					<b>Serviços: </b> 
																				</div>
																				<div class="col-md-8">
																					<div  id="txtHint">
																						<input type="text" class="form-control text-left Numero" id="QtdSrvOrca" maxlength="10" readonly=""
																							   name="QtdSrvOrca" value="<?php echo $orcatrata['QtdSrvOrca'] ?>">
																							   
																					</div>
																				</div>
																			</div>	
																			<div class="row">	
																				<div class="col-md-4 text-left">	
																					<b>Valor:</b> 
																				</div>	
																				<div class="col-md-8">
																					<div class="input-group" id="txtHint">
																						<span class="input-group-addon" id="basic-addon1">R$</span>
																						<input type="text" class="form-control text-left Valor" id="ValorDev" maxlength="10" placeholder="0,00" readonly=""
																							   onkeyup="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)" onchange="calculaResta(this.value),calculaTotal(this.value),calculaTroco(this.value)"
																							   name="ValorDev" value="<?php echo $orcatrata['ValorDev'] ?>">
																					</div>
																				</div>
																			</div>	
																			<div class="row">	
																				<div class="col-md-4 text-left">	
																					<b>Prazo:</b> 
																				</div>
																				<div class="col-md-8">
																					<div  class="input-group" id="txtHint">
																						<span class="input-group-addon" id="basic-addon1">Dias</span>
																						<input type="text" class="form-control text-left Numero"  readonly=""
																							   name="PrazoServicos" id="PrazoServicos" value="<?php echo $orcatrata['PrazoServicos'] ?>">
																							   
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
												<input type="hidden" class="form-control " name="ValorComissao" id="ValorComissao" value="<?php echo $orcatrata['ValorComissao'] ?>" readonly=''>	
												<input type="hidden" class="form-control Valor" name="ValorRestanteOrca" id="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>" readonly=''/>
											<?php }else{ ?>	
												<input type="hidden" class="form-control Valor" name="ValorRestanteOrca" id="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>" readonly=''/>
												<input type="hidden" name="ValorComissao" id="ValorComissao" value="<?php echo $orcatrata['ValorComissao'] ?>">
											<?php } ?>
										</div>
									</div>

									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
										<div id="Entrega_Orca" <?php echo $div['Entrega_Orca']; ?>>	
											<br>
											<div class="panel panel-info">
												<div class="panel-heading">	
													<h4 class="mb-3"><b>Entrega</b></h4>
													<div class="row">
														<div class="col-sm-7  col-md-6 col-lg-4 text-left">
															<label for="TipoFrete">Local e Forma de Entrega:</label><br>
															<div class="btn-block" data-toggle="buttons">
																<?php
																foreach ($select['TipoFrete'] as $key => $row) {
																	(!$orcatrata['TipoFrete']) ? $orcatrata['TipoFrete'] = '1' : FALSE;
																	#if (!$orcatrata['TipoFrete'])$orcatrata['TipoFrete'] = 1;
																	($key == '1') ? $hideshow = 'hideradio' : $hideshow = 'showradio';
																	if ($orcatrata['TipoFrete'] == $key) {
																		echo ''
																		. '<label class="btn btn-default active" name="radio" id="radio' . $key . '">'
																		. '<input type="radio" name="TipoFrete" id="' . $hideshow . '" '
																		. 'onchange="valorTipoFrete(this.value,this.name)" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																		. '<input type="radio" name="TipoFrete" id="' . $hideshow . '"'
																		. 'onchange="valorTipoFrete(this.value,this.name)" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>
														<input type="hidden" id="ValorTipoFrete" name="ValorTipoFrete" value="<?php echo $orcatrata['TipoFrete']; ?>">
														<div class="col-sm-5 col-md-4 text-left">
															<label for="Entregador">Entregador</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																	id="Entregador" name="Entregador">
																<option value="">-- Sel. o Entregador --</option>
																<?php
																foreach ($select['Entregador'] as $key => $row) {
																		#(!$orcatrata['Entregador']) ? $orcatrata['Entregador'] = '1' : FALSE;
																	if ($orcatrata['Entregador'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																	}
																?>
															</select>
														</div>
														<div class="col-sm-4  col-md-2 text-left">
															<label for="DetalhadaEntrega">Personalizada?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['DetalhadaEntrega'] as $key => $row) {
																	if (!$orcatrata['DetalhadaEntrega']) $orcatrata['DetalhadaEntrega'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($orcatrata['DetalhadaEntrega'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="DetalhadaEntrega_' . $hideshow . '">'
																		. '<input type="radio" name="DetalhadaEntrega" id="' . $hideshow . '" '
																		. 'onchange="calculaParcelas(),formaPag(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="DetalhadaEntrega_' . $hideshow . '">'
																		. '<input type="radio" name="DetalhadaEntrega" id="' . $hideshow . '" '
																		. 'onchange="calculaParcelas(),formaPag(this.value)" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
															<?php echo form_error('DetalhadaEntrega'); ?>
														</div>
													</div>
													<div id="DetalhadaEntrega" <?php echo $div['DetalhadaEntrega']; ?>>
														<br>
														<div class="row">	
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="NomeRec">Nome Recebedor:</label>
																<input type="text" class="form-control " id="NomeRec" maxlength="40" <?php echo $readonly; ?>
																	   name="NomeRec" value="<?php echo $orcatrata['NomeRec']; ?>">
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="TelefoneRec">Telefone:</label>
																<input type="text" class="form-control Celular CelularVariavel" id="TelefoneRec" maxlength="11" <?php echo $readonly; ?>
																	   name="TelefoneRec" placeholder="(XX)999999999" value="<?php echo $orcatrata['TelefoneRec']; ?>">
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="ParentescoRec">Parentesco:</label>
																<input type="text" class="form-control " id="ParentescoRec" maxlength="40" <?php echo $readonly; ?>
																	   name="ParentescoRec" value="<?php echo $orcatrata['ParentescoRec']; ?>">
															</div>
														</div>	
														<div class="row">	
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Aux1Entrega">Aux1:</label>
																<input type="text" class="form-control " id="Aux1Entrega" maxlength="40" <?php echo $readonly; ?>
																	   name="Aux1Entrega" value="<?php echo $orcatrata['Aux1Entrega']; ?>">
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Aux2Entrega">Aux2:</label>
																<input type="text" class="form-control " id="Aux2Entrega" maxlength="40" <?php echo $readonly; ?>
																	   name="Aux2Entrega" value="<?php echo $orcatrata['Aux2Entrega']; ?>">
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="ObsEntrega">Obs Entrega:</label>
																<textarea class="form-control " id="ObsEntrega" <?php echo $readonly; ?>
																		  name="ObsEntrega"><?php echo $orcatrata['ObsEntrega']; ?>
																</textarea>
															</div>
														</div>
													</div>
													<input type="hidden" id="Caminho" name="Caminho" value="<?php echo $caminho; ?>">
													<input type="hidden" id="TaxaEntrega" name="TaxaEntrega" value="<?php echo $_SESSION['Empresa']['TaxaEntrega'] ?>">
													<div id="TipoFrete" <?php echo $div['TipoFrete']; ?>>
														<br>
														<input type="hidden" name="CepOrigem" id="CepOrigem" placeholder="CepOrigem" value="<?php echo $_SESSION['Empresa']['CepEmpresa'];?>">
														<input type="hidden" name="Peso" id="Peso" placeholder="Peso" value="1">
														<input type="hidden" name="Formato" id="Formato" placeholder="Formato" value="1">
														<input type="hidden" name="Comprimento" id="Comprimento" placeholder="Comprimento" value="30">
														<input type="hidden" name="Largura" id="Largura" placeholder="Largura" value="15">									
														<input type="hidden" name="Altura" id="Altura" placeholder="Altura" value="5">
														<input type="hidden" name="Diametro" id="Diametro" placeholder="Diametro" value="0">		
														<input type="hidden" name="MaoPropria" id="MaoPropria" placeholder="MaoPropria" value="N">
														<input type="hidden" name="ValorDeclarado" id="ValorDeclarado" placeholder="ValorDeclarado" value="0">
														<input type="hidden" name="AvisoRecebimento" id="AvisoRecebimento" placeholder="AvisoRecebimento" value="N">
														<div class="row ">
															<div class="col-sm-6 col-md-4 ">
																<label class="" for="Cep">Cep:</label><br>
																<div class="input-group">
																	<input type="text" class="form-control btn-sm Numero" maxlength="8" <?php echo $readonly; ?> id="Cep" name="Cep" value="<?php echo $orcatrata['Cep']; ?>">
																	<span class="input-group-btn">
																		<button class="btn btn-success btn-md" type="button" onclick="Procuraendereco()">
																			Buscar/Calcular
																		</button>
																	</span>
																</div>
																<?php echo form_error('Cep'); ?>
															</div>
															<div class="col-sm-6 col-md-4 ">
																<label class="" for="Logradouro">Endreço:</label>
																<input type="text" class="form-control " id="Logradouro" maxlength="100" <?php echo $readonly; ?>
																	   name="Logradouro" value="<?php echo $orcatrata['Logradouro']; ?>">
																<?php echo form_error('Logradouro'); ?>
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Numero">Número:</label>
																<input type="text" class="form-control " id="Numero" maxlength="100" <?php echo $readonly; ?>
																	   name="Numero" value="<?php echo $orcatrata['Numero']; ?>">
																<?php echo form_error('Numero'); ?>
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Complemento">Complemento:</label>
																<input type="text" class="form-control " id="Complemento" maxlength="100" <?php echo $readonly; ?>
																	   name="Complemento" value="<?php echo $orcatrata['Complemento']; ?>">
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Bairro">Bairro:</label>
																<input type="text" class="form-control " id="Bairro" maxlength="100" <?php echo $readonly; ?>
																	   name="Bairro" value="<?php echo $orcatrata['Bairro']; ?>">
																<?php echo form_error('Bairro'); ?>
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Cidade">Cidade:</label>
																<input type="text" class="form-control " id="Cidade" maxlength="100" <?php echo $readonly; ?>
																	   name="Cidade" value="<?php echo $orcatrata['Cidade']; ?>">
																<?php echo form_error('Cidade'); ?>
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Estado">Estado:</label>
																<input type="text" class="form-control " id="Estado" maxlength="2" <?php echo $readonly; ?>
																	   name="Estado" value="<?php echo $orcatrata['Estado']; ?>">
																<?php echo form_error('Estado'); ?>
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Referencia">Referencia:</label>
																<textarea class="form-control " id="Referencia" <?php echo $readonly; ?>
																		  name="Referencia"><?php echo $orcatrata['Referencia']; ?>
																</textarea>
															</div>	
															<div class="col-sm-4 col-md-4 text-left">
																<label for="AtualizaEndereco">Atualizar End.?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['AtualizaEndereco'] as $key => $row) {
																		if (!$cadastrar['AtualizaEndereco'])$cadastrar['AtualizaEndereco'] = 'N';

																		($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($cadastrar['AtualizaEndereco'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="AtualizaEndereco_' . $hideshow . '">'
																			. '<input type="radio" name="AtualizaEndereco" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="AtualizaEndereco_' . $hideshow . '">'
																			. '<input type="radio" name="AtualizaEndereco" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
															<!--
															<div class="col-md-3">
																<label for="Municipio">Município:</label><br>
																<select data-placeholder="Selecione um Município..." class="form-control" <?php echo $disabled; ?>
																		id="Municipio" name="Municipio">
																	<option value="">-- Selec.um Município --</option>
																	<?php
																	/*
																	foreach ($select['Municipio'] as $key => $row) {
																		if ($orcatrata['Municipio'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	*/
																	?>
																</select>
															</div>
															-->
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-sm-4 col-md-4 col-lg-4 ">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
																			<label for="PrazoProdServ">Prazo Loja</label>
																			<div  class="input-group" id="txtHint">
																				<input type="text" class="form-control " id="PrazoProdServ" maxlength="100" <?php echo $readonly; ?>
																						onkeyup="calculaPrazoEntrega()"
																					   name="PrazoProdServ" value="<?php echo $orcatrata['PrazoProdServ']; ?>">
																				<span class="input-group-addon" id="basic-addon1">Dias</span>	   
																			</div>
																		</div>
																		<span class="ResultadoPrecoPrazo "></span>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
																			<label for="PrazoCorreios">Prazo Correios</label>
																			<div  class="input-group" id="txtHint">
																				<input type="text" class="form-control " id="PrazoCorreios" maxlength="100" readonly=""
																					onkeyup="calculaPrazoEntrega()"
																					name="PrazoCorreios" value="<?php echo $orcatrata['PrazoCorreios']; ?>">
																				<span class="input-group-addon" id="basic-addon1">Dias</span>   
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
														</div>
														<div class="col-sm-4 col-md-4 col-lg-4 ">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12  col-lg-6 mb-3">
																			<label for="PrazoEntrega">Prazo Total</label>
																			<div  class="input-group" id="txtHint">
																				<input type="text" class="form-control " id="PrazoEntrega" maxlength="100" <?php echo $readonly; ?> readonly=""
																					   name="PrazoEntrega" value="<?php echo $orcatrata['PrazoEntrega']; ?>">
																				<span class="input-group-addon" id="basic-addon1">Dias</span> 
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12  col-lg-6 mb-3">
																			<label for="DataEntregaOrca">Data da Entrega</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()"
																						id="DataEntregaOrca" name="DataEntregaOrca" value="<?php echo $orcatrata['DataEntregaOrca']; ?>" <?php echo $readonly_cons; ?>>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-sm-4 col-md-4">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<div class="row">	
																		<div class="col-xs-12 col-sm-12 col-md-12  col-lg-6 mb-3">
																			<label for="HoraEntregaOrca">Hora da Entrega:</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																					   accept=""name="HoraEntregaOrca" value="<?php echo $orcatrata['HoraEntregaOrca']; ?>"  <?php echo $readonly_cons; ?>>
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12  col-lg-6 mb-3">
																			<label for="ValorFrete">Taxa de Entrega:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon " id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorFrete" maxlength="10" placeholder="0,00" 
																					  onkeyup="calculaTotal()" name="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>">
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
									<?php }else{ ?>
										<input type="hidden" class="form-control Valor" name="ValorFrete" id="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>"/>
										<input type="hidden" name="DataEntregaOrca" id="DataEntregaOrca" value="<?php echo $orcatrata['DataEntregaOrca']; ?>">
									<?php } ?>																							
									<br>
									<div class="form-group">
										<div class="panel panel-success">
											<div class="panel-heading">
												<h4 class="mb-3"><b>Pagamento</b></h4>
												<div class="row">
													<div class="col-sm-4 col-md-4 col-lg-4">
														<div class="panel panel-info">
															<div class="panel-heading">
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="ValorSomaOrca">Total:</label>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon " id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" name="ValorSomaOrca" id="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>" readonly=''/>
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 text-left">
																			<label for="TipoExtraOrca">Tipo de Extra</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['TipoExtraOrca'] as $key => $row) {
																					(!$orcatrata['TipoExtraOrca']) ? $orcatrata['TipoExtraOrca'] = 'V' : FALSE;
																					if ($orcatrata['TipoExtraOrca'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_TipoExtraOrca" id="radiobutton_TipoExtraOrca' . $key . '">'
																						. '<input type="radio" name="TipoExtraOrca" id="radiobutton" '
																						. 'onchange="tipoExtraOrca(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_TipoExtraOrca" id="radiobutton_TipoExtraOrca' . $key . '">'
																						. '<input type="radio" name="TipoExtraOrca" id="radiobutton" '
																						. 'onchange="tipoExtraOrca(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																<?php }else{ ?>
																	<input type="text" class="form-control Valor" name="ValorSomaOrca" id="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>" readonly=''/>
																	<input type="hidden" name="TipoExtraOrca" id="TipoExtraOrca" value="<?php echo $orcatrata['TipoExtraOrca'] ?>">
																<?php } ?>
																<div class="row">
																	<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="PercExtraOrca">Percent. do Extra</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																				<input type="text" class="form-control Valor" id="PercExtraOrca" maxlength="10" placeholder="0,00"
																					   onkeyup="percExtraOrca()"
																					   name="PercExtraOrca" value="<?php echo $orcatrata['PercExtraOrca'] ?>">
																			</div>
																		</div>
																	<?php }else{ ?>
																		<input type="hidden" class="form-control Valor" id="PercExtraOrca" name="PercExtraOrca" value="<?php echo $orcatrata['PercExtraOrca'] ?>">
																	<?php } ?>
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																		<label for="ValorExtraOrca">Valor do Extra:</label>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon " id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorExtraOrca" maxlength="10" placeholder="0,00" 
																					onkeyup="valorExtraOrca()"
																				   name="ValorExtraOrca" value="<?php echo $orcatrata['ValorExtraOrca'] ?>">
																		</div>
																	</div>
																</div>
																<input type="hidden" id="Hidden_TipoExtraOrca" value="<?php echo $orcatrata['TipoExtraOrca'] ?>">
															</div>
														</div>
													</div>
													
													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
														<div class="col-sm-4 col-md-4 col-lg-4">
															<div class="panel panel-danger">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="ValorTotalOrca">Total C/Extra</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" name="ValorTotalOrca" id="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>" readonly=''/>
																			</div>
																		</div>
																		<input type="hidden" class="form-control" id="UsarE" name="UsarE" value="<?php echo $cadastrar['UsarE']; ?>"/>
																		<input type="hidden" id="UsarC" name="UsarC" value="<?php echo $cadastrar['UsarC']; ?>"/>
																		<div id="UsarC1" class="col-xs-12 col-sm-12 col-md-12 col-lg-6 text-left" style="display:<?php echo $cadastrar['UsarC']; ?>">
																			<label for="TipoDescOrca">Tipo de Desc</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['TipoDescOrca'] as $key => $row) {
																					(!$orcatrata['TipoDescOrca']) ? $orcatrata['TipoDescOrca'] = 'V' : FALSE;

																					if ($orcatrata['TipoDescOrca'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_TipoDescOrca" id="radiobutton_TipoDescOrca' . $key . '">'
																						. '<input type="radio" name="TipoDescOrca" id="radiobutton" '
																						. 'onchange="tipoDescOrca(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_TipoDescOrca" id="radiobutton_TipoDescOrca' . $key . '">'
																						. '<input type="radio" name="TipoDescOrca" id="radiobutton" '
																						. 'onchange="tipoDescOrca(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																		<input type="hidden" id="UsarD" name="UsarD" value="<?php echo $cadastrar['UsarD']; ?>"/>
																		<div id="UsarD1" class="col-xs-12 col-sm-12 col-md-12 col-lg-6 text-left" style="display:<?php echo $cadastrar['UsarD']; ?>">
																			<label for="TipoDescOrca">Tipo de Desc</label><br>
																			<?php 
																				if($cadastrar['UsarE']){
																					if($cadastrar['UsarE'] == 'V'){
																						$UsarE = 'R$';
																					}elseif($cadastrar['UsarE'] == 'P'){
																						$UsarE = '%';
																					}else{
																						$UsarE = '';
																					}
																				}else{
																					$UsarE = '';
																				} 
																			?>
																			<input type="text" class="form-control"  id="UsarE1" value="<?php echo $UsarE; ?>" readonly=''/>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="DescPercOrca">Perc. do Desconto</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																				<input type="text" class="form-control Valor" name="DescPercOrca" id="DescPercOrca" maxlength="10" placeholder="0,00"
																					   onkeyup="descPercOrca()" value="<?php echo $orcatrata['DescPercOrca'] ?>">
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="DescValorOrca">Valor do Desconto</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" name="DescValorOrca" id="DescValorOrca" maxlength="10" placeholder="0,00"
																					   onkeyup="descValorOrca()" value="<?php echo $orcatrata['DescValorOrca'] ?>">
																			</div>
																		</div>	
																	</div>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 text-left">
																			<label for="UsarCupom">Usar Cupom?</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['UsarCupom'] as $key => $row) {
																					if (!$orcatrata['UsarCupom'])$orcatrata['UsarCupom'] = 'N';

																					($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																					if ($orcatrata['UsarCupom'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="UsarCupom_' . $hideshow . '">'
																						. '<input type="radio" name="UsarCupom" id="' . $hideshow . '" '
																						. 'onchange="usarcupom(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="UsarCupom_' . $hideshow . '">'
																						. '<input type="radio" name="UsarCupom" id="' . $hideshow . '" '
																						. 'onchange="usarcupom(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																		<div id="UsarCupom" <?php echo $div['UsarCupom']; ?>>	
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																				<label for="Cupom">Cupom <span class="modal-title" id="Hidden_CodigoCupom"><?php echo $cadastrar['CodigoCupom'];?></span> </label><br>
																				<div class="input-group" id="txtHint">
																					<span class="input-group-addon" id="basic-addon1">Nº</span>
																					<input type="text" class="form-control Numero" name="Cupom" id="Cupom" maxlength="11" placeholder="1234"
																						   onkeyup="cupom()" value="<?php echo $orcatrata['Cupom'] ?>">
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			<h3 class="modal-title text-center" id="Hidden_MensagemCupom"><?php echo $cadastrar['MensagemCupom'];?></h3>
																		</div>
																		<input type="hidden" id="CodigoCupom" name="CodigoCupom" value="<?php echo $cadastrar['CodigoCupom'];?>"/>
																		<input type="hidden" id="MensagemCupom" name="MensagemCupom" value="<?php echo $cadastrar['MensagemCupom'];?>"/>
																	</div>
																</div>
															</div>
														</div>
													<?php }else{ ?>
														<input type="hidden" name="TipoDescOrca" id="TipoDescOrca" value="<?php echo $orcatrata['TipoDescOrca'] ?>"/>
														<input type="hidden" class="form-control Valor" name="DescValorOrca" id="DescValorOrca" value="<?php echo $orcatrata['DescValorOrca'] ?>"/>
														<input type="hidden" class="form-control Valor" name="DescPercOrca" id="DescPercOrca" value="<?php echo $orcatrata['DescPercOrca'] ?>"/>
														<input type="text" class="form-control Valor" name="ValorTotalOrca" id="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>">
													<?php } ?>
													<input type="hidden" name="ValidaCupom" id="ValidaCupom" value="<?php echo $cadastrar['ValidaCupom'] ?>">
													<input type="hidden" id="Hidden_TipoDescOrca" value="<?php echo $orcatrata['TipoDescOrca'] ?>">
													<input type="hidden" id="Hidden_UsarCupom" value="<?php echo $orcatrata['UsarCupom'] ?>">
													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
														<div class="col-sm-4 col-md-4 col-lg-4">
															<div class="panel panel-primary">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="SubValorFinal">Total C/Desc</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" name="SubValorFinal" id="SubValorFinal" value="<?php echo $orcatrata['SubValorFinal'] ?>" readonly=''/>
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 text-left">
																			<label for="UsarCashBack">Usar CashBack?</label><br>
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['UsarCashBack'] as $key => $row) {
																					if (!$orcatrata['UsarCashBack'])$orcatrata['UsarCashBack'] = 'N';

																					($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																					if ($orcatrata['UsarCashBack'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="UsarCashBack_' . $hideshow . '">'
																						. '<input type="radio" name="UsarCashBack" id="' . $hideshow . '" '
																						//. 'onchange="descValorOrca(this.value)" '
																						. 'onchange="usarcashback(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="UsarCashBack_' . $hideshow . '">'
																						. '<input type="radio" name="UsarCashBack" id="' . $hideshow . '" '
																						//. 'onchange="descValorOrca(this.value)" '
																						. 'onchange="usarcashback(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="CashBackOrca">CashBack.</label><br>
																			<div class="input-group " id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input style="color: #FF0000" type="text" class="form-control Valor " id="CashBackOrca" readonly=''
																					   name="CashBackOrca" value="<?php echo $orcatrata['CashBackOrca'] ?>">
																			</div>
																		</div>												
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="ValidadeCashBackOrca">Validade</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" id="ValidadeCashBackOrca" maxlength="10" placeholder="DD/MM/AAAA"
																					   name="ValidadeCashBackOrca" value="<?php echo $orcatrata['ValidadeCashBackOrca']; ?>" readonly=''>																			
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			<label for="ValorFinalOrca">Valor Final desta O.S.:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorFinalOrca" maxlength="10" placeholder="0,00" readonly=''
																					   name="ValorFinalOrca" value="<?php echo $orcatrata['ValorFinalOrca'] ?>">
																			</div>
																		</div>
																	</div>
																	<?php if($Recorrencias > 1) { ?>
																		<div class="row">
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																				<label>Valor das outras <?php echo $Recorrencias_outras; ?> O.S.</label><br>
																				<div class="input-group">
																					<span class="input-group-addon">R$</span>
																					<input type="text" class="form-control Valor" id="Valor_C_Desc" name="Valor_C_Desc" value="<?php echo $cadastrar['Valor_C_Desc'] ?>" readonly=''>
																				</div>
																			</div>
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																				<label>Valor Final das <?php echo $Recorrencias; ?> O.S.</label><br>
																				<div class="input-group">
																					<span class="input-group-addon">R$</span>
																					<input type="text" class="form-control Valor" id="Valor_S_Desc" name="Valor_S_Desc" value="<?php echo $cadastrar['Valor_S_Desc'] ?>" readonly=''>
																				</div>
																			</div>
																		</div>
																	<?php } ?>
																</div>
															</div>	
														</div>
													<?php }else{ ?>
														<input type="hidden" name="UsarCashBack" id="UsarCashBack" value="<?php echo $orcatrata['UsarCashBack'] ?>"/>
														<input type="text" class="form-control Valor" name="SubValorFinal" id="SubValorFinal" value="<?php echo $orcatrata['SubValorFinal'] ?>" readonly=''/>
														<input type="text" class="form-control Valor" name="CashBackOrca" id="CashBackOrca" value="<?php echo $orcatrata['CashBackOrca'] ?>" readonly=''/>
														<input type="text" class="form-control Valor" name="ValorFinalOrca" id="ValorFinalOrca" value="<?php echo $orcatrata['ValorFinalOrca'] ?>" readonly=''/>
													<?php } ?>
													<input type="hidden" id="Hidden_UsarCashBack" value="<?php echo $orcatrata['UsarCashBack'] ?>">		
												</div>
												<br>
												<div class="row">
													<div class="col-sm-4 col-md-4 col-lg-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">	
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<label for="Descricao">Obs/Descrição:</label>
																		<textarea class="form-control" id="Descricao" <?php echo $readonly; ?> 
																		placeholder="Observaçoes:" name="Descricao" value="<?php echo $orcatrata['Descricao']; ?>"><?php echo $orcatrata['Descricao']; ?></textarea>
																	</div>
																</div>	
															</div>
														</div>
													</div>
													<div class="col-sm-4 col-md-4 col-lg-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
																			<label for="AVAP">Local do Pagamento:</label><br>
																			<div class="btn-block" data-toggle="buttons">
																				<?php
																				foreach ($select['AVAP'] as $key => $row) {
																					(!$orcatrata['AVAP']) ? $orcatrata['AVAP'] = 'V' : FALSE;
																					#if (!$orcatrata['AVAP'])$orcatrata['AVAP'] = V;
																					($key != 'V') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																					if ($orcatrata['AVAP'] == $key) {
																						echo ''
																						. '<label class="btn btn-default active" name="radio" id="radio' . $key . '">'
																						. '<input type="radio" name="AVAP" id="' . $hideshow . '" '
																						. 'onchange="formaPag(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																						. '<input type="radio" name="AVAP" id="' . $hideshow . '"'
																						. 'onchange="formaPag(this.value)" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	</div>
																<?php }else{ ?>
																	<input type="hidden" name="AVAP" id="AVAP" value="<?php echo $orcatrata['AVAP'] ?>"/>
																<?php } ?>
																<div class="row">
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<label for="FormaPagamento">Forma de Pagamento</label>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
																			data-toggle="collapse" onchange="exibirTroco(this.value),dateDiff()" <?php echo $readonly; ?>
																				data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																				id="FormaPagamento" name="FormaPagamento">
																			<option value="">-- Selecione uma opção --</option>
																			<?php
																			foreach ($select['FormaPagamento'] as $key => $row) {
																				if ($orcatrata['FormaPagamento'] == $key) {
																					echo'<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo'<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																		<?php echo form_error('FormaPagamento'); ?>
																	</div>
																</div>
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																	<div class="row Exibir_Troco">	
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="ValorDinheiro">Troco para:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorDinheiro" maxlength="10" placeholder="0,00" 
																					   onkeyup="calculaTroco(this.value)" onchange="calculaTroco(this.value)"
																					   name="ValorDinheiro" value="<?php echo $orcatrata['ValorDinheiro'] ?>">
																			</div>
																		</div>	
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="ValorTroco">Valor do Troco:</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorTroco" maxlength="10" placeholder="0,00" readonly=""
																					   name="ValorTroco" value="<?php echo $orcatrata['ValorTroco'] ?>">
																			</div>
																		</div>
																	</div>
																<?php }else{ ?>
																	<input type="hidden" class="form-control Valor" name="ValorDinheiro" id="ValorDinheiro" value="<?php echo $orcatrata['ValorDinheiro'] ?>"/>
																	<input type="hidden" class="form-control Valor" name="ValorTroco" id="ValorTroco" value="<?php echo $orcatrata['ValorTroco'] ?>"/>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="col-sm-4 col-md-4 col-lg-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">																
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																		<label for="QtdParcelasOrca">Parcelas</label><br>
																		<input type="text" class="form-control Numero" id="QtdParcelasOrca" maxlength="3" placeholder="0"
																			   data-toggle="collapse" onkeyup="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																			   name="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>">
																		<?php echo form_error('QtdParcelasOrca'); ?>		
																	</div>												
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																		<label for="DataVencimentoOrca">Venc.</label>
																		<div class="input-group <?php echo $datepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" id="DataVencimentoOrca" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																				   data-toggle="collapse" onkeyup="calculaParcelas()" onchange="calculaParcelas()"
																					data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																				   name="DataVencimentoOrca" value="<?php echo $orcatrata['DataVencimentoOrca']; ?>">																			
																		</div>
																		<?php echo form_error('DataVencimentoOrca'); ?>	
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																		<label for="Modalidade">Dividido/ Mensal</label><br>
																		<div class="btn-block" data-toggle="buttons">
																			<?php
																			foreach ($select['Modalidade'] as $key => $row) {
																				(!$orcatrata['Modalidade']) ? $orcatrata['Modalidade'] = 'P' : FALSE;

																				if ($orcatrata['Modalidade'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Modalidade" id="radiobutton_Modalidade' .  $key . '">'
																					. '<input type="radio" name="Modalidade" id="radiobuttondinamico" ' 
																					. 'onchange="calculaParcelas(this.value)" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Modalidade" id="radiobutton_Modalidade' .  $key . '">'
																					. '<input type="radio" name="Modalidade" id="radiobuttondinamico" '
																					. 'onchange="calculaParcelas(this.value)" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>	
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 text-left">
																		<label for="BrindeOrca">PermitirTotal=0,00?</label><br>
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['BrindeOrca'] as $key => $row) {
																				if (!$orcatrata['BrindeOrca'])$orcatrata['BrindeOrca'] = 'N';

																				($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																				if ($orcatrata['BrindeOrca'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="BrindeOrca_' . $hideshow . '">'
																					. '<input type="radio" name="BrindeOrca" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="BrindeOrca_' . $hideshow . '">'
																					. '<input type="radio" name="BrindeOrca" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div id="BrindeOrca" <?php echo $div['BrindeOrca']; ?>>
																	<?php echo form_error('BrindeOrca'); ?>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div>
												
													<h4 class="mb-3"><b>Parcelas</b></h4>
													
													<?php echo form_error('ValorFinalOrca'); ?>
													
													<div class="input_fields_parcelas">
														<?php if(isset($orcatrata['QtdParcelasOrca']) && $valortotalorca > 0.00) { ?>
															<?php
															for ($i=1; $i <= $orcatrata['QtdParcelasOrca']; $i++) {
															?>

																<?php if ($metodo > 1) { ?>
																<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
																<?php } ?>

																<div class="form-group">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-sm-3 col-md-2 col-lg-1">
																					<label for="Parcela">Prcl.:<?php echo $i ?></label><br>
																					<input type="text" class="form-control" maxlength="6" readonly=""
																						   name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-2">
																					<label for="ValorParcela">Valor Parcela:</label><br>
																					<div class="input-group" id="txtHint">
																						<span class="input-group-addon" id="basic-addon1">R$</span>
																						<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>"
																							   name="ValorParcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																					</div>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-2">
																					<label for="DataVencimento">Vencimento</label>
																					<div class="input-group DatePicker">
																						<span class="input-group-addon" disabled>
																							<span class="glyphicon glyphicon-calendar"></span>
																						</span>
																						<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																							   name="DataVencimento<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">
																						
																					</div>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-2">
																					<label for="FormaPagamentoParcela<?php echo $i ?>">FormaPagParcela</label>
																					<?php if ($i == 1) { ?>
																					<?php } ?>
																					<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																							 id="FormaPagamentoParcela<?php echo $i ?>" name="FormaPagamentoParcela<?php echo $i ?>">
																						<option value="">-- Sel.FormaPag --</option>
																						<?php
																						foreach ($select['FormaPagamentoParcela'] as $key => $row) {
																							if ($parcelasrec[$i]['FormaPagamentoParcela'] == $key) {
																								echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																							} else {
																								echo '<option value="' . $key . '">' . $row . '</option>';
																							}
																						}
																						?>
																					</select>
																				</div>
																				<div class="col-sm-3  col-md-2 col-lg-2">
																					<label for="Quitado">Parc. Paga?</label><br>
																					<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																						<div class="btn-group" data-toggle="buttons">
																							<?php
																							/*
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
																							*/
																							foreach ($select['Quitado'] as $key => $row) {
																								if (!$parcelasrec[$i]['Quitado'])$parcelasrec[$i]['Quitado'] = 'N';
																								($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																								if ($parcelasrec[$i]['Quitado'] == $key) {
																									echo ''
																									. '<label class="btn btn-warning active" name="Quitado' . $i . '_' . $hideshow . '">'
																									. '<input type="radio" name="Quitado' . $i . '" id="' . $hideshow . '" '
																									. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																									. 'autocomplete="off" value="' . $key . '" checked>' . $row
																									. '</label>'
																									;
																								} else {
																									echo ''
																									. '<label class="btn btn-default" name="Quitado' . $i . '_' . $hideshow . '">'
																									. '<input type="radio" name="Quitado' . $i . '" id="' . $hideshow . '" '
																									. 'onchange="carregaQuitado(this.value,this.name,'.$i.')" '
																									. 'autocomplete="off" value="' . $key . '" >' . $row
																									. '</label>'
																									;
																								}
																							}
																							?>
																						</div>
																					<?php }else{ ?>
																						<input type="hidden" name="Quitado<?php echo $i ?>" id="Quitado<?php echo $i ?>"  value="<?php echo $parcelasrec[$i]['Quitado']; ?>"/>
																						<span><?php if($parcelasrec[$i]['Quitado'] == "S") {
																										echo 'Sim';
																									} elseif($parcelasrec[$i]['Quitado'] == "N"){
																										echo 'Não';
																									}else{
																										echo 'Não';
																									}?>
																						</span>
																					<?php } ?>
																				</div>
																				<div class="col-sm-3  col-md-3 col-lg-2">
																					<div id="Quitado<?php echo $i ?>" <?php echo $div['Quitado' . $i]; ?>>
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
														<?php
														}
														?>
													</div>
												</div>
											</div>
										</div>
										<br>
										<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
											<div class="panel panel-default">
												<div class="panel-heading text-left">
													<h4 class="mb-3"><b>Procedimentos</b></h4>
													<!--
													<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Procedimentos" aria-expanded="false" aria-controls="Procedimentos">
														<span class="glyphicon glyphicon-menu-down"></span> Procedimentos
													</a>
													-->
													<div <?php echo $collapse; ?> id="Procedimentos">
														

														<input type="hidden" name="PMCount" id="PMCount" value="<?php echo $count['PMCount']; ?>"/>

														<div class="input_fields_wrap3">

														<?php
														for ($i=1; $i <= $count['PMCount']; $i++) {
														?>

														<?php if ($metodo > 1) { ?>
														<input type="hidden" name="idApp_Procedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['idApp_Procedimento']; ?>"/>
														<?php } ?>

														<div class="form-group" id="3div<?php echo $i ?>">
															<div class="panel panel-success">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-sm-5 col-md-5 col-lg-4">
																			<input type="hidden" name="idSis_Usuario<?php echo $i ?>" id="idSis_Usuario<?php echo $i ?>" value="<?php echo $procedimento[$i]['idSis_Usuario'] ?>"/>
																			<label for="Procedimento<?php echo $i ?>">
																				Proced. <?php echo $i ?>: 
																				<?php if ($procedimento[$i]['idSis_Usuario']) { ?>
																					<?php echo $_SESSION['Procedimento'][$i]['Nome'];?>
																				<?php } ?>
																			</label>
																			<textarea class="form-control" id="Procedimento<?php echo $i ?>" <?php echo $readonly; ?> 
																					  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
																		</div>
																		<div class="col-sm-4 col-md-5 col-lg-4">
																			<label for="Compartilhar<?php echo $i ?>">Quem Fazer:</label>
																			<?php if ($i == 1) { ?>
																			<?php } ?>
																			<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
																					 id="listadinamica_comp<?php echo $i ?>" name="Compartilhar<?php echo $i ?>">
																				<option value="">-- Selecione uma opção --</option>
																				<?php
																				foreach ($select['Compartilhar'] as $key => $row) {
																					if ($procedimento[$i]['Compartilhar'] == $key) {
																						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																					} else {
																						echo '<option value="' . $key . '">' . $row . '</option>';
																					}
																				}
																				?>
																			</select>
																		</div>
																		<div class="col-sm-3 col-md-2 col-lg-2 text-left">
																			<label for="ConcluidoProcedimento">Concluido? </label><br>
																			<?php if ($_SESSION['Usuario']['Bx_Prc'] == "S") { ?>
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['ConcluidoProcedimento'] as $key => $row) {
																						if (!$procedimento[$i]['ConcluidoProcedimento'])$procedimento[$i]['ConcluidoProcedimento'] = 'N';
																						($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																						if ($procedimento[$i]['ConcluidoProcedimento'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="ConcluidoProcedimento' . $i . '_' . $hideshow . '">'
																							. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="' . $hideshow . '" '
																							. 'onchange="carregaConclProc(this.value,this.name,'.$i.',0)" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="ConcluidoProcedimento' . $i . '_' . $hideshow . '">'
																							. '<input type="radio" name="ConcluidoProcedimento' . $i . '" id="' . $hideshow . '" '
																							. 'onchange="carregaConclProc(this.value,this.name,'.$i.',0)" '
																							. 'autocomplete="off" value="' . $key . '" >' . $row
																							. '</label>'
																							;
																						}
																					}
																					?>
																				</div>
																			<?php }else{ ?>
																				<input type="hidden" name="ConcluidoProcedimento<?php echo $i ?>" id="ConcluidoProcedimento<?php echo $i ?>"  value="<?php echo $procedimento[$i]['ConcluidoProcedimento']; ?>"/>
																				<span>
																					<?php 
																						if($procedimento[$i]['ConcluidoProcedimento'] == "S") {
																								echo 'Sim';
																						} elseif($procedimento[$i]['ConcluidoProcedimento'] == "N"){
																							echo 'Não';
																						}else{
																							echo 'Não';
																						}
																					?>
																				</span>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-sm-3 col-md-3 col-lg-2">
																			<label for="DataProcedimento<?php echo $i ?>">Data do Proced.:</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=""
																					   name="DataProcedimento<?php echo $i ?>" id="DataProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimento']; ?>">
																			</div>
																		</div>
																		<div class="col-sm-3 col-md-2 col-lg-2">
																			<label for="HoraProcedimento<?php echo $i ?>">Hora Concl</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM" readonly=""
																					   name="HoraProcedimento<?php echo $i ?>" id="HoraProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['HoraProcedimento']; ?>">
																			</div>
																		</div>
																		<div class="col-md-5 col-lg-4">
																			<div class="row">
																				<div id="ConcluidoProcedimento<?php echo $i ?>" <?php echo $div['ConcluidoProcedimento' . $i]; ?>>
																					<div class="col-sm-3 col-md-7 col-lg-6">
																						<label for="DataConcluidoProcedimento<?php echo $i ?>">Data Concl</label>
																						<div class="input-group <?php echo $datepicker; ?>">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-calendar"></span>
																							</span>
																							<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=""
																								   name="DataConcluidoProcedimento<?php echo $i ?>" id="DataConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataConcluidoProcedimento']; ?>">
																						</div>
																					</div>
																					<div class="col-sm-3 col-md-5 col-lg-6">
																						<label for="HoraConcluidoProcedimento<?php echo $i ?>">Hora Concl.</label>
																						<div class="input-group <?php echo $timepicker; ?>">
																							<span class="input-group-addon" disabled>
																								<span class="glyphicon glyphicon-time"></span>
																							</span>
																							<input type="text" class="form-control Time" readonly="" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM" readonly=""
																								   name="HoraConcluidoProcedimento<?php echo $i ?>" id="HoraConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['HoraConcluidoProcedimento']; ?>">
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-sm-8 col-md-1 col-lg-1">
																			<label><br></label><br>
																			<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																				<span class="glyphicon glyphicon-trash"></span>
																			</button>
																		</div>
																	</div>
																	<!--
																	<div class="row">
																		<div class="col-md-3">
																			<label for="idSis_Usuario<?php echo $i ?>">Profissional:</label>
																			<?php if ($i == 1) { ?>
																			<?php } ?>
																			<select data-placeholder="Selecione uma opção..." class="form-control" readonly=""
																					 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?>">
																				<option value="">-- Selecione uma opção --</option>
																				<?php
																				/*
																				foreach ($select['idSis_Usuario'] as $key => $row) {
																					if ($procedimento[$i]['idSis_Usuario'] == $key) {
																						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																					} else {
																						echo '<option value="' . $key . '">' . $row . '</option>';
																					}
																				}
																				*/
																				?>
																			</select>
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
														<div class="row">
															<div class="col-md-4">
																<a class="add_field_button3 btn btn btn-warning" onclick="adicionaProcedimento()">
																	<span class="glyphicon glyphicon-plus"></span> Adic. Procedimento
																</a>
															</div>
														</div>
													</div>
												</div>	
											</div>
											<br>
										<?php } ?>
										<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="mb-3"><b>Status do Pedido</b></h4>
													<div class="row">	
														<div id="FinalizadoOrca" <?php echo $div['FinalizadoOrca']; ?>>
															<div class="col-sm-3 col-md-2">
																<div class="panel panel-danger">
																	<div class="panel-heading">
																		<div class="row">
																			<div class="col-md-12 text-left">
																				<label for="CombinadoFrete">Aprovado Entrega?</label><br>
																				<div class="btn-larg-right btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['CombinadoFrete'] as $key => $row) {
																						//if (!$orcatrata['CombinadoFrete'])$orcatrata['CombinadoFrete'] = 'S';
																						($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																						if ($orcatrata['CombinadoFrete'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="CombinadoFrete_' . $hideshow . '">'
																							. '<input type="radio" name="CombinadoFrete" id="' . $hideshow . '" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="CombinadoFrete_' . $hideshow . '">'
																							. '<input type="radio" name="CombinadoFrete" id="' . $hideshow . '" '
																							. 'autocomplete="off" value="' . $key . '" >' . $row
																							. '</label>'
																							;
																						}
																					}
																					?>
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-12 text-left">
																				<label for="AprovadoOrca">Aprovado Pagam?</label><br>
																				<div class="btn-larg-right btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['AprovadoOrca'] as $key => $row) {
																						//if (!$orcatrata['AprovadoOrca'])$orcatrata['AprovadoOrca'] = 'S';
																						($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																						if ($orcatrata['AprovadoOrca'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="AprovadoOrca_' . $hideshow . '">'
																							. '<input type="radio" name="AprovadoOrca" id="' . $hideshow . '" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="AprovadoOrca_' . $hideshow . '">'
																							. '<input type="radio" name="AprovadoOrca" id="' . $hideshow . '" '
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
															<div class="col-sm-3 col-md-2">
																<div class="row">
																			<div class="col-sm-12 col-md-12">
																				<div class="panel panel-success">
																					<div class="panel-heading">
																						<div class="row">
																							<div class="col-md-12 text-left">
																								<label for="ProntoOrca">Prd.Prontos?</label><br>
																								<div class="btn-larg-right btn-group" data-toggle="buttons">
																									<?php
																									foreach ($select['ProntoOrca'] as $key => $row) {
																										if (!$orcatrata['ProntoOrca'])
																											$orcatrata['ProntoOrca'] = 'N';
																										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																										if ($orcatrata['ProntoOrca'] == $key) {
																											echo ''
																											. '<label class="btn btn-warning active" name="ProntoOrca_' . $hideshow . '">'
																											. '<input type="radio" name="ProntoOrca" id="' . $hideshow . '" '
																											. 'autocomplete="off" value="' . $key . '" checked>' . $row
																											. '</label>'
																											;
																										} else {
																											echo ''
																											. '<label class="btn btn-default" name="ProntoOrca_' . $hideshow . '">'
																											. '<input type="radio" name="ProntoOrca" id="' . $hideshow . '" '
																											. 'autocomplete="off" value="' . $key . '" >' . $row
																											. '</label>'
																											;
																										}
																									}
																									?>
																								</div>
																							</div>
																						</div>
																						<div class="row">
																							<div class="col-md-12 text-left">
																								<label for="EnviadoOrca">Enviados?</label><br>
																								<div class="btn-larg-right btn-group" data-toggle="buttons">
																									<?php
																									foreach ($select['EnviadoOrca'] as $key => $row) {
																										if (!$orcatrata['EnviadoOrca'])
																											$orcatrata['EnviadoOrca'] = 'N';
																										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																										if ($orcatrata['EnviadoOrca'] == $key) {
																											echo ''
																											. '<label class="btn btn-warning active" name="EnviadoOrca_' . $hideshow . '">'
																											. '<input type="radio" name="EnviadoOrca" id="' . $hideshow . '" '
																											. 'autocomplete="off" value="' . $key . '" checked>' . $row
																											. '</label>'
																											;
																										} else {
																											echo ''
																											. '<label class="btn btn-default" name="EnviadoOrca_' . $hideshow . '">'
																											. '<input type="radio" name="EnviadoOrca" id="' . $hideshow . '" '
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
															</div>
															<div class="col-sm-6 col-md-4">
																<div class="panel panel-warning">
																	<div class="panel-heading text-left">				
																		<div class="row">
																			<div class="col-sm-6 col-md-6 text-left">
																				<label for="ConcluidoOrca">TudoEntregue?</label><br>
																				<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
																					<div class="btn-larg-right btn-group" data-toggle="buttons">
																						<?php
																						foreach ($select['ConcluidoOrca'] as $key => $row) {
																							if (!$orcatrata['ConcluidoOrca'])$orcatrata['ConcluidoOrca'] = 'N';
																							($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																							if ($orcatrata['ConcluidoOrca'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="ConcluidoOrca_' . $hideshow . '">'
																								. '<input type="radio" name="ConcluidoOrca" id="' . $hideshow . '" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="ConcluidoOrca_' . $hideshow . '">'
																								. '<input type="radio" name="ConcluidoOrca" id="' . $hideshow . '" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>
																					</div>
																				<?php }else{ ?>
																					<input type="hidden" name="ConcluidoOrca" id="ConcluidoOrca"  value="<?php echo $orcatrata['ConcluidoOrca']; ?>"/>
																					<span>
																						<?php 
																							if($orcatrata['ConcluidoOrca'] == "S") {
																								echo 'Sim';
																							} elseif($orcatrata['ConcluidoOrca'] == "N"){
																								echo 'Não';
																							}else{
																								echo 'Não';
																							}
																						?>
																					</span>
																				<?php } ?>
																			</div>
																			<div id="ConcluidoOrca" <?php echo $div['ConcluidoOrca']; ?>>
																				<div <?php echo $textoEntregues; ?> >
																					<div class="col-sm-6 col-md-6 text-right">
																						<label for="StatusProdutos">As <strong><?php echo $Recorrencias; ?></strong> OS?</label><br>
																						<div class="btn-group" data-toggle="buttons">
																							<?php
																							foreach ($select['StatusProdutos'] as $key => $row) {
																								if (!$cadastrar['StatusProdutos'])$cadastrar['StatusProdutos'] = 'N';
																								($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																								if ($cadastrar['StatusProdutos'] == $key) {
																									echo ''
																									. '<label class="btn btn-warning active" name="StatusProdutos_' . $hideshow . '">'
																									. '<input type="radio" name="StatusProdutos" id="' . $hideshow . '" '
																									. 'autocomplete="off" value="' . $key . '" checked>' . $row
																									. '</label>'
																									;
																								} else {
																									echo ''
																									. '<label class="btn btn-default" name="StatusProdutos_' . $hideshow . '">'
																									. '<input type="radio" name="StatusProdutos" id="' . $hideshow . '" '
																									. 'autocomplete="off" value="' . $key . '" >' . $row
																									. '</label>'
																									;
																								}
																							}
																							?>
																						</div>
																					</div>
																					<!--
																					<div id="StatusProdutos" <?php echo $div['StatusProdutos']; ?>>
																						<div <?php echo $textoEntregues; ?> class="col-sm-12 col-md-12">
																							<span class="glyphicon glyphicon-alert"></span> Atenção!! + <?php echo $vinculadas; ?> O.S. vinculada(s) a esta. Todas os Produtos, de todas as O.S., receberão o status de: "Entregue"="Sim".
																							Atenção!! <strong><?php echo $Recorrencias; ?></strong> O.S.<br>"Entregue"="Sim"
																						</div>
																					</div>
																					-->
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-sm-6 col-md-6 text-left">
																				<label for="QuitadoOrca">TudoPago?</label><br>
																				<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																					<div class="btn-larg-right btn-group" data-toggle="buttons">
																						<?php
																						foreach ($select['QuitadoOrca'] as $key => $row) {
																							if (!$orcatrata['QuitadoOrca'])
																								$orcatrata['QuitadoOrca'] = 'N';
																							($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																							if ($orcatrata['QuitadoOrca'] == $key) {
																								echo ''
																								. '<label class="btn btn-warning active" name="QuitadoOrca_' . $hideshow . '">'
																								. '<input type="radio" name="QuitadoOrca" id="' . $hideshow . '" '
																								. 'autocomplete="off" value="' . $key . '" checked>' . $row
																								. '</label>'
																								;
																							} else {
																								echo ''
																								. '<label class="btn btn-default" name="QuitadoOrca_' . $hideshow . '">'
																								. '<input type="radio" name="QuitadoOrca" id="' . $hideshow . '" '
																								. 'autocomplete="off" value="' . $key . '" >' . $row
																								. '</label>'
																								;
																							}
																						}
																						?>
																					</div>
																				<?php }else{ ?>
																					<input type="hidden" name="QuitadoOrca" id="QuitadoOrca"  value="<?php echo $orcatrata['QuitadoOrca']; ?>"/>
																					<span>
																						<?php 
																							if($orcatrata['QuitadoOrca'] == "S") {
																								echo 'Sim';
																							} elseif($orcatrata['QuitadoOrca'] == "N"){
																								echo 'Não';
																							}else{
																								echo 'Não';
																							}
																						?>
																					</span>
																				<?php } ?>
																			</div>
																		
																			<div id="QuitadoOrca" <?php echo $div['QuitadoOrca']; ?>>
																			
																				<div <?php echo $textoPagas; ?> >
																					<div class="col-sm-6 col-md-6 text-right">
																						<label for="StatusParcelas">As <strong><?php echo $Recorrencias; ?></strong> OS?</label><br>
																						<div class="btn-group" data-toggle="buttons">
																							<?php
																							foreach ($select['StatusParcelas'] as $key => $row) {
																								if (!$cadastrar['StatusParcelas'])$cadastrar['StatusParcelas'] = 'N';
																								($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																								if ($cadastrar['StatusParcelas'] == $key) {
																									echo ''
																									. '<label class="btn btn-warning active" name="StatusParcelas_' . $hideshow . '">'
																									. '<input type="radio" name="StatusParcelas" id="' . $hideshow . '" '
																									. 'autocomplete="off" value="' . $key . '" checked>' . $row
																									. '</label>'
																									;
																								} else {
																									echo ''
																									. '<label class="btn btn-default" name="StatusParcelas_' . $hideshow . '">'
																									. '<input type="radio" name="StatusParcelas" id="' . $hideshow . '" '
																									. 'autocomplete="off" value="' . $key . '" >' . $row
																									. '</label>'
																									;
																								}
																							}
																							?>
																						</div>
																					</div>
																					<!--
																					<div id="StatusParcelas" <?php echo $div['StatusParcelas']; ?>>	
																						<div <?php echo $textoPagas; ?> class="col-sm-12 col-md-12">
																							<span class="glyphicon glyphicon-alert"></span> Atenção!! + <?php #echo $vinculadas; ?> O.S. Vinculada(s) a esta. Todas as parcelas, de todas as O.S., receberão o status de: "Parc.Paga"="Sim".
																							 Atenção!! <strong><?php echo $Recorrencias; ?></strong> O.S.<br>"Pago"="Sim"
																						</div>
																					</div>
																					-->
																				</div>	
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-sm-12 col-md-4">
															<div class="panel panel-primary">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-12 text-center">
																			<label for="FinalizadoOrca">Finalizado?</label><br>
																			<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																				<div class="btn-larg-right btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['FinalizadoOrca'] as $key => $row) {
																						if (!$orcatrata['FinalizadoOrca'])$orcatrata['FinalizadoOrca'] = 'N';
																						($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																						if ($orcatrata['FinalizadoOrca'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="FinalizadoOrca_' . $hideshow . '">'
																							. '<input type="radio" name="FinalizadoOrca" id="' . $hideshow . '" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="FinalizadoOrca_' . $hideshow . '">'
																							. '<input type="radio" name="FinalizadoOrca" id="' . $hideshow . '" '
																							. 'autocomplete="off" value="' . $key . '" >' . $row
																							. '</label>'
																							;
																						}
																					}
																					?>
																				</div>
																			<?php }else{ ?>
																				<input type="hidden" name="FinalizadoOrca" id="FinalizadoOrca"  value="<?php echo $orcatrata['FinalizadoOrca']; ?>"/>
																				<span>
																					<?php 
																						if($orcatrata['FinalizadoOrca'] == "S") {
																							echo 'Sim';
																						} elseif($orcatrata['FinalizadoOrca'] == "N"){
																							echo 'Não';
																						}else{
																							echo 'Não';
																						}
																					?>
																				</span>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-12 text-center">
																			<h4>Produtos e<br>Parecelas</h4>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--
													<div class="form-group ">
														<div class="row">
															<div class="col-md-4">
																<div id="ConcluidoOrca" <?php echo $div['ConcluidoOrca']; ?>>	
																	<label for="DataConclusao">Concluído em:</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataConclusao" value="<?php echo $orcatrata['DataConclusao']; ?>">
																	</div>
																	
																</div>
															</div>
															<div class="col-md-4">
																<div id="QuitadoOrca" <?php echo $div['QuitadoOrca']; ?>>	
																	<label for="DataQuitado">Quitado em:</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataQuitado" value="<?php echo $orcatrata['DataQuitado']; ?>">																				
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-md-3">
																<label for="DataRetorno">Retornar em:</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataRetorno" value="<?php echo $orcatrata['DataRetorno']; ?>">
																</div>
															</div>
														</div>
													</div>
													-->
												</div>
											</div>
											<br>
										<?php } ?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<!--<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">-->
												<input type="hidden" name="Tipo_Orca"  id="Tipo_Orca" value="<?php echo $orcatrata['Tipo_Orca']; ?>">
												<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<input type="hidden" name="Hidden_idApp_Cliente" id="Hidden_idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>" />
												<h4 class="mb-3"><b>Pedido</b></h4>
												<div class="row">
													<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">	
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<label for="Consideracoes">Informações Gerais</label>
																		<textarea class="form-control" id="Consideracoes" <?php echo $readonly; ?> 
																		placeholder="Descrição:" name="Consideracoes" value="<?php echo $orcatrata['Consideracoes']; ?>" rows="4"><?php echo $orcatrata['Consideracoes']; ?></textarea>
																	</div>
																</div>	
															</div>
														</div>
													</div>
													<?php if($this->Basico_model->get_dt_validade()) { ?>
														<?php if ($metodo > 1) { ?>
														<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
														<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
														<?php } ?>
														<?php if ($metodo == 2) { ?>
															<div class="col-md-6">
																<!--
																<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																	<span class="glyphicon glyphicon-save"></span> Salvar
																</button>
																-->
																<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																	<span class="glyphicon glyphicon-save"></span> Salvar
																</button>														
															</div>
															<div class="col-md-6 text-right">
																<label></label>
																<button  type="button" class="btn btn-md btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																	<span class="glyphicon glyphicon-trash"></span> Excluir
																</button>
															</div>
															<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																Aguarde um instante! Estamos processando sua solicitação!
															</div>
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
																				<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotao()" data-dismiss="modal">
																					<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																				</button>
																			</div>
																			<div class="col-md-6 text-right">
																				<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'orcatrata/excluir2/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																					<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																				</a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } else { ?>
															<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left"></div>	
															<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
																<!--
																<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																	<span class="glyphicon glyphicon-save"></span> Salvar
																</button>
																-->
																<button type="submit" class="btn btn-lg btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)" data-loading-text="Aguarde..." value="1" >
																	<span class="glyphicon glyphicon-save"></span> Salvar
																</button>
																<div class="alert alert-warning aguardar" role="alert" >
																	Aguarde um instante! Estamos processando sua solicitação!
																</div>														
															</div>
														<?php } ?>
													<?php } ?>		
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
		</div>
	</div>
</div>
<?php 
	if ($_SESSION['log']['idSis_Empresa'] != 5){
		if(isset($_SESSION['bd_consulta']['Whatsapp']) && $_SESSION['bd_consulta']['Whatsapp'] == "S"){
			if(isset($whatsapp_agenda)){
				echo "<script>window.open('https://api.whatsapp.com/send?phone=55".$_SESSION['bd_consulta']['CelularCliente']."&text=".$whatsapp_agenda."','1366002941508','width=700,height=350,left=375,right=375,top=300');</script>";
			}		
		}
		unset($_SESSION['bd_consulta'], $whatsapp_agenda);	
	} 
?>