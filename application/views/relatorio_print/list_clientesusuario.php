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
                        <th class="active">Cliente</th>
                        <th class="active">Sexo</th>
						
                        <!--<th class="active">Telefone</th>
						<th class="active">Telefone2</th>
						<th class="active">Telefone3</th>-->
						<th class="active">Nascimento</th>
                        <!--<th class="active">Endere�o</th>
                        <th class="active">Bairro</th>
                        <th class="active">Munic�pio</th>-->
                        <th class="active">E-mail</th>
						<th class="active">Ativo?</th>
						<!--<th class="active">Contato</th>
						<th class="active">Sexo</th>
						<th class="active">Rel. Com.</th>
						<th class="active">Rel. Pes.</th>-->

                    </tr>
                </thead>

				<tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'clienteusuario/prontuario/' . $row['idSis_Usuario'] . '">';
                            echo '<td>' . $row['idSis_Usuario'] . '</td>';

                            echo '<td>' . $row['Nome'] . '</td>';
                            echo '<td>' . $row['Sexo'] . '</td>';
							
                            #echo '<td>' . $row['Telefone1'] . '</td>';
							#echo '<td>' . $row['Telefone2'] . '</td>';
							#echo '<td>' . $row['Telefone3'] . '</td>';
							echo '<td>' . $row['DataNascimento'] . '</td>';							
                            #echo '<td>' . $row['Endereco'] . '</td>';
                            #echo '<td>' . $row['Bairro'] . '</td>';
                            #echo '<td>' . $row['Municipio'] . '</td>';
                            echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['Inativo'] . '</td>';
							#echo '<td>' . $row['NomeContatoCliente'] . '</td>';
							#echo '<td>' . $row['Sexo'] . '</td>';
							#echo '<td>' . $row['RelaCom'] . '</td>';
							#echo '<td>' . $row['RelaPes'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
