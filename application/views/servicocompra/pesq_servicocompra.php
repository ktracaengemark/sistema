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
							<label for="ServicoBase">Servico</label>								
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="ServicoBase" name="ServicoBase">
								<option value="">--Sel. Servico --</option>
								<?php
								foreach ($select['ServicoBase'] as $key => $row) {
									if ($query['ServicoBase'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
							<label for="Empresa">Fornecedor</label>								
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="Empresa"  name="Empresa">
								<option value="">-- Sel. Fornec. --</option>
								<?php
								foreach ($select['Empresa'] as $key => $row) {
									(!$query['Empresa']) ? $query['Empresa'] = 'V' : FALSE;
									if ($query['Empresa'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
                            <label for="CodFornec">Cod. Fornec.:</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                    name="CodFornec" value="<?php echo $query['CodFornec'] ?>">
                        </div>
						<div class="col-md-2">
                            <label for="ValorCompraServico">Valor de Compra: *</label><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                        name="ValorCompraServico" value="<?php echo $query['ValorCompraServico'] ?>">
                            </div>
                        </div>
                    </div>

                    <br>
                
                    <div class="form-group">
						<div class="row">
							<input type="hidden" name="idTab_ServicoCompra" value="<?php echo $query['idTab_ServicoCompra']; ?>">
							<?php if ($metodo == 2) { ?>

								<div class="col-md-3">
									<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
										<span class="glyphicon glyphicon-save"></span> Salvar
									</button>
								</div>
								<div class="col-md-3 text-left">											
									<a class="btn btn-lg btn-success" href="<?php echo base_url() ?>servicobase/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Novo Servico
									</a>
								</div>
								<div class="col-md-3 text-right">											
									<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>servico/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-list"></span> Plano & <span class="glyphicon glyphicon-usd"></span>Preco Venda
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
													<a class="btn btn-danger" href="<?php echo base_url() . 'servicocompra/excluir/' . $query['idTab_ServicoCompra'] ?>" role="button">
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
									<a class="btn btn-lg btn-success" href="<?php echo base_url() ?>servicobase/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Novo Servico
									</a>
								</div>
								<div class="col-md-3 text-right">											
									<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>servico/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-list"></span> Plano & <span class="glyphicon glyphicon-usd"></span>Preco Venda
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