<?php if ($msg) echo $msg; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php if ( !isset($evento) && isset($_SESSION['Fornecedor'])) { ?>
				<nav class="navbar navbar-inverse navbar-fixed" role="banner">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<div class="navbar-form btn-group">
								<button type="button" class="btn btn-md btn-warning  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span>
										<?php echo '<small>' . $_SESSION['Fornecedor']['NomeFornecedor'] . '</small> - <small>' . $_SESSION['Fornecedor']['idApp_Fornecedor'] . '</small>' ?> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a <?php if (preg_match("/fornecedor\/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
												<span class="glyphicon glyphicon-file"></span> Ver Dados do Fornecedor
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/fornecedor\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/cadastrar1/    ?>>
											<a href="<?php echo base_url() . 'fornecedor/alterar/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
												<span class="glyphicon glyphicon-edit"></span> Editar Dados do Fornecedor
											</a>
										</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/consulta/   ?>>
											<a href="<?php echo base_url() . 'fornecedor/prontuario/' . $_SESSION['Fornecedor']['idApp_Fornecedor']; ?>">
												<span class="glyphicon glyphicon-user"></span> Contatos do Fornecedor
											</a>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
			<?php } ?>		



			<div class="row">
			
				<div class="col-md-12 col-lg-12">

					<div class="panel panel-<?php echo $panel; ?>">

						<div class="panel-heading"><strong>Fornecedor</strong></div>
						<div class="panel-body">				
							<table class="table table-user-information">
								<tbody>
									
									<?php 
									
													
									if ($query['NomeFornecedor']) {
										
									echo ' 
									<tr>
										<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Fornecedor:</td>
										<td>' . $query['NomeFornecedor'] . '</td>
									</tr>  
									';
									
									}
													
									if ($query['Cnpj']) {
										
									echo ' 
									<tr>
										<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Cnpj N°:</td>
										<td>' . $query['Cnpj'] . '</td>
									</tr>  
									';
									
									}
									
									if ($query['DataNascimento']) {
										
									echo '                         
									<tr>
										<td><span class="glyphicon glyphicon-gift"></span> Data de Nascimento:</td>
											<td>' . $query['DataNascimento'] . '</td>
									</tr>
									<tr>
										<td><span class="glyphicon glyphicon-gift"></span> Idade:</td>
											<td>' . $query['Idade'] . ' anos</td>
									</tr>                        
									';
									
									}
									
									if ($query['Telefone']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
										<td>' . $query['Telefone'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Sexo']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
										<td>' . $query['Sexo'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['TipoFornec']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-heart"></span> TipoFornec:</td>
										<td>' . $query['TipoFornec'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Atividade']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-heart"></span> Atividade:</td>
										<td>' . $query['Atividade'] . '</td>
									</tr>
									';
									
									}
								   
									if ($query['CepFornecedor']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-home"></span> Cep:</td>
										<td>' . $query['CepFornecedor'] . '</td>
									</tr>
									';
									
									}
								   
									if ($query['EnderecoFornecedor'] || $query['BairroFornecedor'] || $query['MunicipioFornecedor']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-home"></span> Endereço:</td>
										<td>' . $query['EnderecoFornecedor'] . ' , ' . $query['NumeroFornecedor'] . ' - ' . $query['ComplementoFornecedor'] . '<br>
											' . $query['BairroFornecedor'] . ' - ' . $query['CidadeFornecedor'] . ' - ' . $query['EstadoFornecedor'] . '</td>
									</tr>
									';
									
									}
								   
									if ($query['ReferenciaFornecedor']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-home"></span> Referencia:</td>
										<td>' . $query['ReferenciaFornecedor'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Email']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
										<td>' . $query['Email'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Obs']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-file"></span> Obs:</td>
										<td>' . nl2br($query['Obs']) . '</td>
									</tr>
									';
									
									}
									
									if ($query['VendaFornec']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-alert"></span> Fornec. P/Venda:</td>
										<td>' . $query['VendaFornec'] . '</td>
									</tr>
									';
									
									}
									
									if ($query['Ativo']) {
										
									echo '                                                 
									<tr>
										<td><span class="glyphicon glyphicon-alert"></span> Ativo:</td>
										<td>' . $query['Ativo'] . '</td>
									</tr>
									';
									
									}												
									?>
									
								</tbody>
							</table>

							<div class="row">
			
								<div class="col-md-12 col-lg-12">

									<div class="panel panel-primary">

										<div class="panel-heading"><strong>Contato</strong></div>
										<div class="panel-body">
									
											<?php
											if (!$list) {
											?>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatofornec/cadastrar" role="button"> 
													<span class="glyphicon glyphicon-plus"></span> Novo Contato
												</a>
												<br><br>
												<div class="alert alert-info" role="alert"><b>Nenhum contato cadastrado</b></div>
											<?php
											} else {
												echo $list;
											}
											?>       
											
										</div>
									</div>
								</div>
							</div>
						</div>			
					</div>		
				</div>
			</div>									
				

		</div>
		<div class="col-md-2"></div>
	</div>	
</div>
