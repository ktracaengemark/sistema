<div style="overflow: auto; height: auto; ">
	<h3>Promocoes</h3>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id_Valor</th>
				<th>id_Produto</th>
				<th>Tipo</th>
				<th>Valor</th>
				<th>id_Prom</th>
				<th>Promocao</th>
				<th>Descricao</th>
				<th>Dt.Inicio</th>
				<th>Dt.Fim</th>
				<th>Ativo</th>
				<th>V/R</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q_precos_promocoes) {

				foreach ($q_precos_promocoes as $row)
				{

					$url = base_url() . 'promocao/tela_promocao/' . $row['idTab_Promocao'];
					//$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idTab_Valor'] . '</td>';
						echo '<td>' . $row['idTab_Produtos'] . '</td>';
						echo '<td>' . $row['Desconto'] . '</td>';
						echo '<td>' . $row['ValorProduto'] . '</td>';
						echo '<td>' . $row['idTab_Promocao'] . '</td>';
						echo '<td>' . $row['Promocao'] . '</td>';
						echo '<td>' . $row['Descricao'] . '</td>';
						echo '<td>' . $row['DataInicioProm'] . '</td>';
						echo '<td>' . $row['DataFimProm'] . '</td>';
						echo '<td>' . $row['AtivoPromocao'] . '</td>';
						echo '<td>' . $row['TipoPromocao'] . '</td>';
						echo '<td></td>';
					echo '</tr>';            

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
	<hr>
</div>


