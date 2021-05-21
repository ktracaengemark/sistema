<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] ) && isset($_SESSION['Produtos'] )) { ?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
	<div class="panel-body">
		<div class="col-md-12">
			<h2 class="ser-title">Icone!</h2>
			<hr class="botm-line">
		</div>			
		<div class="panel-body">
			<?php if (isset($list4)) echo $list4; ?>
		</div>		
		<div class="col-md-12">
			<h2 class="ser-title">Logo Navegador!</h2>
			<hr class="botm-line">
		</div>			
		<div class="panel-body">
			<?php if (isset($list3)) echo $list3; ?>
		</div>		
		<div class="col-md-12">
			<h2 class="ser-title">Slides!</h2>
			<hr class="botm-line">
		</div>			
		<div class="panel-body">
			<?php if (isset($list2)) echo $list2; ?>
		</div>
		<div class="col-md-12">
			<h2 class="ser-title">Produtos!</h2>
			<hr class="botm-line">
		</div>			
		<div class="panel-body">
			<?php if (isset($list1)) echo $list1; ?>
		</div>
	</div>
</div>

<?php } ?>
