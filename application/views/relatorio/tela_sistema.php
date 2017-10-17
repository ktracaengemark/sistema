<?php if ($msg) echo $msg; ?>

	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">

				<?php echo validation_errors(); ?>
				
				

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
												<strong>R$ 50,00</strong><br>(2 Usuários/ loja)
												<!-- 50 reais -->
												<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
												<input type="hidden" name="itemCode" value="9DA3EE4B5F5F2B300463BFA057CEA720" />
												<input type="hidden" name="iot" value="button" />
												<input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/84x35-comprar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
												</form>
												<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
												<!-- -->
												<br>
												<strong>R$ 100,00</strong><br>(5 Usuários/ loja)
												<!-- 100 reais -->
												<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">										
												<input type="hidden" name="itemCode" value="17612F32222247A5545A8F88DA96AC72" />
												<input type="hidden" name="iot" value="button" />
												<input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/84x35-comprar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
												</form>
												<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
												<!---->
												<br>
												<strong>R$ 150,00</strong><br>(10 Usuários/ loja)
												<!-- 150 reais -->
												<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
												<input type="hidden" name="itemCode" value="577CBF6DBEBE7B4994641FB83D324D41" />
												<input type="hidden" name="iot" value="button" />
												<input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/84x35-comprar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
												</form>
												<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
												<!--  -->	
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
										<!--
										<div class="form-group col-md-12 text-left">													
											<div class="row">	
												<a  class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>loginassociadoempresafilial/registrar" role="button"> 
													<span class="glyphicon glyphicon-user"></span> Cadastrar Empresa Indicada
												</a>
											</div>
										</div>
										-->
										<div class="form-group col-md-12 text-left">														
											<div class="row">	
												<a  class="btn btn-md btn-danger btn-block" href="<?php echo base_url() ?>relatorio/empresaassociado" role="button"> 
													<span class="glyphicon glyphicon-list"></span> Relatório de Indicações
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

