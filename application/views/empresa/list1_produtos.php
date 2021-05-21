<div class="container">
	<div class="row">
		<?php
			if($prod){
				foreach ($prod as $row){
				?>		
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="card h-100">
						<!--<img class="img-responsive" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?>">-->
						<a href="<?php echo base_url() . 'produtos/alterarlogo/' . $row['idTab_Produto'] . ''; ?>"><img class="img-responsive" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $row['Arquivo'] . ''; ?>"></a>					 
						<!--<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>-->
						
						<div class="card-body">
							<h4 class="card-title">
								<!--<a href="produto.php?id=<?php echo $row['idTab_Produto'];?>"><?php echo utf8_encode ($row['Produtos']);?></a>-->
								<!--<a class="clickable-row" data-href="<?php echo base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . ''; ?>"><?php echo $row['Produtos'];?></a>-->
								<a href="<?php echo base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . ''; ?>"><?php echo $row['Produtos'];?></a>
							</h4>
							<h5>
								<a href="<?php echo base_url() . 'produtos/alterar/' . $row['idTab_Produto'] . ''; ?>">
									R$ <?php echo number_format($row['ValorProduto'],2,",",".");?>
								</a>	
							</h5>
							<!--<p><?php echo utf8_encode ($row['produto_breve_descricao']);?></p>-->
						</div>
					</div>
				</div>
				<?php 
				}
			}
		?>
	</div>
</div>