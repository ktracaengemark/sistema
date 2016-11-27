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
                        <div class="col-md-8">
                            <label for="TipoDespesa">Nome do TipoDespesa:</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                   autofocus name="TipoDespesa" value="<?php echo $query['TipoDespesa'] ?>">
                        </div>
                      
                        <input type="hidden" name="idTab_TipoDespesa" value="<?php echo $query['idTab_TipoDespesa']; ?>">

                    </div>

                    <br>
                
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $button ?>
                        </div>

                        <input type="hidden" name="idTab_TipoDespesa" value="<?php echo $query['idTab_TipoDespesa']; ?>">
                    </div>                
                </form>

                <br>                
                
                <?php if (isset($list)) echo $list; ?>

            </div>

        </div>

    </div>
    <div class="col-md-2"></div>

</div>