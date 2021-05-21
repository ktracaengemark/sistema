<div style="overflow: auto; height: 95px; ">		
	<div class="panel panel-danger">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<label for="DataFim">Despesa diária 
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Diavenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Mesvenc'] . '</small>' ?> /
					<?php echo '<small>' . $_SESSION['FiltroBalanco']['Ano'] . '</small>' ?>
					</label>
					<div class="input-group">
						<span class="input-group-addon">R$</span>
						<input type="text" class="form-control" disabled aria-label="Total Pago" value="<?php echo $report->soma->somarecebido ?>">
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
	</div>
</div>