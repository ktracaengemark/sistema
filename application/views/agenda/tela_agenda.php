
<div class="col-md-12">
	<?php if (isset($msg)) echo $msg; ?>
	<?php echo form_open('agenda', 'role="form"'); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<input type="hidden" id="AgendaI" value="<?php echo $_SESSION['Empresa']['AgendaI'];?>">
			<input type="hidden" id="AgendaF" value="<?php echo $_SESSION['Empresa']['AgendaF'];?>">
			<div class="row">		
				<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>
					<?php if ($_SESSION['log']['Permissao'] <= 2 ) { ?>
						<div class="col-md-4 text-left">
							<label class="" for="Ordenamento">Profissional:</label><br>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()" id="NomeUsuario" name="NomeUsuario">
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
					<div class="col-md-4 text-left">
						<label  id="NomeClienteAuto1">Cliente: <?php echo $cadastrar['NomeClienteAuto']; ?></label>
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-info btn-md" type="submit">
									<span class="glyphicon glyphicon-search"></span> 
								</button>
							</span>
							
							<input type="text" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
							<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
							<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
							<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
							
							<!--
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="clientePet(this.value),clienteDep(this.value),this.form.submit()"
									id="idApp_Cliente" name="idApp_Cliente">
								<?php
								/*
								foreach ($select['idApp_Cliente'] as $key => $row) {
									if ($query['idApp_Cliente'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								*/
								?>
							</select>
							-->
						</div>
					</div>
					<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
						<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
						<div class="col-md-3 text-left">
							<label  for="idApp_ClienteDep">Dep</label>
							<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep" onchange="this.form.submit()">
								<option value=""></option>
							</select>
							<span class="modal-title" id="Dep"></span>
						</div>
					<?php } ?>
					<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
						<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
						<div class="col-md-3 text-left">
							<label  for="idApp_ClientePet">Pet</label>
							<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet" onchange="this.form.submit()">
								<option value=""></option>
							</select>
							<span class="modal-title" id="Pet"></span>
						</div>
					<?php } ?>
					<!--
					<div class="col-md-4 text-left">
						<label class="" for="Ordenamento">Cliente:</label><br>
						<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()" id="NomeCliente" name="NomeCliente">
							<?php
							/*
							foreach ($select['NomeCliente'] as $key => $row) {
								if ($query['NomeCliente'] == $key) {
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
				<?php } ?>
				<!--
				<div class=" btn btn-success" type="button" data-toggle="collapse" data-target="#Agenda" aria-expanded="false" aria-controls="Agenda">
					<span class="glyphicon glyphicon-chevron-up"></span> Agenda
				</div>
				-->
				<div class="col-md-1 text-left">	
					<label class="" for="Ordenamento">Calendário</label><br>
					<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#Calendario" aria-expanded="false" aria-controls="Calendario">
						<span class="glyphicon glyphicon-calendar"></span>
					</div>
				</div>	
			</div>
		</div>
		<div <?php echo $collapse; ?> id="Agenda">
			
				<div <?php echo $collapse1; ?> id="Calendario">
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4 form-group text-center" id="datepickerinline" >
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>	
				<div class="row">	
					<div class="col-md-12 form-group">
						<div  style="overflow:auto; height:520px; "> 
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