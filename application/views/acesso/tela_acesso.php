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
<link rel="stylesheet" type="text/css" href="css/popup.css">
<script type="text/javascript" src="js/popup.js"></script>
	
<?php 

	$dateNow   = new \DateTime(date('Y-m-d'));
	$dateStart = new \DateTime($_SESSION['log']['DataDeValidade']);
	//$dateStart = new \DateTime('2021-09-24');	

	$dateDiff = $dateNow->diff($dateStart);
	
	$resultInvert = $dateDiff->invert;
	$resultDias = $dateDiff->days;

	$intervalo = $resultDias;
	
	if($resultInvert == 0){
		if($resultDias == 0){
			$corBotao	= 'warning';
			$texto = 'Sua Fatura vence hoje';
			$exibirPost = 1;
			
		}elseif($resultDias == 1 || $resultDias == 2){
			$corBotao	= 'success';
			$texto = 'Sua Fatura vence em ';
			$exibirPost = 1;
		}else{
			$corBotao	= 'default';
			$texto = 'Sua Fatura vence no futuro, a ';
			$exibirPost = 0;
		}
	}else{
		$corBotao	= 'danger';
		$texto = 'Sua Fatura está atrasada a ';
		$exibirPost = 1;
	}
	/*
	echo'<br>';
	echo'<pre>';
	print_r($dateNow);
	echo'<br>';
	print_r($dateStart);
	echo'<br>';
	print_r('status = '.$resultInvert);
	echo'<br>';
	print_r($resultDias);
	echo'<br>';
	print_r($corBotao);
	echo'<br>';
	print_r($exibirPost);
	echo'<br>';
	echo'</pre>';
	echo base_url();
	//exit();	
	*/
?>
	<input type="hidden" id="id_empresa" value="<?php echo $_SESSION['Empresa']['idSis_Empresa'];?>">
	<input type="hidden" id="intervalo" value="<?php echo $intervalo;?>">
	<input type="hidden" id="corBotao" value="<?php echo $corBotao;?>">
	<input type="hidden" id="texto" value="<?php echo $texto;?>">
	<input type="hidden" id="exibirPost" value="<?php echo $exibirPost;?>">
	
	<!--<img src="arquivos/imagens/popup.jpg" width="200" height="200" alt="" border="0" style="margin-top: 10px;"/>\-->
	
	<script type="text/javascript">
		Shadowbox.init({
			skipSetup: true
		});
		window.onload = function() {
			var id_empresa 	= $('#id_empresa').val();
			var intervalo 	= $('#intervalo').val();
			var corBotao 		= $('#corBotao').val();
			var texto 		= $('#texto').val();
			var exibirPost 	= $('#exibirPost').val();
			if(intervalo == 0){
				var tempo = '';
			}else{
				var tempo = intervalo+' dia(s)';
			}
				
			//console.log(id_empresa);
			//console.log(intervalo);
			//console.log(exibirPost);
			//console.log(corBotao);
			//console.log(tempo);
			
			// Abre uma mensagem, quando essa janela é selecionada
			if(exibirPost == 1){
				Shadowbox.open({
					//content:    '<div align="center"><a onclick="Shadowbox.close()" target="_blank" href="../../enkontraki/login_cliente.php?id_empresa="><img src="arquivos/imagens/popup.jpg" width="250" height="220" alt="" border="0" style="margin-top: 30px;"/></a></div>',
					content:    '<div align="center">\
									<div class="form-group col-md-12 text-center" style="margin-top: 100px;">\
										<span class="glyphicon glyphicon-alert"></span> '+texto+' '+tempo+'.\
									</div>\
									<div class="form-group col-md-12 text-left">\
										<a type="button" class="btn btn-md btn-'+corBotao+' btn-block"  href="../../enkontraki/login_cliente.php?id_empresa='+id_empresa+'" target="_blank"  role="button" onclick="Shadowbox.close()">\
											Pagar Agora\
										</a>\
									</div>\
								</div>',
					player:     "html",
					//title:      "hjhjhjh",
					height:     350,
					width:      350
				});
			}
		};
	</script>
	
<?php } ?>