<?php if ($msg) echo $msg; ?>
<!--<?php #echo form_open('relatorio/rankingvendas', 'role="form"'); ?>-->
<?php echo form_open($form_open_path, 'role="form"'); ?>
<div class="col-md-12 ">
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php if($paginacao == "N") { ?>
				<div class="btn-group " role="group" aria-label="...">
					<div class="row text-left">	
						<div class="col-md-12">
							<div class="col-md-8 text-left">
								<label  >Cliente:</label>
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-info btn-md" type="submit">
											<span class="glyphicon glyphicon-search"></span> 
										</button>
									</span>
									<input type="text" autofocus name="id_Cliente_Auto" id="id_Cliente_Auto" value="<?php echo $cadastrar['id_Cliente_Auto']; ?>" class="form-control" placeholder="Pesquisar Cliente">
								</div>
								<span class="modal-title" id="NomeClienteAuto1"><?php echo $cadastrar['NomeClienteAuto']; ?></span>
								<input type="hidden" id="NomeClienteAuto" name="NomeClienteAuto" value="<?php echo $cadastrar['NomeClienteAuto']; ?>" />
								<input type="hidden" id="Hidden_id_Cliente_Auto" name="Hidden_id_Cliente_Auto" value="<?php echo $query['idApp_Cliente']; ?>" />
								<input type="hidden" name="idApp_Cliente" id="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>" class="form-control" readonly= "">
							</div>
							<div class="col-md-2 text-left">
								<label>Filtros</label><br>
								<button  class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
									<span class="glyphicon glyphicon-filter"></span>
								</button>
							</div>
							<div class="col-md-2">
								<label>CashBack</label><br>
								<a href="<?php echo base_url() . 'cliente/alterarcashback/' . $_SESSION['log']['idSis_Empresa']; ?>">
									<button class="btn btn-success btn-md btn-block" type="button">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
								</a>
							</div>
						</div>
					</div>	
				</div>
			<?php } ?>	
		</div>		
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>

</div>

<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="row text-left">
						<div class="col-md-6">
							<label for="Pedidos_de">Pedidos de:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>Qtd</span>
								<input type="text" class="form-control Numero" maxlength="10" placeholder="Ex. 1"
								name="Pedidos_de" value="<?php echo set_value('Pedidos_de', $query['Pedidos_de']); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<label for="Pedidos_ate">Pedidos até:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>Qtd</span>
								<input type="text" class="form-control Numero" maxlength="10" placeholder="Ex. 5"
								name="Pedidos_ate" value="<?php echo set_value('Pedidos_ate', $query['Pedidos_ate']); ?>">
							</div>
						</div>
					</div>	
				</div>	
				<div class="form-group">	
					<div class="row text-left">	
						<div class="col-md-6">
							<label for="Valor_de">Valor de:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>R$</span>
								<input type="text" class="form-control " maxlength="10" placeholder="Ex. 100.00"
								name="Valor_de" value="<?php echo set_value('Valor_de', $query['Valor_de']); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<label for="Valor_ate">Valor até:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>R$</span>
								<input type="text" class="form-control " maxlength="10" placeholder="Ex. 200.00"
								name="Valor_ate" value="<?php echo set_value('Valor_ate', $query['Valor_ate']); ?>">
							</div>
						</div>						
					</div>
				</div>	
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-6">
							<label for="DataInicio">Data Pedido Início:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
								name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<label for="DataFim">Data Pedido Fim:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
							   name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
							</div>
						</div>								
					</div>
				</div>
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-6">
							<label for="DataInicio2">Data Cash Início: </label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
								name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<label for="DataFim2">Data Cash Fim:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
							   name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-6">
							<label for="Ultimo">Agrupar Pelo:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Ultimo" name="Ultimo">
								<?php
								foreach ($select['Ultimo'] as $key => $row) {
									if ($query['Ultimo'] == $key) {
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
					<div class="row text-left">
						<div class="col-md-12">
							<label for="Ordenamento">Ordenamento:</label>
							<div class="row">
								<div class="col-md-6">
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

								<div class="col-md-6">
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

				<div class="row text-left">
					<br>
					<div class="form-group col-md-6">
						<div class="form-footer ">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove"></span> Fechar
							</button>
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="form-footer ">
							<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-filter"></span> Filtrar
							</button>
						</div>
					</div>
				</div>
			</div>									
		</div>								
	</div>
</div>
