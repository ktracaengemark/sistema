<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Variacao</th>
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
						echo '<td>' . $row['idTab_Atributo'] . '</td>';
						echo '<td>'. $cont . ') ' . $row['Atributo'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarAtributo" 
										data-whateveridatributo="' . $row['idTab_Atributo'] . '" data-whateveratributo="' . $row['Atributo'] . '">
										Editar
									</button>
								</td>';
						if($row['VariacaoUsada'] == "N"){		
							echo '<td><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#excluirAtributo" 
											data-whateveridatributo="' . $row['idTab_Atributo'] . '" data-whateveratributo="' . $row['Atributo'] . '">
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


