<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php if ($nav_secundario) echo $nav_secundario; ?>	
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
										<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
											   name="RacaPet" value="<?php #echo $query['RacaPet']; ?>">
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
								</div>
							</div>	
							<div class="form-group">
								<div class="row">
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
										<label for="CastradoPet">Castrado?</label><br>
										<div class="form-group">
											<div class="btn-group" data-toggle="buttons">
												<?php
												foreach ($select['CastradoPet'] as $key => $row) {
													(!$query['CastradoPet']) ? $query['CastradoPet'] = 'N' : FALSE;
													if ($query['CastradoPet'] == $key) {
														echo ''
														. '<label class="btn btn-warning active" name="radiobutton_CastradoPet" id="radiobutton_CastradoPet' . $key . '">'
														. '<input type="radio" name="CastradoPet" id="radiobutton" '
														. 'autocomplete="off" value="' . $key . '" checked>' . $row
														. '</label>'
														;
													} else {
														echo ''
														. '<label class="btn btn-default" name="radiobutton_CastradoPet" id="radiobutton_CastradoPet' . $key . '">'
														. '<input type="radio" name="CastradoPet" id="radiobutton" '
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
												/*
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
												*/
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

