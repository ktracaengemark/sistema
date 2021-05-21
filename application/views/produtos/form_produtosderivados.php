<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-md-12 ">	
<?php #echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		
		<div class="panel-heading">
			<?php echo $titulo; ?>
			<?php if ($metodo != 2) { ?>
				<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/produtos" role="button">
					<span class="glyphicon glyphicon-search"></span> Produtos/Servicos
				</a>
				<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/estoque" role="button">
					<span class="glyphicon glyphicon-search"></span> Estoque
				</a>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModeloModal">
					Cadastrar
				</button>
			<?php } ?>
		</div>
		
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>
			
				<!--Tab_Produto-->
	
				<div class="row">
					<div class="col-md-4">
						<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">	
							<div class="panel panel-primary">
								<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Dados do: 
										</a>
									</h4>
								</div>
								<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
									<div class="panel panel-success">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-6">
													<label for="Prod_Serv">Produto ou Servico*</label>								
													<?php if ($metodo == 0) { ?>	
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																id="Prod_Serv" name="Prod_Serv">
															<option value="">-- Sel.a Opção --</option>
															<?php
															foreach ($select['Prod_Serv'] as $key => $row) {
																if ($produtos['Prod_Serv'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
														<?php echo form_error('Prod_Serv'); ?>
													<?php } else { ?>
															<br>
															<?php echo '<strong>" ' . $_SESSION['Produto']['TipoProdServ'] . ' "</strong>' ?>
													<?php } ?>
												</div>
												<?php if ($metodo > 0) { ?>	
													<div class="col-md-6">
														<label for="idTab_Catprod">Categoria*:</label>								
														<?php if ($metodo == 1) { ?>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> 
																	id="idTab_Catprod" name="idTab_Catprod">
																<option value="">-- Sel.uma Categoria --</option>
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
															<?php echo form_error('idTab_Catprod'); ?>
														<?php } else { ?>
															<br>
															<?php echo '<strong>" ' . $_SESSION['Produto']['Catprod'] . ' "</strong>' ?>
														<?php } ?>
													</div>
												<?php } ?>	
											</div>
											<?php if ($metodo > 1) { ?>
												<div class="row">
													<div class="col-md-12">
														<label for="idTab_Modelo">Modelo *</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="idTab_Modelo" name="idTab_Modelo">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['idTab_Modelo'] as $key => $row) {
																if ($produtos['idTab_Modelo'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
														<?php echo form_error('idTab_Modelo'); ?>
													</div>
												</div>
												<div class="row">				
													<div class="col-md-6">
														<label for="TipoProduto">Venda/Cons/Alug:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="TipoProduto" name="TipoProduto">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['TipoProduto'] as $key => $row) {
																if ($produtos['TipoProduto'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
														<?php echo form_error('TipoProduto'); ?>
													</div>
													<div class="col-md-6">
														<label for="UnidadeProduto">Unidade:</label>
														<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																id="UnidadeProduto" name="UnidadeProduto">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['UnidadeProduto'] as $key => $row) {
																if ($produtos['UnidadeProduto'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 text-left">
														<label for="Ativo">Ativo?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['Ativo'] as $key => $row) {
																if (!$produtos['Ativo']) $produtos['Ativo'] = 'N';

																($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																if ($produtos['Ativo'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="Ativo_' . $hideshow . '">'
																	. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="Ativo_' . $hideshow . '">'
																	. '<input type="radio" name="Ativo" id="' . $hideshow . '" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
													<div id="Ativo" <?php echo $div['Ativo']; ?>>
														<div class="col-md-4 text-left">
															<label for="VendaBalcao">VendaBalcao?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['VendaBalcao'] as $key => $row) {
																	if (!$produtos['VendaBalcao']) $produtos['VendaBalcao'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($produtos['VendaBalcao'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="VendaBalcao_' . $hideshow . '">'
																		. '<input type="radio" name="VendaBalcao" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="VendaBalcao_' . $hideshow . '">'
																		. '<input type="radio" name="VendaBalcao" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>								
														<div id="VendaBalcao" <?php echo $div['VendaBalcao']; ?>>	
															
														</div>	
														<div class="col-md-4 text-left">
															<label for="VendaSite">VendaSite?</label><br>
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['VendaSite'] as $key => $row) {
																	if (!$produtos['VendaSite']) $produtos['VendaSite'] = 'N';

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																	if ($produtos['VendaSite'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="VendaSite_' . $hideshow . '">'
																		. '<input type="radio" name="VendaSite" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="VendaSite_' . $hideshow . '">'
																		. '<input type="radio" name="VendaSite" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" >' . $row
																		. '</label>'
																		;
																	}
																}
																?>
															</div>
														</div>								
														<div id="VendaSite" <?php echo $div['VendaSite']; ?>>	
															
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

				<?php if ($metodo > 2) { ?>
					<div class="row">
						<div class="col-md-12">	
							<div class="panel-group" id="accordion7" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading7" data-toggle="collapse" data-parent="#accordion7" data-target="#collapse7">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Produtos Derivados
											</a>
										</h4>
									</div>	
							
									<div id="collapse7" class="panel-collapse" role="tabpanel" aria-labelledby="heading7" aria-expanded="false">
										<div class="panel panel-success">
											<div class="panel-heading">
												<input type="hidden" name="PDCount" id="PDCount" value="<?php echo $count['PDCount']; ?>"/>

												<div class="input_fields_wrap97">

													<?php
													$QtdSoma = $ProdutoSoma = 0;
													for ($i=1; $i <= $count['PDCount']; $i++) {
													?>

													<?php if ($metodo > 1) { ?>
													<input type="hidden" name="idTab_Produtos<?php echo $i ?>" value="<?php echo $derivados[$i]['idTab_Produtos']; ?>"/>
													<?php } ?>

													<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">

													<div class="form-group" id="97div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-3">
																		<label for="Nome_Prod">Produto <?php echo $i ?></label>
																		<input type="text" class="form-control"  id="Nome_Prod<?php echo $i ?>" <?php echo $readonly; ?> readonly = ""
																				  name="Nome_Prod<?php echo $i ?>" value="<?php echo $derivados[$i]['Nome_Prod']; ?>">
																	</div>
																	<div class="col-md-3">
																		<label for="Opcao_Atributo_2<?php echo $i ?>">Atributo1 </label>
																		<?php if ($i == 1) { ?>
																		<?php } ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																				 id="listadinamican<?php echo $i ?>" name="Opcao_Atributo_2<?php echo $i ?>">
																			<option value="">-- Sel.Opcao --</option>
																			<?php
																			foreach ($select['Opcao_Atributo_2'] as $key => $row) {
																				if ($derivados[$i]['Opcao_Atributo_2'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																	<div class="col-md-3">
																		<label for="Opcao_Atributo_1">Atributo2 </label>
																		<?php if ($i == 1) { ?>
																		<?php } ?>
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																				 id="listadinamicam<?php echo $i ?>" name="Opcao_Atributo_1<?php echo $i ?>">
																			<option value="">-- Sel. Opcao --</option>
																			<?php
																			foreach ($select['Opcao_Atributo_1'] as $key => $row) {
																				if ($derivados[$i]['Opcao_Atributo_1'] == $key) {
																					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																				} else {
																					echo '<option value="' . $key . '">' . $row . '</option>';
																				}
																			}
																			?>
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label for="Valor_Produto">Valor Custo </label>
																		<div class="input-group">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="Valor_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																				name="Valor_Produto<?php echo $i ?>" value="<?php echo $derivados[$i]['Valor_Produto'] ?>">
																		</div>
																	</div>
																	<!--
																	<div class="col-md-1">
																		<label><br></label><br>
																		<button type="button" id="<?php echo $i ?>" class="remove_field97 btn btn-danger">
																			<span class="glyphicon glyphicon-trash"></span>
																		</button>
																	</div>
																	-->
																</div>
															</div>
														</div>
													</div>

													<?php
													//$QtdSoma+=$derivados[$i]['QtdProduto'];
													//$ProdutoSoma++;
													}
													?>
													<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">
												</div>
												
												<div class="panel panel-warning">
													<div class="panel-heading text-left">
														<div class="row">
															<div class="col-md-4">
																<label></label>
																<a class="add_field_button97 btn btn-success">
																	<span class="glyphicon glyphicon-arrow-up"></span> Adicionar Derivados
																</a>
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
					</div>
				<?php } ?>	
				
				<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
				
				<div class="row">
					<div class="col-md-12">
						<!--<input type="hidden" name="idTab_Produto" value="<?php echo $produtos['idTab_Produto']; ?>">-->
						<?php if ($metodo > 1) { ?>
							<input type="hidden" name="idTab_Catprod" value="<?php echo $_SESSION['Produto']['idTab_Catprod']; ?>">
						<?php } ?>
						<?php if ($metodo > 1) { ?>

							<div class="col-md-6">
								<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." >
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>
							</div>
							<!--
							<div class="col-md-6 text-right">
								<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
									<span class="glyphicon glyphicon-trash"></span> Excluir
								</button>
							</div>
							-->
							<div id="msgCadModeloSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header bg-success text-center">
											<h4 class="modal-title" id="visulUsuarioModalLabel">Modelo cadastrado com sucesso!</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										</div>
										<!--
										<div class="modal-body">
											Modelo cadastrado com sucesso!
										</div>
										-->
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
												<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idTab_Produto'] ?>" role="button">
													<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } else { ?>
							<div class="col-md-6">
								<button class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." type="submit">
									<span class="glyphicon glyphicon-save"></span> Salvar
								</button>
							</div>
						<?php } ?>
						
					</div>
				</div>
				<?php } ?>
			
			</form>

		</div>

	</div>

</div>
<div id="addModeloModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addModeloModalLabel">Cadastrar Modelo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-modelo"></span>
				<form method="post" id="insert_modelo_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Modelo</label>
						<div class="col-sm-10">
							<input name="Novo_Modelo" type="text" class="form-control" id="Novo_Modelo" placeholder="Modelo">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Descrição</label>
						<div class="col-sm-10">
							<input name="Desc_Modelo" type="text" class="form-control" id="Desc_Modelo" placeholder="Descrição">
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCad" id="botaoCad" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFechar" id="botaoFechar">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardar1" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	