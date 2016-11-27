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
                            <label for="Data">Data do Orçamento *</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="Data" value="<?php echo $query['Data']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
						
						<div class="col-md-4">
                            <label for="idApp_Profissional">Orç.Feito por: *</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button"> 
                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                    id="idApp_Profissional" name="idApp_Profissional">
                                <option value="">-- Selecione um Funcionário --</option>
                                <?php
                                foreach ($select['Profissional'] as $key => $row) {
                                    if ($query['idApp_Profissional'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="Obs">Obs do Orçam.:</label>
									<textarea class="form-control" id="Obs"
											  name="Obs"><?php echo $query['Obs']; ?></textarea>
								</div>
							</div>
						</div>                      
                    </div>
                </div> 

                <hr>
                
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
                                <span class="glyphicon glyphicon-menu-down"></span> Orçamento
                            </button>
                        </div>                
                    </div>
                </div> 

				<hr>	

			<div <?php echo $collapse; ?> id="DadosComplementares">

			
				
                <input type="hidden" name="SCount" id="SCount" value="<?php echo $servico['SCount']; ?>"/>
                               
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="idTab_Servico">Serviço:</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>servico/cadastrar/servico" role="button"> 
                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Serviço</b>
                            </a>
                            <!--<select data-placeholder="Selecione uma opção..." class="form-control" onchange="addValues(this.value)" <?php echo $readonly; ?>-->
                            <select data-placeholder="Selecione uma opção..." class="form-control" onchange="buscaValor(this.value,this.name,'Servico')" <?php echo $readonly; ?>
                                    id="lista" name="idTab_Servico1">
                                <option value="">-- Selecione um Serviço --</option>
                                <?php
                                foreach ($select['Servico'] as $key => $row) {
                                    if ($servico['idTab_Servico1'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
                        <div class="col-md-3">
                            <label for="ValorVenda">Valor do Serviço:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="idTab_Servico1" maxlength="10" placeholder="0,00" 
                                       name="ValorVenda1" value="<?php echo $servico['ValorVenda1'] ?>">
                            														
							</div>																					
                        </div>
						<div class="col-md-4">
								<label for="Obs">Obs:</label>
								<textarea class="form-control" id="Obs"
										  name="Obs"><?php echo $query['Obs']; ?></textarea>
						</div>
						
                    </div>               
                </div>   
                
                <div class="input_fields_wrap">
                
                <?php
                for ($i=2; $i <= $servico['SCount']; $i++) {
                ?>
                
                <div class="form-group" id="1div<?php echo $i ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="idTab_Servico">Serviço:</label>
                            <select data-placeholder="Selecione uma opção..." class="form-control" onchange="buscaValor(this.value,this.name,'Servico')" <?php echo $readonly; ?>
                                    id="lista" name="idTab_Servico<?php echo $i ?>">
                                <option value="">-- Selecione um Serviço --</option>
                                <?php
                                foreach ($select['Servico'] as $key => $row) {
                                    if ($servico['idTab_Servico'.$i] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
                        <div class="col-md-3">
                            <label for="ValorVenda">Valor do Serviço:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="idTab_Servico<?php echo $i ?>" maxlength="10" placeholder="0,00" readonly=""
                                       name="ValorVenda<?php echo $i ?>" value="<?php echo $servico['ValorVenda'.$i] ?>"> 
                            </div>
																												
                        </div>       
                        <div class="col-md-3">
                            <label><br></label><br>
                            <button type="button" id="<?php echo $i ?>" class="remove_field btn btn-danger">                                
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </div>
						<div class="col-md-4">
								<label for="Obs">Obs:</label>
								<textarea class="form-control" id="Obs"
										  name="Obs"><?php echo $query['Obs']; ?></textarea>
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
                            <a class="add_field_button btn btn-xs btn-warning">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>                   
                
                <hr>
                
                <input type="hidden" name="PCount" id="PCount" value="<?php echo $produto['PCount']; ?>"/>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="idTab_Produto">Produto:</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>produto/cadastrar/produto" role="button"> 
                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Produto</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" onchange="buscaValor(this.value,this.name,'Produto','1')" <?php echo $readonly; ?>
                                    id="idTab_Produto" name="idTab_Produto1">
                                <option value="">-- Selecione um Produto --</option>
                                <?php
                                foreach ($select['Produto'] as $key => $row) {
                                    if ($produto['idTab_Produto1'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
											
                        <div class="col-md-3">
                            <label for="ValorProduto">Valor do Produto:</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="idTab_Produto1" maxlength="10" placeholder="0,00" 
                                       name="ValorProduto1" value="<?php echo $produto['ValorProduto1'] ?>">
                            </div>
                        </div>                            
                        <div class="col-md-1">
                            <label for="Quantidade">Qtd:</label>                           
                            <input type="text" class="form-control" maxlength="3" id="Qtd1" placeholder="0" onkeyup="calculaSubtotal(this.value,this.name,'1')" 
                                   name="Quantidade1" value="<?php echo $produto['Quantidade1'] ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="ValorVenda">Subtotal:</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="Quantidade1"
                                       name="SubtotalProduto1" value="<?php echo $produto['SubtotalProduto1'] ?>">
                            </div>
                        </div>                                      
                    </div>
                </div>   

                <div class="input_fields_wrap2">
                    
                <?php
                for ($i=2; $i <= $produto['PCount']; $i++) {
                ?>
                
                <div class="form-group" id="2div<?php echo $i ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="idTab_Produto">Produto:</label>
                            <select data-placeholder="Selecione uma opção..." class="form-control" onchange="buscaValor(this.value,this.name,'Produto','<?php echo $i ?>')" <?php echo $readonly; ?>
                                     id="listadinamicab<?php echo $i ?>" name="idTab_Produto<?php echo $i ?>">
                                <option value="">-- Selecione um Produto --</option>
                                <?php
                                foreach ($select['Produto'] as $key => $row) {
                                    if ($produto['idTab_Produto'.$i] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
												
                        <div class="col-md-3">
                            <label for="ValorProduto">Valor do Produto:</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="idTab_Produto<?php echo $i ?>" maxlength="10" placeholder="0,00" 
                                       name="ValorVenda<?php echo $i ?>" value="<?php echo $produto['ValorVenda'.$i] ?>">
                            </div>
                        </div>                            
                        <div class="col-md-1">
                            <label for="Quantidade">Qtd:</label>                           
                            <input type="text" class="form-control" maxlength="3" id="Qtd<?php echo $i ?>" placeholder="0" onkeyup="calculaSubtotal(this.value,this.name,'<?php echo $i ?>')" 
                                   name="Quantidade<?php echo $i ?>" value="<?php echo $produto['Quantidade'.$i] ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="ValorVenda">Subtotal:</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="Quantidade<?php echo $i ?>"
                                       name="SubtotalProduto<?php echo $i ?>" value="<?php echo $produto['SubtotalProduto'.$i] ?>">
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
                
                <hr>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="OrcamentoTotal">Orçamento Total:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="OrcamentoTotal" maxlength="10" placeholder="0,00" readonly=""
                                       name="OrcamentoTotal" value="<?php echo $orcamento['OrcamentoTotal'] ?>">
                            </div>
                        </div>
						
						<div class="col-md-3">
                            <label for="OrcamentoTotal">Valor Pago:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="OrcamentoTotal" maxlength="10" placeholder="0,00" readonly=""
                                       name="OrcamentoTotal" value="<?php echo $orcamento['OrcamentoTotal'] ?>">
                            </div>
                        </div>
						
						<div class="col-md-3">
                            <label for="OrcamentoTotal">Resta Pagar:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="OrcamentoTotal" maxlength="10" placeholder="0,00" readonly=""
                                       name="OrcamentoTotal" value="<?php echo $orcamento['OrcamentoTotal'] ?>">
                            </div>
                        </div>						
                    </div>               
                </div>
			</div>  <!--Fim da função que esconde a tela ORÇAMENTO-->      
                
                <hr>
                   
			<div class="form-group">
				<div class="row">
					<div class="col-md-12 text-center">
						<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#FormaPagamento" aria-expanded="false" aria-controls="FormaPagamento">
							<span class="glyphicon glyphicon-menu-down"></span> Forma de Pagamento
						</button>
					</div>
					
					<!--<div class="col-md-6 text-center">
						<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
							<span class="glyphicon glyphicon-menu-up"></span> Orçamento
						</button>
					</div>-->
											
				</div>	
			</div>  
			
			<hr>
			
			<div <?php echo $collapse; ?> id="FormaPagamento">
	
				<div class="form-group">
					<div class="row">
					
						<div class="col-md-4">
                            <label for="idApp_Profissional">Forma de Pag. *</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button"> 
                                <span class="glyphicon glyphicon-plus"></span> <b>Nova Forma de Pagam.</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                    id="idApp_Profissional" name="idApp_Profissional">
                                <option value="">-- Selec. uma forma de Pagamento --</option>
                                <?php
                                foreach ($select['Profissional'] as $key => $row) {
                                    if ($query['idApp_Profissional'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
						
						<div class="col-md-2">
                            <label for="Quantidade">Qtd Parcelas:</label>                           
                            <input type="text" class="form-control" maxlength="3" id="Qtd1" placeholder="0" onkeyup="calculaSubtotal(this.value,this.name,'1')" 
                                   name="Quantidade1" value="<?php echo $produto['Quantidade1'] ?>">
                        </div>
						
						<div class="col-md-3">
                            <label for="Data">Data do 1ºVencimento: *</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="Data" value="<?php echo $query['Data']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
	
					</div>
					
					<hr>
					
					<div class="row">					
						<div class="col-md-1">
                            <label for="Quantidade">Parc.:</label>                           
                            <input type="text" class="form-control" maxlength="3" id="Qtd1" placeholder="0" onkeyup="calculaSubtotal(this.value,this.name,'1')" 
                                   name="Quantidade1" value="<?php echo $produto['Quantidade1'] ?>">
                        </div>
					
						<div class="col-md-2">
                            <label for="Data">Data Venc.: *</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="Data" value="<?php echo $query['Data']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
											
						<div class="col-md-2">
                            <label for="OrcamentoTotal">Valor Parc.:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="OrcamentoTotal" maxlength="10" placeholder="0,00" readonly=""
                                       name="OrcamentoTotal" value="<?php echo $orcamento['OrcamentoTotal'] ?>">
                            </div>
                        </div>
						
						<div class="col-md-3">
                            <label for="Data">Data Pag.: *</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="Data" value="<?php echo $query['Data']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
						
						<div class="col-md-2">
                            <label for="OrcamentoTotal">Valor Pago:</label>
                            <div class="input-group" id="txtHint">
                                <span class="input-group-addon" id="basic-addon1">R$</span>
                                <input type="text" class="form-control Valor" id="OrcamentoTotal" maxlength="10" placeholder="0,00" readonly=""
                                       name="OrcamentoTotal" value="<?php echo $orcamento['OrcamentoTotal'] ?>">
                            </div>
                        </div>
		
						<div class="col-md-2">
							<label for="ValorVenda">Quitado:</label>
							<div class="radio">
								<label><input type="radio" name="optradio">Pago</label>
							</div>																													
						</div>
					
					</div>
				</div>
			
			</div>
				
			<hr>
				
			<div class="form-group">
				<div class="row">
					<!--<div class="col-md-6 text-center">
						<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#FormaPagamento" aria-expanded="false" aria-controls="FormaPagamento">
							<span class="glyphicon glyphicon-menu-up"></span> Forma de Pagamento
						</button>
					</div>-->
					
					<div class="col-md-12 text-center">
						<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#Procedimentos" aria-expanded="false" aria-controls="Procedimentos">
							<span class="glyphicon glyphicon-menu-down"></span> Procedimentos
						</button>
					</div>
											
				</div>	
			</div>  
		
			<hr>
			<div <?php echo $collapse; ?> id="Procedimentos">
			
					<div class="row">
						
						<div class="col-md-3">
                            <label for="Data">Data do Procedimento.: *</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                       name="Data" value="<?php echo $query['Data']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
						
						<div class="col-md-4">
                            <label for="idApp_Profissional">Proc. Realiz. por: *</label>
                            <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>profissional/cadastrar/profissional" role="button"> 
                                <span class="glyphicon glyphicon-plus"></span> <b>Novo Profissional</b>
                            </a>
                            <select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
                                    id="idApp_Profissional" name="idApp_Profissional">
                                <option value="">-- Selec. um Profissional --</option>
                                <?php
                                foreach ($select['Profissional'] as $key => $row) {
                                    if ($query['idApp_Profissional'] == $key) {
                                        echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
                                    } else {
                                        echo '<option value="' . $key . '">' . $row . '</option>';
                                    }
                                }
                                ?>   
                            </select>          
                        </div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="Obs">Procedimento.:</label>
									<textarea class="form-control" id="Obs"
											  name="Obs"><?php echo $query['Obs']; ?></textarea>
								</div>
							</div>
						</div>

					</div>
			
			</div>
			<hr>		
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="idApp_Despesas" value="<?php echo $query['idApp_Despesas']; ?>">
                        <input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">
                        <input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
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