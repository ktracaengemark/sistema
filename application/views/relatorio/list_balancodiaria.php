
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<label for="DataFim">Entradas do dia: 
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Diavenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Mesvenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?>
					</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $balancodiario->somaentradas ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<label for="DataFim">Saidas do dia: 
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Diavenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Mesvenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?>
					</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $balancodiario->somasaidas ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<label for="DataFim">Balanco do dia: 
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Diavenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Mesvenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?>
					</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $balancodiario->balanco ?>">
					</div>
				</div>
			</div>	
		</div>		
	</div>