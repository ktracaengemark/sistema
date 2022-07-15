<?php if ($msg) echo $msg; ?>

<div class="container-fluid">
    <div class="row">

        <div class="main">

            <?php echo validation_errors(); ?>

            <div class="panel panel-primary">

                <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
                <div class="panel-body">

                    <?php echo form_open('relatorio/orcamentopc', 'role="form"'); ?>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-2">
                                <label for="Ordenamento">Nome do Cliente:</label>
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                        id="NomeCliente" name="NomeCliente">
                                    <?php
                                    foreach ($select['NomeCliente'] as $key => $row) {
                                        if ($query['NomeCliente'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
							<div class="col-md-2">
                                <label for="Ordenamento">Nome do Profissional:</label>
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                        id="NomeProfissional" name="NomeProfissional">
                                    <?php
                                    foreach ($select['NomeProfissional'] as $key => $row) {
                                        if ($query['NomeProfissional'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="AprovadoOrca">Aprovado?</label>
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                        id="AprovadoOrca" name="AprovadoOrca">
                                    <?php
                                    foreach ($select['AprovadoOrca'] as $key => $row) {
                                        if ($query['AprovadoOrca'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
						<!--
                            <div class="col-md-1">
                                <label for="QuitadoOrca">Quitado?</label>
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                        id="QuitadoOrca" name="QuitadoOrca">
                                    <?php
                                    foreach ($select['QuitadoOrca'] as $key => $row) {
                                        if ($query['QuitadoOrca'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
						-->
							<div class="col-md-2">
                                <label for="ServicoConcluido">Serv. Concl.?</label>
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                        id="ServicoConcluido" name="ServicoConcluido">
                                    <?php
                                    foreach ($select['ServicoConcluido'] as $key => $row) {
                                        if ($query['ServicoConcluido'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

							<div class="col-md-2">
                                <label for="ConcluidoProcedimento">Proc. Concl.?</label>
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                        id="ConcluidoProcedimento" name="ConcluidoProcedimento">
                                    <?php
                                    foreach ($select['ConcluidoProcedimento'] as $key => $row) {
                                        if ($query['ConcluidoProcedimento'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
							<!--
                            <div class="col-md-3">
                                <label for="Ordenamento">Ordenamento:</label>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                                    id="Campo" name="Campo">
                                                <?php
                                                foreach ($select['Campo'] as $key => $row) {
                                                    if ($query['Campo'] == $key) {
                                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <select data-placeholder="Selecione uma op��o..." class="form-control Chosen"
                                                    id="Ordenamento" name="Ordenamento">
                                                <?php
                                                foreach ($select['Ordenamento'] as $key => $row) {
                                                    if ($query['Ordenamento'] == $key) {
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
                            </div>
							-->
                        </div>
                    </div>
					<div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="DataInicio">Data In�cio: *</label>
                                <div class="input-group DatePicker">
                                    <input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
                                           autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
                                    <span class="input-group-addon" disabled>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="DataFim">Data Fim: (opc.)</label>
                                <div class="input-group DatePicker">
                                    <input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
                                           autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
                                    <span class="input-group-addon" disabled>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
							<br>
							<div class="col-md-2 text-left">
								<button class="btn btn-lg btn-primary" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-search"></span> Pesquisar
								</button>
							</div>
                        </div>
                    </div>
                    </form>
                    <br>
                    <?php echo (isset($list)) ? $list : FALSE ?>
                </div>
            </div>
        </div>
    </div>
</div>
