<?php if ($msg) echo $msg; ?>

	<div class="col-md-12">
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-info">

					<div class="panel-heading"><span class="glyphicon glyphicon-pencil"></span><strong> Ranking de Vendas<?php #echo $titulo; ?></strong></div>
					<div class="panel-body">

						<?php echo form_open('relatorio/rankingvendas', 'role="form"'); ?>

						<div class="form-group">
							<div class="row">
								<div class="col-md-8 text-left">
									<label  id="NomeClienteAuto1">Cliente: <?php echo $cadastrar['NomeClienteAuto']; ?></label>
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-info btn-md" type="submit">
												<span class="glyphicon glyphicon-search"></span> 
											</button>
										</span>
										<input type="text" autofocus name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
										<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
										<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
										<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
									</div>
								</div>
								<!--
								<div class="col-md-4">
									<label for="Ordenamento">Cliente</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="NomeCliente" name="NomeCliente">
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
								<div class="col-md-4">
									<label for="Ordenamento">Ordenamento:</label>

									<div class="form-group">
										<div class="row">
											<div class="col-md-7">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="Campo" name="Campo">
													<?php
													foreach ($select['Campo'] as $key => $row) {
														if ($query['Campo'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>

											<div class="col-md-5">
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="Ordenamento" name="Ordenamento">
													<?php
													foreach ($select['Ordenamento'] as $key => $row) {
														if ($query['Ordenamento'] == $key) {
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
								</div>								
							</div>												
							<div class="row">
								<div class="col-md-2">
									<label for="Pedidos_de">Pedidos de:</label>
									<div class="input-group ">
										<span class="input-group-addon" disabled>Qtd</span>
										<input type="text" class="form-control Numero" maxlength="10" placeholder="Ex. 1"
									    name="Pedidos_de" value="<?php echo set_value('Pedidos_de', $query['Pedidos_de']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="Pedidos_ate">Pedidos até:</label>
									<div class="input-group ">
										<span class="input-group-addon" disabled>Qtd</span>
										<input type="text" class="form-control Numero" maxlength="10" placeholder="Ex. 5"
									    name="Pedidos_ate" value="<?php echo set_value('Pedidos_ate', $query['Pedidos_ate']); ?>">
									</div>
								</div>
							
								<div class="col-md-2">
									<label for="Valor_de">Valor de:</label>
									<div class="input-group ">
										<span class="input-group-addon" disabled>R$</span>
										<input type="text" class="form-control " maxlength="10" placeholder="Ex. 100.00"
									    name="Valor_de" value="<?php echo set_value('Valor_de', $query['Valor_de']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="Valor_ate">Valor até:</label>
									<div class="input-group ">
										<span class="input-group-addon" disabled>R$</span>
										<input type="text" class="form-control " maxlength="10" placeholder="Ex. 200.00"
									    name="Valor_ate" value="<?php echo set_value('Valor_ate', $query['Valor_ate']); ?>">
									</div>
								</div>
							
								<div class="col-md-2">
									<label for="DataInicio">Data Início: *</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									    name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim">Data Fim: (opc.)</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
									   name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
									</div>
								</div>								
							</div>												
							<div class="row">	
								<div class="col-md-2 text-left"><br />
									<button class="btn btn-lg btn-warning" name="pesquisar" value="0" type="submit">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
							</div>
						</div>

						</form>

						<?php echo (isset($list)) ? $list : FALSE ?>

					</div>

				</div>

			</div>

		</div>
	</div>
	
