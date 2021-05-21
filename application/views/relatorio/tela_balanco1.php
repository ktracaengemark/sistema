<?php if ($msg) echo $msg; ?>
<div class="col-md-1"></div>
<div class="col-md-10">
	<div class="row">

		<div class="main">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<?php echo form_open('relatorio/balanco', 'role="form"'); ?>
					<?php #echo $titulo; ?>						
					
					<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
						<span class="glyphicon glyphicon-search"></span> Balanco Anual
					</button>										

				</div>
				<div class="panel-body">	
					<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-md " role="document">
							<div class="modal-content">
								<div class="modal-header bg-danger">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro por Ano</h4>
								</div>
								<div class="modal-footer">
									<div class="form-group text-left">
										<div class="row">                           								
											<div class="col-md-3">
												<div>
													<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
														   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
												</div>
											</div>								
										</div>
										<div class="row">
											<br>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button class="btn btn-success btn-block" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-filter"></span> Filtrar
													</button>
												</div>
											</div>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"></span> Fechar
													</button>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php echo (isset($list)) ? $list : FALSE ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-1"></div>
