<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			<?php echo validation_errors(); ?>

			<div class="panel panel-primary">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<p>Informe <b>NomeAdmin ou Telefone</b> do Empresa:</p>

					<div class="row">
						<?php echo form_open('empresa/pesquisar', 'role="form"'); ?>
						<div class="col-md-6">

							<input type="text" id="inputText" class="form-control"
								   autofocus name="Pesquisa" value="<?php echo set_value('Pesquisa', $Pesquisa); ?>">

						</div>

						<div class="col-md-6">
							<button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-search"></span> Pesquisar
							</button>
						</div>
						</form>

					</div>

					<br>                
					
					<?php if ($cadastrar) { ?>
					<div class="row">
						<div class="col-md-6">                        
							<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>empresa/cadastrar" role="button"> 
								<span class="glyphicon glyphicon-plus"></span> Novo Cadastro
							</a>
						</div>
					</div>
					<?php } ?>
					
					<?php if (isset($list)) echo $list; ?>

				</div>

			</div>

		</div>
		<div class="col-md-2"></div>
	</div>
</div>