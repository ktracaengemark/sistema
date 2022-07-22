<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-sm-offset-2 col-md-8 ">	
<?php echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/colaborador" role="button">
				<span class="glyphicon glyphicon-search"></span> Colaborador
			</a>
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>

			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="row">
							<div class="col-md-4">
								<label for="Nome_Colaborador">Nome:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Nome_Colaborador" value="<?php echo $query['Nome_Colaborador'] ?>">
							</div>
							<div class="col-md-4">
								<label for="Texto_Colaborador">Texto:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Texto_Colaborador" value="<?php echo $query['Texto_Colaborador'] ?>">
							</div>
							<div class="col-md-2 text-left">
								<label for="Ativo_Colaborador">Ativo?</label><br>
								<div class="btn-group" data-toggle="buttons">
									<?php
									foreach ($select['Ativo_Colaborador'] as $key => $row) {
										if (!$query['Ativo_Colaborador']) $query['Ativo_Colaborador'] = 'N';

										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

										if ($query['Ativo_Colaborador'] == $key) {
											echo ''
											. '<label class="btn btn-warning active" name="Ativo_Colaborador_' . $hideshow . '">'
											. '<input type="radio" name="Ativo_Colaborador" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" checked>' . $row
											. '</label>'
											;
										} else {
											echo ''
											. '<label class="btn btn-default" name="Ativo_Colaborador_' . $hideshow . '">'
											. '<input type="radio" name="Ativo_Colaborador" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" >' . $row
											. '</label>'
											;
										}
									}
									?>
								</div>
							</div>							
						</div>
					</div>	
				</div>		
			</div>

			<?php $data1 = new DateTime(); $data2 = new DateTime($_SESSION['log']['DataDeValidade']); if (($data2 > $data1) || ($_SESSION['log']['idSis_Empresa'] == 5))  { ?>
			<div class="form-group">
				<div class="row">
					<input type="hidden" name="idApp_Colaborador" value="<?php echo $query['idApp_Colaborador']; ?>">
					<?php if ($metodo == 2) { ?>
						<div class="col-md-6">
							<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-save"></span> Salvar
							</button>
						</div>
						<div class="col-md-6 text-right">
							<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
								<span class="glyphicon glyphicon-trash"></span> Excluir
							</button>
						</div>

						<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
									</div>
									<div class="modal-body">
										<p>Ao confirmar a exclus�o todos os dados ser�o exclu�dos do banco de dados. Esta opera��o � irrevers�vel.</p>
									</div>
									<div class="modal-footer">
										<div class="col-md-6 text-left">
											<button type="button" class="btn btn-warning" data-dismiss="modal">
												<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<a class="btn btn-danger" href="<?php echo base_url() . 'colaborador/excluir/' . $query['idApp_Colaborador'] ?>" role="button">
												<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-md-6">
							<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
								<span class="glyphicon glyphicon-save"></span> Salvar
							</button>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			</form>

		</div>

	</div>

</div>	