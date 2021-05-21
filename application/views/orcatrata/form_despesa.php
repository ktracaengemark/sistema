<?php if (isset($msg)) echo $msg; ?>
<div class="col-md-2 "></div>
<div class="col-md-8 ">	
	<div class="row">
		<div class="col-md-12 ">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
								
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">	
						<div class="col-md-9">	
							<h4 class="text-center"><b> Selecione o <?php echo $titulo; ?></h4>
						</div>
						<div class="col-md-3">										
							<a class="btn btn-md btn-danger" href="<?php echo base_url() ?>orcatrata/cadastrar3" role="button"> 
								<span class="glyphicon glyphicon-plus"></span> Novo Pedido
							</a>
						</div>
					</div>	
				</div>
			</div>
			</form>
		</div>
	</div>		
	<div class="row">		
		<div class="col-md-12">
			<div class="panel panel-info ">
				<div class="panel-heading">
					<div class="text-center" type="button" data-toggle="collapse" data-target="#StatusOrç" aria-expanded="false" aria-controls="StatusOrç">
						 <h4><b>Gestor de Pedidos</b></h4>
					</div>
					<div <?php echo $collapse; ?> id="StatusOrç">
								
							<div class="row">
							<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div type="button" data-toggle="collapse" data-target="#Combinar" aria-expanded="false" aria-controls="Combinar">
												 Aguardando <b>Combinar Entrega e Pagamento</b>
											</div>					
										</div>
										<div <?php echo $collapse; ?> id="Combinar">
											<div class="panel-body">

												<?php if (isset($list7)) echo $list7; ?>

											</div>
										</div>	
									</div>
								</div>
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<div type="button" data-toggle="collapse" data-target="#Pagamentoonline" aria-expanded="false" aria-controls="Pagamentoonline">
												Aguardando <b>Pagamento OnLine</b>
											</div>					
										</div>
										<div <?php echo $collapse; ?> id="Pagamentoonline">
											<div class="panel-body">

												<?php if (isset($list8)) echo $list8; ?>

											</div>
										</div>	
									</div>
								</div>
								<div class="col-md-12">
									<div class="panel panel-danger">
										<div class="panel-heading">
											<div type="button" data-toggle="collapse" data-target="#NaoEntreguesBalcao" aria-expanded="false" aria-controls="NaoEntreguesBalcao">
												 Aguardando <b>Produção</b>
											</div>					
										</div>
										<div <?php echo $collapse; ?> id="NaoEntreguesBalcao">
											<div class="panel-body">

												<?php if (isset($list1)) echo $list1; ?>

											</div>
										</div>	
									</div>
								</div>
								<div class="col-md-12">
									<div class="panel panel-success">
										<div class="panel-heading">
											<div type="button" data-toggle="collapse" data-target="#NaoDevolvidos" aria-expanded="false" aria-controls="NaoDevolvidos">
												Aguardando <b>Envio</b>
											</div>			
										</div>
										<div <?php echo $collapse; ?> id="NaoDevolvidos">				
											<div class="panel-body">

												<?php if (isset($list3)) echo $list3; ?>

											</div>
										</div>	
									</div>
								</div>
								<div class="col-md-12">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div type="button" data-toggle="collapse" data-target="#NaoEntreguesOnline" aria-expanded="false" aria-controls="NaoEntreguesOnline">
												Aguardando <b>Entrega</b>
											</div>					
										</div>
										<div <?php echo $collapse; ?> id="NaoEntreguesOnline">
											<div class="panel-body">

												<?php if (isset($list5)) echo $list5; ?>

											</div>
										</div>	
									</div>
								</div>
								<div class="col-md-12">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<div type="button" data-toggle="collapse" data-target="#NaoDevolvidosOnline" aria-expanded="false" aria-controls="NaoDevolvidosOnline">
												Aguardando <b>Pagamento</b>
											</div>			
										</div>
										<div <?php echo $collapse; ?> id="NaoDevolvidosOnline">				
											<div class="panel-body">

												<?php if (isset($list6)) echo $list6; ?>

											</div>
										</div>	
									</div>
								</div>		
								<!--
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
												<span class="glyphicon glyphicon-chevron-up"></span> Não Recebidos
											</div>
											<a class="btn btn-md btn-warning" href="<?php #echo base_url() ?>relatorio/fiadorec" role="button">
												<span class="glyphicon glyphicon-search"></span> Fiado
											</a>
										</div>
										<div <?php #echo $collapse1; ?> id="NaoRecebidos">	
											<div class="panel-body">

												<?php #if (isset($list2)) echo $list2; ?>

											</div>
										</div>	
									</div>
								</div>
								-->	
							<?php } else { ?>
									
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#NaoRecebidos" aria-expanded="false" aria-controls="NaoRecebidos">
												Resumo <span class="glyphicon glyphicon-chevron-down"></span>
											</div>					
											<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>relatorio/parcelasrec" role="button">
												<span class="glyphicon glyphicon-search"></span> Rel. das Receitas
											</a>					
										</div>
										<div <?php echo $collapse1; ?> id="NaoRecebidos">
											<div class="panel-body">

												<?php if (isset($list4)) echo $list4; ?>

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