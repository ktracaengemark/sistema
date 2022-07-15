<?php if (isset($msg)) echo $msg; ?>

<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">	
	
	<?php echo validation_errors(); ?>
		
	<div class="panel panel-primary">
		<div class="panel-heading">
			
				<div class="row text-left">	
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<button  class="btn btn-md btn-danger btn-block" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
							<span class="glyphicon glyphicon-plus"></span> Novo
						</button>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<a type="button" class="btn btn-md btn-default btn-block" href="<?php echo base_url() ?>relatorio/site" role="button"> 
							<span class="glyphicon glyphicon-barcode"></span> Site
						</a>
					</div>
				</div>	
						
		</div>		
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</div>
<?php echo form_open('relatorio/slides', 'role="form"'); ?>
<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Evite cadastrar Slides REPETIDOS!<br></h4>
			</div>
			<div class="modal-footer">
				<div class="form-group col-md-4 text-right">
					<div class="form-footer">		
						<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>slides/cadastrar" role="button">
							<span class="glyphicon glyphicon-plus"></span> Slides
						</a>
					</div>	
				</div>
				<div class="form-group col-md-4">
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

