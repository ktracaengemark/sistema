
<div class="col-md-1"></div>
<div class="col-md-10">
	
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<?php echo form_open('tarefa', 'role="form"'); ?>
				<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>				
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group text-left">
							<label class="" for="Compartilhar">Quem Fazer</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
									id="Compartilhar" name="Compartilhar">
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
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group  text-left">
							<label  class="" for="NomeProfissional">Quem Cadastrou?</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
									id="NomeProfissional" name="NomeProfissional">
								<?php
								foreach ($select['NomeProfissional'] as $key => $row) {
									if ($query['NomeProfissional'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
										}
								}
								?>
							</select>
						</div>
				<?php }else { ?>
					<input type="hidden" name="NomeProfissional" id="NomeProfissional" value="">
					<input type="hidden" name="Compartilhar" id="Compartilhar" value="">
				<?php } ?>
				
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
				
					<label  class="" for="">Ações</label>
					<div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
						<span class="input-group-btn">
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
							
								<a class="btn btn-md btn-danger" href="<?php echo base_url() ?>tarefa/cadastrar" role="button"> 
									<span class="glyphicon glyphicon-plus"></span>Nova
								</a>
							
							<?php } ?>
							<a type="button" class="btn btn-md btn-warning" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>Filtrar
							</a>
							<a type="button"  class="btn btn-md btn-info" href="<?php echo base_url() ?>relatorio/tarefa" role="button">
								<span class="glyphicon glyphicon-pencil"></span>Relatório
							</a>
						</span>
					</div>	
				</div>
			</div>
		</div>
															
		<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtro de Tarefas</h4>
					</div>
					<div class="modal-footer">
						<div class="form-group">	
							<div class="row">	
								<div class="col-md-3 text-left">
									<label for="idTab_Categoria">Categoria:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
											id="idTab_Categoria" name="idTab_Categoria">
										<?php
										foreach ($select['idTab_Categoria'] as $key => $row) {
											if ($query['idTab_Categoria'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="ConcluidoTarefa">Concluído</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
											id="ConcluidoTarefa" name="ConcluidoTarefa">
										<?php
										foreach ($select['ConcluidoTarefa'] as $key => $row) {
											if ($query['ConcluidoTarefa'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<br>
							<div class="row text-left">
								<div class="col-md-3">
									<label for="DataInicio">Inciar (de:).</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim">Iniciar (até:)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataInicio2">Concl (de:)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim2">Concl (até:)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
												name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
									</div>
								</div>
							</div>
							<br>
							<div class="row">	
								<div class="col-md-6 text-left">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
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
											<div class="col-md-6">
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
							<br>
							<div class="row">
								<div class="form-group col-md-3 text-left">
									<div class="form-footer ">
										<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
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
		<?php if (isset($msg)) echo $msg; ?>
		<div <?php echo $collapse; ?> id="Tarefas">	
			<div class="panel-body">
				
				<?php echo (isset($list1)) ? $list1 : FALSE ?>
			</div>
		</div>
	</div>

</div>
