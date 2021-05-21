<?php if ($msg) echo $msg; ?>
<?php echo validation_errors(); ?>    
	<?php echo form_open('pedidos/pedidos', 'role="form"'); ?>
	<div class="col-md-12 ">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-2">	
						<h5 class="text-center"><b> Selecione o Pedido</b><?php #echo $titulo; ?></h5>
					</div>
					<div class="col-md-2">
						<div class="input-group">
							<input type="text" class="form-control Numero"  
									name="Orcamento" value="<?php echo set_value('Orcamento', $query['Orcamento']); ?>">
						</div>
					</div>
					<div class="col-md-2 text-left">
						<button class="btn btn-md btn-warning" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
					</div>
					<div class="col-md-4">
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
					<div class="col-md-2">										
						<a class="btn btn-md btn-danger" href="<?php echo base_url() ?>orcatrata/cadastrar3" role="button"> 
							<span class="glyphicon glyphicon-plus"></span> Novo Pedido
						</a>
					</div>
				</div>	
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<strong><?php echo $titulo; ?></strong>
			</div>
			<div class="panel-body">
				
				<?php echo (isset($list_combinar)) ? $list_combinar : FALSE ?>
				
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<strong><?php echo $titulo; ?></strong>
			</div>
			<div class="panel-body">
				
				<?php echo (isset($list_combinar)) ? $list_combinar : FALSE ?>
				
			</div>
		</div>
	</div>	
</form>
