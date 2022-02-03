<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa']) && isset($_SESSION['Saudacao'])) { ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-primary">
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
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/atendimento\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/atendimento/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Horario de Atendimento
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Alterar Logo
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/saudacao\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/saudacao/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Saudacoes
									</a>
								</a>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a <?php if (preg_match("/empresa\/pagseguro\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
									<a href="<?php echo base_url() . 'empresa/pagseguro/' . $_SESSION['Empresa']['idSis_Empresa']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Pag Seguro
									</a>
								</a>
							</li>							
						</ul>
					</div>
				</div>
								
				<div class="panel-body">
					<div class="row">	
						<div class="col-md-12">	
						
							<?php echo validation_errors(); ?>

							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="text-left">Agendamento</h3>	
									<div class="form-group">	
										<div class="row">	
											<div class="col-md-6">
												<label for="TextoAgenda_1">Texto_1:</label>
												<textarea type="text" class="form-control " id="TextoAgenda_1" maxlength="200" <?php echo $readonly; ?>
													   name="TextoAgenda_1" value="<?php echo $saudacao['TextoAgenda_1']; ?>"><?php echo $saudacao['TextoAgenda_1']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="ClienteAgenda">Nome do Cliente?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ClienteAgenda'] as $key => $row) {
														if (!$saudacao['ClienteAgenda'])$saudacao['ClienteAgenda'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['ClienteAgenda'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="ClienteAgenda_' . $hideshow . '">'
															. '<input type="radio" name="ClienteAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="ClienteAgenda_' . $hideshow . '">'
															. '<input type="radio" name="ClienteAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row">		
											<div class="col-md-6">
												<label for="TextoAgenda_2">Texto_2:</label>
												<textarea type="text" class="form-control " id="TextoAgenda_2" maxlength="200" <?php echo $readonly; ?>
													   name="TextoAgenda_2" value="<?php echo $saudacao['TextoAgenda_2']; ?>"><?php echo $saudacao['TextoAgenda_2']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="ProfAgenda">Nome do Profissional?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ProfAgenda'] as $key => $row) {
														if (!$saudacao['ProfAgenda'])$saudacao['ProfAgenda'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['ProfAgenda'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="ProfAgenda_' . $hideshow . '">'
															. '<input type="radio" name="ProfAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="ProfAgenda_' . $hideshow . '">'
															. '<input type="radio" name="ProfAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row">		
											<div class="col-md-6">
												<label for="TextoAgenda_3">Texto_3:</label>
												<textarea type="text" class="form-control " id="TextoAgenda_3" maxlength="200" <?php echo $readonly; ?>
													   name="TextoAgenda_3" value="<?php echo $saudacao['TextoAgenda_3']; ?>"><?php echo $saudacao['TextoAgenda_3']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="DataAgenda">Data do Agendamento?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['DataAgenda'] as $key => $row) {
														if (!$saudacao['DataAgenda'])$saudacao['DataAgenda'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['DataAgenda'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="DataAgenda_' . $hideshow . '">'
															. '<input type="radio" name="DataAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="DataAgenda_' . $hideshow . '">'
															. '<input type="radio" name="DataAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row">		
											<div class="col-md-6">
												<label for="TextoAgenda_4">Texto_4:</label>
												<textarea type="text" class="form-control " id="TextoAgenda_4" maxlength="200" <?php echo $readonly; ?>
													   name="TextoAgenda_4" value="<?php echo $saudacao['TextoAgenda_4']; ?>"><?php echo $saudacao['TextoAgenda_4']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="SiteAgenda">Site da Empresa?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['SiteAgenda'] as $key => $row) {
														if (!$saudacao['SiteAgenda'])$saudacao['SiteAgenda'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['SiteAgenda'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="SiteAgenda_' . $hideshow . '">'
															. '<input type="radio" name="SiteAgenda" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="SiteAgenda_' . $hideshow . '">'
															. '<input type="radio" name="SiteAgenda" id="' . $hideshow . '" '
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
									<h3 class="text-left">Pedido</h3>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="TextoPedido_1">Texto_1:</label>
												<textarea type="text" class="form-control" id="TextoPedido_1" maxlength="300" <?php echo $readonly; ?>
													   name="TextoPedido_1" value="<?php echo $saudacao['TextoPedido_1']; ?>"><?php echo $saudacao['TextoPedido_1']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="ClientePedido">Nome do Cliente?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ClientePedido'] as $key => $row) {
														if (!$saudacao['ClientePedido'])$saudacao['ClientePedido'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['ClientePedido'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="ClientePedido_' . $hideshow . '">'
															. '<input type="radio" name="ClientePedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="ClientePedido_' . $hideshow . '">'
															. '<input type="radio" name="ClientePedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label for="TextoPedido_2">Texto_2:</label>
												<textarea type="text" class="form-control" id="TextoPedido_2" maxlength="300" <?php echo $readonly; ?>
													   name="TextoPedido_2" value="<?php echo $saudacao['TextoPedido_2']; ?>"><?php echo $saudacao['TextoPedido_2']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="idClientePedido">N do Cliente?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['idClientePedido'] as $key => $row) {
														if (!$saudacao['idClientePedido'])$saudacao['idClientePedido'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['idClientePedido'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="idClientePedido_' . $hideshow . '">'
															. '<input type="radio" name="idClientePedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="idClientePedido_' . $hideshow . '">'
															. '<input type="radio" name="idClientePedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label for="TextoPedido_3">Texto_3:</label>
												<textarea type="text" class="form-control" id="TextoPedido_3" maxlength="300" <?php echo $readonly; ?>
													   name="TextoPedido_3" value="<?php echo $saudacao['TextoPedido_3']; ?>"><?php echo $saudacao['TextoPedido_3']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="idPedido">N do Pedido?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['idPedido'] as $key => $row) {
														if (!$saudacao['idPedido'])$saudacao['idPedido'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['idPedido'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="idPedido_' . $hideshow . '">'
															. '<input type="radio" name="idPedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="idPedido_' . $hideshow . '">'
															. '<input type="radio" name="idPedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label for="TextoPedido_4">Texto_4:</label>
												<textarea type="text" class="form-control" id="TextoPedido_4" maxlength="300" <?php echo $readonly; ?>
													   name="TextoPedido_4" value="<?php echo $saudacao['TextoPedido_4']; ?>"><?php echo $saudacao['TextoPedido_4']; ?></textarea>
											</div>
											<div class="col-md-3 text-left">
												<label for="SitePedido">Site da Empresa?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['SitePedido'] as $key => $row) {
														if (!$saudacao['SitePedido'])$saudacao['SitePedido'] = 'N';
														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
														if ($saudacao['SitePedido'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="SitePedido_' . $hideshow . '">'
															. '<input type="radio" name="SitePedido" id="' . $hideshow . '" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="SitePedido_' . $hideshow . '">'
															. '<input type="radio" name="SitePedido" id="' . $hideshow . '" '
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
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="btn-group">
														<button class="btn btn-sm btn-default" id="inputDb" data-loading-text="Aguarde..." type="submit">
															<span class="glyphicon glyphicon-save"></span> Salvar
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
					<input type="hidden" name="idSis_Empresa" value="<?php echo $_SESSION['Saudacao']['idSis_Empresa']; ?>">
					<input type="hidden" name="idApp_Documentos" value="<?php echo $_SESSION['Saudacao']['idApp_Documentos']; ?>">
					<!--<input type="hidden" name="idSis_Empresa" value="<?php echo $saudacao['idSis_Empresa']; ?>">-->
				</div>	
			</div>
			</form>
		</div>
	</div>	
</div>
<?php } ?>