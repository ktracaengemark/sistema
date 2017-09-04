<?php if ($msg) echo $msg; ?>


	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">

				<?php echo validation_errors(); ?>
				<?php echo form_open('relatorio/admin', 'role="form"'); ?>

				<div class="col-md-6">

						<div class="panel panel-primary">
							<div class="panel-heading"><strong><?php echo $titulo1; ?></strong></div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">														
										<div class="col-md-12 text-center">
											<label for="">Pessoas & Empresas:</label>
											<div class="form-group">
												<div class="row">																				
													<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
														<span class="glyphicon glyphicon-user"></span> Cliente
													</a>
													<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/funcionario" role="button"> 
														<span class="glyphicon glyphicon-user"></span> Funcion.
													</a>													
													<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>relatorio/fornecedor" role="button"> 
														<span class="glyphicon glyphicon-user"></span> Fornec.
													</a>
												</div>	
											</div>																										
										</div>
										<div class="col-md-12 text-center">											
											<label for="">Planos, Produtos & Serviços:</label>									
											<div class="form-group">
												<div class="row">													
													<a class="btn btn-sm btn-primary" href="<?php echo base_url() ?>convenio/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-qrcode"></span> Planos
													</a>
													<a class="btn btn-sm btn-primary" href="<?php echo base_url() ?>produtos/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-qrcode"></span> Produtos
													</a>
													<a class="btn btn-sm btn-primary" href="<?php echo base_url() ?>servico/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-qrcode"></span> Serviços
													</a>											
												</div>	
											</div>													
										</div>								
										<div class="col-md-12 text-center">											
											<label for="">Dia a Dia:</label>
											<div class="form-group">
												<div class="row">													
													<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Orçam.
													</a>													
													<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>despesas/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Despesa
													</a>
													<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>consumo/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Consumo
													</a>											
												</div>	
											</div>		
										</div>																								
									</div>
								</div>
								</form>
							</div>
						</div>
	
				</div>	
				<div class="col-md-6">	

						<div class="panel panel-primary">
							<div class="panel-heading"><strong><?php echo $titulo2; ?></strong></div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">								
										<div class="col-md-12 text-center">											
											<label for="">Financeiro:</label>									
											<div class="form-group">
												<div class="row">										
													<a  class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/receitas" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Receitas
													</a>											
													<a  class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/despesas" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Despesas
													</a>
													<a  class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/orcamento" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Balanço
													</a>											
												</div>	
											</div>		
										</div>
										<div class="col-md-12 text-center">											
											<label for="">Produtos:</label>									
											<div class="form-group">
												<div class="row">
													<a class="btn btn-sm btn-primary" href="<?php echo base_url() ?>relatorio/produtoscomp" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Prod/Cp
													</a>											
													<a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url() ?>relatorio/produtosvend" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Prod/Vd
													</a>											
													<a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url() ?>relatorio/consumo" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Prod/Cs
													</a>
												</div>	
											</div>		
										</div>
										<div class="col-md-12 text-center">
											<label for="">Serviços, Proced. & Tarefas:</label>								
											<div class="form-group">
												<div class="row">
													<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/servicosprest" role="button"> 
														<span class="glyphicon glyphicon-plus"></span> Serv/Vd
													</a>											
													<a type="button" class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/orcamentopc" role="button"> 
														<span class="glyphicon glyphicon-list-alt"></span> Proced.
													</a>											
													<a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url() ?>relatorio/produtos" role="button"> 
														<span class="glyphicon glyphicon-barcode"></span> Produtos
													</a>
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
	<div class="col-md-3"></div>

