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
						<th class="active">N� do Associado</th>-->
                        <th class="active">Empresa</th>
                        <th class="active">Administrador.</th>
						<th class="active">Telefone</th>
                        <th class="active">E-mail</th>
						<th class="active">Usu�rio</th>
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
                            echo '<td>' . $row['NomeEmpresa'] . '</td>';
							echo '<td>' . $row['Nome'] . '</td>';
                            echo '<td>' . $row['Celular'] . '</td>';
                            echo '<td>' . $row['Email'] . '</td>';
							echo '<td>' . $row['UsuarioEmpresaFilial'] . '</td>';
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
