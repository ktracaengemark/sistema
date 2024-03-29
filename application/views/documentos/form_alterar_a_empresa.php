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
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label for="AEmpresa">A Empresa*</label><br>
								<textarea type="text" class="form-control" maxlength="500" name="AEmpresa" value="<?php echo $empresa['AEmpresa'];?>"><?php echo $empresa['AEmpresa'];?></textarea>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="Top1">Topico1</label><br>
								<input type="text" class="form-control" maxlength="100" name="Top1" value="<?php echo $empresa['Top1'] ?>">
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<label for="Texto_Top1">Texto Tópico1</label><br>
								<textarea type="text" class="form-control" maxlength="100" name="Texto_Top1" value="<?php echo $empresa['Texto_Top1'] ?>"><?php echo $empresa['Texto_Top1'];?></textarea>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="Top2">Tópico2</label><br>
								<input type="text" class="form-control" maxlength="100" name="Top2" value="<?php echo $empresa['Top2'] ?>">
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<label for="Texto_Top2">Texto Tópico2</label><br>
								<textarea type="text" class="form-control" maxlength="100" name="Texto_Top2" value="<?php echo $empresa['Texto_Top2'];?>"><?php echo $empresa['Texto_Top2'];?></textarea>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="Video_Empresa">Link do Video</label><br>
								<input type="text" class="form-control" maxlength="100" name="Video_Empresa" value="<?php echo $empresa['Video_Empresa'] ?>">
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<label>Video</label><br>
								<?php if(isset($empresa['Video_Empresa']) && $empresa['Video_Empresa'] != "") { ?>
									<figure >
										<div class="boxVideo">
											<iframe  class="img-responsive thumbnail" src="https://www.youtube.com/embed/<?php echo $empresa['Video_Empresa'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										</div>
									</figure>
								<?php } ?>
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