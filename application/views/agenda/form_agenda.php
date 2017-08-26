<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-md-2"></div>
    <div class="col-md-8">

        <?php echo validation_errors(); ?>

        <div class="panel panel-<?php echo $panel; ?>">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open_multipart($form_open_path); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="DataInicio">Data</label>
                            <div class="input-group date">
                                <input type="text" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="DataFim">De</label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="idTab_TipoConsulta">TROCA</label><br>
                            <select data-placeholder="Selecione um TROCA..." class="form-control" 
                                    id="idTab_TipoConsulta" name="idTab_TipoConsulta">
                                <option value=""></option>
                                <?php
                                foreach ($select['TipoConsulta'] as $key => $row) {
                                    if ($query['idTab_TipoConsulta'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="Procedimento">TROCA</label>
                            <input type="text" class="form-control" id="Procedimento" maxlength="ongtex"
                                   name="Procedimento" value="<?php echo $query['Procedimento']; ?>">
                        </div>
                    </div>
                </div> 

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Obs">TROCA</label>
                            <input type="text" class="form-control" id="Obs" maxlength="ongtex"
                                   name="Obs" value="<?php echo $query['Obs']; ?>">
                        </div>
                    </div>
                </div>



            </div>

        </div>
        <div class="col-md-2"></div>

    </div>


</div>