<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="btn-menu btn-group">
								<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/cliente\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-file"></span> Ver Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/contatocliente\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'contatocliente/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
											</a>
										</a>
									</li>
									<?php if ($_SESSION['Empresa']['CadastrarPet'] == 'S') { ?>
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/clientepet\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-user"></span> Pets do Cliente
												</a>
											</a>
										</li>
									<?php } ?>	
									<?php if ($_SESSION['Empresa']['CadastrarDep'] == 'S') { ?>	
										<li role="separator" class="divider"></li>
										<li>
											<a <?php if (preg_match("/clientedep\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
												<a href="<?php echo base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
													<span class="glyphicon glyphicon-user"></span> Dependentes do Cliente
												</a>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '.</small>' ?>
							</a>
							-->
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-calendar"></span> Agenda <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-calendar"></span> Lista de Agendamentos
													</a>
												</a>
											</li>
											<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
														</a>
													</a>
												</li>
											<?php } ?>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Orçs. <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Lista de Orçamentos
													</a>
												</a>
											</li>
											<?php if ($_SESSION['Usuario']['Cad_Orcam'] == "S" ) { ?>
												<li role="separator" class="divider"></li>
												<li>
													<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
														<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
															<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
														</a>
													</a>
												</li>
											<?php } ?>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> SAC <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Chamadas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Sac/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Chamada
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="botoesnav" role="toolbar" aria-label="...">
									<div class="btn-group">
										<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-pencil"></span> Marketing <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/procedimento\/listar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
													<a href="<?php echo base_url() . 'procedimento/listar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-pencil"></span> Lista de Campanhas
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/procedimento\/cadastrar_Marketing\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'procedimento/cadastrar_Marketing/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Nova Campanha
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>	
							</ul>
						</div>
					  </div>
					</nav>
				<?php } ?>
			<?php } ?>			
					
			<div class="row">
				<div class="col-sm-offset-1 col-md-10 ">
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading">
						<strong>Dependente do Cliente: <?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?></strong>
						</div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label for="NomeClienteDep">Nome do Dependente: *</label>
										<input type="text" class="form-control" id="NomeClienteDep" maxlength="255" <?php echo $readonly; ?>
											   name="NomeClienteDep" autofocus value="<?php echo $query['NomeClienteDep']; ?>">
										<?php echo form_error('NomeClienteDep'); ?> 
									</div>
									<div class="col-md-4">
										<label for="DataNascimentoDep">Data de Nascimento:</label>
										<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
											   name="DataNascimentoDep" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimentoDep']; ?>">
									</div> 
									<div class="col-md-4">
										<label for="SexoDep">Sexo:</label>
										<select data-placeholder="Selecione uma Opção..." class="form-control" <?php echo $readonly; ?>
												id="SexoDep" name="SexoDep">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['SexoDep'] as $key => $row) {
												if ($query['SexoDep'] == $key) {
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
							<div class="form-group">
								<div class="row">					
									<div class="col-md-4">
										<label for="RelacaoDep">Relação</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="RelacaoDep" name="RelacaoDep">
											<option value="">-- Selecione uma Relação --</option>
											<?php
											foreach ($select['RelacaoDep'] as $key => $row) {
												if ($query['RelacaoDep'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>   
										</select>
										<?php echo form_error('RelacaoDep'); ?>           
									</div>
									<div class="col-md-4">
										<label for="ObsDep">OBS:</label>
										<textarea class="form-control" id="ObsDep" <?php echo $readonly; ?>
												  name="ObsDep"><?php echo $query['ObsDep']; ?></textarea>
									</div>
									<div class="col-md-2">
										<label for="AtivoDep">Ativo?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['AtivoDep'] as $key => $row) {
													(!$query['AtivoDep']) ? $query['AtivoDep'] = 'S' : FALSE;

													if ($query['AtivoDep'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_AtivoDep" id="radiobutton_AtivoDep' . $key . '">'
														. '<input type="radio" name="AtivoDep" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_AtivoDep" id="radiobutton_AtivoDep' . $key . '">'
														. '<input type="radio" name="AtivoDep" id="radiobutton" '
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
							
									<!--<div class="col-md-3 form-inline">
										<label for="StatusVidaDep">Status de Vida:</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['StatusVidaDep'] as $key => $row) {
													if (!$query['StatusVidaDep'])
														$query['StatusVidaDep'] = 'V';

													if ($query['StatusVidaDep'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radio_StatusVidaDep" id="radiogeral' . $key . '">'
														. '<input type="radio" name="StatusVidaDep" id="radiogeral" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radio_StatusVidaDep" id="radiogeral' . $key . '">'
														. '<input type="radio" name="StatusVidaDep" id="radiogeral" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>  
											</div>
										</div>
									</div>-->

							<br>
										
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>"> 
									<?php if ($metodo > 1) { ?>
										<input type="hidden" name="idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>"> 
									<?php } ?>
									<?php if ($metodo == 2) { ?>

										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
										<!--
										<div class="col-md-6 text-right">
											<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
												<span class="glyphicon glyphicon-trash"></span> Excluir
											</button>
										</div>
										-->
										<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header bg-danger">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
													</div>
													<div class="modal-body">
														<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
															Esta operação é irreversível.</p>
													</div>
													<div class="modal-footer">
														<div class="col-md-6 text-left">
															<button type="button" class="btn btn-warning" data-dismiss="modal">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
														<div class="col-md-6 text-right">
															<a class="btn btn-danger" href="<?php echo base_url() . 'clientedep/excluir/' . $query['idApp_ClienteDep'] ?>" role="button">
																<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

									<?php } else { ?>
										<div class="col-md-6">
											<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
												<span class="glyphicon glyphicon-save"></span> Salvar
											</button>
										</div>
									<?php } ?>
								</div>
							</div>									
							</form>
						</div>
					</div>
				</div>
			</div>
	
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>
	

