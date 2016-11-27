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
                        <div class="col-md-5">
                            <label for="NomeCliente">Nome do Cliente: *</label>
                            <input type="text" class="form-control" id="NomeCliente" maxlength="255" <?php echo $readonly; ?>
                                   name="NomeCliente" autofocus value="<?php echo $query['NomeCliente']; ?>">
                        </div>
						<div class="col-md-3">
                            <label for="Telefone1">Telefone Principal: *</label>
                            <input type="text" class="form-control Celular CelularVariavel" id="Telefone1" maxlength="20" <?php echo $readonly; ?>
                                   name="Telefone1" placeholder="(99) 99999-9999" value="<?php echo $query['Telefone1']; ?>">
                        </div>
						<div class="col-md-3">
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
                            <div class="col-md-2">
                                <label for="RegistroFicha">Ficha Nº:</label>
                                <input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
                                       name="RegistroFicha" value="<?php echo $query['RegistroFicha']; ?>">
                            </div>                        
                            <div class="col-md-4">
                                <label for="DataNascimento">Data de Nascimento:</label>
                                <input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
                                       name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
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
                                    <option value="">-- Selec.um Município --</option>
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
							<div class="col-md-3">
								<label for="Telefone2">Telefone ou Celular:</label>
								<input type="text" class="form-control Celular CelularVariavel" id="Telefone2" maxlength="20" <?php echo $readonly; ?>
									   name="Telefone2" value="<?php echo $query['Telefone2']; ?>">
							</div>
							<div class="col-md-3">
								<label for="Telefone3">Telefone ou Celular:</label>
								<input type="text" class="form-control Celular CelularVariavel" id="Telefone3" maxlength="20" <?php echo $readonly; ?>
									   name="Telefone3" value="<?php echo $query['Telefone3']; ?>">
							</div>                                                  
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Obs">OBS:</label>
                                <textarea class="form-control" id="Obs" <?php echo $readonly; ?>
                                          name="Obs"><?php echo $query['Obs']; ?></textarea>
                            </div>
                        </div>
                    </div>                 

                </div>                                    

                <br>

                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
                        <?php if ($metodo == 3) { ?>
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