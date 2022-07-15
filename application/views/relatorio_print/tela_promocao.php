<?php if (isset($msg)) echo $msg; ?>

<div class="col-md-12 ">		
	
	<?php echo validation_errors(); ?>
		
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="btn-group " role="group" aria-label="...">
				<div class="row text-left">	
					<div class="col-md-12">
						<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span>Filtro de Promoções
						</button>
						<!--
						<a class="btn btn-sm btn-info " href="<?php echo base_url() ?>relatorio/precopromocao" role="button">
							<span class="glyphicon glyphicon-pencil"></span> Lista de Preços
						</a>
						-->
						<a class="btn btn-sm btn-info " href="<?php echo base_url() ?>relatorio/produtos" role="button">
							<span class="glyphicon glyphicon-pencil"></span> Lista de Produtos
						</a>
						<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span> Nova Promoção
						</button>
					</div>
				</div>	
			</div>			
		</div>		
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</div>
<?php echo form_open('relatorio/promocao', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Promocoes</h4>
			</div>
			<div class="modal-footer">
				<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Ordenamento">Promocao</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
									id="Promocao" name="Promocao">
								<?php
								foreach ($select['Promocao'] as $key => $row) {
									if ($query['Promocao'] == $key) {
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
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Ordenamento">Produto</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
									id="Produtos" name="Produtos">
								<?php
								foreach ($select['Produtos'] as $key => $row) {
									if ($query['Produtos'] == $key) {
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
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Ordenamento">Ordenamento:</label>
							<div class="row">
								<div class="col-md-4">
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
				<?php } ?>
				<div class="row text-left">
					<br>
					<div class="form-group col-md-4">
						<div class="form-footer ">
							<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
					<!--
					<div class="form-group col-md-4">
						<div class="form-footer">		
							<a class="btn btn-warning btn-block" href="<?php echo base_url() ?>relatorio/estoque" role="button">
								<span class="glyphicon glyphicon-search"></span> Estoque
							</a>
						</div>	
					</div>
					-->
					<div class="form-group col-md-4">
						<div class="form-footer">		
							<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-plus"></span> Nova Promoção
							</button>							
						</div>	
					</div>
					<div class="form-group col-md-4">
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

<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Evite cadastrar Produtos REPETIDOS!<br>
										"Pesquise" os Produtos Cadastradas!</h4>
			</div>
			<!--
			<div class="modal-body">
				<p>Pesquise os Produtos Cadastrados!!</p>
			</div>
			-->
			<div class="modal-footer">
				<div class="form-group col-md-4 text-left">
					<div class="form-footer">
						<button  class="btn btn-info btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
					</div>
				</div>
				
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>promocao/cadastrar" role="button">
							<span class="glyphicon glyphicon-plus"></span> Nova Promocao
						</a>
					</div>	
				</div>
				
				<div class="form-group col-md-4">
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

