		<div class="row">	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 text-left">
								<label><?php echo $titulo;?></label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-primary btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" class="form-control Numero" placeholder="Nº Pedido" name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
								</div>
							</div>
							<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
								<input type="hidden" class="form-control Numero" placeholder="Pesquisar Cliente"  name="Cliente" value="<?php echo set_value('Cliente', $query['Cliente']); ?>">
								<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5 text-left">
									<label  >Cliente:</label>
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-primary btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
										<input type="text" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
										
									</div>
									<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
									<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
									<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
									<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
								</div>
							<?php }else{ ?>
								<input type="hidden" name="Cliente" id="Cliente" value=""/>
							<?php } ?>
							<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ">
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
										<label>Filtros</label>
										<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
											<span class="glyphicon glyphicon-filter"></span>
										</button>
									</div>
									<?php if($_SESSION['log']['idSis_Empresa'] == 5){ ?>
										<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 ">
											<label>Cadastrar Pedido</label>	
											<a class="btn btn-md btn-primary btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar3" role="button"> 
												<span class="glyphicon glyphicon-plus"></span> Nova Venda / Receita
											</a>
										</div>
									<?php }else{ ?>
										<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
											<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 ">
												<label>Cadastrar Pedido</label>	
												<a class="btn btn-md btn-primary btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar3" role="button"> 
													<span class="glyphicon glyphicon-plus"></span> Nova Venda / Receita
												</a>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<?php if ($msg) {?>
			<div class="row">
				<div class="col-md-12">
					<?php echo $msg; ?>
				</div>
			</div>
		<?php } ?>
	

