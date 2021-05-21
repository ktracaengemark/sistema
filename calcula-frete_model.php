<?php	

	//$CepOrigem = trim($_POST['CepOrigem']);	
	//$CepDestino = trim($_POST['CepDestino']);
	//$Peso = $_POST['Peso'];
	$CepOrigem=filter_input(INPUT_POST,'CepOrigem',FILTER_SANITIZE_SPECIAL_CHARS);
	$CepDestino=filter_input(INPUT_POST,'CepDestino',FILTER_SANITIZE_SPECIAL_CHARS);	
	$Peso=filter_input(INPUT_POST,'Peso',FILTER_SANITIZE_SPECIAL_CHARS);
	$Formato=filter_input(INPUT_POST,'Formato',FILTER_SANITIZE_SPECIAL_CHARS);
	$Comprimento=filter_input(INPUT_POST,'Comprimento',FILTER_SANITIZE_SPECIAL_CHARS);
	$Altura=filter_input(INPUT_POST,'Altura',FILTER_SANITIZE_SPECIAL_CHARS);
	$Largura=filter_input(INPUT_POST,'Largura',FILTER_SANITIZE_SPECIAL_CHARS);
	$MaoPropria=filter_input(INPUT_POST,'MaoPropria',FILTER_SANITIZE_SPECIAL_CHARS);
	$ValorDeclarado=filter_input(INPUT_POST,'ValorDeclarado',FILTER_SANITIZE_SPECIAL_CHARS);
	$AvisoRecebimento=filter_input(INPUT_POST,'AvisoRecebimento',FILTER_SANITIZE_SPECIAL_CHARS);
	$Codigo=filter_input(INPUT_POST,'Codigo',FILTER_SANITIZE_SPECIAL_CHARS);
	$Diametro=filter_input(INPUT_POST,'Diametro',FILTER_SANITIZE_SPECIAL_CHARS);	

	function calcula_frete($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro)
    {
        //$Url="http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem={$CepOrigem}&sCepDestino={$CepDestino}&nVlPeso={$Peso}&nCdFormato={$Formato}&nVlComprimento={$Comprimento}&nVlAltura={$Altura}&nVlLargura={$Largura}&sCdMaoPropria={$MaoPropria}&nVlValorDeclarado={$ValorDeclarado}&sCdAvisoRecebimento={$AvisoRecebimento}&nCdServico={$Codigo}&nVlDiametro={$Diametro}&StrRetorno=xml&nIndicaCalculo=3";
		//$Url="http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=24320040&sCepDestino=24350460&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
		$Url="http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem={$CepOrigem}&sCepDestino={$CepDestino}&nVlPeso=1&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3";
		$xml = simplexml_load_file($Url);
		
		return $xml->cServico;
	}

		$dados 			= calcula_frete($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro);
		$valor_frete 	= $dados->Valor;		
		$prazo_correios 	= $dados->PrazoEntrega;
		
		//echo $dados->Valor;
		//exit();
		//echo $dados->PrazoEntrega;
		//echo $valor_frete;
		//echo $prazo_correios;
		//echo "<br>";
		echo "<input class='form-control Correios' type='hidden' name='valor_frete' id='valor_frete' value='".$valor_frete."'>";
		echo '<input class="form-control Correios" type="hidden" name="prazo_correios" id="prazo_correios" value="'.$prazo_correios.'">';
		//echo '<input class="form-control" type="text" name="prazo_correios" id="prazo_correios" value="'.$prazo_correios.'">';
		/*
		echo '<div class="col-md-6 mb-3">
				<label for="prazo_correios">PrazoCorreios (Dias)</label>
				<input type="text" class="form-control " id="prazo_correios" maxlength="100" 
						onkeyup="calculaPrazoEntrega()"
					   name="prazo_correios" value="'.$prazo_correios.'">
			</div>';
		*/
		