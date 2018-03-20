<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
                        <th class="active">id</th>
                        <th class="active">Nome da Unidade</th>
						<th class="active">Telefone</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'empresafilial/prontuario/' . $row['idSis_EmpresaFilial'] . '">';
                            echo '<td>' . $row['idSis_EmpresaFilial'] . '</td>';
                            echo '<td>' . $row['Nome'] . '</td>';
							echo '<td>' . $row['Celular'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
