<?php if ($msg) echo $msg; ?>
<div class="col-md-4"></div>
<div class="col-md-4">
	<?php echo validation_errors(); ?>
	<?php echo form_open('relatorio/balanco_print', 'role="form"'); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<nav class="navbar navbar-inverse navbar-fixed" role="banner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<div class="btn-menu-print btn-group">
						<a type="button" class="col-md-6 btn btn-md btn-default " href="javascript:window.print()">
							<span class="glyphicon glyphicon-print"></span>
						</a>
						<a type="button" class="col-md-6 btn btn-md btn-warning "  href="<?php echo base_url() ?>Relatorio/balanco">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</div>
				</div>
			</div>
		</nav>
	</div>	
	<div class="panel-body">	
		<?php echo (isset($list3)) ? $list3 : FALSE ?>
	</div>	
</form>	
</div>
<div class="col-md-4"></div>

