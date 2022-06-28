<div class="col-md-12 ">	
	<?php #echo validation_errors(); ?>
	
	<div class="panel panel-<?php echo $panel; ?>">
		
		<div class="panel-heading">
			<?php #echo $titulo; ?>
			<?php if ($metodo >= 1) { ?>
				<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
					<span class="glyphicon glyphicon-search"></span> Lista de Produtos
				</a>
				<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
					<span class="glyphicon glyphicon-plus"></span> Cadastrar Produto
				</a>
			<?php } ?>
		</div>
		
		<div class="panel-body">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
						<?php if (isset($msg)) echo $msg; ?>
						<div class="panel panel-primary">
							<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
								<h4 class="panel-title">
									<a class="accordion-toggle">
										<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
										Dados do Produto: 
									</a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
								<div class="panel panel-success">
									<div class="panel-heading">	
										<div class="form-group">
											<div class="row">
												<div class="col-md-1 text-center" >
													<?php 
														if($metodo == 6) { 
															$url = '';
														}elseif($metodo == 7){
															$url = base_url() . 'produtos/alterarlogoderivado/' . $_SESSION['Valor']['idTab_Produtos'];
														}
													?>
													<a class="notclickable" href="<?php echo $url ;?>">
														<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Valor']['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'>
													</a>
												</div>		
												<div class="col-md-5">
													<label for="Nome_Prod">Nome Produto*</label>
													<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['Nome_Prod']; ?>">
													<?php echo form_error('Nome_Prod'); ?>
												</div>		
												<div class="col-md-3">
													<label for="Produtos_Descricao">Descrição</label>
													<textarea type="text" class="form-control " readonly="" value="<?php echo $_SESSION['Valor']['Produtos_Descricao']; ?>"><?php echo $_SESSION['Valor']['Produtos_Descricao']; ?></textarea>
													<?php echo form_error('Produtos_Descricao'); ?>
												</div>
												<div class="col-md-3">
													<div class="col-md-6">
														<label for="ContarEstoque">Contar Estoque?</label>
														<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['ContarEstoque']; ?>">
														<?php echo form_error('ContarEstoque'); ?>
													</div>
													<?php if ($_SESSION['Valor']['ContarEstoque'] == "S") { ?>
														<div class="col-md-6">
															<label for="Estoque">Estoque</label>
															<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['Estoque']; ?>">
															<?php echo form_error('Estoque'); ?>
														</div>
													<?php } ?>	
												</div>	
											</div>	
											<div class="row">	
												<div class="col-md-1"></div>	
												<div class="col-md-1">
													<label for="id">id_Produto</label>
													<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['idTab_Produtos']; ?>">
												</div>		
												<div class="col-md-2">
													<label for="Cod_Prod">Codigo *</label>
													<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['Cod_Prod']; ?>">
													<?php echo form_error('Cod_Prod'); ?>
												</div>		
												<div class="col-md-3">
													<label for="Cod_Barra">Codigo de Barra</label>
													<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['Cod_Barra']; ?>">
													<?php echo form_error('Cod_Barra'); ?>
												</div>
												
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="panel-body">
													<div class="panel panel-info">
														<div class="panel-heading">			
															<div class="row">																					
																<div class="col-md-1">
																	<label for="QtdProdutoDesconto">QtdPrd :</label>
																	<?php if ($metodo == 6) { ?>
																		<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Valor']['QtdProdutoDesconto'] ?>">
																	<?php }elseif ($metodo == 7) { ?>
																		<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto" placeholder="0"
																				name="QtdProdutoDesconto" value="<?php echo $valor['QtdProdutoDesconto'] ?>">
																	<?php } ?>			
																</div>
																<div class="col-md-1">
																	<label for="QtdProdutoIncremento">QtdEmb:</label>
																	<?php if ($metodo == 6) { ?>
																		<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Valor']['QtdProdutoIncremento'] ?>">
																	<?php }elseif ($metodo == 7) { ?>
																		<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento" placeholder="0"
																				name="QtdProdutoIncremento" value="<?php echo $valor['QtdProdutoIncremento'] ?>">
																	<?php } ?>
																</div>
																<div class="col-md-2">
																	<label for="ValorProduto">ValorEmbal *</label>
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">R$</span>
																		<?php if ($metodo == 6) { ?>
																			<input type="text" class="form-control Valor text-left" readonly="" value="<?php echo $_SESSION['Valor']['ValorProduto'] ?>">
																		<?php }elseif ($metodo == 7) { ?>
																			<input type="text" class="form-control Valor" id="ValorProduto" maxlength="10" placeholder="0,00"
																				name="ValorProduto" value="<?php echo $valor['ValorProduto'] ?>">
																		<?php } ?>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="TempoDeEntrega">Prazo De Entrega</label>
																	<div class="input-group">
																		<?php if ($metodo == 6) { ?>
																			<input type="text" class="form-control Numero text-right" readonly="" value="<?php echo $_SESSION['Valor']['TempoDeEntrega'] ?>">
																		<?php }elseif ($metodo == 7) { ?>
																			<input type="text" class="form-control Numero text-right" id="TempoDeEntrega" maxlength="3" placeholder="0"
																				name="TempoDeEntrega" value="<?php echo $valor['TempoDeEntrega'] ?>">
																		<?php } ?>
																		<span class="input-group-addon" id="basic-addon1">Dia(s)</span>
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="Convdesc">Desc. Embal </label>
																	<?php if ($metodo == 6) { ?>
																		<textarea type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Valor']['Convdesc']; ?>"><?php echo $_SESSION['Valor']['Convdesc']; ?></textarea>
																	<?php }elseif ($metodo == 7) { ?>
																		<textarea type="text" class="form-control"  id="Convdesc" <?php echo $readonly; ?>
																				  name="Convdesc" value="<?php echo $valor['Convdesc']; ?>"><?php echo $valor['Convdesc']; ?></textarea>
																	<?php } ?>
																</div>
															</div>
															<div class="row">
																<!--
																<div class="col-md-2">
																	<label for="AtivoPreco">Ativo?</label><br>
																	<?php if ($metodo == 6) { ?>
																		<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Valor']['AtivoPreco'] ?>">
																	<?php }elseif ($metodo == 7) { ?>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				/*
																				foreach ($select['AtivoPreco'] as $key => $row) {
																					(!$valor['AtivoPreco']) ? $valor['AtivoPreco'] = 'N' : FALSE;

																					if ($valor['AtivoPreco'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_AtivoPreco" id="radiobutton_AtivoPreco' .  $key . '">'
																						. '<input type="radio" name="AtivoPreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_AtivoPreco" id="radiobutton_AtivoPreco' .  $key . '">'
																						. '<input type="radio" name="AtivoPreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				*/
																				?>
																			</div>
																		</div>
																	<?php } ?>	
																</div>
																-->
																<div class="col-md-2">
																	<label for="ComissaoVenda">ComissaoVenda</label>
																	<div class="input-group">
																		<?php if ($metodo == 6) { ?>
																			<input type="text" class="form-control Valor text-right" readonly="" value="<?php echo $_SESSION['Valor']['ComissaoVenda'] ?>">
																		<?php }elseif ($metodo == 7) { ?>
																			<input type="text" class="form-control Valor text-right" id="ComissaoVenda" maxlength="10" placeholder="0,00"
																				name="ComissaoVenda" value="<?php echo $valor['ComissaoVenda'] ?>">
																		<?php } ?>
																		<span class="input-group-addon" id="basic-addon1">%</span>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ComissaoServico">ComissaoServico</label>
																	<div class="input-group">
																		<?php if ($metodo == 6) { ?>
																			<input type="text" class="form-control Valor text-right" readonly="" value="<?php echo $_SESSION['Valor']['ComissaoServico'] ?>">
																		<?php }elseif ($metodo == 7) { ?>
																			<input type="text" class="form-control Valor text-right" id="ComissaoServico" maxlength="10" placeholder="0,00"
																				name="ComissaoServico" value="<?php echo $valor['ComissaoServico'] ?>">
																		<?php } ?>
																		<span class="input-group-addon" id="basic-addon1">%</span>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="ComissaoCashBack">Cashback</label>
																	<div class="input-group">
																		<?php if ($metodo == 6) { ?>
																			<input type="text" class="form-control Valor text-right" readonly="" value="<?php echo $_SESSION['Valor']['ComissaoCashBack'] ?>">
																		<?php }elseif ($metodo == 7) { ?>
																			<input type="text" class="form-control Valor text-right" id="ComissaoCashBack" maxlength="10" placeholder="0,00"
																				name="ComissaoCashBack" value="<?php echo $valor['ComissaoCashBack'] ?>">
																		<?php } ?>
																		<span class="input-group-addon" id="basic-addon1">%</span>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="VendaBalcaoPreco">Balcao?</label><br>
																	<?php if ($metodo == 6) { ?>
																		<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Valor']['VendaBalcaoPreco'] ?>">
																	<?php }elseif ($metodo == 7) { ?>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['VendaBalcaoPreco'] as $key => $row) {
																					(!$valor['VendaBalcaoPreco']) ? $valor['VendaBalcaoPreco'] = 'N' : FALSE;

																					if ($valor['VendaBalcaoPreco'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_VendaBalcaoPreco" id="radiobutton_VendaBalcaoPreco' .  $key . '">'
																						. '<input type="radio" name="VendaBalcaoPreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_VendaBalcaoPreco" id="radiobutton_VendaBalcaoPreco' .  $key . '">'
																						. '<input type="radio" name="VendaBalcaoPreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	<?php } ?>
																</div>
																<div class="col-md-2">
																	<label for="VendaSitePreco">Site?</label><br>
																	<?php if ($metodo == 6) { ?>
																		<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Valor']['VendaSitePreco'] ?>">
																	<?php }elseif ($metodo == 7) { ?>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['VendaSitePreco'] as $key => $row) {
																					(!$valor['VendaSitePreco']) ? $valor['VendaSitePreco'] = 'N' : FALSE;

																					if ($valor['VendaSitePreco'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_VendaSitePreco" id="radiobutton_VendaSitePreco' .  $key . '">'
																						. '<input type="radio" name="VendaSitePreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_VendaSitePreco" id="radiobutton_VendaSitePreco' .  $key . '">'
																						. '<input type="radio" name="VendaSitePreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	<?php } ?>
																</div>
																<div class="col-md-2">
																	<label for="TipoPreco">Venda/Revenda?</label><br>
																	<?php if ($metodo == 6) { ?>
																		<input type="text" class="form-control text-left" readonly="" value="<?php echo $_SESSION['Valor']['TipoPreco'] ?>">
																	<?php }elseif ($metodo == 7) { ?>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['TipoPreco'] as $key => $row) {
																					(!$valor['TipoPreco']) ? $valor['TipoPreco'] = 'V' : FALSE;
																					if ($valor['TipoPreco'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_TipoPreco" id="radiobutton_TipoPreco' .  $key . '">'
																						. '<input type="radio" name="TipoPreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_TipoPreco" id="radiobutton_TipoPreco' .  $key . '">'
																						. '<input type="radio" name="TipoPreco" id="radiobuttondinamico" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				?>
																			</div>
																		</div>
																	<?php } ?>
																</div>
															</div>
														</div>	
													</div>
												</div>
											</div>
										</div>
									
										<input type="hidden" name="idTab_Valor" id="idTab_Valor" value="<?php echo $valor['idTab_Valor']; ?>">
										
										<?php if($this->Basico_model->get_dt_validade()) { ?>
											<div class="row">
												<div class="col-md-12">
													<?php if ($metodo > 1) { ?>
														<?php if ($metodo != 4 && $metodo != 6) { ?>
															<div class="col-md-2">
																<label >Salvar Alterações</label><br>
																<button type="submit" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
																	<span class="glyphicon glyphicon-save"></span> Próximo Passo
																</button>
															</div>
														<?php } ?>
														<?php if ($metodo == 4) { ?>
															<div class="col-md-2">
																<label >Editar Produto</label><br>
																<a class="btn btn-warning btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" href="<?php echo base_url() . 'produtos/alterar2/' . $_SESSION['Valor']['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Editar
																</a>
															</div>
															<div class="col-md-2">
																<label >Preço, Prazo e Promoção</label><br>
																<a class="btn btn-success btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" href="<?php echo base_url() . 'produtos/tela_precos/' . $_SESSION['Valor']['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-usd"></span> Ver
																</a>
															</div>
														<?php }elseif($metodo == 6){ ?>
															<div class="col-md-2">
																<label >Editar Este</label><br>
																<a class="btn btn-warning btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" href="<?php echo base_url() . 'produtos/alterar_valor/' . $valor['idTab_Valor'] ?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Editar
																</a>
															</div>
															<div class="col-md-2">
																<label >Editar Todos</label><br>
																<a class="btn btn-warning btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" href="<?php echo base_url() . 'produtos/alterar_precos/' . $_SESSION['Valor']['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Editar
																</a>
															</div>
															<div class="col-md-2">
																<label >Produtos Associados</label><br>
																<a class="btn btn-info btn-block" name="submeter5" id="submeter5" onclick="DesabilitaBotao(this.name)" href="<?php echo base_url() . 'produtos/tela/' . $_SESSION['Valor']['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-pencil"></span> Ver Produtos
																</a>
															</div>
														<?php } ?>
														<?php if ($metodo == 2) { ?>	
															<div class="col-md-6 text-right">
																<label >Excluir</label><br>
																<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																	<span class="glyphicon glyphicon-trash"></span> Excluir
																</button>
															</div>
														<?php } ?>
														<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header bg-danger">
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
																	</div>
																	<div class="modal-body">
																		<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6 text-left">
																			<button type="button" class="btn btn-warning" data-dismiss="modal">
																				<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																			</button>
																		</div>
																		<div class="col-md-6 text-right">
																			<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idTab_Produtos'] ?>" role="button">
																				<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																			</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<?php } else { ?>
														<div class="col-md-6">
															<label >Salvar</label><br>
															<button class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
													<?php } ?>
													<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header bg-success text-center">
																	<h4 class="modal-title" id="visulUsuarioModalLabel">Cadastrado realizado com sucesso!</h4>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-footer">
																	<div class="col-md-6">	
																		<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
																			<span class="glyphicon glyphicon-filter"></span> Fechar
																		</button>
																		<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
																			Aguarde um instante! Estamos processando sua solicitação!
																		</div>
																	</div>
																	<!--<button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>-->
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<?php if (isset($list_precos)) echo $list_precos; ?>
				<?php if (isset($list_precos_promocoes)) echo $list_precos_promocoes; ?>
			</div>
			</form>
		</div>
	</div>
</div>

