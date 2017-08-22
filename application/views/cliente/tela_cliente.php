<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="col-sm-7 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="form-group">
			<div class="row">		
				<div class="col-md-3 text-left">
					<label for="">Cliente & Contatos:</label>
					<div class="form-group">
						<div class="row">	
							<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
								<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
								</a>
							</a>				
							<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
								<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<span class="glyphicon glyphicon-edit"></span> Edit.
								</a>
							</a>
						</div>
					</div>	
				</div>

				<div class="col-md-3 text-center">
					<label for="">Consultas:</label>
					<div class="form-group">
						<div class="row">
							<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
								<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<span class="glyphicon glyphicon-list-alt"></span> List.
								</a>
							</a>
							<a <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
								<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<span class="glyphicon glyphicon-plus"></span> Cad.
								</a>
							</a>
						</div>	
					</div>	
				</div>

				<div class="col-md-3 text-right">
					<label for="">Orçamentos:</label>
					<div class="form-group">
						<div class="row">
							<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
								<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<span class="glyphicon glyphicon-list-alt"></span> List.
								</a>
							</a>
							<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
								<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
									<span class="glyphicon glyphicon-plus"></span> Cad.
								</a>
							</a>
						</div>		
					</div>	
				</div>
			</div>	
		</div>		
		<div class="form-group">		
			<div class="row">
				<div class="text-center t">
					<h3><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong><br><small>Identificador: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h3>
				</div>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
		
<div class="container-fluid col-sm-7 col-sm-offset-3 col-md-9 col-md-offset-2 main">
	<div class=" col-md-10 col-lg-10 "> 
		<table class="table table-user-information">
			<tbody>
				
				<?php 
				
				if ($query['Empresa']) {
					
				echo ' 
				<tr>
					<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Empresa:</td>
					<td>' . $query['Empresa'] . '</td>
				</tr>  
				';
				
				}
				
				if ($query['RegistroFicha']) {
					
				echo ' 
				<tr>
					<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Ficha N°:</td>
					<td>' . $query['RegistroFicha'] . '</td>
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
				
				if ($query['Endereco'] || $query['Bairro'] || $query['Municipio']) {
					
				echo '                                                 
				<tr>
					<td><span class="glyphicon glyphicon-home"></span> Endereço:</td>
					<td>' . $query['Endereco'] . ' ' . $query['Bairro'] . ' ' . $query['Municipio'] . '</td>
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
			
	</div>

	<div class="row">
		
		<hr>

		<div class=" col-md-12 col-lg-12">
			
			<br>
			
			<?php
			if (!$list) {
			?>
				<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatocliente/cadastrar" role="button"> 
					<span class="glyphicon glyphicon-plus"></span> Novo Contato
				</a>
				<br><br>
				<div class="alert alert-info" role="alert"><b>Nenhum Contato Cadastrado</b></div>
			<?php
			} else {
				echo $list;
			}
			?>       
			
		</div>
	</div>                                   
</div>
      

