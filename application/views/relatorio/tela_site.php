<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] ) && isset($_SESSION['Produtos'] )) { ?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
	<div class="panel-body">
		<h1 class="text-center">Site</h1>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Titulo!</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_title/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Title'])) echo $query['Title']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Frase!</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_description/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Description'])) echo $query['Description']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Icone! (300 x 300)px</h2>
			<?php if (isset($list4)) echo $list4; ?>
		</div>			

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Navegador! (1240 x 528)px</h2>
			<?php if (isset($list3)) echo $list3; ?>
		</div>			
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Slides! (1902 x 448)px</h2>
			<?php if (isset($list2)) echo $list2; ?>
		</div>
		<div class="col-md-12">
			<h2 class="ser-title">A Empresa!</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_a_empresa/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['AEmpresa'])) echo $query['AEmpresa']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Topico1</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_a_empresa/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Top1'])) echo $query['Top1']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Texto Topico1</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_a_empresa/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Texto_Top1'])) echo $query['Texto_Top1']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Topico2</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_a_empresa/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Top2'])) echo $query['Top2']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h2 class="ser-title">Texto Topico2</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_a_empresa/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Texto_Top2'])) echo $query['Texto_Top2']; ?>"</h3>
			</a>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">Video</h2>
			<a href="<?php echo base_url() . 'documentos/alterar_a_empresa/' . $query['idSis_Empresa'] . ''; ?>">
				<h3>"<?php if (isset($query['Video_Empresa'])) echo $query['Video_Empresa']; ?>"</h3>
			</a>
			
		</div>
		<?php if (isset($query['Video_Empresa']) && $query['Video_Empresa'] != "") { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<figure >
					<div class="boxVideo">
						<iframe class="img-responsive thumbnail" src="https://www.youtube.com/embed/<?php echo $query['Video_Empresa']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</figure>
			</div>
		<?php } ?>	
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Atuacao! (300 x 300)px</h2>
		<?php if (isset($list7)) echo $list7; ?>
		</div>	
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Equipe! (300 x 300)px</h2>
		<?php if (isset($list5)) echo $list5; ?>
		</div>	
		<hr class="botm-line">
		<div class="col-md-12">
			<h2 class="ser-title">Depoimentos! (300 x 300)px</h2>
		<?php if (isset($list6)) echo $list6; ?>
		</div>	
	</div>
</div>

<?php } ?>
