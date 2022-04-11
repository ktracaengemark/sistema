

<div class="col-md-12 ">	
	<?php #echo validation_errors(); ?>
	
	<div class="panel panel-<?php echo $panel; ?>">
		
		<div class="panel-heading">
			<?php #echo $titulo; ?>
			<?php if ($metodo >= 1) { ?>
				<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
					<span class="glyphicon glyphicon-search"></span> Lista de Produtos
				</a>
				<!--
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/precopromocao" role="button">
					<span class="glyphicon glyphicon-search"></span> Lista de Preços
				</a>
				<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
					<span class="glyphicon glyphicon-plus"></span> Cadastrar Produto
				</a>
				-->
				<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".produto">
					<span class="glyphicon glyphicon-plus"></span> Novo Produto
				</button>
				<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".promocao">
					<span class="glyphicon glyphicon-plus"></span> Nova Promoção
				</button>
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
										<?php if ($metodo < 4) { ?>
											<div class="form-group">
												<div class="row">	
													<div class="col-md-12">
														<div class="col-md-3">
															<label for="idTab_Catprod">Categoria *</label>
															<?php if ($metodo < 2) { ?>
																<select data-placeholder="Selecione uma Categoria..." class="form-control Chosen" 
																id="idTab_Catprod" name="idTab_Catprod">
																	<option value="">-- Selecione uma Categoria --</option>
																	<?php
																		foreach ($select['idTab_Catprod'] as $key => $row) {
																			if ($produtos['idTab_Catprod'] == $key) {
																				echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																				echo '<option value="' . $key . '">' . $row . '</option>';
																			}
																		}
																	?>
																</select>
																<?php } else { ?>
																<input type="hidden" id="idTab_Catprod" name="idTab_Catprod" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
																<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
															<?php } ?>
															
															<?php echo form_error('idTab_Catprod'); ?>
														</div>
														<div class="col-md-3">
															<?php if ($metodo >= 2) { ?>
																<label for="idTab_Produto">Produto Base*</label>
																<?php if ($metodo < 4) { ?>
																	<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="idTab_Produto" name="idTab_Produto" onchange="codigo(this.value,this.name)">
																		<option value="">-- Selecione uma opção --</option>
																		<?php
																			foreach ($select['idTab_Produto'] as $key => $row) {
																				if ($produtos['idTab_Produto'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																					} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																		?>
																	</select>
																	<input type="hidden" id="Produtos" name="Produtos" value="<?php echo $_SESSION['Produtos']['Produtos']; ?>">
																	<?php }else{ ?>
																	<input type="hidden" id="idTab_Produto" name="idTab_Produto" value="<?php echo $_SESSION['Produtos']['idTab_Produto']; ?>">
																	<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Produtos']; ?>">
																<?php } ?>
																<?php echo form_error('idTab_Produto'); ?>
															<?php } ?>
														</div>
														<?php if ($metodo >= 2) { ?>
															<div class="col-md-3">
																<?php if ($_SESSION['Atributo'][1]['idTab_Atributo']) { ?>
																	<label for="Opcao_Atributo_1"><?php echo $_SESSION['Atributo'][1]['Atributo']; ?></label>
																	<?php if ($metodo < 4) { ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Opcao_Atributo_1" name="Opcao_Atributo_1" onchange="codigo(this.value,this.name)">
																			<option value="">-- Selecione uma opção --</option>
																			<?php
																				foreach ($select['Opcao_Atributo_1'] as $key => $row) {
																					if ($produtos['Opcao_Atributo_1'] == $key) {
																						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																						echo '<option value="' . $key . '">' . $row . '</option>';
																					}
																				}
																			?>
																		</select>
																		<?php echo form_error('Opcao_Atributo_1'); ?>
																		<input type="hidden" id="Opcao1" name="Opcao1" value="<?php echo $_SESSION['Produtos']['Opcao1']; ?>">
																		<?php }else{ ?>
																		<input type="hidden" id="Opcao_Atributo_1" name="Opcao_Atributo_1" value="<?php echo $_SESSION['Produtos']['Opcao_Atributo_1']; ?>">
																		<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Opcao1']; ?>">
																	<?php } ?>
																	<?php }else{ ?>
																	<label for="Opcao_Atributo_1">Não existe Variacao1</label>
																	<input type="text" class="form-control"readonly="" name="Opcao_Atributo_1" id="Opcao_Atributo_1" value="0">
																<?php } ?>
															</div>
														<?php } ?>
														<?php if ($metodo >= 2) { ?>		
															<div class="col-md-3">
																<?php if ($_SESSION['Atributo'][2]['idTab_Atributo']) { ?>
																	<label for="Opcao_Atributo_2"><?php echo $_SESSION['Atributo'][2]['Atributo']; ?></label>
																	<?php if ($metodo < 4) { ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Opcao_Atributo_2" name="Opcao_Atributo_2" onchange="codigo(this.value,this.name)">
																			<option value="">-- Selecione uma opção --</option>
																			<?php
																				foreach ($select['Opcao_Atributo_2'] as $key => $row) {
																					if ($produtos['Opcao_Atributo_2'] == $key) {
																						echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																						echo '<option value="' . $key . '">' . $row . '</option>';
																					}
																				}
																			?>
																		</select>
																		<?php echo form_error('Opcao_Atributo_2'); ?>
																		<input type="hidden" id="Opcao2" name="Opcao2" value="<?php echo $_SESSION['Produtos']['Opcao2']; ?>">
																		<?php }else{ ?>
																		<input type="hidden" id="Opcao_Atributo_2" name="Opcao_Atributo_2" value="<?php echo $_SESSION['Produtos']['Opcao_Atributo_2']; ?>">
																		<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Opcao2']; ?>">
																	<?php } ?>
																	<?php }else{ ?>
																	<label for="Opcao_Atributo_2">Não existe Variacao2</label>
																	<input type="text" class="form-control"readonly=""  name="Opcao_Atributo_2" id="Opcao_Atributo_2" value="0">
																<?php } ?>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>
											
										<?php }else { ?>	
											<input type="hidden" id="idTab_Catprod" name="idTab_Catprod" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
											<input type="hidden" id="idTab_Produto" name="idTab_Produto" value="<?php echo $_SESSION['Produtos']['idTab_Produto']; ?>">
											<input type="hidden" id="Opcao_Atributo_1" name="Opcao_Atributo_1" value="<?php echo $_SESSION['Produtos']['Opcao_Atributo_1']; ?>">
											<input type="hidden" id="Opcao_Atributo_2" name="Opcao_Atributo_2" value="<?php echo $_SESSION['Produtos']['Opcao_Atributo_2']; ?>">
										<?php } ?>	
											
										
										<?php if ($metodo >= 2) { ?>
											<div class="form-group">
												<div class="row">
													<div class="col-md-1 text-center" >
														<a class="notclickable" href="<?php echo base_url() . 'produtos/alterarlogoderivado/' . $_SESSION['Produtos']['idTab_Produtos'] . ''; ?>">
															<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produtos']['ArquivoDerivado'] . ''; ?> "class="img-circle img-responsive" width='100'>
														</a>
													</div>		
													<div class="col-md-5">
														<label for="Nome_Prod">Nome Produto*</label>
														<input type="text" class="form-control" readonly="" id="Nome_Prod" name="Nome_Prod" value="<?php echo $produtos['Nome_Prod']; ?>">
														<?php echo form_error('Nome_Prod'); ?>
													</div>		
													<div class="col-md-3">
														<label for="Produtos_Descricao">Descrição</label>
														<textarea type="text" class="form-control " <?php echo $readonly ?> id="Produtos_Descricao" name="Produtos_Descricao" 
															maxlength="200" value="<?php echo $produtos['Produtos_Descricao']; ?>"><?php echo $produtos['Produtos_Descricao']; ?></textarea>
														<?php echo form_error('Produtos_Descricao'); ?>
													</div>
													<div class="col-md-3 text-left">
														<?php if ($metodo == 2 || $metodo == 3) { ?>	
															<div class="col-md-6 text-left">
																<label for="ContarEstoque">Contar Estoque?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																		foreach ($select['ContarEstoque'] as $key => $row) {
																			if (!$produtos['ContarEstoque']) $produtos['ContarEstoque'] = 'S';
																			
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																			
																			if ($produtos['ContarEstoque'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="ContarEstoque_' . $hideshow . '">'
																				. '<input type="radio" name="ContarEstoque" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																				} else {
																				echo ''
																				. '<label class="btn btn-default" name="ContarEstoque_' . $hideshow . '">'
																				. '<input type="radio" name="ContarEstoque" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																	?>
																</div>
															</div>
															<div class="col-md-6">
																<div id="ContarEstoque" <?php echo $div['ContarEstoque']; ?>>
																	<label for="Estoque">Estoque</label>
																	<input type="text" class="form-control Numero" <?php echo $readonly ?> id="Estoque" name="Estoque" value="<?php echo $produtos['Estoque']; ?>">
																	<?php echo form_error('Estoque'); ?>
																</div>
															</div>
														<?php }else{ ?>
															<div class="col-md-6 text-left">
																<label for="ContarEstoque">Contar Estoque?</label><br>
																<input type="text" class="form-control" <?php echo $readonly ?> id="ContarEstoque" name="ContarEstoque" value="<?php echo $_SESSION['Produtos']['ContarEstoque']; ?>">
															</div>
															<?php if ($_SESSION['Produtos']['ContarEstoque'] == "S") { ?>
																<div class="col-md-6 text-left">
																	<label for="Estoque">Estoque</label><br>
																	<input type="text" class="form-control" <?php echo $readonly ?> id="Estoque" name="Estoque" value="<?php echo $_SESSION['Produtos']['Estoque']; ?>">
																</div>
															<?php } ?>	
														<?php } ?>
													</div>	
												</div>	
												<div class="row">
													<div class="col-md-1"></div>
													<div class="col-md-1">
														<label for="id">id_Produto</label>
														<input type="text" class="form-control" readonly="" value="<?php echo $produtos['idTab_Produtos']; ?>">
													</div>		
													<div class="col-md-2">
														<label for="Cod_Prod">Codigo *</label>
														<input type="text" class="form-control" readonly="" id="Cod_Prod" name="Cod_Prod" value="<?php echo $produtos['Cod_Prod']; ?>">
														<?php echo form_error('Cod_Prod'); ?>
													</div>		
													<div class="col-md-2">
														<label for="Cod_Barra">Codigo de Barras</label>
														<input type="text" class="form-control" <?php echo $readonly ?> id="Cod_Barra" name="Cod_Barra" value="<?php echo $produtos['Cod_Barra']; ?>">
														<?php echo form_error('Cod_Barra'); ?>
													</div>
												</div>
											</div>	
										<?php } ?>
										
										<?php if ($metodo == 7){ ?>
											<div class="row">
												<div class="col-md-12">
													<div class="panel-body">

														<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

														<div class="input_fields_wrap3">

														<?php
														for ($i=1; $i <= $count['PTCount']; $i++) {
														?>

														
														<input type="hidden" name="idTab_Valor<?php echo $i ?>" value="<?php echo $valor[$i]['idTab_Valor']; ?>"/>
														

														<div class="form-group" id="3div<?php echo $i ?>">
															<div class="panel panel-info">
																<div class="panel-heading">			
																	<div class="row">																					
																		<div class="col-md-1">
																			<label for="QtdProdutoDesconto">QtdPrd <?php echo $i ?>:</label>
																			<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto<?php echo $i ?>" placeholder="0"
																					name="QtdProdutoDesconto<?php echo $i ?>" value="<?php echo $valor[$i]['QtdProdutoDesconto'] ?>">
																		</div>
																		<div class="col-md-1">
																			<label for="QtdProdutoIncremento">QtdEmb<?php echo $i ?>:</label>
																			<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento<?php echo $i ?>" placeholder="0"
																					name="QtdProdutoIncremento<?php echo $i ?>" value="<?php echo $valor[$i]['QtdProdutoIncremento'] ?>">
																		</div>
																		<div class="col-md-2">
																			<label for="ValorProduto">ValorEmbal <?php echo $i ?>*</label>
																			<div class="input-group">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" id="ValorProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																					name="ValorProduto<?php echo $i ?>" value="<?php echo $valor[$i]['ValorProduto'] ?>">
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="TempoDeEntrega">Prazo De Entrega<?php echo $i ?></label>
																			<div class="input-group">
																				<input type="text" class="form-control Numero text-right" id="TempoDeEntrega<?php echo $i ?>" maxlength="3" placeholder="0"
																					name="TempoDeEntrega<?php echo $i ?>" value="<?php echo $valor[$i]['TempoDeEntrega'] ?>">
																				<span class="input-group-addon" id="basic-addon1">Dia(s)</span>
																			</div>
																		</div>
																		<div class="col-md-4">
																			<label for="Convdesc">Desc. Embal <?php echo $i ?></label>
																			<textarea type="text" class="form-control"  id="Convdesc<?php echo $i ?>" 
																					  name="Convdesc<?php echo $i ?>" value="<?php echo $valor[$i]['Convdesc']; ?>"><?php echo $valor[$i]['Convdesc']; ?></textarea>
																		</div>
																		<div class="col-md-1 text-right">
																			<label><br></label><br>
																			<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																				<span class="glyphicon glyphicon-trash"></span>
																			</button>
																		</div>
																	</div>
																	<div class="row">
																		<!--
																		<div class="col-md-2">
																			<label for="AtivoPreco">Ativo?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					/*
																					foreach ($select['AtivoPreco'] as $key => $row) {
																						(!$valor[$i]['AtivoPreco']) ? $valor[$i]['AtivoPreco'] = 'N' : FALSE;

																						if ($valor[$i]['AtivoPreco'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_AtivoPreco' . $i . '" id="radiobutton_AtivoPreco' . $i .  $key . '">'
																							. '<input type="radio" name="AtivoPreco' . $i . '" id="radiobuttondinamico" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_AtivoPreco' . $i . '" id="radiobutton_AtivoPreco' . $i .  $key . '">'
																							. '<input type="radio" name="AtivoPreco' . $i . '" id="radiobuttondinamico" '
																							. 'autocomplete="off" value="' . $key . '" >' . $row
																							. '</label>'
																							;
																						}
																					}
																					*/
																					?>
																				</div>
																			</div>
																		</div>
																		-->
																		<div class="col-md-2">
																			<label for="ComissaoVenda">ComissaoVenda<?php echo $i ?></label>
																			<div class="input-group">
																				<input type="text" class="form-control Valor text-right" id="ComissaoVenda<?php echo $i ?>" maxlength="10" placeholder="0,00"
																					name="ComissaoVenda<?php echo $i ?>" value="<?php echo $valor[$i]['ComissaoVenda'] ?>">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="ComissaoServico">ComissaoServico<?php echo $i ?></label>
																			<div class="input-group">
																				<input type="text" class="form-control Valor text-right" id="ComissaoServico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																					name="ComissaoServico<?php echo $i ?>" value="<?php echo $valor[$i]['ComissaoServico'] ?>">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="ComissaoCashBack">CashBack<?php echo $i ?></label>
																			<div class="input-group">
																				<input type="text" class="form-control Valor text-right" id="ComissaoCashBack<?php echo $i ?>" maxlength="10" placeholder="0,00"
																					name="ComissaoCashBack<?php echo $i ?>" value="<?php echo $valor[$i]['ComissaoCashBack'] ?>">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<label for="VendaBalcaoPreco">VendaBalcao?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['VendaBalcaoPreco'] as $key => $row) {
																						(!$valor[$i]['VendaBalcaoPreco']) ? $valor[$i]['VendaBalcaoPreco'] = 'N' : FALSE;

																						if ($valor[$i]['VendaBalcaoPreco'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_VendaBalcaoPreco' . $i . '" id="radiobutton_VendaBalcaoPreco' . $i .  $key . '">'
																							. '<input type="radio" name="VendaBalcaoPreco' . $i . '" id="radiobuttondinamico" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_VendaBalcaoPreco' . $i . '" id="radiobutton_VendaBalcaoPreco' . $i .  $key . '">'
																							. '<input type="radio" name="VendaBalcaoPreco' . $i . '" id="radiobuttondinamico" '
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
																			<label for="VendaSitePreco">VendaSite?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['VendaSitePreco'] as $key => $row) {
																						(!$valor[$i]['VendaSitePreco']) ? $valor[$i]['VendaSitePreco'] = 'N' : FALSE;

																						if ($valor[$i]['VendaSitePreco'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_VendaSitePreco' . $i . '" id="radiobutton_VendaSitePreco' . $i .  $key . '">'
																							. '<input type="radio" name="VendaSitePreco' . $i . '" id="radiobuttondinamico" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_VendaSitePreco' . $i . '" id="radiobutton_VendaSitePreco' . $i .  $key . '">'
																							. '<input type="radio" name="VendaSitePreco' . $i . '" id="radiobuttondinamico" '
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
														<!--
														<div class="form-group">
															<div class="col-md-2">
																<a class="btn btn-md btn-danger btn-block" onclick="adiciona_precos()">
																	<span class="glyphicon glyphicon-plus"></span> Adiciona Preço
																</a>
															</div>
														</div>
														-->
													</div>
												</div>
											</div>
										<?php } ?>
										<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idTab_Produtos" id="idTab_Produtos" value="<?php echo $produtos['idTab_Produtos']; ?>">
										<?php } ?>
										<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
											<div class="row">
												<div class="col-md-12">
													<?php if ($metodo > 1) { ?>
														<?php if ($metodo != 4 && $metodo != 6) { ?>
															<?php if ($metodo < 4) { ?>
																<div class="col-md-2 text-left">
																	<label for="Cadastrar">Encontrou?</label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																			foreach ($select['Cadastrar'] as $key => $row) {
																				if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';
																				
																				($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																				
																				if ($cadastrar['Cadastrar'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
																					. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																					. 'onchange="codigo()" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																					} else {
																					echo ''
																					. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
																					. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																					. 'onchange="codigo()" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																		?>
																		
																	</div>
																</div>
																<div class="col-md-6 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
																	<div class="row">
																		<div class="col-md-2 text-left">	
																			<label >Categoria</label><br>
																			<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addCatprodModal">
																				Cad./Edit
																			</button>
																		</div>
																		<?php if ($metodo >= 2) { ?>
																			<div class="col-md-3 text-left">	
																				<label >Produto Base</label><br>
																				<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addProdutoModal">
																					Cad./Edit
																				</button>
																			</div>
																		<?php } ?>
																		<?php if ($metodo >= 2) { ?>
																			<div class="col-md-2 text-left">	
																				<label >Variacoes</label><br>
																				<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addAtributoModal">
																					Cad./Edit
																				</button>
																			</div>	
																			<div class="col-md-2 text-left">
																				<label >Opcoes</label><br>
																				<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addOpcaoModal">
																					Cad./Edit
																				</button>
																			</div>
																		<?php } ?>	
																		<div class="col-md-3 text-left">
																			<label >Recarregar</label><br>
																			<button class="btn btn-md btn-warning btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																				<span class="glyphicon glyphicon-refresh"></span>Recarregar
																			</button>
																		</div>	
																		<span id="msg"></span>
																	</div>	
																	<?php echo form_error('Cadastrar'); ?>
																</div>
															<?php } ?>
															<?php if ($metodo == 7) { ?>
																<div class="col-md-2">
																<label >Preço e Prazo</label><br>
																	<a class="btn btn-md btn-danger btn-block"  name="submeter2" id="submeter2" onclick="adiciona_precos()">
																		<span class="glyphicon glyphicon-plus"></span> Adicionar
																	</a>
																</div>
															<?php } ?>
															<?php if (isset($usado['produto']) && $usado['produto'] == "N" && ($metodo == 2 || $metodo == 3)) { ?>	
																<div class="col-md-2">
																	<label >Produto</label><br>
																	<button  type="button" class="btn btn-md btn-danger btn-block" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																		<span class="glyphicon glyphicon-trash"></span> Excluir
																	</button>
																</div>
															<?php } ?>
															<div class="col-md-2">
																<label >Alterações</label><br>
																<button type="submit" class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
																	<span class="glyphicon glyphicon-save"></span> Próximo Passo
																</button>
															</div>
														<?php } ?>
														<?php if ($metodo == 4) { ?>
															<div class="col-md-2">
																<label >Preço, Prazo e Promoção</label><br>
																<a class="btn btn-success btn-block" href="<?php echo base_url() . 'produtos/tela_precos/' . $produtos['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-usd"></span> Ver
																</a>
															</div>
															<div class="col-md-2">
																<label >Produto</label><br>
																<a class="btn btn-warning btn-block" href="<?php echo base_url() . 'produtos/alterar2/' . $produtos['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Editar
																</a>
															</div>
														<?php }elseif($metodo == 6){ ?>
															<div class="col-md-2">
																<label >Preços e Prazos</label><br>
																<a class="btn btn-danger btn-block" href="<?php echo base_url() . 'produtos/alterar_precos/' . $produtos['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Cadastrar / Editar
																</a>
															</div>
															<!--
															<div class="col-md-2">
																<a class="btn btn-danger btn-block" href="<?php /*echo base_url() . 'promocao/cadastrar/' */?>" role="button">
																	<span class="glyphicon glyphicon-edit"></span> Cad./Edit. Promoção
																</a>
															</div>
															-->
															<div class="col-md-2">
																<label >Produto</label><br>
																<a class="btn btn-info btn-block" href="<?php echo base_url() . 'produtos/tela/' . $produtos['idTab_Produtos'] ?>" role="button">
																	<span class="glyphicon glyphicon-pencil"></span> Ver 
																</a>
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
																		<?php if ($promocao['produto'] == "S") { ?>
																			<p>* Este Produto ainda não foi comercializado, mas pertence a(s) Promoção(s) apresentada(s) abaixo.</p>
																			<p>* Antes de Excluir o Produto, Reveja a(s) promoção(s).</p>
																		<?php } else { ?>
																			<p>* Este Produto ainda não foi comercializado e não pertence a nenhuma Promoção.</p>
																			<p>* Ao confirmar esta exclusão todos os dados serão excluídos do banco de dados.</p>
																			<p>* Esta operação é irreversível.</p>
																		<?php } ?>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6 text-left">
																			<button type="button" class="btn btn-warning" onclick="DesabilitaBotao()" data-dismiss="modal">
																				<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																			</button>
																		</div>
																		<?php if ($promocao['produto'] == "N") { ?>
																			<div class="col-md-6 text-right">
																				<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idTab_Produtos'] ?>" role="button">
																					<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																				</a>
																			</div>
																		<?php } ?>
																	</div>
																</div>
															</div>
														</div>
													<?php } else { ?>
														<div class="col-md-2 text-left">
															<label for="Cadastrar">Encontrou?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																	foreach ($select['Cadastrar'] as $key => $row) {
																		if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';
																		
																		($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																		
																		if ($cadastrar['Cadastrar'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
																			. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																			. 'onchange="codigo()" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																			} else {
																			echo ''
																			. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
																			. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																			. 'onchange="codigo()" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																?>
																
															</div>
														</div>
														<div class="col-md-4 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
															<div class="row">
																<div class="col-md-6 text-left">	
																	<label >Categoria</label><br>
																	<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addCatprodModal">
																		Cad./Edit
																	</button>
																</div>	
																<div class="col-md-6 text-left">
																	<label >Recarregar</label><br>
																	<button class="btn btn-md btn-warning btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																		<span class="glyphicon glyphicon-refresh"></span>Recarregar
																	</button>
																</div>	
																<span id="msg"></span>
															</div>	
															<?php echo form_error('Cadastrar'); ?>
														</div>
														<div class="col-md-2">
															<label >Alterações</label><br>
															<button class="btn btn-md btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-save"></span> Próximo Passo
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
			</div>
			<?php if ($metodo < 6) { ?>
				<?php if ($metodo >= 3) { ?>
					<?php if (isset($list)) echo $list; ?>
					<?php if (isset($list_promocoes)) echo $list_promocoes; ?>
				<?php } ?>
			<?php }elseif($metodo >= 6){ ?>	
				<?php if (isset($list_precos)) echo $list_precos; ?>
				<?php if (isset($list_precos_promocoes)) echo $list_precos_promocoes; ?>
			<?php } ?>
			</form>
		</div>
	</div>
</div>

<div class="modal fade produto" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Evite cadastrar Produtos REPETIDOS!<br>
										"Pesquise" os Produtos Cadastradas!</h4>
			</div>
			<!--
			<div class="modal-body">
				<p>Pesquise os Produtos Cadastrados!!</p>
			</div>
			-->
			<div class="modal-footer">
				<div class="form-group col-md-4">
					<div class="form-footer ">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</div>
				</div>
				<div class="form-group col-md-4 text-left">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>produtos/cadastrar" role="button">
							<span class="glyphicon glyphicon-plus"></span> Novo Produto
						</a>
					</div>	
				</div>									
			</div>
		</div>
	</div>
</div>

<div class="modal fade promocao" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Evite cadastrar Promoções REPETIDOS!<br>
										"Pesquise" as Promoções Cadastradas!</h4>
			</div>
			<!--
			<div class="modal-body">
				<p>Pesquise os Produtos Cadastrados!!</p>
			</div>
			-->
			<div class="modal-footer">
				<div class="form-group col-md-4">
					<div class="form-footer ">
						<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</div>
				</div>
				<div class="form-group col-md-4 text-left">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>promocao/cadastrar" role="button">
							<span class="glyphicon glyphicon-plus"></span> Nova Promocao
						</a>
					</div>	
				</div>									
			</div>
		</div>
	</div>
</div>

<div id="addCatprodModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCatprodModalLabel">Cadastrar Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-catprod"></span>
				<form method="post" id="insert_catprod_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Tipo</label>
						<div class="col-sm-10">
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
							id="TipoCatprod" name="TipoCatprod">
								<option value="">-- Selecione uma opção --</option>
								<?php
									foreach ($select['TipoCatprod'] as $key => $row) {
										if ($cadastrar['TipoCatprod'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
								?>
							</select>
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input name="Novo_Catprod" type="text" class="form-control" id="Novo_Catprod" placeholder="Nome da Categoria">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Balcao</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Balcao_Catprod_Cadastrar" class="custom-control-input " id="Balcao_Catprod_Cadastrar_Nao" value="N">
									<label class="custom-control-label" for="Nao">Nao </label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Balcao_Catprod_Cadastrar" class="custom-control-input "  id="Balcao_Catprod_Cadastrar_Sim" value="S" checked>
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Site</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Site_Catprod_Cadastrar" class="custom-control-input " id="Site_Catprod_Cadastrar_Nao" value="N">
									<label class="custom-control-label" for="Nao">Nao </label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Site_Catprod_Cadastrar" class="custom-control-input "  id="Site_Catprod_Cadastrar_Sim" value="S" checked>
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharCatprod" id="botaoFecharCatprod">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadCatprod" id="botaoCadCatprod" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarCatprod" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list1)) echo $list1; ?>
			</div>
		</div>
	</div>
</div>

<div id="alterarCatprod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarCatprodLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="alterarCatprodLabel">Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-catprod"></span>
				<form method="post" id="alterar_catprod_form">
					<div class="form-group row">
						<label for="Catprod" class="col-sm-2 col-form-label">Categoria:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="Catprod" id="Catprod">
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Balcao</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Balcao_Catprod_Alterar" class="custom-control-input " id="Balcao_Catprod_Alterar_Nao" value="N" >
									<label class="custom-control-label" for="Nao">Nao</label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Balcao_Catprod_Alterar" class="custom-control-input "  id="Balcao_Catprod_Alterar_Sim" value="S" >
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Site</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Site_Catprod_Alterar" class="custom-control-input " id="Site_Catprod_Alterar_Nao" value="N" >
									<label class="custom-control-label" for="Nao">Nao</label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="Site_Catprod_Alterar" class="custom-control-input "  id="Site_Catprod_Alterar_Sim" value="S" >
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="id_Categoria" id="id_Categoria">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarCatprod" id="CancelarCatprod" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarCatprod" id="AlterarCatprod" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarCatprod" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="excluirCatprod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirCatprodLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="excluirCatprodLabel">Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-excluir-catprod"></span>
				<form method="post" id="excluir_catprod_form">
					
					<div class="form-group row">
						<label for="Catprod_Excluir" class="col-sm-2 col-form-label">Categoria:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="Catprod_Excluir" id="Catprod_Excluir" readonly="">
						</div>	
					</div>
					<input type="hidden" name="id_Categoria_Excluir" id="id_Categoria_Excluir">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarExcluirCatprod" id="CancelarExcluirCatprod" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="ExcluirCatprod" id="ExcluirCatprod" >Apagar</button>	
						<div class="col-md-12 alert alert-warning aguardarExcluirCatprod" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="addAtributoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addAtributoModalLabel">Cadastrar Variacao</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-atributo"></span>
				<form method="post" id="insert_atributo_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input type="hidden" name="idCat_Atributo" id="idCat_Atributo" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
							<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Variacao</label>
						<div class="col-sm-10">
							<input name="Novo_Atributo" type="text" class="form-control" id="Novo_Atributo" placeholder="Variacao">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharAtributo" id="botaoFecharAtributo">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<?php if($Conta_Atributos < 2) { ?>
								<br>
								<button type="submit" class="btn btn-success btn-block" name="botaoCadAtributo" id="botaoCadAtributo" >
									<span class="glyphicon glyphicon-plus"></span> Cadastrar
								</button>
							<?php } ?>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarAtributo" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list3)) echo $list3; ?>
			</div>
		</div>
	</div>
</div>

<div id="alterarAtributo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarAtributoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarAtributoLabel">Variacao</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-atributo"></span>
				<form method="post" id="alterar_atributo_form">
					<div class="form-group">
						<label for="Atributo" class="control-label">Variacao:</label>
						<input type="text" class="form-control" name="Atributo" id="Atributo">
					</div>
					<input type="hidden" name="id_Atributo" id="id_Atributo">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarAtributo" id="CancelarAtributo" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarAtributo" id="AlterarAtributo" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarAtributo" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="excluirAtributo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirAtributoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="excluirAtributoLabel">Variacao</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-excluir-atributo"></span>
				<form method="post" id="excluir_atributo_form">
					<div class="form-group">
						<label for="ExcluirAtributo" class="control-label">Variacao:</label>
						<input type="text" class="form-control" name="ExcluirAtributo" id="ExcluirAtributo" readonly="">
					</div>
					<input type="hidden" name="id_ExcluirAtributo" id="id_ExcluirAtributo">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarExcluirAtributo" id="CancelarExcluirAtributo" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="Excluirtributo" id="ExcluirAtributo" >Apagar</button>	
						<div class="col-md-12 alert alert-warning aguardarExcluirAtributo" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="addOpcaoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addOpcaoModalLabel">Cadastrar Opcao</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-opcao"></span>
				<form method="post" id="insert_opcao_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input type="hidden" name="idCat_Opcao" id="idCat_Opcao" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
							<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Variacao</label>
						<div class="col-sm-10">
							<select data-placeholder="Selecione uma Variacao..." class="form-control Chosen"
							id="idAtributo_Opcao" name="idAtributo_Opcao">
								<option value="">-- Selecione uma Variacao --</option>
								<?php
									foreach ($select['idAtributo_Opcao'] as $key => $row) {
										if ($cadastrar['idAtributo_Opcao'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
								?>
							</select>
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Opcao</label>
						<div class="col-sm-10">
							<input name="Novo_Opcao" type="text" class="form-control" id="Novo_Opcao" placeholder="Opcao">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharOpcao" id="botaoFecharOpcao">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadOpcao" id="botaoCadOpcao" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarOpcao" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list4)) echo $list4; ?>
			</div>
		</div>
	</div>
</div>

<div id="alterarOpcao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarOpcaoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarOpcaoLabel">Opcao</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-opcao"></span>
				<form method="post" id="alterar_opcao_form">
					<div class="form-group">
						<label for="Opcao" class="control-label">Opcao:</label>
						<input type="text" class="form-control" name="Opcao" id="Opcao">
					</div>
					<input type="hidden" name="id_Opcao" id="id_Opcao">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarOpcao" id="CancelarOpcao" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarOpcao" id="AlterarOpcao" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarOpcao" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="excluirOpcao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirOpcaoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="excluirOpcaoLabel">Opcao</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-excluir-opcao"></span>
				<form method="post" id="excluir_opcao_form">
					<div class="form-group">
						<label for="ExcluirOpcao" class="control-label">Opcao:</label>
						<input type="text" class="form-control" name="ExcluirOpcao" id="ExcluirOpcao" readonly="">
					</div>
					<input type="hidden" name="id_ExcluirOpcao" id="id_ExcluirOpcao">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarExcluirOpcao" id="CancelarExcluirOpcao" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="ExcluirOpcao" id="ExcluirOpcao" >Apagar</button>	
						<div class="col-md-12 alert alert-warning aguardarExcluirOpcao" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="addProdutoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addProdutoModalLabel">Cadastrar Produto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-produto"></span>
				<form method="post" id="insert_produto_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Categoria</label>
						<div class="col-sm-10">
							<input type="hidden" name="idCat_Produto" id="idCat_Produto" value="<?php echo $_SESSION['Produtos']['idTab_Catprod']; ?>">
							<input class="form-control"readonly="" value="<?php echo $_SESSION['Produtos']['Catprod']; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Produto</label>
						<div class="col-sm-10">
							<input name="Novo_Produto" type="text" class="form-control" id="Novo_Produto" placeholder="Produto">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Balcao</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaBalcao_Cadastrar" class="custom-control-input " id="VendaBalcao_Cadastrar_Nao" value="N">
									<label class="custom-control-label" for="Nao">Nao </label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaBalcao_Cadastrar" class="custom-control-input "  id="VendaBalcao_Cadastrar_Sim" value="S" checked>
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Site</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaSite_Cadastrar" class="custom-control-input " id="VendaSite_Cadastrar_Nao" value="N">
									<label class="custom-control-label" for="Nao">Nao </label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaSite_Cadastrar" class="custom-control-input "  id="VendaSite_Cadastrar_Sim" value="S" checked>
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list2)) echo $list2; ?>
			</div>
		</div>
	</div>
</div>

<div id="alterarProduto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarProdutoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarProdutoLabel">Produto</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-produto"></span>
				<form method="post" id="alterar_produto_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Produto</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="AlterarProdutos" id="AlterarProdutos">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Balcao</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaBalcao_Alterar" class="custom-control-input " id="VendaBalcao_Alterar_Nao" value="N" >
									<label class="custom-control-label" for="Nao">Nao</label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaBalcao_Alterar" class="custom-control-input "  id="VendaBalcao_Alterar_Sim" value="S" >
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Site</label>
						<div class="col-sm-10">
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaSite_Alterar" class="custom-control-input " id="VendaSite_Alterar_Nao" value="N" >
									<label class="custom-control-label" for="Nao">Nao</label>
								</div>
							</div>
							<div class="col-md-2 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="VendaSite_Alterar" class="custom-control-input "  id="VendaSite_Alterar_Sim" value="S" >
									<label class="custom-control-label" for="Sim">Sim</label>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="id_Produto" id="id_Produto">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarProduto" id="CancelarProduto" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarProduto" id="AlterarProduto" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarProduto" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="excluirProduto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirProdutoLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="excluirProdutoLabel">Produto</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-excluir-produto"></span>
				<form method="post" id="excluir_produto_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Produto</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="ExcluirProdutos" id="ExcluirProdutos" readonly="">
						</div>
					</div>
					<input type="hidden" name="id_ExcluirProduto" id="id_ExcluirProduto">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarExcluirProduto" id="CancelarExcluirProduto" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="ExcluirProduto" id="ExcluirProduto" >Apagar</button>	
						<div class="col-md-12 alert alert-warning aguardarExcluirProduto" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

