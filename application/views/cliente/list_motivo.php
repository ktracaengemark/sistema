<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Motivo</th>
				<th>Desc</th>
				<th>Editar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q_motivo) {

				foreach ($q_motivo as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_Motivo'] . '</td>';
						echo '<td>' . $cont . ') ' . $row['Motivo'] . '</td>';
						echo '<td>' . $row['Desc_Motivo'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarMotivo" 
										data-whateveridmotivo="' . $row['idTab_Motivo'] . '" data-whatevermotivo="' . $row['Motivo'] . '"
										data-whateverdescmotivo="' . $row['Desc_Motivo'] . '">
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


