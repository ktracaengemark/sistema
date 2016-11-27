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
                        <div class="col-md-6">
                            <label for="NomeServico">Nome do Serviço:</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                   autofocus name="NomeServico" value="<?php echo $query['NomeServico'] ?>">
                        </div>

                        <div class="col-md-3">
                            <label for="ValorVenda">Valor do Serviço:</label><br>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                       autofocus name="ValorVenda" value="<?php echo $query['ValorVenda'] ?>">
                            </div>
                        </div>

                        <input type="hidden" name="idTab_Servico" value="<?php echo $query['idTab_Servico']; ?>">

                    </div>

                    <br>
                
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $button ?>
                        </div>

                        <input type="hidden" name="idTab_Servico" value="<?php echo $query['idTab_Servico']; ?>">
                    </div>                
                </form>

                <br>                
                
                <?php if (isset($list)) echo $list; ?>

            </div>

        </div>

    </div>
    <div class="col-md-2"></div>

</div>