<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Raca</th>
				<th>Editar</th>
				<th>Apagar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q3) {

				foreach ($q3 as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_RacaPet'] . '</td>';
						echo '<td>'. $cont . ') ' . $row['RacaPet'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarRacaPet" 
										data-whateveridracapet="' . $row['idTab_RacaPet'] . '" data-whateverracapet="' . $row['RacaPet'] . '">
										Editar
									</button>
								</td>';
						if($row['VariacaoUsada'] == "N"){		
							echo '<td><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#excluirRacaPet" 
											data-whateveridracapet="' . $row['idTab_RacaPet'] . '" data-whateverracapet="' . $row['RacaPet'] . '">
											Apagar
										</button>
									</td>';
						}else{				
							echo '<td><button type="button" class="btn btn-xs btn-success">
											Usada
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


