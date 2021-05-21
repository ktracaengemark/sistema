<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ( !isset($evento) && $_SESSION['log']['idSis_Empresa'] != 5 && isset($_SESSION['Cliente'])) { ?>
				<?php if ($_SESSION['Cliente']['idApp_Cliente'] != 150001 && $_SESSION['Cliente']['idApp_Cliente'] != 1 && $_SESSION['Cliente']['idApp_Cliente'] != 0) { ?>
					<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consulta\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Agendamento
													</a>
												</a>
											</li>
										</ul>
									</div>									
								</li>								
								<?php if ($_SESSION['Cliente']['idSis_Empresa'] == $_SESSION['log']['idSis_Empresa'] ) { ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Novo Orçamento
													</a>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php } ?>
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
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
							<strong>Pet do Cliente: <?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '.</small>' ?></strong>
						</div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label for="NomeClientePet">Nome do Pet: *</label>
										<input type="text" class="form-control" id="NomeClientePet" maxlength="255" <?php echo $readonly; ?>
											   name="NomeClientePet" autofocus value="<?php echo $query['NomeClientePet']; ?>">
									</div>
									<div class="col-md-4">
										<label for="DataNascimentoPet">Data de Nascimento:</label>
										<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
											   name="DataNascimentoPet" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimentoPet']; ?>">
									</div> 
									<div class="col-md-4">
										<label for="SexoPet">Gênero:</label>
										<select data-placeholder="Selecione uma Opção..." class="form-control" <?php echo $readonly; ?>
												id="SexoPet" name="SexoPet">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['SexoPet'] as $key => $row) {
												if ($query['SexoPet'] == $key) {
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
									<!--
									<div class="col-md-4">
										<label for="EspeciePet">Especie: *</label>
										<input type="text" class="form-control" id="EspeciePet" maxlength="45" <?php echo $readonly; ?>
											   name="EspeciePet" value="<?php echo $query['EspeciePet']; ?>">
									</div>
									-->
									<div class="col-md-4">
										<label for="EspeciePet">Especie:</label>
										<select data-placeholder="Selecione uma Opção..." class="form-control" 
												id="EspeciePet" name="EspeciePet">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['EspeciePet'] as $key => $row) {
												if ($query['EspeciePet'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>   
										</select>
									</div>
									<div class="col-md-4 text-left">
										<label for="RacaPet">Raca:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control"
												id="RacaPet" name="RacaPet">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['RacaPet'] as $key => $row) {
												if ($query['RacaPet'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
									<!--
									<div class="col-md-4">
										<label for="RacaPet">Raca: *</label>
										<input type="text" class="form-control" id="RacaPet" maxlength="45" <?php echo $readonly; ?>
											   name="RacaPet" value="<?php echo $query['RacaPet']; ?>">
									</div>
									-->
									<div class="col-md-4">
										<label for="PeloPet">Pelo:</label>
										<select data-placeholder="Selecione uma Opção..." class="form-control" 
												id="PeloPet" name="PeloPet">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['PeloPet'] as $key => $row) {
												if ($query['PeloPet'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>   
										</select>
									</div>
									<div class="col-md-4">
										<label for="CorPet">Cor: *</label>
										<input type="text" class="form-control" id="CorPet" maxlength="45" <?php echo $readonly; ?>
											   name="CorPet" value="<?php echo $query['CorPet']; ?>">
									</div>
									<!--
									<div class="col-md-4">
										<label for="PeloPet">Pelo: *</label>
										<input type="text" class="form-control" id="PeloPet" maxlength="45" <?php echo $readonly; ?>
											   name="PeloPet" value="<?php echo $query['PeloPet']; ?>">
									</div>
									--> 
									<div class="col-md-4">
										<label for="PortePet">Porte:</label>
										<select data-placeholder="Selecione uma Opção..." class="form-control" 
												id="PortePet" name="PortePet">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['PortePet'] as $key => $row) {
												if ($query['PortePet'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>   
										</select>
									</div>
									<!--
									<div class="col-md-4">
										<label for="PortePet">Porte: *</label>
										<input type="text" class="form-control" id="PortePet" maxlength="45" <?php echo $readonly; ?>
											   name="PortePet" value="<?php echo $query['PortePet']; ?>">
									</div>
									-->
									<div class="col-md-4">
										<label for="PesoPet">Peso:</label>
										<div class="input-group" id="txtHint">
											<input type="text" class="form-control ValorPeso" id="PesoPet" maxlength="10" placeholder="0,000" <?php echo $readonly; ?>
												   name="PesoPet" value="<?php echo $query['PesoPet']; ?>">
											<span class="input-group-addon" id="basic-addon1">kg</span>
										</div>  
									</div>
								</div>
							</div>	
							<div class="form-group">
								<div class="row">
									<div class="col-md-2">
										<label for="AlergicoPet">Alergico?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['AlergicoPet'] as $key => $row) {
													(!$query['AlergicoPet']) ? $query['AlergicoPet'] = 'N' : FALSE;
													if ($query['AlergicoPet'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_AlergicoPet" id="radiobutton_AlergicoPet' . $key . '">'
														. '<input type="radio" name="AlergicoPet" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_AlergicoPet" id="radiobutton_AlergicoPet' . $key . '">'
														. '<input type="radio" name="AlergicoPet" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<label for="AtivoPet">AtivoPet?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['AtivoPet'] as $key => $row) {
													(!$query['AtivoPet']) ? $query['AtivoPet'] = 'S' : FALSE;
													if ($query['AtivoPet'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_AtivoPet" id="radiobutton_AtivoPet' . $key . '">'
														. '<input type="radio" name="AtivoPet" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_AtivoPet" id="radiobutton_AtivoPet' . $key . '">'
														. '<input type="radio" name="AtivoPet" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" >' . $row
														. '</label>'
														;
													}
												}
												?>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<label for="ObsPet">OBS:</label>
										<textarea class="form-control" id="ObsPet" <?php echo $readonly; ?>
												  name="ObsPet"><?php echo $query['ObsPet']; ?></textarea>
									</div>
									<div class="col-md-2 text-left">
										<label for="Cadastrar">Raca Encontrada?</label><br>
										<div class="btn-group" data-toggle="buttons">
											<?php
											foreach ($select['Cadastrar'] as $key => $row) {
												if (!$cadastrar['Cadastrar']) $cadastrar['Cadastrar'] = 'S';

												($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

												if ($cadastrar['Cadastrar'] == $key) {
													echo ''
													. '<label class="btn btn-warning active" name="Cadastrar_' . $hideshow . '">'
													. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" checked>' . $row
													. '</label>'
													;
												} else {
													echo ''
													. '<label class="btn btn-default" name="Cadastrar_' . $hideshow . '">'
													. '<input type="radio" name="Cadastrar" id="' . $hideshow . '" '
													. 'autocomplete="off" value="' . $key . '" >' . $row
													. '</label>'
													;
												}
											}
											?>

										</div>
									</div>
									<div class="col-md-4 text-left" id="Cadastrar" <?php echo $div['Cadastrar']; ?>>
										<div class="row">	
											<div class="col-md-6 text-left">	
												<label >Raca</label><br>
												<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#addRacaPetModal">
													Cadastrar/Edit./Excl.
												</button>
											</div>
											<div class="col-md-6 text-left">
												<label >Recarregar</label><br>
												<button class="btn btn-md btn-primary btn-block"  id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-refresh"></span>Recarregar
												</button>
											</div>	
										</div>	
										<?php echo form_error('Cadastrar'); ?>
									</div>
								</div>
							</div> 
							
									<!--<div class="col-md-3 form-inline">
										<label for="StatusVidaPet">Status de Vida:</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['StatusVidaPet'] as $key => $row) {
													if (!$query['StatusVidaPet'])
														$query['StatusVidaPet'] = 'V';

													if ($query['StatusVidaPet'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radio_StatusVidaPet" id="radiogeral' . $key . '">'
														. '<input type="radio" name="StatusVidaPet" id="radiogeral" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radio_StatusVidaPet" id="radiogeral' . $key . '">'
														. '<input type="radio" name="StatusVidaPet" id="radiogeral" '
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
										<input type="hidden" name="idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>"> 
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'clientepet/excluir/' . $query['idApp_ClientePet'] ?>" role="button">
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
								<div id="msgCadSucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header bg-success text-center">
												<h4 class="modal-title" id="visulClienteModalLabel">Cadastrado com sucesso!</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span>
												</button>
											</div>
											<!--
											<div class="modal-body">
												Cliente cadastrado com sucesso!
											</div>
											-->
											<div class="modal-footer">
												<div class="col-md-6">	
													<button class="btn btn-success btn-block" name="botaoFechar2" id="botaoFechar2" onclick="DesabilitaBotaoFechar(this.name)" value="0" type="submit">
														<span class="glyphicon glyphicon-filter"></span> Fechar
													</button>
													<div class="col-md-12 alert alert-warning aguardar2" role="alert" >
														Aguarde um instante! Estamos processando sua solicitação!
													</div>
												</div>
												<!--<button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>-->
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
		<div class="col-md-2"></div>
	</div>	
</div>
<div id="addRacaPetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRacaPetModalLabel">Cadastrar RacaPet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="msg-error-racapet"></span>
				<form method="post" id="insert_racapet_form">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">RacaPet</label>
						<div class="col-sm-10">
							<input name="Novo_RacaPet" type="text" class="form-control" id="Novo_RacaPet" placeholder="RacaPet">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<br>
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal" name="botaoFecharRacaPet" id="botaoFecharRacaPet">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>	
						<div class="col-sm-6">
							<br>
							<button type="submit" class="btn btn-success btn-block" name="botaoCadRacaPet" id="botaoCadRacaPet" >
								<span class="glyphicon glyphicon-plus"></span> Cadastrar
							</button>
						</div>	
						<div class="col-md-12 alert alert-warning aguardarRacaPet" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
				<?php if (isset($list3)) echo $list3; ?>
			</div>
		</div>
	</div>
</div>	

<div id="alterarRacaPet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alterarRacaPetLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="alterarRacaPetLabel">Raca</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-alterar-racapet"></span>
				<form method="post" id="alterar_racapet_form">
					<div class="form-group">
						<label for="Nome_RacaPet" class="control-label">Raca:</label>
						<input type="text" class="form-control" name="Nome_RacaPet" id="Nome_RacaPet">
					</div>
					<input type="hidden" name="id_RacaPet" id="id_RacaPet">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarRacaPet" id="CancelarRacaPet" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="AlterarRacaPet" id="AlterarRacaPet" >Alterar</button>	
						<div class="col-md-12 alert alert-warning aguardarAlterarRacaPet" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="excluirRacaPet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="excluirRacaPetLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="excluirRacaPetLabel">Raca</h4>
			</div>
			<div class="modal-body">
				<span id="msg-error-excluir-racapet"></span>
				<form method="post" id="excluir_racapet_form">
					<div class="form-group">
						<label for="ExcluirRacaPet" class="control-label">Raca:</label>
						<input type="text" class="form-control" name="ExcluirRacaPet" id="ExcluirRacaPet" readonly="">
					</div>
					<input type="hidden" name="id_ExcluirRacaPet" id="id_ExcluirRacaPet">
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" name="CancelarExcluirRacaPet" id="CancelarExcluirRacaPet" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger" name="Excluirtributo" id="ExcluirRacaPet" >Apagar</button>	
						<div class="col-md-12 alert alert-warning aguardarExcluirRacaPet" role="alert" >
							Aguarde um instante! Estamos processando sua solicitação!
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

