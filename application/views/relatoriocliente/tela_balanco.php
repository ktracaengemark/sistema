<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
					<div class="panel-body">

						<?php echo form_open('relatorio/balanco', 'role="form"'); ?>

						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<label for="Ano">Ano</label>
									<div class="input-group">
										<input type="text" class="form-control" maxlength="4" placeholder="AAAA"
											   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
									</div>
								</div>
								<div class="col-md-2 text-left"><br />
									<button class="btn btn-lg btn-primary" name="pesquisar" value="0" type="submit">
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
	<div class="col-md-1"></div>
