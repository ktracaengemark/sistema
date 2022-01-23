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
					<!--
					<a class="text-center" style="color: #3CB371" data-toggle="collapse" data-target="#Tarefas" aria-expanded="false" aria-controls="Tarefas">
						<h3 class="text-center"><b>Tarefas & Agendas<?php #echo $titulo2; ?></b></h3>
					</a>
					-->
					<div <?php echo $collapse1; ?> id="Tarefas">	
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<label for=""><h4><b>Agenda</b></h4></label>
									<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
										<div class="form-group col-md-12 text-left">
											<div class="row">
												<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>relatorio/evento_cli" role="button"> 
													<span class="glyphicon glyphicon-pencil"></span> Eventos C/Clientes
												</a>											
											</div>	
										</div>
									<?php }?>
										<div class="form-group col-md-12 text-left">
											<div class="row">
												<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>relatorio/evento" role="button"> 
													<span class="glyphicon glyphicon-pencil"></span> Outros Eventos
												</a>											
											</div>	
										</div>	
								</div>
								<div class="col-md-12">
									<label for=""><h4><b>Tarefas</b></h4></label>
									<div class="form-group col-md-12 text-left">
										<div class="row">
											<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
												<span class="glyphicon glyphicon-pencil"></span> Relatório de Tarefas
											</a>											
										</div>	
									</div>
									<div class="form-group col-md-12 text-left">
										<div class="row">
											<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>categoria/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-pencil"></span> Categorias das Tarefas
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
									<?php if($_SESSION['Usuario']['Rel_Orc'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Receitas</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>orcatrata/pedidos" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Gestor de Receitas Estático
													</a>											
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>relatorio/receitas" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Receitas
													</a>											
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
									<div class="col-md-12">	
										<label for=""><h4><b>Pagamentos</b></h4></label>
										<div class="form-group col-md-12 text-left">
											<div class="row">										
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/cobrancas" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Parcelas
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
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/cobrancas" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Parcelas
													</a>
												</div>	
											</div>
										</div>	
									<?php } ?>
								<?php } ?>	
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
									<?php if($_SESSION['Usuario']['Rel_Prd'] == "S") {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Produtos & Serviços</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/vendidos" role="button"> 
														<span class="glyphicon glyphicon-gift"></span> Vendidos
													</a>
												</div>	
											</div>
											
											<!--
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/estoque" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Estoque
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtosvend" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos Vendidos
													</a>
												</div>	
											</div>
											
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtosdevol" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos Devolvidos
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/consumo" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos Consumidos
													</a>
												</div>	
											</div>
											
											<div class="form-group col-md-12 text-left">
												<div class="row">
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/servicosprest" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Serviços Prestados
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/orcamentopc" role="button"> 
														<span class="glyphicon glyphicon-list-alt"></span> Procedimentos
													</a>
												</div>	
											</div>
											-->
										</div>
									<?php }?>	
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>	
									<?php if($_SESSION['Usuario']['Rel_Prc'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Procedimentos</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/proc_receitas" role="button">
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
										<?php if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Permissao_Comissao'] >= 2) {?>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/comissao_online" role="button"> 
														<span class="glyphicon glyphicon-usd"></span>Por Pedido/ Associado
													</a>
												</div>	
											</div>
										<?php }?>
									</div>
								<?php }else{ ?>
									<?php if($_SESSION['Usuario']['Rel_Com'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Comissões</b></h4></label>
											<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/comissao" role="button"> 
															<span class="glyphicon glyphicon-usd"></span>Por Pedido/ Colaborador
														</a>
													</div>	
												</div>
											<?php } ?>
											<?php if($_SESSION['log']['idSis_Empresa'] == 5 || $_SESSION['Usuario']['Permissao_Comissao'] >= 2) {?>
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/comissao_online" role="button"> 
															<span class="glyphicon glyphicon-usd"></span>Por Pedido/ Associado
														</a>
													</div>	
												</div>
											<?php }?>	
											<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatoriocomissoes/porservicos" role="button"> 
															<span class="glyphicon glyphicon-usd"></span> Por Serviços
														</a>
													</div>	
												</div>
											<?php } ?>	
										</div>
									<?php }?>								
								<?php } ?>	
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>	
									<?php if($_SESSION['Usuario']['Rel_Est'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Estatísticas</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/balanco" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Balanço
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/rankingvendas" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Ranking de Vendas
													</a>
												</div>	
											</div>
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
											<?php if($_SESSION['log']['idSis_Empresa'] == "2") {?>
												<!--
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php #echo base_url() ?>relatorio/ultimopedido" role="button"> 
															<span class="glyphicon glyphicon-usd"></span> Ultimo pedido
														</a>
													</div>	
												</div>
												<div class="form-group col-md-12 text-left">
													<div class="row">										
														<a  type="button" class="btn btn-md btn-default btn-block" href="<?php #echo base_url() ?>orcatrata/ultimopedido" role="button"> 
															<span class="glyphicon glyphicon-usd"></span> Cadastrar Ultimo pedido
														</a>
													</div>	
												</div>
												-->
											<?php }?>
										</div>
									<?php }?>
								<?php }?>	
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
									<?php if($_SESSION['Usuario']['Rel_Orc'] == "S") {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Despesas</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>despesas/despesas" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Gestor de Despesas Estático
													</a>											
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/despesas" role="button"> 
														<span class="glyphicon glyphicon-pencil"></span> Despesas
													</a>											
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] == "5") {?>
									<div class="col-md-12">		
										<label for=""><h4><b>Pagamentos</b></h4></label>	
										<div class="form-group col-md-12 text-left">
											<div class="row">										
												<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/debitos" role="button"> 
													<span class="glyphicon glyphicon-usd"></span> Parcelas
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
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/debitos" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Parcelas
													</a>
												</div>	
											</div>											
										</div>
									<?php } ?>
								<?php } ?>	
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
									<?php if($_SESSION['Usuario']['Rel_Prd'] == "S") {?>
										<div class="col-md-12">
											<label for=""><h4><b>Produtos & Serviços</b></h4></label>
											<!--
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/comprados" role="button">
														<span class="glyphicon glyphicon-gift"></span> Comprados
													</a>
												</div>	
											</div>
											
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/estoque" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Estoque
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtoscomp" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos Comprados
													</a>
												</div>	
											</div>
											
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtosdevol" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos Devolvidos
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/consumo" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos Consumidos
													</a>
												</div>	
											</div>
											
											<div class="form-group col-md-12 text-left">
												<div class="row">
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/servicosprest" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Serviços Comprados
													</a>
												</div>	
											</div>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/orcamentopc" role="button"> 
														<span class="glyphicon glyphicon-list-alt"></span> Procedimentos
													</a>
												</div>	
											</div>
											-->
										</div>
									<?php } ?>
									<?php if($_SESSION['Usuario']['Rel_Prc'] == "S") {?>
										<div class="col-md-12">											
											<label for=""><h4><b>Procedimentos</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">										
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/proc_despesas" role="button">
														<span class="glyphicon glyphicon-pencil"></span> Procedimentos
													</a>
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php } ?>
								<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>	
									<?php if($_SESSION['Usuario']['Rel_Est'] == "S") {?>	
										<div class="col-md-12">											
											<label for=""><h4><b>Estatísticas</b></h4></label>
											<div class="form-group col-md-12 text-left">
												<div class="row">		
													<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/balanco" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Balanço
													</a>
												</div>	
											</div>									
										</div>
									<?php }?>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="text-center" style="color: #4F4F4F" data-toggle="collapse" data-target="#Administracao" aria-expanded="false" aria-controls="Administracao">
						<h3 class="text-center"><b>Administração<?php #echo $titulo2; ?></b></h3>
					</div>
					<div <?php echo $collapse1; ?> id="Administracao">
						<div class="panel-body">
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
								<label for=""><h4><b>Clientes</b></h4></label>
								<div class="row">
									<div class="form-group col-md-12 text-left">																				
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
											<span class="glyphicon glyphicon-user"></span> Clientes/ Dep/ Pet
										</a>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">
										<a  type="button" class="btn btn-md btn-default btn-block text-left" href="<?php echo base_url() ?>motivo/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-pencil"></span> Motivos do Inativo
										</a>											
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">										
										<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/proc_Sac" role="button">
											<span class="glyphicon glyphicon-pencil"></span> SAC
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">										
										<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/proc_Marketing" role="button">
											<span class="glyphicon glyphicon-pencil"></span> Marketing
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">										
										<a  type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>campanha" role="button">
											<span class="glyphicon glyphicon-pencil"></span> Campanhas
										</a>
									</div>	
								</div>
								<?php if ($_SESSION['log']['idSis_Empresa'] == 2 ) { ?>	
									<div class="row">
										<div class="form-group col-md-12 text-left">																				
											<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/clenkontraki" role="button"> 
												<span class="glyphicon glyphicon-user"></span> Clientes Enkontraki/ Lista
											</a>
										</div>
									</div>
								<?php } ?>
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
								<label for=""><h4><b>Produtos & Serviços</b></h4></label>
								<div class="row">
									<div class="form-group col-md-12 text-left">	
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtos" role="button"> 
											<span class="glyphicon glyphicon-gift"></span> Produtos & Serviços
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
								<!--
								<div class="row">
									<div class="form-group col-md-12 text-left">													
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/catprod" role="button"> 
											<span class="glyphicon glyphicon-pencil"></span> Categoria
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">													
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/atributo" role="button"> 
											<span class="glyphicon glyphicon-pencil"></span> Atributos
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">		
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/produtos2" role="button"> 
											<span class="glyphicon glyphicon-gift"></span> Produtos & Serviços
										</a>
									</div>	
								</div>
								<div class="row">
									<div class="form-group col-md-12 text-left">													
										<a class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/precopromocao" role="button"> 
											<span class="glyphicon glyphicon-usd"></span> Preços
										</a>
									</div>	
								</div>
								-->
								<!--
								<div class="form-group col-md-12 text-left">
									<div class="row">													
										<a class="btn btn-md btn-primary btn-block" href="<?php echo base_url() ?>convenio/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-qrcode"></span> Planos & Convênios
										</a>
									</div>	
								</div>													
								<div class="form-group col-md-12 text-left">
									<div class="row">													
										<a class="btn btn-md btn-primary btn-block" href="<?php echo base_url() ?>formapag/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-qrcode"></span> Forma de Pagamento
										</a>
									</div>	
								</div>												
								
								<div class="form-group col-md-10 text-left">
									<div class="row">		
										<a class="btn btn-md btn-primary" href="<?php echo base_url() ?>servicos/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-qrcode"></span> Serviços
										</a>											
									</div>	
								</div>
								-->
								
							<?php } ?>	
							<!--
							<div class="col-md-12">											
								<label for="">Tipos de Saídas:</label>
								<div class="form-group col-md-12 text-left">
									<div class="row">		
										<a class="btn btn-md btn-info btn-block" href="<?php echo base_url() ?>tipodespesa/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-pencil"></span> Tipo de Despesa
										</a>
									</div>	
								</div>											
								<div class="form-group col-md-12 text-left">
									<div class="row">		
										<a class="btn btn-md btn-info btn-block" href="<?php echo base_url() ?>tipoconsumo/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-pencil"></span> Tipo de Consumo
										</a>
									</div>	
								</div>											
							</div>
							-->	
							<label for=""><h4><b>Site</b></h4></label>	
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
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
											<span class="glyphicon glyphicon-barcode"></span> Slides do Site
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
							<label for=""><h4><b><?php echo $_SESSION['log']['NomeEmpresa']; ?></b></h4></label>
							
							<?php 
								if($_SESSION['log']['idSis_Empresa'] == "5"){
									$usuario = 'associado';
								}else{
									
									$usuario = 'usuario2';
								}
							?>
							<div class="row">
								<div class="form-group col-md-12 text-left">	
									<a class="container-img" href="<?php echo base_url() ?><?php echo $usuario; ?>/prontuario/<?php echo $_SESSION['log']['idSis_Usuario']; ?>" > 
										<img class="img-circle img-responsive" width='200' height='200' alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Usuario']['idSis_Empresa'] . '/usuarios/miniatura/' . $query['Arquivo'] . ''; ?>">
										<?php echo $_SESSION['log']['Nome']; ?>
									</a>
								</div>
							</div>
							<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
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
											<span class="glyphicon glyphicon-barcode"></span> Renovar Assinatura
										</a>
									</div>	
								</div>
							<?php }?>
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
				<div class="panel-heading"><strong><?php echo $titulo4; ?></strong><strong> - Como Receber?</strong></div>
				<div class="panel-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">																			
								<div class="text-center t">
									<h3><?php echo '<small></small><strong> Nos Indicando </strong><small></small>'  ?></h3>
								</div>
								
								<div class="form-group col-md-12 text-left">	
									<div class="row">										
										<a  class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>tipobanco/cadastrar" role="button"> 
											<span class="glyphicon glyphicon-usd"></span> Cadastrar Conta Corrente
										</a>
									</div>
								</div>
								
								<div class="form-group col-md-12 text-left">													
									<div class="row">	
										<a  class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>loginassociadoempresafilial/registrar" role="button"> 
											<span class="glyphicon glyphicon-user"></span> Cadastrar Empresa Indicada
										</a>
									</div>
								</div>
								
								<div class="form-group col-md-12 text-left">														
									<div class="row">	
										<a  class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>relatorio/empresaassociado" role="button"> 
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
