<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> 
			</button>
			<div class="btn-menu-print btn-group">
				<a type="button" class="col-md-6 btn btn-md btn-info " href="javascript:window.print()">
					<?php echo $report->num_rows(); ?> / <?php echo $_SESSION['FiltroReceitas']['total_rows']; ?>
				</a>
				<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
					<span class="glyphicon glyphicon-print"></span>
				</a>
				<a type="button" class="col-md-3 btn btn-md btn-warning "  href="<?php echo base_url() ?>relatorio_pag/receitas_pag">
					<span class="glyphicon glyphicon-edit"></span>
				</a>
			</div>
		</div>
		<div class="btn-paginacao collapse navbar-collapse" id="myNavbar">
			<?php echo $pagination; ?>	
		</div>
	</div>
</nav>
<div class="container-fluid">
	<div class="row">
		<div style="overflow: auto; height: auto; ">
			<table class="table table-bordered table-condensed table-striped">
				<thead>						
					<tr>
						<th class="col-md-1" scope="col">Cont</th>
						<th class="col-md-1" scope="col">Pedido</th>
						<th class="col-md-1" scope="col">DtPedido</th>
						<th class="col-md-2" scope="col">Cliente</th>
						<th class="col-md-2" scope="col">Tel</th>
						<th class="col-md-2" scope="col">Cadastro</th>
						<th class="col-md-1" scope="col">Lc/Fr.Pag.</th>
						<th class="col-md-2" scope="col">Recebedor</th>
						<th class="col-md-2" scope="col">Relacao</th>
						<th class="col-md-2" scope="col">Tel_Rec</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					foreach ($report->result_array() as $row) {
					?>
						<tr>
							<td><?php echo ($linha + $count);?></td>
							<td class="col-md-1" scope="col"><?php echo $row['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['DataOrca'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row['Nome'.$nome] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row['Celular'.$nome] ?>
								- <?php echo $row['Telefone'] ?>
								- <?php echo $row['Telefone2'] ?>
								- <?php echo $row['Telefone3'] ?>
							</td>
							<td class="col-md-2" scope="col"><?php echo $row['DataCadastro'.$nome] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['AVAP'] ?>/<?php echo $row['FormaPag'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row['NomeRec'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row['ParentescoRec'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row['TelefoneRec'] ?></td>
						</tr>
					<?php	
						$count++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>