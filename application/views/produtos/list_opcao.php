<div style="overflow: auto; height: auto; ">	
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>id</th>
				<th>Atributo</th>
				<th>Opcao</th>
				<th>Editar</th>
				<th>Apagar</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			$cont=1;
			if ($q4) {

				foreach ($q4 as $row)
				{

					#$url = base_url() . 'produtos/alterar2/' . $row['idTab_Opcao'];
					//$url = '';
					//echo '<tr class="clickable-row" data-href="' . $url . '">';
					echo '<tr>';
						echo '<td>' . $row['idTab_Opcao'] . '</td>';
						echo '<td>' . $cont . ') ' . $row['Atributo'] . '</td>';
						echo '<td>' . $row['Opcao'] . '</td>';
						echo '<td><button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#alterarOpcao" 
										data-whateveridopcao="' . $row['idTab_Opcao'] . '" data-whateveropcao="' . $row['Opcao'] . '">
										Editar
									</button>
								</td>';
						if($row['OpcaoUsada'] == "N"){
							echo '<td><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#excluirOpcao" 
											data-whateveridopcao="' . $row['idTab_Opcao'] . '" data-whateveropcao="' . $row['Opcao'] . '">
											Apagar
										</button>
									</td>';
						}else{	
							echo '<td><button type="button" class="btn btn-xs btn-success">
											Usado
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


