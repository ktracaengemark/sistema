<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php echo form_open_multipart($form_open_path); ?>
						<div class="panel panel-primary">
							<div class="panel-heading">
							</div>			
							<div class="panel-body">
								<div class="row">	
									<div class="col-md-12">	
									
										<?php echo validation_errors(); ?>

										<div class="panel panel-info">
											<div class="panel-heading">
												<h3 class="text-left">Dados do Administrador  </h3>
												<div class="form-group">
													<div class="row">
														<div class="col-md-3">
															<label for="NomeAdmin">Nome do Admin.:</label>
															<input type="text" class="form-control" id="NomeAdmin" maxlength="45" 
																	name="NomeAdmin" autofocus value="<?php echo $query['NomeAdmin']; ?>">
														</div>
														<div class="col-md-3">
															<label for="DataNascimento">Data do Aniver.:</label>
															<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
																   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
														</div>	
													</div>
												</div>
												<h3 class="text-left">Dados da Empresa  </h3>									
												<div class="form-group">
													<div class="row">											
														<div class="col-md-3">
															<label for="NomeEmpresa">Nome da Empresa:</label>
															<input type="text" class="form-control" id="NomeEmpresa" maxlength="45" 
																	name="NomeEmpresa" autofocus value="<?php echo $query['NomeEmpresa']; ?>">
														</div>
														<div class="col-md-3">
															<label for="CategoriaEmpresa">Categoria:*</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																	id="CategoriaEmpresa" name="CategoriaEmpresa">
																<option value="">-- Selec. uma Categoria --</option>
																<?php
																foreach ($select['CategoriaEmpresa'] as $key => $row) {
																	if ($query['CategoriaEmpresa'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>   
															</select>
															<?php echo form_error('CategoriaEmpresa'); ?>          
														</div>
														<div class="col-md-3">
															<label for="Telefone">Whatsapp Empresa:</label>
															<input type="text" class="form-control Celular CelularVariavel" id="Telefone" maxlength="11" <?php echo $readonly; ?>
																   name="Telefone" placeholder="(XX)999999999" value="<?php echo $query['Telefone']; ?>">
														</div>
														<div class="col-md-3">
															<label for="Site">Site:</label><br>
															<span >enkontraki.com.br/<?php echo $_SESSION['Empresa']['Site']; ?></span>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3">
															<label for="Atuacao">Atuação:</label>
															<textarea class="form-control" id="Atuacao" <?php echo $readonly; ?>
																	  name="Atuacao"><?php echo $query['Atuacao']; ?></textarea>
														</div>
														<!--
														<div class="col-md-3">
															<label for="Atendimento">Atendimento:</label>
															<textarea class="form-control" id="Atendimento" <?php echo $readonly; ?>
																	  name="Atendimento"><?php #echo $query['Atendimento']; ?></textarea>
														</div>
														<div class="col-md-3">
															<label for="SobreNos">Sobre Nós:</label>
															<textarea class="form-control" id="SobreNos" <?php echo $readonly; ?>
																	  name="SobreNos"><?php #echo $query['SobreNos']; ?></textarea>
														</div>
														-->
													</div>
												</div>
												
												<div class="form-group">
													<div class="row">
														<div class="col-md-12 text-center">
															<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
																<span class="glyphicon glyphicon-menu-down"></span> Completar Dados
															</button>
														</div>
													</div>
												</div>

												<div <?php echo $collapse; ?> id="DadosComplementares">
													<div class="form-group">
														<div class="row">										
															<div class="col-md-3">
																<label for="Email">E-mail Admin.:</label>
																<input type="text" class="form-control" id="BairroEmpresa" maxlength="100" <?php echo $readonly; ?>
																	   name="Email" value="<?php echo $query['Email']; ?>">
															</div>												
															<div class="col-md-3">
																<label for="Cnpj">Cnpj:</label>
																<input type="text" class="form-control Cnpj" maxlength="18" <?php echo $readonly; ?>
																	   name="Cnpj" placeholder="99.999.999/9999-98" value="<?php echo $query['Cnpj']; ?>">
															</div>
															<div class="col-md-3">
																<label for="InscEstadual">Insc.Estadual:</label>
																<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
																	   name="InscEstadual" value="<?php echo $query['InscEstadual']; ?>">
															</div>																				
														</div>
													</div>
													
													<div class="form-group">
														<div class="row">
															<div class="col-md-4">
																<label for="EnderecoEmpresa">Endreço:</label>
																<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
																	   name="EnderecoEmpresa" value="<?php echo $query['EnderecoEmpresa']; ?>">
															</div>
															<div class="col-md-2">
																<label for="NumeroEmpresa">Numero:</label>
																<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
																	   name="NumeroEmpresa" value="<?php echo $query['NumeroEmpresa']; ?>">
															</div>
															<div class="col-md-3">
																<label for="ComplementoEmpresa">Complemento:</label>
																<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																	   name="ComplementoEmpresa" value="<?php echo $query['ComplementoEmpresa']; ?>">
															</div>
															<div class="col-md-3">
																<label for="BairroEmpresa">Bairro:</label>
																<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																	   name="BairroEmpresa" value="<?php echo $query['BairroEmpresa']; ?>">
															</div>
														</div>	
														<div class="row">	
															<div class="col-md-3">
																<label for="MunicipioEmpresa">Municipio:</label>
																<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																	   name="MunicipioEmpresa" value="<?php echo $query['MunicipioEmpresa']; ?>">
															</div>												
															<div class="col-md-3">
																<label for="EstadoEmpresa">Estado:</label>
																<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																	   name="EstadoEmpresa" value="<?php echo $query['EstadoEmpresa']; ?>">
															</div>
															<div class="col-md-3">
																<label for="CepEmpresa">Cep:</label>
																<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
																	   name="CepEmpresa" value="<?php echo $query['CepEmpresa']; ?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-md-2">
																<h3 class="text-left">Cadastro:</h3>
															</div>
															<div class="col-md-2 text-left">
																<label for="CadastrarPet">Cadastra Pets?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['CadastrarPet'] as $key => $row) {
																		if (!$query['CadastrarPet'])$query['CadastrarPet'] = 'N';

																		($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($query['CadastrarPet'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="CadastrarPet_' . $hideshow . '">'
																			. '<input type="radio" name="CadastrarPet" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="CadastrarPet_' . $hideshow . '">'
																			. '<input type="radio" name="CadastrarPet" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
															<div id="CadastrarPet" <?php echo $div['CadastrarPet']; ?>>
																<div class="col-md-3 text-left">
																	<label for="CadastrarDep">Cadastra Dependentes?</label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['CadastrarDep'] as $key => $row) {
																			if (!$query['CadastrarDep'])$query['CadastrarDep'] = 'N';

																			($key == 'N') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($query['CadastrarDep'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="CadastrarDep_' . $hideshow . '">'
																				. '<input type="radio" name="CadastrarDep" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="CadastrarDep_' . $hideshow . '">'
																				. '<input type="radio" name="CadastrarDep" id="' . $hideshow . '" '
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
													<div class="form-group">
														<div class="row">
															<div class="col-md-2">
																<h3 class="text-left">Entrega:</h3>
															</div>
															<div class="col-md-2">
																<label for="TaxaEntrega">Taxa de Entrega:</label><br>
																<div class="input-group">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
																			name="TaxaEntrega" value="<?php echo $query['TaxaEntrega'] ?>">
																</div>
															</div>
														</div>
													</div>	
													<div class="form-group">
														<div class="row">
															<div class="col-md-2">
																<h3 class="text-left">Valor Mínimo:</h3>
															</div>
															<div class="col-md-2">
																<label for="ValorMinimo">A Partir de:</label><br>
																<div class="input-group">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
																			name="ValorMinimo" value="<?php echo $query['ValorMinimo'] ?>">
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-md-2">
																<h3 class="text-left">Conta:</h3>
															</div>	
															<div class="col-md-3">
																<label for="BancoEmpresa">Banco:</label>
																<input type="text" class="form-control" maxlength="100"
																	   name="BancoEmpresa" value="<?php echo $query['BancoEmpresa']; ?>">
															</div>												
															<div class="col-md-3">
																<label for="AgenciaEmpresa">Agencia:</label>
																<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																	   name="AgenciaEmpresa" value="<?php echo $query['AgenciaEmpresa']; ?>">
															</div>
															<div class="col-md-3">
																<label for="ContaEmpresa">Conta:</label>
																<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																	   name="ContaEmpresa" value="<?php echo $query['ContaEmpresa']; ?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-md-2">
																<h3 class="text-left">Chave:</h3>
															</div>	
															<div class="col-md-3">
																<label for="PixEmpresa">Pix:</label>
																<input type="text" class="form-control" maxlength="100"
																	   name="PixEmpresa" value="<?php echo $query['PixEmpresa']; ?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-md-2">
																<h3 class="text-left">CashBack:</h3>
															</div>
															<div class="col-md-3 text-left">
																<label for="CashBackAtivo">Ativo?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['CashBackAtivo'] as $key => $row) {
																		if (!$query['CashBackAtivo'])$query['CashBackAtivo'] = 'N';

																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($query['CashBackAtivo'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="CashBackAtivo_' . $hideshow . '">'
																			. '<input type="radio" name="CashBackAtivo" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="CashBackAtivo_' . $hideshow . '">'
																			. '<input type="radio" name="CashBackAtivo" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
															<div id="CashBackAtivo" <?php echo $div['CashBackAtivo']; ?>>
																<div class="col-md-2">
																	<label for="PrazoCashBackEmpresa">Prazo:</label><br>
																	<div class="input-group">
																		<input type="text" class="form-control Numero" maxlength="2" placeholder="Ex.: 7 Dias"
																				name="PrazoCashBackEmpresa" value="<?php echo $query['PrazoCashBackEmpresa'] ?>">
																		<span class="input-group-addon">Dias</span>
																	</div>
																</div>
															</div>
														</div>
													</div>	
													<h3 class="text-left">Dados do E-Comerce</h3>
													<div class="form-group">
														<div class="row">
															<div class="col-md-3 text-left">
																<label for="EComerce">E-Comerce Ativo?</label><br>
																<div class="btn-group" data-toggle="buttons">
																	<?php
																	foreach ($select['EComerce'] as $key => $row) {
																		if (!$query['EComerce'])$query['EComerce'] = 'S';

																		($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																		if ($query['EComerce'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="EComerce_' . $hideshow . '">'
																			. '<input type="radio" name="EComerce" id="' . $hideshow . '" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="EComerce_' . $hideshow . '">'
																			. '<input type="radio" name="EComerce" id="' . $hideshow . '" '
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
													<div id="EComerce" <?php echo $div['EComerce']; ?>>
														<div class="form-group">
															<div class="row">
																<div class="col-md-2">
																	<h3 class="text-left">Entrega:</h3>
																</div>
																<div class="col-md-2">
																	<label for="RetirarLoja">Retirar na Loja?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['RetirarLoja'] as $key => $row) {
																				(!$query['RetirarLoja']) ? $query['RetirarLoja'] = 'S' : FALSE;

																				if ($query['RetirarLoja'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_RetirarLoja" id="radiobutton_RetirarLoja' . $key . '">'
																					. '<input type="radio" name="RetirarLoja" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_RetirarLoja" id="radiobutton_RetirarLoja' . $key . '">'
																					. '<input type="radio" name="RetirarLoja" id="radiobutton" '
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
																	<label for="MotoBoy">Moto Boy?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['MotoBoy'] as $key => $row) {
																				(!$query['MotoBoy']) ? $query['MotoBoy'] = 'S' : FALSE;

																				if ($query['MotoBoy'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_MotoBoy" id="radiobutton_MotoBoy' . $key . '">'
																					. '<input type="radio" name="MotoBoy" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_MotoBoy" id="radiobutton_MotoBoy' . $key . '">'
																					. '<input type="radio" name="MotoBoy" id="radiobutton" '
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
																	<label for="Correios">Correios?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Correios'] as $key => $row) {
																				(!$query['Correios']) ? $query['Correios'] = 'S' : FALSE;

																				if ($query['Correios'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Correios" id="radiobutton_Correios' . $key . '">'
																					. '<input type="radio" name="Correios" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Correios" id="radiobutton_Correios' . $key . '">'
																					. '<input type="radio" name="Correios" id="radiobutton" '
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
														<div class="form-group">
															<div class="row">
																<div class="col-md-2">
																	<h3 class="text-left">Pagamento:</h3>
																</div>
																<div class="col-md-2">
																	<label for="NaLoja">NaLoja?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['NaLoja'] as $key => $row) {
																				(!$query['NaLoja']) ? $query['NaLoja'] = 'S' : FALSE;

																				if ($query['NaLoja'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_NaLoja" id="radiobutton_NaLoja' . $key . '">'
																					. '<input type="radio" name="NaLoja" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_NaLoja" id="radiobutton_NaLoja' . $key . '">'
																					. '<input type="radio" name="NaLoja" id="radiobutton" '
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
																	<label for="NaEntrega">NaEntrega?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['NaEntrega'] as $key => $row) {
																				(!$query['NaEntrega']) ? $query['NaEntrega'] = 'S' : FALSE;

																				if ($query['NaEntrega'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_NaEntrega" id="radiobutton_NaEntrega' . $key . '">'
																					. '<input type="radio" name="NaEntrega" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_NaEntrega" id="radiobutton_NaEntrega' . $key . '">'
																					. '<input type="radio" name="NaEntrega" id="radiobutton" '
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
																	<label for="OnLine">OnLine?</label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['OnLine'] as $key => $row) {
																			if (!$query['OnLine'])$query['OnLine'] = 'S';

																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($query['OnLine'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="OnLine_' . $hideshow . '">'
																				. '<input type="radio" name="OnLine" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="OnLine_' . $hideshow . '">'
																				. '<input type="radio" name="OnLine" id="' . $hideshow . '" '
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
														<div id="OnLine" <?php echo $div['OnLine']; ?>>
															<div class="form-group">
																<div class="row">
																	<div class="col-md-2">
																		<h3 class="text-left">OnLine:</h3>
																	</div>
																	<div class="col-md-2">
																		<label for="Debito">Debito?</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['Debito'] as $key => $row) {
																					(!$query['Debito']) ? $query['Debito'] = 'S' : FALSE;

																					if ($query['Debito'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_Debito" id="radiobutton_Debito' . $key . '">'
																						. '<input type="radio" name="Debito" id="radiobutton" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_Debito" id="radiobutton_Debito' . $key . '">'
																						. '<input type="radio" name="Debito" id="radiobutton" '
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
																		<label for="Cartao">Cartao?</label><br>
																		<div class="form-group">
																			<div class="btn-group" data-toggle="buttons">
																				<?php
																				foreach ($select['Cartao'] as $key => $row) {
																					(!$query['Cartao']) ? $query['Cartao'] = 'S' : FALSE;

																					if ($query['Cartao'] == $key) {
																						echo ''
																						. '<label class="btn btn-warning active" name="radiobutton_Cartao" id="radiobutton_Cartao' . $key . '">'
																						. '<input type="radio" name="Cartao" id="radiobutton" '
																						. 'autocomplete="off" value="' . $key . '" checked>' . $row
																						. '</label>'
																						;
																					} else {
																						echo ''
																						. '<label class="btn btn-default" name="radiobutton_Cartao" id="radiobutton_Cartao' . $key . '">'
																						. '<input type="radio" name="Cartao" id="radiobutton" '
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
																		<label for="Boleto">Boleto?</label><br>
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Boleto'] as $key => $row) {
																				if (!$query['Boleto'])$query['Boleto'] = 'S';

																				($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																				if ($query['Boleto'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="Boleto_' . $hideshow . '">'
																					. '<input type="radio" name="Boleto" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="Boleto_' . $hideshow . '">'
																					. '<input type="radio" name="Boleto" id="' . $hideshow . '" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																	<div id="Boleto" <?php echo $div['Boleto']; ?>>
																		<div class="col-md-3">
																			<label for="TipoBoleto">Tipo do Boleto?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['TipoBoleto'] as $key => $row) {
																						(!$query['TipoBoleto']) ? $query['TipoBoleto'] = 'L' : FALSE;

																						if ($query['TipoBoleto'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_TipoBoleto" id="radiobutton_TipoBoleto' . $key . '">'
																							. '<input type="radio" name="TipoBoleto" id="radiobutton" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_TipoBoleto" id="radiobutton_TipoBoleto' . $key . '">'
																							. '<input type="radio" name="TipoBoleto" id="radiobutton" '
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
																<div class="col-md-2">
																	<h3 class="text-left">Associado:</h3>
																</div>
																<div class="col-md-3 text-left">
																	<label for="AssociadoAtivo">Ativo?</label><br>
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['AssociadoAtivo'] as $key => $row) {
																			if (!$query['AssociadoAtivo'])$query['AssociadoAtivo'] = 'N';

																			($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

																			if ($query['AssociadoAtivo'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="AssociadoAtivo_' . $hideshow . '">'
																				. '<input type="radio" name="AssociadoAtivo" id="' . $hideshow . '" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="AssociadoAtivo_' . $hideshow . '">'
																				. '<input type="radio" name="AssociadoAtivo" id="' . $hideshow . '" '
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
										</div>
									</div>
								</div>
								<input type="hidden" name="idSis_Empresa" value="<?php echo $query['idSis_Empresa']; ?>">
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-primary">
											<div class="panel-heading">
												<div class="btn-group">
													<button class="btn btn-md btn-default" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
											</div>
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
<?php } ?>