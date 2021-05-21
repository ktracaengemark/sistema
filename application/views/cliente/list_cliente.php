<div style="overflow: auto; height: 550px; ">	
	
		<div class="text-left"><?php echo $pagination; ?></div>

			<table class="table table-bordered table-condensed table-striped">								
				<thead>
					<tr>
						<th colspan="6" class="text-left">Total encontrado: <?php echo $total_rows; ?></th>
					</tr>
					<tr>
						<th class=" col-md-1" scope="col">Foto</th>
						<th class="active">id</th>
						<th class="active">Cliente</th>
						<th class="active">Ficha</th>
						<th class="active">Sexo</th>
						<th class="active">Celular</th>
						<th class="active">Telefone1</th>
						<th class="active">Telefone2</th>
						<th class="active">Telefone3</th>
						<th class="active">Nascimento</th>
						<th class="active">Endereço</th>
						<th class="active">Bairro</th>
						<th class="active">Cidade</th>
						<!--<th class="active">E-mail</th>-->
						<th class="active">Ativo?</th>
						<th class="active">Cadastrado</th>
						<th class="active">Login</th>
						<!--<th class="active">Contato</th>
						<th class="active">Sexo</th>
						<th class="active">Rel. Com.</th>
						<th class="active">Rel. Pes.</th>-->

					</tr>
				</thead>

				<tbody>

					<?php
					foreach ($query->result_array() as $row) {
					?>
					<tr class="clickable-row" data-href="<?php echo base_url() . 'cliente/prontuario/' . $row['idApp_Cliente'] . ''; ?>">
						<td><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/clientes/miniatura/' . $row['Arquivo'] . ''; ?> "class="img-circle img-responsive" width='100'></td>
						<td><?php echo $row['idApp_Cliente'] ?></td>
						<td><?php echo $row['NomeCliente'] ?></td>
						<td><?php echo $row['RegistroFicha'] ?></td>
						<td><?php echo $row['Sexo'] ?></td>
						<td><?php echo $row['CelularCliente'] ?></td>
						<td><?php echo $row['Telefone'] ?></td>
						<td><?php echo $row['Telefone2'] ?></td>
						<td><?php echo $row['Telefone3'] ?></td>
						<td><?php echo $row['DataNascimento'] ?></td>
						<td><?php echo $row['EnderecoCliente'] ?></td>
						<td><?php echo $row['BairroCliente'] ?></td>
						<td><?php echo $row['CidadeCliente'] ?></td>
						<!--<td><?php #echo $row['Email'] ?></td>-->
						<td><?php echo $row['Ativo'] ?></td>
						<td><?php echo $row['DataCadastroCliente'] ?></td>
						<td><?php echo $row['usuario'] ?></td>
					</tr>						
					<?php
					}
					?>

				</tbody>
				<tfoot>
					<tr>
						<th colspan="6" class="text-left">Total encontrado: <?php echo $total_rows; ?></th>
					</tr>
				</tfoot>

			</table>

		<div class="text-left"><?php echo $pagination; ?></div>
	
</div>