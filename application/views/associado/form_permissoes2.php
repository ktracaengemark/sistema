<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Usuario'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-md-8">
		<?php echo form_open_multipart($form_open_path); ?>
			<?php #echo validation_errors(); ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-file"></span> <?php echo '<small>' . $_SESSION['Usuario']['Nome'] . '</small> - <small>Id.: ' . $_SESSION['Usuario']['idSis_Usuario'] . '</small>' ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a <?php if (preg_match("/usuario2\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
									<a href="<?php echo base_url() . 'usuario2/prontuario/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-file"> </span>Ver Dados do Usuário
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<?php if ($_SESSION['log']['idSis_Empresa'] == 5 ) { ?>
								<li>
									<a <?php if (preg_match("/usuario2\/permissoes\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
										<a href="<?php echo base_url() . 'usuario2/permissoes/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
											<span class="glyphicon glyphicon-edit"></span> Editar Permissões do Usuário
										</a>
									</a>
								</li>
								<li role="separator" class="divider"></li>
							<?php } ?>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarsenha\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarsenha/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Senha
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarconta\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarconta/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Editar Conta
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/usuario2\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'usuario2/alterarlogo/' . $_SESSION['Usuario']['idSis_Usuario']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Foto
									</a>
								</a>
							</li>									
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4>Orçamentos</h4>
							<div class="row">
								<div class="col-md-3">
									<label for="Cad_Orcam">Cadastrar?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
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
								<div class="col-md-3">
									<label for="Ver_Orcam">Ver?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
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
								<div class="col-md-3">
									<label for="Edit_Orcam">Editar?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
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
								<div class="col-md-3">
									<label for="Delet_Orcam">Deletar?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
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
							</div>
						</div>
					</div>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4>Relatórios</h4>
							<div class="row">
								<div class="col-md-3">
									<label for="Rel_Pag">Pagamentos?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
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
								<div class="col-md-3">
									<label for="Rel_Com">Comissões?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['Rel_Com'] as $key => $row) {
												(!$query['Rel_Com']) ? $query['Rel_Com'] = 'N' : FALSE;

												if ($query['Rel_Com'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="radiobutton_Rel_Com" id="radiobutton_Rel_Com' . $key . '">'
													. '<input type="radio" name="Rel_Com" id="radiobutton" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="radiobutton_Rel_Com" id="radiobutton_Rel_Com' . $key . '">'
													. '<input type="radio" name="Rel_Com" id="radiobutton" '
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
							<h4>Baixa</h4>
							<div class="row">
								<div class="col-md-3">
									<label for="Bx_Pag">Pagamentos?</label><br>
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
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
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
							<div class="col-md-6">
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
<?php } ?>