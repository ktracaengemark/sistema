<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">
			<div class="main">

				<?php echo validation_errors(); ?>
				<?php echo form_open('relatorio/admin', 'role="form"'); ?>

				<div class="panel panel-primary">
					<div class="panel-heading"><strong><?php echo $titulo1; ?></strong></div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">														
								<div class="col-md-4 text-center">
									<label for="">Pessoas & Empresas:</label>
									<div class="form-group">
										<div class="row">																				
											<button type="button" class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Clientes
											</button>
											<button type="button" class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/funcionario" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Funcion.
											</button>													
											<button type="button" class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/fornecedor" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Fornec.
											</button>
										</div>	
									</div>																										
								</div>
								<div class="col-md-4 text-center">											
									<label for="">Planos, Produtos & Serviços:</label>									
									<div class="form-group">
										<div class="row">													
											<button type="button" class="btn btn-md btn-primary" href="<?php echo base_url() ?>convenio/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Planos
											</button>
											<button type="button" class="btn btn-md btn-primary" href="<?php echo base_url() ?>produto/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Produtos
											</button>
											<button type="button" class="btn btn-md btn-primary" href="<?php echo base_url() ?>servico/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Serviços
											</button>											
										</div>	
									</div>													
								</div>								
								<div class="col-md-4 text-center">											
									<label for="">Dia a Dia:</label>
									<div class="form-group">
										<div class="row">													
											<button type="button" class="btn btn-md btn-info" href="<?php echo base_url() ?>despesas/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Despesas
											</button>
											<button type="button" class="btn btn-md btn-info" href="<?php echo base_url() ?>consumo/cadastrar" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Consumo
											</button>
											<button type="button" class="btn btn-md btn-info" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Orçam.
											</button>											
										</div>	
									</div>		
								</div>																								
							</div>
						</div>
						</form>
					</div>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading"><strong><?php echo $titulo2; ?></strong></div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">								
								<div class="col-md-4 text-center">											
									<label for="">Financeiro:</label>									
									<div class="form-group">
										<div class="row">										
											<button type="button" class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/receitas" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Receitas
											</button>											
											<button type="button" class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/despesas" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Despesas
											</button>
											<button type="button" class="btn btn-md btn-success" href="<?php echo base_url() ?>relatorio/orcamento" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Balanço
											</button>											
										</div>	
									</div>		
								</div>
								<div class="col-md-4 text-center">											
									<label for="">Produtos:</label>									
									<div class="form-group">
										<div class="row">
											<button type="button" class="btn btn-md btn-primary" href="<?php echo base_url() ?>relatorio/produtoscomp" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Prod/Cp
											</button>											
											<button type="button" class="btn btn-md btn-primary" href="<?php echo base_url() ?>relatorio/produtosvend" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Prod/Vd
											</button>											
											<button type="button" class="btn btn-md btn-primary" href="<?php echo base_url() ?>relatorio/consumo" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Prod/Cs
											</button>
										</div>	
									</div>		
								</div>
								<div class="col-md-4 text-center">
									<label for="">Serviços, Proced. & Tarefas:</label>								
									<div class="form-group">
										<div class="row">
											<button type="button" class="btn btn-md btn-info" href="<?php echo base_url() ?>relatorio/servicosprest" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Serviço/Vd
											</button>											
											<button type="button" class="btn btn-md btn-info" href="<?php echo base_url() ?>relatorio/orcamentopc" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Proced.
											</button>											
											<button type="button" class="btn btn-md btn-info" href="<?php echo base_url() ?>relatorio/tarefa" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Tarefas
											</button>
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
	<div class="col-md-1"></div>

