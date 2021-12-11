<?php if ($_SESSION['log']['idSis_Empresa'] == 5) { ?>
	<div class="col-lg-2 col-md-2 col-sm-2"></div>
<?php } ?>
<?php 
	if ($_SESSION['log']['idSis_Empresa'] != 5){
		if(isset($_SESSION['bd'])){
			echo "<script>window.open('https://api.whatsapp.com/send?phone=55".$_SESSION['bd']['CelularCliente']."&text=Ola ".$_SESSION['bd']['NomeCliente'].". Agendamento marcado com ".$_SESSION['bd']['Profissional'].", dia ".$_SESSION['bd']['DataInicio'].", as ".$_SESSION['bd']['HoraInicio'].".','_blank');</script>";
		}
		unset($_SESSION['bd']);		
	} 
?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
	<?php if($paginacao == "N") { ?>	
		<div id="fluxo" class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="fluxo" aria-hidden="true">
			<div class="vertical-alignment-helper">
				<div class="modal-dialog modal-sm vertical-align-center">
					<div class="modal-content">
						<div class="modal-body text-center">
							
								<div class="row">
									<div class="col-md-12 col-lg-12">
										<label for="">Agendamento:</label>
										<div class="form-group">
											<?php if ($_SESSION['log']['idSis_Empresa'] != 5 ) { ?>
												<?php if ($_SESSION['Usuario']['Cad_Agend'] == "S" ) { ?>
													<div class="row">
														<button type="button" id="MarcarConsulta" onclick="redirecionar(2)" class="btn btn-primary"> Com Cliente
														</button>
													</div>
												<?php } ?>
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
	<?php } ?>	
	<?php if (isset($msg)) echo $msg; ?>
	<?php #echo form_open('agenda', 'role="form"'); ?>
	<?php echo form_open($form_open_path, 'role="form"'); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<?php if($paginacao == "N") { ?>					
				<div class="row text-left">
					<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>
						<?php if ($_SESSION['log']['Permissao'] <= 2 ) { ?>
							<div class="col-lg-3 col-md-5 col-sm-4 col-xs-9 text-left" >
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
						<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12 text-left">
							<label  >Cliente:</label>
							<div class="input-group">
								<input type="text" class="form-control" name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>"  placeholder="Pesquisar Cliente">
								<span class="input-group-btn">
									<button class="btn btn-primary btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
							</div>
							<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
							<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
							<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
							<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
						</div>
						<?php if($_SESSION['Empresa']['CadastrarPet'] == "S"){?>
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-left" >
								<label  for="idApp_ClientePet">Pet</label>
								<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClientePet" name="idApp_ClientePet" onchange="this.form.submit()">
									<option value=""></option>
								</select>
								<span class="modal-title" id="Pet"></span>
							</div>
							<input type="hidden" id="Hidden_idApp_ClientePet" name="Hidden_idApp_ClientePet" value="<?php echo $query['idApp_ClientePet']; ?>" />
						<?php } else { ?>
							<?php if($_SESSION['Empresa']['CadastrarDep'] == "S"){?>
								<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-left" >
									<label  for="idApp_ClienteDep">Dep</label>
									<select data-placeholder="Selecione uma opção..." class="form-control" id="idApp_ClienteDep" name="idApp_ClienteDep" onchange="this.form.submit()">
										<option value=""></option>
									</select>
									<span class="modal-title" id="Dep"></span>
								</div>
								<input type="hidden" id="Hidden_idApp_ClienteDep" name="Hidden_idApp_ClienteDep" value="<?php echo $query['idApp_ClienteDep']; ?>" />
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-left">	
						<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>	
							<label class="" for="Ordenamento">Cal.</label><br>
						<?php } ?>	
						<div class=" btn btn-primary" type="button" data-toggle="collapse" data-target="#Calendario" aria-expanded="false" aria-controls="Calendario">
							<span class="glyphicon glyphicon-calendar"></span>
						</div>
					</div>	
				</div>
			<?php } ?>
			<input type="hidden" id="AgendaI" value="<?php echo $_SESSION['Empresa']['AgendaI'];?>">
			<input type="hidden" id="AgendaF" value="<?php echo $_SESSION['Empresa']['AgendaF'];?>">	
		</div>
		<div <?php echo $collapse; ?> id="Agenda">
			
				<div <?php echo $collapse1; ?> id="Calendario">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 text-center" id="datepickerinline" >
							</div>
						</div>	
					</div>
				</div>	
				<div class="row">	
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
								<table id="calendar" class="table table-condensed table-striped "></table>
						
					</div>
				</div>
			
		</div>	
	</div>	
</div>

<?php if ($_SESSION['log']['idSis_Empresa'] != 5) { ?>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<?php #echo form_open('agenda', 'role="form"'); ?>
		<?php echo form_open($form_open_path, 'role="form"'); ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				
				<?php if($paginacao == "N") { ?>					
					<div class="row text-left">
						<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-left" >
							<label for="Dia">Dia:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
						<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-left" >
							<label for="Mesvenc">Mês:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 text-left" >
							<label for="Ano">Ano:</label>
							<!--<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA" name="Ano" id="Ano" value="<?php #echo set_value('Ano', $query['Ano']); ?>">-->
							<div class="input-group">
								<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA" name="Ano" id="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
								<!--
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
								-->
							</div>
						</div>
					</div>
					<br>
					<div class="row text-left">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left" >
							<label for="Texto1">Texto1:</label>
							<div class="">
								<input type="text" class="form-control" maxlength="200" placeholder="Ex. Olá" name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>">
							</div>
						</div>
					</div>				
					<div class="row text-left">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left" >
							<label></label><br>
							<div class="">
								<input type="text" class="form-control" placeholder="Nome do Cliente" readonly="">
							</div>
						</div>
					</div>					
					<div class="row text-left">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left" >
							<label for="Texto2">Texto2:</label>
							<div class="input-group">
								<input type="text" class="form-control" maxlength="200" placeholder="Ex. Passando para te desejar feliz aniversário!" name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>">
								<span class="input-group-btn">
									<button class="btn btn-info btn-md" type="submit">
										<span class="glyphicon glyphicon-search"></span> 
									</button>
								</span>
							</div>
						</div>
					</div>
				<?php } ?>
				<!--
				<div class=" btn btn-info" type="button" data-toggle="collapse" data-target="#Aniversariantes" aria-expanded="false" aria-controls="Aniversariantes">
					<span class="glyphicon glyphicon-pencil"></span> Aniversariantes
				</div>
				
				
				<a class="btn btn-sm btn-info" href="<?php #echo base_url() ?>relatorio/alterarprocedimento" role="button">
					<span class="glyphicon glyphicon-search"></span> Todas
				</a>
				<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>procedimento/cadastrar" role="button">
					<span class="glyphicon glyphicon-plus"></span> Cad.
				</a>
				-->
			</div>
			<div <?php echo $collapse; ?> id="Aniversariantes">
				<?php echo (isset($list)) ? $list : FALSE ?>
			</div>
		</div>
	</div>
<?php } ?>	