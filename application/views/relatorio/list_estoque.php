<div class="container-fluid">
    <div class="row">

        <div>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
						<th class="active text-center">PRODUTO</th>

                        <th class="active text-center">QTD COMPRA</th>
                        <th class="active text-center">QTD ENTREGUE</th>
						<th class="active text-center">QTD DEVOLVE</th>
                        <th class="active text-center">QTD CONSUMO</th>
						<th class="active text-center">QTD VENDIDA</th>
                        <th class="active text-center">QTD ESTOQUE</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report as $row) {

                        echo '<tr>';
							echo '<td>' . $row->Produtos . '</td>';

							echo '<td>' . $row->QtdCompra . '</td>';
							echo '<td>' . $row->QtdVenda . '</td>';
							echo '<td>' . $row->QtdDevolve . '</td>';
                            echo '<td>' . $row->QtdConsumo . '</td>';
							echo '<td>' . $row->QtdVendida . '</td>';
							echo '<td>' . $row->QtdEstoque . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
