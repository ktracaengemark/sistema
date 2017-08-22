<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="<?php echo $sidebar; ?>"><?php if (isset($nav_secundario)) echo $nav_secundario; ?></div>

    <div class="<?php echo $main; ?>">

        <?php echo validation_errors(); ?>

        <div class="panel panel-<?php echo $panel; ?>">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open_multipart($form_open_path); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="Nome">Nome do Associado / Novo Usuário: *</label>
                            <input type="text" class="form-control" id="Nome" maxlength="255" <?php echo $readonly; ?>
                                   name="Nome" autofocus value="<?php echo $query['Nome']; ?>">
                        </div>
						<div class="col-md-3">
                            <label for="Celular">Tel.1 - Fixo ou Celular*</label>
                            <input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="11" <?php echo $readonly; ?>
                                   name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
                        </div>
						<div class="col-md-3">
							<label for="DataNascimento">Data de Nascimento:</label>
							<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
								   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
						</div>						
						<div class="col-md-2">
							<label for="Sexo">Sexo:</label>
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="Sexo" name="Sexo">
								<option value="">--Selec. o Sexo--</option>
								<?php
								foreach ($select['Sexo'] as $key => $row) {
									if ($query['Sexo'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>						
					</div>
				</div>
				<div class="form-group">
					<div class="row">						
						<div class="col-md-4">
							<label for="Email">E-mail:</label>
							<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
								   name="Email" value="<?php echo $query['Email']; ?>">
						</div>
						<div class="col-md-3">
							<label for="Usuario">Usuário:</label>
							<input type="text" class="form-control" id="Usuario" maxlength="45" 
								   name="Usuario" value="<?php echo $query['Usuario']; ?>">
							<?php echo form_error('Usuario'); ?>
						</div>
						<div class="col-md-3">
							<label for="Senha">Senha:</label>
							<input type="password" class="form-control" id="Senha" maxlength="45"
								   name="Senha" value="<?php echo $query['Senha']; ?>">
							<?php echo form_error('Senha'); ?>
						</div>
						<div class="col-md-2">
							<label for="Senha">Confirmar Senha:</label>
							<input type="password" class="form-control" id="Confirma" maxlength="45"
								   name="Confirma" value="<?php echo $query['Confirma']; ?>">
							<?php echo form_error('Confirma'); ?>
						</div>
					</div>
				</div>
                
                <br>

                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idSis_Usuario" value="<?php echo $query['idSis_Usuario']; ?>">
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
                                                <a class="btn btn-danger" href="<?php echo base_url() . 'associado/excluir/' . $query['idSis_Usuario'] ?>" role="button">
                                                    <span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } elseif ($metodo == 3) { ?>
                            <div class="col-md-12 text-center">
                                <button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
                                    <span class="glyphicon glyphicon-trash"></span> Excluir
                                </button>
                                <button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
                                        return true;">
                                    <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                                </button>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6">
                                <button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
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

</div>
