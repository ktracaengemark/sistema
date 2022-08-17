<?php if ($msg) echo $msg; ?>
<?php echo form_open($form_open_path, 'role="form"'); ?>
<div class="col-md-12">
	<?php echo validation_errors(); ?>
	<?php if($paginacao == "N") { ?>
		<div class="panel panel-<?php echo $panel; ?>">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-2 text-left">
						<label>id <?php echo $titulo1;?></label>
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
									<span class="glyphicon glyphicon-search"></span> 
								</button>
							</span>
							<input type="text" placeholder="Pesquisar <?php echo $titulo1;?>" class="form-control Numero btn-sm" name="Orcamento" id="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
						</div>
						<input type="hidden" name="idApp_Procedimento" id="idApp_Procedimento" value="">
					</div>
					<?php if($_SESSION['log']['idSis_Empresa'] != "5") {?>
						<div class="col-md-4 text-left">
							<label  ><?php echo $nome; ?>: </label>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								<input type="text" name="id_<?php echo $nome; ?>_Auto" id="id_<?php echo $nome; ?>_Auto" value="<?php echo $cadastrar['id_'.$nome.'_Auto']; ?>" class="form-control" placeholder="Pesquisar <?php echo $nome; ?>">
								<?php if($metodo == 2) {?>
									<input type="hidden" placeholder="Pesquisar <?php echo $nome; ?>" class="form-control Numero btn-sm" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value="<?php echo set_value($nome, $query[$nome]); ?>">
								<?php } ?>	
							</div>
							<span class="modal-title" id="Nome<?php echo $nome; ?>Auto1"><?php echo $cadastrar['Nome'.$nome.'Auto']; ?></span>
							<input type="hidden" id="Nome<?php echo $nome; ?>Auto" name="Nome<?php echo $nome; ?>Auto" value="<?php echo $cadastrar['Nome'.$nome.'Auto']; ?>" />
							<input type="hidden" id="Hidden_id_<?php echo $nome; ?>_Auto" name="Hidden_id_<?php echo $nome; ?>_Auto" value="<?php echo $query['idApp_'.$nome]; ?>" />
							<input type="hidden" name="idApp_<?php echo $nome; ?>" id="idApp_<?php echo $nome; ?>" value="<?php echo $query['idApp_'.$nome]; ?>" class="form-control" readonly= "">
						</div>
					<?php }else{ ?>
						<input type="hidden" name="idApp_<?php echo $nome; ?>" id="idApp_<?php echo $nome; ?>" value=""/>
						<input type="hidden" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" value=""/>
					<?php } ?>
					<input type="hidden" name="idTab_TipoRD" id="idTab_TipoRD" value="<?php echo $TipoRD; ?>"/>

					<div class="col-md-3 text-left">
						<label for="NomeUsuario">Quem Cadastrou:</label>
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
									<span class="glyphicon glyphicon-search"></span> 
								</button>
							</span>
							<select data-placeholder="Selecione uma opção..." class="form-control" id="NomeUsuario" name="NomeUsuario">
								<?php
								foreach ($select['NomeUsuario'] as $key => $row) {
									if ($query['NomeUsuario'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>	
					</div>
					<div class="col-md-3 text-left">
						<label for="Compartilhar">Quem Fazer:</label>
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-<?php echo $panel; ?> btn-md" type="submit">
									<span class="glyphicon glyphicon-search"></span> 
								</button>
							</span>
							<select data-placeholder="Selecione uma opção..." class="form-control" id="Compartilhar" name="Compartilhar">
								<?php
								foreach ($select['Compartilhar'] as $key => $row) {
									if ($query['Compartilhar'] == $key) {
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
				<div class="row">
					<div class="col-md-1">
						<label></label><br>
						<button class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span>Filtros
						</button>
					</div>
					<?php if ($print == 1) { ?>	
						<div class="col-md-1">
							<label></label><br>
							<a href="<?php echo base_url() . $imprimirlista . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-<?php echo $panel; ?> btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-print"></span>Imprimir
								</button>
							</a>
						</div>
					<?php } ?>
					<?php if ($editar == 1) { ?>	
						<div class="col-md-1">
							<label></label><br>
							<a href="<?php echo base_url() . $alterarparc . $_SESSION['log']['idSis_Empresa']; ?>">
								<button class="btn btn-success btn-md btn-block" type="button">
									<span class="glyphicon glyphicon-edit"></span>Editar
								</button>
							</a>
						</div>	
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro dos Procedimentos</h4>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<div class="panel panel-<?php echo $panel; ?>">
								<div class="panel-heading text-left">
									<div class="row">
										<div class="col-md-3 text-left">
											<label for="ConcluidoProcedimento">Concluido:</label>
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
										<div class="col-md-3 text-left">
											<label for="Agrupar">Agrupar Por:</label>
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
													id="Agrupar" name="Agrupar">
												<?php
												foreach ($select['Agrupar'] as $key => $row) {
													if ($query['Agrupar'] == $key) {
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
							<div class="panel panel-<?php echo $panel; ?>">
								<div class="panel-heading text-left">
									<div class="row">
										<div class="col-md-3">
											<label for="DataInicio9">Data Proc. de <?php echo $titulo1;?> Inc.</label>
											<div class="input-group DatePicker">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataInicio9" value="<?php echo set_value('DataInicio9', $query['DataInicio9']); ?>">
											</div>
										</div>
										<div class="col-md-3">
											<label for="DataFim9">Data Proc. de <?php echo $titulo1;?> Fim</label>
											<div class="input-group DatePicker">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														name="DataFim9" value="<?php echo set_value('DataFim9', $query['DataFim9']); ?>">
											</div>
										</div>
										<div class="col-md-3">
											<label for="HoraInicio9">Hora Proc. de <?php echo $titulo1;?> Inc.</label>
											<div class="input-group TimePicker">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-time"></span>
												</span>
												<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM"
														name="HoraInicio9" value="<?php echo set_value('HoraInicio9', $query['HoraInicio9']); ?>">
											</div>
										</div>
										<div class="col-md-3">
											<label for="HoraFim9">Hora Proc. de <?php echo $titulo1;?> Fim</label>
											<div class="input-group TimePicker">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-time"></span>
												</span>
												<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM"
														name="HoraFim9" value="<?php echo set_value('HoraFim9', $query['HoraFim9']); ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-<?php echo $panel; ?>">
								<div class="panel-heading text-left">
									<div class="row">
										<div class="col-md-9 text-left">
											<label for="Ordenamento">Ordenamento:</label>
											<div class="form-group btn-block">
												<div class="row">
													<div class="col-md-4">
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen" 
																id="Campo" name="Campo"><!--onchange="this.form.submit()" -->
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
																id="Ordenamento" name="Ordenamento"><!--onchange="this.form.submit()" -->
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
			</div>
		</div>
	<?php } ?>
	<?php echo (isset($list)) ? $list : FALSE ?>
</div>	
</form>		

