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
                        <th class="active">#</th>
                        <th class="active">Profissional</th>						
                        <th class="active">Nascimento</th>
                        <th class="active">Telefone</th>
						<th class="active">Fun��o</th>
                        <!--<th class="active">Sexo</th>
                        <th class="active">Endere�o</th>
                        <th class="active">Bairro</th>
                        <th class="active">Munic�pio</th>
                        <th class="active">E-mail</th>-->
						<th class="active">Contato</th>
						<!--<th class="active">Sexo</th>-->
						<th class="active">Rela��o</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'profissional/prontuario/' . $row['idApp_Profissional'] . '">';
                            echo '<td>' . $row['idApp_Profissional'] . '</td>';

                            echo '<td>' . $row['NomeProfissional'] . '</td>';							
                            echo '<td>' . $row['DataNascimento'] . '</td>';
                            echo '<td>' . $row['Telefone'] . '</td>';
                            echo '<td>' . $row['Funcao'] . '</td>';
							#echo '<td>' . $row['Sexo'] . '</td>';
                            #echo '<td>' . $row['Endereco'] . '</td>';
                            #echo '<td>' . $row['Bairro'] . '</td>';
                            #echo '<td>' . $row['Municipio'] . '</td>';
                            #echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['NomeContatoProf'] . '</td>';
							#echo '<td>' . $row['Sexo'] . '</td>';
							echo '<td>' . $row['RelaPes'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
