<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10 ">		
		
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
					<div class="panel-body">

						<?php echo form_open('relatorio/receitas', 'role="form"'); ?>

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
								<div class="col-md-2">
									<label for="AprovadoOrca">Orç.Aprov.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="AprovadoOrca" name="AprovadoOrca">
										<?php
										foreach ($select['AprovadoOrca'] as $key => $row) {
											if ($query['AprovadoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>

								<div class="col-md-2">
									<label for="QuitadoOrca">Orç.Quit.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="QuitadoOrca" name="QuitadoOrca">
										<?php
										foreach ($select['QuitadoOrca'] as $key => $row) {
											if ($query['QuitadoOrca'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								
								<div class="col-md-2">
									<label for="ServicoConcluido">Serv. Concl.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="ServicoConcluido" name="ServicoConcluido">
										<?php
										foreach ($select['ServicoConcluido'] as $key => $row) {
											if ($query['ServicoConcluido'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								
								<div class="col-md-2">
									<label for="QuitadoRecebiveis">Parc. Quit.?</label>
									<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
											id="QuitadoRecebiveis" name="QuitadoRecebiveis">
										<?php
										foreach ($select['QuitadoRecebiveis'] as $key => $row) {
											if ($query['QuitadoRecebiveis'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<!--
								<div class="col-md-3">
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
								-->
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<label for="DataInicio3">Orç.- Data Inc.</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim3">Orç.- Data Fim</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>								
								<div class="col-md-2">
									<label for="DataInicio">Venc.- Data Inc.</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim">Venc.- Data Fim</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataInicio2">Pagam.- Data Inc.</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataFim2">Pagam.- Data Fim</label>
									<div class="input-group DatePicker">
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<br>
								<div class="col-md-4"></div>
								<div class="col-md-2 text-left">
									<button class="btn btn-lg btn-primary" name="pesquisar" value="0" type="submit">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
								
								<div class="col-md-2 text-right">											
										<a class="btn btn-lg btn-danger" href="<?php echo base_url() ?>relatorio/orcamento" role="button"> 
											<span class="glyphicon glyphicon-plus"></span> Orçamentos
										</a>
								</div>
								
								<div class="col-md-4"></div>
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

