<?php if ($msg) echo $msg; ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<!--<?php #echo form_open('relatorio/rankingvendas', 'role="form"'); ?>-->
	<?php echo form_open($form_open_path, 'role="form"'); ?>
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<?php if($paginacao == "N") { ?>
			<div class="panel-heading">
				<div class="btn-group " role="group" aria-label="...">
					<div class="row text-left">	
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
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
						<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
							<label>Filtros</label><br>
							<button  class="btn btn-warning btn-md btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span>
							</button>
						</div>
					</div>	
				</div>	
			</div>	
		<?php } ?>	
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</div>

<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="row text-left">
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="Pedidos_de">Pdds. de:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>Qtd</span>
								<input type="text" class="form-control Numero" maxlength="10" placeholder="Ex. 1"
								name="Pedidos_de" value="<?php echo set_value('Pedidos_de', $query['Pedidos_de']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="Pedidos_ate">Pdds. até:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>Qtd</span>
								<input type="text" class="form-control Numero" maxlength="10" placeholder="Ex. 5"
								name="Pedidos_ate" value="<?php echo set_value('Pedidos_ate', $query['Pedidos_ate']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="Valor_de">Valor Total de:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>R$</span>
								<input type="text" class="form-control " maxlength="10" placeholder="Ex. 100.00"
								name="Valor_de" value="<?php echo set_value('Valor_de', $query['Valor_de']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="Valor_ate">Valor Total até:</label>
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
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="DataInicio">Dt.Pdd Iní:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
								name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="DataFim">Dt.Pdd Fim:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
							   name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="DataInicio3">Dt.Ult.Pdd.Ini: </label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
								name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="DataFim3">Dt.Ult.Pdd.Fim:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
							   name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="DataInicio2">Dt.Cash.Iní: </label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
								name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="DataFim2">Dt.Cash.Fim:</label>
							<div class="input-group DatePicker">
								<span class="input-group-addon" disabled>
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
							   name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
							</div>
						</div>	
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="Valor_cash_de">Valor Cash de:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>R$</span>
								<input type="text" class="form-control " maxlength="10" placeholder="Ex. 100.00"
								name="Valor_cash_de" value="<?php echo set_value('Valor_cash_de', $query['Valor_cash_de']); ?>">
							</div>
						</div>
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
							<label for="Valor_cash_ate">Valor Cash até:</label>
							<div class="input-group ">
								<span class="input-group-addon" disabled>R$</span>
								<input type="text" class="form-control " maxlength="10" placeholder="Ex. 200.00"
								name="Valor_cash_ate" value="<?php echo set_value('Valor_cash_ate', $query['Valor_cash_ate']); ?>">
							</div>
						</div>						
					</div>
				</div>
				<!--
				<div class="form-group">	
					<div class="row text-left">
						<div class="col-md-6">
							<label for="Ultimo">Agrupar Pelo:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen" id="Ultimo" name="Ultimo">
								<?php
								/*
								foreach ($select['Ultimo'] as $key => $row) {
									if ($query['Ultimo'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								*/
								?>
							</select>
						</div>				
					</div>
				</div>
				-->
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
				<div class="form-group text-left">
					<label class="text-left">Texto Whatsapp:</label>
					<div class="row text-left">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Pt1</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. Olá" name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>"><?php echo set_value('Texto1', $query['Texto1']); ?></textarea>
							</div>
						</div>
						<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
							<label for="nomedo<?php echo $nome?>">Nome do <?php echo $nome?>?</label><br>
							<div class="btn-larg-right btn-group" data-toggle="buttons">
								<?php
								foreach ($select['nomedo' . $nome] as $key => $row) {
									if (!$query['nomedo' . $nome]) $query['nomedo' . $nome] = 'N';
									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
									if ($query['nomedo' . $nome] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="nomedo' . $nome . '_' . $hideshow . '">'
										. '<input type="radio" name="nomedo' . $nome . '" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="nomedo' . $nome . '_' . $hideshow . '">'
										. '<input type="radio" name="nomedo' . $nome . '" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" >' . $row
										. '</label>'
										;
									}
								}
								?>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Pt2</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>"><?php echo set_value('Texto2', $query['Texto2']); ?></textarea>
							</div>
						</div>
						<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
							<label for="id<?php echo $nome?>">Valor do CashBack?</label><br>
							<div class="btn-larg-right btn-group" data-toggle="buttons">
								<?php
								foreach ($select['id' . $nome] as $key => $row) {
									if (!$query['id' . $nome]) $query['id' . $nome] = 'N';
									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
									if ($query['id' . $nome] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="id' . $nome . '_' . $hideshow . '">'
										. '<input type="radio" name="id' . $nome . '" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="id' . $nome . '_' . $hideshow . '">'
										. '<input type="radio" name="id' . $nome . '" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" >' . $row
										. '</label>'
										;
									}
								}
								?>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Pt3</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" name="Texto3" id="Texto3" value="<?php echo set_value('Texto3', $query['Texto3']); ?>"><?php echo set_value('Texto3', $query['Texto3']); ?></textarea>
							</div>
						</div>
						<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
							<label for="numerodopedido">Vldd.do CashBack?</label><br>
							<div class="btn-larg-right btn-group" data-toggle="buttons">
								<?php
								foreach ($select['numerodopedido'] as $key => $row) {
									if (!$query['numerodopedido']) $query['numerodopedido'] = 'N';
									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
									if ($query['numerodopedido'] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="numerodopedido_' . $hideshow . '">'
										. '<input type="radio" name="numerodopedido" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="numerodopedido_' . $hideshow . '">'
										. '<input type="radio" name="numerodopedido" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" >' . $row
										. '</label>'
										;
									}
								}
								?>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Pt4</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. tal tal tal tal!" name="Texto4" id="Texto4" value="<?php echo set_value('Texto4', $query['Texto4']); ?>"><?php echo set_value('Texto4', $query['Texto4']); ?></textarea>
							</div>
						</div>
						<div class="col-xs-6 col-sm-3  col-md-3 col-lg-3 text-left">
							<label for="site">Site?</label><br>
							<div class="btn-larg-right btn-group" data-toggle="buttons">
								<?php
								foreach ($select['site'] as $key => $row) {
									if (!$query['site']) $query['site'] = 'N';
									($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
									if ($query['site'] == $key) {
										echo ''
										. '<label class="btn btn-warning active" name="site_' . $hideshow . '">'
										. '<input type="radio" name="site" id="' . $hideshow . '" '
										. 'autocomplete="off" value="' . $key . '" checked>' . $row
										. '</label>'
										;
									} else {
										echo ''
										. '<label class="btn btn-default" name="site_' . $hideshow . '">'
										. '<input type="radio" name="site" id="' . $hideshow . '" '
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
				<!--
				<div class="form-group text-left">
					<label class="text-left">Texto Whatsapp:</label>
					<div class="row text-left">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Tx1</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. Olá" name="Texto1" id="Texto1" value="<?php echo set_value('Texto1', $query['Texto1']); ?>" rows="2"><?php echo set_value('Texto1', $query['Texto1']); ?></textarea>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="">
								<textarea type="text" class="form-control" placeholder="Nome do Cliente" readonly="" rows="2"></textarea>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Tx2</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex.. Você possui " name="Texto2" id="Texto2" value="<?php echo set_value('Texto2', $query['Texto2']); ?>" rows="2"><?php echo set_value('Texto2', $query['Texto2']); ?></textarea>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="">
								<textarea type="text" class="form-control" placeholder="R$xxx,xx" readonly="" rows="2"></textarea>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Tx3</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex. em desconto, válidos até" name="Texto3" id="Texto3" value="<?php echo set_value('Texto3', $query['Texto3']); ?>" rows="2"><?php echo set_value('Texto3', $query['Texto3']); ?></textarea>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="">
								<textarea type="text" class="form-control" placeholder="dd/mm/aaaa" readonly="" rows="2"></textarea>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left" >
							<div class="input-group">
								<span class="input-group-addon" disabled>Tx4</span>
								<textarea type="text" class="form-control" maxlength="200" placeholder="Ex.. Aproveite e visite o nosso site https://enkontraki.com.br/seusite" name="Texto4" id="Texto4" value="<?php echo set_value('Texto4', $query['Texto4']); ?>" rows="2"><?php echo set_value('Texto4', $query['Texto4']); ?></textarea>
							</div>
						</div>
					</div>
				</div>
				-->
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
