
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
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" onchange="this.form.submit()"
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
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" onchange="this.form.submit()"
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
				
					<label  class="" for="">A��es</label>
					<div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
						<!--
						<span class="input-group-btn">	
							<div class=" btn btn-success" type="button" data-toggle="collapse" data-target="#Tarefas" aria-expanded="false" aria-controls="Tarefas">
								<span class="glyphicon glyphicon-chevron-down"></span> Tarefas
							</div>
						</span>
						-->
							<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
							<span class="input-group-btn">
								<a class="btn btn-md btn-danger" href="<?php echo base_url() ?>tarefa/cadastrar" role="button"> 
									<span class="glyphicon glyphicon-plus"></span>Nova
								</a>
							</span>
							<?php } ?>
						<span class="input-group-btn">
							<a type="button" class="btn btn-md btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>Filtrar
							</a>
							<!--
							<button type="button" class="btn btn-md btn-warning dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">							
								<li>
									<a class="dropdown-item" href="<?php echo base_url() ?>relatorio/tarefa" role="button">
										<span class="glyphicon glyphicon-pencil"></span> Estat�stica das Tarefas
									</a>
								</li>					
								
								<li>
									<a class="dropdown-item" href="<?php echo base_url() . 'orcatrata/alterarprocedimento/' . $_SESSION['log']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-pencil"></span> Editar Tarefas Filtradas
									</a>
								</li>
								
							</ul>
							-->
						</span>
						<!--
						<span class="input-group-btn">
							<a class="btn btn-md btn-success" href="<?php echo base_url() . 'orcatrata/alterarprocedimento/' . $_SESSION['log']['idSis_Empresa']; ?>">
								<span class="glyphicon glyphicon-pencil"></span>Editar
							</a>
						</span>	
						-->
					</div>	
				</div>
				
				<!--
				<button  class="btn btn-md btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-filter"></span>Filtrar
				</button>
				<a href="<?php echo base_url() . 'orcatrata/alterarprocedimento/' . $_SESSION['log']['idSis_Empresa']; ?>">
					<button type="button" class="btn btn-md btn-info">
						<span class="glyphicon glyphicon-edit"></span> Editar
					</button>
				</a>
				-->
				<!--<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorio/alterarprocedimento" role="button"> 
					<span class="glyphicon glyphicon-ok"></span> Edit Todas
				</a>-->	
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
									<label for="Ordenamento">Categoria:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
											id="Categoria" name="Categoria">
										<?php
										foreach ($select['Categoria'] as $key => $row) {
											if ($query['Categoria'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<!--
								<div class="col-md-3 text-left">
									<label for="Prioridade">Prioridade</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
											id="Prioridade" name="Prioridade">
										<?php
										/*
										foreach ($select['Prioridade'] as $key => $row) {
											if ($query['Prioridade'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										*/
										?>
									</select>
								</div>
								<div class="col-md-3 text-left">
									<label for="Statustarefa">StsTarefa</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
											id="Statustarefa" name="Statustarefa">
										<?php
										/*
										foreach ($select['Statustarefa'] as $key => $row) {
											if ($query['Statustarefa'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										*/
										?>
									</select>
								</div>
								
								<div class="col-md-2 text-left">
									<label for="SubPrioridade">SubPri</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
											id="SubPrioridade" name="SubPrioridade">
										<?php
										/*
										foreach ($select['SubPrioridade'] as $key => $row) {
											if ($query['SubPrioridade'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										*/
										?>
									</select>
								</div>
								<div class="col-md-2 text-left">
									<label for="Statussubtarefa">SubSts</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
											id="Statussubtarefa" name="Statussubtarefa">
										<?php
										/*
										foreach ($select['Statussubtarefa'] as $key => $row) {
											if ($query['Statussubtarefa'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										*/
										?>
									</select>
								</div>
								-->
								
								<div class="col-md-3 text-left">
									<label for="ConcluidoProcedimento">Conclu�do</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
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
								<!--
								<div class="col-md-3 text-left">
									<label for="ConcluidoSubProcedimento">St SubTarefa</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block"
											id="ConcluidoSubProcedimento" name="ConcluidoSubProcedimento">
										<?php
										foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
											if ($query['ConcluidoSubProcedimento'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								-->
							</div>
							<!--
							<div class="row">								
								<div class="col-md-10 text-left">
									<label for="Ordenamento">Tarefa:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
											id="Procedimento" name="Procedimento">
										<?php
										foreach ($select['Procedimento'] as $key => $row) {
											if ($query['Procedimento'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							-->
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
									<label for="DataFim">Iniciar (at�:)</label>
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
									<label for="DataFim2">Concl (at�:)</label>
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
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
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
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" 
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
							<!--
							<div class="row">	
								<div class="col-md-3 text-left" >
									<label for="Ordenamento">Dia:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
									<label for="Ordenamento">M�s:</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen btn-block" 
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
							-->
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
