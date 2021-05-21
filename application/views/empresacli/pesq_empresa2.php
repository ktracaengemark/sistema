<?php if (isset($msg)) echo $msg; ?>

<div class="col-md-offset-3 col-md-6">

	<?php echo validation_errors(); ?>

	<div class="panel panel-primary">

		<div class="panel-heading">
			<div class="row">	
				<?php echo form_open(base_url() . 'empresacli2/pesquisar', 'class="navbar-form navbar-left"'); ?>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-info" type="submit">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
					<input type="text" placeholder="Ex.: barbeiro" class="form-control" name="Pesquisa" value="">
				</div>
			</div>
			
			<a class="btn btn-sm btn-warning" href="<?php echo base_url() ?>relatorioempresa/empresas" role="button">Limpar Filtro</a>
		</div>
		<div class="panel-body">
						
			<?php if (isset($list)) echo $list; ?>

		</div>

	</div>

</div>