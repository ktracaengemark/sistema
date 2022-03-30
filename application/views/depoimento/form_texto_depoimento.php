<?php if (isset($msg)) echo $msg; ?>
			
<div class="col-sm-offset-2 col-md-8 ">	
<?php echo validation_errors(); ?>

	<div class="panel panel-<?php echo $panel; ?>">
		<div class="panel-heading">
			<?php echo $titulo; ?>
			<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>relatorio/depoimento" role="button">
				<span class="glyphicon glyphicon-search"></span> Depoimento
			</a>
		</div>			
		<div class="panel-body">

			<?php echo form_open_multipart($form_open_path); ?>

			<div class="form-group">
				<div class="panel panel-info">
					<div class="panel-heading">	
						<div class="row">
							<div class="col-md-4">
								<label for="Nome_Depoimento">Nome:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Nome_Depoimento" value="<?php echo $query['Nome_Depoimento'] ?>">
							</div>
							<div class="col-md-4">
								<label for="Texto_Depoimento">Texto:*</label><br>
								<input type="text" class="form-control" maxlength="200"
										name="Texto_Depoimento" value="<?php echo $query['Texto_Depoimento'] ?>">
							</div>
							<div class="col-md-2 text-left">
								<label for="Ativo_Depoimento">Ativo?</label><br>
								<div class="btn-group" data-toggle="buttons">
									<?php
									foreach ($select['Ativo_Depoimento'] as $key => $row) {
										if (!$query['Ativo_Depoimento']) $query['Ativo_Depoimento'] = 'N';

										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

										if ($query['Ativo_Depoimento'] == $key) {
											echo ''
											. '<label class="btn btn-warning active" name="Ativo_Depoimento_' . $hideshow . '">'
											. '<input type="radio" name="Ativo_Depoimento" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" checked>' . $row
											. '</label>'
											;
										} else {
											echo ''
											. '<label class="btn btn-default" name="Ativo_Depoimento_' . $hideshow . '">'
											. '<input type="radio" name="Ativo_Depoimento" id="' . $hideshow . '" '
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
					<input type="hidden" name="idApp_Depoimento" value="<?php echo $query['idApp_Depoimento']; ?>">
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
										<p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
									</div>
									<div class="modal-footer">
										<div class="col-md-6 text-left">
											<button type="button" class="btn btn-warning" data-dismiss="modal">
												<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
											</button>
										</div>
										<div class="col-md-6 text-right">
											<a class="btn btn-danger" href="<?php echo base_url() . 'depoimento/excluir/' . $query['idApp_Depoimento'] ?>" role="button">
												<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
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