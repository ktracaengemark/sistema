<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="3" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>                       											
						<th class="active">id Produto</th>						
						<th class="active">Produto</th>
						<th class="active">Valor de Venda</th>
																																							
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'produtos/alterar/' . $row['idApp_Produtos'] . '">';
 							echo '<td>' . $row['idApp_Produtos'] . '</td>';                          
							echo '<td>' . $row['Produtos'] . '</td>';
							echo '<td>' . $row['ValorVendaProduto'] . '</td>';			
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

