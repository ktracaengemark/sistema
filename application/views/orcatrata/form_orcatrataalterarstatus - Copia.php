<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php if ( !isset($evento) && isset($query) && $query['idApp_Cliente'] != 0 && ($_SESSION['log']['idSis_Empresa'] != 5 || $_SESSION['log']['idSis_Empresa'] == $orcatrata['idSis_Empresa'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
								<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
											</a>
										</a>
									</li>
								</ul>
							</div>
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?> 
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>" onclick="buscaEnderecoCliente(<?php echo $_SESSION['Cliente']['idApp_Cliente'];?>)">
														<span class="glyphicon glyphicon-plus" ></span> Novo Orçamento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
									<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
										<div class="btn-group">
											<a type="button" class="btn btn-md btn-warning " href="<?php echo base_url() . 'orcatrata/alterarstatus/' . $orcatrata['idApp_OrcaTrata']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar
											</a>
										</div>									
									</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<a type="button" class="btn btn-md btn-default " href="<?php echo base_url() . 'orcatrata/arquivos/' . $orcatrata['idApp_OrcaTrata']; ?>">
											<span class="glyphicon glyphicon-picture"></span> Arquivos
										</a>
									</div>									
								</li>	
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<a type="button" class="btn btn-md btn-default " href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Impressão
										</a>
									</div>									
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Campanha
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>
			<div class="row">
				<div class="col-md-12">			
					<?php #echo validation_errors(); ?>
					<?php echo form_open_multipart($form_open_path); ?>
					<div class="panel panel-<?php echo $panel; ?>">
						<div class="panel-heading">
							<h4 class="text-center"><b>Colaborador: <?php echo $_SESSION['Orcatrata']['Nome'] ?></b></h4>
							<div style="overflow: auto; height: auto; ">
								<div class="panel-group">
									<div class="panel panel-success">
										<div class="panel-heading">
											<input type="hidden" id="AtivoCashBack" value="<?php echo $AtivoCashBack; ?>"/>
											<input type="hidden" id="metodo" value="<?php echo $metodo; ?>"/>
											<input type="hidden" id="exibirExtraOrca" value="<?php echo $exibirExtraOrca; ?>" />
											<input type="hidden" id="exibirDescOrca" value="<?php echo $exibirDescOrca; ?>" />
											<input type="hidden" name="Negocio" id="Negocio" value="1"/>
											<input type="hidden" name="Empresa" id="Empresa" value="<?php echo $_SESSION['log']['idSis_Empresa']; ?>"/>
											<input type="hidden" name="NivelEmpresa" id="NivelEmpresa" value="<?php echo $_SESSION['log']['NivelEmpresa']; ?>"/>
											<div class="form-group">	
												<div class="row">
													<div class="col-md-4 ">
														<h4 class="mb-3">
																<b>Editar Status Receita</b> - Nº <?php echo $orcatrata['idApp_OrcaTrata'] ?> - 
																							<?php 
																								if($orcatrata['Tipo_Orca'] == "B"){
																									echo 'Balcão';
																								} elseif($orcatrata['Tipo_Orca'] == "O"){
																									echo 'OnLine';
																								}
																							?>
														</h4>
													</div>	
													<?php if (isset($_SESSION['Orcatrata']['RepeticaoCons']) && $_SESSION['Orcatrata']['RepeticaoCons'] != 0){ ?>	
														<div class="col-md-4 ">
															<label >Agendamento</label>
															<a class="btn btn-md btn-info btn-block"  name="submeter6" id="submeter6" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() ?>consulta/alterar/<?php echo $_SESSION['Orcatrata']['idApp_Cliente'];?>/<?php echo $_SESSION['Orcatrata']['RepeticaoCons'];?>" role="button">
																<span class="glyphicon glyphicon-pencil"></span> <?php echo $_SESSION['Orcatrata']['RepeticaoCons'];?>
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
													<div class="col-md-4">
														<input type="hidden" name="TipoFinanceiro" id="TipoFinanceiro" value="<?php echo $orcatrata['TipoFinanceiro']; ?>"/>
														<label for="TipoFinanceiro">Tipo de Receita</label>
														<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Orcatrata']['NomeTipoFinanceiro']; ?>"/>
													</div>
													<div class="col-md-4 text-left">
														<label for="DataOrca">Data do Pedido</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()" readonly=''
																	id="DataOrca" name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
														</div>
													</div>
													<div class="col-md-2 text-left"></div>
													<div class="col-md-2 text-left"></div>
												</div>
											</div>
											<div <?php echo $visivel; ?>>
												<?php if ($orcatrata['idApp_Cliente'] != 0) { ?>
													<div class="row">
														<div class="col-md-4">
															<label >Cliente</label>
															<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['Orcatrata']['NomeCliente']; ?>">
														</div>
														<?php if ($_SESSION['Empresa']['CadastrarPet'] == "S") { ?>
															<?php if (!empty($_SESSION['Orcatrata']['idApp_ClientePet']) && $_SESSION['Orcatrata']['idApp_ClientePet'] != 0) { ?>
																<div class="col-md-4">
																	<label >Pet</label>
																	<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['ClientePet']['NomeClientePet']; ?>">
																	<span class="modal-title" id="Pet"></span>
																</div>
															<?php } ?>
															<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $orcatrata['idApp_ClientePet']; ?>" />
														<?php }else{ ?>	
															<?php if ($_SESSION['Empresa']['CadastrarDep'] == "S") { ?>
																<?php if (!empty($_SESSION['Orcatrata']['idApp_ClienteDep']) && $_SESSION['Orcatrata']['idApp_ClienteDep'] != 0) { ?>
																	<div class="col-md-4">
																		<label >Dependente</label>
																		<input class="form-control"<?php echo $readonly; ?> readonly="" value="<?php echo $_SESSION['ClienteDep']['NomeClienteDep']; ?>">
																		<span class="modal-title" id="Dep"></span>
																	</div>
																<?php } ?>
																<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $orcatrata['idApp_ClienteDep']; ?>" />
															<?php } ?>
														<?php } ?>
														<!--
														<div class="col-md-4">
															<h4 class="text-left"><b>Cliente</b>: <?php echo '' . $_SESSION['Orcatrata']['NomeCliente'] . '' ?> - <?php echo '' . $orcatrata['idApp_Cliente'] . '' ?></h4>
														</div>
														-->
													</div>
												<?php } ?>
											</div>
											<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 && ($count['PCount'] > 0 || $count['SCount'] > 0)) { ?>
												
													<h5 class="mb-3"><b>Produtos & Serviços</b></h5>
											
													<input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>

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
																	<div class="col-md-8">
																		<div class="row">
																			<input type="hidden" class="form-control " id="idTab_Valor_Produto<?php echo $i ?>" name="idTab_Valor_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Valor_Produto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Produtos_Produto<?php echo $i ?>" name="idTab_Produtos_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produtos_Produto'] ?>">
																			<input type="hidden" class="form-control " id="Prod_Serv_Produto<?php echo $i ?>" name="Prod_Serv_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['Prod_Serv_Produto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoProduto<?php echo $i ?>" name="ComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServicoProduto<?php echo $i ?>" name="ComissaoServicoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoCashBackProduto<?php echo $i ?>" name="ComissaoCashBackProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ComissaoCashBackProduto'] ?>">
																			<!--<input type="hidden" class="form-control " id="NomeProduto<?php echo $i ?>" name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">-->
																			<input type="hidden" class="form-control " name="idTab_Produto<?php echo $i ?>" value="<?php echo $produto[$i]['idTab_Produto'] ?>">
																			<div class="col-md-12">
																				<label for="NomeProduto">Produto <?php echo $i ?></label>
																				<input type="text" class="form-control text-left"  readonly="" id="NomeProduto<?php echo $i ?>"
																					   name="NomeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['NomeProduto'] ?>">
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="QtdProduto">Qtd.Item</label>
																				<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto<?php echo $i ?>" placeholder="0"
																						name="QtdProduto<?php echo $i ?>" readonly="" value="<?php echo $produto[$i]['QtdProduto'] ?>">
																			</div>
																			<div class="col-md-2">
																				<label for="QtdIncrementoProduto">Qtd.na Embl</label>
																				<input type="text" class="form-control Numero" id="QtdIncrementoProduto<?php echo $i ?>" placeholder="0"
																					name="QtdIncrementoProduto<?php echo $i ?>" readonly="" value="<?php echo $produto[$i]['QtdIncrementoProduto'] ?>">
																			</div>
																			<input type="hidden" class="form-control " id="SubtotalComissaoProduto<?php echo $i ?>" name="SubtotalComissaoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="SubtotalComissaoServicoProduto<?php echo $i ?>" name="SubtotalComissaoServicoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="SubtotalComissaoCashBackProduto<?php echo $i ?>" name="SubtotalComissaoCashBackProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalComissaoCashBackProduto'] ?>">
																			<div class="col-md-2">
																				<label for="SubtotalQtdProduto">Sub.Qtd.Prod</label>
																				<input type="text" class="form-control Numero text-left" maxlength="10" readonly="" id="SubtotalQtdProduto<?php echo $i ?>"
																					   name="SubtotalQtdProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalQtdProduto'] ?>">
																			</div>
																			<div class="col-md-3">
																				<label for="ValorProduto">Valor da Embl</label>
																				<div class="input-group">
																					<span class="input-group-addon" id="basic-addon1">R$</span>
																					<input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																						name="ValorProduto<?php echo $i ?>" readonly="" value="<?php echo $produto[$i]['ValorProduto'] ?>">
																				</div>
																			</div>
																			<div class="col-md-3">
																				<label for="SubtotalProduto">Sub.Valor.Prod.</label>
																				<div class="input-group">
																					<span class="input-group-addon" id="basic-addon1">R$</span>
																					<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
																						   name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
																				</div>
																			</div>
																		</div>
																	</div>	
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-7">
																				<label for="ObsProduto">Obs</label>
																				<input type="text" class="form-control" readonly="" id="ObsProduto<?php echo $i ?>" maxlength="200" placeholder="Observacao"
																						name="ObsProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ObsProduto'] ?>"></input>
																			</div>
																			<div class="col-md-3">
																				<label for="PrazoProduto">Prazo</label>
																				<input type="text" class="form-control Numero" readonly="" maxlength="3" placeholder="0" id="PrazoProduto<?php echo $i ?>" name="PrazoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['PrazoProduto'] ?>">
																			</div>
																			<div class="col-md-1 text-left">
																				<label><br></label><br>
																				<button type="button" id="<?php echo $i ?>" class="btn btn-default">
																					<span class="glyphicon glyphicon-trash"></span>
																				</button>
																			</div>
																		</div>
																		<?php 
																			if($produto[$i]['ConcluidoProduto'] == "S") {
																				$concprd[$i] = 'Sim';
																				$readprd[$i] = 'readonly=""';
																				//echo 'Sim';
																			} elseif($produto[$i]['ConcluidoProduto'] == "N"){
																				$concprd[$i] = 'Não';
																				$readprd[$i] = '';
																				//echo 'Não';
																			}else{
																				$concprd[$i] = 'Não';
																				$readprd[$i] = '';
																				//echo 'Não';
																			}
																		?>
																		<div class="row">
																			<div class="col-md-6 text-left">
																				<label for="ConcluidoProduto">Entregue? </label><br>
																				<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S" && $produto[$i]['ConcluidoProduto'] == "N") { ?>
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
																					<input type="text" class="form-control" readonly="" value="<?php echo $concprd[$i]; ?>"/>
																				<?php } ?>
																			</div>
																		</div>
																		<div id="ConcluidoProduto<?php echo $i ?>" <?php echo $div['ConcluidoProduto' . $i]; ?>>
																			<div class="row">
																				<div class="col-md-6">
																					<label for="DataConcluidoProduto">Data Entregue</label>
																					<div class="input-group DatePicker">
																						<span class="input-group-addon" disabled>
																							<span class="glyphicon glyphicon-calendar"></span>
																						</span>
																						<input type="text" class="form-control Date" <?php echo $readprd[$i]; ?> id="DataConcluidoProduto<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																							   name="DataConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['DataConcluidoProduto'] ?>">
																					</div>
																				</div>	
																				<div class="col-md-6">
																					<label for="HoraConcluidoProduto">Hora Entregue:</label>
																					<div class="input-group <?php echo $timepicker; ?>">
																						<span class="input-group-addon">
																							<span class="glyphicon glyphicon-time"></span>
																						</span>
																						<input type="text" class="form-control Time" <?php echo $readprd[$i]; ?> maxlength="5"  placeholder="HH:MM"
																							   accept="" name="HoraConcluidoProduto<?php echo $i ?>" id="HoraConcluidoProduto<?php echo $i ?>" value="<?php echo $produto[$i]['HoraConcluidoProduto']; ?>">
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
													<input type="hidden" name="CountMax" id="CountMax" value="<?php echo $ProdutoSoma ?>">		
											
													<input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

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
																	<div class="col-md-8">
																		<div class="row">
																			<input type="hidden" class="form-control " id="idTab_Valor_Servico<?php echo $i ?>" name="idTab_Valor_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Valor_Produto'] ?>">
																			<input type="hidden" class="form-control " id="idTab_Produtos_Servico<?php echo $i ?>" name="idTab_Produtos_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produtos_Produto'] ?>">
																			<input type="hidden" class="form-control " id="Prod_Serv_Servico<?php echo $i ?>" name="Prod_Serv_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['Prod_Serv_Produto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServico<?php echo $i ?>" name="ComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoServicoServico<?php echo $i ?>" name="ComissaoServicoServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="ComissaoCashBackServico<?php echo $i ?>" name="ComissaoCashBackServico<?php echo $i ?>" value="<?php echo $servico[$i]['ComissaoCashBackProduto'] ?>">
																			<!--<input type="hidden" class="form-control " id="NomeServico<?php echo $i ?>" name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">-->
																			<input type="hidden" class="form-control " name="idTab_Servico<?php echo $i ?>" value="<?php echo $servico[$i]['idTab_Produto'] ?>">
																			
																			<div class="col-md-12">
																				<label for="NomeServico">Serviço <?php echo $i ?>:</label>
																				<input type="text" class="form-control " readonly="" id="NomeServico<?php echo $i ?>"
																					   name="NomeServico<?php echo $i ?>" value="<?php echo $servico[$i]['NomeProduto'] ?>">
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="QtdServico">Qtd</label>
																				<input type="text" class="form-control Numero" maxlength="10" id="QtdServico<?php echo $i ?>" placeholder="0"
																						 name="QtdServico<?php echo $i ?>" readonly="" value="<?php echo $servico[$i]['QtdProduto'] ?>">
																			</div>
																			<div class="col-md-2">
																				<label for="QtdIncrementoServico">Qtd.na Embl</label>
																				<input type="text" class="form-control Numero" id="QtdIncrementoServico<?php echo $i ?>" name="QtdIncrementoServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdIncrementoProduto'] ?>" readonly="">
																			</div>
																			<div class="col-md-2">
																				<label for="SubtotalQtdServico">Sub.Qtd.Serv</label>
																				<input type="text" class="form-control Numero" id="SubtotalQtdServico<?php echo $i ?>" name="SubtotalQtdServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalQtdProduto'] ?>" readonly="">
																			</div>
																			<input type="hidden" class="form-control " id="SubtotalComissaoServico<?php echo $i ?>" name="SubtotalComissaoServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoProduto'] ?>">
																			<input type="hidden" class="form-control " id="SubtotalComissaoServicoServico<?php echo $i ?>" name="SubtotalComissaoServicoServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoServicoProduto'] ?>">
																			<input type="hidden" class="form-control " id="SubtotalComissaoCashBackServico<?php echo $i ?>" name="SubtotalComissaoCashBackServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalComissaoCashBackProduto'] ?>">
																			<div class="col-md-3">
																				<label for="ValorServico">Valor do Serviço</label>
																				<div class="input-group">
																					<span class="input-group-addon" id="basic-addon1">R$</span>
																					<input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
																						name="ValorServico<?php echo $i ?>" readonly="" value="<?php echo $servico[$i]['ValorProduto'] ?>">
																				</div>
																			</div>
																			<div class="col-md-3">
																				<label for="SubtotalServico">Sub.Valor.Serv:</label>
																				<div class="input-group">
																					<span class="input-group-addon" id="basic-addon1">R$</span>
																					<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
																						   name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalProduto'] ?>">
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-3">
																				<label for="ProfissionalServico_1<?php echo $i ?>">Profissional 1</label>
																				<?php if ($i == 1) { ?>
																				<?php } ?>
																				<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																						 id="listadinamica_prof_1<?php echo $i ?>" name="ProfissionalServico_1<?php echo $i ?>">
																					<option value="">-- Sel.Profis. --</option>
																					<?php
																					foreach ($select['ProfissionalServico_1'] as $key => $row) {
																						//(!$servico['ProfissionalServico_1']) ? $servico['ProfissionalServico_1'] = $_SESSION['log']['ProfissionalServico_1']: FALSE;
																						if ($servico[$i]['ProfissionalProduto_1'] == $key) {
																							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																							echo '<option value="' . $key . '">' . $row . '</option>';
																						}
																					}
																					?>
																				</select>
																			</div>
																			<div class="col-md-3">
																				<label for="ProfissionalServico_2<?php echo $i ?>">Profissional 2</label>
																				<?php if ($i == 1) { ?>
																				<?php } ?>
																				<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																						 id="listadinamica_prof_2<?php echo $i ?>" name="ProfissionalServico_2<?php echo $i ?>">
																					<option value="">-- Sel.Profis. --</option>
																					<?php
																					foreach ($select['ProfissionalServico_2'] as $key => $row) {
																						//(!$servico['ProfissionalServico_2']) ? $servico['ProfissionalServico_2'] = $_SESSION['log']['ProfissionalServico_1']: FALSE;
																						if ($servico[$i]['ProfissionalProduto_2'] == $key) {
																							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																							echo '<option value="' . $key . '">' . $row . '</option>';
																						}
																					}
																					?>
																				</select>
																			</div>
																			<div class="col-md-3">
																				<label for="ProfissionalServico_3<?php echo $i ?>">Profissional 3</label>
																				<?php if ($i == 1) { ?>
																				<?php } ?>
																				<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																						 id="listadinamica_prof_3<?php echo $i ?>" name="ProfissionalServico_3<?php echo $i ?>">
																					<option value="">-- Sel.Profis. --</option>
																					<?php
																					foreach ($select['ProfissionalServico_3'] as $key => $row) {
																						//(!$servico['ProfissionalServico_3']) ? $servico['ProfissionalServico_3'] = $_SESSION['log']['ProfissionalServico_1']: FALSE;
																						if ($servico[$i]['ProfissionalProduto_3'] == $key) {
																							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																							echo '<option value="' . $key . '">' . $row . '</option>';
																						}
																					}
																					?>
																				</select>
																			</div>
																			<div class="col-md-3">
																				<label for="ProfissionalServico_4<?php echo $i ?>">Profissional 4</label>
																				<?php if ($i == 1) { ?>
																				<?php } ?>
																				<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																						 id="listadinamica_prof_4<?php echo $i ?>" name="ProfissionalServico_4<?php echo $i ?>">
																					<option value="">-- Sel.Profis. --</option>
																					<?php
																					foreach ($select['ProfissionalServico_4'] as $key => $row) {
																						//(!$servico['ProfissionalServico_3']) ? $servico['ProfissionalServico_4'] = $_SESSION['log']['ProfissionalServico_1']: FALSE;
																						if ($servico[$i]['ProfissionalProduto_4'] == $key) {
																							echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																						} else {
																							echo '<option value="' . $key . '">' . $row . '</option>';
																						}
																					}
																					?>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-7">
																				<label for="ObsServico">Obs</label>
																				<input type="text" class="form-control" maxlength="200" id="ObsServico<?php echo $i ?>" placeholder="Observacao" readonly=""
																						 name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsProduto'] ?>">
																			</div>
																			<div class="col-md-3">
																				<label for="PrazoServico">Prazo</label>
																				<input type="text" class="form-control Numero" maxlength="3" placeholder="0"  id="PrazoServico<?php echo $i ?>" readonly=""
																				name="PrazoServico<?php echo $i ?>" value="<?php echo $servico[$i]['PrazoProduto'] ?>">
																			</div>
																			<div class="col-md-1 text-left">
																				<label><br></label><br>
																				<button type="button" id="<?php echo $i ?>" class="btn btn-default">
																					<span class="glyphicon glyphicon-trash"></span>
																				</button>
																			</div>
																		</div>
																		<?php 
																			if($servico[$i]['ConcluidoProduto'] == "S") {
																				$concsrv[$i] = 'Sim';
																				$readsrv[$i] = 'readonly=""';
																				//echo 'Sim';
																			} elseif($servico[$i]['ConcluidoProduto'] == "N"){
																				$concsrv[$i] = 'Não';
																				$readsrv[$i] = '';
																				//echo 'Não';
																			}else{
																				$concsrv[$i] = 'Não';
																				$readsrv[$i] = '';
																				//echo 'Não';
																			}
																		?>
																		<div class="row">
																			<div class="col-md-6 text-left">
																				<label for="ConcluidoServico">Entregue? </label><br>
																				<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S" && $servico[$i]['ConcluidoProduto'] =="N") { ?>
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
																					<input type="text" class="form-control" readonly="" value="<?php echo $concsrv[$i]; ?>"/>
																				<?php } ?>
																			</div>
																		</div>
																		<div id="ConcluidoServico<?php echo $i ?>" <?php echo $div['ConcluidoServico' . $i]; ?>>
																			<div class="row">
																				<div class="col-md-6">
																					<label for="DataConcluidoServico">Data Entregue</label>
																					<div class="input-group DatePicker">
																						<span class="input-group-addon" disabled>
																							<span class="glyphicon glyphicon-calendar"></span>
																						</span>
																						<input type="text" class="form-control Date" <?php echo $readsrv[$i]; ?> id="DataConcluidoServico<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																							   name="DataConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['DataConcluidoProduto'] ?>">
																					</div>
																				</div>
																				<div class="col-md-6">
																					<label for="HoraConcluidoServico">Hora Entregue</label>
																					<div class="input-group <?php echo $timepicker; ?>">
																						<span class="input-group-addon">
																							<span class="glyphicon glyphicon-time"></span>
																						</span>
																						<input type="text" class="form-control Time" <?php echo $readsrv[$i]; ?> maxlength="5"  placeholder="HH:MM"
																							   accept="" name="HoraConcluidoServico<?php echo $i ?>" id="HoraConcluidoServico<?php echo $i ?>" value="<?php echo $servico[$i]['HoraConcluidoProduto']; ?>">
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
													
													<input type="hidden" name="CountMax2" id="CountMax2" value="<?php echo $ServicoSoma ?>">
													
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-4 text-left">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-md-4 text-left">
																					<b>Linhas: <span id="ProdutoSoma"><?php echo $ProdutoSoma; ?></span></b><br />
																				</div>
																				<!--
																				<div class="col-md-3 text-center">	
																					
																					<b>Produtos: <span id="QtdSoma"><?php echo $QtdSoma; ?></span></b>
																				</div>
																				-->
																			</div>
																			<br>
																			<div class="row">	
																				<div class="col-md-12">
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
																<div class="col-md-4 text-left">
																	<div class="panel panel-danger">
																		<div class="panel-heading">
																			<div class="row">
																				<div class="col-md-4 text-left">	
																					<b>Linhas: <span id="ServicoSoma"><?php echo $ServicoSoma ?></span></b><br />
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
																<input type="hidden" name="ValorComissao" id="ValorComissao" value="<?php echo $orcatrata['ValorComissao'] ?>">
															</div>
														</div>
													</div>
											<?php } ?>
										</div>
									</div>
									
									<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
									<br>
									<div class="panel panel-info">
										<div class="panel-heading">	
											<h4 class="mb-3"><b>Entrega</b></h4>
											<div class="row">
												<div class="col-md-8 text-left">
													<input type="hidden" name="TipoFrete" id="TipoFrete" value="<?php echo $orcatrata['TipoFrete']; ?>"/>
													<label for="TipoFrete">Local e Forma de Entrega</label>
													<?php 
														if($orcatrata['TipoFrete'] == 1){
															$tipofrete = 'Retirar na Loja';
														}elseif($orcatrata['TipoFrete'] == 2){
															$tipofrete = 'Casa / Moto Boy';
														}elseif($orcatrata['TipoFrete'] == 3){
															$tipofrete = 'Casa / Correios';
														}
													?>
													<input type="text" class="form-control" readonly="" value="<?php echo $tipofrete; ?>"/>
												</div>
												<input type="hidden" id="ValorTipoFrete" name="ValorTipoFrete" value="<?php echo $orcatrata['TipoFrete']; ?>">
												<div class="col-md-4 text-left">
													<input type="hidden" name="DetalhadaEntrega" id="DetalhadaEntrega" value="<?php echo $orcatrata['DetalhadaEntrega']; ?>"/>
													<label for="DetalhadaEntrega">Personalizada</label>
													<?php 
														if($orcatrata['DetalhadaEntrega'] == "S"){
															$detalhada = 'Sim';
														}elseif($orcatrata['DetalhadaEntrega'] == "N"){
															$detalhada = 'Não';
														}
													?>
													<input type="text" class="form-control" readonly="" value="<?php echo $detalhada; ?>"/>
												</div>
											</div>
											<br>
											<input type="hidden" id="Caminho" name="Caminho" value="<?php echo $caminho; ?>">
											<input type="hidden" id="TaxaEntrega" name="TaxaEntrega" value="<?php echo $_SESSION['Empresa']['TaxaEntrega'] ?>">
											<div id="TipoFrete" <?php echo $div['TipoFrete']; ?>>
											
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
													<div class="col-md-2 mb-3 ">	
														<!--<label >Buscar End.</label>
														
														<button class=" form-control btn btn-lg btn-success" type="button" onclick="Procuraendereco(), calculaTotal(), calculaParcelas()" >Buscar</button>-->
													</div>
													<div class="col-md-2 ">
														<label class="" for="Cep">Cep:</label>
														<input type="text" class="form-control " id="Cep" maxlength="8" <?php echo $readonly; ?>
															   name="Cep" readonly="" value="<?php echo $orcatrata['Cep']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="Logradouro">Endreço:</label>
														<input type="text" class="form-control " id="Logradouro" maxlength="100" <?php echo $readonly; ?>
															   name="Logradouro" readonly="" value="<?php echo $orcatrata['Logradouro']; ?>">
													</div>
													<div class="col-md-2 ">
														<label class="" for="Numero">Número:</label>
														<input type="text" class="form-control " id="Numero" maxlength="100" <?php echo $readonly; ?>
															   name="Numero" readonly="" value="<?php echo $orcatrata['Numero']; ?>">
													</div>
													<div class="col-md-2 ">
														<label class="" for="Complemento">Complemento:</label>
														<input type="text" class="form-control " id="Complemento" maxlength="100" <?php echo $readonly; ?>
															   name="Complemento" readonly="" value="<?php echo $orcatrata['Complemento']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="Bairro">Bairro:</label>
														<input type="text" class="form-control " id="Bairro" maxlength="100" <?php echo $readonly; ?>
															   name="Bairro" readonly="" value="<?php echo $orcatrata['Bairro']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="Cidade">Cidade:</label>
														<input type="text" class="form-control " id="Cidade" maxlength="100" <?php echo $readonly; ?>
															   name="Cidade" readonly="" value="<?php echo $orcatrata['Cidade']; ?>">
													</div>
													<div class="col-md-2 ">
														<label class="" for="Estado">Estado:</label>
														<input type="text" class="form-control " id="Estado" maxlength="2" <?php echo $readonly; ?>
															   name="Estado" readonly="" value="<?php echo $orcatrata['Estado']; ?>">
													</div>
													<div class="col-md-2 ">
														<label class="" for="Referencia">Referencia:</label>
														<textarea class="form-control " id="Referencia" <?php echo $readonly; ?>
																  name="Referencia" readonly=""><?php echo $orcatrata['Referencia']; ?>
														</textarea>
													</div>
												</div>	
												<div class="row ">
													<div class="col-md-8 text-left"></div>
													<div class="col-md-4 text-left">
														<input type="hidden" name="AtualizaEndereco" id="AtualizaEndereco" value="<?php echo $cadastrar['AtualizaEndereco']; ?>"/>
														<label for="AtualizaEndereco">Atualizar End.?</label>
														<?php 
															if($cadastrar['AtualizaEndereco'] == "S"){
																$atualizar = 'Sim';
															}elseif($cadastrar['AtualizaEndereco'] == "N"){
																$atualizar = 'Não';
															}
														?>
														<input type="text" class="form-control" readonly="" value="<?php echo $atualizar; ?>"/>
														<!--
														<label for="AtualizaEndereco">Atualizar End.?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															/*
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
															*/
															?>
														</div>
														-->
													</div>
												</div>
												<br>
											</div>
											<div id="DetalhadaEntrega" <?php echo $div['DetalhadaEntrega']; ?>>
												<div class="row">	
													<div class="col-md-4 ">
														<label class="" for="NomeRec">Nome Recebedor:</label>
														<input type="text" class="form-control " id="NomeRec" maxlength="100" <?php echo $readonly; ?>
															   name="NomeRec" readonly="" value="<?php echo $orcatrata['NomeRec']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="TelefoneRec">Telefone:</label>
														<input type="text" class="form-control Celular CelularVariavel" id="TelefoneRec" maxlength="11" <?php echo $readonly; ?>
															   name="TelefoneRec" placeholder="(XX)999999999" readonly="" value="<?php echo $orcatrata['TelefoneRec']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="ParentescoRec">Parentesco:</label>
														<input type="text" class="form-control " id="ParentescoRec" maxlength="100" <?php echo $readonly; ?>
															   name="ParentescoRec" readonly="" value="<?php echo $orcatrata['ParentescoRec']; ?>">
													</div>
												</div>	
												<div class="row">	
													<div class="col-md-4 ">
														<label class="" for="Aux1Entrega">Aux1:</label>
														<input type="text" class="form-control " id="Aux1Entrega" maxlength="100" <?php echo $readonly; ?>
															   name="Aux1Entrega" readonly="" value="<?php echo $orcatrata['Aux1Entrega']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="Aux2Entrega">Aux2:</label>
														<input type="text" class="form-control " id="Aux2Entrega" maxlength="100" <?php echo $readonly; ?>
															   name="Aux2Entrega" readonly="" value="<?php echo $orcatrata['Aux2Entrega']; ?>">
													</div>
													<div class="col-md-4 ">
														<label class="" for="ObsEntrega">Obs Entrega:</label>
														<textarea class="form-control " id="ObsEntrega" <?php echo $readonly; ?>
																  name="ObsEntrega" readonly=""><?php echo $orcatrata['ObsEntrega']; ?>
														</textarea>
													</div>
												</div>
												<br>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="row">
														<div class="col-md-12">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<div class="row">
																		<div class="col-md-6 mb-3">
																			<label for="PrazoProdServ">Prazo Loja</label>
																			<div  class="input-group" id="txtHint">
																				<input type="text" class="form-control " id="PrazoProdServ" maxlength="100" readonly=""
																					   name="PrazoProdServ" value="<?php echo $orcatrata['PrazoProdServ']; ?>">
																				<span class="input-group-addon" id="basic-addon1">Dias</span>	   
																			</div>
																		</div>
																		<span class="ResultadoPrecoPrazo "></span>
																		<div class="col-md-6 mb-3">
																			<label for="PrazoCorreios">Prazo Correios</label>
																			<div  class="input-group" id="txtHint">
																				<input type="text" class="form-control " id="PrazoCorreios" maxlength="100" readonly=""
																					name="PrazoCorreios" value="<?php echo $orcatrata['PrazoCorreios']; ?>">
																				<span class="input-group-addon" id="basic-addon1">Dias</span>   
																			</div>
																		</div>
																	</div>	
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-6 mb-3">
																	<label for="PrazoEntrega">Prazo Total</label>
																	<div  class="input-group" id="txtHint">
																		<input type="text" class="form-control " id="PrazoEntrega" maxlength="100" readonly=""
																			   name="PrazoEntrega" value="<?php echo $orcatrata['PrazoEntrega']; ?>">
																		<span class="input-group-addon" id="basic-addon1">Dias</span> 
																	</div>
																</div>
																<div class="col-md-6 mb-3">
																	<label for="DataEntregaOrca">Data da Entrega</label>
																	<div class="input-group <?php echo $datepicker; ?>">
																		<span class="input-group-addon" disabled>
																			<span class="glyphicon glyphicon-calendar"></span>
																		</span>
																		<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" onchange="dateDiff()" readonly=""
																				id="DataEntregaOrca" name="DataEntregaOrca" value="<?php echo $orcatrata['DataEntregaOrca']; ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">	
																<div class="col-md-6 mb-3">
																	<label for="HoraEntregaOrca">Hora da Entrega:</label>
																	<div class="input-group <?php echo $timepicker; ?>">
																		<span class="input-group-addon">
																			<span class="glyphicon glyphicon-time"></span>
																		</span>
																		<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM" readonly=""
																			   accept=""name="HoraEntregaOrca" value="<?php echo $orcatrata['HoraEntregaOrca']; ?>">
																	</div>
																</div>
																<div class="col-md-6">
																	<label for="ValorFrete">Taxa de Entrega:</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon " id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="ValorFrete" maxlength="10" placeholder="0,00" readonly=""
																			   name="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>">
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
										<input type="hidden" name="ValorFrete" id="ValorFrete" value="<?php echo $orcatrata['ValorFrete'] ?>"/>
									<?php } ?>																							
									<br>	
									<div class="panel panel-success">
										<div class="panel-heading">
											<h4 class="mb-3"><b>Pagamento</b></h4>
											<!-- soma dos produtos, serviços e total do orçamento-->
											<div class="row">
												<div class="col-md-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																	<div class="col-md-6">
																		<label for="ValorRestanteOrca">Prd + Srv :</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00" readonly=''
																				   name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
																		</div>
																	</div>
																	<div class="col-md-6">
																		<label for="ValorSomaOrca">Prd + Srv + Entrega:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorSomaOrca" maxlength="10" placeholder="0,00" readonly=''
																				   name="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>">
																		</div>
																	</div>
																<?php }else{ ?>
																	<input type="hidden" name="ValorSomaOrca" id="ValorSomaOrca" value="<?php echo $orcatrata['ValorSomaOrca'] ?>"/>
																	<input type="hidden" name="ValorRestanteOrca" id="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>"/>
																<?php } ?>
																<div class="col-md-12 text-left">
																	<input type="hidden" name="TipoExtraOrca" id="TipoExtraOrca" value="<?php echo $_SESSION['Orcatrata']['TipoExtraOrca']; ?>"/>
																	<label for="TipoExtraOrca">Tipo de Extra</label><br>
																	<?php 
																		if($_SESSION['Orcatrata']['TipoExtraOrca'] == "P"){
																			$TipoExtraOrca = 'Porcentagem';
																		}elseif($_SESSION['Orcatrata']['TipoExtraOrca'] == "V"){
																			$TipoExtraOrca = 'Valor';
																		}
																	?>
																	<input type="text" class="form-control" readonly="" value="<?php echo $TipoExtraOrca; ?>"/>
																</div>
																<input type="hidden" id="Hidden_TipoExtraOrca" value="<?php echo $_SESSION['Orcatrata']['TipoExtraOrca'] ?>">
															</div>	
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="panel panel-info">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-6">
																	<label for="PercExtraOrca">Percent. do Extra</label><br>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon" id="basic-addon1">%</span>
																		<input type="text" class="form-control Valor" id="PercExtraOrca" maxlength="10" placeholder="0,00"
																			   name="PercExtraOrca" value="<?php echo $orcatrata['PercExtraOrca'] ?>">
																	</div>
																</div>	
																<div class="col-md-6">
																	<label for="ValorExtraOrca">Valor do Extra:</label>
																	<div class="input-group" id="txtHint">
																		<span class="input-group-addon " id="basic-addon1">R$</span>
																		<input type="text" class="form-control Valor" id="ValorExtraOrca" maxlength="10" placeholder="0,00" 
																			   name="ValorExtraOrca" value="<?php echo $orcatrata['ValorExtraOrca'] ?>">
																	</div>
																</div>
															</div>	
															<div class="row">	
																<div class="col-md-12">
																	<label for="Descricao">Obs/Descrição:</label>
																	<textarea class="form-control" id="Descricao" <?php echo $readonly; ?> 
																	placeholder="Observaçoes:" name="Descricao" readonly="" value="<?php echo $orcatrata['Descricao']; ?>"><?php echo $orcatrata['Descricao']; ?></textarea>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																	<div class="col-md-12">
																		<label for="ValorTotalOrca">Total do Pedido:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorTotalOrca" maxlength="10" placeholder="0,00" readonly=''
																				   name="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>">
																		</div>
																	</div>
																<?php }else{ ?>
																	<input type="hidden" name="ValorTotalOrca" id="ValorTotalOrca" value="<?php echo $orcatrata['ValorTotalOrca'] ?>"/>
																<?php } ?>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<label for="FormaPagamento">Forma de Pagamento</label><br>
																		<?php 
																			if($orcatrata['FormaPagamento'] == 1) {
																				$FormaPagamento = 'CARTÃO CRÉDITO';
																			}elseif($orcatrata['FormaPagamento'] == 2){
																				$FormaPagamento = 'BOLETO PAGSEGURO';
																			}elseif($orcatrata['FormaPagamento'] == 3){
																				$FormaPagamento = 'DÉBITO AUT.';
																			}elseif($orcatrata['FormaPagamento'] == 7){
																				$FormaPagamento = 'DINHEIRO';
																			}elseif($orcatrata['FormaPagamento'] == 8){
																				$FormaPagamento = 'CHEQUE';
																			}elseif($orcatrata['FormaPagamento'] == 9){
																				$FormaPagamento = 'DEPÓSITO';
																			}elseif($orcatrata['FormaPagamento'] == 10){
																				$FormaPagamento = 'OUTROS';
																			}elseif($orcatrata['FormaPagamento'] == 11){
																				$FormaPagamento = 'BOLETO DA LOJA';
																			}
																		?>
																	<input type="text" class="form-control" value="<?php echo $FormaPagamento; ?>" readonly=""/>
																</div>
																<input type="hidden" name="FormaPagamento" id="FormaPagamento" value="<?php echo $orcatrata['FormaPagamento'] ?>"/>
															</div>
														</div>
													</div>	
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="row">
																<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																	<div class="col-md-12">
																		<label for="AVAP">Local do Pagamento</label><br>
																			<?php 
																				if($orcatrata['AVAP'] == "P") {
																					$AVAP = 'Na Casa';
																				} elseif($orcatrata['AVAP'] == "V"){
																					$AVAP = 'Na Loja';
																				}else{
																					$AVAP = 'On Line';
																				}
																			?>
																		<input type="text" class="form-control" value="<?php echo $AVAP; ?>" readonly=""/>
																	</div>
																	<input type="hidden" name="AVAP" value="<?php echo $orcatrata['AVAP'] ?>"/>
																<?php }else{ ?>
																	<input type="hidden" name="AVAP" id="AVAP" value="<?php echo $orcatrata['AVAP'] ?>"/>
																<?php } ?>
															</div>
															<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																<div class="row ">
																	<div class="col-md-12 text-left">
																		<input type="hidden" name="TipoDescOrca" id="TipoDescOrca" value="<?php echo $_SESSION['Orcatrata']['TipoDescOrca']; ?>"/>
																		<label for="TipoDescOrca">Tipo de Desconto</label><br>
																		<?php 
																			if($_SESSION['Orcatrata']['TipoDescOrca'] == "P"){
																				$TipoDescOrca = 'Porcentagem';
																			}elseif($_SESSION['Orcatrata']['TipoDescOrca'] == "V"){
																				$TipoDescOrca = 'Valor';
																			}
																		?>
																		<input type="text" class="form-control" readonly="" value="<?php echo $TipoDescOrca; ?>"/>
																	</div>
																	<input type="hidden" id="Hidden_TipoDescOrca" value="<?php echo $_SESSION['Orcatrata']['TipoDescOrca'] ?>">
																</div>
															<?php }else{ ?>
																<input type="hidden" name="TipoDescOrca" id="TipoDescOrca" value="<?php echo $orcatrata['TipoDescOrca'] ?>"/>
																<input type="hidden" id="Hidden_TipoDescOrca" value="<?php echo $orcatrata['TipoDescOrca'] ?>">
															<?php } ?>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="panel panel-danger">
														<div class="panel-heading">
															<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																<div class="row">
																	<div class="col-md-6">
																		<label for="DescPercOrca">Percent. do Desconto</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">%</span>
																			<input type="text" class="form-control Valor" id="DescPercOrca" maxlength="10" placeholder="0,00"
																				   name="DescPercOrca" value="<?php echo $orcatrata['DescPercOrca'] ?>">
																		</div>
																	</div>
																	<div class="col-md-6">
																		<label for="DescValorOrca">Valor do Desconto</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="DescValorOrca" maxlength="10" placeholder="0,00"
																				   name="DescValorOrca" value="<?php echo $orcatrata['DescValorOrca'] ?>">
																		</div>
																	</div>	
																</div>
																<div class="row">	
																	<div class="col-md-12 text-left">
																		<label>"Total com Desconto"</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="SubValorFinal" name="SubValorFinal" value="<?php echo $orcatrata['SubValorFinal'] ?>" readonly="">
																		</div>
																	</div>	
																</div>
																<div class="row">
																	<div class="col-md-6">
																		<label for="CashBackOrca">CashBack.</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="CashBackOrca" maxlength="10" placeholder="0,00" readonly=''
																				   name="CashBackOrca" value="<?php echo $orcatrata['CashBackOrca'] ?>">
																		</div>
																	</div>
																	<div class="col-md-6 text-left">
																		<input type="hidden" name="UsarCashBack" id="UsarCashBack" value="<?php echo $_SESSION['Orcatrata']['UsarCashBack']; ?>"/>
																		<label for="UsarCashBack">Usar CashBack?</label><br>
																		<?php 
																			if($_SESSION['Orcatrata']['UsarCashBack'] == "S"){
																				$UsarCashBack = 'Sim';
																			}elseif($_SESSION['Orcatrata']['UsarCashBack'] == "N"){
																				$UsarCashBack = 'Não';
																			}
																		?>
																		<input type="text" class="form-control" readonly="" value="<?php echo $UsarCashBack; ?>"/>
																	</div>
																</div>
															<?php }else{ ?>
																<input type="hidden" name="UsarCashBack" id="UsarCashBack" value="<?php echo $orcatrata['UsarCashBack'] ?>"/>
																<input type="hidden" name="CashBackOrca" id="CashBackOrca" value="<?php echo $orcatrata['CashBackOrca'] ?>"/>
																<input type="hidden" name="DescValorOrca" id="DescValorOrca" value="<?php echo $orcatrata['DescValorOrca'] ?>"/>
																<input type="hidden" name="DescPercOrca" id="DescPercOrca" value="<?php echo $orcatrata['DescPercOrca'] ?>"/>
															<?php } ?>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="panel panel-default">
														<div class="panel-heading">
															<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																<div class="row">
																	<div class="col-md-12">
																		<label for="ValorFinalOrca">Valor Final:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorFinalOrca" maxlength="10" placeholder="0,00" readonly=''
																				   name="ValorFinalOrca" value="<?php echo $orcatrata['ValorFinalOrca'] ?>">
																		</div>
																	</div>
																</div>
															<?php }else{ ?>
																<input type="hidden" name="ValorFinalOrca" id="ValorFinalOrca" value="<?php echo $orcatrata['ValorFinalOrca'] ?>"/>
															<?php } ?>
															<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
																<div class="row Exibir_Troco">	
																	<div class="col-md-6">
																		<label for="ValorDinheiro">Troco para:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorDinheiro" maxlength="10" placeholder="0,00" readonly=""
																				   name="ValorDinheiro" value="<?php echo $orcatrata['ValorDinheiro'] ?>">
																		</div>
																	</div>	
																	<div class="col-md-6">
																		<label for="ValorTroco">Valor do Troco:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" id="ValorTroco" maxlength="10" placeholder="0,00" readonly=""
																				   name="ValorTroco" value="<?php echo $orcatrata['ValorTroco'] ?>">
																		</div>
																	</div>
																</div>
															<?php }else{ ?>
																<input type="hidden" name="ValorDinheiro" id="ValorDinheiro" value="<?php echo $orcatrata['ValorDinheiro'] ?>"/>
																<input type="hidden" name="ValorTroco" id="ValorTroco" value="<?php echo $orcatrata['ValorTroco'] ?>"/>
															<?php } ?>
															<div class="row">
																<div class="col-md-12">
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
															</div>
														</div>
													</div>
												</div>
											</div>
											<div>
												<!--App_parcelasRec-->
												<br>
												<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>
												
												<?php
												for ($i=1; $i <= $count['PRCount']; $i++) {
												?>

													<?php if ($metodo > 1) { ?>
													<input type="hidden" name="idApp_Parcelas<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_Parcelas']; ?>"/>
													<?php } ?>

													<div class="form-group" id="21div<?php echo $i ?>">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-1">
																		<label for="Parcela">Prcl:<?php echo $i ?></label><br>
																		<input type="text" class="form-control" maxlength="6" 
																			   name="Parcela<?php echo $i ?>" readonly="" value="<?php echo $parcelasrec[$i]['Parcela'] ?>">
																	</div>
																	<div class="col-md-2">
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
																	<div class="col-md-2">
																		<label for="ValorParcela">Valor:</label><br>
																		<div class="input-group" id="txtHint">
																			<span class="input-group-addon" id="basic-addon1">R$</span>
																			<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcela<?php echo $i ?>"
																				   name="ValorParcela<?php echo $i ?>" readonly="" value="<?php echo $parcelasrec[$i]['ValorParcela'] ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="DataVencimento">Vencimento</label>
																		<div class="input-group DatePicker">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" id="DataVencimento<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																				   name="DataVencimento<?php echo $i ?>" readonly="" value="<?php echo $parcelasrec[$i]['DataVencimento'] ?>">																
																		</div>
																	</div>
																	<?php 
																		if($parcelasrec[$i]['Quitado'] == "S") {
																			$concparc[$i] = 'Sim';
																			$readparc[$i] = 'readonly=""';
																			//echo 'Sim';
																		} elseif($parcelasrec[$i]['Quitado'] == "N"){
																			$concparc[$i] = 'Não';
																			$readparc[$i] = '';
																			//echo 'Não';
																		}else{
																			$concparc[$i] = 'Não';
																			$readparc[$i] = '';
																			//echo 'Não';
																		}
																	?>
																	<div class="col-md-2">
																		<label for="Quitado">Parc. Paga?</label><br>
																		<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S" && $parcelasrec[$i]['Quitado'] == "N") { ?>
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
																			<input type="text" class="form-control" readonly="" value="<?php echo $concparc[$i]; ?>"/>
																		<?php } ?>
																	</div>
																	<div class="col-md-2">
																		<div id="Quitado<?php echo $i ?>" <?php echo $div['Quitado' . $i]; ?>>
																			<label for="DataPago">Pagamento</label>
																			<div class="input-group DatePicker">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date"  <?php echo $readparc[$i] ?> id="DataPago<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA" 
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
													<input type="hidden" name="idApp_Procedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['idApp_Procedimento']; ?>"/>
													<?php } ?>

													<div class="form-group" id="3div<?php echo $i ?>">
														<div class="panel panel-success">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-4">
																		<input type="hidden" name="idSis_Usuario<?php echo $i ?>" id="idSis_Usuario<?php echo $i ?>" value="<?php echo $procedimento[$i]['idSis_Usuario'] ?>"/>
																		<label for="Procedimento<?php echo $i ?>">
																			Proced. <?php echo $i ?>: 
																			<?php if ($procedimento[$i]['idSis_Usuario']) { ?>
																				<?php echo $_SESSION['Procedimento'][$i]['Nome'];?>
																			<?php } ?>
																		</label>
																		<textarea class="form-control" id="Procedimento<?php echo $i ?>" readonly="" <?php echo $readonly; ?>
																				  name="Procedimento<?php echo $i ?>"><?php echo $procedimento[$i]['Procedimento']; ?></textarea>
																	</div>
																	<div class="col-md-4">
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
																</div>
																<div class="row">
																	<div class="col-md-2">
																		<label for="DataProcedimento<?php echo $i ?>">Data do Proced.:</label>
																		<div class="input-group <?php echo $datepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-calendar"></span>
																			</span>
																			<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" 
																				   name="DataProcedimento<?php echo $i ?>" id="DataProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataProcedimento']; ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label for="HoraProcedimento<?php echo $i ?>">Hora Concl</label>
																		<div class="input-group <?php echo $timepicker; ?>">
																			<span class="input-group-addon" disabled>
																				<span class="glyphicon glyphicon-time"></span>
																			</span>
																			<input type="text" class="form-control Time" readonly="" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
																				   name="HoraProcedimento<?php echo $i ?>" id="HoraProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['HoraProcedimento']; ?>">
																		</div>
																	</div>
																	<?php 
																		if($procedimento[$i]['ConcluidoProcedimento'] == "S") {
																			$concproc[$i] = 'Sim';
																			$readproc[$i] = 'readonly=""';
																			//echo 'Sim';
																		} elseif($procedimento[$i]['ConcluidoProcedimento'] == "N"){
																			$concproc[$i] = 'Não';
																			$readproc[$i] = 'readonly=""';
																			//echo 'Não';
																		}else{
																			$concproc[$i] = 'Não';
																			$readproc[$i] = 'readonly=""';
																			//echo 'Não';
																		}
																	?>
																	<div class="col-md-2 text-left">
																		<label for="ConcluidoProcedimento">Concluido? </label><br>
																		<?php if ($_SESSION['Usuario']['Bx_Prc'] == "S" && $procedimento[$i]['ConcluidoProcedimento'] == "N") { ?>
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
																			<input type="text" class="form-control" readonly="" value="<?php echo $concproc[$i]; ?>"/>
																		<?php } ?>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div id="ConcluidoProcedimento<?php echo $i ?>" <?php echo $div['ConcluidoProcedimento' . $i]; ?>>
																				<div class="col-md-6">
																					<label for="DataConcluidoProcedimento<?php echo $i ?>">Data Concl</label>
																					<div class="input-group <?php echo $datepicker; ?>">
																						<span class="input-group-addon" disabled>
																							<span class="glyphicon glyphicon-calendar"></span>
																						</span>
																						<input type="text" class="form-control Date" readonly="" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																							   name="DataConcluidoProcedimento<?php echo $i ?>" id="DataConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['DataConcluidoProcedimento']; ?>">
																					</div>
																				</div>
																				<div class="col-md-6">
																					<label for="HoraConcluidoProcedimento<?php echo $i ?>">Hora Concl.</label>
																					<div class="input-group <?php echo $timepicker; ?>">
																						<span class="input-group-addon" disabled>
																							<span class="glyphicon glyphicon-time"></span>
																						</span>
																						<input type="text" class="form-control Time" readonly="" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
																							   name="HoraConcluidoProcedimento<?php echo $i ?>" id="HoraConcluidoProcedimento<?php echo $i ?>" value="<?php echo $procedimento[$i]['HoraConcluidoProcedimento']; ?>">
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<!--
																	<div class="col-md-1">
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
											<div id="CanceladoOrca" <?php echo $div['CanceladoOrca']; ?>>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="mb-3"><b>Status do Pedido</b></h4>
														<div class="row">
															<div class="col-md-3">
																<?php
																	if($_SESSION['Orcatrata']['FinalizadoOrca'] == "S"){
																		$cor = 'primary';
																	}else{
																		$cor = 'danger';
																	}
																?>
																<div class="panel panel-<?php echo $cor; ?>">
																	<div class="panel-heading">
																		<div class="row">
																			<div class="col-md-12 text-left">
																				<label for="CombinadoFrete">Tudo Informado?</label><br>
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['CombinadoFrete'] as $key => $row) {
																						if (!$orcatrata['CombinadoFrete'])$orcatrata['CombinadoFrete'] = 'S';

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
																			<div class="col-md-12 text-right">
																				<label for="FinalizadoOrca">Finalizado?</label><br>
																				<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S" && $_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																					<div class="btn-group" data-toggle="buttons">
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
																	</div>
																</div>
															</div>
															<div id="FinalizadoOrca" <?php echo $div['FinalizadoOrca']; ?>>
																<div id="CombinadoFrete" <?php echo $div['CombinadoFrete']; ?>>
																	<div class="col-md-3">
																		<?php
																			if($_SESSION['Orcatrata']['AprovadoOrca'] == "S"){
																				$cor2 = 'info';
																			}else{
																				$cor2 = 'warning';
																			}
																		?>
																		<div class="panel panel-<?php echo $cor2; ?>">
																			<div class="panel-heading">
																				<div class="row">
																					<div class="col-md-12 text-left">
																						<label for="AprovadoOrca">Aprovado?</label><br>
																						<div class="btn-group" data-toggle="buttons">
																							<?php
																							foreach ($select['AprovadoOrca'] as $key => $row) {
																								if (!$orcatrata['AprovadoOrca'])$orcatrata['AprovadoOrca'] = 'S';

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
																				<div class="row">
																					<div class="col-md-12 text-right">
																						<label for="ProntoOrca">Pronto pra Entrega?</label><br>
																						<div class="btn-group" data-toggle="buttons">
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
																			</div>
																		</div>
																	</div>
																	<div id="AprovadoOrca" <?php echo $div['AprovadoOrca']; ?>>
																		<div class="col-md-3">
																			<div id="ProntoOrca" <?php echo $div['ProntoOrca']; ?>>
																				<div class="panel panel-success">
																					<div class="panel-heading">
																						<div class="row">				
																							<div class="col-md-12 text-left">
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
																						</div>
																						<div class="row">
																							<div class="col-md-12 text-right">
																								<label for="EnviadoOrca">Enviado?</label><br>
																								<div class="btn-group" data-toggle="buttons">
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
																		<div class="col-md-3">
																			<div class="panel panel-warning">
																				<div class="panel-heading">																						
																					<div class="row">
																						<div class="col-md-6 text-left">
																							<label for="ConcluidoOrca">Prds Entregues?</label><br>
																							<?php if ($_SESSION['Usuario']['Bx_Prd'] == "S") { ?>
																								<div class="btn-group" data-toggle="buttons">
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
																							<div <?php echo $textoEntregues; ?>>
																								<div class="col-md-6 text-left">
																									<label for="StatusProdutos">Todas as OS?</label><br>
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
																								<div id="StatusProdutos" <?php echo $div['StatusProdutos']; ?>>
																									<div <?php echo $textoEntregues; ?> class="col-md-12">
																										<h4><span class="glyphicon glyphicon-alert"></span> Atenção!! + <?php echo $vinculadas; ?> Vinculada(s).<br>Todas os Produtos, de todas as O.S. vinculadas a esta, receberão o status de Entregue="Sim"!</h4>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="row">		
																						<div class="col-md-6 text-left">
																							<label for="QuitadoOrca">Parcelas Pagas?</label><br>
																							<?php if ($_SESSION['Usuario']['Bx_Pag'] == "S") { ?>
																								<div class="btn-group" data-toggle="buttons">
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
																								<div class="col-md-6 text-left">
																									<label for="StatusParcelas">Todas as OS?</label><br>
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
																								<div id="StatusParcelas" <?php echo $div['StatusParcelas']; ?>>
																									<div <?php echo $textoPagas; ?> class="col-md-12">
																										<h4><span class="glyphicon glyphicon-alert"></span> Atenção!! + <?php echo $vinculadas; ?> Vinculada(s).<br>Todas as parcelas, de todas as O.S. vinculadas a esta, receberão o status de Paga="Sim"!</h4>
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
											</div>
									<?php } ?>
									<div class="panel panel-default">
										<div class="panel-heading">
											<input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
											<input type="hidden" name="Tipo_Orca"  id="Tipo_Orca" value="<?php echo $orcatrata['Tipo_Orca']; ?>">
											<input type="hidden" name="Cadastrar" value="<?php echo $cadastrar['Cadastrar'] ?>">
											<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $orcatrata['idApp_Cliente'] ?>">
											<input type="hidden" name="idApp_ClientePet" id="idApp_ClientePet" value="<?php echo $orcatrata['idApp_ClientePet']; ?>" />
											<input type="hidden" name="idApp_ClienteDep" id="idApp_ClienteDep" value="<?php echo $orcatrata['idApp_ClienteDep']; ?>" />
											<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<input type="hidden" name="Modalidade" value="<?php echo $orcatrata['Modalidade'] ?>">
											<input type="hidden" name="BrindeOrca" value="<?php echo $orcatrata['BrindeOrca'] ?>">-->
											<h4 class="mb-3"><b>Pedido</b></h4>
											<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
												<div class="row">
													<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
													<div class="col-md-3">
														<div class="panel panel-default">
															<div class="panel-heading">
																<div class="row">
																	<div class="col-md-12 text-left">
																		<label for="CanceladoOrca">Cancelado?</label><br>
																		<div class="btn-group" data-toggle="buttons">
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
																	<div class="col-md-12">
																		<label for="ObsOrca"></label>
																		<textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?> placeholder="Motivo do Cancelamento:"
																				  name="ObsOrca"><?php echo $orcatrata['ObsOrca']; ?></textarea>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<?php } ?>
													<div class="col-md-6"></div>
													<div class="col-md-3 text-center">
														<?php if ($metodo > 1) { ?>
														<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
														<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
														<?php } ?>
														<?php if ($metodo == 2) { ?>
															<label >.</label><br>
															<div class="btn-block">
																<?php if ($_SESSION['Usuario']['Edit_Orcam'] == "S" ) { ?>
																	<span class="input-group-btn">	
																		<?php 
																			if($orcatrata['idApp_Cliente'] == 0 || $orcatrata['idApp_Cliente'] == 1 || $orcatrata['idApp_Cliente'] == 150001 || $_SESSION['log']['idSis_Empresa'] == 5) { 
																				$ref_alterar = 'alterar2';
																			
																			}else{
																				$ref_alterar = 'alterar';
																			}
																		?>
																		
																		<a class="btn btn-lg btn-warning" name="submeter5" id="submeter5" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'Orcatrata/' . $ref_alterar . '/' . $orcatrata['idApp_OrcaTrata']; ?>">
																			<span class="glyphicon glyphicon-edit"></span>Edit
																		</a>
																	</span>
																<?php } ?>
																<span class="input-group-btn">
																	<a class="btn btn-lg btn-info" name="submeter2" id="submeter2" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
																		<span class="glyphicon glyphicon-print"></span>										
																	</a>
																</span>
																<span class="input-group-btn">
																	<button type="submit" class="btn btn-lg btn-primary" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name)" data-loading-text="Aguarde..." value="1" >
																		<span class="glyphicon glyphicon-save"></span>Save
																	</button>
																</span>
															</div>	
															<div class="col-md-12 alert alert-warning aguardar" role="alert" >
																Aguarde um instante! Estamos processando sua solicitação!
															</div>
														<?php } else { ?>
															<div class="col-md-12 text-left">
																<label></label>
																<button type="submit" class="btn btn-lg btn-primary btn-block" name="submeter" id="submeter" onclick="DesabilitaBotao(this.name),calculaQtdSoma('QtdProduto','QtdSoma','ProdutoSoma',0,0,'CountMax',1,0)" data-loading-text="Aguarde..." value="1" >
																	<span class="glyphicon glyphicon-save"></span> Salvar
																</button>														
															</div>
														<?php } ?>
													</div>
												</div>
											<?php } ?>
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
