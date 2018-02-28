<div class="container-fluid">
    <div class="row">

        <div>
            <table class="table table-bordered table-condensed table-striped">
				
                <thead>
                    <tr>

						<th class="active text-center">CLIENTE</th>
						<th class="active text-center">ORCAM.</th>
						<th class="active text-center">DESCON.</th>
						<th class="active text-center">DEVOL.</th>
						<th class="active text-center">VENDIDO</th>
						<th class="active text-center">PAGO</th>

                    </tr>
                </thead>
				<thead>
                    <tr>
						
						<th colspan="1" class="active">Total :</th>

						<th colspan="1" class="active"><?php echo $report->soma->somaqtdorcam ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddescon ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddevol ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdvendida ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdparc ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($report as $row) {
                    #for($i=0;$i<count($report);$i++) {

                        if(isset($row->NomeCliente)) {
                        echo '<tr>';

							echo '<td>' . $row->NomeCliente . '</td>';
							echo '<td>' . $row->QtdOrcam . '</td>';
							echo '<td>' . $row->QtdDescon . '</td>';
							echo '<td>' . $row->QtdDevol . '</td>';
							echo '<td>' . $row->QtdVendida . '</td>';
							echo '<td>' . $row->QtdParc . '</td>';

                        echo '</tr>';
                        }
                    }
                    ?>

                </tbody>
				<tfoot>
                    <tr>
						
						<th colspan="1" class="active">Total:</th>

						<th colspan="1" class="active"><?php echo $report->soma->somaqtdorcam ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddescon ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtddevol ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdvendida ?></th>
						<th colspan="1" class="active"><?php echo $report->soma->somaqtdparc ?></th>
                    </tr>
                </tfoot>

            </table>

        </div>

    </div>

</div>
