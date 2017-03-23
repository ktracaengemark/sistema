<?php if (isset($msg)) echo $msg; ?>

<div class="row">
	<div class="form-group">
		<div class="row">
			<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>tarefa/cadastrar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Cadastrar Nova Tarefa
			</a>
			
			<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>tarefa/listar" role="button"> 
				<span class="glyphicon glyphicon-plus"></span> Listar Tarefas
			</a>
		</div>	
	</div>
    <!--<div class="col-sm-3 col-md-2 sidebar">
        <?php echo $nav_secundario; ?>
    </div>-->

    <div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <?php echo validation_errors(); ?>

        <div class="panel panel-<?php echo $panel; ?>">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open_multipart($form_open_path); ?>

                <!--App_Tarefa-->

                <div class="form-group">
                    <div class="row">                      
						<div class="col-md-4">
							<label for="ObsTarefa">Tarefa:</label>
							<textarea class="form-control" id="ObsTarefa" <?php echo $readonly; ?>
									  name="ObsTarefa"><?php echo $tarefa['ObsTarefa']; ?></textarea>
						</div>
						
						<div class="col-md-2">
                            <label for="DataTarefa">Criada em:</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       autofocus name="DataTarefa" value="<?php echo $tarefa['DataTarefa']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
						
						<div class="col-md-2">
								<label for="DataPrazoTarefa">Prazo Final:</label>
								<div class="input-group <?php echo $datepicker; ?>">
									<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
										   autofocus name="DataPrazoTarefa" value="<?php echo $tarefa['DataPrazoTarefa']; ?>">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>

                        <div class="col-md-4">
                            <label for="ProfissionalTarefa">Criador da Tarefa:</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                    id="ProfissionalTarefa" name="ProfissionalTarefa">
                                <option value="">-- Selecione uma opção --</option>
                                <?php
                                foreach ($select['Profissional'] as $key => $row) {
                                    if ($tarefa['ProfissionalTarefa'] == $key) {
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

	                <hr>
				<!--
                <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
                        <div class="panel-heading" role="tab" id="heading1" data-toggle="collapse" data-parent="#accordion1" data-target="#collapse1">
                            <h4 class="panel-title">
                                <a class="accordion-toggle">
                                    <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                    Tarefa - Produtos e Serviços
                                </a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse <?php echo $tarefain ?>" role="tabpanel" aria-labelledby="heading1">
                            <div class="panel-body">

                                

                                <input type="hidden" name="SCount" id="SCount" value="<?php echo $count['SCount']; ?>"/>

                                <div class="input_fields_wrap">

                                <?php
                                for ($i=1; $i <= $count['SCount']; $i++) {
                                ?>

                                <?php if ($metodo > 1) { ?>
                                <input type="hidden" name="idApp_ServicoVenda<?php echo $i ?>" value="<?php echo $servico[$i]['idApp_ServicoVenda']; ?>"/>
                                <?php } ?>

                                <div class="form-group" id="1div<?php echo $i ?>">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-4">
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
                                                <div class="col-md-3">
                                                    <label for="ValorVendaServico">Valor do Serviço:</label>
                                                    <div class="input-group" id="txtHint">
                                                        <span class="input-group-addon" id="basic-addon1">R$</span>
                                                        <input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00"
                                                            onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Servico')"
                                                            name="ValorVendaServico<?php echo $i ?>" value="<?php echo $servico[$i]['ValorVendaServico'] ?>">
                                                    </div>

                                                </div>
                                                <div class="col-md-1">
                                                    <label for="QtdVendaServico">Qtd:</label>
                                                    <input type="text" class="form-control Numero" maxlength="3" id="QtdVendaServico<?php echo $i ?>" placeholder="0"
                                                            onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Servico')"
                                                            name="QtdVendaServico<?php echo $i ?>" value="<?php echo $servico[$i]['QtdVendaServico'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="SubtotalServico">Subtotal:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1">R$</span>
                                                        <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico<?php echo $i ?>"
                                                               name="SubtotalServico<?php echo $i ?>" value="<?php echo $servico[$i]['SubtotalServico'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label><br></label><br>
                                                    <button type="button" id="<?php echo $i ?>" class="remove_field btn btn-danger">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
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
                                            </div>
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
                                                <span class="glyphicon glyphicon-plus"></span> Adicionar Serviço
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <input type="hidden" name="PCount" id="PCount" value="<?php echo $count['PCount']; ?>"/>

                                <div class="input_fields_wrap2">

                                <?php
                                for ($i=1; $i <= $count['PCount']; $i++) {
                                ?>

                                <?php if ($metodo > 1) { ?>
                                <input type="hidden" name="idApp_ProdutoVenda<?php echo $i ?>" value="<?php echo $produto[$i]['idApp_ProdutoVenda']; ?>"/>
                                <?php } ?>

                                <div class="form-group" id="2div<?php echo $i ?>">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
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
                                                            onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','VP','Produto')"
                                                            name="ValorVendaProduto<?php echo $i ?>" value="<?php echo $produto[$i]['ValorVendaProduto'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="QtdVendaProduto">Qtd:</label>
                                                    <input type="text" class="form-control Numero" maxlength="3" id="QtdVendaProduto<?php echo $i ?>" placeholder="0"
                                                            onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>','QTD','Produto')"
                                                            name="QtdVendaProduto<?php echo $i ?>" value="<?php echo $produto[$i]['QtdVendaProduto'] ?>">
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
                                                <span class="glyphicon glyphicon-plus"></span> Adicionar Produto
                                            </a>
                                        </div>
                                    </div>
                                </div>

								<hr>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="ValorTarefa">Tarefa:</label><br>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="ValorTarefa" maxlength="10" placeholder="0,00" readonly=""
                                                       name="ValorTarefa" value="<?php echo $tarefa['ValorTarefa'] ?>">
                                            </div>
                                        </div>

										<div class="col-md-3">
                                            <label for="FormaPagamento">Forma de Pagamento:</label>
                                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                                    id="FormaPagamento" name="FormaPagamento">
                                                <option value="">-- Selecione uma opção --</option>
                                                <?php
                                                foreach ($select['FormaPagamento'] as $key => $row) {
                                                    if ($tarefa['FormaPagamento'] == $key) {
                                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="ValorEntradaTarefa">Valor Pago - A Vista /Entrada:</label><br>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="ValorEntradaTarefa" maxlength="10" placeholder="0,00"
                                                    onkeyup="calculaResta(this.value)"
                                                    name="ValorEntradaTarefa" value="<?php echo $tarefa['ValorEntradaTarefa'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="DataEntradaTarefa">Data do Pagamento:</label>
                                            <div class="input-group <?php echo $datepicker; ?>">
                                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                       name="DataEntradaTarefa" value="<?php echo $tarefa['DataEntradaTarefa']; ?>">
                                                <span class="input-group-addon" disabled>
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="ValorRestanteTarefa">Resta:</label><br>
                                            <div class="input-group" id="txtHint">
                                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                                <input type="text" class="form-control Valor" id="ValorRestanteTarefa" maxlength="10" placeholder="0,00" readonly=""
                                                       name="ValorRestanteTarefa" value="<?php echo $tarefa['ValorRestanteTarefa'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
				-->
				<!--
                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
                        <div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
                            <h4 class="panel-title">
                                <a class="accordion-toggle">
                                    <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                    Parcelado / Faturado
                                </a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse <?php echo $parcelasin ?>" role="tabpanel" aria-labelledby="heading2">
                            <div class="panel-body">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="QtdParcelasTarefa">Qtd de Parcelas:</label><br>
                                            <input type="text" class="form-control Numero" id="QtdParcelasTarefa" maxlength="3" placeholder="0"
                                                   name="QtdParcelasTarefa" value="<?php echo $tarefa['QtdParcelasTarefa'] ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="DataVencimentoTarefa">Data do 1º Venc.</label>
                                            <div class="input-group <?php echo $datepicker; ?>">
                                                <input type="text" class="form-control Date" id="DataVencimentoTarefa" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                       name="DataVencimentoTarefa" value="<?php echo $tarefa['DataVencimentoTarefa']; ?>">
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

                              
                                <div class="input_fields_parcelas">

                                <?php
                                for ($i=1; $i <= $tarefa['QtdParcelasTarefa']; $i++) {
                                ?>

                                    <?php if ($metodo > 1) { ?>
                                    <input type="hidden" name="idApp_ParcelasRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['idApp_ParcelasRecebiveis']; ?>"/>
                                    <?php } ?>

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
                                                    <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                                           name="ValorParcelaRecebiveis<?php echo $i ?>" value="<?php echo $parcelasrec[$i]['ValorParcelaRecebiveis'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="DataVencimentoRecebiveis">Data Venc. Parc.</label>
                                                <div class="input-group DatePicker">
                                                    <input type="text" class="form-control Date" id="DataVencimentoRecebiveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
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
                                                        <?php
                                                        foreach ($select['QuitadoRecebiveis'] as $key => $row) {
                                                            (!$parcelasrec[$i]['QuitadoRecebiveis']) ? $parcelasrec[$i]['QuitadoRecebiveis'] = 'N' : FALSE;

                                                            if ($parcelasrec[$i]['QuitadoRecebiveis'] == $key) {
                                                                echo ''
                                                                . '<label class="btn btn-warning active" name="radiobutton_QuitadoRecebiveis' . $i . '" id="radiobutton_QuitadoRecebiveis' . $i .  $key . '">'
                                                                . '<input type="radio" name="QuitadoRecebiveis' . $i . '" id="radiobuttondinamico" '
                                                                . 'autocomplete="off" value="' . $key . '" checked>' . $row
                                                                . '</label>'
                                                                ;
                                                            } else {
                                                                echo ''
                                                                . '<label class="btn btn-default" name="radiobutton_QuitadoRecebiveis' . $i . '" id="radiobutton_QuitadoRecebiveis' . $i .  $key . '">'
                                                                . '<input type="radio" name="QuitadoRecebiveis' . $i . '" id="radiobuttondinamico" '
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

                                <?php
                                }
                                ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
				-->
                <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
                        <div class="panel-heading" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion3" data-target="#collapse3">
                            <h4 class="panel-title">
                                <a class="accordion-toggle">
                                    <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                    Ações
                                </a>
                            </h4>
                        </div>

                        <div id="collapse3" class="panel-collapse collapse <?php echo $tratamentosin ?>" role="tabpanel" aria-labelledby="heading3">
                            <div class="panel-body">

                                <input type="hidden" name="PTCount" id="PTCount" value="<?php echo $count['PTCount']; ?>"/>

                                <div class="input_fields_wrap3">

                                <?php
                                for ($i=1; $i <= $count['PTCount']; $i++) {
                                ?>

                                <?php if ($metodo > 1) { ?>
                                <input type="hidden" name="idApp_Procedtarefa<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['idApp_Procedtarefa']; ?>"/>
                                <?php } ?>

                                <div class="form-group" id="3div<?php echo $i ?>">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="DataProcedtarefa<?php echo $i ?>">Data da Ação:</label>
                                            <div class="input-group <?php echo $datepicker; ?>">
                                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                                       name="DataProcedtarefa<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataProcedtarefa']; ?>">
                                                <span class="input-group-addon" disabled>
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
										<div class="col-md-2">
											<label for="DataProcedtarefaLimite<?php echo $i ?>">Data Limite:</label>
											<div class="input-group <?php echo $datepicker; ?>">
												<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
													   name="DataProcedtarefaLimite<?php echo $i ?>" value="<?php echo $procedtarefa[$i]['DataProcedtarefaLimite']; ?>">
												<span class="input-group-addon" disabled>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
                                        <div class="col-md-2">
                                            <label for="Profissional<?php echo $i ?>">Profissional:</label>
                                            <?php if ($i == 1) { ?>
                                            <!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button">
                                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
                                            </a>-->
                                            <?php } ?>
                                            <select data-placeholder="Selecione uma opção..." class="form-control"
                                                     id="listadinamicac<?php echo $i ?>" name="Profissional<?php echo $i ?>">
                                                <option value="">-- Selecione uma opção --</option>
                                                <?php
                                                foreach ($select['Profissional'] as $key => $row) {
                                                    if ($procedtarefa[$i]['Profissional'] == $key) {
                                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Procedtarefa<?php echo $i ?>">Ação:</label>
                                            <textarea class="form-control" id="Procedtarefa<?php echo $i ?>" <?php echo $readonly; ?>
                                                      name="Procedtarefa<?php echo $i ?>"><?php echo $procedtarefa[$i]['Procedtarefa']; ?></textarea>
                                        </div>
										<div class="col-md-2">
											<label for="ConcluidoProcedtarefa">Ação. Concl.? </label><br>
											<div class="form-group">
												<div class="btn-group" data-toggle="buttons">
													<?php
													foreach ($select['ConcluidoProcedtarefa'] as $key => $row) {
														(!$procedtarefa[$i]['ConcluidoProcedtarefa']) ? $procedtarefa[$i]['ConcluidoProcedtarefa'] = 'N' : FALSE;

														if ($procedtarefa[$i]['ConcluidoProcedtarefa'] == $key) {
															echo ''
															. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedtarefa' . $i . '" id="radiobutton_ConcluidoProcedtarefa' . $i .  $key . '">'
															. '<input type="radio" name="ConcluidoProcedtarefa' . $i . '" id="radiobuttondinamico" '
															. 'autocomplete="off" value="' . $key . '" checked>' . $row
															. '</label>'
															;
														} else {
															echo ''
															. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedtarefa' . $i . '" id="radiobutton_ConcluidoProcedtarefa' . $i .  $key . '">'
															. '<input type="radio" name="ConcluidoProcedtarefa' . $i . '" id="radiobuttondinamico" '
															. 'autocomplete="off" value="' . $key . '" >' . $row
															. '</label>'
															;
														}
													}
													?>
												</div>
											</div>
										</div>
                                        <div class="col-md-1">
                                            <label><br></label><br>
                                            <button type="button" id="<?php echo $i ?>" class="remove_field3 btn btn-danger">
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
                                            <a class="add_field_button3 btn btn-xs btn-warning" onclick="adicionaProcedtarefa()">
                                                <span class="glyphicon glyphicon-plus"></span> Adicionar Procedtarefa
                                            </a>
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
						<div class="col-md-2 form-inline">
							<label for="AprovadoTarefa">Tarefa Concluída?</label><br>
							<div class="form-group">
								<div class="btn-group" data-toggle="buttons">
									<?php
									foreach ($select['AprovadoTarefa'] as $key => $row) {
										if (!$tarefa['AprovadoTarefa'])
											$tarefa['AprovadoTarefa'] = 'N';

										($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';

										if ($tarefa['AprovadoTarefa'] == $key) {
											echo ''
											. '<label class="btn btn-warning active" name="AprovadoTarefa_' . $hideshow . '">'
											. '<input type="radio" name="AprovadoTarefa" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" checked>' . $row
											. '</label>'
											;
										} else {
											echo ''
											. '<label class="btn btn-default" name="AprovadoTarefa_' . $hideshow . '">'
											. '<input type="radio" name="AprovadoTarefa" id="' . $hideshow . '" '
											. 'autocomplete="off" value="' . $key . '" >' . $row
											. '</label>'
											;
										}
									}
									?>

								</div>
							</div>
						</div>

						<div class="form-group">
                            <div id="AprovadoTarefa" <?php echo $div['AprovadoTarefa']; ?>>
								<!--
								<div class="col-md-2 form-inline">
    								<label for="QuitadoTarefa">Orçam. Quitado?</label><br>
    								<div class="form-group">
    									<div class="btn-group" data-toggle="buttons">
    										<?php
    										foreach ($select['QuitadoTarefa'] as $key => $row) {
    											(!$tarefa['QuitadoTarefa']) ? $tarefa['QuitadoTarefa'] = 'N' : FALSE;

    											if ($tarefa['QuitadoTarefa'] == $key) {
    												echo ''
    												. '<label class="btn btn-warning active" name="radiobutton_QuitadoTarefa" id="radiobutton_QuitadoTarefa' . $key . '">'
    												. '<input type="radio" name="QuitadoTarefa" id="radiobutton" '
    												. 'autocomplete="off" value="' . $key . '" checked>' . $row
    												. '</label>'
    												;
    											} else {
    												echo ''
    												. '<label class="btn btn-default" name="radiobutton_QuitadoTarefa" id="radiobutton_QuitadoTarefa' . $key . '">'
    												. '<input type="radio" name="QuitadoTarefa" id="radiobutton" '
    												. 'autocomplete="off" value="' . $key . '" >' . $row
    												. '</label>'
    												;
    											}
    										}
    										?>
    									</div>
    								</div>
    							</div>
								
    							<div class="col-md-2 form-inline">
    								<label for="ServicoConcluido">Serviço Concluído?</label><br>
    								<div class="form-group">
    									<div class="btn-group" data-toggle="buttons">
    										<?php
    										foreach ($select['ServicoConcluido'] as $key => $row) {
    											(!$tarefa['ServicoConcluido']) ? $tarefa['ServicoConcluido'] = 'N' : FALSE;

    											if ($tarefa['ServicoConcluido'] == $key) {
    												echo ''
    												. '<label class="btn btn-warning active" name="radiobutton_ServicoConcluido" id="radiobutton_ServicoConcluido' . $key . '">'
    												. '<input type="radio" name="ServicoConcluido" id="radiobutton" '
    												. 'autocomplete="off" value="' . $key . '" checked>' . $row
    												. '</label>'
    												;
    											} else {
    												echo ''
    												. '<label class="btn btn-default" name="radiobutton_ServicoConcluido" id="radiobutton_ServicoConcluido' . $key . '">'
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
                                -->
    							<div class="col-md-2">
    								<label for="DataConclusao">Data da Conclusão:</label>
    								<div class="input-group <?php echo $datepicker; ?>">
    									<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
    										   name="DataConclusao" value="<?php echo $tarefa['DataConclusao']; ?>">
    									<span class="input-group-addon" disabled>
    										<span class="glyphicon glyphicon-calendar"></span>
    									</span>
    								</div>
    							</div>
								<div class="col-md-2">
									<label for="DataRetorno">Data do Retorno:</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
											   name="DataRetorno" value="<?php echo $tarefa['DataRetorno']; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
                            </div>   													
                        </div>
                    </div>					
				</div>

                <hr>

                <div class="form-group">
                    <div class="row">
                        <!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
                        <input type="hidden" name="idApp_Tarefa" value="<?php echo $tarefa['idApp_Tarefa']; ?>">
                        <?php if ($metodo > 1) { ?>
                        <!--<input type="hidden" name="idApp_Procedtarefa" value="<?php echo $procedtarefa['idApp_Procedtarefa']; ?>">
                        <input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
                        <?php } ?>
                        <?php if ($metodo == 2) { ?>
                            <!--
                            <div class="col-md-12 text-center">
                                <button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
                                    <span class="glyphicon glyphicon-trash"></span> Excluir
                                </button>
                                <button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
                                            return true;">
                                    <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                                </button>
                            </div>
                            <button type="button" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
                            </button>                        -->

                            <div class="col-md-6">
                                <button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
                                    <span class="glyphicon glyphicon-save"></span> Salvar
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
                                    <span class="glyphicon glyphicon-trash"></span> Excluir
                                </button>
                            </div>

                            <div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Tem certeza que deseja excluir?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Ao confirmar a exclusão todos os dados serão excluídos do banco de dados. Esta operação é irreversível.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-md-6 text-left">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                    <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                                                </button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <a class="btn btn-danger" href="<?php echo base_url() . 'tarefa/excluir/' . $tarefa['idApp_Tarefa'] ?>" role="button">
                                                    <span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
