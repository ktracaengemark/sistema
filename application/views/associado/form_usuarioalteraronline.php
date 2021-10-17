<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
				<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Empresa']['NomeEmpresa'] . '</small> - <small>Id.: ' . $_SESSION['Empresa']['idSis_Empresa'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'empresa/prontuario/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados da Empresa
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterar/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Dados da Empresa
									</a>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<?php } ?>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">	
							<?php #echo validation_errors(); ?>
							<div class="panel panel-<?php echo $panel; ?>">
								<div class="panel-body">
									<div class="panel panel-info">
										<div class="panel-heading">
											<div class="form-group">
												<div class="row">	
													<div class="col-md-4 panel-body">
														<div class="panel panel-warning">
															<div class="panel-heading">
																<div class="row">														
																	<div class="col-md-12">
																		<label>Colaborador - id.<?php echo $query['idSis_Usuario_Online']?>:</label><br>
																		<strong><?php echo $online['Nome']?></strong>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<label for="Inativo">Ativo?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['Inativo'] as $key => $row) {
																	(!$query['Inativo']) ? $query['Inativo'] = '0' : FALSE;

																	if ($query['Inativo'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																		. '<input type="radio" name="Inativo" id="radiobutton" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="radiobutton_Inativo" id="radiobutton_Inativo' . $key . '">'
																		. '<input type="radio" name="Inativo" id="radiobutton" '
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
									</div>
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idSis_Usuario_Online" value="<?php echo $query['idSis_Usuario_Online']; ?>">
											<?php if ($metodo == 2) { ?>
												<div class="col-md-6">
													<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
											<?php } else { ?>
												<div class="col-md-6">
													<button class="btn btn-sm btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
											<?php } ?>
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