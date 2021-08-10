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
								<button type="button" class="btn btn-md btn-default  dropdown-toggle" data-toggle="dropdown">
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
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Cliente
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/cliente\/alterarlogo\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
											<a href="<?php echo base_url() . 'cliente/alterarlogo/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Alterar Foto
											</a>
										</a>
									</li>											
								</ul>
							</div>
							<!--
							<a class="navbar-brand" href="<?php #echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<?php #echo '<small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small> - <small>' . $_SESSION['Cliente']['NomeCliente'] . '</small>' ?> 
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
										<button type="button" class="btn btn-md btn-<?php echo $botao_Sac;?>  dropdown-toggle" data-toggle="dropdown">
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
												<a <?php if (preg_match("/procedimento\/cadastrar_Sac_Sac\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
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
										<button type="button" class="btn btn-md btn-<?php echo $botao_mark;?>  dropdown-toggle" data-toggle="dropdown">
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

						<div class="panel-heading"><strong><?php echo $titulo; ?> </strong><?php echo $_SESSION['Cliente']['NomeCliente']; ?> - <?php echo $_SESSION['Cliente']['idApp_Cliente']; ?></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>
							<!--App_Procedimento-->
							<div class="panel-group">	
								<div class="panel panel-<?php echo $panel2; ?>">
									<div class="panel-heading">
										<div class="row text-left">
											<div class="col-md-3 " >
												<label for="<?php echo $titulo; ?>"><?php echo $titulo; ?> Nº <?php echo $orcatrata['idApp_Procedimento']; ?> - Tipo:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="<?php echo $titulo; ?>" name="<?php echo $titulo; ?>">
													<option value="">- Selec. <?php echo $titulo; ?> -</option>	
													<?php
													foreach ($select[$titulo] as $key => $row) {
														if ($orcatrata[$titulo] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error($titulo); ?>
											</div>
											
											<div class="col-md-6">
												<input type="hidden" name="idSis_Usuario" id="idSis_Usuario" value="<?php echo $orcatrata['idSis_Usuario']; ?>"/>
												<?php 
													if ($metodo == 1 || $metodo == 3) { 
														$nomecadatrou = $_SESSION['log']['Nome'];
													}elseif(isset($orcatrata['idSis_Usuario']) && ($metodo == 2 || $metodo == 4)){
														$nomecadatrou = $_SESSION['Orcatrata']['NomeCadastrou'];
													}else{
														$nomecadatrou = false;
													}
												?>
												<label for="Procedimento">Relato do Cliente - Cacastrado por : <?php echo $nomecadatrou; ?></label>
												<textarea class="form-control" name="Procedimento" id="Procedimento" <?php echo $readproc; ?>><?php echo $orcatrata['Procedimento']; ?></textarea>
												<?php echo form_error('Procedimento'); ?>		  
											</div>
											
											<!--
											<?php if ($metodo == 1) { ?>
												<div class="col-md-3">
													<label for="Compartilhar">Quem Fazer?</label>		
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Compartilhar" name="Compartilhar">
														<option value="">- Selec. Quem Fazer-</option>	
														<?php
														/*
														foreach ($select['Compartilhar'] as $key => $row) {
															if ($orcatrata['Compartilhar'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														*/
														?>
													</select>
												</div>
											<?php } elseif ($metodo == 2){ ?>
												<div class="col-md-3">
													<input type="hidden" name="Compartilhar" id="Compartilhar" value="<?php echo $orcatrata['Compartilhar']; ?>"/>
													<label for="Compartilhar">Quem Fazer</label>
													<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Orcatrata']['NomeCompartilhar']; ?>"/>
												</div>
											<?php } ?>
											-->
											
											<div class="col-md-3">
												<label for="Compartilhar">Quem Fazer?</label>		
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" id="Compartilhar" name="Compartilhar">
													<option value="">- Selec. Quem Fazer-</option>	
													<?php
													foreach ($select['Compartilhar'] as $key => $row) {
														if ($orcatrata['Compartilhar'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
												<?php echo form_error('Compartilhar'); ?>
											</div>	
										</div>	
										<div class="row">		
											<div class="col-md-3">
												<label for="DataProcedimento">Cadastrado em:</label>
												<div class="input-group <?php echo $datepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly=""
															name="DataProcedimento" id="DataProcedimento" value="<?php echo $orcatrata['DataProcedimento']; ?>">
												</div>
											</div>		
											<div class="col-md-2">
												<label for="HoraProcedimento">ÀS:</label>
												<div class="input-group <?php echo $timepicker; ?>">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-time"></span>
													</span>
													<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
															name="HoraProcedimento" id="HoraProcedimento" value="<?php echo $orcatrata['HoraProcedimento']; ?>">
												</div>
											</div>
											<div class="col-md-2 text-left">
												<label for="ConcluidoProcedimento">Concluído?</label><br>
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ConcluidoProcedimento'] as $key => $row) {
														if (!$orcatrata['ConcluidoProcedimento'])$orcatrata['ConcluidoProcedimento'] = 'N';

														($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

														if ($orcatrata['ConcluidoProcedimento'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="ConcluidoProcedimento_' . $hideshow . '">'
															. '<input type="radio" name="ConcluidoProcedimento" id="' . $hideshow . '" '
															. 'onchange="carregaConcluido(this.value,this.name,0)" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="ConcluidoProcedimento_' . $hideshow . '">'
															. '<input type="radio" name="ConcluidoProcedimento" id="' . $hideshow . '" '
															. 'onchange="carregaConcluido(this.value,this.name,0)" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
											<div id="ConcluidoProcedimento" <?php echo $div['ConcluidoProcedimento']; ?>>
												<div class="col-md-3">
													<label for="DataConcluidoProcedimento">Concluído em:</label>
													<div class="input-group <?php echo $datepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA" readonly=""
																name="DataConcluidoProcedimento" id="DataConcluidoProcedimento" value="<?php echo $orcatrata['DataConcluidoProcedimento']; ?>">
													</div>
													<?php echo form_error('DataConcluidoProcedimento'); ?>
												</div>		
												<div class="col-md-2">
													<label for="HoraConcluidoProcedimento">ÀS:</label>
													<div class="input-group <?php echo $timepicker; ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-time"></span>
														</span>
														<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly=""
																name="HoraConcluidoProcedimento" id="HoraConcluidoProcedimento" value="<?php echo $orcatrata['HoraConcluidoProcedimento']; ?>">
													</div>
												</div>
											</div>
										</div>	
										
									</div>
								</div>
							</div>
					
							<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
								<div class="panel panel-primary">
									 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
										<h4 class="panel-title">
											<a class="accordion-toggle">
												<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
												Ações
											</a>
										</h4>
									</div>

									<div id="collapse3" class="panel-collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
										<div class="panel-body">

											<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

											<div class="input_fields_wrap3">

											<?php
											for ($i=1; $i <= $count['PTCount']; $i++) {
											?>

											<?php if ($metodo == 2 || $metodo == 4) { ?>
											<input type="hidden" name="idApp_SubProcedimento<?php echo $i ?>" id="idApp_SubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_SubProcedimento']; ?>"/>
											<?php } ?>

											<div class="form-group" id="3div<?php echo $i ?>">
												<div class="panel panel-info">
													<div class="panel-heading">			
														<div class="row">
															<input type="hidden" name="idSis_Usuario<?php echo $i ?>" id="idSis_Usuario<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idSis_Usuario']; ?>"/>
															<div class="col-md-6">
																<label for="SubProcedimento<?php echo $i ?>">
																	Ação <?php echo $i ?>: 
																	<?php if ($procedtarefa[$i]['idSis_Usuario']) { ?>
																		<?php echo $_SESSION['Procedtarefa'][$i]['NomeCadastrou'];?>
																	<?php } ?>
																</label>
																<textarea class="form-control" id="SubProcedimento<?php echo $i ?>" <?php echo $readonly; ?> readonly=""
																		  name="SubProcedimento<?php echo $i ?>"><?php echo $procedtarefa[$i]['SubProcedimento']; ?></textarea>
															</div>
														</div>	
														<div class="row">	
															<!--
															<div class="col-md-2">
																<label for="Prioridade<?php echo $i ?>">Prioridade:</label>
																<?php if ($i == 1) { ?>
																<?php } ?>
																<select data-placeholder="Selecione uma opção..." class="form-control" 
																		 id="listadinamicad<?php echo $i ?>" name="Prioridade<?php echo $i ?>">
																	
																	<?php
																	/*
																	foreach ($select['Prioridade'] as $key => $row) {
																		if ($procedtarefa[$i]['Prioridade'] == $key) {
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
															<div class="col-md-2">
																<label for="DataSubProcedimento<?php echo $i ?>">Cadastrado em:</label>
																<div class="input-group <?php echo $datepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>															
																	<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly=""
																		   name="DataSubProcedimento<?php echo $i ?>" id="DataSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataSubProcedimento']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="HoraSubProcedimento<?php echo $i ?>">Às</label>
																<div class="input-group <?php echo $timepicker; ?>">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-time"></span>
																	</span>
																	<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																		   name="HoraSubProcedimento<?php echo $i ?>" id="HoraSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['HoraSubProcedimento']; ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="ConcluidoSubProcedimento">Concluído? </label><br>
																<div class="form-group">
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		/*
																		foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
																			(!$procedtarefa[$i]['ConcluidoSubProcedimento']) ? $procedtarefa[$i]['ConcluidoSubProcedimento'] = 'N' : FALSE;

																			if ($procedtarefa[$i]['ConcluidoSubProcedimento'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="radiobutton_ConcluidoSubProcedimento' . $i . '" id="radiobutton_ConcluidoSubProcedimento' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="radiobutton_ConcluidoSubProcedimento' . $i . '" id="radiobutton_ConcluidoSubProcedimento' . $i .  $key . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="radiobuttondinamico" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																				. '</label>'
																				;
																			}
																		}
																		*/
																		foreach ($select['ConcluidoSubProcedimento'] as $key => $row) {
																			if (!$procedtarefa[$i]['ConcluidoSubProcedimento'])$procedtarefa[$i]['ConcluidoSubProcedimento'] = 'N';
																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																			if ($procedtarefa[$i]['ConcluidoSubProcedimento'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="ConcluidoSubProcedimento' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaConclSubProc(this.value,this.name,'.$i.',0)" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="ConcluidoSubProcedimento' . $i . '_' . $hideshow . '">'
																				. '<input type="radio" name="ConcluidoSubProcedimento' . $i . '" id="' . $hideshow . '" '
																				. 'onchange="carregaConclSubProc(this.value,this.name,'.$i.',0)" '
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
																<div id="ConcluidoSubProcedimento<?php echo $i ?>" <?php echo $div['ConcluidoSubProcedimento' . $i]; ?>>
																	<div class="row">	
																		<div class="col-md-6">
																			<label for="DataConcluidoSubProcedimento<?php echo $i ?>">Data Concl</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> readonly="" maxlength="10" placeholder="DD/MM/AAAA"
																					   name="DataConcluidoSubProcedimento<?php echo $i ?>" id="DataConcluidoSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataConcluidoSubProcedimento']; ?>">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<label for="HoraConcluidoSubProcedimento<?php echo $i ?>">Hora Concl</label>
																			<div class="input-group <?php echo $timepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-time"></span>
																				</span>
																				<input type="text" class="form-control Time" <?php echo $readonly; ?> readonly="" maxlength="5" placeholder="HH:MM"
																					   name="HoraConcluidoSubProcedimento<?php echo $i ?>" id="HoraConcluidoSubProcedimento<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['HoraConcluidoSubProcedimento']; ?>">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<!--
															<div class="col-md-1">
																<label><br></label><br>
																<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
																	<span class="glyphicon glyphicon-trash"></span>
																</button>
															</div>
															-->
														</div>
													</div>	
												</div>		
											</div>

											<?php
											}
											?>

											</div>

											<div class="row">
												<div class="col-md-4">
													<a class="btn btn-xs btn-warning" onclick="adicionaSubProcedimento()">
														<span class="glyphicon glyphicon-plus"></span> Adicionar Ação
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<input type="hidden" name="idApp_Procedimento" value="<?php echo $orcatrata['idApp_Procedimento']; ?>">
									<?php if ($metodo > 1) { ?>
									<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
									<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
									<?php } ?>
									<?php if ($metodo == 2 || $metodo == 4) { ?>
									
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
															<a class="btn btn-danger" href="<?php echo base_url() . 'procedimento/excluirproc/' . $orcatrata['idApp_Procedimento'] ?>" role="button">
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
	</div>
</div>
