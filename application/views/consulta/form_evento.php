<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-sm-3 col-md-2 sidebar">
        <?php echo $nav_secundario; ?>
    </div>

    <div class="col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main">

        <?php echo validation_errors(); ?>

        <div class="panel panel-<?php echo $panel; ?>">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open_multipart($form_open_path); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Data">Data:</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="Data" value="<?php echo $query['Data']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-7 form-inline">
                            <div class="form-group">
                                <label for="Hora">Hora:</label><br>
                                De 
                                <div class="input-group <?php echo $timepicker; ?>">
                                    <input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
                                           accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>

                                Até
                                <div class="input-group <?php echo $timepicker; ?>">
                                    <input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
                                           accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Obs">Obs:</label>
                            <textarea class="form-control" id="Obs"
                                      name="Obs"><?php echo $query['Obs']; ?></textarea>
                        </div>
                    </div>
                </div> 

                <br>

                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
                        <input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">
                        <input type="hidden" name="Evento" value="1">
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