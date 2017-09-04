<?php if (isset($msg)) echo $msg; ?>
<div class="container-fluid">
	<div class="row">			
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
			<?php echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">
				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>			
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

					<!--App_Produtos-->

					<div class="form-group">
						<div class="panel panel-info">
							<div class="panel-heading">	
								<div class="row">
									<div class="col-md-3">
										<label for="TipoProduto">Tipo de Produto:</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="TipoProduto" name="TipoProduto">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['TipoProduto'] as $key => $row) {
												if ($produtos['TipoProduto'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>									
									<div class="col-md-4">
										<label for="Fornecedor">Fornecedor</label>
										<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
												id="Fornecedor" name="Fornecedor">
											<option value="">-- Selecione uma opção --</option>
											<?php
											foreach ($select['Fornecedor'] as $key => $row) {
												if ($produtos['Fornecedor'] == $key) {
													echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
												} else {
													echo '<option value="' . $key . '">' . $row . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>	
								<div class="row">	
									<div class="col-md-3">
										<label for="CodProd">Cód. Prod.: *</label><br>
										<input type="text" class="form-control" maxlength="25"
												name="CodProd" value="<?php echo $produtos['CodProd'] ?>">
									</div>
									<div class="col-md-4">
										<label for="Produtos">Produto: *</label><br>
										<input type="text" class="form-control" maxlength="200"
												name="Produtos" value="<?php echo $produtos['Produtos'] ?>">
									</div>										
									<div class="col-md-2">
										<label for="UnidadeProduto">Unid. Prod.:*</label><br>
										<input type="text" class="form-control" maxlength="20"
												name="UnidadeProduto" value="<?php echo $produtos['UnidadeProduto'] ?>">
									</div>
									<div class="col-md-3">
										<label for="ValorCompraProduto">Custo:</label><br>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">R$</span>
											<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
													name="ValorCompraProduto" value="<?php echo $produtos['ValorCompraProduto'] ?>">
										</div>
									</div>									
								</div>
							</div>	
						</div>		
					</div>

					<hr>
											
					<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
						<div class="panel panel-primary">
							 <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
								<h4 class="panel-title">
									<a class="accordion-toggle">
										<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
										Valor de Venda
									</a>
								</h4>
							</div>

							<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">

									<input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

									<div class="input_fields_wrap3">

									<?php
									for ($i=1; $i <= $count['PTCount']; $i++) {
									?>

									<?php if ($metodo > 1) { ?>
									<input type="hidden" name="idApp_Valor<?php echo $i ?>" value="<?php echo $valor[$i]['idApp_Valor']; ?>"/>
									<?php } ?>

									<div class="form-group" id="3div<?php echo $i ?>">
										<div class="panel panel-info">
											<div class="panel-heading">			
												<div class="row">																					

													<div class="col-md-4">
														<label for="Convenio<?php echo $i ?>">Convenio:</label>
														<?php if ($i == 1) { ?>
														<?php } ?>
														<select data-placeholder="Selecione uma opção..." class="form-control"
																 id="listadinamicac<?php echo $i ?>" name="Convenio<?php echo $i ?>">
															<option value="">-- Selecione uma opção --</option>
															<?php
															foreach ($select['Convenio'] as $key => $row) {
																if ($valor[$i]['Convenio'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													<!--
													<div class="col-md-2">
														<label for="ValorVendaProduto<?php echo $i ?>">Valor Venda:</label>
														<textarea class="form-control" id="ValorVendaProduto<?php echo $i ?>" <?php echo $readonly; ?>
																  name="ValorVendaProduto<?php echo $i ?>"><?php echo $valor[$i]['ValorVendaProduto']; ?></textarea>
													</div>
													-->
													<div class="col-md-3">
														<label for="ValorVendaProduto">Valor Venda:</label>
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1">R$</span>
															<input type="text" class="form-control Valor" id="ValorVendaProduto<?php echo $i ?>" maxlength="10" placeholder="0,00"
																name="ValorVendaProduto<?php echo $i ?>" value="<?php echo $valor[$i]['ValorVendaProduto'] ?>">
														</div>
													</div>													
													
													<div class="col-md-1">
														<label><br></label><br>
														<button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
															<span class="glyphicon glyphicon-trash"></span>
														</button>
													</div>
												</div>
											</div>	
										</div>		
									</div>

									<?php
									}
									?>

									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<a class="add_field_button3 btn btn-xs btn-warning" onclick="adicionaValor()">
													<span class="glyphicon glyphicon-plus"></span> Adicionar Plano
												</a>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
							<input type="hidden" name="idApp_Produtos" value="<?php echo $produtos['idApp_Produtos']; ?>">
							<?php if ($metodo > 1) { ?>
							<!--<input type="hidden" name="idApp_Valor" value="<?php echo $valor['idApp_Valor']; ?>">
							<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
							<?php } ?>
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
													<a class="btn btn-danger" href="<?php echo base_url() . 'produtos/excluir/' . $produtos['idApp_Produtos'] ?>" role="button">
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

					</form>

				</div>

			</div>

		</div>
		<div class="col-md-2"></div>
	</div>
</div>	