<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryUsuario'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-10">
						<?php echo form_open_multipart($form_open_path); ?>	
						<?php #echo validation_errors(); ?>
						<div class="panel panel-<?php echo $panel; ?>">
							<div class="panel-heading">
								<?php echo $titulo; ?>
							</div>
							<div class="panel-body">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Horário de Atendimento</h4>
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Horario_Atend">Verificar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Horario_Atend'] as $key => $row) {
															(!$query['Horario_Atend']) ? $query['Horario_Atend'] = 'N' : FALSE;

															if ($query['Horario_Atend'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Horario_Atend" id="radiobutton_Horario_Atend' . $key . '">'
																. '<input type="radio" name="Horario_Atend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Horario_Atend" id="radiobutton_Horario_Atend' . $key . '">'
																. '<input type="radio" name="Horario_Atend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Agendamentos</h4>
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Cad_Agend">Cadastrar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Cad_Agend'] as $key => $row) {
															(!$query['Cad_Agend']) ? $query['Cad_Agend'] = 'N' : FALSE;

															if ($query['Cad_Agend'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Cad_Agend" id="radiobutton_Cad_Agend' . $key . '">'
																. '<input type="radio" name="Cad_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Cad_Agend" id="radiobutton_Cad_Agend' . $key . '">'
																. '<input type="radio" name="Cad_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Ver_Agend">Ver?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Ver_Agend'] as $key => $row) {
															(!$query['Ver_Agend']) ? $query['Ver_Agend'] = 'N' : FALSE;

															if ($query['Ver_Agend'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Ver_Agend" id="radiobutton_Ver_Agend' . $key . '">'
																. '<input type="radio" name="Ver_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Ver_Agend" id="radiobutton_Ver_Agend' . $key . '">'
																. '<input type="radio" name="Ver_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Edit_Agend">Editar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Edit_Agend'] as $key => $row) {
															(!$query['Edit_Agend']) ? $query['Edit_Agend'] = 'N' : FALSE;

															if ($query['Edit_Agend'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Edit_Agend" id="radiobutton_Edit_Agend' . $key . '">'
																. '<input type="radio" name="Edit_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Edit_Agend" id="radiobutton_Edit_Agend' . $key . '">'
																. '<input type="radio" name="Edit_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Delet_Agend">Deletar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Delet_Agend'] as $key => $row) {
															(!$query['Delet_Agend']) ? $query['Delet_Agend'] = 'N' : FALSE;

															if ($query['Delet_Agend'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Delet_Agend" id="radiobutton_Delet_Agend' . $key . '">'
																. '<input type="radio" name="Delet_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Delet_Agend" id="radiobutton_Delet_Agend' . $key . '">'
																. '<input type="radio" name="Delet_Agend" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
												<label for="Permissao_Agend">Acesso Agend.</label>		
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Permissao_Agend" name="Permissao_Agend">
													<option value="">- Selec. Permissão-</option>	
													<?php
													foreach ($select['Permissao_Agend'] as $key => $row) {
														if ($query['Permissao_Agend'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('Permissao_Agend'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Orçamentos</h4>
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Cad_Orcam">Cadastrar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Cad_Orcam'] as $key => $row) {
															(!$query['Cad_Orcam']) ? $query['Cad_Orcam'] = 'N' : FALSE;

															if ($query['Cad_Orcam'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Cad_Orcam" id="radiobutton_Cad_Orcam' . $key . '">'
																. '<input type="radio" name="Cad_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Cad_Orcam" id="radiobutton_Cad_Orcam' . $key . '">'
																. '<input type="radio" name="Cad_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Ver_Orcam">Ver?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Ver_Orcam'] as $key => $row) {
															(!$query['Ver_Orcam']) ? $query['Ver_Orcam'] = 'N' : FALSE;

															if ($query['Ver_Orcam'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Ver_Orcam" id="radiobutton_Ver_Orcam' . $key . '">'
																. '<input type="radio" name="Ver_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Ver_Orcam" id="radiobutton_Ver_Orcam' . $key . '">'
																. '<input type="radio" name="Ver_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Edit_Orcam">Editar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Edit_Orcam'] as $key => $row) {
															(!$query['Edit_Orcam']) ? $query['Edit_Orcam'] = 'N' : FALSE;

															if ($query['Edit_Orcam'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Edit_Orcam" id="radiobutton_Edit_Orcam' . $key . '">'
																. '<input type="radio" name="Edit_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Edit_Orcam" id="radiobutton_Edit_Orcam' . $key . '">'
																. '<input type="radio" name="Edit_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Delet_Orcam">Deletar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Delet_Orcam'] as $key => $row) {
															(!$query['Delet_Orcam']) ? $query['Delet_Orcam'] = 'N' : FALSE;

															if ($query['Delet_Orcam'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Delet_Orcam" id="radiobutton_Delet_Orcam' . $key . '">'
																. '<input type="radio" name="Delet_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Delet_Orcam" id="radiobutton_Delet_Orcam' . $key . '">'
																. '<input type="radio" name="Delet_Orcam" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
												<label for="Permissao_Orcam">Acesso Orcam.</label>		
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Permissao_Orcam" name="Permissao_Orcam">
													<option value="">- Selec. Permissão-</option>	
													<?php
													foreach ($select['Permissao_Orcam'] as $key => $row) {
														if ($query['Permissao_Orcam'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('Permissao_Orcam'); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Baixa</h4>
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Bx_Orc">Orçamentos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Bx_Orc'] as $key => $row) {
															(!$query['Bx_Orc']) ? $query['Bx_Orc'] = 'N' : FALSE;

															if ($query['Bx_Orc'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Bx_Orc" id="radiobutton_Bx_Orc' . $key . '">'
																. '<input type="radio" name="Bx_Orc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Bx_Orc" id="radiobutton_Bx_Orc' . $key . '">'
																. '<input type="radio" name="Bx_Orc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Bx_Pag">Pagamentos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Bx_Pag'] as $key => $row) {
															(!$query['Bx_Pag']) ? $query['Bx_Pag'] = 'N' : FALSE;

															if ($query['Bx_Pag'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Bx_Pag" id="radiobutton_Bx_Pag' . $key . '">'
																. '<input type="radio" name="Bx_Pag" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Bx_Pag" id="radiobutton_Bx_Pag' . $key . '">'
																. '<input type="radio" name="Bx_Pag" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Bx_Prd">Produtos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Bx_Prd'] as $key => $row) {
															(!$query['Bx_Prd']) ? $query['Bx_Prd'] = 'N' : FALSE;

															if ($query['Bx_Prd'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Bx_Prd" id="radiobutton_Bx_Prd' . $key . '">'
																. '<input type="radio" name="Bx_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Bx_Prd" id="radiobutton_Bx_Prd' . $key . '">'
																. '<input type="radio" name="Bx_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Bx_Prc">Procedimentos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Bx_Prc'] as $key => $row) {
															(!$query['Bx_Prc']) ? $query['Bx_Prc'] = 'N' : FALSE;

															if ($query['Bx_Prc'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Bx_Prc" id="radiobutton_Bx_Prc' . $key . '">'
																. '<input type="radio" name="Bx_Prc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Bx_Prc" id="radiobutton_Bx_Prc' . $key . '">'
																. '<input type="radio" name="Bx_Prc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Produtos</h4>
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Cad_Prd">Cadastrar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Cad_Prd'] as $key => $row) {
															(!$query['Cad_Prd']) ? $query['Cad_Prd'] = 'N' : FALSE;

															if ($query['Cad_Prd'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Cad_Prd" id="radiobutton_Cad_Prd' . $key . '">'
																. '<input type="radio" name="Cad_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Cad_Prd" id="radiobutton_Cad_Prd' . $key . '">'
																. '<input type="radio" name="Cad_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Ver_Prd">Ver?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Ver_Prd'] as $key => $row) {
															(!$query['Ver_Prd']) ? $query['Ver_Prd'] = 'N' : FALSE;

															if ($query['Ver_Prd'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Ver_Prd" id="radiobutton_Ver_Prd' . $key . '">'
																. '<input type="radio" name="Ver_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Ver_Prd" id="radiobutton_Ver_Prd' . $key . '">'
																. '<input type="radio" name="Ver_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Edit_Prd">Editar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Edit_Prd'] as $key => $row) {
															(!$query['Edit_Prd']) ? $query['Edit_Prd'] = 'N' : FALSE;

															if ($query['Edit_Prd'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Edit_Prd" id="radiobutton_Edit_Prd' . $key . '">'
																. '<input type="radio" name="Edit_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Edit_Prd" id="radiobutton_Edit_Prd' . $key . '">'
																. '<input type="radio" name="Edit_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Delet_Prd">Deletar?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Delet_Prd'] as $key => $row) {
															(!$query['Delet_Prd']) ? $query['Delet_Prd'] = 'N' : FALSE;

															if ($query['Delet_Prd'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Delet_Prd" id="radiobutton_Delet_Prd' . $key . '">'
																. '<input type="radio" name="Delet_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Delet_Prd" id="radiobutton_Delet_Prd' . $key . '">'
																. '<input type="radio" name="Delet_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4>Relatórios</h4>
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Rel_Orc">Orçamentos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Rel_Orc'] as $key => $row) {
															(!$query['Rel_Orc']) ? $query['Rel_Orc'] = 'N' : FALSE;

															if ($query['Rel_Orc'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Rel_Orc" id="radiobutton_Rel_Orc' . $key . '">'
																. '<input type="radio" name="Rel_Orc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Rel_Orc" id="radiobutton_Rel_Orc' . $key . '">'
																. '<input type="radio" name="Rel_Orc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Rel_Pag">Pagamentos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Rel_Pag'] as $key => $row) {
															(!$query['Rel_Pag']) ? $query['Rel_Pag'] = 'N' : FALSE;

															if ($query['Rel_Pag'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Rel_Pag" id="radiobutton_Rel_Pag' . $key . '">'
																. '<input type="radio" name="Rel_Pag" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Rel_Pag" id="radiobutton_Rel_Pag' . $key . '">'
																. '<input type="radio" name="Rel_Pag" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Rel_Prd">Produtos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Rel_Prd'] as $key => $row) {
															(!$query['Rel_Prd']) ? $query['Rel_Prd'] = 'N' : FALSE;

															if ($query['Rel_Prd'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Rel_Prd" id="radiobutton_Rel_Prd' . $key . '">'
																. '<input type="radio" name="Rel_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Rel_Prd" id="radiobutton_Rel_Prd' . $key . '">'
																. '<input type="radio" name="Rel_Prd" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Rel_Prc">Procedimentos?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Rel_Prc'] as $key => $row) {
															(!$query['Rel_Prc']) ? $query['Rel_Prc'] = 'N' : FALSE;

															if ($query['Rel_Prc'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Rel_Prc" id="radiobutton_Rel_Prc' . $key . '">'
																. '<input type="radio" name="Rel_Prc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Rel_Prc" id="radiobutton_Rel_Prc' . $key . '">'
																. '<input type="radio" name="Rel_Prc" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>
											</div>
										</div>											
										<div class="row">
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Rel_Est">Estatísticas?</label><br>
												<div class="form-group">
													<div class="btn-larg-right btn-group" data-toggle="buttons">
														<?php
														foreach ($select['Rel_Est'] as $key => $row) {
															(!$query['Rel_Est']) ? $query['Rel_Est'] = 'N' : FALSE;

															if ($query['Rel_Est'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radiobutton_Rel_Est" id="radiobutton_Rel_Est' . $key . '">'
																. '<input type="radio" name="Rel_Est" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radiobutton_Rel_Est" id="radiobutton_Rel_Est' . $key . '">'
																. '<input type="radio" name="Rel_Est" id="radiobutton" '
																. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>
													</div>
												</div>	
											</div>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<label for="Rel_Com">Comissões?</label><br>
												<div class="btn-larg-right btn-group" data-toggle="buttons">
													<?php
													foreach ($select['Rel_Com'] as $key => $row) {
														if (!$query['Rel_Com'])$query['Rel_Com'] = 'N';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($query['Rel_Com'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="Rel_Com_' . $hideshow . '">'
															. '<input type="radio" name="Rel_Com" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="Rel_Com_' . $hideshow . '">'
															. '<input type="radio" name="Rel_Com" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
												<div id="Rel_Com" <?php echo $div['Rel_Com']; ?>>
													<label for="Permissao_Comissao">Acesso Comissao</label>		
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Permissao_Comissao" name="Permissao_Comissao">
														<option value="">- Selec. Permissão-</option>	
														<?php
														foreach ($select['Permissao_Comissao'] as $key => $row) {
															if ($query['Permissao_Comissao'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
													<?php echo form_error('Permissao_Comissao'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
										<!--<input type="hidden" name="idSis_Empresa" value="<?php #echo $query['idSis_Empresa']; ?>">-->
										<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
											<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						</form>	
					</div>
				</div>	
			</div>		
		</div>	
	</div>
<?php } ?>