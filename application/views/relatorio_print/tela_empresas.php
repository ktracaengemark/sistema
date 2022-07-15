<?php if ($msg) echo $msg; ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<?php echo validation_errors(); ?>
	<div class="panel panel-primary">
		
		<div class="panel-heading">
			<?php echo form_open(base_url() . 'empresacli/pesquisar', 'class=""'); ?>
			<div class="row">	
				
				<!--
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-info" type="submit">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
					<input type="text" placeholder="Ex.: barbeiro" class="form-control" name="Pesquisa" value="">
				</div>
				-->

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<a type="button" class="btn  btn-warning btn-block" data-toggle="modal" data-target="#buscaModal">
						<img class="" type="button"  width='20' src="../arquivos/imagens/lupa.png" > Produtos & Empresas
					</a>
				</div>				
			</div>
			<!--
			<?php #echo form_open('relatorio/empresas', 'role="form"'); ?>
			<button  class="btn btn-sm btn-info" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
					<span class="glyphicon glyphicon-search"></span> <?php echo $titulo; ?>
			</button>	
			
			<a class="btn btn-sm btn-warning" href="<?php #echo base_url() ?>relatorio/associado" role="button">
				<span class="glyphicon glyphicon-search"></span> Associados
			</a>
			-->
			</form>
		</div>
		
		<div class="panel-body">
			<?php echo (isset($list)) ? $list : FALSE ?>
		</div>

	</div>	
</div>
<div id="buscaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<div class="row">
					<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<h3 class="modal-title" id="buscaModalLabel">Pesquisar na Plataforma</h3>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="SetBusca" class="custom-control-input "  id="SetProduto" value="PD" checked>
									<label class="custom-control-label" for="Produto">Produtos</label>
								</div>
							</div>
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="SetBusca" class="custom-control-input " id="SetPromocao" value="PM">
									<label class="custom-control-label" for="Promocao">Promoções</label>
								</div>
							</div>
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 mb-3 ">	
								<div class="custom-control custom-radio">
									<input type="radio" name="SetBusca" class="custom-control-input " id="SetEmpresa" value="EM" >
									<label class="custom-control-label" for="Empresa">Empresas</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpaBuscaProduto(), limpaBuscaPromocao(), limpaBuscaEmpresa()">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<input class="form-control input-produto" type="text" name="Produto" id="Produto" maxlength="255" placeholder="Busca Produto">
						<input class="form-control input-promocao" type="text" name="Promocao" id="Promocao" maxlength="255" placeholder="Busca Promoção">
						<input class="form-control input-empresa" type="text" name="Empresa" id="Empresa" maxlength="255" placeholder="Busca Empresa">
					</div>
				</div>	
			</div>
			<div class="modal-body">
				<div class="input_fields_produtos"></div>
				<div class="input_fields_promocao"></div>
					<div class="input_fields_empresa"></div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<button type="button" class="btn btn-primary" data-dismiss="modal" name="botaoFecharBusca" id="botaoFecharBusca" onclick="limpaBuscaProduto(), limpaBuscaPromocao(), limpaBuscaEmpresa()">
							<span class="glyphicon glyphicon-remove"></span> Fechar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
