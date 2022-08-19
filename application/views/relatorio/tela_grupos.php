<?php if ($msg) echo $msg; ?>
<div class="col-sm-offset-2 col-md-8 ">		
<?php echo form_open('relatorio/grupos', 'role="form"'); ?>
	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="btn-group " role="group" aria-label="...">
				<div class="row text-left">	
				</div>	
			</div>			
		</div>		
		<?php echo (isset($list)) ? $list : FALSE ?>	
	</div>
</form>
</div>	


