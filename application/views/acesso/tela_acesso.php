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
	//depois tenho que voltar a linha correta
	//$dateStart = new \DateTime('2022-09-24');	

	$dateDiff = $dateNow->diff($dateStart);
	
	$resultInvert = $dateDiff->invert;
	$resultDias = $dateDiff->days;

	$intervalo = $resultDias;
	
	if($resultInvert == 0){
		if($resultDias == 0){
			$corBotao	= 'success';
			$texto = 'Sua Fatura vence hoje';
			$imagem = 'Alerta.png';
			$exibirPost = 1;
			
		}elseif($resultDias == 1 || $resultDias == 2){
			$corBotao	= 'success';
			$texto = 'Sua Fatura vence em ';
			$imagem = 'aprovado.png';
			$exibirPost = 1;
		}else{
			$corBotao	= 'default';
			$texto = 'Sua Fatura vence em ';
			$imagem = 'aprovado.png';
			$exibirPost = 0;
		}
	}else{
		$corBotao	= 'success';
		$texto = 'Fatura atrasada a';
		$imagem = 'cancelado.png';
		$exibirPost = 1;
	}
?>
	<input type="hidden" id="id_empresa" value="<?php echo $_SESSION['Empresa']['idSis_Empresa'];?>">
	<input type="hidden" id="intervalo" value="<?php echo $intervalo;?>">
	<input type="hidden" id="corBotao" value="<?php echo $corBotao;?>">
	<input type="hidden" id="texto" value="<?php echo $texto;?>">
	<input type="hidden" id="imagem" value="<?php echo $imagem;?>">
	<input type="hidden" id="exibirPost" value="<?php echo $exibirPost;?>">
	
	<script type="text/javascript">
		Shadowbox.init({
			skipSetup: true
		});
		window.onload = function() {
			var id_empresa 	= $('#id_empresa').val();
			var intervalo 	= $('#intervalo').val();
			var corBotao 	= $('#corBotao').val();
			var texto 		= $('#texto').val();
			var imagem 		= $('#imagem').val();
			var exibirPost 	= $('#exibirPost').val();
			if(intervalo == 0){
				var tempo = '';
			}else{
				var tempo = intervalo+' dia(s)';
			}

			// Abre uma mensagem, quando essa janela é selecionada
			if(exibirPost == 1 && id_empresa != 5 && id_empresa != 1){
				Shadowbox.open({
				content: '\
							<div style="text-align: center;">\
								<img src="arquivos/imagens/'+imagem+'" width="100" height="100" alt="" border="0" style="margin-top: 10px; margin-bottom: -100px;"/>\
								<div class="form-group col-md-12 text-center" style="margin-top: 100px;">\
									<h3> '+texto+' '+tempo+'.</h3>\
									<h4>Deseja Pagar agora?</h4>\
								</div>\
								<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">\
									<a type="button" class="btn btn-md btn-'+corBotao+' btn-block"  href="../../enkontraki/login_cliente.php?id_empresa='+id_empresa+'" target="_blank"  role="button" onclick="Shadowbox.close()">\
										<span class="glyphicon glyphicon-usd"></span> Sim\
									</a>\
								</div>\
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">\
									<button type="button" class="btn btn-warning btn-block" onclick="Shadowbox.close()">\
										<span class="glyphicon glyphicon-remove"></span> N\u00e3o\
									</button>\
								</div>\
							</div>\
						',
					player:     "html",
					//title:      "hjhjhjh",
					height:     500,
					width:      500
				});
			}
		};
	</script>
	
<?php } ?>