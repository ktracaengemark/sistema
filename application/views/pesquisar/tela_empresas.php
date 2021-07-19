<?php if ($msg) echo $msg; ?>
<section id="banner" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="bg-color">
		<div class="banner-info">
			<div class="row">
				<?php echo validation_errors(); ?>
					<?php #echo form_open(base_url() . 'empresacli0/pesquisar', 'class="navbar-form navbar-left"'); ?>
				<?php echo form_open(base_url() . 'empresacli0/pesquisar', 'role="form"'); ?>
				<div class="col-lg-offset-2 col-lg-8  col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
									<button  class="btn btn-sm btn-info btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
											<span class="glyphicon glyphicon-filter"></span> Filtrar<?php #echo $titulo; ?>
									</button>
								</div>
							</div>	
						</div>
						<div class="panel-body">			
							<?php echo (isset($list)) ? $list : FALSE ?>
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
										<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
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
									<!--
									<div class="row">		
										<div class="col-md-8 text-left">
											<label for="Ordenamento">Atuação:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
			</div>
		</div>
	</div>
</section>