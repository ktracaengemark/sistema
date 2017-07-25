<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-md-2"></div>
    <div class="col-md-8">

        <?php echo validation_errors(); ?>

        <div class="panel panel-primary">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open($form_open_path, 'role="form"'); ?>
                    <div class="row">                      						
						<div class="col-md-4">
							<label for="ProdutoBase">Produto</label>								
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="ProdutoBase" autofocus name="ProdutoBase">
								<option value="">--Sel. Produto --</option>
								<?php
								foreach ($select['ProdutoBase'] as $key => $row) {
									if ($query['ProdutoBase'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>						
						<div class="col-md-2">
							<label for="Convenio">Plano</label>								
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="Convenio" autofocus name="Convenio">
								<option value="">--Sel. Plano --</option>
								<?php
								foreach ($select['Convenio'] as $key => $row) {
									if ($query['Convenio'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
                            <label for="ValorVendaProduto">Valor de Venda: *</label><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                        name="ValorVendaProduto" value="<?php echo $query['ValorVendaProduto'] ?>">
                            </div>
                        </div>												
                    </div>
                    <br>				
					<div class="form-group">
						<div class="row">
							<input type="hidden" name="idTab_Produto" value="<?php echo $query['idTab_Produto']; ?>">
							<?php if ($metodo == 2) { ?>

								<div class="col-md-3">
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<div class="col-md-3 text-left">											
									<a class="btn btn-lg btn-success" href="<?php echo base_url() ?>produtobase/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Novo Servico
									</a>
								</div>
								<div class="col-md-3 text-right">											
									<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>produtocompra/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-list"></span> Fornec & <span class="glyphicon glyphicon-usd"></span> Preco Compra
									</a>
								</div>
								<div class="col-md-3 text-right">
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
												<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
													Esta operação é irreversível.</p>
											</div>
											<div class="modal-footer">
												<div class="col-md-6 text-left">
													<button type="button" class="btn btn-warning" data-dismiss="modal">
														<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
													</button>
												</div>
												<div class="col-md-6 text-right">
													<a class="btn btn-danger" href="<?php echo base_url() . 'produto/excluir/' . $query['idTab_Produto'] ?>" role="button">
														<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>

							<?php } else { ?>
								<div class="col-md-3">
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<div class="col-md-3 text-left">											
									<a class="btn btn-lg btn-success" href="<?php echo base_url() ?>produtobase/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Novo Servico
									</a>
								</div>
								<div class="col-md-3 text-right">											
									<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>produtocompra/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-list"></span> Fornec & <span class="glyphicon glyphicon-usd"></span> Preco Compra
									</a>
								</div>
							<?php } ?>
						</div>
					</div>					
                </form>
                <br>                               
                <?php if (isset($list)) echo $list; ?>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>