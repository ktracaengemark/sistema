<nav class="navbar navbar-inverse navbar-fixed" role="banner">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> 
			</button>
			<div class="btn-menu-print btn-group">
				<a type="button" class="col-md-6 btn btn-md btn-info " href="">
					<?php echo $report->num_rows(); ?> / <?php echo $total_rows; ?>
				</a>
				<a type="button" class="col-md-3 btn btn-md btn-default " href="javascript:window.print()">
					<span class="glyphicon glyphicon-print"></span>
				</a>
				<a type="button" class="col-md-3 btn btn-md btn-warning "  href="<?php echo base_url() ?>Comissao/comissao_pag">
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
						<td class="col-md-1" scope="col"><img  alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>"class="img-circle img-responsive" width='100'></td>
						<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>'?></td>
						<td class="col-md-3 text-left" scope="col"><?php echo '<strong>' . $titulo . '</strong>'?><br>Total: R$ <?php echo $report->soma->somacomissao ?> / <?php echo $pesquisa_query->soma2->somacomissao2 ?></td>
					</tr>
				</thead>			
			</table>
			<table class="table table-bordered table-condensed table-striped">
				<thead>						
					<tr>
						<th class="col-md-1" scope="col">Cont</th>
						<th class="col-md-1" scope="col">Pedido</th>
						<th class="col-md-1" scope="col">Local</th>
						<th class="col-md-2" scope="col">Nome</th>
						<th class="col-md-1" scope="col">Valor</th>
						<th class="col-md-2" scope="col">Colab.</th>
						<th class="col-md-1" scope="col">Comissao</th>
						<th class="col-md-1" scope="col">Pago</th>
						<th class="col-md-1" scope="col">Data</th>
						<th class="col-md-1" scope="col">Recibo</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					$linha =  $per_page*$pagina;
					foreach ($report->result_array() as $row) {
					?>
						<tr>
							<td><?php echo ($linha + $count);?></td>
							<td class="col-md-1" scope="col"><?php echo $row['idApp_OrcaTrata'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['Tipo_Orca'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row[$nome] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['ValorRestanteOrca'] ?></td>
							<td class="col-md-2" scope="col"><?php echo $row['NomeColaborador'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['ValorComissao'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row[$status] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['DataPagoComissaoOrca'] ?></td>
							<td class="col-md-1" scope="col"><?php echo $row['id_Comissao'] ?></td>
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