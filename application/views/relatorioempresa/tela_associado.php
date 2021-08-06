<?php if ($msg) echo $msg; ?>

<div class="col-md-offset-3 col-md-6">

	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo form_open('relatorioempresa/associado', 'role="form"'); ?>
			
			
			<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-search"></span><?php echo $titulo; ?>
			</button>
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorioempresa/empresas" role="button">
				<span class="glyphicon glyphicon-search"></span>Empresas
			</a>
			<!--
			<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
			-->
		</div>

		<div class="panel-body">
			<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Evite cadastrar Empresas REPETIDAS!<br>
													"Pesquise"as Empresas Cadastradas!</h4>
						</div>
						<!--
						<div class="modal-body">
							<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
								Esta operação é irreversível.</p>
						</div>
						-->
						<div class="modal-footer">
							<div class="form-group col-md-4 text-left">
								<div class="form-footer">
									<button  class="btn btn-warning btn-block"" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
							</div>
							<div class="form-group col-md-4 text-right">
								<div class="form-footer">		
									<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>loginempresa/registrar2" role="button">
										<span class="glyphicon glyphicon-plus"></span> Novo Associado
									</a>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros das Empresas</h4>
						</div>
						<div class="modal-footer">
							<div class="form-group">	
								<div class="row">
									<div class="col-md-4 text-left">
										<label for="Ordenamento">Empresa:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
									<div class="col-md-4 text-left">
										<label for="Ordenamento">Categoria:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
								<div class="row">		
									<div class="col-md-8 text-left">
										<label for="Ordenamento">Atuação:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
												id="Atuacao" name="Atuacao">
											<?php
											foreach ($select['Atuacao'] as $key => $row) {
												if ($query['Atuacao'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>										
								<div class="row">
									<br>
									<div class="form-group col-md-4 text-left">
										<div class="form-footer ">
											<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
												<span class="glyphicon glyphicon-filter"></span> Filtrar
											</button>
										</div>
									</div>
									<div class="form-group col-md-4 text-left">
										<div class="form-footer ">
											<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
												<span class="glyphicon glyphicon-remove"> Fechar
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
													<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen " 
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
													<select data-placeholder="Selecione uma opção..." class="form-control btn-block Chosen" 
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
		<?php echo (isset($list)) ? $list : FALSE ?>
		
		</div>
		
	</div>

</div>