<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Categoria</th>
				<th>Editar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q_categoria) {

				foreach ($q_categoria as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_Categoria'] . '</td>';
						echo '<td>' . $cont . ') ' . $row['Categoria'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarCategoria" 
										data-whateveridcategoria="' . $row['idTab_Categoria'] . '" data-whatevercategoria="' . $row['Categoria'] . '">
										Editar
									</button>
								</td>';
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


