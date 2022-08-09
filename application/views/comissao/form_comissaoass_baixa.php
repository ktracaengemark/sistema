<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 ">
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() . $relatorio; ?>" role="button">
								<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo; ?>
							</a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 ">	
							<br>
							<a type= "button" class="btn btn-md btn-info btn-block" type="button" href="<?php echo base_url() . $imprimir; ?>">
								<span class="glyphicon glyphicon-list"></span> Lista
							</a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 ">	
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
								<?php echo $_SESSION['FiltroComissaoAss']['Contagem'];?> / <?php echo $_SESSION['FiltroComissaoAss']['Total_Rows'];?> Resultados
							</a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 ">	
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
								<span class="glyphicon glyphicon-usd"></span>R$ <?php if(isset($_SESSION['FiltroComissaoAss']['SomaTotal'])) echo $_SESSION['FiltroComissaoAss']['SomaTotal']; ?> / <?php echo $_SESSION['FiltroComissaoAss']['ComissaoTotal'] ?>
							</a>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 ">
							<?php echo $_SESSION['FiltroComissaoAss']['Pagination']; ?>
						</div>
					</div>	
				</div>
				<div class="panel-body">

					<div class="panel-group">	
						
						<div class="panel panel-primary">

							<div  style="overflow: auto; height: 456px; ">
							
								<div class="panel-body">
									<!--App_parcelasRec-->
									<input type="hidden" name="PRCount" id="PRCount" value="<?php echo $count['PRCount']; ?>"/>

									<div class="input_fields_wrap21">

									<?php
									$linha =  $_SESSION['FiltroComissaoAss']['Per_Page']*$_SESSION['FiltroComissaoAss']['Pagina'];
									for ($i=1; $i <= $count['PRCount']; $i++) {
										$contagem = ($linha + $i);
									?>
										<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $orcamento[$i]['idApp_OrcaTrata']; ?>"/>
										<div class="form-group" id="21div<?php echo $i ?>">
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-2">
															<label >Cont : <?php echo $contagem ?> - <?php echo $nomeusuario; ?></label><br>
															<span><?php echo $_SESSION['Orcamento'][$i][$nomeusuario] ?></span>
														</div>
														<div class="col-md-2">
															<label for="DataOrca">Receita - <?php echo $orcamento[$i]['idApp_OrcaTrata'] ?> - <?php echo $_SESSION['Orcamento'][$i]['Tipo_Orca'] ?></label>
															<div class="input-group DatePicker">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
																<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['DataOrca'] ?>">																
															</div>
														</div>
														<div class="col-md-2">
															<label for="ValorRestanteOrca">Prd+Srv:</label><br>
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['ValorRestanteOrca'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<label for="ValorComissaoAssoc">Comissao:</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor"  maxlength="10" placeholder="0,00" id="ValorComissaoAssoc<?php echo $i ?>"
																	   name="ValorComissaoAssoc<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorComissaoAssoc'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<label for="StatusComissaoOrca">StatusPago</label>
															<div class="input-group">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-pencil"></span>
																</span>
																<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['StatusComissaoOrca'] ?>">																
															</div>
														</div>
														<div class="col-md-2">
															<label for="DataPagoComissaoOrca">DataPago</label>
															<div class="input-group">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
																<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['DataPagoComissaoOrca'] ?>">																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

									<?php
									}
									?>
									</div>
								</div>
							</div>									
						</div>
					</div>
				
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
							
							<div class="col-md-2 text-left">
								<label for="QuitadoComissao">Confirma Baixa?</label><br>
								<div class="btn-group" data-toggle="buttons">
									<?php
									foreach ($select['QuitadoComissao'] as $key => $row) {
										if (!$query['QuitadoComissao'])$query['QuitadoComissao'] = 'N';

										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

										if ($query['QuitadoComissao'] == $key) {
											echo ''
											. '<label class="btn btn-warning active" name="QuitadoComissao_' . $hideshow . '">'
											. '<input type="radio" name="QuitadoComissao" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" checked>' . $row
											. '</label>'
											;
										} else {
											echo ''
											. '<label class="btn btn-default" name="QuitadoComissao_' . $hideshow . '">'
											. '<input type="radio" name="QuitadoComissao" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" >' . $row
											. '</label>'
											;
										}
									}
									?>
								</div>
								<?php #echo form_error('QuitadoComissao'); ?>
							</div>

							<div id="QuitadoComissao" <?php echo $div['QuitadoComissao']; ?>>
								<div class="col-md-4 text-left">
									<h4 style="color: #FF0000">Atenção</h4>
									<h5 style="color: #FF0000">Todas as Comissões receberão:" Pago = Sim "</h5>
								</div>
								<div class="col-md-2 text-left">
									<label for="DataPagoComissãoPadrao">Data do Pagamento Padrao</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
												id="DataPagoComissãoPadrao" name="DataPagoComissãoPadrao" value="<?php echo $query['DataPagoComissãoPadrao']; ?>">
									</div>
									<?php echo form_error('DataPagoComissãoPadrao'); ?>
								</div>
							</div>	
							<div class="col-md-4 text-right">
								<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
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
