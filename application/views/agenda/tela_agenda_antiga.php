<?php if (isset($msg)) echo $msg; ?>

<!--<div id="dp" class="col-md-2"></div>
<div id="datepickerinline" class="col-md-2"></div>
<div id="calendar" class="col-md-8"></div>-->

<div class="col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo form_open('agenda', 'role="form"'); ?>
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Tarefas" aria-expanded="false" aria-controls="Tarefas">
				<span class="glyphicon glyphicon-pencil"> Tarefas</span>
			</div>
			<a class="btn btn-sm btn-info" href="<?php #echo base_url() ?>relatorio/alterarprocedimento" role="button">
				<span class="glyphicon glyphicon-search"></span> Todas
			</a>
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button">
				<span class="glyphicon glyphicon-plus"></span> Cad.
			</a>
		</div>
		<div <?php echo $collapse1; ?> id="Tarefas">
			<div class="panel-body">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<div style="overflow: auto; height: 155px; ">
								<table class="table table-condensed table-bordered table-striped" >
									<tr>
										<th class="active">Cpf</th>
										<th class="active">Tarefa</th>	
										<th class="active">Data</th>
										<th class="active">Conc.</th>
									</tr>
									
									<?php
									if ($query['procedimento'] != FALSE) {

										foreach ($query['procedimento']->result_array() as $row) {
											$url = base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'];

											echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
													data-toggle="tooltip" data-placement="right" title="">';
												echo '<td>' . $row['NomeEmpresa'] . '</td>';
												echo '<td>' . $row['Procedimento'] . '</td>';
												echo '<td>' . $row['DataProcedimento'] . '</td>';
												echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
												
											echo '</tr>';

										}

									}
									?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo form_open('agenda', 'role="form"'); ?>		
			<?php if ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) { ?>	
				
			<div class="col-md-6 text-left">
				<label class="sr-only" for="Ordenamento">Agenda dos Prof.:</label>
				<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
						id="NomeUsuario" name="NomeUsuario">
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
			<?php } ?>
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Agenda" aria-expanded="false" aria-controls="Agenda">
				<span class="glyphicon glyphicon-pencil"> Agenda</span>
			</div>
			<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#Calendario" aria-expanded="false" aria-controls="Calendario">
				<span class="glyphicon glyphicon-calendar"></span>
			</div>
			
		</div>
		<div <?php echo $collapse; ?> id="Agenda">
			<div class="panel-body">
				<div class="text-right">
					<div <?php echo $collapse1; ?> id="Calendario">
							<div class="form-group" id="datepickerinline" class="col-md-12" >
							</div>
					</div>
				</div>
				<div class="form-group">
					<div  style="overflow: auto; height: 456px; "> 
							<table id="calendar" class="table table-condensed table-striped "></table>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<div id="fluxo" class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="fluxo" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-sm vertical-align-center">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<label for="">Agendamento:</label>
								<div class="form-group">
									<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>				
									<div class="row">
										<button type="button" id="MarcarConsulta" onclick="redirecionar(2)" class="btn btn-primary"> Com Cliente
										</button>
									</div>
									<?php } ?>
									<br>
									<div class="row">
										<button type="button" id="AgendarEvento" onclick="redirecionar(1)" class="btn btn-info"> Outro Evento
										</button>
									</div>
										<input type="hidden" id="start" />
										<input type="hidden" id="end" />
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>
<div class="col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<!--
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/procedimentocli" role="button">
				<span class="glyphicon glyphicon-search"></span> Pesq.
			</a>
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button">
				<span class="glyphicon glyphicon-plus"></span> Cad.
			</a>
			-->
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Cliente" aria-expanded="false" aria-controls="Cliente">
				<span class="glyphicon glyphicon-pencil"> Procd.Cli.</span>
			</div>
		</div>		
		<div <?php echo $collapse1; ?> id="Cliente">
			<div class="panel-body">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<div style="overflow: auto; height: 155px; ">
								<table class="table table-condensed table-bordered table-striped" >
									<tr>
										<th class="active">Cliente</th>
										<th class="active">Procedimento</th>	
										<th class="active">Data</th>
										<th class="active">Conc.</th>
									</tr>
									<?php
									if ($query['procedimentocli'] != FALSE) {

										foreach ($query['procedimentocli']->result_array() as $row) {
											$url = base_url() . 'procedimento/alterarproc/' . $row['idApp_Procedimento'];

											echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
													data-toggle="tooltip" data-placement="right" title="">';
												echo '<td>' . $row['NomeCliente'] . '</td>';
												echo '<td>' . $row['Procedimento'] . '</td>';
												echo '<td>' . $row['DataProcedimento'] . '</td>';
												echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
												
											echo '</tr>';

										}

									}
									?>
								</table>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
