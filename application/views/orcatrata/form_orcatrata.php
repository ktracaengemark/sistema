<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-sm-3 col-md-2 sidebar">
        <?php echo $nav_secundario; ?>
    </div>

    <div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <?php echo validation_errors(); ?>

        <div class="panel panel-<?php echo $panel; ?>">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open_multipart($form_open_path); ?>

                <!--App_OrcaTrata-->

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="DataOrca">Data do Orçamento:</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       autofocus name="DataOrca" value="<?php echo $orcatrata['DataOrca']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>


                        <div class="col-md-2 form-inline">
                            <label for="StatusOrca">Orçamento Aprovado?</label><br>
                            <div class="form-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <?php
                                    foreach ($select['StatusOrca'] as $key => $row) {
                                        if (!$orcatrata['StatusOrca'])
                                            $orcatrata['StatusOrca'] = 'N';

                                        ($key == 'S') ? $hideshow = 'show' : $hideshow = 'hide';

                                        if ($orcatrata['StatusOrca'] == $key) {
                                            echo ''
                                            . '<label class="btn btn-warning active" name="StatusOrca_' . $hideshow . '">'
                                            . '<input type="radio" name="StatusOrca" id="' . $hideshow . '" '
                                            . 'autocomplete="off" value="' . $key . '" checked>' . $row
                                            . '</label>'
                                            ;
                                        } else {
                                            echo ''
                                            . '<label class="btn btn-default" name="StatusOrca_' . $hideshow . '">'
                                            . '<input type="radio" name="StatusOrca" id="' . $hideshow . '" '
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

                <div id="StatusOrca" <?php echo $div['StatusOrca']; ?>>

                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 form-inline">
                                <label for="idTab_TipoConcluido">Tratamento Concluído?</label><br>
                                <div class="form-group">
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php
                                        foreach ($select['TipoConcluido'] as $key => $row) {
                                            (!$orcatrata['idTab_TipoConcluido']) ? $orcatrata['idTab_TipoConcluido'] = '1' : FALSE;

                                            if ($orcatrata['idTab_TipoConcluido'] == $key) {
                                                echo ''
                                                . '<label class="btn btn-warning active" name="radio_idTab_TipoConcluido" id="radiogeral' . $key . '">'
                                                . '<input type="radio" name="idTab_TipoConcluido" id="radiogeral" '
                                                . 'autocomplete="off" value="' . $key . '" checked>' . $row
                                                . '</label>'
                                                ;
                                            } else {
                                                echo ''
                                                . '<label class="btn btn-default" name="radio_idTab_TipoConcluido" id="radiogeral' . $key . '">'
                                                . '<input type="radio" name="idTab_TipoConcluido" id="radiogeral" '
                                                . 'autocomplete="off" value="' . $key . '" >' . $row
                                                . '</label>'
                                                ;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="DataConcl">Data da Conclusão</label>
                                <div class="input-group <?php echo $datepicker; ?>">
                                    <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                           name="DataConcl" value="<?php echo $orcatrata['DataConcl']; ?>">
                                    <span class="input-group-addon" disabled>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="DataRet">Data do Retorno</label>
                                <div class="input-group <?php echo $datepicker; ?>">
                                    <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                           name="DataRet" value="<?php echo $orcatrata['DataRet']; ?>">
                                    <span class="input-group-addon" disabled>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-danger">
                            <div class="panel-heading" role="tab" id="heading1" data-toggle="collapse" data-parent="#accordion1" data-target="#collapse1">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle">
                                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                        Orçamento - Produtos e Serviços
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse <?php echo $orcamentoin ?>" role="tabpanel" aria-labelledby="heading1">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="ValorOrca">Orçamento:</label><br>
                                                <div class="input-group" id="txtHint">
                                                    <span class="input-group-addon" id="basic-addon1">R$</span>
                                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                           name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="ValorEntOrca">Entrada:</label><br>
                                                <div class="input-group" id="txtHint">
                                                    <span class="input-group-addon" id="basic-addon1">R$</span>
                                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                           name="ValorEntOrca" value="<?php echo $orcatrata['ValorEntOrca'] ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="ValorResOrca">Resta:</label><br>
                                                <div class="input-group" id="txtHint">
                                                    <span class="input-group-addon" id="basic-addon1">R$</span>
                                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                           name="ValorResOrca" value="<?php echo $orcatrata['ValorResOrca'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-warning">
                            <div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle">
                                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                        Forma de Pagamento - Parcelas
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse <?php echo $parcelasin ?>" role="tabpanel" aria-labelledby="heading2">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="FormaPag">Forma de Pagamento:</label>
                                                <!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>formapag/cadastrar/formapag" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span> <b>Forma Pag</b>
                                                </a>-->
                                                <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                                        id="FormaPag" name="FormaPag">
                                                    <option value="">-- Sel. Forma --</option>
                                                    <?php
                                                    foreach ($select['FormaPag'] as $key => $row) {
                                                        if ($orcatrata['FormaPag'] == $key) {
                                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                        } else {
                                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="QtdParcOrca">Qtd de Parcelas:</label><br>
                                                <input type="text" class="form-control" maxlength="3"
                                                       name="QtdParcOrca" value="<?php echo $orcatrata['QtdParcOrca'] ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="DataVencOrca">Data do 1º Vencimento:</label>
                                                <div class="input-group <?php echo $datepicker; ?>">
                                                    <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                           name="DataVencOrca" value="<?php echo $orcatrata['DataVencOrca']; ?>">
                                                    <span class="input-group-addon" disabled>
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <div class="col-md-3 text-right">
                                                    <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
                                                        <span class="glyphicon glyphicon-menu-down"></span> Gerar Parcelas
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--App_parcelasRec-->
                                    <div <?php echo $collapse; ?> id="Parcelas">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <label for="ParcRec">Parcela:</label><br>
                                                    <input type="text" class="form-control" maxlength="6"
                                                           name="ParcRec" value="<?php echo $parcelasrec['ParcRec'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="ValorParcRec">Valor Parcela:</label><br>
                                                    <div class="input-group" id="txtHint">
                                                        <span class="input-group-addon" id="basic-addon1">R$</span>
                                                        <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                               name="ValorParcRec" value="<?php echo $parcelasrec['ValorParcRec'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="DataVencRec">Data Venc. Parc.</label>
                                                    <div class="input-group <?php echo $datepicker; ?>">
                                                        <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                               name="DataVencRec" value="<?php echo $parcelasrec['DataVencRec']; ?>">
                                                        <span class="input-group-addon" disabled>
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="ValorPagoRec">Valor Pago:</label><br>
                                                    <div class="input-group" id="txtHint">
                                                        <span class="input-group-addon" id="basic-addon1">R$</span>
                                                        <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                               name="ValorPagoRec" value="<?php echo $parcelasrec['ValorPagoRec'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="DataPagoRec">Data Pag.</label>
                                                    <div class="input-group <?php echo $datepicker; ?>">
                                                        <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                               name="DataPagoRec" value="<?php echo $parcelasrec['DataPagoRec']; ?>">
                                                        <span class="input-group-addon" disabled>
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="QuitRec">Qt?</label><br>
                                                    <input type="text" class="form-control" maxlength="1"
                                                           name="QuitRec" value="<?php echo $parcelasrec['QuitRec'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-success">
                            <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle">
                                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                        Tratamento - Procedimentos
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse <?php echo $tratamentosin ?>" role="tabpanel" aria-labelledby="heading3">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="DataProcedimento">Data do Procedimento</label>
                                                <div class="input-group <?php echo $datepicker; ?>">
                                                    <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                           name="DataProcedimento" value="<?php echo $procedimento['DataProcedimento']; ?>">
                                                    <span class="input-group-addon" disabled>
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="Profissional">ProfProc</label>
                                                <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
                                                    <span class="glyphicon glyphicon-plus"></span> <b>Profissional</b>
                                                </a>
                                                <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                                        id="Profissional" name="Profissional">
                                                    <option value="">--Sel. Prof.--</option>
                                                    <?php
                                                    foreach ($select['Profissional'] as $key => $row) {
                                                        if ($procedimento['Profissional'] == $key) {
                                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                        } else {
                                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Proc">Procedimento:</label>
                                                <textarea class="form-control" id="Proc" <?php echo $readonly; ?>
                                                          name="Proc"><?php echo $procedimento['Proc']; ?></textarea>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="idApp_Profissional">Profissional</label>
                                <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
                                    <span class="glyphicon glyphicon-plus"></span> <b>Profissional</b>
                                </a>
                                <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                        id="idApp_Profissional" name="idApp_Profissional">
                                    <option value="">--Sel. Prof.--</option>
                                    <?php
                                    foreach ($select['Profissional'] as $key => $row) {
                                        if ($orcatrata['idApp_Profissional'] == $key) {
                                            echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                        } else {
                                            echo '<option value="' . $key . '">' . $row . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label for="ObsOrca">OBS:</label>
                                <textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?>
                                          name="ObsOrca"><?php echo $orcatrata['ObsOrca']; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                </div>

                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
                        <input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
                        <input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
                        <input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">
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
