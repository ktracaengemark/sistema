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
                        <!--<th class="active">Associador</th>
						<th class="active">Nº do Associado</th>-->
                        <th class="active">Associado</th>
                        <th class="active">Sexo</th>					
                        <th class="active">Telefone</th>
						<th class="active">Nascimento</th>
                        <th class="active">E-mail</th>
						<th class="active">Usuário</th>
						<th class="active">Ativo?</th>
						
                    </tr>
                </thead>

				<tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        #echo '<tr class="clickable-row" data-href="' . base_url() . 'associado/prontuario/' . $row['idSis_Usuario'] . '">';
                            #echo '<td>' . $row['Associado'] . '</td>';
							#echo '<td>' . $row['idSis_Usuario'] . '</td>';
                            echo '<td>' . $row['Nome'] . '</td>';
                            echo '<td>' . $row['Sexo'] . '</td>';							
                            echo '<td>' . $row['Celular'] . '</td>';
							echo '<td>' . $row['DataNascimento'] . '</td>';
                            echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['Usuario'] . '</td>';
							echo '<td>' . $row['StatusSN'] . '</td>';
							#echo '<td>' . $row['Inativo'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
