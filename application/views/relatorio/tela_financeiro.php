<?php if ($msg) echo $msg; ?>

<div class="container-fluid">
    <div class="row">
        <!--
        <div class="col-sm-3 col-md-2 sidebar">
            <?php echo $nav_secundario; ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        -->
        <div class="main">

            <?php echo validation_errors(); ?>

            <div class="panel panel-primary">

                <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
                <div class="panel-body">

                    <?php echo form_open('relatorio/financeiro', 'role="form"'); ?>

                    <div class="form-group">
                        <div class="row">

                            <!--
                            <div class="col-md-4">
                                <label for="Pesquisa">Pesquisar: *</label>
                                <select data-placeholder="Selecione uma opção..." class="form-control"
                                        id="Pesquisa" name="Pesquisa">
                                    <option value="">-- Selecione uma opção --</option>
                                    <?php
                                    foreach ($select['Pesquisa'] as $key => $row) {
                                        if ($query['Pesquisa'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            -->

                            <div class="col-md-2"></div>

                            <div class="col-md-4">
                                <label for="DataInicio">Data Início: *</label>
                                <div class="input-group DatePicker">
                                    <input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
                                           autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
                                    <span class="input-group-addon" disabled>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="DataFim">Data Fim: (opcional)</label>
                                <div class="input-group DatePicker">
                                    <input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
                                           autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
                                    <span class="input-group-addon" disabled>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-2"></div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 text-center">
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
