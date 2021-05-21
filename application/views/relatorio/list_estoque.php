<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">
		<div>
			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<!--<th class="active text-left">Código</th>-->
						<th class="active text-left">Produto</th>
						<th class="active text-center">QTD COMPRA</th>
						<th class="active text-center">QTD VENDA</th>						
						<th class="active text-center">QTD ESTOQUE</th>
					</tr>
				</thead>

				<tbody>

					<?php

					foreach ($report as $row) {
					#for($i=0;$i<count($report);$i++) {

						if(isset($row->Produtos)) {
						echo '<tr>';
							#echo '<td>' . $row->CodProd . '</td>';

							echo '<td>' . $row->Produtos . '</td>';
							echo '<td>' . $row->QtdCompra . '</td>';
							echo '<td>' . $row->QtdVenda . '</td>';								
							echo '<td>' . $row->QtdEstoque . '</td>';
						echo '</tr>';
						}
					}
					?>

				</tbody>
				<tfoot>
					<tr>
						<!--<th colspan="1" class="active"></th>-->
						<th colspan="1" class="active text-right">Total de Produtos:</th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdcompra ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdvenda ?></th>							
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdestoque ?></th>
					</tr>
				</tfoot>

			</table>

		</div>
	</div>
</div>