<!--
<div class="col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/procedimentoorc" role="button">
				<span class="glyphicon glyphicon-search"></span> Pesq.
			</a>
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button">
				<span class="glyphicon glyphicon-plus"></span> Cad.
			</a>
			
			<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Orca" aria-expanded="false" aria-controls="Orca">
				<span class="glyphicon glyphicon-pencil"> Procd.Orç.</span>
			</div>
		</div>		
		<div <?php echo $collapse; ?> id="Orca">
			<div class="panel-body">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<div style="overflow: auto; height: 155px; ">
								<table class="table table-condensed table-bordered table-striped" >
									<tr>
										<th class="active">Orç.</th>
										<th class="active">Procedimento</th>	
										<th class="active">Data</th>
										<th class="active">Conc.</th>
									</tr>
									<?php
									if ($query['procedimentoorc'] != FALSE) {

										foreach ($query['procedimentoorc']->result_array() as $row) {
											$url = base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'];

											echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
													data-toggle="tooltip" data-placement="right" title="">';
												echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
												echo '<td>' . $row['Procedimento'] . '</td>';
												echo '<td>' . $row['DataProcedimento'] . '</td>';
												echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
												
											echo '</tr>';

										}

									}
									?>
								</table>
							</div>
							
							
							<table class="table table-condensed table-bordered">
								<tr class="active text-active">
									<th colspan="2" class="col-md-12 text-center"><b>Estatísticas - <?php echo date('m/Y', time()) ?></b></th>
								</tr>
								<tr class="warning text-warning">
									<td class="col-md-8"><b>Agendadas</b></td>
									<th><?php if (isset($query['estatisticas'][1])) { echo $query['estatisticas'][1]; } else { echo 0; } ?></th>
								</tr>
								<tr class="success text-success">
									<td><b>Confirmadas</b></td>
									<th><?php if (isset($query['estatisticas'][2])) { echo $query['estatisticas'][2]; } else { echo 0; } ?></th>
								</tr>
								<tr class="info text-primary">
									<td><b>Comparecimentos</b></td>
									<th><?php if (isset($query['estatisticas'][3])) { echo $query['estatisticas'][3]; } else { echo 0; } ?></th>
								</tr>
								<tr class="danger text-danger">
									<td><b>Faltas</b></td>
									<th><?php if (isset($query['estatisticas'][4])) { echo $query['estatisticas'][4]; } else { echo 0; } ?></th>
								</tr>
								<tr class="danger text-danger">
									<td><b>Remarcações</b></td>
									<th><?php if (isset($query['estatisticas'][5])) { echo $query['estatisticas'][5]; } else { echo 0; } ?></th>
								</tr>
								<tr class="danger text-danger">
									<td><b>Cancelamentos</b></td>
									<th><?php if (isset($query['estatisticas'][6])) { echo $query['estatisticas'][6]; } else { echo 0; } ?></th>
								</tr>
							</table>

							<table class="table table-condensed table-bordered table-striped">
								<tr class="active text-active">
									<th colspan="3" class="col-md-12 text-center"><b>Aniversariantes - <?php echo date('m/Y', time()) ?></b></th>
								</tr>
								<?php

								if ($query['cliente_aniversariantes'] != FALSE) {

									foreach ($query['cliente_aniversariantes']->result_array() as $row) {
										$url = base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'];

										echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
												data-toggle="tooltip" data-placement="right" title="">';
											echo '<td>' . $row['NomeCliente'] . '</td>';
											echo '<td>' . $row['DataNascimento'] . '</td>';
											echo '<td>' . $row['Telefone1'] . '</td>';
										echo '</tr>';

									}

								}

								if ($query['contatocliente_aniversariantes'] != FALSE) {

									foreach ($query['contatocliente_aniversariantes']->result_array() as $row) {
										$url = base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'];

										echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
												data-toggle="tooltip" data-placement="right" title="">';
											echo '<td>' . $row['NomeContatoCliente'] . '</td>';
											echo '<td>' . $row['DataNascimento'] . '</td>';
											echo '<td>' . $row['Telefone1'] . '</td>';
										echo '</tr>';
									}

								}
								/*
								if ($query['profissional_aniversariantes'] != FALSE) {

									foreach ($query['profissional_aniversariantes']->result_array() as $row) {
										$url = base_url() . 'profissional/prontuario/' . $row['idApp_Profissional'];

										echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
												data-toggle="tooltip" data-placement="right" title="">';
											echo '<td>' . $row['NomeProfissional'] . '</td>';
											echo '<td>' . $row['DataNascimento'] . '</td>';
											echo '<td>' . $row['Telefone1'] . '</td>';
										echo '</tr>';

									}

								}

								if ($query['contatoprof_aniversariantes'] != FALSE) {

									foreach ($query['contatoprof_aniversariantes']->result_array() as $row) {
										$url = base_url() . 'profissional/prontuario/' . $row['idApp_Profissional'];

										echo '<tr class="clickable-row" data-href="' . $url . '" data-original-title="' . $row['Idade'] . ' anos" data-container="body"
												data-toggle="tooltip" data-placement="right" title="">';
											echo '<td>' . $row['NomeContatoProf'] . '</td>';
											echo '<td>' . $row['DataNascimento'] . '</td>';
											echo '<td>' . $row['TelefoneContatoProf'] . '</td>';
										echo '</tr>';
									}

								}
								*/
								?>
							</table>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
-->
<?php } ?>