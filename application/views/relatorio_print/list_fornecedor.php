<div style="overflow: auto; height: 550px; ">	
	<div class="container-fluid">


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
							<th class="active">N. Forn.</th>
							<th class="active">Fornecedor</th>
							<!--<th class="active">Serv./Prod.</th>
							<th class="active">For.P/Venda</th>-->
							<th class="active">Atividade</th>
							<th class="active">Telefone</th>						                      
							<!--<th class="active">Endere�o</th>
							<th class="active">Bairro</th>
							<th class="active">Munic�pio</th>
							<th class="active">E-mail</th>-->
							<th class="active">Contatofornec</th>
							<!--<th class="active">Sexo</th>-->
							<th class="active">Rela��o</th>
							<th class="active">Data Cadastro</th>
						</tr>
					</thead>

					<tbody>

						<?php
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							echo '<tr class="clickable-row" data-href="' . base_url() . 'fornecedor/prontuario/' . $row['idApp_Fornecedor'] . '">';
								echo '<td>' . $row['idApp_Fornecedor'] . '</td>';
								echo '<td>' . $row['NomeFornecedor'] . '</td>';
								#echo '<td>' . $row['TipoFornec'] . '</td>';
								#echo '<td>' . $row['StatusSN'] . '</td>';
								echo '<td>' . $row['Atividade'] . '</td>';                           
								echo '<td>' . $row['Telefone'] . '</td>';							
								#echo '<td>' . $row['Endereco'] . '</td>';
								#echo '<td>' . $row['Bairro'] . '</td>';
								#echo '<td>' . $row['Municipio'] . '</td>';
							   # echo '<td>' . $row['Email'] . '</td>';
								echo '<td>' . $row['NomeContatofornec'] . '</td>';
								#echo '<td>' . $row['Sexo'] . '</td>';
								echo '<td>' . $row['Relacao'] . '</td>';
								echo '<td>' . $row['DataCadastroFornecedor'] . '</td>';
							echo '</tr>';
						}
						?>

					</tbody>

				</table>

			</div>



	</div>
</div>