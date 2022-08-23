<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<?php echo validation_errors(); ?>
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 ">
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" href="<?php echo base_url() . $relatorio; ?>" role="button">
								<span class="glyphicon glyphicon-pencil"></span><?php echo $titulo; ?>
							</a>
						</div>
						<div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 ">	
							<br>
							<a type= "button" class="btn btn-md btn-info btn-block" type="button" href="<?php echo base_url() . $imprimir; ?>">
								<span class="glyphicon glyphicon-list"></span> Lista
							</a>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ">	
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
								<?php echo $_SESSION['FiltroComissaoFunc']['Contagem'];?> / <?php echo $_SESSION['FiltroComissaoFunc']['Total_Rows'];?> Resultados
							</a>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ">		
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
								<span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['FiltroComissaoFunc']['NomeFuncionario']; ?>
							</a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 ">	
							<br>
							<a type= "button" class="btn btn-md btn-warning btn-block" role="button">
								<span class="glyphicon glyphicon-usd"></span>R$ <?php if(isset($_SESSION['FiltroComissaoFunc']['SomaTotal'])) echo $_SESSION['FiltroComissaoFunc']['SomaTotal']; ?> / <?php echo $_SESSION['FiltroComissaoFunc']['ComissaoTotal'] ?>
							</a>
						</div>
						<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 ">
							<?php echo $_SESSION['FiltroComissaoFunc']['Pagination']; ?>
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
									$linha =  $_SESSION['FiltroComissaoFunc']['Per_Page']*$_SESSION['FiltroComissaoFunc']['Pagina'];
									for ($i=1; $i <= $count['PRCount']; $i++) {
										$contagem = ($linha + $i);
									?>
										<input type="hidden" name="idApp_OrcaTrata<?php echo $i ?>" value="<?php echo $orcamento[$i]['idApp_OrcaTrata']; ?>"/>
										<div class="form-group" id="21div<?php echo $i ?>">
											<div class="panel panel-warning">
												<div class="panel-heading">
													<div class="row">
														<div class="col-md-2">
															<label >Cont: <?php echo $contagem ?> - Nome</label><br>
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
															<label for="ValorComissaoFunc">Comissao:</label><br>
															<div class="input-group" id="txtHint">
																<span class="input-group-addon" id="basic-addon1">R$</span>
																<input type="text" class="form-control Valor"  maxlength="10" placeholder="0,00" id="ValorComissaoFunc<?php echo $i ?>"
																	   name="ValorComissaoFunc<?php echo $i ?>" value="<?php echo $orcamento[$i]['ValorComissaoFunc'] ?>">
															</div>
														</div>
														<div class="col-md-2">
															<label for="StatusComissaoFunc">StatusPago</label>
															<div class="input-group">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-pencil"></span>
																</span>
																<input type="text" class="form-control" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['StatusComissaoFunc'] ?>">																
															</div>
														</div>
														<div class="col-md-2">
															<label for="DataPagoComissaoFunc">DataPago</label>
															<div class="input-group">
																<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
																<input type="text" class="form-control Date" readonly="" value="<?php echo $_SESSION['Orcamento'][$i]['DataPagoComissaoFunc'] ?>">																
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
							<div class="col-md-3 text-left">
								<label for="QuitadoComissao">Seletor de Função</label><br>
								<div class="btn-group" data-toggle="buttons">
									<?php
									foreach ($select['QuitadoComissao'] as $key => $row) {
										if (!$cadastrar['QuitadoComissao'])$cadastrar['QuitadoComissao'] = 'N';

										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

										if ($cadastrar['QuitadoComissao'] == $key) {
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
								<div class="col-md-2 text-left">
									<h4 style="color: #FF0000">Atenção</h4>
									<h5 style="color: #FF0000"><?php if(isset($mensagem)) echo $mensagem ;?></h5>
								</div>
								<div class="col-md-3 text-left">
									<label for="DescricaoRecibo">Descricao</label>
										<input type="text" class="form-control" maxlength="100" id="DescricaoRecibo" name="DescricaoRecibo" value="<?php echo $query['DescricaoRecibo']; ?>">
									<?php echo form_error('DescricaoRecibo'); ?>
								</div>
								<?php 
									$editarData = FALSE;
									if(isset($metodo)) {
										if($metodo == 2){
											$editarData = 'readonly=""';
										}
									}
								?>
								<div class="col-md-2 text-left">
									<label for="DataRecibo">Data do Pagamento</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" <?php echo $editarData; ?> maxlength="10" placeholder="DD/MM/AAAA"
												id="DataRecibo" name="DataRecibo" value="<?php echo $query['DataRecibo']; ?>">
									</div>
									<?php echo form_error('DataRecibo'); ?>
								</div>
							</div>	
							<div class="col-md-2 text-left">
								<label>Confirmar Ação</label>
								<button class="btn btn-md btn-primary btn-block" id="inputDb" data-loading-text="Aguarde..." type="submit">
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
