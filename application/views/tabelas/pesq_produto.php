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
                            <label for="NomeProduto">Nome do Produto: *</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                   autofocus name="NomeProduto" value="<?php echo $query['NomeProduto'] ?>">
                        </div>
						
						<div class="col-md-3">
                            <label for="Unidade">Unidade:</label><br>
                            <input type="text" class="form-control" maxlength="20"
                                   autofocus name="Unidade" value="<?php echo $query['Unidade'] ?>">
                        </div>
						
						<div class="col-md-3">
                            <label for="ValorVenda">Valor de Venda: *</label><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                       autofocus name="ValorVenda" value="<?php echo $query['ValorVenda'] ?>">
                            </div>
                        </div>
						
						
                    </div>

                    <br>
                <!--
                    <div class="row">
                        <div class="col-md-3">
                            <label for="QuantidadeCompra">Quantidade Comprada:</label><br>
                                <input type="text" class="form-control Valor" maxlength="10"
                                       autofocus name="QuantidadeCompra" value="<?php echo $query['QuantidadeCompra'] ?>">
                        </div>

                                                         
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="ValorCompra">Valor total da Compra:</label><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
                                       autofocus name="ValorCompra" value="<?php echo $query['ValorCompra'] ?>">
                            </div>
                        </div>                             
                        
                             
                    </div>
				
                    <br>
                -->    
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $button ?>
                        </div>

                        <input type="hidden" name="idTab_Produto" value="<?php echo $query['idTab_Produto']; ?>">
                    </div>                
                </form>

                <br>                
                
                <?php if (isset($list)) echo $list; ?>

            </div>

        </div>

    </div>
    <div class="col-md-2"></div>

</div>