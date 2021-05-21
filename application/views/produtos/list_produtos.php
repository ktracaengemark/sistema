<div style="overflow: auto; height: auto; ">
	<h3>Produtos assosiados</h3>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Categoria</th>
				<th>Produto</th>
				<?php if ($_SESSION['Atributo'][1]['idTab_Atributo']) { ?>
					<th><?php echo $_SESSION['Atributo'][1]['Atributo']; ?></th>										
				<?php } ?>
				<?php if ($_SESSION['Atributo'][2]['idTab_Atributo']) { ?>
					<th><?php echo $_SESSION['Atributo'][2]['Atributo']; ?></th>										
				<?php } ?>
				<th>Codigo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			if ($q) {

				foreach ($q as $row)
				{

					$url = base_url() . 'produtos/tela/' . $row['idTab_Produtos'];
					#$url = '';

					echo '<tr class="clickable-row" data-href="' . $url . '">';
						echo '<td>' . $row['idTab_Produtos'] . '</td>';
						echo '<td>' . $row['Catprod'] . '</td>';
						echo '<td>' . $row['Nome_Prod'] . '</td>';
						if($_SESSION['Atributo'][1]['idTab_Atributo']){
							echo '<td>' . $row['Atributo1'] . '</td>';
						}
						if($_SESSION['Atributo'][2]['idTab_Atributo']){
							echo '<td>' . $row['Atributo2'] . '</td>';
						}
						echo '<td>' . $row['Cod_Prod'] . '</td>';
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
</div>


