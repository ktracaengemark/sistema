<?php if ($msg) echo $msg; ?>
<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<div class="banner-info">
			<div class="row">
				<?php echo validation_errors(); ?>
					<?php #echo form_open(base_url() . 'empresacli0/pesquisar', 'class="navbar-form navbar-left"'); ?>
				<?php echo form_open(base_url() . 'empresacli0/pesquisar', 'role="form"'); ?>
				<div class="col-lg-offset-2 col-lg-8  col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
									<button  class="btn btn-sm btn-info btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".Pesquisar_Modal">
											<span class="glyphicon glyphicon-search"></span> Pesquisar<?php #echo $titulo; ?>
									</button>
								</div>
								
								<label >Dep</label><br>
								<button type="button" class="btn btn-success btn-block" id="Produto" data-toggle="modal" data-target="#addClienteDepModal">
									<span class="glyphicon glyphicon-plus"></span>Cad
								</button>
							</div>	
						</div>
						<div class="panel-body">			
							<?php echo (isset($list)) ? $list : FALSE ?>
						</div>
					</div>
					
					<div class="modal fade Pesquisar_Modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<div class="row">
										<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
											<h3 class="modal-title" id="buscaModalLabel">Pesquisar</h3>
											<div class="row">
												<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
													<div class="custom-control custom-radio">
														<input type="radio" name="SetBusca" class="custom-control-input "  id="SetProduto" value="PD" checked >
														<label class="custom-control-label" for="Produto">Produto</label>
													</div>
												</div>
												<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
													<div class="custom-control custom-radio">
														<input type="radio" name="SetBusca" class="custom-control-input " id="SetPromocao" value="PM">
														<label class="custom-control-label" for="Promocao">Promoção</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpaBuscaProduto(), limpaBuscaPromocao()">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<input class="form-control input-produto" type="text" name="Produto" id="Produto2" maxlength="255" placeholder="Busca Produto">
											<input class="form-control input-promocao" type="text" name="Promocao" id="Promocao" maxlength="255" placeholder="Busca Promoção">
										</div>
									</div>
								</div>
								<div class="modal-body">
									<div class="input_fields_produtos"></div>
									<div class="input_fields_promocao"></div>
								</div>
								<div class="modal-footer">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
											<div class="form-footer ">
												<button type="button" class="btn btn-primary" data-dismiss="modal" name="botaoFecharBusca" id="botaoFecharBusca" onclick="limpaBuscaProduto(), limpaBuscaPromocao()">
													<span class="glyphicon glyphicon-remove"></span> Fechar
												</button>
											</div>
										</div>
									</div>
									<!--
									<div class="row">	
										<div class="col-md-12 text-left">
											<label for="Ordenamento">Ordenamento:</label>
											<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen " 
																id="Campo" name="Campo">
															<?php
															/*
															foreach ($select['Campo'] as $key => $row) {
																if ($query['Campo'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															*/
															?>
														</select>
													</div>

													<div class="col-md-4">
														<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen" 
																id="Ordenamento" name="Ordenamento">
															<?php
															/*
															foreach ($select['Ordenamento'] as $key => $row) {
																if ($query['Ordenamento'] == $key) {
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
											</div>
										</div>
									</div>
									-->
								</div>									
							</div>								
						</div>
					</div>
					
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
									</form>
								</div>
							</div>
						</div>
					</div>				
				</div>
				</form>	
			</div>
		</div>
	</div>
</section>