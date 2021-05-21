<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Tipo</th>
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

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Catprod'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_Catprod'] . '</td>';
						echo '<td>' . $row['Prod_Serv'] . '</td>';
						echo '<td>'. $cont . ') ' . $row['Catprod'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarCatprod" 
										data-whateveridcatprod="' . $row['idTab_Catprod'] . '" data-whatevercatprod="' . $row['Catprod'] . '" 
										data-whateversitecatprod="' . $row['Site_Catprod'] . '" data-whateverbalcaocatprod="' . $row['Balcao_Catprod'] . '">
										Editar
									</button>
								</td>';
						if($row['CategoriaUsada'] == "N"){		
							echo '<td><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#excluirCatprod" 
											data-whateveridcatprod="' . $row['idTab_Catprod'] . '" data-whatevercatprod="' . $row['Catprod'] . '" 
											data-whateversitecatprod="' . $row['Site_Catprod'] . '" data-whateverbalcaocatprod="' . $row['Balcao_Catprod'] . '">
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


