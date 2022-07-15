<?php if ($msg) echo $msg; ?>


	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-info">

					<div class="panel-heading"><span class="glyphicon glyphicon-pencil"></span><strong><?php echo $titulo; ?></strong></div>
					<div class="panel-body">

						<?php echo form_open('relatorio/rankingformaentrega', 'role="form"'); ?>

						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="Ordenamento">Entrega</label>
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
											id="TipoFrete" name="TipoFrete">
										<?php
										foreach ($select['TipoFrete'] as $key => $row) {
											if ($query['TipoFrete'] == $key) {
												echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
											} else {
												echo '<option value="' . $key . '">' . $row . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-8">
									<label for="Ordenamento">Ordenamento:</label>

									<div class="form-group">
										<div class="row">
											<div class="col-md-7">
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
												<select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
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
								<div class="col-md-3">
									<label for="DataInicio">Data In�cio: *</label>
									<div class="input-group DatePicker">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
											   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
									</div>
								</div>
								<div class="col-md-3">
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

						<br>

						<?php echo (isset($list)) ? $list : FALSE ?>

					</div>

				</div>

			</div>

		</div>
	</div>
	
