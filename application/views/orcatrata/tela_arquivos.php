<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php echo form_open('orcatrata/arquivos', 'role="form"'); ?>
				<?php if ($nav_secundario) echo $nav_secundario; ?>
			<?php if ($msg) {?>
				<div class="row">
					<div class="col-md-12 ">
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
					
			<?php echo validation_errors(); ?>
				
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="btn-group " role="group" aria-label="...">
						<div class="row text-left">	
							<div class="col-md-12">
								<b>Orcamento:<?php echo $orcatrata['idApp_OrcaTrata'] ?></b>
								<button  class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
									<span class="glyphicon glyphicon-plus"></span> Novo Arquivo
								</button>
							</div>
						</div>	
					</div>			
				</div>		
				<?php echo (isset($list)) ? $list : FALSE ?>	
			</div>
			<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Evite cadastrar Arquivos REPETIDOS!<br></h4>
						</div>
						<div class="modal-footer">
							<div class="form-group col-md-4 text-right">
								<div class="form-footer">
									<a type="button" class="btn btn-md btn-danger btn-block " href="<?php echo base_url() . 'orcatrata/cadastrar_arquivos/' . $orcatrata['idApp_OrcaTrata']; ?>">
										<span class="glyphicon glyphicon-picture"></span> Novo Arquivo
									</a>
									<!--
									<a class="btn btn-danger btn-block" href="<?php echo base_url() ?>orcatrata/cadastrar_arquivos" role="button">
										<span class="glyphicon glyphicon-plus"></span> Novo Arquivo
									</a>
									-->
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
		</div>
	</div>
</div>