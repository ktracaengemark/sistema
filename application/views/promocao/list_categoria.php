<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Categoria</th>
				<th>Editar</th>
				<th>Apagar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q1) {

				foreach ($q1 as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprom'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_Catprom'] . '</td>';
						echo '<td>'. $cont . ') ' . $row['Catprom'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarCatprom" 
										data-whateveridcatprom="' . $row['idTab_Catprom'] . '" data-whatevercatprom="' . $row['Catprom'] . '"
										data-whateversitecatprom="' . $row['Site_Catprom'] . '" data-whateverbalcaocatprom="' . $row['Balcao_Catprom'] . '">
										Editar
									</button>
								</td>';
						if($row['CategoriaUsada'] == "N"){		
							echo '<td><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#excluirCatprom" 
											data-whateveridcatprom="' . $row['idTab_Catprom'] . '" data-whatevercatprom="' . $row['Catprom'] . '"
											data-whateversitecatprom="' . $row['Site_Catprom'] . '" data-whateverbalcaocatprom="' . $row['Balcao_Catprom'] . '">
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


