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
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
								<?php if ($titulo == "Vendas" ) { ?>
									<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>relatorio/produtosvend" role="button">
										<span class="glyphicon glyphicon-search"></span> Rel. Produtos Venidos 
									</a>
								<?php } else { ?>	
									<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>relatorio/produtoscomp" role="button">
										<span class="glyphicon glyphicon-search"></span> Rel. Produtos Comprados
									</a>
								<?php } ?>
							<?php } ?>
						</div>						
						<div class="panel-body">						
							<div class="panel-group">	
								<div class="row">
									<div  style="overflow: auto; height: 550px; ">
										<div class="panel-body">	
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
													<div class="panel panel-success">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-2">
																	<label for="QtdProduto">Qtd <?php echo $i ?>:</label>
																	<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto<?php echo $i ?>" placeholder="0" readonly=""
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto'),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',0,'ProdutoHidden')"
																			autofocus name="QtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdProduto'] ?>">
																</div>
																<!--
																<div class="col-md-6">
																	<label for="idTab_Produto">Produto:</label>
																	<?php if ($i == 1) { ?>
																	<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>produto/cadastrar/produto" role="button">
																		<span class="glyphicon glyphicon-plus"></span> <b>Novo Produto</b>
																	</a>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="buscaValor2Tabelas(this.value,this.name,'Valor',<?php echo $i ?>,'Produto')" <?php echo $readonly; ?>
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
																-->
																<div class="col-md-1">
																	<label for="idTab_Produto">id. <?php echo $i ?>:</label><br>
																	<input type="text" class="form-control" maxlength="6" readonly=""
																		   name="idTab_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produto'] ?>">
																</div>
																<div class="col-md-5">
																	<label for="Produtos">Produto <?php echo $i ?>:</label><br>
																	<input type="text" class="form-control" maxlength="6" readonly=""
																		   name="Produtos<?php echo $i ?>" value="<?php echo $produto[$i]['Produtos'] ?>">
																</div>
																																		
																<div class="col-md-2">
																	<label for="ValorProduto">Valor:</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00" readonly=""
																			onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
																			name="ValorProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorProduto'] ?>">
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="SubtotalProduto">Subtotal:</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																			   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-2">
																	<label for="Produto">Orcamento <?php echo $i ?>:</label><br>
																	<input type="text" class="form-control" maxlength="6" readonly=""
																		   name="Produto<?php echo $i ?>" value="<?php echo $produto[$i]['Produto'] ?>">
																</div>
																<div class="col-md-2">
																	<label for="idSis_Usuario<?php echo $i ?>">Profissional:</label>
																	<?php if ($i == 1) { ?>
																	<?php } ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control"
																			 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?>">
																		<option value="">-- Sel.Profis. --</option>
																		<?php
																		foreach ($select['idSis_Usuario'] as $key => $row) {
																			(!$produto['idSis_Usuario']) ? $produto['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario']: FALSE;
																			if ($produto[$i]['idSis_Usuario'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																			} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																		?>
																	</select>
																</div>																				
																<div class="col-md-2">
																	<label for="DataValidadeProduto<?php echo $i ?>">Validade:</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																			   name="DataValidadeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataValidadeProduto']; ?>">
																		
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ObsProduto<?php echo $i ?>">Obs: <?php echo $i ?>:</label>
																	<textarea class="form-control" id="ObsProduto<?php echo $i ?>" <?php echo $readonly; ?>
																			  name="ObsProduto<?php echo $i ?>"><?php echo $produto[$i]['ObsProduto']; ?></textarea>
																</div>
																<div class="col-md-2">
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
																<div class="col-md-2">
																	<label for="DevolvidoProduto">Devolvido? </label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['DevolvidoProduto'] as $key => $row) {
																				(!$produto[$i]['DevolvidoProduto']) ? $produto[$i]['DevolvidoProduto'] = 'S' : FALSE;

																				if ($produto[$i]['DevolvidoProduto'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_DevolvidoProduto' . $i . '" id="radiobutton_DevolvidoProduto' . $i .  $key . '">'
																					. '<input type="radio" name="DevolvidoProduto' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_DevolvidoProduto' . $i . '" id="radiobutton_DevolvidoProduto' . $i .  $key . '">'
																					. '<input type="radio" name="DevolvidoProduto' . $i . '" id="radiobuttondinamico" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>																		
																<!--
																<div class="col-md-1">
																	<label><br></label><br>
																	<button type="button" id="<?php echo $i ?>" class="remove_field9 btn btn-danger"
																			onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',1,<?php echo $i ?>,'CountMax',0,'ProdutoHidden')">
																		<span class="glyphicon glyphicon-trash"></span>
																	</button>
																</div>
																-->
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
								<div class="col-md-3">
									<label for="Devolvidos">Todos Devolvidos?</label><br>
									<div class="btn-group" data-toggle="buttons">
										<?php
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
										?>
									</div>
									<?php #echo form_error('Devolvidos'); ?>
								</div>
								
								<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
								<input type="hidden" name="idSis_Empresa" value="<?php echo $orcatrata['idSis_Empresa']; ?>">
								<?php if ($metodo > 1) { ?>
								<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
								<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
								<?php } ?>
								<?php if ($metodo == 2) { ?>
									<div class="col-md-3">
										<br>
										<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
											<span class="glyphicon glyphicon-save"></span> Salvar
										</button>
									</div>
									<!--
									<div class="col-md-6 text-right">
										<button  type="button" class="btn btn-md btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
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
														<a class="btn btn-danger" href="<?php echo base_url() . 'orcatrata/excluirdesp/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
															<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
														</a>
													</div>
												</div>
											</div>
										</div>
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
		<div class="col-md-1"></div>
	</div>
</div>
