<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10">		
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
					<div class="panel-body">

						<?php echo form_open('relatorio/produtosvend', 'role="form"'); ?>

						<div class="form-group">
							<div class="row">                           								
								<div class="col-md-4">
									<label for="Ordenamento">Nome do Cliente:</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="NomeCliente" name="NomeCliente">
										<?php
										foreach ($select['NomeCliente'] as $key => $row) {
											if ($query['NomeCliente'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="Ordenamento">Produtos</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="Produtos" name="Produtos">
										<?php
										foreach ($select['Produtos'] as $key => $row) {
											if ($query['Produtos'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								
								<!--
								<div class="col-md-1">
									<label for="AprovadoDespesas">Desp.Aprov.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="AprovadoDespesas" name="AprovadoDespesas">
										<?php
										foreach ($select['AprovadoDespesas'] as $key => $row) {
											if ($query['AprovadoDespesas'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<label for="ServicoConcluidoDespesas">Desp. Concl.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="ServicoConcluidoDespesas" name="ServicoConcluidoDespesas">
										<?php
										foreach ($select['ServicoConcluidoDespesas'] as $key => $row) {
											if ($query['ServicoConcluidoDespesas'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<label for="QuitadoDespesas">Desp.Quit.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="QuitadoDespesas" name="QuitadoDespesas">
										<?php
										foreach ($select['QuitadoDespesas'] as $key => $row) {
											if ($query['QuitadoDespesas'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>

								<div class="col-md-1">
									<label for="QuitadoPagaveis">Parc. Quit.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="QuitadoPagaveis" name="QuitadoPagaveis">
										<?php
										foreach ($select['QuitadoPagaveis'] as $key => $row) {
											if ($query['QuitadoPagaveis'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								-->
								<div class="col-md-5">
									<label for="Ordenamento">Ordenamento:</label>
									<div class="form-group">
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

											<div class="col-md-4">
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
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label for="DataInicio">Data Início: *</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataFim">Data Fim: (opcional)</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<br>
								<div class="col-md-2 text-left">
									<button class="btn btn-lg btn-primary" name="pesquisar" value="0" type="submit">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
								<div class="col-md-2 text-right">											
										<a class="btn btn-lg btn-danger" href="<?php echo base_url() ?>relatorio/clientes" role="button"> 
											<span class="glyphicon glyphicon-plus"></span> Nova Venda
										</a>
								</div>								
							</div>
						</div>

						</form>

						<br>

						<?php echo (isset($list)) ? $list : FALSE ?>

					</div>

				</div>

			</div>

		</div>
	</div>
	<div class="col-md-1"></div>	

