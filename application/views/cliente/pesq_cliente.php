<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading">
					<strong><?php echo $titulo; ?> - Total: <?php echo $total; ?></strong>
				</div>
				<div class="panel-body">
					<div class="row">
						<?php echo form_open('cliente/pesquisar', 'role="form"'); ?>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Informe o <b>Nome, Telefone ou Ficha</b>:</label>
							<input type="text" id="inputText" class="form-control btn-block"
								   autofocus name="Pesquisa" value="<?php echo set_value('Pesquisa', $Pesquisa); ?>">

						</div>

						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
							<label>Pesquisar</label><br>
							<button class="btn btn-sm btn-primary btn-block" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-search"></span> 
							</button>
						</div>

						</form>
					
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">                        
							<label>Novo</label><br>
							<a class="btn btn-sm btn-warning btn-block" href="<?php echo base_url() ?>cliente/cadastrar" role="button"> 
								<span class="glyphicon glyphicon-plus"></span> 
							</a>
						</div>
					</div>
					
					<?php if (isset($list)) echo $list; ?>
					
				</div>

			</div>

		</div>

	</div>
</div>

