<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] ) && isset($_SESSION['Produtos'] )) { ?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
	<div class="panel-body">
		<div class="col-md-12">
			<h2 class="ser-title">Icone!</h2>
			<?php if (isset($list4)) echo $list4; ?>
			<h3>Dimensoes de 300 x 300</h3>
		</div>			
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Logo Navegador!</h2>
			<?php if (isset($list3)) echo $list3; ?>
			<h3>Dimensoes de 150 x 66</h3>
		</div>			
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Slides!</h2>
			<?php if (isset($list2)) echo $list2; ?>
			<h3>Dimensoes de 1902 x 448</h3>
		</div>			
		<!--
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Produtos!</h2>
		<?php #if (isset($list1)) echo $list1; ?>
		</div>			
		-->
	</div>
</div>

<?php } ?>
