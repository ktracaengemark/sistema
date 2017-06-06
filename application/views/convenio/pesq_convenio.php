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
                            <label for="Convenio">Nome do Convenio:</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                   autofocus name="Convenio" value="<?php echo $query['Convenio'] ?>">
                        </div>
						
						<div class="col-md-3">
                            <label for="Abrev">Abrev.:</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                   autofocus name="Abrev" value="<?php echo $query['Abrev'] ?>">
                        </div>
						
                      
                        <input type="hidden" name="idTab_Convenio" value="<?php echo $query['idTab_Convenio']; ?>">

                    </div>

                    <br>
                
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $button ?>
                        </div>

                        <input type="hidden" name="idTab_Convenio" value="<?php echo $query['idTab_Convenio']; ?>">
                    </div>                
                </form>

                <br>                
                
                <?php if (isset($list)) echo $list; ?>

            </div>

        </div>

    </div>
    <div class="col-md-2"></div>

</div>