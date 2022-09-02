<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresa'] ) && isset($_SESSION['Documentos'] ) && isset($_SESSION['Produtos'] )) { ?>
<div class="col-lg-2 col-md-2 col-sm-1"></div>
<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">Slides! (1902 x 448)px</h2>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="btn btn-info btn-block" href="<?php echo base_url() ?>relatorio/slides" role="button">
					<span class="glyphicon glyphicon-edit"></span> Editar Slides
				</a>
			</div>	
			<?php if (isset($list2)) echo $list2; ?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">O que Fazemos! (300 x 300)px</h2>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="btn btn-info btn-block" href="<?php echo base_url() ?>relatorio/atuacao" role="button">
					<span class="glyphicon glyphicon-edit"></span>Editar O que Fazemos
				</a>
			</div>
			<?php if (isset($list7)) echo $list7; ?>
		</div>
		<hr class="botm-line">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">Depoimentos! (300 x 300)px</h2>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="btn btn-info btn-block" href="<?php echo base_url() ?>relatorio/depoimento" role="button">
					<span class="glyphicon glyphicon-edit"></span>Editar Depoimentos
				</a>
			</div>
			<?php if (isset($list6)) echo $list6; ?>
		</div>	
		<hr class="botm-line">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">Equipe! (300 x 300)px</h2>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="btn btn-info btn-block" href="<?php echo base_url() ?>relatorio/colaborador" role="button">
					<span class="glyphicon glyphicon-edit"></span>Editar Equipe
				</a>
			</div>
			<?php if (isset($list5)) echo $list5; ?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">Rodape</h2>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h3 class="ser-title">Sobre Nos</h3>
					<a href="<?php echo base_url() . 'documentos/alterar_redessociais/' . $query['idSis_Empresa'] . ''; ?>">
						<h4>"<?php if (isset($query['SobreNos'])) echo $query['SobreNos']; ?>"</h4>
					</a>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h3 class="ser-title">Atendimento</h3>
					<a href="<?php echo base_url() . 'documentos/alterar_redessociais/' . $query['idSis_Empresa'] . ''; ?>">
						<h4>"<?php if (isset($query['Atendimento'])) echo $query['Atendimento']; ?>"</h4>
					</a>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="ser-title">Redes Sociais</h2>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h3 class="ser-title">Facebook</h3>
					<a href="<?php echo base_url() . 'documentos/alterar_redessociais/' . $query['idSis_Empresa'] . ''; ?>">
						<h4>"<?php if (isset($query['Facebook'])) echo $query['Facebook']; ?>"</h4>
					</a>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h3 class="ser-title">Instagram</h3>
					<a href="<?php echo base_url() . 'documentos/alterar_redessociais/' . $query['idSis_Empresa'] . ''; ?>">
						<h4>"<?php if (isset($query['Instagram'])) echo $query['Instagram']; ?>"</h4>
					</a>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h3 class="ser-title">Youtube</h3>
					<a href="<?php echo base_url() . 'documentos/alterar_redessociais/' . $query['idSis_Empresa'] . ''; ?>">
						<h4>"<?php if (isset($query['Youtube'])) echo $query['Youtube']; ?>"</h4>
					</a>
				</div>
			</div>
		</div>	
	</div>
</div>

<?php } ?>
