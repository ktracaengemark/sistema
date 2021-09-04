<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] ) && isset($_SESSION['Produtos'] )) { ?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
	<div class="panel-body">
		<div class="col-md-12">
			<h2 class="ser-title">Titulo!</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_title/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Title'])) echo $query['Title']; ?>"</h3>
			</a>
		</div>
		<div class="col-md-12">
			<h2 class="ser-title">Frase!</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_description/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Description'])) echo $query['Description']; ?>"</h3>
			</a>
		</div>
		<div class="col-md-12">
			<h2 class="ser-title">Icone! (300 x 300)px</h2>
			<?php if (isset($list4)) echo $list4; ?>
		</div>			
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Logo Navegador! (150 x 66)px</h2>
			<?php if (isset($list3)) echo $list3; ?>
		</div>			
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Slides! (1902 x 448)px</h2>
			<?php if (isset($list2)) echo $list2; ?>
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
