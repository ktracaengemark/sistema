<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['QueryEmpresa'])) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php #if ($nav_secundario) echo $nav_secundario; ?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<div class="panel panel-primary">
							<div class="panel-heading">
									<?php echo $titulo; ?>
							</div>
							<div class="panel-body">
								<div style="overflow: auto; height: auto; ">
									<div class="form-group">	
										<div class="row">
											<div class=" col-md-12" align="center">	
												<a href="<?php echo base_url() . 'empresa/alterarlogo/' . $_SESSION['QueryEmpresa']['idSis_Empresa']; ?>">	
													<img alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['QueryEmpresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['QueryEmpresa']['Arquivo'] . ''; ?>"
													class="img-circle img-responsive" width='200'>
												</a>		
											</div>
										</div>	
										<div class="row">	
											<div class=" col-md-12">							
												<table class="table table-user-information">
													<tbody>

														<?php
														
														if ($query['NomeAdmin']) {

														echo '
														<tr>
															<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Admin:</td>
															<td>' . $query['NomeAdmin'] . '</td>
														</tr>
														';

														}
														
														if ($query['CpfAdmin']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-phone-alt"></span> CPF:</td>
															<td>' . $query['CpfAdmin'] . '</td>
														</tr>
														';

														}

														if ($query['CelularAdmin']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
															<td>' . $query['CelularAdmin'] . '</td>
														</tr>
														';

														}
														
														if ($query['DataCriacao']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-gift"></span> Cadastro :</td>
																<td>' . $query['DataCriacao'] . '</td>
														</tr>
														<tr>
															<td><span class="glyphicon glyphicon-gift"></span> Tempo:</td>
																<td>' . $query['Idade'] . ' anos</td>
														</tr>
														';

														}

														/*
														if ($query['Sexo']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
															<td>' . $query['Sexo'] . '</td>
														</tr>
														';

														}
														*/
														
														if ($query['Email']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
															<td>' . $query['Email'] . '</td>
														</tr>
														';

														}
														
														if ($query['CategoriaEmpresa']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Categoria:</td>
															<td>' . $query['CategoriaEmpresa'] . '</td>
														</tr>
														';

														}
														
														if ($query['Atuacao']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Atuacao:</td>
															<td>' . $query['Atuacao'] . '</td>
														</tr>
														';

														}

														if($query['CadastrarPet'] == "S"){
															$cadastro = 'Pets';
														}elseif($query['CadastrarDep'] == "S"){
															$cadastro = 'Dependentes';
														}else{
															$cadastro = 'Nenhum';
														}
														
														if ($cadastro) {
														
														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Cadastro Aux.:</td>
															<td>' . $cadastro . '</td>
														</tr>
														';
														}
														
														if ($query['SobreNos']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Sobre Nos:</td>
															<td>' . $query['SobreNos'] . '</td>
														</tr>
														';

														}
														
														if ($query['Atendimento']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Atendimento:</td>
															<td>' . $query['Atendimento'] . '</td>
														</tr>
														';

														}

														if ($query['Site']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-envelope"></span> Site:</td>
															<td>enkontraki.com.br/' . $query['Site'] . '</td>
														</tr>
														';

														}
														
														if ($query['Arquivo']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-pencil"></span> Arquivo:</td>
															<td>' . $query['Arquivo'] . '</td>
														</tr>
														';

														}												
														
														if ($query['Inativo']) {

														echo '
														<tr>
															<td><span class="glyphicon glyphicon-alert"></span> Ativo?:</td>
															<td>' . $query['Inativo'] . '</td>
														</tr>
														';

														}

														?>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
<?php } ?>
