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
                            <label for="NomeEmpresa">Fornecedor *</label>
                            <input type="text" class="form-control" id="NomeEmpresa" maxlength="255" <?php echo $readonly; ?>
                                   name="NomeEmpresa" autofocus value="<?php echo $query['NomeEmpresa']; ?>">
                        </div>
						<div class="col-md-2">
                            <label for="Telefone1">Tel Principal: *</label>
                            <input type="text" class="form-control Celular CelularVariavel" id="Telefone1" maxlength="14" <?php echo $readonly; ?>
                                   name="Telefone1" placeholder="(XX)999999999" value="<?php echo $query['Telefone1']; ?>">
                        </div>
						<div class="col-md-2">
							<label for="TipoFornec">Serv. ou Prod.</label>								
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="TipoFornec" name="TipoFornec">
								<option value="">-- Sel. Tipo de Fornec. --</option>
								<?php
								foreach ($select['TipoFornec'] as $key => $row) {
									(!$query['TipoFornec']) ? $query['TipoFornec'] = 'V' : FALSE;
									if ($query['TipoFornec'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-2 text-center">
							<label for="VendaFornec">P/Venda?</label><br>
							<div class="form-group">
								<div class="btn-group" data-toggle="buttons">
									<?php
									foreach ($select['VendaFornec'] as $key => $row) {
										(!$query['VendaFornec']) ? $query['VendaFornec'] = 'S' : FALSE;

										if ($query['VendaFornec'] == $key) {
											echo ''
											. '<label class="btn btn-warning active" name="radiobutton_VendaFornec" id="radiobutton_VendaFornec' . $key . '">'
											. '<input type="radio" name="VendaFornec" id="radiobutton" '
											. 'autocomplete="off" value="' . $key . '" checked>' . $row
											. '</label>'
											;
										} else {
											echo ''
											. '<label class="btn btn-default" name="radiobutton_VendaFornec" id="radiobutton_VendaFornec' . $key . '">'
											. '<input type="radio" name="VendaFornec" id="radiobutton" '
											. 'autocomplete="off" value="' . $key . '" >' . $row
											. '</label>'
											;
										}
									}
									?>
								</div>
							</div>
						</div>
						<div class="col-md-2 text-left">
                            <label for="Atividade">Ativ.: *</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>atividade/cadastrar/atividade" role="button"> 
                                <span class="glyphicon glyphicon-plus"></span> <b>Ativ.</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                    id="Atividade" name="Atividade">
                                <option value="">-- Sel. Ativ. --</option>
                                <?php
                                foreach ($select['Atividade'] as $key => $row) {
                                    if ($query['Atividade'] == $key) {
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
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
                                <span class="glyphicon glyphicon-menu-down"></span> Completar Dados
                            </button>
                        </div>                
                    </div>
                </div>                 
                <div <?php echo $collapse; ?> id="DadosComplementares">
					<div class="form-group">
						<div class="row">                      
							<div class="col-md-4">
								<label for="Telefone2">Telefone ou Celular:</label>
								<input type="text" class="form-control Celular CelularVariavel" id="Telefone2" maxlength="20" <?php echo $readonly; ?>
									   name="Telefone2" placeholder="(XX)999999999" value="<?php echo $query['Telefone2']; ?>">
							</div>
							<div class="col-md-4">
								<label for="Telefone3">Telefone ou Celular:</label>
								<input type="text" class="form-control Celular CelularVariavel" id="Telefone3" maxlength="20" <?php echo $readonly; ?>
									   name="Telefone3" placeholder="(XX)999999999" value="<?php echo $query['Telefone3']; ?>">
							</div>
							<div class="col-md-4">
								<label for="Cnpj">Cnpj:</label>
								<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
									   name="Cnpj" value="<?php echo $query['Cnpj']; ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="Endereco">Endreço:</label>
								<input type="text" class="form-control" id="Endereco" maxlength="100" <?php echo $readonly; ?>
									   name="Endereco" value="<?php echo $query['Endereco']; ?>">
							</div>
							<div class="col-md-6">
								<label for="Bairro">Bairro:</label>
								<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
									   name="Bairro" value="<?php echo $query['Bairro']; ?>">
							</div>
						</div>
					</div> 
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="Municipio">Município:</label><br>
								<select data-placeholder="Selecione um Município..." class="form-control" <?php echo $disabled; ?>
										id="Municipio" name="Municipio">
									<option value="">-- Selecione uma opção --</option>
									<?php
									foreach ($select['Municipio'] as $key => $row) {
										if ($query['Municipio'] == $key) {
											echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
										} else {
											echo '<option value="' . $key . '">' . $row . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label for="Email">E-mail:</label>
								<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
									   name="Email" value="<?php echo $query['Email']; ?>">
							</div>                        
						</div>
					</div> 
					<div class="form-group">
						<div class="row">
							<div class="col-md-10">
								<label for="Obs">OBS:</label>
								<textarea class="form-control" id="Obs" <?php echo $readonly; ?>
										  name="Obs"><?php echo $query['Obs']; ?></textarea>
							</div>
							<div class="col-md-2">
								<label for="Ativo">Ativo?</label><br>
								<div class="form-group">
									<div class="btn-group" data-toggle="buttons">
										<?php
										foreach ($select['Ativo'] as $key => $row) {
											(!$query['Ativo']) ? $query['Ativo'] = 'S' : FALSE;

											if ($query['Ativo'] == $key) {
												echo ''
												. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
												. '<input type="radio" name="Ativo" id="radiobutton" '
												. 'autocomplete="off" value="' . $key . '" checked>' . $row
												. '</label>'
												;
											} else {
												echo ''
												. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
												. '<input type="radio" name="Ativo" id="radiobutton" '
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
                <br>               
				<div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idApp_Empresa" value="<?php echo $query['idApp_Empresa']; ?>">
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
                                                <a class="btn btn-danger" href="<?php echo base_url() . 'empresa/excluir/' . $query['idApp_Empresa'] ?>" role="button">
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
</div>