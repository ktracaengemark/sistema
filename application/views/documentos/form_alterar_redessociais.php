<?php if (isset($msg)) echo $msg; ?>
<div class="col-lg-2 col-md-2 col-sm-1"></div>	
<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
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
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
								<label for="SobreNos">Sobre Nos</label><br>
								<textarea type="text" class="form-control" name="SobreNos" value="<?php echo $empresa['SobreNos'] ?>"><?php echo $empresa['SobreNos'] ?></textarea>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
								<label for="Atendimento">Atendimento</label><br>
								<textarea type="text" class="form-control" maxlength="100" name="Atendimento" value="<?php echo $empresa['Atendimento'] ?>"><?php echo $empresa['Atendimento'] ?></textarea>
							</div>				
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="Facebook">Facebook</label><br>
								<input type="text" class="form-control" maxlength="100" name="Facebook" value="<?php echo $empresa['Facebook'] ?>">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="Instagram">Instagram</label><br>
								<input type="text" class="form-control" maxlength="100" name="Instagram" value="<?php echo $empresa['Instagram'] ?>">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="Youtube">Youtube</label><br>
								<input type="text" class="form-control" maxlength="100" name="Youtube" value="<?php echo $empresa['Youtube'] ?>">
							</div>					
						</div>
					</div>	
				</div>		
			</div>
			<input type="hidden" name="idSis_Empresa" value="<?php echo $empresa['idSis_Empresa']; ?>">
			<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<button class="btn btn-lg btn-primary btn-block" id="inputDb" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-save"></span> Salvar
							</button>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<a class="btn btn-lg btn-warning btn-block" href="<?php echo base_url() . 'relatorio/site/'?>">
								<span class="glyphicon glyphicon-file"></span> Voltar
							</a>
						</div>
					</div>
				</div>
			<?php } ?>
			</form>
		</div>
	</div>
</div>	