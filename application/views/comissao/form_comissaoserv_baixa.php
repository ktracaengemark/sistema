<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
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
								<a type= "button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() ?>Comissao/comissaoserv_pag" role="button">
									<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo; ?>
								</a>
							</div>
							<div class="col-md-2 text-left">	
								<br>
								<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
									<?php echo $_SESSION['Filtro_Porservicos']['Total_Rows'];?> Resultados
								</a>
							</div>
							<!--
							<div class="col-md-2 text-left">	
								<br>
								<a type= "button" class="btn btn-md btn-warning btn-block" type="button" href="<?php #echo base_url() . $imprimir . $_SESSION['log']['idSis_Empresa']; ?>">
									<span class="glyphicon glyphicon-print"></span> Print.
								</a>
							</div>
							-->

							<?php if(isset($_SESSION['Filtro_Porservicos']['Funcionario']) && $_SESSION['Filtro_Porservicos']['Funcionario'] != 0){ ?>
								<div class="col-md-2 text-left">	
									<br>
									<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
										<span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['Filtro_Porservicos']['NomeFuncionario']; ?>
									</a>
								</div>
								<div class="col-md-2 text-left">	
									<br>
									<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
										<span class="glyphicon glyphicon-usd"></span>R$ <?php echo $_SESSION['Filtro_Porservicos']['ComissaoFunc']; ?> / R$ <?php echo $_SESSION['Filtro_Porservicos']['ComissaoTotal']; ?>
									</a>
								</div>
							<?php }else{ ?>
								<div class="col-md-2 text-left">	
									<br>
									<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
										<span class="glyphicon glyphicon-usd"></span>R$ <?php echo $_SESSION['Filtro_Porservicos']['SomaTotal']; ?> / R$ <?php echo $_SESSION['Filtro_Porservicos']['ComissaoTotal']; ?>
									</a>
								</div>
							<?php } ?>
							<div class="col-md-4 text-left">
								<?php echo $_SESSION['Filtro_Porservicos']['Pagination']; ?>
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

									<?php
									$linha =  $_SESSION['Filtro_Porservicos']['Per_Page']*$_SESSION['Filtro_Porservicos']['Pagina'];
									for ($i=1; $i <= $count['PRCount']; $i++) {
										$contagem = ($linha + $i);
									?>

										<input type="hidden" name="idApp_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_Produto']; ?>"/>
										<div class="form-group" id="21div<?php echo $i ?>">
											<div class="panel panel-danger">
												<div class="panel-heading">
													<div class="row">
														<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
															<label >
																<?php echo $contagem ?>/<?php echo $_SESSION['Filtro_Porservicos']['Total_Rows'];?> |
																<a class="notclickable" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Produto'][$i]['idApp_Cliente']; ?>">
																	<span class="glyphicon glyphicon-edit notclickable"></span> <?php echo $_SESSION['Produto'][$i]['idApp_Cliente']; ?>
																</a>
																| Cliente 
															</label>
															<input type="text" class="form-control " readonly="" value="<?php echo $_SESSION['Produto'][$i]['NomeCliente']; ?> | <?php echo $_SESSION['Produto'][$i]['NomeClientePet']; ?><?php echo $_SESSION['Produto'][$i]['NomeClienteDep']; ?>">
														</div>
														<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
															<label >
																<?php echo $_SESSION['Produto'][$i]['RecorrenciaOrca']; ?> | <?php echo $produto[$i]['idApp_Produto'];?> |
																<a class="notclickable" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $_SESSION['Produto'][$i]['idApp_OrcaTrata']; ?>">
																	<span class="glyphicon glyphicon-edit notclickable"></span> <?php echo $_SESSION['Produto'][$i]['idApp_OrcaTrata']; ?>
																</a>
																| Item 
															</label>
															<input type="text" class="form-control " readonly="" value="<?php echo $_SESSION['Produto'][$i]['Receita']; ?>">
														</div>
														<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
															<label for="ObsProduto<?php echo $i ?>">Obs</label>
															<textarea class="form-control" id="ObsProduto<?php echo $i ?>"
																	  name="ObsProduto<?php echo $i ?>" rows="1"><?php echo $produto[$i]['ObsProduto']; ?>
															</textarea>
														</div>
													</div>
													<div class="row">
														<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
															<label for="SubtotalServico<?php echo $i ?>">Valor Servico</label>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" id="SubtotalServico<?php echo $i ?>" readonly="" value="<?php echo $_SESSION['Produto'][$i]['SubtotalProduto'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<label for="ValorComissaoServico">Valor Comissao </label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor"  id="ValorComissaoServico<?php echo $i ?>" readonly=""
																	   name="ValorComissaoServico<?php echo $i ?>"  value="<?php echo $produto[$i]['ValorComissaoServico'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<label for="DataConcluidoProduto" >Data Entrega</label>
															<div class="input-group DatePicker">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
																<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Produto'][$i]['DataConcluidoProduto'] ?>">																
															</div>
														</div>
														<div class="col-md-2">
															<label for="StatusComissaoServico">Status Comissao</label><br>
															<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Produto'][$i]['StatusComissaoServico'] ?>">
														</div>
														<!--
														<div class="col-md-2">
															<label for="StatusComissaoServico">Status Comissao</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																/*
																foreach ($select['StatusComissaoServico'] as $key => $row) {
																	if (!$produto[$i]['StatusComissaoServico'])$produto[$i]['StatusComissaoServico'] = 'N';
																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																	if ($produto[$i]['StatusComissaoServico'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="StatusComissaoServico' . $i . '_' . $hideshow . '">'
																		. '<input type="radio" name="StatusComissaoServico' . $i . '" id="' . $hideshow . '" '
																		. 'onchange="carregaQuitado2(this.value,this.name,'.$i.',2)" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="StatusComissaoServico' . $i . '_' . $hideshow . '">'
																		. '<input type="radio" name="StatusComissaoServico' . $i . '" id="' . $hideshow . '" '
																		. 'onchange="carregaQuitado2(this.value,this.name,'.$i.',2)" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																*/
																?>
															</div>
														</div>
														<div id="StatusComissaoServico<?php #echo $i ?>" <?php #echo $div['StatusComissaoServico' . $i]; ?>>
															<div class="col-md-2">
																<label for="DataPagoComissaoServico">Data Pago Comissao</label>
																<div class="input-group DatePicker">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" id="DataPagoComissaoServico<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" 
																		   name="DataPagoComissaoServico<?php #echo $i ?>" value="<?php #echo $produto[$i]['DataPagoComissaoServico'] ?>">																
																</div>
															</div>
														</div>
														-->
													</div>
													<div class="row"   <?php echo $div['Prof_comissao']; ?>>
														<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="ProfissionalProduto_1<?php echo $i ?>">Profissional 1</label>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																			 id="listadinamica_prof_1<?php echo $i ?>" name="ProfissionalProduto_1<?php echo $i ?>" 
																				onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',1)">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select[$i]['ProfissionalProduto_1'] as $key => $row) {
																			if ($produto[$i]['ProfissionalProduto_1'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<input type="hidden" class="form-control " id="ProfissionalServico_1<?php echo $i ?>" value="<?php echo $produto[$i]['ProfissionalProduto_1'] ?>" readonly="">
																<input type="hidden" class="form-control " id="idTFProf_Servico_1<?php echo $i ?>" name="idTFProf_Servico_1<?php echo $i ?>" value="<?php echo $produto[$i]['idTFProf_1'] ?>" readonly="">
																<input type="hidden" class="form-control " id="ComFunProf_Servico_1<?php echo $i ?>" name="ComFunProf_Servico_1<?php echo $i ?>" value="<?php echo $produto[$i]['ComFunProf_1'] ?>" readonly="">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<input type="text" class="form-control Valor" id="ValorComProf_Servico_1<?php echo $i ?>" name="ValorComProf_Servico_1<?php echo $i ?>"
																		value="<?php echo $produto[$i]['ValorComProf_1'] ?>" onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)"<?php echo $cadastrar_servico[$i]['Hidden_readonly_1'];?>>
																</div>
															</div>	
														</div>
														<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="ProfissionalProduto_2<?php echo $i ?>">Profissional 2</label>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																			 id="listadinamica_prof_2<?php echo $i ?>" name="ProfissionalProduto_2<?php echo $i ?>"
																				onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',2)">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select[$i]['ProfissionalProduto_2'] as $key => $row) {
																			if ($produto[$i]['ProfissionalProduto_2'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<input type="hidden" class="form-control " id="ProfissionalServico_2<?php echo $i ?>" value="<?php echo $produto[$i]['ProfissionalProduto_2'] ?>" readonly="">
																<input type="hidden" class="form-control " id="idTFProf_Servico_2<?php echo $i ?>" name="idTFProf_Servico_2<?php echo $i ?>" value="<?php echo $produto[$i]['idTFProf_2'] ?>" readonly="">
																<input type="hidden" class="form-control " id="ComFunProf_Servico_2<?php echo $i ?>" name="ComFunProf_Servico_2<?php echo $i ?>" value="<?php echo $produto[$i]['ComFunProf_2'] ?>" readonly="">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<input type="text" class="form-control Valor" id="ValorComProf_Servico_2<?php echo $i ?>" name="ValorComProf_Servico_2<?php echo $i ?>"
																		value="<?php echo $produto[$i]['ValorComProf_2'] ?>" onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)"<?php echo $cadastrar_servico[$i]['Hidden_readonly_2'];?>>
																</div>
															</div>	
														</div>
														<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="ProfissionalProduto_3<?php echo $i ?>">Profissional 3</label>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																			 id="listadinamica_prof_3<?php echo $i ?>" name="ProfissionalProduto_3<?php echo $i ?>"
																				onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',3)">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select[$i]['ProfissionalProduto_3'] as $key => $row) {
																			if ($produto[$i]['ProfissionalProduto_3'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<input type="hidden" class="form-control " id="ProfissionalServico_3<?php echo $i ?>" value="<?php echo $produto[$i]['ProfissionalProduto_3'] ?>" readonly="">
																<input type="hidden" class="form-control " id="idTFProf_Servico_3<?php echo $i ?>" name="idTFProf_Servico_3<?php echo $i ?>" value="<?php echo $produto[$i]['idTFProf_3'] ?>" readonly="">
																<input type="hidden" class="form-control " id="ComFunProf_Servico_3<?php echo $i ?>" name="ComFunProf_Servico_3<?php echo $i ?>" value="<?php echo $produto[$i]['ComFunProf_3'] ?>" readonly="">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<input type="text" class="form-control Valor" id="ValorComProf_Servico_3<?php echo $i ?>" name="ValorComProf_Servico_3<?php echo $i ?>"
																		value="<?php echo $produto[$i]['ValorComProf_3'] ?>" onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)"<?php echo $cadastrar_servico[$i]['Hidden_readonly_3'];?>>
																</div>
															</div>	
														</div>
														<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="ProfissionalProduto_4<?php echo $i ?>">Profissional 4</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																			 id="listadinamica_prof_4<?php echo $i ?>" name="ProfissionalProduto_4<?php echo $i ?>"
																				onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',4)">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select[$i]['ProfissionalProduto_4'] as $key => $row) {
																			if ($produto[$i]['ProfissionalProduto_4'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<input type="hidden" class="form-control " id="ProfissionalServico_4<?php echo $i ?>" value="<?php echo $produto[$i]['ProfissionalProduto_4'] ?>" readonly="">
																<input type="hidden" class="form-control " id="idTFProf_Servico_4<?php echo $i ?>" name="idTFProf_Servico_4<?php echo $i ?>" value="<?php echo $produto[$i]['idTFProf_4'] ?>" readonly="">
																<input type="hidden" class="form-control " id="ComFunProf_Servico_4<?php echo $i ?>" name="ComFunProf_Servico_4<?php echo $i ?>" value="<?php echo $produto[$i]['ComFunProf_4'] ?>" readonly="">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<input type="text" class="form-control Valor" id="ValorComProf_Servico_4<?php echo $i ?>" name="ValorComProf_Servico_4<?php echo $i ?>"
																		value="<?php echo $produto[$i]['ValorComProf_4'] ?>" onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)"<?php echo $cadastrar_servico[$i]['Hidden_readonly_4'];?>>
																</div>
															</div>	
														</div>
														<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="ProfissionalProduto_5<?php echo $i ?>">Profissional 5</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																			 id="listadinamica_prof_5<?php echo $i ?>" name="ProfissionalProduto_5<?php echo $i ?>"
																				onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',5)">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select[$i]['ProfissionalProduto_5'] as $key => $row) {
																			if ($produto[$i]['ProfissionalProduto_5'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<input type="hidden" class="form-control " id="ProfissionalServico_5<?php echo $i ?>" value="<?php echo $produto[$i]['ProfissionalProduto_5'] ?>" readonly="">
																<input type="hidden" class="form-control " id="idTFProf_Servico_5<?php echo $i ?>" name="idTFProf_Servico_5<?php echo $i ?>" value="<?php echo $produto[$i]['idTFProf_5'] ?>" readonly="">
																<input type="hidden" class="form-control " id="ComFunProf_Servico_5<?php echo $i ?>" name="ComFunProf_Servico_5<?php echo $i ?>" value="<?php echo $produto[$i]['ComFunProf_5'] ?>" readonly="">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<input type="text" class="form-control Valor" id="ValorComProf_Servico_5<?php echo $i ?>" name="ValorComProf_Servico_5<?php echo $i ?>"
																		value="<?php echo $produto[$i]['ValorComProf_5'] ?>" onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)"<?php echo $cadastrar_servico[$i]['Hidden_readonly_5'];?>>
																</div>
															</div>	
														</div>
														<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="ProfissionalProduto_6<?php echo $i ?>">Profissional 6</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																			 id="listadinamica_prof_6<?php echo $i ?>" name="ProfissionalProduto_6<?php echo $i ?>"
																				onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',6)">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select[$i]['ProfissionalProduto_6'] as $key => $row) {
																			if ($produto[$i]['ProfissionalProduto_6'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>
																<input type="hidden" class="form-control " id="ProfissionalServico_6<?php echo $i ?>" value="<?php echo $produto[$i]['ProfissionalProduto_6'] ?>" readonly="">
																<input type="hidden" class="form-control " id="idTFProf_Servico_6<?php echo $i ?>" name="idTFProf_Servico_6<?php echo $i ?>" value="<?php echo $produto[$i]['idTFProf_6'] ?>" readonly="">
																<input type="hidden" class="form-control " id="ComFunProf_Servico_6<?php echo $i ?>" name="ComFunProf_Servico_6<?php echo $i ?>" value="<?php echo $produto[$i]['ComFunProf_6'] ?>" readonly="">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<input type="text" class="form-control Valor" id="ValorComProf_Servico_6<?php echo $i ?>" name="ValorComProf_Servico_6<?php echo $i ?>"
																		value="<?php echo $produto[$i]['ValorComProf_6'] ?>" onkeyup="carregaValores_Prof(<?php echo $i ?>,6,2)"<?php echo $cadastrar_servico[$i]['Hidden_readonly_6'];?>>
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
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>">
							<!--<input type="hidden" name="idSis_Empresa" value="<?php echo $orcatrata['idSis_Empresa']; ?>">-->
							<div class="col-md-4 text-left">
								<label for="QuitadoParcelas">Seletor da função</label><br>
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
							<div id="QuitadoParcelas" <?php echo $div['QuitadoParcelas']; ?>>
								<div class="col-md-4 text-left">
									<h4 style="color: #FF0000">Atenção</h4>
									<h5 style="color: #FF0000"><?php if(isset($mensagem)) echo $mensagem ;?></h5>
								</div>
								<div class="col-md-2 text-left">
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
							</div>
							<div class="col-md-2 text-right">
								<label ></label><br>
								<button  type="button" class="btn btn-md btn-primary btn-block" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
