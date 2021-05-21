<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Produto base</th>
				<th>Editar</th>
				<th>Apagar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q2) {

				foreach ($q2 as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_Produto'] . '</td>';
						echo '<td>'. $cont . ') ' . $row['Produtos'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarProduto" 
										data-whateveridproduto="' . $row['idTab_Produto'] . '" data-whateverproduto="' . $row['Produtos'] . '" 
										data-whatevervendasite="' . $row['VendaSite'] . '" data-whatevervendabalcao="' . $row['VendaBalcao'] . '">
										Editar
									</button>
								</td>';
						if($row['ProdutoUsada'] == "N"){		
							echo '<td><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#excluirProduto" 
											data-whateveridproduto="' . $row['idTab_Produto'] . '" data-whateverproduto="' . $row['Produtos'] . '" 
											data-whatevervendasite="' . $row['VendaSite'] . '" data-whatevervendabalcao="' . $row['VendaBalcao'] . '">
											Apagar
										</button>
									</td>';
						}else{			
							echo '<td><button type="button" class="btn btn-xs btn-success">
											Usado
										</button>
									</td>';
						}		
						echo '<td></td>';
					echo '</tr>';            
					
					$cont++;
					$i++;
				}
				
			}
			?>

		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">Total encontrado: <?php echo $i; ?> resultado(s)</th>
			</tr>
		</tfoot>
	</table>
</div>


