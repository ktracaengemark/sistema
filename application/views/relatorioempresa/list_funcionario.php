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
                        <th class="active">Profissional</th>
						<th class="active">Funcao</th>
						<th class="active">Acesso Agenda</th>
						<th class="active">Permissao</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'funcionario/prontuario/' . $row['idSis_Usuario'] . '">';
                            echo '<td>' . $row['idSis_Usuario'] . '</td>';
                            echo '<td>' . $row['Nome'] . '</td>';
							echo '<td>' . $row['Funcao'] . '</td>';
							echo '<td>' . $row['Nivel'] . '</td>';
							echo '<td>' . $row['Permissao'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
