<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12 ">
							<div class="col-md-2 text-left">
								<br>						
								<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<?php if ($titulo == "Vendas" ) { ?>
										<a class="btn btn-md btn-warning btn-block" href="<?php echo base_url() ?>relatorio/vendidos" role="button">
											<span class="glyphicon glyphicon-search"></span> Venidos 
										</a>
									<?php } else { ?>	
										<a class="btn btn-md btn-warning btn-block" href="<?php echo base_url() ?>relatorio/comprados" role="button">
											<span class="glyphicon glyphicon-search"></span> Comprados
										</a>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="col-md-2 text-left">	
								<br>
								<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
									<?php echo $_SESSION['Filtro_Vendidos']['Total_Rows'];?> Resultados
								</a>
							</div>
							<div class="col-md-6 text-left">
								<?php echo $_SESSION['Filtro_Vendidos']['Pagination']; ?>
							</div>
						</div>
					</div>
				</div>						
				<div class="panel-body">						
					<div class="panel-group">	
						<div class="row">
							<div  style="overflow: auto; height: auto; ">
								<div class="panel-body">	
									<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>

									<div class="input_fields_wrap9">

										<?php
										$QtdSoma = $ProdutoSoma = 0;
										$linha =  $per_page*$pagina;
										for ($i=1; $i <= $count['PCount']; $i++) {
											$contagem = ($linha + $i);
										?>

											<input type="hidden" name="idApp_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_Produto']; ?>"/>

											<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">
											<?php 
												if ($_SESSION['Produto'][$i]['Prod_Serv_Produto'] == "S") {
													$cor = 'danger';
												}else{
													$cor = 'warning';
												} 
											?>
											<div class="form-group" id="9div<?php echo $i ?>">
												<div class="panel panel-<?php echo $cor ?>">
													<div class="panel-heading">
														<div class="row">
															<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" id="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_OrcaTrata']; ?>"/>
															<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
																<div class="row">
																	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																		<label >
																			<?php echo $contagem ?>/<?php echo $_SESSION['Filtro_Vendidos']['Total_Rows'];?> |
																			<a class="notclickable" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Produto'][$i]['idApp_Cliente']; ?>">
																				<span class="glyphicon glyphicon-edit notclickable"></span> <?php echo $_SESSION['Produto'][$i]['idApp_Cliente']; ?>
																			</a>
																			| Cliente 
																		</label>
																		<input type="text" class="form-control " readonly="" value="<?php echo $_SESSION['Produto'][$i]['NomeCliente']; ?> | <?php echo $_SESSION['Produto'][$i]['NomeClientePet']; ?><?php echo $_SESSION['Produto'][$i]['NomeClienteDep']; ?>">
																	</div>
																	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																		<label >
																			<a class="notclickable" href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $_SESSION['Produto'][$i]['idApp_OrcaTrata']; ?>">
																				<span class="glyphicon glyphicon-edit notclickable"></span> <?php echo $_SESSION['Produto'][$i]['idApp_OrcaTrata']; ?>
																			</a>
																			| Item 
																		</label>
																		<input type="text" class="form-control " readonly="" value="<?php echo $_SESSION['Produto'][$i]['NomeProduto']; ?>">
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
																		<label for="QtdProduto<?php echo $i ?>">Qtd</label>
																		<input type="text" class="form-control Numero" readonly="" value="<?php echo $_SESSION['Produto'][$i]['QtdProduto'] ?>">
																	</div>
																	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
																		<label for="QtdIncrementoProduto<?php echo $i ?>">Embl</label>
																		<input type="text" class="form-control Numero" readonly="" value="<?php echo $_SESSION['Produto'][$i]['QtdIncrementoProduto'] ?>">
																	</div>
																	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
																		<label for="SubtotalQtdProduto<?php echo $i ?>">Total</label>
																		<input type="text" class="form-control Numero" readonly="" value="<?php echo $_SESSION['Produto'][$i]['SubtotalQtdProduto'] ?>">
																	</div>
																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		<label for="ValorProduto<?php echo $i ?>">ValorEmbl</label>
																		<div class="input-group">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" readonly="" value="<?php echo $_SESSION['Produto'][$i]['ValorProduto'] ?>">
																		</div>
																	</div>
																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		<label for="SubtotalServico<?php echo $i ?>">Valortotal</label>
																		<div class="input-group">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="SubtotalServico<?php echo $i ?>" readonly="" value="<?php echo $_SESSION['Produto'][$i]['SubtotalProduto'] ?>">
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">																
																<div class="row">
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<label for="ObsProduto<?php echo $i ?>">Obs</label>
																		<textarea class="form-control" id="ObsProduto<?php echo $i ?>" <?php echo $readonly; ?>
																				  name="ObsProduto<?php echo $i ?>" rows="1"><?php echo $produto[$i]['ObsProduto']; ?></textarea>
																	</div>
																</div>	
																<div class="row">		
																	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																		<label for="DataConcluidoProduto<?php echo $i ?>">Data</label>
																		<div class="input-group <?php echo $datepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=""
																				   name="DataConcluidoProduto<?php echo $i ?>" value="<?php echo $_SESSION['Produto'][$i]['DataConcluidoProduto']; ?>">
																			
																		</div>
																	</div>
																	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																		<label for="HoraConcluidoProduto">Hora</label>
																		<div class="input-group <?php echo $timepicker; ?>">
																			<span class="input-group-addon">
																				<span class="glyphicon glyphicon-time"></span>
																			</span>
																			<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
																				   name="HoraConcluidoProduto<?php echo $i ?>" id="HoraConcluidoProduto<?php echo $i ?>" value="<?php echo $_SESSION['Produto'][$i]['HoraConcluidoProduto']; ?>">
																		</div>
																	</div>
																</div>
																<div class="row">		
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<label for="ConcluidoProduto">Entregue? </label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['ConcluidoProduto'] as $key => $row) {
																					(!$produto[$i]['ConcluidoProduto']) ? $produto[$i]['ConcluidoProduto'] = 'S' : FALSE;
																					if ($produto[$i]['ConcluidoProduto'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProduto' . $i . '" id="radiobutton_ConcluidoProduto' . $i .  $key . '">'
																						. '<input type="radio" name="ConcluidoProduto' . $i . '" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_ConcluidoProduto' . $i . '" id="radiobutton_ConcluidoProduto' . $i .  $key . '">'
																						. '<input type="radio" name="ConcluidoProduto' . $i . '" id="radiobuttondinamico" '
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
											</div>

										<?php
										$QtdSoma+=$produto[$i]['QtdProduto'];
										$ProdutoSoma++;
										}
										?>

									</div>
								</div>	
							</div>
						</div>	
					</div>
					<div class="row">	
						<!--
						<div class="panel panel-success">
							<div class="panel-heading text-left">
								<div class="row">
									<div class="col-md-4"></div>
									<div class="col-md-2">	
										<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma ?></span></b>
									</div>
									<div class="col-md-2">	
										<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma ?></span></b><br />
									</div>
								</div>
							</div>
						</div>
						-->
						<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">									
						<div class="col-md-3">
							<label for="Entregues">Todos Entregues?</label><br>
							<div class="btn-group" data-toggle="buttons">
								<?php
								foreach ($select['Entregues'] as $key => $row) {
									(!$query['Entregues']) ? $query['Entregues'] = 'N' : FALSE;

									if ($query['Entregues'] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="radiobutton_Entregues' . '" id="radiobutton_Entregues' .  $key . '">'
										. '<input type="radio" name="Entregues' . '" id="radiobuttondinamico" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="radiobutton_Entregues' .  '" id="radiobutton_Entregues' .  $key . '">'
										. '<input type="radio" name="Entregues' . '" id="radiobuttondinamico" '
										. 'autocomplete="off" value="' . $key . '" >' . $row
										. '</label>'
										;
									}
								}
								?>
							</div>
							<?php #echo form_error('Entregues'); ?>
						</div>
						<!--
						<div class="col-md-3">
							<label for="Devolvidos">Todos Devolvidos?</label><br>
							<div class="btn-group" data-toggle="buttons">
								<?php
								/*
								foreach ($select['Devolvidos'] as $key => $row) {
									(!$query['Devolvidos']) ? $query['Devolvidos'] = 'N' : FALSE;

									if ($query['Devolvidos'] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="radiobutton_Devolvidos' . '" id="radiobutton_Devolvidos' .  $key . '">'
										. '<input type="radio" name="Devolvidos' . '" id="radiobuttondinamico" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="radiobutton_Devolvidos' .  '" id="radiobutton_Devolvidos' .  $key . '">'
										. '<input type="radio" name="Devolvidos' . '" id="radiobuttondinamico" '
										. 'autocomplete="off" value="' . $key . '" >' . $row
										. '</label>'
										;
									}
								}
								*/
								?>
							</div>
							<?php #echo form_error('Devolvidos'); ?>
						</div>
						-->
						<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
						<?php if ($metodo > 1) { ?>
						<!--<input type="hidden" name="idApp_Procedimento" value="<?php #echo $procedimento['idApp_Procedimento']; ?>">
						<input type="hidden" name="idApp_ParcelasRec" value="<?php #echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
						<?php } ?>
						<?php if ($metodo == 2) { ?>
							<div class="col-md-3">
								<br>
								<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>
							</div>
						<?php } else { ?>
							<div class="col-md-3">
								<br>
								<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>
							</div>

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
