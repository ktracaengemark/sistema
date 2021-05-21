<?php if ($msg) echo $msg; ?>


	<div class="col-md-3"></div>
	<div class="col-md-6 ">		
		
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong>
					
					<?php echo form_open('relatorioempresa/receitas', 'role="form"'); ?>
					
						<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span>Pesquise
						</button>
						<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span> Filtro
						</button>											
						<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span>Receita
						</button>					
										
					</div>
					<div class="panel-body">
						
						<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Antes de cadastrar uma<br>
																Nova Receita, "Pesquise"<br>
																as Receitas Cadastradas!</h4>
									</div>
									<!--
									<div class="modal-body">
										<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema. 
											Esta operação é irreversível.</p>
									</div>
									-->
									<div class="modal-footer">
										<div class="form-group col-md-3 text-left">
											<div class="form-footer">
												<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
													<span class="glyphicon glyphicon-search"></span> Pesquise
												</button>
											</div>
										</div>
										<div class="form-group col-md-3 text-left">
											<div class="form-footer">		
												<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>orcatratacli/cadastrar2" role="button">
													<span class="glyphicon glyphicon-plus"></span> Receita
												</a>
											</div>	
										</div>		
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
									</div>
									<div class="modal-footer">
											<div class="row">
												<div class="col-md-4 text-left" >
													<label for="Ordenamento">Mês do Vencimento:</label>
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
												<div class="col-md-4 text-left" >
													<label for="Ordenamento">Mês do Pagamento:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
															id="Mespag" name="Mespag">
														<?php
														foreach ($select['Mespag'] as $key => $row) {
															if ($query['Mespag'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-4 text-left" >
													<label for="Ordenamento">Ano:</label>
													<div>
														<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
															   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4 text-left">
													<label for="QuitadoOrca">Orçam. Quit?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
															id="QuitadoOrca" name="QuitadoOrca">
														<?php
														foreach ($select['QuitadoOrca'] as $key => $row) {
															if ($query['QuitadoOrca'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-4 text-left">
													<label for="QuitadoRecebiveis">Parc. Quit.?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
															id="QuitadoRecebiveis" name="QuitadoRecebiveis">
														<?php
														foreach ($select['QuitadoRecebiveis'] as $key => $row) {
															if ($query['QuitadoRecebiveis'] == $key) {
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
														<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
															<span class="glyphicon glyphicon-search"></span> Pesquisar
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
												<div class="col-md-4 text-left">
													<label for="Ordenamento">Nome do Cliente:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
															id="NomeCliente" name="NomeCliente">
														<?php
														foreach ($select['NomeCliente'] as $key => $row) {
															if ($query['NomeCliente'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-4 text-left">
													<label for="Ordenamento">Tipo de Receita:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
															id="TipoReceita" name="TipoReceita">
														<?php
														foreach ($select['TipoReceita'] as $key => $row) {
															if ($query['TipoReceita'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-4 text-left">
													<label for="Modalidade">Modalidade</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " 
															id="Modalidade" name="Modalidade">
														<?php
														foreach ($select['Modalidade'] as $key => $row) {
															if ($query['Modalidade'] == $key) {
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
												<div class="col-md-4 text-left">
													<label for="ConcluidoOrca">Prod.Entr.?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
															id="ConcluidoOrca" name="ConcluidoOrca">
														<?php
														foreach ($select['ConcluidoOrca'] as $key => $row) {
															if ($query['ConcluidoOrca'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												
												<div class="col-md-8 text-left">
													<label for="Ordenamento">Ordenamento:</label>
													<div class="form-group">
														<div class="row">
															<div class="col-md-6">
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

															<div class="col-md-6">
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
											<div class="row">	
												
												<div class="form-group col-md-4 text-left">
													<div class="form-footer ">
														<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
															<span class="glyphicon glyphicon-search"></span> Pesquisar
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
											<!--
											<div class="row">
												
												<div class="col-md-3">
													<label for="DataInicio3">Orç.- Data Inc.</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
														
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataFim3">Orç.- Data Fim</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
														
													</div>
												</div>
												
												<div class="col-md-3">
													<label for="DataInicio">Venc Dt Inc</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
														
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataFim">Venc Dt Fim</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
														
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataInicio2">Pago Dt. Inc</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
														
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataFim2">Pago Dt. Fim</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
														
													</div>
												</div>
											</div>
											-->
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
	<div class="col-md-3"></div>	

