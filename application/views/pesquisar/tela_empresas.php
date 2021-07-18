<?php if ($msg) echo $msg; ?>
<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<nav class="navbar navbar-inverse navbar-fixed-top navbar-menu">
			
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>					
					<a class="navbar-brand navbar-logo" href="<?php echo base_url() ?>../enkontraki/index.php"><img src="<?php echo base_url() ?>/arquivos/imagens/Logo_Navegador.png"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right navbar-fonte">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() . '../enkontraki/#banner';?>">Enkontraki</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#about">A Plataforma</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#cta-1">Planos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#testimonial">Depoimentos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#dicas">Dicas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url() ?>../enkontraki/#contact">Fale Conosco</a>
						</li>
					</ul>
				</div>		
			
		</nav>
				
		
			<div class="row">
				<div class="banner-info">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center img-responsive">	
						<center>
							<figure>
								<div class="boxVideo">
									<a  href="<?php echo base_url() ?>../enkontraki" role="button">
										<img class="img-responsive" src="<?php echo base_url() . 'arquivos/imagens/Logo_Navegador.png'; ?>" >
									</a>
								</div>
							</figure>
						</center>	
					</div>
					<?php echo validation_errors(); ?>
						<?php #echo form_open(base_url() . 'empresacli0/pesquisar', 'class="navbar-form navbar-left"'); ?>
					<?php echo form_open(base_url() . 'empresacli0/pesquisar', 'role="form"'); ?>

					<div class="container ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
											<button  class="btn btn-sm btn-info btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
													<span class="glyphicon glyphicon-filter"></span> Filtrar<?php #echo $titulo; ?>
											</button>
										</div>
										<!--
										<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 ">	
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<a class="" href="<?php #echo base_url(); ?>login/index" role="button" style="color: #000000" >
													<span class="glyphicon glyphicon-user"></span> Associado
												</a>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 " >			
												<a class="" href="<?php #echo base_url(); ?>login/index2" role="button" style="color: #000000" >
													<span class="glyphicon glyphicon-home"></span> Empresa
												</a>
											</div>
										</div>
										-->
									</div>	
									
									<!--
									<?php #echo form_open('relatorio/empresas', 'role="form"'); ?>
									<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
											<span class="glyphicon glyphicon-search"></span> <?php #echo $titulo; ?>
									</button>	
									
									<a class="btn btn-sm btn-warning" href="<?php #echo base_url() ?>relatorio/associado" role="button">
										<span class="glyphicon glyphicon-search"></span> Associados
									</a>
									-->
								</div>
								
								<div class="panel-body">			
									<?php echo (isset($list)) ? $list : FALSE ?>
								</div>
								
							</div>
							
						</div>
						
					</div>
					<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros de Pesquisa</h4>
								</div>
								<div class="modal-footer">
									<div class="form-group">	
										<div class="row">
											<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">	
												<div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
													<span class="input-group-btn">
														<button class="btn btn-info btn-md" type="submit">
															<span class="glyphicon glyphicon-search"></span>
														</button>
													</span>
													<input type="text" placeholder="Ex.: barbeiro" class="form-control " name="Pesquisa" value="">
												</div>
											</div>
											<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12  text-left">
												<label for="Ordenamento">Nome Empresa:</label>
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
														id="NomeEmpresa" name="NomeEmpresa">
													<?php
													foreach ($select['NomeEmpresa'] as $key => $row) {
														if ($query['NomeEmpresa'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
												<label for="Ordenamento">Categoria:</label>
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
														id="CategoriaEmpresa" name="CategoriaEmpresa">
													<?php
													foreach ($select['CategoriaEmpresa'] as $key => $row) {
														if ($query['CategoriaEmpresa'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
										</div>										
										<!--
										<div class="row">		
											<div class="col-md-8 text-left">
												<label for="Ordenamento">Atua��o:</label>
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
														id="Atuacao" name="Atuacao">
													<?php
													/*
													foreach ($select['Atuacao'] as $key => $row) {
														if ($query['Atuacao'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													*/
													?>
												</select>
											</div>
										</div>
										-->
										<div class="row">
											<br>
											<div class="form-group col-md-4 text-left">
												<div class="form-footer ">
													<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-search"></span> Pesquisar
													</button>
												</div>
											</div>
											<div class="form-group col-md-4 text-left">
												<div class="form-footer ">
													<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"></span> Fechar
													</button>
												</div>
											</div>
										</div>	
										<div class="row">	
											<div class="col-md-12 text-left">
												<label for="Ordenamento">Ordenamento:</label>
												<div class="form-group">
													<div class="row">
														<div class="col-md-8">
															<select data-placeholder="Selecione uma op��o..." class="form-control btn-block Chosen " 
																	id="Campo" name="Campo">
																<?php
																foreach ($select['Campo'] as $key => $row) {
																	if ($query['Campo'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>

														<div class="col-md-4">
															<select data-placeholder="Selecione uma op��o..." class="form-control btn-block Chosen" 
																	id="Ordenamento" name="Ordenamento">
																<?php
																foreach ($select['Ordenamento'] as $key => $row) {
																	if ($query['Ordenamento'] == $key) {
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
											</div>
										</div>
									</div>
								</div>									
							</div>								
						</div>
					</div>
					</form>					
					<div class=" col-md-12 col-sm-12 col-xs-12 banner-text text-center ">
						<div class="row">
							<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group text-center">
								<h3 class="white">Empresas</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group text-center">
								<a  type="button" class="btn btn-sm btn-warning btn-block text-left" href="<?php echo base_url() ?>pesquisar/empresas" role="button" > 
									 Pesquisar!
								</a>											
							</div>
							<div class=" col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group text-center">
								<a  type="button" class="btn btn-sm btn-danger btn-block text-left" href="<?php echo base_url() ?>loginempresa/registrar" role="button" > 
									 Cadastrar!
								</a>											
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group text-center">
								<a  type="button" class="btn btn-sm btn-info btn-block text-left" href="<?php echo base_url() ?>login/index2" role="button" > 
									 Acessar!
								</a>											
							</div>	
						</div>
					</div>
					
				</div>
			</div>
			<!--
			<div class="overlay-detail text-center">
				<a href="#service"><i class="fa fa-angle-down"></i></a>
			</div>
			-->
		
	</div>
</section>