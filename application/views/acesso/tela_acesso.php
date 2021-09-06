<?php if (isset($msg)) echo $msg; ?>
<?php if (( !isset($evento) && isset($_SESSION['log'])) || ( isset($_SESSION['Empresa'])) || ( isset($_SESSION['Usuario']))) { ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
			<h4><?php echo '<strong> ' . $_SESSION['Empresa']['NomeEmpresa'] . '</strong>.'  ?></h4>
			<img class="img-circle img-responsive" width='500' alt="User Pic" src="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Empresa']['Arquivo'] . ''; ?>" >
			<h4><?php echo '<small>Acesse o </small><strong> Menu </strong><small> acima <br>e tenha um bom trabalho! </small>'  ?></h4>
		</div>
	</div>
</div>
<input type="hidden" id="id_empresa" value="<?php echo $_SESSION['Empresa']['idSis_Empresa'];?>">
<link rel="stylesheet" type="text/css" href="css/popup.css">
<script type="text/javascript" src="js/popup.js"></script>
	
	<script type="text/javascript">
		Shadowbox.init({
			skipSetup: true
		});
		window.onload = function() {
			// Abre uma mensagem, quando essa janela é selecionada
			Shadowbox.open({
				
				//content:    '<div align="center"><a onclick="Shadowbox.close()" target="_blank" href="../../enkontraki/login_cliente.php?id_empresa="><img src="arquivos/imagens/popup.jpg" width="250" height="220" alt="" border="0" style="margin-top: 30px;"/></a></div>',
				content:    '<div align="center"><button onclick="Shadowbox.close(),logar_cliente()" ><img src="arquivos/imagens/popup.jpg" width="250" height="220" alt="" border="0" style="margin-top: 30px;"/></button></div>',
				player:     "html",
				title:      "",
				height:     350,
				width:      300
			});
			
		};
	</script>

<?php } ?>