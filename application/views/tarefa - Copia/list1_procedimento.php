<div style="overflow: auto; height: 455px; ">
	<div class="container-fluid">
		<div class="row">

			
				<table class="table table-bordered table-condensed table-striped">	
					<tfoot>
						<tr>
							<th colspan="9" class="active">Tarefas: <?php echo $report->num_rows(); ?> resultado(s)</th>
						</tr>
					</tfoot>
				</table>	
				<table class="table table-bordered table-condensed table-striped">								
					<thead>
						<tr>
							<!--<th class="active">Filt.</th>-->
							<th class="active">Baixa</th>
							<th class="active">Edit</th>
							<!--<th class="active">Excl</th>-->
							<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
								<th class="active">Fazer</th>
							<?php } ?>
							<th class="active">Tarefa</th>
							<th class="active">Categoria</th>
							<!--<th class="active">Prior.</th>
							<th class="active">SubTarefa</th>
							<th class="active">SubPri.</th>
							<th class="active">SubSts</th>
							<th class="active">Cnl.SbTF</th>
							<th class="active">Status</th>-->
							<th class="active">Iniciar</th>
							<th class="active">Concluir</th>
							<th class="active">Concl?</th>
							<?php if($_SESSION['log']['idSis_Empresa'] != 5) {?>
								<th class="active">Cadastrou</th>
							<?php } ?>
						</tr>
					</thead>

					<tbody>

						<?php
						$count = 1;
						foreach ($report->result_array() as $row) {

							#echo '<tr>';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimento/alterar/' . $row['idApp_Procedimento'] . '">';
							#echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterarprocedimento/' . $row['idSis_Empresa'] . '">';

								/*
									echo '<td class="notclickable">
										<a class="btn btn-md btn-info notclickable" href="' . base_url() . 'orcatrata/alterarprocedimento/' . $row['idSis_Empresa'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
								*/
								if($row['idSis_Usuario'] == $_SESSION['log']['idSis_Usuario']){
									echo '<td class="notclickable">
											<a class="btn btn-md btn-success notclickable" href="' . base_url() . 'tarefa/baixadatarefa/' . $row['idApp_Procedimento'] . '">
												<span class="glyphicon glyphicon-ok notclickable"></span>
											</a>
										</td>';
								}else{
									echo '<td class="notclickable">
											<a class="btn btn-md btn-danger notclickable" >
												<span class="glyphicon glyphicon-ok notclickable"></span>
											</a>
										</td>';
								}
									
									
								echo '<td class="notclickable">
										<a class="btn btn-md btn-primary notclickable" href="' . base_url() . 'tarefa/alterar/' . $row['idApp_Procedimento'] . '">
											<span class="glyphicon glyphicon-edit notclickable"></span>
										</a>
									</td>';
									
								#echo '<td>' . $row['NomeEmpresa'] . '</td>';
								/*
								echo '<td class="notclickable">
										<a class="btn btn-md btn-danger notclickable" href="' . base_url() . 'tarefa/excluir/' . $row['idApp_Procedimento'] . '">
											<span class="glyphicon glyphicon-trash notclickable"></span>
										</a>
									</td>';
								*/
								if($_SESSION['log']['idSis_Empresa'] != 5){
									echo '<td>' . $row['Comp'] . '</td>';
								}
								echo '<td>' . $count . ') ' . $row['Procedimento'] . '</td>';
								echo '<td>' . $row['Categoria'] . '</td>';
								#echo '<td>' . $row['Prioridade'] . '</td>';
								#echo '<td>' . $row['SubProcedimento'] . '</td>';
								#echo '<td>' . $row['SubPrioridade'] . '</td>';
								#echo '<td>' . $row['Statussubtarefa'] . '</td>';
								#echo '<td>' . $row['ConcluidoSubProcedimento'] . '</td>';
								#echo '<td>' . $row['Statustarefa'] . '</td>';
								echo '<td>' . $row['DataProcedimento'] . '</td>';
								echo '<td>' . $row['DataProcedimentoLimite'] . '</td>';
								echo '<td>' . $row['ConcluidoProcedimento'] . '</td>';
								if($_SESSION['log']['idSis_Empresa'] != 5){
									echo '<td>' . $row['NomeUsuario'] . '</td>';
								}
							echo '</tr>';
							$count++;
						}
						?>

					</tbody>

				</table>

			

		</div>

	</div>
</div>