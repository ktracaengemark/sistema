<div style="overflow: auto; height: auto; ">	
	<table class="table table-hover">
		<thead>
			<tr>
				<!--<th class="active">EdtOrç</th>
				<th class="active">Imp.</th>-->							
				<th class="active">id.</th>
				<th class="active">Produto</th>
				<th class="active">Preço</th>								
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q) {

				foreach ($q as $row)
				{

					$url = base_url() . 'produtos/alterar/' . $row['idTab_Produto'];
					#$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idTab_Produto'] . '</td>';
						echo '<td>' . $row['Produtos'] . '</td>';
						echo '<td>' . number_format($row['ValorProduto'], 2,",",".") . '</td>';
					echo '</tr>';            

					$i++;
				}
				
			}
			?>

		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">Total encontrado: <?php echo $i; ?> resultado(s)</th>
			</tr>
		</tfoot>
	</table>
</div>


