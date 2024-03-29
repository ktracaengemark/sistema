<div class="container-fluid">
	<div class="row">	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<h4 class="text-center">
								<?php 
									if(isset($_SESSION['Orcatrata']['id_Funcionario']) && $_SESSION['Orcatrata']['id_Funcionario'] !=0){
										if(isset($funcionario)){
											$colaborador = 'Vendedor: ' . $funcionario['Nome'];
										}
									}elseif(isset($_SESSION['Orcatrata']['id_Associado']) && $_SESSION['Orcatrata']['id_Associado'] !=0){
										if(isset($associado)){
											$colaborador = 'Associado: ' . $associado['Nome'];
										}
									}else{
										$colaborador = "Sem Vendedor";
									}
								?>
								<b><?php echo $colaborador; ?></b>
							</h4>
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
													<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">			
														<h4 class="mb-3">
															<b>Editar Receita | N�</b> 
															<?php echo $_SESSION['Orcatrata']['idApp_OrcaTrata'] ?> - 
															<?php 
																if($orcatrata['Tipo_Orca'] == "B"){
																	echo 'Balc�o';
																} elseif($orcatrata['Tipo_Orca'] == "O"){
																	echo 'OnLine';
																}
															?>
														</h4>
													</div>	
													<?php if (isset($_SESSION['Orcatrata']['RepeticaoCons']) && $_SESSION['Orcatrata']['RepeticaoCons'] != 0){ ?>	
														<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
															<label >Agendamentos</label>
															<!--
															<a class="btn btn-md btn-info btn-block" href="<?php #echo base_url() ?>consulta/alterar/<?php #echo $_SESSION['Orcatrata']['idApp_Cliente'];?>/<?php #echo $_SESSION['Orcatrata']['RepeticaoCons'];?>" role="button">
																<span class="glyphicon glyphicon-pencil"></span> <?php #echo $_SESSION['Orcatrata']['RepeticaoCons'];?>
															</a>
															-->
															<a class="btn btn-md btn-info btn-block"  name="submeter6" id="submeter6" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() ?>agenda" role="button">
																<span class="glyphicon glyphicon-calendar"></span> <b><?php echo $_SESSION['Orcatrata']['RecorrenciaOrca'];?></b> 
															</a>
															<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																Aguarde um instante! Estamos processando sua solicita��o!
															</div>
														</div>
													<?php } ?>
												</div>
											</div>		
											<div class="form-group">	
												<div class="row">
													<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
														<label for="TipoFinanceiro">Tipo de Receita</label>
														<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
																id="TipoFinanceiro" name="TipoFinanceiro">
															<option value="">-- Selecione uma op��o --</option>
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
															<input type="text" class="form-control Date" <?php echo $readonly; ?><?php echo $readonly_cons; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()" onkeyup="dateDiff()"
																	id="DataOrca" name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
														</div>
													</div>

													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
														<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-left">	
															<div class="row">
																<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4 text-left">
																	<label for="Cli_Forn_Orca">Cliente?</label><br>
																	<input type="text" class="form-control"id="Cli_Forn_Orca" name="Cli_Forn_Orca" value="<?php echo $_SESSION['Orcatrata']['Cli_Forn_Orca']; ?>" readonly="">
																</div>
																<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4 text-left">
																	<label for="Prd_Srv_Orca">Prd/Srv?</label><br>
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
																	<label for="Entrega_Orca">Entrega?</label><br>
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
														<input type="hidden" name="Cli_Forn_Orca" id="Cli_Forn_Orca" value="<?php echo $_SESSION['Orcatrata']['Cli_Forn_Orca']; ?>"/>
														<input type="hidden" name="Prd_Srv_Orca" id="Prd_Srv_Orca" value="<?php echo $orcatrata['Prd_Srv_Orca']; ?>"/>
														<input type="hidden" name="Entrega_Orca" id="Entrega_Orca" value="<?php echo $orcatrata['Entrega_Orca']; ?>"/>
													<?php } ?>
												</div>
												<input type="hidden" id="Hidden_Cli_Forn_Orca" value="<?php echo $_SESSION['Orcatrata']['Cli_Forn_Orca']; ?>"/>
												<input type="hidden" id="Hidden_Entrega_Orca" value="<?php echo $orcatrata['Entrega_Orca']; ?>"/>
											</div>
											<input type="hidden" id="Caminho2" name="Caminho2" value="<?php echo $caminho2; ?>">
											<div <?php echo $visivel; ?>>
												<div class="row">
													<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
														<label >Cliente</label>
														<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Cliente']['NomeCliente']; ?>">
													</div>
													<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
														<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $orcatrata['idApp_ClientePet']; ?>" />
														<!--
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
															<label  for="idApp_ClientePet">Pet</label>
																<select data-placeholder="Selecione uma op��o..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
																	<option value=""></option>
																</select>
															<span class="modal-title" id="Pet"></span>
														</div>
														-->
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
															<label for="idApp_ClientePet">Pet</label>
															<?php if (isset($_SESSION['Orcatrata']['RepeticaoCons']) && $_SESSION['Orcatrata']['RepeticaoCons'] != 0){ ?>
																<?php 
																	if (isset($_SESSION['Orcatrata']['idApp_ClientePet']) && $_SESSION['Orcatrata']['idApp_ClientePet'] != 0){
																		$clientepet = $_SESSION['ClientePet']['NomeClientePet'];
																	}else{
																		$clientepet = '';
																	}
																?>
																<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $clientepet; ?>">
															<?php }else{ ?>
																<select data-placeholder="Selecione uma op��o..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet">
																	<option value=""></option>
																</select>
															<?php } ?>
															<span class="modal-title" id="Pet"></span>
														</div>
													<?php }else{ ?>
														<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
															<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $orcatrata['idApp_ClienteDep']; ?>" />
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
																<label  for="idApp_ClienteDep">Dependente</label>
																<?php if (isset($_SESSION['Orcatrata']['RepeticaoCons']) && $_SESSION['Orcatrata']['RepeticaoCons'] != 0){ ?>
																	<?php 
																		if (isset($_SESSION['Orcatrata']['idApp_ClienteDep']) && $_SESSION['Orcatrata']['idApp_ClienteDep'] != 0){ 
																			$clientedep = $_SESSION['ClienteDep']['NomeClienteDep'];
																		}else{
																			$clientedep = '';
																		}
																	?>
																	<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $clientedep; ?>">
																<?php }else{ ?>																	
																	<select data-placeholder="Selecione uma op��o..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep">
																		<option value=""></option>
																	</select>
																<?php } ?>	
																<span class="modal-title" id="Dep"></span>
															</div>
														<?php } ?>
													<?php } ?>
													<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S" || $_SESSION['Empresa']['CadastrarDep'] == "S") { ?>	
														<?php if($this->Basico_model->get_dt_validade()) { ?>
															<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
																<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>	
																	<label for="Cadastrar">Pet Encontrado?</label><br>
																<?php }elseif($_SESSION['Empresa']['CadastrarDep'] == "S"){ ?>	
																	<label for="Cadastrar">Dep Encontrado?</label><br>
																<?php } ?>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['Cadastrar'] as $key => $row) {
																		if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';
																		($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																		if ($cadastrar['Cadastrar'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
																			. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
																			. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
															<div class="text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
																<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3  text-left">
																	<label >Recarregar</label><br>
																	<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
																			<span class="glyphicon glyphicon-refresh"></span>Recarregar
																	</button>
																</div>
																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6  text-left">
																	<div class="row">
																		<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
																			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6  text-left">
																				<label >Pet</label><br>
																				<button type="button" class="btn btn-success btn-block" id="addPet" data-toggle="modal" data-target="#addClientePetModal" >
																					<span class="glyphicon glyphicon-plus"></span>Cadastrar
																				</button>
																			</div>
																		<?php }else{ ?>	
																			<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
																				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-left">
																					<label >Dependente</label><br>
																					<button type="button" class="btn btn-success btn-block" id="addDep" data-toggle="modal" data-target="#addClienteDepModal">
																						<span class="glyphicon glyphicon-plus"></span>Cadastrar
																					</button>
																				</div>
																			<?php } ?>
																		<?php } ?>
																	</div>	
																</div>	
																<!--
																<a class="btn btn-md btn-info"   target="_blank" href="<?php echo base_url() ?>cliente2/cadastrar3/" role="button"> 
																	<span class="glyphicon glyphicon-plus"></span> <span class="glyphicon glyphicon-edit"></span> Cliente
																</a>
																-->
																<?php echo form_error('Cadastrar'); ?>
															</div>
														<?php } ?>
													<?php } ?>
												</div>
											</div>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
												<div id="Prd_Srv_Orca" <?php echo $div['Prd_Srv_Orca']; ?>>	
													<h5 class="mb-3"><b>Produtos & Servi�os</b></h5>
												
													<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>
													
													<div class="input_fields_wrap9">
														
														<?php
														$QtdSoma = $ProdutoSoma = 0;
														for ($i=1; $i <= $count['PCount']; $i++) {
														?>

															<?php if (isset($produto[$i]['idApp_Produto'])) { ?>
																
																<input type="hidden" name="idApp_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_Produto']; ?>"/>

																<input type="hidden" name="ProdutoHidden" id="ProdutoHidden<?php echo $i ?>" value="<?php echo $i ?>">
															<?php } ?>
																<div class="form-group" id="9div<?php echo $i ?>">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<input type="hidden" class="form-control " id="idTab_Valor_Produto<?php echo $i ?>" name="idTab_Valor_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Valor_Produto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Produtos_Produto<?php echo $i ?>" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">
																			<input type="hidden" class="form-control " id="Prod_Serv_Produto<?php echo $i ?>" name="Prod_Serv_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['Prod_Serv_Produto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoProduto<?php echo $i ?>" name="ComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServicoProduto<?php echo $i ?>" name="ComissaoServicoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoCashBackProduto<?php echo $i ?>" name="ComissaoCashBackProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoCashBackProduto'] ?>">
																			<!--<input type="hidden" class="form-control " id="NomeProduto<?php echo $i ?>" name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">-->
																			<input type="hidden" class="form-control " name="idTab_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produto'] ?>">
																			<div class="row">
																				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
																					<div class="row">
																						<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
																							<label for="NomeProduto">Produto <?php echo $i ?></label>
																							<input type="text" class="form-control text-left"  readonly="" id="NomeProduto<?php echo $i ?>"
																								   name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">
																						</div>
																						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																							<label for="ObsProduto">Obs</label>
																							<textarea type="text" class="form-control" maxlength="200" id="ObsProduto<?php echo $i ?>" placeholder="Observacao"
																									 name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>" rows="1"><?php echo $produto[$i]['ObsProduto'] ?>
																							</textarea>
																						</div>
																					</div>
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
																				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																					<div class="row">
																						<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
																							<label for="DataConcluidoProduto">Data Entrega</label>
																							<div class="input-group DatePicker">
																								<span class="input-group-addon" disabled>
																									<span class="glyphicon glyphicon-calendar"></span>
																								</span>
																								<input type="text" class="form-control Date" id="DataConcluidoProduto<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																									   name="DataConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataConcluidoProduto'] ?>" <?php echo $readonly_cons; ?>>
																							</div>
																						</div>
																						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																							<label for="HoraConcluidoProduto">Hora</label>
																							<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																							   accept="" name="HoraConcluidoProduto<?php echo $i ?>" id="HoraConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['HoraConcluidoProduto']; ?>" <?php echo $readonly_cons; ?>>
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
																											echo 'N�o';
																										}else{
																											echo 'N�o';
																										}
																									?>
																								</span>
																							<?php } ?>
																						</div>
																						<div id="ConcluidoProduto<?php echo $i ?>" <?php echo $div['ConcluidoProduto' . $i]; ?>>
																						</div>
																						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 ">
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

															<?php if (isset($servico[$i]['idApp_Produto'])) { ?>
																
																<input type="hidden" name="idApp_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_Produto']; ?>"/>

																<input type="hidden" name="ServicoHidden" id="ServicoHidden<?php echo $i ?>" value="<?php echo $i ?>">
															<?php } ?>
																<div class="form-group" id="10div<?php echo $i ?>">
																	<div class="panel panel-danger">
																		<div class="panel-heading">
																			<input type="hidden" class="form-control " id="idTab_Valor_Servico<?php echo $i ?>" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Produto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Produtos_Servico<?php echo $i ?>" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Produto'] ?>">
																			<input type="hidden" class="form-control " id="Prod_Serv_Servico<?php echo $i ?>" name="Prod_Serv_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['Prod_Serv_Produto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServico<?php echo $i ?>" name="ComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServicoServico<?php echo $i ?>" name="ComissaoServicoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoCashBackServico<?php echo $i ?>" name="ComissaoCashBackServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoCashBackProduto'] ?>">
																			<!--<input type="hidden" class="form-control " id="NomeServico<?php echo $i ?>" name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">-->
																			<input type="hidden" class="form-control " name="idTab_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produto'] ?>">
																			<div class="row">
																				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">	
																					<div class="row">
																						<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
																							<label for="NomeServico">Servi�o <?php echo $i ?>:</label>
																							<input type="text" class="form-control " readonly="" id="NomeServico<?php echo $i ?>"
																								   name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">
																						</div>
																						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
																							<label for="ObsServico">Obs</label>
																							<textarea type="text" class="form-control" maxlength="200" id="ObsServico<?php echo $i ?>" placeholder="Observacao"
																									 name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsProduto'] ?>" rows="1"><?php echo $servico[$i]['ObsProduto'] ?></textarea>
																						</div>
																					</div>	
																					<div class="row">
																						<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
																							<label for="QtdServico">Qtd.Item</label>
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
																				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																					<div class="row">
																						<div class="col-xs-6 col-sm-4 col-md-6 col-lg-6">
																							<label for="DataConcluidoServico">Data Entrega</label>
																							<div class="input-group DatePicker">
																								<span class="input-group-addon" disabled>
																									<span class="glyphicon glyphicon-calendar"></span>
																								</span>
																								<input type="text" class="form-control Date" id="DataConcluidoServico<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																									   name="DataConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataConcluidoProduto'] ?>" <?php echo $readonly_cons; ?>>
																							</div>
																						</div>
																						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
																							<label for="HoraConcluidoServico">Hora</label>
																							<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																								accept="" name="HoraConcluidoServico<?php echo $i ?>" id="HoraConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['HoraConcluidoProduto']; ?>" <?php echo $readonly_cons; ?>>
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
																											echo 'N�o';
																										}else{
																											echo 'N�o';
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
																						<div class="col-xs-6 col-sm-4 col-md-3  col-lg-3">
																							<label>Excluir</label><br>
																							<button type="button" id="<?php echo $i ?>" class="remove_field10 btn btn-danger btn-block"
																								onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',1,<?php echo $i ?>,'CountMax2',0,'ServicoHidden')">
																								<span class="glyphicon glyphicon-trash"></span>
																							</button>
																						</div>
																					</div>
																				</div>
																				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" <?php echo $div['Prof_comissao']; ?>>
																					<div class="row">
																						<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
																							<div class="row">
																								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																									<label for="ProfissionalServico_1<?php echo $i ?>">Profissional 1</label>
																									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																											 id="listadinamica_prof_1<?php echo $i ?>" name="ProfissionalServico_1<?php echo $i ?>" 
																											onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',1)">
																										<option value="">-- Sel.Profis. --</option>
																										<?php
																										foreach ($select[$i]['ProfissionalServico_1'] as $key => $row) {
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
																									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																											 id="listadinamica_prof_2<?php echo $i ?>" name="ProfissionalServico_2<?php echo $i ?>"
																											onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',2)">
																										<option value="">-- Sel.Profis. --</option>
																										<?php
																										foreach ($select[$i]['ProfissionalServico_2'] as $key => $row) {
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
																									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																											 id="listadinamica_prof_3<?php echo $i ?>" name="ProfissionalServico_3<?php echo $i ?>"
																											onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',3)">
																										<option value="">-- Sel.Profis. --</option>
																										<?php
																										foreach ($select[$i]['ProfissionalServico_3'] as $key => $row) {
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
																									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																											 id="listadinamica_prof_4<?php echo $i ?>" name="ProfissionalServico_4<?php echo $i ?>"
																											onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',4)">
																										<option value="">-- Sel.Profis. --</option>
																										<?php
																										foreach ($select[$i]['ProfissionalServico_4'] as $key => $row) {
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
																									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																											 id="listadinamica_prof_5<?php echo $i ?>" name="ProfissionalServico_5<?php echo $i ?>"
																											onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',5)">
																										<option value="">-- Sel.Profis. --</option>
																										<?php
																										foreach ($select[$i]['ProfissionalServico_5'] as $key => $row) {
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
																									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
																											 id="listadinamica_prof_6<?php echo $i ?>" name="ProfissionalServico_6<?php echo $i ?>"
																											onchange="carregaHidden_Prof(this.value,this.name,'<?php echo $i ?>',6)">
																										<option value="">-- Sel.Profis. --</option>
																										<?php
																										foreach ($select[$i]['ProfissionalServico_6'] as $key => $row) {
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
																<div class="col-xs-12 col-sm-4  col-md-4  col-lg-4  text-left">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-md-4 text-left">
																					<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma; ?></span></b><br />
																				</div>
																				<div class="col-md-8 text-center">	
																					<a class="add_field_button9 btn btn-warning btn-block"
																							onclick="calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)">
																						<span class="glyphicon glyphicon-plus"></span> Adi.Produtos
																					</a>
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
																<div class="col-xs-12 col-sm-4  col-md-4  col-lg-4  text-left">
																	<div class="panel panel-danger">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-md-4 text-left">	
																					<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
																				</div>
																				<div class="col-md-8 text-center">
																					<a class="add_field_button10  btn btn-danger btn-block" 
																							onclick="calculaQtdSomaDev('QtdServico','QtdSomaDev','ServicoSoma',0,0,'CountMax2',1,0)">
																						<span class="glyphicon glyphicon-plus"></span> Adi.Servi�os
																					</a>
																				</div>
																			</div>	
																			<br>
																			<div class="row">
																				<!--
																				<div class="col-md-6">
																					<div class="row">
																						<div class="col-md-12 text-left">	
																							<b>Servi�os: <span class="text-right" id="QtdSomaDev"><?php echo $QtdSomaDev ?></span> </b>
																						</div>
																					</div>
																				</div>
																				-->
																				<div class="col-md-4 text-left">	
																					<b>Servi�os: </b> 
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
												<input type="hidden" class="form-control" name="ValorComissao" id="ValorComissao" value="<?php echo $orcatrata['ValorComissao'] ?>" readonly=''>
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
														<div class="col-sm-5 col-md-4 col-lg-4 text-left">
															<label for="Entregador">Entregador</label>
															<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" <?php echo $readonly; ?>
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
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="DetalhadaEntrega_' . $hideshow . '">'
																		. '<input type="radio" name="DetalhadaEntrega" id="' . $hideshow . '" '
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
																<label class="" for="Logradouro">Endre�o:</label>
																<input type="text" class="form-control " id="Logradouro" maxlength="100" <?php echo $readonly; ?>
																	   name="Logradouro" value="<?php echo $orcatrata['Logradouro']; ?>">
																<?php echo form_error('Logradouro'); ?>
															</div>
															<div class="col-sm-4 col-md-4 ">
																<label class="" for="Numero">N�mero:</label>
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
																<label for="Municipio">Munic�pio:</label><br>
																<select data-placeholder="Selecione um Munic�pio..." class="form-control" <?php echo $disabled; ?>
																		id="Municipio" name="Municipio">
																	<option value="">-- Selec.um Munic�pio --</option>
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
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
																			<label for="PrazoEntrega">Prazo Total</label>
																			<div  class="input-group" id="txtHint">
																				<input type="text" class="form-control " id="PrazoEntrega" maxlength="100" <?php echo $readonly; ?> readonly=""
																					   name="PrazoEntrega" value="<?php echo $orcatrata['PrazoEntrega']; ?>">
																				<span class="input-group-addon" id="basic-addon1">Dias</span> 
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
																			<label for="DataEntregaOrca">Data da Entrega</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()" onkeyup="dateDiff()"
																						id="DataEntregaOrca" name="DataEntregaOrca" value="<?php echo $orcatrata['DataEntregaOrca']; ?>" <?php echo $readonly_cons; ?>>
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
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
																			<label for="HoraEntregaOrca">Hora da Entrega:</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																					   accept=""name="HoraEntregaOrca" value="<?php echo $orcatrata['HoraEntregaOrca']; ?>" <?php echo $readonly_cons; ?>>
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
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
																<input type="hidden" name="TipoExtraOrca" id="TipoExtraOrca" value="<?php echo $orcatrata['TipoExtraOrca'] ?>">
																<input type="text" class="form-control Valor" name="ValorSomaOrca" id="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>" readonly=''/>
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
																	<input type="hidden" id="UsarD" name="UsarD" value="<?php echo $cadastrar['UsarD']; ?>"/>
																	<?php if ($_SESSION['Orcatrata']['UsarCupom'] == "N" ) { ?>
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
																	<?php }else{ ?>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6  text-left">
																			<label for="TipoDescOrca">Tipo de Desc</label><br>
																			<?php 
																				if($_SESSION['Orcatrata']['TipoDescOrca'] == "P"){
																					$TipoDescOrca = '%';
																					}elseif($_SESSION['Orcatrata']['TipoDescOrca'] == "V"){
																					$TipoDescOrca = 'R$';
																				}
																			?>
																			<input type="text" class="form-control" readonly="" value="<?php echo $TipoDescOrca; ?>"/>
																		</div>
																		<input type="hidden" name="TipoDescOrca" id="TipoDescOrca" value="<?php echo $_SESSION['Orcatrata']['TipoDescOrca'] ?>"/>
																	<?php } ?>
																</div>
																<?php if ($_SESSION['Orcatrata']['UsarCupom'] == "N" ) { ?>
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
																<?php }else{ ?>
																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="DescPercOrca">Perc. do Desconto</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">%</span>
																				<input type="text" class="form-control Valor" value="<?php echo $orcatrata['DescPercOrca'] ?>" readonly="">
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																			<label for="DescValorOrca">Valor do Desconto</label><br>
																			<div class="input-group" id="txtHint">
																				<span class="input-group-addon" id="basic-addon1">R$</span>
																				<input type="text" class="form-control Valor" value="<?php echo $orcatrata['DescValorOrca'] ?>" readonly="">
																			</div>
																		</div>	
																	</div>
																	<input type="hidden" class="form-control Valor" name="DescPercOrca" id="DescPercOrca" value="<?php echo $orcatrata['DescPercOrca'] ?>"/>
																	<input type="hidden" class="form-control Valor" name="DescValorOrca" id="DescValorOrca" value="<?php echo $orcatrata['DescValorOrca'] ?>"/>
																<?php } ?>
																<?php if(isset($_SESSION['Orcatrata']['NivelOrca']) && $_SESSION['Orcatrata']['NivelOrca'] == 1) { ?>
																	<?php if ($_SESSION['Orcatrata']['UsarCupom'] == "N" ) { ?>
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
																						<span class="input-group-addon" id="basic-addon1">N�</span>
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
																		</div>
																		<input type="hidden" id="CodigoCupom" name="CodigoCupom" value="<?php echo $cadastrar['CodigoCupom'];?>"/>
																		<input type="hidden" id="MensagemCupom" name="MensagemCupom" value="<?php echo $cadastrar['MensagemCupom'];?>"/>	
																	<?php }else{ ?>
																		<div class="row">
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6  text-left">
																				<label for="UsarCupom">Usar Cupom?</label><br>
																				<input type="text" class="form-control" readonly="" value="Sim"/>
																			</div>
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6  text-left">
																				<label for="Cupom">Cupom</label><br>
																				<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Orcatrata']['Cupom']; ?>"/>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																				<h3 class="modal-title text-center" id="Hidden_MensagemCupom"><?php echo $_SESSION['Campanha']['Campanha']; ?></h3>
																			</div>
																		</div>
																		<input type="hidden" id="UsarCupom" name="UsarCupom" value="<?php echo $orcatrata['UsarCupom'];?>"/>
																		<input type="hidden" id="Cupom" name="Cupom" value="<?php echo $orcatrata['Cupom'];?>"/>
																	<?php } ?>
																<?php }else{ ?>
																	<input type="hidden" name="UsarCupom" id="UsarCupom" value="<?php echo $_SESSION['Orcatrata']['UsarCupom'];?>"/>
																<?php } ?>
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
																		<?php 
																			if($_SESSION['Orcatrata']['UsarCashBack'] == "S"){
																				$UsarCashBack = 'Sim';
																			}elseif($_SESSION['Orcatrata']['UsarCashBack'] == "N"){
																				$UsarCashBack = 'N�o';
																			}
																		?>
																		<input type="text" class="form-control" readonly="" value="<?php echo $UsarCashBack; ?>"/>
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
																		<label for="CashBackOrca">CashBack.</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input style="color: #FF0000"  type="text" class="form-control Valor" id="CashBackOrca" readonly=''
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
																			<label>Total das Outras <?php echo $Recorrencias_outras; ?> O.S.</label><br>
																			<div class="input-group">
																				<span class="input-group-addon">R$</span>
																				<input type="text" class="form-control Valor" id="Valor_C_Desc" name="Valor_C_Desc" value="<?php echo $soma_repet_n_pago ?>" readonly=''>
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
													<input type="hidden" name="CashBackOrca" id="CashBackOrca" value="<?php echo $orcatrata['CashBackOrca'] ?>"/>
													<input type="text" class="form-control Valor" name="SubValorFinal" id="SubValorFinal" value="<?php echo $orcatrata['SubValorFinal'] ?>" readonly=''/>
													<input type="text" class="form-control Valor" name="CashBackOrca" id="CashBackOrca" value="<?php echo $orcatrata['CashBackOrca'] ?>" readonly=''/>
													<input type="text" class="form-control Valor" name="ValorFinalOrca" id="ValorFinalOrca" value="<?php echo $orcatrata['ValorFinalOrca'] ?>" readonly=''/>
												<?php } ?>
												<input type="hidden" name="UsarCashBack" id="UsarCashBack" value="<?php echo $_SESSION['Orcatrata']['UsarCashBack']; ?>"/>
												<input type="hidden" id="Hidden_UsarCashBack" value="<?php echo $orcatrata['UsarCashBack'] ?>">		
											</div>
											<br>
											<div class="row">
												<div class="col-sm-4 col-md-4 col-lg-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">	
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="Descricao">Obs/Descri��o:</label>
																	<textarea class="form-control" id="Descricao" <?php echo $readonly; ?> 
																	placeholder="Observa�oes:" name="Descricao" value="<?php echo $orcatrata['Descricao']; ?>"><?php echo $orcatrata['Descricao']; ?></textarea>
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
																	<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
																		data-toggle="collapse" onchange="exibirTroco(this.value),dateDiff()" <?php echo $readonly; ?>
																			data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																			id="FormaPagamento" name="FormaPagamento">
																		<option value="">-- Selecione uma op��o --</option>
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
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 ">
																	<label for="Modalidade">Dividido/ Mensal</label><br>
																	<?php 
																		if($orcatrata['Modalidade'] == "P") {
																			$modalidade = 'Dividido';
																		} elseif($orcatrata['Modalidade'] == "M"){
																			$modalidade = 'Mensal';
																		}else{
																			$modalidade = 'Mensal';
																		}
																	?>
																	<input type="text" class="form-control" value="<?php echo $modalidade; ?>" readonly=""/>
																</div>
																<input type="hidden" name="Modalidade" value="<?php echo $orcatrata['Modalidade'] ?>"/>	
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
											<!--
											<br>
											<div class="form-group">
												<div class="col-md-2 text-left">
													<button class="btn btn-danger" type="button" data-toggle="collapse" onclick="calculaParcelas()"
															data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
														<span class="glyphicon glyphicon-menu-down"></span> Gerar Parcelas
													</button>
												</div>
											</div>
											-->
											
											<div>
											
												<h4 class="mb-3"><b>Parcelas</b></h4>
														
												<?php echo form_error('ValorFinalOrca');?>
												
												<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>
												<div class="input_fields_wrap21">
														<?php
														for ($i=1; $i <= $count['PRCount']; $i++) {
														?>

															<?php if ($metodo > 1) { ?>
																<?php if (isset($parcelasrec[$i]['idApp_Parcelas'])) { ?>
																	<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
																<?php } ?>
															<?php } ?>
															
																<div class="form-group" id="21div<?php echo $i ?>">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-sm-3 col-md-2 col-lg-1">
																					<label for="Parcela">Prcl:<?php echo $i ?></label><br>
																					<input type="text" class="form-control" maxlength="6" 
																						   name="Parcela<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-2">
																					<label for="ValorParcela">Valor:</label><br>
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
																				<input type="hidden" name="DataLanc<?php echo $i ?>" id="DataLanc<?php echo $i ?>"  value="<?php echo $parcelasrec[$i]['DataLanc']; ?>"/>
																				<div class="col-sm-3 col-md-3 col-lg-2">
																					<label for="FormaPagamentoParcela<?php echo $i ?>">FormaPagParcela</label>
																					<?php if ($i == 1) { ?>
																					<?php } ?>
																					<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
																										echo 'N�o';
																									}else{
																										echo 'N�o';
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
																									<?php if ($_SESSION['Usuario']['Bx_Pag'] == "N") echo 'readonly=""' ?>
																								   name="DataPago<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataPago'] ?>">
																							
																						</div>
																					</div>
																				</div>
																				<!--
																				<div class="col-md-2">
																					<label for="idSis_Usuario<?php echo $i ?>">Cobrador:</label>
																					<?php if ($i == 1) { ?>
																					<?php } ?>
																					<select data-placeholder="Selecione uma op��o..." class="form-control"
																							 id="listadinamicac<?php echo $i ?>" name="idSis_Usuario<?php echo $i ?>">
																						<option value="">-- Sel.Profis. --</option>
																						<?php
																						/*
																						foreach ($select['idSis_Usuario'] as $key => $row) {
																							(!$parcelasrec['idSis_Usuario']) ? $parcelasrec['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario']: FALSE;
																							if ($parcelasrec[$i]['idSis_Usuario'] == $key) {
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
																				<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																					<div class="col-sm-1 col-md-1 col-lg-1">
																						<label><br></label><br>
																						<button type="button" id="<?php echo $i ?>" class="remove_field21 btn btn-danger">
																							<span class="glyphicon glyphicon-trash"></span>
																						</button>
																					</div>
																				<?php } ?>
																			</div>
																		</div>
																	</div>
																</div>
															
														<?php
														}
														?>
												</div>
												<div class="panel panel-warning">
													<div class="panel-heading text-left">
														<div class="row">
															<div class="col-md-3 text-left">
																<label></label>
																<button class="btn btn-warning" type="button" data-toggle="collapse" onclick="adicionaParcelas()"
																		data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
																	<span class="glyphicon glyphicon-plus"></span> Adic. Parcelas
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>	
										</div>
									</div>
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
										<br>
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
																<?php if (isset($procedimento[$i]['idApp_Procedimento'])) { ?>
																	<input type="hidden" name="idApp_Procedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['idApp_Procedimento']; ?>"/>
																<?php } ?>
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
																				<textarea class="form-control" id="Procedimento<?php echo $i ?>" <?php echo $readonly; ?> readonly=""
																						  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
																			</div>
																			<div class="col-sm-4 col-md-5 col-lg-4">
																				<label for="Compartilhar<?php echo $i ?>">Quem Fazer:</label>
																				<?php if ($i == 1) { ?>
																				<?php } ?>
																				<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
																						 id="listadinamica_comp<?php echo $i ?>" name="Compartilhar<?php echo $i ?>">
																					<option value="">-- Selecione uma op��o --</option>
																					<?php
																					foreach ($select[$i]['Compartilhar'] as $key => $row) {
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
																								echo 'N�o';
																							}else{
																								echo 'N�o';
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
																			<!--
																			<div class="col-sm-2 col-md-2 col-lg-1">
																				<label><br></label><br>
																				<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																					<span class="glyphicon glyphicon-trash"></span>
																				</button>
																			</div>
																			-->
																		</div>
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
													<div id="CanceladoOrca" <?php echo $div['CanceladoOrca']; ?>>	
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
																								echo 'N�o';
																							}else{
																								echo 'N�o';
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
																							<span class="glyphicon glyphicon-alert"></span> Aten��o!! + <?php echo $vinculadas; ?> O.S. vinculada(s) a esta. Todas os Produtos, de todas as O.S., receber�o o status de: "Entregue"="Sim".
																							Aten��o!! <strong><?php echo $Recorrencias; ?></strong> O.S.<br>"Entregue"="Sim"
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
																								echo 'N�o';
																							}else{
																								echo 'N�o';
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
																							<span class="glyphicon glyphicon-alert"></span> Aten��o!! + <?php #echo $vinculadas; ?> O.S. Vinculada(s) a esta. Todas as parcelas, de todas as O.S., receber�o o status de: "Parc.Paga"="Sim".
																							 Aten��o!! <strong><?php echo $Recorrencias; ?></strong> O.S.<br>"Pago"="Sim"
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
																							echo 'N�o';
																						}else{
																							echo 'N�o';
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
												</div>
												<!--
												<div class="form-group ">
													<div class="row">
														<div class="col-md-4">
															<div id="ConcluidoOrca" <?php echo $div['ConcluidoOrca']; ?>>	
																<label for="DataConclusao">Conclu�do em:</label>
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
											<input type="hidden" name="idApp_OrcaTrata" id="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
											<input type="hidden" name="Tipo_Orca"  id="Tipo_Orca" value="<?php echo $orcatrata['Tipo_Orca']; ?>">
											<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<h4 class="mb-3"><b>Pedido</b></h4>
											<div class="row">
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">	
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<label for="Consideracoes">Informa��es Gerais</label>
																	<textarea class="form-control" id="Consideracoes" <?php echo $readonly; ?> 
																	placeholder="Descri��o:" name="Consideracoes" value="<?php echo $orcatrata['Consideracoes']; ?>" rows="4"><?php echo $orcatrata['Consideracoes']; ?></textarea>
																</div>
															</div>	
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-12 text-left">
																	<label for="CanceladoOrca">Cancelado?</label><br>
																	<div class="btn-larg-right btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['CanceladoOrca'] as $key => $row) {
																			if (!$orcatrata['CanceladoOrca'])$orcatrata['CanceladoOrca'] = 'N';

																			($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($orcatrata['CanceladoOrca'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="CanceladoOrca_' . $hideshow . '">'
																				. '<input type="radio" name="CanceladoOrca" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="CanceladoOrca_' . $hideshow . '">'
																				. '<input type="radio" name="CanceladoOrca" id="' . $hideshow . '" '
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
																<div class="col-md-12">
																	<label for="ObsOrca"></label>
																	<textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?> placeholder="Motivo:"
																			  name="ObsOrca" value="<?php echo $orcatrata['ObsOrca']; ?>" rows="1"><?php echo $orcatrata['ObsOrca']; ?></textarea>
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
														<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
															<?php if($_SESSION['log']['idSis_Empresa'] != 5){?>
																<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
																	<label for="Whatsapp">
																		Enviar <svg enable-background="new 0 0 512 512" width="15" height="15" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
																	</label>
																	<br>
																	<div class="btn-larg-right btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['Whatsapp'] as $key => $row) {
																			if (!$cadastrar['Whatsapp']) $cadastrar['Whatsapp'] = 'S';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																			if ($cadastrar['Whatsapp'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="Whatsapp_' . $hideshow . '">'
																				. '<input type="radio" name="Whatsapp" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="Whatsapp_' . $hideshow . '">'
																				. '<input type="radio" name="Whatsapp" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		?>
																	</div>
																</div>
																<div id="Whatsapp" <?php echo $div['Whatsapp']; ?>>
																	<!--
																	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
																		<label for="Whatsapp_Site">Enviar C/Site</label>
																		<br>
																		<div class="btn-larg-right btn-group" data-toggle="buttons">
																			<?php
																			/*
																			foreach ($select['Whatsapp_Site'] as $key => $row) {
																				if (!$cadastrar['Whatsapp_Site']) $cadastrar['Whatsapp_Site'] = 'N';
																				($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																				if ($cadastrar['Whatsapp_Site'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="Whatsapp_Site_' . $hideshow . '">'
																					. '<input type="radio" name="Whatsapp_Site" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="Whatsapp_Site_' . $hideshow . '">'
																					. '<input type="radio" name="Whatsapp_Site" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			*/
																			?>
																		</div>
																	</div>
																	-->
																</div>
															<?php } ?>
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
																<label ></label>
																<div class="btn-group">
																	<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>
																		<span class="input-group-btn">
																			<button  type="button" class="btn btn-lg btn-danger" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																				<span class="glyphicon glyphicon-trash"></span>Exc
																			</button>
																		</span>
																	<?php } ?>
																	<span class="input-group-btn">
																		<a class="btn btn-lg btn-info " name="submeter5" id="submeter5" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
																			<span class="glyphicon glyphicon-print"></span>										
																		</a>
																	</span>	
																	<span class="input-group-btn">
																		<!--
																		<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																			<span class="glyphicon glyphicon-save"></span> Salvar
																		</button>
																		-->
																		<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																			<span class="glyphicon glyphicon-save"></span>Save
																		</button>
																	</span>	
																	<div class="alert alert-warning aguardar" role="alert" >
																		Aguarde um instante! Estamos processando sua solicita��o!
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
																			<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
																				Esta opera��o � irrevers�vel.</p>
																		</div>
																		<div class="modal-footer">
																			<div class="col-md-6 text-left">
																				<button type="button" class="btn btn-warning" name="submeter4" id="submeter4" onclick="DesabilitaBotaoExcluir()" data-dismiss="modal">
																					<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																				</button>
																			</div>
																			<?php if ($_SESSION['Usuario']['Delet_Orcam'] == "S" ) { ?>
																				<?php if ($count_orca == 0 ) { ?>	
																					<div class="col-md-6 text-right">
																						<a class="btn btn-danger" name="submeter3" id="submeter3" onclick="DesabilitaBotaoExcluir(this.name)" href="<?php echo base_url() . 'orcatrata/excluir/' . $orcatrata['idApp_OrcaTrata'] ?>" role="button">
																							<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
																						</a>
																					</div>
																				<?php }else{ ?>	
																					<div class="col-md-6 text-left">
																						<span class="glyphicon glyphicon-alert" name="submeter3" id="submeter3" ></span> Aten��o! <br>Este Or�amento est� vinculado a um agendamento e n�o pode ser apagado por aqui!
																					</div>
																				<?php } ?>	
																			<?php } ?>	
																		</div>
																	</div>
																</div>
															</div>
														</div>
													<?php } else { ?>
														<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
															<div class="row">
																<?php if($_SESSION['log']['idSis_Empresa'] != 5){?>
																	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
																		<label for="Whatsapp">
																			Enviar <svg enable-background="new 0 0 512 512" width="15" height="15" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
																		</label>
																		<br>
																		<div class="btn-larg-right btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Whatsapp'] as $key => $row) {
																				if (!$cadastrar['Whatsapp']) $cadastrar['Whatsapp'] = 'S';
																				($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																				if ($cadastrar['Whatsapp'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="Whatsapp_' . $hideshow . '">'
																					. '<input type="radio" name="Whatsapp" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="Whatsapp_' . $hideshow . '">'
																					. '<input type="radio" name="Whatsapp" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																	<div id="Whatsapp" <?php echo $div['Whatsapp']; ?>>
																		<!--
																		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
																			<label for="Whatsapp_Site">Enviar C/Site</label>
																			<br>
																			<div class="btn-larg-right btn-group" data-toggle="buttons">
																				<?php
																				/*
																				foreach ($select['Whatsapp_Site'] as $key => $row) {
																					if (!$cadastrar['Whatsapp_Site']) $cadastrar['Whatsapp_Site'] = 'N';
																					($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																					if ($cadastrar['Whatsapp_Site'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="Whatsapp_Site_' . $hideshow . '">'
																						. '<input type="radio" name="Whatsapp_Site" id="' . $hideshow . '" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="Whatsapp_Site_' . $hideshow . '">'
																						. '<input type="radio" name="Whatsapp_Site" id="' . $hideshow . '" '
																						. 'autocomplete="off" value="' . $key . '" >' . $row
																						. '</label>'
																						;
																					}
																				}
																				*/
																				?>
																			</div>
																		</div>
																		-->
																	</div>
																<?php } ?>	
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
																	<br>
																	<!--
																	<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																		<span class="glyphicon glyphicon-save"></span> Salvar
																	</button>
																	-->
																	<button type="submit" class="btn btn-lg btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)" data-loading-text="Aguarde..." value="1" >
																		<span class="glyphicon glyphicon-save"></span> Salvar
																	</button>
																	<div class="alert alert-warning aguardar" role="alert" >
																		Aguarde um instante! Estamos processando sua solicita��o!
																	</div>														
																</div>
															</div>	
														</div>
													<?php } ?>
												<?php } ?>
											</div>
										</div>
									</div>
									<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-success text-center">
													<h4 class="modal-title" id="visulClienteModalLabel">Cadastrado com sucesso!</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												</div>
												<!--
												<div class="modal-body">
													Cliente cadastrado com sucesso!
												</div>
												-->
												<div class="modal-footer">
													<div class="col-md-6">	
														<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
															<span class="glyphicon glyphicon-filter"></span> Fechar
														</button>
														<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
															Aguarde um instante! Estamos processando sua solicita��o!
														</div>
													</div>
													<!--<button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>-->
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

<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
	<div id="addClientePetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<span class="modal-title" id="addClientePetModalLabel"></span>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="msg-error-clientepet"></span>
					<form method="post" id="insert_clientepet_form">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label for="NomeClientePet">Nome do Pet: *</label>
									<input name="NomeClientePet" type="text" class="form-control" id="NomeClientePet" maxlength="255" placeholder="Nome do Pet">
								</div>
								<div class="col-md-3">
									<label for="DataNascimentoPet">Data de Nascimento:</label>
									<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoPet" placeholder="DD/MM/AAAA">
								</div>
								<div class="col-lg-3 ">
									<h4 class="mb-3">G�nero</h4>
									<div class="row">
										<div class="col-md-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoPet" class="custom-control-input "  id="Retirada" value="M" checked>
												<label class="custom-control-label" for="Masculino">MACHO</label>
											</div>
										</div>
										<div class="col-md-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoPet" class="custom-control-input " id="Combinar" value="F">
												<label class="custom-control-label" for="Feminino">F�MEA</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $orcatrata['idApp_Cliente']; ?>" >
							</div>
							<div class="row">
								<!--
								<div class="col-md-3">
									<label for="EspeciePet">Especie: *</label>
									<input name="EspeciePet" type="text" class="form-control" id="EspeciePet" maxlength="45" placeholder="Especie do Pet">
								</div>
								-->
								<div class="col-md-3 text-left">
									<label for="EspeciePet">Especie:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control"
											id="EspeciePet" name="EspeciePet">
										<option value="">-- Selecione uma op��o --</option>
										<?php
										foreach ($select['EspeciePet'] as $key => $row) {
											if ($cadastrar['EspeciePet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="RacaPet">Raca:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
											id="RacaPet" name="RacaPet">
										<option value="">-- Selecione uma op��o --</option>
										<?php
										foreach ($select['RacaPet'] as $key => $row) {
											if ($cadastrar['RacaPet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<!--
								<div class="col-md-3">
									<label for="RacaPet">Raca: *</label>
									<input name="RacaPet" type="text" class="form-control" id="RacaPet" maxlength="45" placeholder="Raca do Pet">
								</div>
								-->
								<div class="col-md-3 text-left">
									<label for="PeloPet">Pelo?</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control"
											id="PeloPet" name="PeloPet">
										<option value="">-- Selecione uma op��o --</option>
										<?php
										foreach ($select['PeloPet'] as $key => $row) {
											if ($cadastrar['PeloPet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="CorPet">Cor: *</label>
									<input name="CorPet" type="text" class="form-control" id="CorPet" maxlength="45" placeholder="Cor do Pet">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-left">
									<label for="PortePet">Porte?</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control"
											id="PortePet" name="PortePet">
										<option value="">-- Selecione uma op��o --</option>
										<?php
										foreach ($select['PortePet'] as $key => $row) {
											if ($cadastrar['PortePet'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="PesoPet">Peso: </label>
									<div class="input-group">
										<input name="PesoPet" type="text" class="form-control ValorPeso" id="PesoPet" maxlength="10" placeholder="0,000">
										<span class="input-group-addon">kg</span>
									</div>
								</div>
								<div class="col-lg-3 ">
									<h4 class="mb-3">Al�rgico</h4>
									<div class="row">
										<div class="col-md-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="AlergicoPet" class="custom-control-input "  id="AlergicoPet_Nao" value="N" checked>
												<label class="custom-control-label" for="Nao">N�o</label>
											</div>
										</div>
										<div class="col-md-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="AlergicoPet" class="custom-control-input " id="AlergicoPet_Sim" value="S">
												<label class="custom-control-label" for="Sim">Sim</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 ">
									<h4 class="mb-3">Castrado</h4>
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="CastradoPet" class="custom-control-input "  id="CastradoPet_Nao" value="N" checked>
												<label class="custom-control-label" for="Nao">N�o</label>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="CastradoPet" class="custom-control-input " id="CastradoPet_Sim" value="S">
												<label class="custom-control-label" for="Sim">Sim</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<label for="ObsPet">Obs: *</label>
									<textarea name="ObsPet" type="text" class="form-control" id="ObsPet" maxlength="255" placeholder="Observacao"></textarea>
								</div>
								<div class="col-md-3 text-left">	
									<label >Raca</label><br>
									<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#addRacaPetModal">
										Cad./Edit
									</button>
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
								Aguarde um instante! Estamos processando sua solicita��o!
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="addRacaPetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRacaPetModalLabel">Cadastrar RacaPet</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="msg-error-racapet"></span>
					<form method="post" id="insert_racapet_form">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">RacaPet</label>
							<div class="col-sm-10">
								<input name="Novo_RacaPet" type="text" class="form-control" id="Novo_RacaPet" placeholder="RacaPet">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<br>
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharRacaPet" id="botaoFecharRacaPet">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>
							</div>	
							<div class="col-sm-6">
								<br>
								<button type="submit" class="btn btn-success btn-block" name="botaoCadRacaPet" id="botaoCadRacaPet" >
									<span class="glyphicon glyphicon-plus"></span> Cadastrar
								</button>
							</div>	
							<div class="col-md-12 alert alert-warning aguardarRacaPet" role="alert" >
								Aguarde um instante! Estamos processando sua solicita��o!
							</div>
						</div>
					</form>
					<?php if (isset($list3)) echo $list3; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="alterarRacaPet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarRacaPetLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="alterarRacaPetLabel">Raca</h4>
				</div>
				<div class="modal-body">
					<span id="msg-error-alterar-racapet"></span>
					<form method="post" id="alterar_racapet_form">
						<div class="form-group">
							<label for="Nome_RacaPet" class="control-label">Raca:</label>
							<input type="text" class="form-control" name="Nome_RacaPet" id="Nome_RacaPet">
						</div>
						<input type="hidden" name="id_RacaPet" id="id_RacaPet">
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" name="CancelarRacaPet" id="CancelarRacaPet" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-danger" name="AlterarRacaPet" id="AlterarRacaPet" >Alterar</button>	
							<div class="col-md-12 alert alert-warning aguardarAlterarRacaPet" role="alert" >
								Aguarde um instante! Estamos processando sua solicita��o!
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="excluirRacaPet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirRacaPetLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="excluirRacaPetLabel">Raca</h4>
				</div>
				<div class="modal-body">
					<span id="msg-error-excluir-racapet"></span>
					<form method="post" id="excluir_racapet_form">
						<div class="form-group">
							<label for="ExcluirRacaPet" class="control-label">Raca:</label>
							<input type="text" class="form-control" name="ExcluirRacaPet" id="ExcluirRacaPet" readonly="">
						</div>
						<input type="hidden" name="id_ExcluirRacaPet" id="id_ExcluirRacaPet">
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" name="CancelarExcluirRacaPet" id="CancelarExcluirRacaPet" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-danger" name="Excluirtributo" id="ExcluirRacaPet" >Apagar</button>	
							<div class="col-md-12 alert alert-warning aguardarExcluirRacaPet" role="alert" >
								Aguarde um instante! Estamos processando sua solicita��o!
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php }else{ ?>
	<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
		<div id="addClienteDepModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<span class="modal-title" id="addClienteDepModalLabel"></span>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span id="msg-error-clientedep"></span>
						<form method="post" id="insert_clientedep_form">
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="NomeClienteDep">Nome do Dependente: *</label>
										<input name="NomeClienteDep" type="text" class="form-control" id="NomeClienteDep" maxlength="255" placeholder="Nome do Dependente">
									</div>
									<div class="col-md-3">
										<label for="DataNascimentoDep">Data de Nascimento:</label>
										<input type="text" class="form-control Date" maxlength="10" name="DataNascimentoDep" placeholder="DD/MM/AAAA">
									</div>
									<div class="col-lg-3 ">
										<h4 class="mb-3">Sexo</h4>
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoDep" class="custom-control-input "  id="Retirada" value="M">
												<label class="custom-control-label" for="Masculino">Mas</label>
											</div>
										</div>
										<div class="col-md-4 mb-3 ">	
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoDep" class="custom-control-input " id="Combinar" value="F">
												<label class="custom-control-label" for="Feminino">Fem </label>
											</div>
										</div>
										<div class="col-md-4 mb-3 ">
											<div class="custom-control custom-radio">
												<input type="radio" name="SexoDep" class="custom-control-input " id="Correios" value="O" checked>
												<label class="custom-control-label" for="Outros">Outros</label>
											</div>
										</div>
									</div>
									<input type="hidden" name="id_Cliente" id="id_Cliente" value="<?php echo $orcatrata['idApp_Cliente']; ?>" >
								</div>
								<div class="row">					
									<div class="col-md-6">
										<label for="RelacaoDep">Rela��o</label>
										<select data-placeholder="Selecione uma op��o..." class="form-control"
												id="RelacaoDep" name="RelacaoDep">
											<option value="">-- Selecione uma Rela��o --</option>
											<?php
											foreach ($select['RelacaoDep'] as $key => $row) {
												if ($cadastrar['RelacaoDep'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>   
										</select>
										<?php echo form_error('RelacaoDep'); ?>           
									</div>
									<div class="col-md-6">
										<label for="ObsDep">Obs: *</label>
										<input name="ObsDep" type="text" class="form-control" id="ObsDep" maxlength="255" placeholder="Observacao">
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
									Aguarde um instante! Estamos processando sua solicita��o!
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } ?>
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