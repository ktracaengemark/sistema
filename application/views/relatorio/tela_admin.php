<?php if ($msg) echo $msg; ?>
<div class="col-md-12">
<?php echo validation_errors(); ?>
<?php echo form_open('relatorio/admin', 'role="form"'); ?>
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class=" text-center" style="color: #3CB371" data-toggle="collapse" data-target="#Tarefas" aria-expanded="false" aria-controls="Tarefas">
						 <h3 class="text-center"><b>Agenda & Tarefas</b></h3>
					</div>
					<div <?php echo $collapse1; ?> id="Tarefas">	
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<label for=""><h4><b>Agenda</b></h4></label>
									<div class="form-group col-md-12 text-left">
										<div class="row">
											<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>Agenda/agendamentos" role="button"> 
												<span class="glyphicon glyphicon-pencil"></span> Agendamentos
											</a>											
										</div>	
									</div>										
								</div>
								<div class="col-md-12">
									<label for=""><h4><b>Tarefas</b></h4></label>
									<div class="form-group col-md-12 text-left">
										<div class="row">
											<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
												<span class="glyphicon glyphicon-pencil"></span> Relatório
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
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="text-center" style="color: #00008B" data-toggle="collapse" data-target="#Receitas" aria-expanded="false" aria-controls="Receitas">
						<h3 class="text-center"><b>Receitas & Vendas<?php #echo $titulo2; ?></b></h3>
					</div>
					<div <?php echo $collapse1; ?> id="Receitas">
						<div class="panel-body">
							<div class="row">
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>	
									<?php if((isset($_SESSION['Usuario']['Rel_Orc']) && $_SESSION['Usuario']['Rel_Orc'] == "S")) {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Receitas</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>receitas_statico/pedidos" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Gestor de Receitas Estatico 
													</a>											
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>receitas/receitas" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Receitas
													</a>											
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php }else{ ?>
									<div class="col-md-12">											
										<label for=""><h4><b>Receitas</b></h4></label>
										<div class="form-group col-md-12 text-left">
											<div class="row">		
												<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>receitas_statico/pedidos" role="button"> 
													<span class="glyphicon glyphicon-pencil"></span> Gestor de Estatico
												</a>											
											</div>	
										</div>
										<div class="form-group col-md-12 text-left">
											<div class="row">		
												<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>receitas/receitas" role="button"> 
													<span class="glyphicon glyphicon-pencil"></span> Receitas
												</a>											
											</div>	
										</div>
									</div>
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
									<div class="col-md-12">	
										<label for=""><h4><b>Pagamentos</b></h4></label>
										<div class="form-group col-md-12 text-left">
											<div class="row">										
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>cobrancas/cobrancas" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Parcelas
												</a>
											</div>	
										</div>
										<div class="form-group col-md-12 text-left">
											<div class="row">		
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/balanco" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Balanço
												</a>
											</div>	
										</div>
									</div>	
								<?php }else{ ?>
									<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
										<div class="col-md-12">	
											<label for=""><h4><b>Pagamentos</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>cobrancas/cobrancas" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Parcelas
													</a>
												</div>	
											</div>	
											<?php if(isset($_SESSION['Usuario']['Rel_Est']) && $_SESSION['Usuario']['Rel_Est'] == "S") {?>		
												<div class="form-group col-md-12 text-left">
													<div class="row">		
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/balanco" role="button"> 
															<span class="glyphicon glyphicon-usd"></span> Balanço
														</a>
													</div>	
												</div>
											<?php }?>
										</div>	
									<?php } ?>
								<?php } ?>	
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
									<?php if($_SESSION['Usuario']['Rel_Prd'] == "S") {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Produtos & Serviços</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Vendidos/vendidos" role="button"> 
														<span class="glyphicon glyphicon-gift"></span> Vendidos
													</a>
												</div>	
											</div>
										</div>
									<?php }?>	
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>	
									<?php if($_SESSION['Usuario']['Rel_Prc'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Procedimentos</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Receitas/procedimentos" role="button">
														<span class="glyphicon glyphicon-pencil"></span> Procedimentos
													</a>
												</div>	
											</div>
										</div>
									<?php }?>	
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
									<div class="col-md-12">											
										<label for=""><h4><b>Comissões</b></h4></label>
										<?php /* if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Permissao_Comissao'] >= 2) {?>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/comissao_online" role="button"> 
														<span class="glyphicon glyphicon-usd"></span>Pedido x Associado
													</a>
												</div>	
											</div>
										<?php } */?>
									</div>
								<?php }else{ ?>
									<?php if($_SESSION['Usuario']['Rel_Com'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Comissões</b></h4></label>
											<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Comissao/comissao" role="button"> 
															<span class="glyphicon glyphicon-usd"></span>Pedido x Vendedor
														</a>
													</div>	
												</div>
												<?php if($_SESSION['Empresa']['EComerce'] == "S") {?>
													<div class="form-group col-md-12 text-left">
														<div class="row">										
															<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Comissao/comissaoass" role="button"> 
																<span class="glyphicon glyphicon-usd"></span>Pedido x Associado
															</a>
														</div>	
													</div>
													<?php if($_SESSION['Empresa']['Rede'] == "S") {?>
														<div class="form-group col-md-12 text-left">
															<div class="row">										
																<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Comissao/comissaofunc" role="button"> 
																	<span class="glyphicon glyphicon-usd"></span>Pedido x Supervisor
																</a>
															</div>	
														</div>
													<?php } ?>	
												<?php } ?>		
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Comissao/comissaoserv" role="button"> 
															<span class="glyphicon glyphicon-usd"></span>Comissao x Serviço
														</a>
													</div>	
												</div>
												<div class="form-group col-md-12 text-left">
													<div class="row">		
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Comissao/grupos" role="button"> 
															<span class="glyphicon glyphicon-pencil"></span> Grupos
														</a>											
													</div>	
												</div>
											<?php } ?>	
										</div>
									<?php }?>								
								<?php } ?>
								<div class="col-md-12">											
									<label for=""><h4><b>Estatísticas</b></h4></label>
									<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
										<div class="form-group col-md-12 text-left">
											<div class="row">										
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/rankingformapag" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Forma de Pag.
												</a>
											</div>	
										</div>
										<div class="form-group col-md-12 text-left">
											<div class="row">										
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/rankingformaentrega" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Entrega
												</a>
											</div>	
										</div>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="text-center" style="color: #8B0000" data-toggle="collapse" data-target="#Despesas" aria-expanded="false" aria-controls="Despesas">
						<h3 class="text-center"><b>Despesas & Compras<?php #echo $titulo2; ?></b></h3>
					</div>
					<div <?php echo $collapse1; ?> id="Despesas">
						<div class="panel-body">
							<div class="row">
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>								
									<?php if(isset($_SESSION['Usuario']['Rel_Orc']) && $_SESSION['Usuario']['Rel_Orc'] == "S") {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Despesas</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>despesas_statico/pedidos" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Gestor Estatico
													</a>											
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>despesas/despesas" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Despesas
													</a>											
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php }else{ ?>
									<div class="col-md-12">											
										<label for=""><h4><b>Despesas</b></h4></label>
										<div class="form-group col-md-12 text-left">
											<div class="row">		
												<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>despesas_statico/despesas" role="button"> 
													<span class="glyphicon glyphicon-pencil"></span> Gestor Estático
												</a>											
											</div>	
										</div>
										<div class="form-group col-md-12 text-left">
											<div class="row">		
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>despesas/despesas" role="button"> 
													<span class="glyphicon glyphicon-pencil"></span> Despesas
												</a>											
											</div>	
										</div>
									</div>
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
									<div class="col-md-12">		
										<label for=""><h4><b>Pagamentos</b></h4></label>	
										<div class="form-group col-md-12 text-left">
											<div class="row">										
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Debitos/debitos" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Parcelas
												</a>
											</div>	
										</div>		
										<div class="form-group col-md-12 text-left">
											<div class="row">		
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/balanco" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Balanço
												</a>
											</div>	
										</div>											
									</div>
								<?php }else{ ?>
									<?php if($_SESSION['Usuario']['Rel_Pag'] == "S") {?>
										<div class="col-md-12">		
											<label for=""><h4><b>Pagamentos</b></h4></label>	
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Debitos/debitos" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Parcelas
													</a>
												</div>	
											</div>	
											<?php if(isset($_SESSION['Usuario']['Rel_Est']) && $_SESSION['Usuario']['Rel_Est'] == "S") {?>		
												<div class="form-group col-md-12 text-left">
													<div class="row">		
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/balanco" role="button"> 
															<span class="glyphicon glyphicon-usd"></span> Balanço
														</a>
													</div>	
												</div>
											<?php }?>											
										</div>
									<?php } ?>
								<?php } ?>	
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
									<?php if($_SESSION['Usuario']['Rel_Prd'] == "S") {?>
										<div class="col-md-12">
											<label for=""><h4><b>Produtos & Serviços</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Comprados/comprados" role="button">
														<span class="glyphicon glyphicon-gift"></span> Comprados
													</a>
												</div>	
											</div>
										</div>
									<?php } ?>
									<?php if($_SESSION['Usuario']['Rel_Prc'] == "S") {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Procedimentos</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Despesas/procedimentos" role="button">
														<span class="glyphicon glyphicon-pencil"></span> Procedimentos
													</a>
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
									<?php if(isset($_SESSION['Usuario']['Rel_Est']) && $_SESSION['Usuario']['Rel_Est'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Estatísticas</b></h4></label>									
										</div>
									<?php }?>
								<?php }else{?>
									<div class="col-md-12">											
										<label for=""><h4><b>Estatísticas</b></h4></label>									
									</div>	
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<div class="text-center" style="color: #4F4F4F" data-toggle="collapse" data-target="#Administracao" aria-expanded="false" aria-controls="Administracao">
						<h3 class="text-center"><b><?php echo $_SESSION['log']['NomeEmpresa']; ?></b></h3>
					</div>
					<div <?php echo $collapse1; ?> id="Administracao">
						<div class="panel-body">
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<label for=""><h4><b>Clientes</b></h4></label>
								<div class="row">
									<div class="form-group col-md-12 text-left">																				
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Cliente/clientes" role="button"> 
											<span class="glyphicon glyphicon-user"></span> Pesquisar Clientes
										</a>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>Cliente/rankingvendas" role="button"> 
											<span class="glyphicon glyphicon-pencil"></span>Ranking & CashBack
										</a>											
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">										
										<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Sac/sac" role="button">
											<span class="glyphicon glyphicon-pencil"></span> SAC
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">										
										<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>Marketing/marketing" role="button">
											<span class="glyphicon glyphicon-pencil"></span> Marketing
										</a>
									</div>	
								</div>
								<label for=""><h4><b>Fornecedores</b></h4></label>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/fornecedor" role="button"> 
											<span class="glyphicon glyphicon-user"></span> Fornecedores
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>atividade/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-user"></span> Atividade
										</a>
									</div>	
								</div>
								<label for=""><h4><b>Produtos & Promoções</b></h4></label>
								<div class="row">
									<div class="form-group col-md-12 text-left">	
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtos" role="button"> 
											<span class="glyphicon glyphicon-gift"></span> Produtos & Estoque
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">													
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/promocao" role="button"> 
											<span class="glyphicon glyphicon-usd"></span> Promoções
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">										
										<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>campanha" role="button">
											<span class="glyphicon glyphicon-pencil"></span>Campanhas & Cupons
										</a>
									</div>	
								</div>
								<!--
								<div class="form-group col-md-12 text-left">
									<div class="row">		
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php #echo base_url() ?>relatorio/estoque" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Estoque
										</a>
									</div>	
								</div>
								-->
							<?php } ?>
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<label for=""><h4><b>Empresa</b></h4></label>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/loginempresa" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Administração
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/loginempresa" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Funcionários
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block"  href="<?php echo base_url() ?>../enkontraki/login_cliente.php?id_empresa=<?php echo $_SESSION['Empresa']['idSis_Empresa'];?>" target="_blank"  role="button">
											<span class="glyphicon glyphicon-barcode"></span> Assinatura
										</a>
									</div>	
								</div>
								<label for=""><h4><b>Site</b></h4></label>	
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/site" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Site
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/slides" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Slides
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/atuacao" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Atuação
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/colaborador" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Equipe
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/depoimento" role="button"> 
											<span class="glyphicon glyphicon-barcode"></span> Depoimentos
										</a>
									</div>	
								</div>
							<?php }?>
							<div class="row">
								<div class="form-group col-md-12 text-left">
									<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/empresas" role="button"> 
										<span class="glyphicon glyphicon-home"></span> Empresas
									</a>
								</div>	
							</div>
							<div class="row">
								<div class="form-group col-md-12 text-left">
									<a type="button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() ?>login/sair" role="button"> 
										<span class="glyphicon glyphicon-log-out"></span> Sair
									</a>
								</div>	
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<!--
		<div class="col-md-3">
			<div class="panel panel-danger">
				<div class="panel-heading"><strong><?php #echo $titulo4; ?></strong><strong> - Como Receber?</strong></div>
				<div class="panel-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">																			
								<div class="text-center t">
									<h3><?php #echo '<small></small><strong> Nos Indicando </strong><small></small>'  ?></h3>
								</div>
								<div class="form-group col-md-12 text-left">														
									<div class="row">	
										<a  class="btn btn-md btn-danger btn-block" href="<?php #echo base_url() ?>relatorio/empresaassociado" role="button"> 
											<span class="glyphicon glyphicon-list"></span> Cadastrar Indicações
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		-->
	</div>
</form>
</div>
