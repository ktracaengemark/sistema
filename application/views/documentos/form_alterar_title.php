<?php if (isset($msg)) echo $msg; ?>
<div class="col-sm-offset-2 col-md-8 ">	
<?php echo validation_errors(); ?>
	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?>
		</div>			
		<div class="panel-body">
			<?php echo form_open_multipart($form_open_path); ?>
			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="row">																
							<div class="col-md-4">
								<label for="Title">Titulo*</label><br>
								<input type="text" class="form-control" maxlength="100" name="Title" value="<?php echo $empresa['Title'] ?>">
							</div>							
						</div>
					</div>	
				</div>		
			</div>
			<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
			<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-save"></span> Salvar
							</button>
						</div>
					</div>
				</div>
			<?php } ?>
			</form>
		</div>
	</div>
</div>	