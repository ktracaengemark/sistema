<?php if ($msg) echo $msg; ?>
<div class="col-sm-offset-1 col-md-10">
	<?php echo validation_errors(); ?>
	<?php echo form_open('relatorio/balanco', 'role="form"'); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">		
			<button  class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
				<span class="glyphicon glyphicon-search"></span>Filtro
			</button>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>Cobrancas/cobrancas" role="button">
				<span class="glyphicon glyphicon-search"></span>Entradas
			</a>			
			<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>Debitos/debitos" role="button">
				<span class="glyphicon glyphicon-search"></span>Saidas
			</a>			
			<a class="btn btn-sm btn-default" href="<?php echo base_url() ?>Relatorio/balanco_print" role="button">
				<span class="glyphicon glyphicon-print"></span>Imprimir
			</a>
		</div>
		<div <?php echo $collapse; ?> id="Anual">
			<div class="panel-body">	
				<?php echo (isset($list3)) ? $list3 : FALSE ?>			
				<?php echo (isset($list)) ? $list : FALSE ?>
			</div>
		</div>	
	</div>
	<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">	
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-3 text-left">
							<label for="CombinadoFrete">Entrega</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="CombinadoFrete" name="CombinadoFrete">
								<?php
								foreach ($select['CombinadoFrete'] as $key => $row) {
									if ($query['CombinadoFrete'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>				
						<div class="col-md-3 text-left">
							<label for="AprovadoOrca">Pagamento</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
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
						<div class="col-md-3 text-left">
							<label for="Quitado">Parcelas</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Quitado" name="Quitado">
								<?php
								foreach ($select['Quitado'] as $key => $row) {
									if ($query['Quitado'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-left" >
							<label for="Ordenamento">Dia:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Diavenc" name="Diavenc">
								<?php
								foreach ($select['Diavenc'] as $key => $row) {
									if ($query['Diavenc'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-3 text-left" >
							<label for="Ordenamento">Mes:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Mesvenc" name="Mesvenc">
								<?php
								foreach ($select['Mesvenc'] as $key => $row) {
									if ($query['Mesvenc'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-3 text-left" >
							<label for="Ordenamento">Ano:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" 
									id="Ano" name="Ano">
								<?php
								foreach ($select['Ano'] as $key => $row) {
									if ($query['Ano'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>	
					</div>
					<div class="row">
						<br>
						<div class="form-group col-md-3 text-left">
							<div class="form-footer ">
								<button class="btn btn-warning btn-block" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-filter"></span> Filtrar
								</button>
							</div>
						</div>
						<!--
						<div class="form-group col-md-3 text-left">
							<div class="form-footer">		
								<a class="btn btn-success btn-block" href="<?php echo base_url() ?>relatorio/receitas" role="button">
									<span class="glyphicon glyphicon-search"></span> Receitas
								</a>
							</div>	
						</div>
						<div class="form-group col-md-3 text-left">
							<div class="form-footer">		
								<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>relatorio/despesas" role="button">
									<span class="glyphicon glyphicon-search"></span> Despesas
								</a>
							</div>	
						</div>
						-->
						<div class="form-group col-md-3 text-left">
							<div class="form-footer ">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
									<span class="glyphicon glyphicon-remove"></span> Fechar
								</button>
							</div>
						</div>					
					</div>
				</div>
			</div>									
										
		</div>
	</div>	
</form>	
</div>

