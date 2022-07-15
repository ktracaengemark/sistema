<?php if ($msg) echo $msg; ?>

	<div class="col-md-3"></div>
	<div class="col-md-6">		
		<div class="row">
			<div class="main">
				<?php echo validation_errors(); ?>
				<div class="panel panel-primary">
					<div class="panel-heading">
					
						<?php echo form_open('relatorio/alterarprocedimento', 'role="form"'); ?>
						<!--	
						<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span> Pesq.
						</button>
						-->
						<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-search"></span> <?php echo $titulo; ?>
						</button>
						<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/procedimento" role="button"> 
							<span class="glyphicon glyphicon-ok"></span> Edit Indiv.
						</a>											
						<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button"> 
							<span class="glyphicon glyphicon-plus"></span> Nova
						</a>
					
					</div>
					<div class="panel-body">
												
						<div class="col-md-8">
							<div class="form-group">
																									
								<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtrar Todas</h4>
											</div>
											<div class="modal-footer">
												<div class="form-group">	
													<div class="row">														
														<div class="col-md-3 text-left">
															<label for="ConcluidoProcedimento">Concluido?</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
																	id="ConcluidoProcedimento" name="ConcluidoProcedimento">
																<?php
																foreach ($select['ConcluidoProcedimento'] as $key => $row) {
																	if ($query['ConcluidoProcedimento'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-3 text-left" >
															<label for="Ordenamento">Dia:</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
																	id="Dia" name="Dia">
																<?php
																foreach ($select['Dia'] as $key => $row) {
																	if ($query['Dia'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-3 text-left" >
															<label for="Ordenamento">Mês:</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
																	id="Mesvenc" name="Mesvenc">
																<?php
																foreach ($select['Mesvenc'] as $key => $row) {
																	if ($query['Mesvenc'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-3 text-left" >
															<label for="Ordenamento">Ano:</label>
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
													<div class="row">	
														<div class="col-md-9 text-left">
															<label for="Ordenamento">Ordenamento:</label>
															<div class="form-group btn-block">
																<div class="row">
																	<div class="col-md-8">
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
							</div>
						</div>
						</form>

						<?php echo (isset($list)) ? $list : FALSE ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>	

