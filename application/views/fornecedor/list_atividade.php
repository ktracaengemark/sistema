<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Atividade</th>
				<th>Editar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q_atividade) {

				foreach ($q_atividade as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idApp_Atividade'] . '</td>';
						echo '<td>' . $cont . ') ' . $row['Atividade'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarAtividade" 
										data-whateveridatividade="' . $row['idApp_Atividade'] . '" data-whateveratividade="' . $row['Atividade'] . '">
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


