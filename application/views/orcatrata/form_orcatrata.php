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

                        <div class="col-md-4">
                            <label for="ProfissionalOrca">Profissional:</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                    id="ProfissionalOrca" name="ProfissionalOrca">
                                <option value="">-- Selecione uma opção --</option>
                                <?php
                                foreach ($select['Profissional'] as $key => $row) {
                                    if ($orcatrata['ProfissionalOrca'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2 form-inline">
                            <label for="AprovadoOrca">Orçamento Aprovado?</label><br>
                            <div class="form-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <?php
                                    foreach ($select['AprovadoOrca'] as $key => $row) {
                                        if (!$orcatrata['AprovadoOrca'])
                                            $orcatrata['AprovadoOrca'] = 'N';

                                        ($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

                                        if ($orcatrata['AprovadoOrca'] == $key) {
                                            echo ''
                                            . '<label class="btn btn-warning active" name="AprovadoOrca_' . $hideshow . '">'
                                            . '<input type="radio" name="AprovadoOrca" id="' . $hideshow . '" '
                                            . 'autocomplete="off" value="' . $key . '" checked>' . $row
                                            . '</label>'
                                            ;
                                        } else {
                                            echo ''
                                            . '<label class="btn btn-default" name="AprovadoOrca_' . $hideshow . '">'
                                            . '<input type="radio" name="AprovadoOrca" id="' . $hideshow . '" '
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

                <div class="form-group" id="AprovadoOrca" <?php echo $div['AprovadoOrca']; ?>>

	                <hr>

                    <div class="row">
                        <div class="col-md-2 form-inline">
                            <label for="ServicoConcluido">Serviço Concluído?</label><br>
                            <div class="form-group">
                                <div class="btn-group" data-toggle="buttons">
                                    <?php
                                    foreach ($select['TipoConcluido'] as $key => $row) {
                                        (!$orcatrata['ServicoConcluido']) ? $orcatrata['ServicoConcluido'] = '1' : FALSE;

                                        if ($orcatrata['ServicoConcluido'] == $key) {
                                            echo ''
                                            . '<label class="btn btn-warning active" name="radiobutton_ServicoConcluido" id="radiobutton' . $key . '">'
                                            . '<input type="radio" name="ServicoConcluido" id="radiobutton" '
                                            . 'autocomplete="off" value="' . $key . '" checked>' . $row
                                            . '</label>'
                                            ;
                                        } else {
                                            echo ''
                                            . '<label class="btn btn-default" name="radiobutton_ServicoConcluido" id="radiobutton' . $key . '">'
                                            . '<input type="radio" name="ServicoConcluido" id="radiobutton" '
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
                            <label for="DataConclusao">Data da Conclusão:</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="DataConclusao" value="<?php echo $orcatrata['DataConclusao']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="DataRetorno">Data do Retorno:</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="DataRetorno" value="<?php echo $orcatrata['DataRetorno']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
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

                                <!--#######################################-->

                                <input type="hidden" name="SCount" id="SCount" value="<?php echo $servico['SCount']; ?>"/>

                                <div class="input_fields_wrap">

                                <?php
                                for ($i=1; $i <= $servico['SCount']; $i++) {
                                ?>

                                <div class="form-group" id="1div<?php echo $i ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="idTab_Servico">Serviço:</label>
                                            <?php if ($i == 1) { ?>
                                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button">
                                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Serviço</b>
                                            </a>
                                            <?php } ?>
                                            <select data-placeholder="Selecione uma opção..." class="form-control" onchange="buscaValor(this.value,this.name,'Servico',<?php echo $i ?>)" <?php echo $readonly; ?>
                                                    id="lista" name="idTab_Servico<?php echo $i ?>">
                                                <option value="">-- Selecione uma opção --</option>
                                                <?php
                                                foreach ($select['Servico'] as $key => $row) {
                                                    if ($servico[$i]['idTab_Servico'] == $key) {
                                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ValorVendaServico">Valor do Serviço:</label>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
                                                    onkeyup="calculaOrcamento()"
                                                    name="ValorVendaServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorVendaServico'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <label for="ObsServico<?php echo $i ?>">Obs:</label><br>
                                            <input type="text" class="form-control" id="ObsServico<?php echo $i ?>" maxlength="250"
                                                   name="ObsServico<?php echo $i ?>" value="<?php echo $servico[$i]['ObsServico'] ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ConcluidoServico">Concluído? </label><br>
                                            <div class="form-group">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <?php
                                                    foreach ($select['ConcluidoServico'] as $key => $row) {
                                                        (!$servico[$i]['ConcluidoServico']) ? $servico[$i]['ConcluidoServico'] = 'N' : FALSE;

                                                        if ($servico[$i]['ConcluidoServico'] == $key) {
                                                            echo ''
                                                            . '<label class="btn btn-warning active" name="radiobutton_ConcluidoServico' . $i . '" id="radiobutton_ConcluidoServico' . $i .  $key . '">'
                                                            . '<input type="radio" name="ConcluidoServico' . $i . '" id="radiobuttondinamico" '
                                                            . 'autocomplete="off" value="' . $key . '" checked>' . $row
                                                            . '</label>'
                                                            ;
                                                        } else {
                                                            echo ''
                                                            . '<label class="btn btn-default" name="radiobutton_ConcluidoServico' . $i . '" id="radiobutton_ConcluidoServico' . $i .  $key . '">'
                                                            . '<input type="radio" name="ConcluidoServico' . $i . '" id="radiobuttondinamico" '
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
                                            <label><br></label><br>
                                            <button type="button" id="<?php echo $i ?>" class="remove_field btn btn-danger">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                }
                                ?>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="btn btn-xs btn-warning" onclick="adicionaServico()">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <input type="hidden" name="PCount" id="PCount" value="<?php echo $produto['PCount']; ?>"/>

                                <div class="input_fields_wrap2">

                                <?php
                                for ($i=1; $i <= $produto['PCount']; $i++) {
                                ?>

                                <div class="form-group" id="2div<?php echo $i ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="idTab_Produto">Produto:</label>
                                            <?php if ($i == 1) { ?>
                                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>produto/cadastrar/produto" role="button">
                                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Produto</b>
                                            </a>
                                            <?php } ?>
                                            <select data-placeholder="Selecione uma opção..." class="form-control" onchange="buscaValor(this.value,this.name,'Produto',<?php echo $i ?>)" <?php echo $readonly; ?>
                                                     id="listadinamicab<?php echo $i ?>" name="idTab_Produto<?php echo $i ?>">
                                                <option value="">-- Selecione uma opção --</option>
                                                <?php
                                                foreach ($select['Produto'] as $key => $row) {
                                                    if ($produto[$i]['idTab_Produto'] == $key) {
                                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="ValorVendaProduto">Valor do Produto:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00"
                                                    onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP')"
                                                    name="ValorVendaProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorVendaProduto'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="QuantidadeProduto">Qtd:</label>
                                            <input type="text" class="form-control" maxlength="3" id="Qtd<?php echo $i ?>" placeholder="0"
                                                    onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD')"
                                                    name="QuantidadeProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QuantidadeProduto'] ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="SubtotalProduto">Subtotal:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalProduto<?php echo $i ?>"
                                                       name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto[$i]['SubtotalProduto'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label><br></label><br>
                                            <button type="button" id="<?php echo $i ?>" class="remove_field2 btn btn-danger">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                }
                                ?>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="add_field_button2 btn btn-xs btn-warning">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
<!--#######################################-->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="ValorOrca">Orçamento:</label><br>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="ValorOrca" maxlength="10" placeholder="0,00" readonly=""
                                                       name="ValorOrca" value="<?php echo $orcatrata['ValorOrca'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="ValorEntradaOrca">Entrada:</label><br>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="ValorEntradaOrca" maxlength="10" placeholder="0,00"
                                                    onkeyup="calculaResta(this.value)"
                                                    name="ValorEntradaOrca" value="<?php echo $orcatrata['ValorEntradaOrca'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="ValorRestanteOrca">Resta:</label><br>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="ValorRestanteOrca" maxlength="10" placeholder="0,00" readonly=""
                                                       name="ValorRestanteOrca" value="<?php echo $orcatrata['ValorRestanteOrca'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
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
                                            <label for="FormaPagamento">Forma de Pagamento:</label>
                                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                                    id="FormaPagamento" name="FormaPagamento">
                                                <option value="">-- Sel. Forma --</option>
                                                <?php
                                                foreach ($select['FormaPagamento'] as $key => $row) {
                                                    if ($orcatrata['FormaPagamento'] == $key) {
                                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="QtdParcelasOrca">Qtd de Parcelas:</label><br>
                                            <input type="text" class="form-control" id="QtdParcelasOrca" maxlength="3"
                                                   name="QtdParcelasOrca" value="<?php echo $orcatrata['QtdParcelasOrca'] ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="DataVencimentoOrca">Data do 1º Vencimento:</label>
                                            <div class="input-group <?php echo $datepicker; ?>">
                                                <input type="text" class="form-control Date" id="DataVencimentoOrca" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                       name="DataVencimentoOrca" value="<?php echo $orcatrata['DataVencimentoOrca']; ?>">
                                                <span class="input-group-addon" disabled>
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-md-3 text-right">
                                                <button class="btn btn-warning" type="button" data-toggle="collapse" onclick="calculaParcelas()"
                                                        data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
                                                    <span class="glyphicon glyphicon-menu-down"></span> Gerar Parcelas
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--App_parcelasRec-->
                                <div class="input_fields_parcelas">

                                <?php
                                for ($i=1; $i <= $orcatrata['QtdParcelasOrca']; $i++) {
                                ?>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label for="ParcelaRecebiveis">Parcela:</label><br>
                                                <input type="text" class="form-control" maxlength="6" readonly=""
                                                       name="ParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ParcelaRecebiveis'] ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="ValorParcelaRecebiveis">Valor Parcela:</label><br>
                                                <div class="input-group" id="txtHint">
                                                    <span class="input-group-addon" id="basic-addon1">R$</span>
                                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly=""
                                                           name="ValorParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcelaRecebiveis'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="DataVencimentoRecebiveis">Data Venc. Parc.</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""
                                                           name="DataVencimentoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataVencimentoRecebiveis'] ?>">
                                                    <span class="input-group-addon" disabled>
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="ValorPagoRecebiveis">Valor Pago:</label><br>
                                                <div class="input-group" id="txtHint">
                                                    <span class="input-group-addon" id="basic-addon1">R$</span>
                                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                           name="ValorPagoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorPagoRecebiveis'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="DataPagoRecebiveis">Data Pag.</label>
                                                <div class="input-group DatePicker">
                                                    <input type="text" class="form-control Date" id="DataPagoRecebiveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
                                                           name="DataPagoRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['DataPagoRecebiveis'] ?>">
                                                    <span class="input-group-addon" disabled>
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="QuitadoRecebiveis">Quitado?</label><br>
                                                <div class="form-group">
                                                    <div class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-warning active" name="radio_QuitadoRecebiveis<?php echo $i ?>" id="radio_QuitadoRecebiveis<?php echo $i ?>N">
                                                        <input type="radio" name="QuitadoRecebiveis<?php echo $i ?>" id="radiogeraldinamico"
                                                            autocomplete="off" value="N" checked>Não
                                                        </label>
                                                        <label class="btn btn-default" name="radio_QuitadoRecebiveis<?php echo $i ?>" id="radio_QuitadoRecebiveis<?php echo $i ?>S">
                                                        <input type="radio" name="QuitadoRecebiveis<?php echo $i ?>" id="radiogeraldinamico"
                                                            autocomplete="off" value="S" checked>Sim
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
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
                                            <label for="DataProcedimento">Data do Procedimento:</label>
                                            <div class="input-group <?php echo $datepicker; ?>">
                                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                       name="DataProcedimento" value="<?php echo $procedimento['DataProcedimento']; ?>">
                                                <span class="input-group-addon" disabled>
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Profissional">Profissional:</label>
                                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
                                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
                                            </a>
                                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                                    id="Profissional" name="Profissional">
                                                <option value="">-- Selecione uma opção --</option>
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
                                            <label for="Procedimento">Procedimento:</label>
                                            <textarea class="form-control" id="Procedimento" <?php echo $readonly; ?>
                                                      name="Procedimento"><?php echo $procedimento['Procedimento']; ?></textarea>
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
                        <div class="col-md-7">
                            <label for="ObsOrca">OBS:</label>
                            <textarea class="form-control" id="ObsOrca" <?php echo $readonly; ?>
                                      name="ObsOrca"><?php echo $orcatrata['ObsOrca']; ?></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
                        <input type="hidden" name="idApp_OrcaTrata" value="<?php echo $orcatrata['idApp_OrcaTrata']; ?>">
                        <input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
                        <!--<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
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
