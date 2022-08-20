<div class="panel panel-default">
	<div class="panel-heading">
		<table class="table table-condensed table-striped">
			<tbody>
				<tr>
					<td class="col-md-4 text-center" scope="col"><img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" class="img-responsive" width='200'></td>
					<td class="col-md-8 text-center" scope="col">
						<h4>
							<?php echo '<strong>' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>' ?>
						</h4>
						<?php if ($_SESSION['log']['NivelEmpresa'] >= 4 ) { ?>	
							<h5>
								CNPJ:<?php echo '<strong>' . $_SESSION['Empresa']['Cnpj'] . '</strong>' ?>
							</h5>
							<h5>
								<?php echo '<small>' . $_SESSION['Empresa']['EnderecoEmpresa'] . '</small> <small>' . $_SESSION['Empresa']['NumeroEmpresa'] . '</small> <small>' . $_SESSION['Empresa']['ComplementoEmpresa'] . '</small><br>
													<small>' . $_SESSION['Empresa']['BairroEmpresa'] . '</small> - <small>' . $_SESSION['Empresa']['MunicipioEmpresa'] . '</small> - <small>' . $_SESSION['Empresa']['EstadoEmpresa'] . '</small>' ?>
							</h5>
							<h5>
								Data: 
								<?php echo '<small>' . $_SESSION['FiltroBalanco']['Diavenc'] . '</small>' ?> /
								<?php echo '<small>' . $_SESSION['FiltroBalanco']['Mesvenc'] . '</small>' ?> /
								<?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?>
							</h5>
						<?php } ?>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<label for="DataFim">Entradas</label>
							<div class="input-group">
								<span class="input-group-addon">R$</span>
								<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $balancodiario->somaentradas ?>">
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">	
				<div class="col-md-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<label for="DataFim">Saidas</label>
							<div class="input-group">
								<span class="input-group-addon">R$</span>
								<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $balancodiario->somasaidas ?>">
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">	
				<div class="col-md-12">
					<div class="panel panel-warning">
						<div class="panel-heading">
							<label for="DataFim">Balanco</label>
							<div class="input-group">
								<span class="input-group-addon">R$</span>
								<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $balancodiario->balanco ?>">
							</div>
						</div>
					</div>	
				</div>		
			</div>
		</div>
	</div>
</div>
	
	