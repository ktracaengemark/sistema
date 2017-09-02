<?php if ($msg) echo $msg; ?>


	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">

				<?php echo validation_errors(); ?>
				<?php echo form_open('relatorio/admin', 'role="form"'); ?>

				<div class="col-md-6">

						<div class="panel panel-primary">
							<div class="panel-heading"><strong><?php echo $titulo1; ?></strong><strong> - Como Pagar?</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">														
										<div class="col-md-1"></div>
										<div class="col-md-10 text-center">
											<div class="form-group">
												<div class="text-center t">
													<h3><?php echo '<small></small><strong> PagSeguro </strong><small></small>'  ?></h3>
												</div>												
												<div class="row">																																		
													<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
														<strong>R$ 50,00</strong> (1 Usuário/ loja)
													</a>
												</div>
												<br>
												<div class="row">	
													<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/funcionario" role="button"> 
														<strong>R$ 100,00</strong> (5 Usuários/ loja)
													</a>
												</div>
												<br>
												<div class="row">	
													<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/fornecedor" role="button"> 
														<strong>R$ 150,00</strong> (10 Usuários/ loja)
													</a>
												</div>	
											</div>
											<div class="form-group">
												<div class="row">																				
													<div class="text-center t">
														<h3><?php echo '<small></small><strong> Tranf. ou Depósito </strong><small></small>'  ?></h3>
													</div>													
													<a class="btn btn-lg btn-info active" > 
														<strong>Banco do Brasil</strong><br><strong>Ag.XXXX</strong><br><strong>Cc.:XXXX</strong>
														<br><strong>Fav.:Marcio R. Dias</strong><br><strong>Cpf.:015146927-08</strong>
													</a>
												</div>	
											</div>											
										</div>
										<div class="col-md-1"></div>
									</div>
								</div>
								</form>
							</div>
						</div>
	
				</div>	
				<div class="col-md-6">	

						<div class="panel panel-danger">
							<div class="panel-heading"><strong><?php echo $titulo2; ?></strong><strong> - Como Receber?</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">								
										<div class="col-md-1"></div>
										<div class="col-md-10 text-center">																			
											<div class="form-group">
												<div class="text-center t">
													<h3><?php echo '<small></small><strong> Nos Indicando </strong><small></small>'  ?></h3>
												</div>													
												<div class="row">										
													<a  class="btn btn-sm btn-danger" href="<?php echo base_url() ?>tipobanco/cadastrar" role="button"> 
														<span class="glyphicon glyphicon-usd"></span> Cadastrar Conta Corrente
													</a>
												</div>
												<br>
												<div class="row">	
													<a  class="btn btn-sm btn-danger" href="<?php echo base_url() ?>loginassociado/registrar" role="button"> 
														<span class="glyphicon glyphicon-user"></span> Cadastrar Associado
													</a>
												</div>
												<br>	
											</div>		
										</div>
										<div class="col-md-1"></div>
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

