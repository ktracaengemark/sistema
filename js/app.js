// JavaScript Document

var date = new Date();
var d = date.getDate();
var m = date.getMonth() + 1;
var y = date.getFullYear();
var n = date.toISOString();
var tam = n.length - 5;
var agora = n.substring(0, tam);
var data_hoje = new Date(date.getFullYear(), date.getMonth(), date.getDate());
//sequencia de comandos necess�ria para estrair a pasta raiz do endere�o,
//ou seja, qual m�dulo est� sendo utilizado (ex: salao, odonto, etc)
app = window.location.pathname;
app = app.substring(1);
pos = app.indexOf('/');
app = app.substring(0, pos);

//Captura a data do dia e carrega no campo correspondente
var currentDate = moment();

camposDisponiveis();
exibirentrega();
exibir();
exibir_confirmar();	
Aguardar();
clientePet();
clienteDep();
clienteOT();
fechaBuscaOS();
exibirTroco();
exibirExtraOrca();
exibirDescOrca();
dataehora();
qtd_ocorrencias();
calculacashback();
//calculaTotalOS();

//fun��o autocomplete 

// fun��o para limpeza dos campos do Cliente
$('#id_Cliente_Auto').on('input', limpaCampos_Cliente);
// fun��o que busca os nomes do Cliente
$("#id_Cliente_Auto").autocomplete({
	source: window.location.origin+ '/' + app + '/cadastros/pesquisar/Cliente_Autocomplete.php',

	select: function(event, ui){
		var pegar = ui.item.value;
		//console.log('pegar = '+pegar);
		var pegarSplit = pegar.split('#');
		var id_Cliente = pegarSplit[0];
		
		//console.log('id cliente Autocomplete = '+id_Cliente);
		
		$.ajax({
			url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Cliente.php?id=' + id_Cliente,
			dataType: "json",
			success: function (data) {
				
				var idcliente = data[0]['id'];
				var nomecliente = data[0]['nome'];
				var celularcliente = data[0]['celular'];
				
				$("#NomeClienteAuto1").html('<label>Cliente: '+idcliente+ ' | ' + nomecliente + ' | Cel: ' + celularcliente + '</label>');
				$("#NomeClienteAuto").val(''+idcliente+ ' | ' + nomecliente + ' | Cel: ' + celularcliente + '');
				
			},
			error:function(data){
				$("#NomeClienteAuto1").html('<label>Nenhum Cliente Selecionado!</label>');
				$("#NomeClienteAuto").val('Nenhum Cliente Selecionado!');
			}
			
		});

		$('#idApp_Cliente').val(id_Cliente);
		clienteDep(id_Cliente);
		clientePet(id_Cliente);
		calculacashback(id_Cliente);
		buscaEnderecoCliente(id_Cliente);
		clienteOT(id_Cliente);
	}
	
});
// Fun��o para limpar os campos caso a busca esteja vazia
function limpaCampos_Cliente(){
   var busca = $('#id_Cliente_Auto').val();

   if(busca == ""){
		
		$('#idApp_Cliente').val('');
		$('#idApp_ClienteDep').val('0');
		$('#idApp_ClienteDep').hide();
		$('#Dep').val('');
		$('#Dep').hide();
		$('#idApp_ClientePet').val('0');
		$('#idApp_ClientePet').hide();
		$('#Pet').val('');
		$('#Pet').hide();
		
		$('#CashBackOrca').val('0,00');
		$('#ValidadeCashBackOrca').val('');
		
		$("#NomeClienteAuto1").html('<label>Nenhum Cliente Selecionado!</label>');
		$("#NomeClienteAuto").val('Nenhum Cliente Selecionado!');
		
		$('#Cep').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#Referencia').val('');
   }
}	

// fun��o para limpeza dos campos do Fornecedor
$('#id_Fornecedor_Auto').on('input', limpaCampos_Fornecedor);
// fun��o que busca os nomes do Fornecedor
$("#id_Fornecedor_Auto").autocomplete({
	source: window.location.origin+ '/' + app + '/cadastros/pesquisar/Fornecedor_Autocomplete.php',

	select: function(event, ui){
		var pegar = ui.item.value;
		//console.log('pegar = '+pegar);
		var pegarSplit = pegar.split('#');
		var id_Fornecedor = pegarSplit[0];
		
		//console.log('id fornecedor Autocomplete = '+id_Fornecedor);
		
		$.ajax({
			url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Fornecedor.php?id=' + id_Fornecedor,
			dataType: "json",
			success: function (data) {
				
				var idfornecedor = data[0]['id'];
				var nomefornecedor = data[0]['nome'];
				var celularfornecedor = data[0]['celular'];
				
				$("#NomeFornecedorAuto1").html('<label>Fornecedor: '+idfornecedor+ ' | ' + nomefornecedor + ' | Cel: ' + celularfornecedor + '</label>');
				$("#NomeFornecedorAuto").val(''+idfornecedor+ ' | ' + nomefornecedor + ' | Cel: ' + celularfornecedor + '');
				
			},
			error:function(data){
				$("#NomeFornecedorAuto1").html('<label>Nenhum Fornecedor Selecionado!</label>');
				$("#NomeFornecedorAuto").val('Nenhum Fornecedor Selecionado!');
			}
			
		});

		$('#idApp_Fornecedor').val(id_Fornecedor);
		//fornecedorDep(id_Fornecedor);
		//fornecedorPet(id_Fornecedor);
		//calculacashback(id_Fornecedor);
		buscaEnderecoFornecedor(id_Fornecedor);
		//fornecedorOT(id_Fornecedor);
	}
	
});
// Fun��o para limpar os campos caso a busca esteja vazia
function limpaCampos_Fornecedor(){
   var busca = $('#id_Fornecedor_Auto').val();

   if(busca == ""){
		
		$('#idApp_Fornecedor').val('');
		//$('#idApp_FornecedorDep').val('0');
		//$('#idApp_FornecedorDep').hide();
		//$('#Dep').val('');
		//$('#Dep').hide();
		//$('#idApp_FornecedorPet').val('0');
		//$('#idApp_FornecedorPet').hide();
		//$('#Pet').val('');
		//$('#Pet').hide();
		
		$('#CashBackOrca').val('0,00');
		
		$("#NomeFornecedorAuto1").html('<label>Nenhum Fornecedor Selecionado!</label>');
		$("#NomeFornecedorAuto").val('Nenhum Fornecedor Selecionado!');
		
		$('#Cep').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#Referencia').val('');
   }
}	
	

function SomaDias(dias){

	if(dias){
		var qtd_dias = dias;
		var qtd_dias = parseInt(dias);
	}else{
		var qtd_dias = 0;
	}

	var data = new Date();

	data.setDate(data.getDate() + qtd_dias);

	var dia = data.getDate();
	var mes = (data.getMonth() + 1);
	var ano = data.getFullYear();

	if(mes < 10){
		var novo_mes = "0" + mes;
	}else{
		var novo_mes = mes;
	}
	
	
	if(dia < 10){
		var novo_dia = "0" + dia;
	}else{
		var novo_dia = dia;
	}	
	
	var nova_data = novo_dia + "/" + novo_mes + "/" + ano;
	$('#ValidadeGeralCashBack').val(nova_data);

}

function codigo(id, tabela){
	//alert('ok codigo');
	var categoria = $('#idTab_Catprod').val();
	var produto = $('#idTab_Produto').val();
	if(produto != 0){
		var nomeproduto = $('#Produtos').val();
	}else{
		var nomeproduto = "";
	}
	var variacao1 = $('#Opcao_Atributo_1').val();
	if(variacao1 != 0){
		var opcao1 = $('#Opcao1').val();
	}else{
		var opcao1 = "";
	}
	var variacao2 = $('#Opcao_Atributo_2').val();
	if(variacao2 != 0){
		var opcao2 = $('#Opcao2').val();
	}else{
		var opcao2 = "";
	}
	
	$('#Cod_Prod').val(categoria + ':' + produto + ':' + variacao1 + ':' + variacao2);
	$('#Nome_Prod').val(nomeproduto + ' ' + opcao1 + ' ' + opcao2);

    $.ajax({
		url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Pesquisa.php?q='+ tabela +'&id=' + id,
        dataType: "json",
        success: function (data) {
			if(tabela == "idTab_Produto"){
				nomeproduto = data[0]['nome'];
				$('#Produtos').val(nomeproduto);
			}else if(tabela == "Opcao_Atributo_1"){
				opcao1 = data[0]['nome'];
				$('#Opcao1').val(opcao1);
			}else if(tabela == "Opcao_Atributo_2"){
				opcao2 = data[0]['nome'];
				$('#Opcao2').val(opcao2);
			}
			$('#Nome_Prod').val(nomeproduto + ' ' + opcao1 + ' ' + opcao2);
			
		}
		
    });
	
	//$('#Nome_Prod').val(nomeproduto + ' ' + opcao1 + ' ' + opcao2);

}

//Fun��o que desabilita a Mensagem de Aguardar.
function Aguardar () {
	$('.aguardar').hide();
	$('.aguardar1').hide();
	$('.aguardar2').hide();
	$('.aguardarsalvar').hide();
	$('.aguardarResponsavel').hide();
	$('.aguardarCliente').hide();
	$('.aguardarCatprom').hide();
	$('.aguardarCatprod').hide();
	$('.aguardarAtributo').hide();
	$('.aguardarRacaPet').hide();
	$('.aguardarFuncao').hide();
	$('.aguardarOpcao').hide();
	$('.aguardarAlterarMotivo').hide();
	$('.aguardarAlterarCategoria').hide();
	$('.aguardarAlterarAtividade').hide();
	$('.aguardarAlterarCatprom').hide();
	$('.aguardarAlterarCatprod').hide();
	$('.aguardarAlterarProduto').hide();
	$('.aguardarAlterarAtributo').hide();
	$('.aguardarAlterarRacaPet').hide();
	$('.aguardarAlterarFuncao').hide();
	$('.aguardarAlterarOpcao').hide();
	$('.aguardarExcluirCatprod').hide();
	$('.aguardarExcluirAtributo').hide();
	$('.aguardarExcluirRacaPet').hide();
	$('.aguardarExcluirFuncao').hide();
	$('.aguardarExcluirOpcao').hide();
	$('.aguardarExcluirProduto').hide();
	$('.aguardarExcluirCatprom').hide();
	$('.exibir').show();
	$('#botaoFechar2').show();
	$('#botaoSalvar').show();
}

function exibir(){
	
	$('.Mostrar').show();
	$('.NMostrar').hide();
	
}

function exibir_confirmar(){
	$('.Open').show();
	$('.Close').hide();
}

// Fun��es de cadastros auxiliares

function buscaPet(){
		//var id_pet = $('#idApp_ClientePet').val();
		var id_pet = $('#Hidden_idApp_ClientePet').val();
		//console.log("executa safado");	
		//console.log("id do pet" + id_pet);
		event.preventDefault();
		
		$.ajax({
			url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Pet.php?id=' + id_pet,
			dataType: "json",
			success: function (data) {
			
				var id 			= data[0]['id'];
				var nome 		= data[0]['nome'];
				var nascimento 	= data[0]['nascimento'];
				var sexo 		= data[0]['sexo'];
				var especie 	= data[0]['especie'];
				var raca 		= data[0]['raca'];
				var pelo 		= data[0]['pelo'];
				var cor 		= data[0]['cor'];
				var porte 		= data[0]['porte'];
				var peso 		= data[0]['peso'];
				var alergico	= data[0]['alergico'];
				var obs 		= data[0]['obs'];
				
				if(alergico == "S"){
					var alergicopet = 'Sim';
				}else{
					var alergicopet = 'N�o';
				}
				
				if(sexo == "M"){
					var sexopet = 'Macho';
				}else if(sexo == "F"){
					var sexopet = 'F�mea';
				}else{
					var sexopet = 'NI';
				}
				
				if(especie == 0 || especie == ''){
					var especiepet = 'N.I.';
				}else if(especie == 1){
					var especiepet = 'C�O';
				}else if(especie == 2){
					var especiepet = 'GATO';
				}else if(especie == 3){
					var especiepet = 'AVE';
				}else{
					var especiepet = 'N.I.';
				}
				
				if(porte == 0 || porte == ''){
					var portepet = 'N.I.';
				}else if(porte == 1){
					var portepet = 'MINI';
				}else if(porte == 2){
					var portepet = 'PEQUENO';
				}else if(porte == 3){
					var portepet = 'M�DIO';
				}else if(porte == 4){
					var portepet = 'GRANDE';
				}else if(porte == 5){
					var portepet = 'GIGANTE';
				}else{
					var portepet = 'N.I.';
				}
				
				if(pelo == 0 || pelo == ''){
					var pelopet = 'N.I.';
				}else if(pelo == 1){
					var pelopet = 'CURTO';
				}else if(pelo == 2){
					var pelopet = 'M�DIO';
				}else if(pelo == 3){
					var pelopet = 'LONGO';
				}else if(pelo == 4){
					var pelopet = 'CACHEADO';
				}else{
					var pelopet = 'N.I.';
				}
				
				$("#Pet").html('<p>' + especiepet + '/ ' + raca + '/ ' + sexopet + '/ ' + portepet + '/ ' + peso + '/ Pelo: ' + pelopet + '/ Aler: ' + alergicopet + '/ Obs: ' + obs + '</p>');
				//$("#Pet").html('<div class="alert alert-warning" role="alert">' + nome + '/ ' + especiepet + '/ ' + portepet + '/<br>' + raca + '/ ' + pelopet + '</div>');
				
			},
			error:function(data){
				$("#Pet").html('<p >Nenhum Pet Selecionado!</p>');
			}
			
		});	
}

function buscaDep(){
		//var id_dep = $('#idApp_ClienteDep').val();
		var id_dep = $('#Hidden_idApp_ClienteDep').val();
		//console.log("executa safado");	
		//console.log("id do pet" + id_dep);
		event.preventDefault();
		
		$.ajax({
			url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Dep.php?id=' + id_dep,
			dataType: "json",
			success: function (data) {
			
				var id 			= data[0]['id'];
				var nome 		= data[0]['nome'];
				var nascimento 	= data[0]['nascimento'];
				var sexo 		= data[0]['sexo'];
				var obs 		= data[0]['obs'];
				
				$("#Dep").html('<p>' + obs + '</p>');
				
			},
			error:function(data){
				$("#Dep").html('<p >Nenhum Dependente Selecionado!</p>');
			}
			
		});	
}

$('#addPet').on('click', function(event){
	//alert('addPet');			
	
	var id_cliente =  $('#idApp_Cliente').val();
	$('#id_Cliente').val(id_cliente);

	//console.log(id_cliente);
	//Limpar mensagem de erro
	//$("#addClientePetModalLabel").html('<div class="alert alert-warning" role="alert">Pet do Cliente: '+id_cliente+'</div>');		
	
	event.preventDefault();
	
	$.ajax({
		url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Cliente.php?id=' + id_cliente,
		dataType: "json",
		success: function (data) {
		
			var idcliente = data[0]['id'];
			var nomecliente = data[0]['nome'];
			var celularcliente = data[0]['celular'];
			
			$("#addClientePetModalLabel").html('<div class="alert alert-warning" role="alert">Cadsatrar Pet do(a) Cliente: '+idcliente+ '<br>Nome: ' + nomecliente + '<br>Celular: ' + celularcliente + '</div>');
			
		},
		error:function(data){
			$("#addClientePetModalLabel").html('<div class="alert alert-warning" role="alert">Nenhum Cliente Selecionado!</div>');
		}
		
	});	
	
});

$('#addDep').on('click', function(event){
	//alert('addDep');			
	
	var id_cliente =  $('#idApp_Cliente').val();
	$('#id_Cliente').val(id_cliente);

	//console.log(id_cliente);
	//Limpar mensagem de erro
	//$("#addClienteDepModalLabel").html('<div class="alert alert-warning" role="alert">Dep do Cliente: '+id_cliente+'</div>');		
	
	event.preventDefault();
	
	$.ajax({
		url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Cliente.php?id=' + id_cliente,
		dataType: "json",
		success: function (data) {
		
			var idcliente = data[0]['id'];
			var nomecliente = data[0]['nome'];
			var celularcliente = data[0]['celular'];
			
			$("#addClienteDepModalLabel").html('<div class="alert alert-warning" role="alert">Cadsatrar Dependente do(a) Cliente: '+idcliente+ '<br>Nome: ' + nomecliente + '<br>Celular: ' + celularcliente + '</div>');
			
		},
		error:function(data){
			$("#addClienteDepModalLabel").html('<div class="alert alert-warning" role="alert">Nenhum Cliente Selecionado!</div>');
		}
		
	});	
	
});

$('#idApp_ClientePet').on('change', function(event){
	//alert('idApp_ClientePet');			
	
	var id_pet =  $('#idApp_ClientePet').val();

	//console.log(id_pet);	
	
	event.preventDefault();
	
	$.ajax({
		url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Pet.php?id=' + id_pet,
		dataType: "json",
		success: function (data) {
		
			var id 			= data[0]['id'];
			var nome 		= data[0]['nome'];
			var nascimento 	= data[0]['nascimento'];
			var sexo 		= data[0]['sexo'];
			var especie 	= data[0]['especie'];
			var raca 		= data[0]['raca'];
			var pelo 		= data[0]['pelo'];
			var cor 		= data[0]['cor'];
			var porte 		= data[0]['porte'];
			var peso 		= data[0]['peso'];
			var alergico	= data[0]['alergico'];
			var obs 		= data[0]['obs'];
			
			if(alergico == "S"){
				var alergicopet = 'Sim';
			}else{
				var alergicopet = 'N�o';
			}
							
			if(sexo == "M"){
				var sexopet = 'Macho';
			}else if(sexo == "F"){
				var sexopet = 'F�mea';
			}else{
				var sexopet = 'NI';
			}
				
			if(especie == 0 || especie == ''){
				var especiepet = 'N.I.';
			}else if(especie == 1){
				var especiepet = 'C�O';
			}else if(especie == 2){
				var especiepet = 'GATO';
			}else if(especie == 3){
				var especiepet = 'AVE';
			}else{
				var especiepet = 'N.I.';
			}
			
			if(porte == 0 || porte == ''){
				var portepet = 'N.I.';
			}else if(porte == 1){
				var portepet = 'MINI';
			}else if(porte == 2){
				var portepet = 'PEQUENO';
			}else if(porte == 3){
				var portepet = 'M�DIO';
			}else if(porte == 4){
				var portepet = 'GRANDE';
			}else if(porte == 5){
				var portepet = 'GIGANTE';
			}else{
				var portepet = 'N.I.';
			}
			
			if(pelo == 0 || pelo == ''){
				var pelopet = 'N.I.';
			}else if(pelo == 1){
				var pelopet = 'CURTO';
			}else if(pelo == 2){
				var pelopet = 'M�DIO';
			}else if(pelo == 3){
				var pelopet = 'LONGO';
			}else if(pelo == 4){
				var pelopet = 'CACHEADO';
			}else{
				var pelopet = 'N.I.';
			}
			
			$("#Pet").html('<p>' + especiepet + '/ ' + raca + '/ ' + sexopet + '/ ' + portepet + '/ ' + peso + '/ Pelo: ' + pelopet + '/ Aler: ' + alergicopet + '/ Obs: ' + obs + '</p>');
			
		},
		error:function(data){
			$("#Pet").html('<p >Nenhum Pet Selecionado!</p>');
		}
		
	});	
	
});

$('#idApp_ClienteDep').on('change', function(event){
	//alert('idApp_ClienteDep');			
	
	var id_dep =  $('#idApp_ClienteDep').val();

	//console.log(id_dep);	
	
	event.preventDefault();
	
	$.ajax({
		url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Dep.php?id=' + id_dep,
		dataType: "json",
		success: function (data) {
		
			var id 			= data[0]['id'];
			var nome 		= data[0]['nome'];
			var nascimento 	= data[0]['nascimento'];
			var sexo 		= data[0]['sexo'];
			var obs 		= data[0]['obs'];

			$("#Dep").html('<p>' + obs + '</p>');
			
		},
		error:function(data){
			$("#Dep").html('<p >Nenhum Dependente Selecionado!</p>');
		}
		
	});	
	
});

$('#insert_cliente_form').on('submit', function(event){
	//alert('ok');			
	event.preventDefault();
	
	if($('#NomeCliente').val() == "" || $('#CelularCliente').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-cliente").html('<div class="alert alert-danger" role="alert">Necess�rio prencher Nome e Celular!</div>');
	}else{		
		//console.log($('#NomeCliente').val());
		//console.log($('#CelularCliente').val());			
		var celular = $('#CelularCliente').val();
		var tamanho = celular.toString().length;
		//console.log(tamanho);
		
		if( tamanho == 11 ) {
			//Fechar o bot�o cadastrar
			$('#botaoCadCliente').hide();
								
			//Fechar o bot�o fechar
			$('#botaoFecharCliente').hide();
			
			//Abre o Aguardar
			$('.aguardarCliente').show();	
			
			//Receber os dados do formul�rio
			var dados = $("#insert_cliente_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Cliente.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 5){
					//Limpar os campo
					$('#insert_cliente_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addClienteModal').modal('hide');
								
					//Alerta de Cliente existente 
					$('#msgClienteExiste').modal('show');
					
					//Abre o bot�o cadastrar
					$('#botaoCadCliente').show();
										
					//Abre o bot�o fechar
					$('#botaoFecharCliente').show();
					
					//Fecha o Aguardar
					$('.aguardarCliente').hide();
					
					//Limpar mensagem de erro
					$("#msg-error-cliente").html('');
					
					//listar_usuario(1, 50);
				}else if(retorna == 1){
					//Limpar os campo
					$('#insert_cliente_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addClienteModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-cliente").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-cliente").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Cliente!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				}
				
			});
		}else{
			$("#msg-error-cliente").html('<div class="alert alert-danger" role="alert">O Celular deve conter 11 n�meros!</div>');
		}
		
	}
	
	
});	

$('#insert_responsavel_form').on('submit', function(event){
	//alert('ok');
	
	event.preventDefault();
	
	if($('#NomeResponsavel').val() == "" || $('#CelularResponsavel').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-responsavel").html('<div class="alert alert-danger" role="alert">Necess�rio prencher Nome e Celular do Responsavel!</div>');						
	}else{		
		//console.log($('#NomeResponsavel').val());
		//console.log($('#CelularResponsavel').val());
		var celular = $('#CelularResponsavel').val();
		var tamanho = celular.toString().length;
		//console.log(tamanho);
		
		if( tamanho == 11 ) {
			//Fechar o bot�o cadastrar
			$('#botaoCadResponsavel').hide();
								
			//Fechar o bot�o fechar
			$('#botaoFecharResponsavel').hide();
			
			//Abre o Aguardar
			$('.aguardarResponsavel').show();	
			
			//Receber os dados do formul�rio
			var dados = $("#insert_responsavel_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Responsavel.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 5){
					//Limpar os campo
					$('#insert_responsavel_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addResponsavelModal').modal('hide');
								
					//Alerta de Responsavel ja cadastrado
					$('#msgResponsavelExiste').modal('show');
					
					//Abre o bot�o cadastrar
					$('#botaoCadResponsavel').show();
										
					//Abre o bot�o fechar
					$('#botaoFecharResponsavel').show();
					
					//Fecha o Aguardar
					$('.aguardarResponsavel').hide();
					
					//Limpar mensagem de erro
					$("#msg-error-responsavel").html('');
					
					//listar_usuario(1, 50);
				}else if(retorna == 1){
					//Limpar os campo
					$('#insert_responsavel_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addResponsavelModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-responsavel").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-responsavel").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Responsavel!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				}
				
			});
		}else{
			$("#msg-error-responsavel").html('<div class="alert alert-danger" role="alert">O Celular deve conter 11 n�meros!</div>');
		}
		
	}
	
});	

$('#insert_clientedep_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#NomeClienteDep').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-clientedep").html('<div class="alert alert-danger" role="alert">Necess�rio prencher Nome do Dependente!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCad').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFechar').hide();
		
		//Abre o Aguardar
		$('.aguardar1').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_clientedep_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/ClienteDep.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
				//Limpar os campo
				$('#insert_clientedep_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addClienteDepModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-clientedep").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-clientedep").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Dependente!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}
	
});	

$('#insert_clientepet_form').on('submit', function(event){
	//alert('ok');
	var id_cliente =  $('#idApp_Cliente').val();
	$('#id_Cliente').val(id_cliente);

	//console.log(id_cliente);
	//Limpar mensagem de erro
	$("#msg-error-clientepet").html('');
	
	event.preventDefault();
	if(id_cliente == "" || id_cliente == "0"){
		//console.log($('#id_Cliente').val());
		$("#msg-error-clientepet").html('<div class="alert alert-danger" role="alert">Cliente N�o informado!</div>');						
	}else{
		//Limpar mensagem de erro
		$("#msg-error-clientepet").html('');
		
		//console.log($('#id_Cliente').val());
		if($('#NomeClientePet').val() == ""){
			//Alerta de campo  vazio
			$("#msg-error-clientepet").html('<div class="alert alert-danger" role="alert">Necess�rio prencher Nome do Pet!</div>');						
		}else{
			//Fechar o bot�o cadastrar
			$('#botaoCad').hide();
								
			//Fechar o bot�o fechar
			$('#botaoFechar').hide();
			
			//Abre o Aguardar
			$('.aguardar1').show();	
			
			//Receber os dados do formul�rio
			var dados = $("#insert_clientepet_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/inserir/ClientePet.php?', dados, function (retorna){
			 //console.log(retorna);
				
				if(retorna == 1){
					//Limpar os campo
					$('#insert_clientepet_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addClientePetModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
					$('#msgCadSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-clientepet").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-clientepet").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Pet!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				}
				
				
			});
			
		}
	}
	
});	

$('#insert_racapet_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_RacaPet').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-racapet").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCadRacaPet').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFecharRacaPet').hide();
		
		//Abre o Aguardar
		$('.aguardarRacaPet').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_racapet_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/RacaPet.php?', dados, function (retorna){
		 //console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_racapet_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addRacaPetModal').modal('hide');
				
				$('#addClientePetModal').modal('hide');
				
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-racapet").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-racapet").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar RacaPet!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
							
				//Abre o bot�o fechar
				$('#botaoFecharRacaPet').show();
				
				//Fecha o Aguardar
				$('.aguardarRacaPet').hide();				
			
			}
			
			
		});
		
		
	}	
});

$('#alterarRacaPet').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidracapet = button.data('whateveridracapet')
	var recipientracapet = button.data('whateverracapet')
	//console.log(recipientracapet);
	var modal = $(this)
	modal.find('.modal-title').text('id da Raca: ' + recipientidracapet)
	modal.find('#id_RacaPet').val(recipientidracapet)
	modal.find('#Nome_RacaPet').val(recipientracapet)
})

$('#alterar_racapet_form').on('submit', function(event){
	//alert('ok - Alterar o RacaPet');
	
	event.preventDefault();
	var racapet = $('#Nome_RacaPet').val();
	//console.log(racapet);
	//exit();
	
	if($('#Nome_RacaPet').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-racapet").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-racapet').hide();
		//Fechar o bot�o Alterar
		$('#AlterarRacaPet').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarRacaPet').hide();
		//Abre o Aguardar
		$('.aguardarAlterarRacaPet').show();
		//Fechar a janela modal alterar
		$('#addRacaPetModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_racapet_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/RacaPet.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_racapet_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarRacaPet').modal('hide');
				
				$('#addClientePetModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-racapet").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-racapet").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o RacaPet!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o Cancelar
				$('#CancelarRacaPet').show();
				
				//Fecha o Aguardar
				$('.aguardarAlterarRacaPet').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirRacaPet').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidracapet = button.data('whateveridracapet')
	var recipientracapet = button.data('whateverracapet')
	//console.log(recipientracapet);
	var modal = $(this)
	modal.find('.modal-title').text('id da Raca: ' + recipientidracapet)
	modal.find('#id_ExcluirRacaPet').val(recipientidracapet)
	modal.find('#ExcluirRacaPet').val(recipientracapet)
})

$('#excluir_racapet_form').on('submit', function(event){
	//alert('ok - Excluir o RacaPet');
	
	event.preventDefault();
	var racapet = $('#id_ExcluirRacaPet').val();
	//console.log(racapet);
	//exit();
	
	if($('#id_ExcluirRacaPet').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-racapet").html('<div class="alert alert-danger" role="alert">Necess�rio Informar o RacaPet!</div>');						
	}else{
		//$("#msg-error-excluir-racapet").html('<div class="alert alert-success" role="alert">RacaPet Informado!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-racapet').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirRacaPet').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirRacaPet').hide();
		//Abre o Aguardar
		$('.aguardarExcluirRacaPet').show();
		//Fechar a janela modal excluir
		$('#addRacaPetModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_racapet_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/RacaPet.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_racapet_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirRacaPet').modal('hide');
				
				$('#addClientePetModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-racapet").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-racapet").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Excluir a Varia��o!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarExcluirRacaPet').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirRacaPet').hide();				
			
			}
			
		});
		
	}
	
});	

$('#insert_fornecedor_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#NomeFornecedor').val() == "" || $('#CelularFornecedor').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-fornecedor").html('<div class="alert alert-danger" role="alert">Necess�rio prencher Nome e Celular do Fornecedor!</div>');						
	}else{		
		
		var celular = $('#CelularFornecedor').val();
		var tamanho = celular.toString().length;
		//console.log(tamanho);
		
		if( tamanho == 11 ) {
			//Fechar o bot�o cadastrar
			$('#botaoCad').hide();
								
			//Fechar o bot�o fechar
			$('#botaoFechar').hide();
			
			//Abre o Aguardar
			$('.aguardar1').show();	
			
			//Receber os dados do formul�rio
			var dados = $("#insert_fornecedor_form").serialize();
			//console.log(dados);
			
			$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Fornecedor.php?', dados, function (retorna){
			 //console.log(retorna);
				if(retorna == 1){
					//Limpar os campo
					$('#insert_fornecedor_form')[0].reset();
					
					//Fechar a janela modal cadastrar
					$('#addFornecedorModal').modal('hide');
								
					//Alerta de cadastro realizado com sucesso
					//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
					$('#msgCadFornecedorSucesso').modal('show');
					
					//Limpar mensagem de erro
					$("#msg-error-fornecedor").html('');
					
					//listar_usuario(1, 50);
				}else{
					$("#msg-error-fornecedor").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Fornecedor!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				}
				
			});
		}else{
			$("#msg-error-fornecedor").html('<div class="alert alert-danger" role="alert">O Celular deve conter 11 n�meros!</div>');
		}
	}
	
});	

$('#insert_funcao_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Funcao').val() == "" || $('#Novo_Abrev').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-funcao").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCadFuncao').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFecharFuncao').hide();
		
		//Abre o Aguardar
		$('.aguardarFuncao').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_funcao_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Funcao.php?', dados, function (retorna){
		 //console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_funcao_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addFuncaoModal').modal('hide');
				
				$('#addClientePetModal').modal('hide');
				
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-funcao").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-funcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar funcao!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
							
				//Abre o bot�o fechar
				$('#botaoFecharFuncao').show();
				
				//Fecha o Aguardar
				$('.aguardarFuncao').hide();				
			
			}
			
			
		});
		
		
	}	
});

$('#alterarFuncao').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidfuncao = button.data('whateveridfuncao')
	var recipientfuncao = button.data('whateverfuncao')
	var recipientabrev = button.data('whateverabrev')
	//console.log(recipientfuncao);
	var modal = $(this)
	modal.find('.modal-title').text('id da Funcao: ' + recipientidfuncao)
	modal.find('#id_Funcao').val(recipientidfuncao)
	modal.find('#Nome_Funcao').val(recipientfuncao)
	modal.find('#Nome_Abrev').val(recipientabrev)
})

$('#alterar_funcao_form').on('submit', function(event){
	//alert('ok - Alterar o Funcao');
	
	event.preventDefault();
	var funcao = $('#Nome_Funcao').val();
	var abrev = $('#Nome_Abrev').val();
	//console.log(funcao);
	//exit();
	
	if($('#Nome_Funcao').val() == "" || $('#Nome_Abrev').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-funcao").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-funcao').hide();
		//Fechar o bot�o Alterar
		$('#AlterarFuncao').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarFuncao').hide();
		//Abre o Aguardar
		$('.aguardarAlterarFuncao').show();
		//Fechar a janela modal alterar
		$('#addFuncaoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_funcao_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Funcao.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_funcao_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarFuncao').modal('hide');
				
				$('#addClientePetModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-funcao").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-funcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Funcao!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o Cancelar
				$('#CancelarFuncao').show();
				
				//Fecha o Aguardar
				$('.aguardarAlterarFuncao').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirFuncao').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidfuncao = button.data('whateveridfuncao')
	var recipientfuncao = button.data('whateverfuncao')
	var recipientabrev = button.data('whateverabrev')
	//console.log(recipientfuncao);
	var modal = $(this)
	modal.find('.modal-title').text('id da Funcao: ' + recipientidfuncao)
	modal.find('#id_ExcluirFuncao').val(recipientidfuncao)
	modal.find('#ExcluirFuncao').val(recipientfuncao)
	modal.find('#ExcluirAbrev').val(recipientabrev)
})

$('#excluir_funcao_form').on('submit', function(event){
	//alert('ok - Excluir o Funcao');
	
	event.preventDefault();
	var funcao = $('#id_ExcluirFuncao').val();
	//console.log(funcao);
	//exit();
	
	if($('#id_ExcluirFuncao').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-funcao").html('<div class="alert alert-danger" role="alert">Necess�rio Informar o Funcao!</div>');						
	}else{
		//$("#msg-error-excluir-funcao").html('<div class="alert alert-success" role="alert">Funcao Informado!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-funcao').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirFuncao').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirFuncao').hide();
		//Abre o Aguardar
		$('.aguardarExcluirFuncao').show();
		//Fechar a janela modal excluir
		$('#addFuncaoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_funcao_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/Funcao.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_funcao_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirFuncao').modal('hide');
				
				$('#addClientePetModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-funcao").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-funcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Excluir a Varia��o!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarExcluirFuncao').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirFuncao').hide();				
			
			}
			
		});
		
	}
	
});	

$('#insert_motivo_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Motivo').val() == "" || $('#Desc_Motivo').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-motivo").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCad').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFechar').hide();
		
		//Abre o Aguardar
		$('.aguardar1').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_motivo_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Motivo.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_motivo_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addMotivoModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-motivo").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-motivo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Motivo!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}	
});

$('#alterarMotivo').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidmotivo = button.data('whateveridmotivo')
	var recipientmotivo = button.data('whatevermotivo')
	var recipientdescmotivo = button.data('whateverdescmotivo')
	//console.log(recipientmotivo);
	var modal = $(this)
	modal.find('.modal-title').text('id do Motivo: ' + recipientidmotivo)
	modal.find('#id_Motivo').val(recipientidmotivo)
	modal.find('#MotivoAlterar').val(recipientmotivo)
	modal.find('#DescMotivoAlterar').val(recipientdescmotivo)
})

$('#alterar_motivo_form').on('submit', function(event){
	//alert('ok - Alterar o Motivo');
	
	event.preventDefault();
	var motivo = $('#MotivoAlterar').val();
	//console.log(motivo);
	
	if($('#MotivoAlterar').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-motivo").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-motivo').hide();
		//Fechar o bot�o Alterar
		$('#AlterarMotivo').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarMotivo').hide();
		//Abre o Aguardar
		$('.aguardarAlterarMotivo').show();
		//Fechar a janela modal alterar
		$('#addMotivoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_motivo_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Motivo.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_motivo_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarMotivo').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-motivo").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-motivo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Motivo!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}
	
});	

$('#insert_categoria_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Categoria').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-categoria").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCad').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFechar').hide();
		
		//Abre o Aguardar
		$('.aguardar1').show();
		
		//Receber os dados do formul�rio
		var dados = $("#insert_categoria_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Categoria.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_categoria_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addCategoriaModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-categoria").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-categoria").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}	
});

$('#alterarCategoria').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidcategoria = button.data('whateveridcategoria')
	var recipientcategoria = button.data('whatevercategoria')
	//console.log(recipientcategoria);
	var modal = $(this)
	modal.find('.modal-title').text('id do Categoria: ' + recipientidcategoria)
	modal.find('#id_Categoria').val(recipientidcategoria)
	modal.find('#CategoriaAlterar').val(recipientcategoria)
})

$('#alterar_categoria_form').on('submit', function(event){
	//alert('ok - Alterar o Categoria');
	
	event.preventDefault();
	var categoria = $('#CategoriaAlterar').val();
	//console.log(categoria);
	
	if($('#CategoriaAlterar').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-categoria").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-categoria').hide();
		//Fechar o bot�o Alterar
		$('#AlterarCategoria').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarCategoria').hide();
		//Abre o Aguardar
		$('.aguardarAlterarCategoria').show();
		//Fechar a janela modal alterar
		$('#addCategoriaModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_categoria_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Categoria.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_categoria_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarCategoria').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-categoria").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-categoria").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}
	
});	

$('#insert_atividade_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Atividade').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-atividade").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCad').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFechar').hide();
		
		//Abre o Aguardar
		$('.aguardar1').show();	
				
		//Receber os dados do formul�rio
		var dados = $("#insert_atividade_form").serialize();
		//console.log(dados);

		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Atividade.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_atividade_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addAtividadeModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-atividade").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-atividade").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Atividade!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}
	
});

$('#alterarAtividade').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidatividade = button.data('whateveridatividade')
	var recipientatividade = button.data('whateveratividade')
	//console.log(recipientatividade);
	var modal = $(this)
	modal.find('.modal-title').text('id do Atividade: ' + recipientidatividade)
	modal.find('#id_Atividade').val(recipientidatividade)
	modal.find('#AtividadeAlterar').val(recipientatividade)
})

$('#alterar_atividade_form').on('submit', function(event){
	//alert('ok - Alterar o Atividade');
	
	event.preventDefault();
	var atividade = $('#AtividadeAlterar').val();
	//console.log(atividade);
	
	if($('#AtividadeAlterar').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-atividade").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-atividade').hide();
		//Fechar o bot�o Alterar
		$('#AlterarAtividade').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarAtividade').hide();
		//Abre o Aguardar
		$('.aguardarAlterarAtividade').show();
		//Fechar a janela modal alterar
		$('#addAtividadeModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_atividade_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Atividade.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_atividade_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarAtividade').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-atividade").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-atividade").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Atividade!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			}
			
		});
		
	}
	
});	

$('#insert_catprom_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Catprom').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-catprom").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCadCatprom').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFecharCatprom').hide();
		
		//Abre o Aguardar
		$('.aguardarCatprom').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_catprom_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Catprom.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_catprom_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addCatpromModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-catprom").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-catprom").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
							
				//Abre o bot�o fechar
				$('#botaoFecharCatprom').show();
				
				//Fecha o Aguardar
				$('.aguardarCatprom').hide();				
			
			}
			
		});
		
	}	
});

$('#alterarCatprom').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidcatprom = button.data('whateveridcatprom')
	var recipientcatprom = button.data('whatevercatprom')
	var recipientsitecatprom = button.data('whateversitecatprom')
	var recipientbalcaocatprom = button.data('whateverbalcaocatprom')
	//console.log(recipientcatprom);
	var modal = $(this)
	modal.find('.modal-title').text('id da Categoria: ' + recipientidcatprom)
	modal.find('#id_Categoria').val(recipientidcatprom)
	modal.find('#Catprom').val(recipientcatprom)
	if(recipientsitecatprom == 'S'){
		modal.find('#Site_Catprom_Alterar_Sim').prop('checked', true);
	}else if(recipientsitecatprom == 'N'){
		modal.find('#Site_Catprom_Alterar_Nao').prop('checked', true);
	}
	if(recipientbalcaocatprom == 'S'){
		modal.find('#Balcao_Catprom_Alterar_Sim').prop('checked', true);
	}else if(recipientbalcaocatprom == 'N'){
		modal.find('#Balcao_Catprom_Alterar_Nao').prop('checked', true);
	}
})

$('#alterar_catprom_form').on('submit', function(event){
	//alert('ok - Alterar Categoria do Produto');
	
	event.preventDefault();
	var catprom = $('#Catprom').val();
	//console.log(catprom);
	//exit();
	
	if($('#Catprom').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-catprom").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-catprom').hide();
		//Fechar o bot�o Alterar
		$('#AlterarCatprom').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarCatprom').hide();
		//Abre o Aguardar
		$('.aguardarAlterarCatprom').show();
		//Fechar a janela modal alterar
		$('#addCatpromModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_catprom_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Catprom.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_catprom_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarCatprom').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-catprom").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-catprom").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarCatprom').show();
				
				//Fecha o Aguardar
				$('.aguardarAlterarCatprom').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirCatprom').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidcatprom = button.data('whateveridcatprom')
	var recipientcatprom = button.data('whatevercatprom')
	var recipientsitecatprom = button.data('whateversitecatprom')
	var recipientbalcaocatprom = button.data('whateverbalcaocatprom')
	//console.log(recipientcatprom);
	var modal = $(this)
	modal.find('.modal-title').text('id da Categoria: ' + recipientidcatprom)
	modal.find('#id_ExcluirCategoria').val(recipientidcatprom)
	modal.find('#Catprom_Excluir').val(recipientcatprom)
})

$('#excluir_catprom_form').on('submit', function(event){
	//alert('ok - Excluir Categoria da Promocao');
	
	event.preventDefault();
	var catprom = $('#id_ExcluirCategoria').val();
	//console.log(catprom);
	
	if($('#id_ExcluirCategoria').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-catprom").html('<div class="alert alert-danger" role="alert">Necess�rio Informar a Categoria!</div>');						
	}else{
		$("#msg-error-excluir-catprom").html('<div class="alert alert-success" role="alert">Categoria Informada!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-catprom').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirCatprom').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirCatprom').hide();
		//Abre o Aguardar
		$('.aguardarExcluirCatprom').show();
		//Fechar a janela modal excluir
		$('#addCatpromModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_catprom_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/Catprom.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_catprom_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirCatprom').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-catprom").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-catprom").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Excluir a Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o Cancelar
				$('#CancelarExcluirCatprom').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirCatprom').hide();				
			
			}
			
		});
		
	}
	
});	

$('#insert_catprod_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Catprod').val() == "" || $('#TipoCatprod').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-catprod").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCadCatprod').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFecharCatprod').hide();
		
		//Abre o Aguardar
		$('.aguardarCatprod').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_catprod_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Catprod.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_catprod_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addCatprodModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-catprod").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-catprod").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o fechar
				$('#botaoFecharCatprod').show();
				
				//Fecha o Aguardar
				$('.aguardarCatprod').hide();				
			
			}
			
		});
		
	}	
});

$('#alterarCatprod').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidcatprod = button.data('whateveridcatprod')
	var recipientcatprod = button.data('whatevercatprod')
	var recipientsitecatprod = button.data('whateversitecatprod')
	var recipientbalcaocatprod = button.data('whateverbalcaocatprod')
	//console.log(recipientcatprod);
	var modal = $(this)
	modal.find('.modal-title').text('id da Categoria: ' + recipientidcatprod)
	modal.find('#id_Categoria').val(recipientidcatprod)
	modal.find('#Catprod').val(recipientcatprod)
	if(recipientsitecatprod == 'S'){
		modal.find('#Site_Catprod_Alterar_Sim').prop('checked', true);
	}else if(recipientsitecatprod == 'N'){
		modal.find('#Site_Catprod_Alterar_Nao').prop('checked', true);
	}
	if(recipientbalcaocatprod == 'S'){
		modal.find('#Balcao_Catprod_Alterar_Sim').prop('checked', true);
	}else if(recipientbalcaocatprod == 'N'){
		modal.find('#Balcao_Catprod_Alterar_Nao').prop('checked', true);
	}
})

$('#alterar_catprod_form').on('submit', function(event){
	//alert('ok - Alterar Categoria do Produto');
	
	event.preventDefault();
	var catprod = $('#Catprod').val();
	//console.log(catprod);
	//exit();
	
	if($('#Catprod').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-catprod").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-catprod').hide();
		//Fechar o bot�o Alterar
		$('#AlterarCatprod').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarCatprod').hide();
		//Abre o Aguardar
		$('.aguardarAlterarCatprod').show();
		//Fechar a janela modal alterar
		$('#addCatprodModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_catprod_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Catprod.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_catprod_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarCatprod').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-catprod").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-catprod").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o Cancelar
				$('#CancelarCatprod').show();
				
				//Fecha o Aguardar
				$('.aguardarAlterarCatprod').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirCatprod').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidcatprod = button.data('whateveridcatprod')
	var recipientcatprod = button.data('whatevercatprod')
	var recipientsitecatprod = button.data('whateversitecatprod')
	var recipientbalcaocatprod = button.data('whateverbalcaocatprod')
	//console.log(recipientcatprod);
	var modal = $(this)
	modal.find('.modal-title').text('id da Categoria: ' + recipientidcatprod)
	modal.find('#id_Categoria_Excluir').val(recipientidcatprod)
	modal.find('#Catprod_Excluir').val(recipientcatprod)
})

$('#excluir_catprod_form').on('submit', function(event){
	//alert('ok - Excluir Categoria do Produto');
	
	event.preventDefault();
	var catprod = $('#id_Categoria_Excluir').val();
	//console.log(catprod);
	//exit();
	
	if($('#id_Categoria_Excluir').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-catprod").html('<div class="alert alert-danger" role="alert">Necess�rio informar a Categoria!</div>');						
	}else{
		//$("#msg-error-excluir-catprod").html('<div class="alert alert-success" role="alert">Categoria Informada!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-catprod').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirCatprod').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirCatprod').hide();
		//Abre o Aguardar
		$('.aguardarExcluirCatprod').show();
		//Fechar a janela modal excluir
		$('#addCatprodModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_catprod_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/Catprod.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_catprod_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirCatprod').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-catprod").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-catprod").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Apagar a Categoria!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarExcluirCatprod').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirCatprod').hide();
			}
			
		});
		
	}
	
});	

$('#insert_produto_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Produto').val() == "" || $('#idCat_Produto').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-produto").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCad').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFechar').hide();
		
		//Abre o Aguardar
		$('.aguardar1').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_produto_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Produto.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_produto_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addProdutoModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-produto").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-produto").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Produto!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o fechar
				$('#botaoFechar').show();
				
				//Fecha o Aguardar
				$('.aguardar1').hide();				
			}
			
		});
		
	}	
});

$('#alterarProduto').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidproduto = button.data('whateveridproduto')
	var recipientproduto = button.data('whateverproduto')
	var recipientvendasite = button.data('whatevervendasite')
	var recipientvendabalcao = button.data('whatevervendabalcao')
	//console.log(recipientvendasite);
	var modal = $(this)
	modal.find('.modal-title').text('id do Produto: ' + recipientidproduto)
	modal.find('#id_Produto').val(recipientidproduto)
	modal.find('#AlterarProdutos').val(recipientproduto)
	if(recipientvendasite == 'S'){
		//$("#VendaSite_Alterar_Sim").prop('checked', true);
		modal.find('#VendaSite_Alterar_Sim').prop('checked', true);
	}else if(recipientvendasite == 'N'){
		//$("#VendaSite_Alterar_Nao").prop('checked', true);
		modal.find('#VendaSite_Alterar_Nao').prop('checked', true);
	}
	if(recipientvendabalcao == 'S'){
		//$("#VendaBalcao_Alterar_Sim").prop('checked', true);
		modal.find('#VendaBalcao_Alterar_Sim').prop('checked', true);
	}else if(recipientvendabalcao == 'N'){
		//$("#VendaBalcao_Alterar_Nao").prop('checked', true);
		modal.find('#VendaBalcao_Alterar_Nao').prop('checked', true);
	}
})

$('#alterar_produto_form').on('submit', function(event){
	//alert('ok - Alterar o Produto');
	
	event.preventDefault();
	var produto = $('#AlterarProdutos').val();
	//var vendasite = $('#VendaSite').val();
	//console.log(vendasite);
	if($('#AlterarProdutos').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-produto").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-produto').hide();
		//Fechar o bot�o Alterar
		$('#AlterarProduto').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarProduto').hide();
		//Abre o Aguardar
		$('.aguardarAlterarProduto').show();
		//Fechar a janela modal alterar
		$('#addProdutoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_produto_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Produto.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_produto_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarProduto').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-produto").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-produto").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Produto!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarProduto').show();
				//Fecha o Aguardar
				$('.aguardarAlterarProduto').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirProduto').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidproduto = button.data('whateveridproduto')
	var recipientproduto = button.data('whateverproduto')
	var recipientvendasite = button.data('whatevervendasite')
	var recipientvendabalcao = button.data('whatevervendabalcao')
	//console.log(recipientvendasite);
	var modal = $(this)
	modal.find('.modal-title').text('id do Produto: ' + recipientidproduto)
	modal.find('#id_ExcluirProduto').val(recipientidproduto)
	modal.find('#ExcluirProdutos').val(recipientproduto)
})

$('#excluir_produto_form').on('submit', function(event){
	//alert('ok - Excluir o Produto');
	
	event.preventDefault();
	var produto = $('#id_ExcluirProduto').val();
	//var vendasite = $('#VendaSite').val();
	//console.log(produto);
	if($('#id_ExcluirProduto').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-produto").html('<div class="alert alert-danger" role="alert">Necess�rio Informar o Produto Base!</div>');						
	}else{
		//$("#msg-error-excluir-produto").html('<div class="alert alert-success" role="alert">Produto Base Informado!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-produto').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirProduto').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirProduto').hide();
		//Abre o Aguardar
		$('.aguardarExcluirProduto').show();
		//Fechar a janela modal excluir
		$('#addProdutoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_produto_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/Produto.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_produto_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirProduto').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-produto").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-produto").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Excluir o Produto!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarExcluirProduto').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirProduto').hide();
				
			}
			
		});
		
	}
	
});	

$('#insert_atributo_form').on('submit', function(event){
	//alert('ok');
	event.preventDefault();
	if($('#Novo_Atributo').val() == "" || $('#idCat_Atributo').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-atributo").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCadAtributo').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFecharAtributo').hide();
		
		//Abre o Aguardar
		$('.aguardarAtributo').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_atributo_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Atributo.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_atributo_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addAtributoModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-atributo").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-atributo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Atributo!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
							
				//Abre o bot�o fechar
				$('#botaoFecharAtributo').show();
				
				//Fecha o Aguardar
				$('.aguardarAtributo').hide();				
			
			}
			
		});
		
	}	
});

$('#alterarAtributo').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidatributo = button.data('whateveridatributo')
	var recipientatributo = button.data('whateveratributo')
	//console.log(recipientatributo);
	var modal = $(this)
	modal.find('.modal-title').text('id da Variacao: ' + recipientidatributo)
	modal.find('#id_Atributo').val(recipientidatributo)
	modal.find('#Atributo').val(recipientatributo)
})

$('#alterar_atributo_form').on('submit', function(event){
	//alert('ok - Alterar o Atributo');
	
	event.preventDefault();
	var atributo = $('#Atributo').val();
	//console.log(atributo);
	//exit();
	
	if($('#Atributo').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-atributo").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-atributo').hide();
		//Fechar o bot�o Alterar
		$('#AlterarAtributo').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarAtributo').hide();
		//Abre o Aguardar
		$('.aguardarAlterarAtributo').show();
		//Fechar a janela modal alterar
		$('#addAtributoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_atributo_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Atributo.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_atributo_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarAtributo').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-atributo").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-atributo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar o Atributo!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o Cancelar
				$('#CancelarAtributo').show();
				
				//Fecha o Aguardar
				$('.aguardarAlterarAtributo').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirAtributo').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidatributo = button.data('whateveridatributo')
	var recipientatributo = button.data('whateveratributo')
	//console.log(recipientatributo);
	var modal = $(this)
	modal.find('.modal-title').text('id da Variacao: ' + recipientidatributo)
	modal.find('#id_ExcluirAtributo').val(recipientidatributo)
	modal.find('#ExcluirAtributo').val(recipientatributo)
})

$('#excluir_atributo_form').on('submit', function(event){
	//alert('ok - Excluir o Atributo');
	
	event.preventDefault();
	var atributo = $('#id_ExcluirAtributo').val();
	//console.log(atributo);
	//exit();
	
	if($('#id_ExcluirAtributo').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-atributo").html('<div class="alert alert-danger" role="alert">Necess�rio Informar o Atributo!</div>');						
	}else{
		//$("#msg-error-excluir-atributo").html('<div class="alert alert-success" role="alert">Atributo Informado!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-atributo').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirAtributo').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirAtributo').hide();
		//Abre o Aguardar
		$('.aguardarExcluirAtributo').show();
		//Fechar a janela modal excluir
		$('#addAtributoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_atributo_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/Atributo.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_atributo_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirAtributo').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-atributo").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-atributo").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Excluir a Varia��o!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
			
				//Abre o bot�o Cancelar
				$('#CancelarExcluirAtributo').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirAtributo').hide();				
			
			}
			
		});
		
	}
	
});	

$('#insert_opcao_form').on('submit', function(event){
	//alert('ok - Opcao');
	event.preventDefault();
	if($('#Novo_Opcao').val() == "" || $('#idAtributo_Opcao').val() == "" || $('#idCat_Opcao').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-opcao").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		//Fechar o bot�o cadastrar
		$('#botaoCadOpcao').hide();
							
		//Fechar o bot�o fechar
		$('#botaoFecharOpcao').hide();
		
		//Abre o Aguardar
		$('.aguardarOpcao').show();	
		
		//Receber os dados do formul�rio
		var dados = $("#insert_opcao_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/inserir/Opcao.php?', dados, function (retorna){
		 //console.log(retorna);
			if(retorna == 1){
			
				//Limpar os campo
				$('#insert_opcao_form')[0].reset();
				
				//Fechar a janela modal cadastrar
				$('#addOpcaoModal').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-opcao").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-opcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar Op��o!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
							
				//Abre o bot�o fechar
				$('#botaoFecharOpcao').show();
				
				//Fecha o Aguardar
				$('.aguardarOpcao').hide();					
			
			}
			
		});
		
	}	
});

$('#alterarOpcao').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidopcao = button.data('whateveridopcao')
	var recipientopcao = button.data('whateveropcao')
	//console.log(recipientopcao);
	var modal = $(this)
	modal.find('.modal-title').text('id da Opcao: ' + recipientidopcao)
	modal.find('#id_Opcao').val(recipientidopcao)
	modal.find('#Opcao').val(recipientopcao)
})

$('#alterar_opcao_form').on('submit', function(event){
	//alert('ok - Alterar a Opcao');
	
	event.preventDefault();
	var opcao = $('#Opcao').val();
	//console.log(opcao);
	//exit();
	
	if($('#Opcao').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-alterar-opcao").html('<div class="alert alert-danger" role="alert">Necess�rio prencher todos os campos!</div>');						
	}else{
		
		//Fechar a mensagem de erro
		$('#msg-error-alterar-opcao').hide();
		//Fechar o bot�o Alterar
		$('#AlterarOpcao').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarOpcao').hide();
		//Abre o Aguardar
		$('.aguardarAlterarOpcao').show();
		//Fechar a janela modal alterar
		$('#addOpcaoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#alterar_opcao_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/alterar/Opcao.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#alterar_opcao_form')[0].reset();
				
				//Fechar a janela modal alterar
				$('#alterarOpcao').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-alterar-opcao").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-alterar-opcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao cadastrar a Opcao!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');
				
				//Abre o bot�o Cancelar
				$('#CancelarOpcao').show();
				
				//Fecha o Aguardar
				$('.aguardarAlterarOpcao').hide();				
			}
			
		});
		
	}
	
});	

$('#excluirOpcao').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var recipientidopcao = button.data('whateveridopcao')
	var recipientopcao = button.data('whateveropcao')
	//console.log(recipientopcao);
	var modal = $(this)
	modal.find('.modal-title').text('id da Opcao: ' + recipientidopcao)
	modal.find('#id_ExcluirOpcao').val(recipientidopcao)
	modal.find('#ExcluirOpcao').val(recipientopcao)
})

$('#excluir_opcao_form').on('submit', function(event){
	//alert('ok - Excluir a Opcao');
	
	event.preventDefault();
	var opcao = $('#id_ExcluirOpcao').val();
	//console.log(opcao);
	
	if($('#id_ExcluirOpcao').val() == ""){
		//Alerta de campo  vazio
		$("#msg-error-excluir-opcao").html('<div class="alert alert-danger" role="alert">Necess�rio Informar a Opcao!</div>');						
	}else{
		//$("#msg-error-excluir-opcao").html('<div class="alert alert-success" role="alert">Opcao Informada!</div>');
		
		//Fechar a mensagem de erro
		$('#msg-error-excluir-opcao').hide();
		//Fechar o bot�o Excluir
		$('#ExcluirOpcao').hide();
		//Fechar o bot�o Cancelar
		$('#CancelarExcluirOpcao').hide();
		//Abre o Aguardar
		$('.aguardarExcluirOpcao').show();
		//Fechar a janela modal excluir
		$('#addOpcaoModal').modal('hide');
		
		//Receber os dados do formul�rio
		var dados = $("#excluir_opcao_form").serialize();
		//console.log(dados);
		
		$.post(window.location.origin+ '/' + app + '/cadastros/excluir/Opcao.php?', dados, function (retorna){
		 
			//console.log(retorna);
			
			if(retorna == 1){
			
				//Limpar os campo
				$('#excluir_opcao_form')[0].reset();
				
				//Fechar a janela modal excluir
				$('#excluirOpcao').modal('hide');
							
				//Alerta de cadastro realizado com sucesso
				//$("#msg").html('<div class="alert alert-success" role="alert">Usu�rio cadastrado com sucesso!</div>'); 
				$('#msgCadSucesso').modal('show');
				
				//Limpar mensagem de erro
				$("#msg-error-excluir-opcao").html('');
				
				//listar_usuario(1, 50);
			}else{
				$("#msg-error-excluir-opcao").html('<div class="alert alert-danger" role="alert">Ocorreu um erro ao Apagar a Opcao!<br>Entre em contato com o Suporte T�cnico do Sistema.</div>');

				//Abre o bot�o Cancelar
				$('#CancelarExcluirOpcao').show();
				
				//Fecha o Aguardar
				$('.aguardarExcluirOpcao').hide();				
			
			}
			
		});
		
	}
	
});	

//Fun��o que busca Pets do Cliente.
function clientePet(id = null){
	//alert('carregando clientepets: ' + id);
	
	$("#Pet").html('');
	
	if(id && id!= 'null'){
		var id_cliente = id;
	}else{
		var id_cliente = $('#idApp_Cliente').val();
	}
	//var id_cliente = $('#idApp_Cliente').val();
	//var id_pet = $('#idApp_ClientePet').val();
	
	var caminho2 = $('#Caminho2').val();
	//console.log('caminho pet = '+caminho2);
	//var caminho2 = '../../';
	//console.log('id cliente  = '+id_cliente);
	
	//console.log(id);
	
	//console.log(' <br>oioioioi<br> ');
		
	//console.log('<br> Hidden_idApp_ClientePet = '+ $('#Hidden_idApp_ClientePet').val());
	
	if(id_cliente) {
		//console.log(id_cliente);
		
		$('#idApp_ClientePet').val('0');
		if(id_cliente == 0){
			$('#idApp_ClientePet').hide();
		}
		
		var exibir_id = $('#exibir_id').val();
		//console.log('exibir_id = '+exibir_id);
		if(exibir_id == 1){
			$('#idApp_ClientePet').hide();
			$('#idApp_ClientePet').val('0');
		}
		/*
		$('.carregando').show();
		*/
		
		$.getJSON(window.location.origin+ '/' + app + '/cadastros/pesquisar/ClientePet.php?search=',{idApp_Cliente: id_cliente, ajax: 'true'}, function(j){
			//console.log(idApp_Cliente);
			//console.log(j);
			//console.log(j.length);
		
			var options = '<option value="">-- Sel. Pet --</option>';	
			for (var i = 0; i < j.length; i++) {
				if (j[i].id_ClientePet == $('#Hidden_idApp_ClientePet').val()) {
					options += '<option value="' + j[i].id_ClientePet + '" selected="selected">' + j[i].nome_ClientePet + '</option>';
					buscaPet();
				} else {
					options += '<option value="' + j[i].id_ClientePet + '">' + j[i].nome_ClientePet + '</option>';
				}
				//options += '<option value="' + j[i].id_ClientePet + '">' + j[i].nome_ClientePet + '</option>';
			}	
			$('#idApp_ClientePet').html(options).show();
			//$('.carregando').hide();
			//console.log(options);
		});
			
	} else {
		$('#idApp_ClientePet').html('<option value="">� Selecione um Cliente �</option>');
		//console.log('Nenhum Cliente');
	}

}

//Fun��o que busca Deps do Cliente.
function clienteDep(id = null){
	//alert('carregando clientepets: ' + id);
	
	$("#Dep").html('');

	if(id && id!= 'null'){
		var id_cliente = id;
	}else{
		var id_cliente = $('#idApp_Cliente').val();
	}
	
	//var id_cliente = $('#idApp_Cliente').val();
	
	var caminho2 = $('#Caminho2').val();
	//console.log(caminho2);
	//var caminho2 = '../../';
	//console.log('id cliente dep = '+id_cliente);
	//console.log(id);
	
	//console.log(' <br>oioioioi<br> ');
		
	//console.log('<br> Hidden_idApp_ClienteDep = '+ $('#Hidden_idApp_ClienteDep').val());
	
	if(id_cliente) {
		//console.log(id);
		
		$('#idApp_ClienteDep').val('0');
		if(id_cliente == 0){
			$('#idApp_ClienteDep').hide();
		}
		
		var exibir_id = $('#exibir_id').val();
		//console.log('exibir_id = '+exibir_id);
		if(exibir_id == 1){
			$('#idApp_ClienteDep').hide();
			$('#idApp_ClienteDep').val('0');
		}
		
		//$('#idApp_ClienteDep').hide();
		/*
		$('.carregando').show();
		*/
		$.getJSON(window.location.origin+ '/' + app + '/cadastros/pesquisar/ClienteDep.php?search=',{idApp_Cliente: id_cliente, ajax: 'true'}, function(j){
			//console.log(idApp_Cliente);
			//console.log(j.length);
			
			//console.log(j);

			/*		
			foreach ($select['idApp_ClientePet'] as $key => $row) {
				if ($query['idApp_ClientePet'] == $key) {
					echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
				} else {
					echo '<option value="' . $key . '">' . $row . '</option>';
				}
			}			
			*/			
			var options = '<option value="">-- Sel. Dep --</option>';	
			for (var i = 0; i < j.length; i++) {
				if (j[i].id_ClienteDep == $('#Hidden_idApp_ClienteDep').val()) {
					options += '<option value="' + j[i].id_ClienteDep + '" selected="selected">' + j[i].nome_ClienteDep + '</option>';
					buscaDep();
				} else {
					options += '<option value="' + j[i].id_ClienteDep + '">' + j[i].nome_ClienteDep + '</option>';
				}
				//options += '<option value="' + j[i].id_ClienteDep + '">' + j[i].nome_ClienteDep + '</option>';
			}	
			$('#idApp_ClienteDep').html(options).show();
			//$('.carregando').hide();
			//console.log(options);
		});
		
	} else {
		$('#idApp_ClienteDep').html('<option value="">� Selecione um Cliente �</option>');
	}

}

function fechaBuscaOS(novaos){
	//alert('fechaBuscaOS');
	//console.log('novaos = '+novaos);
	//console.log('Hidden_NovaOS = '+$('#Hidden_NovaOS').val());
	if(novaos){
		var hnovaos = novaos;
		$('#Hidden_NovaOS').val(hnovaos);
	}else{
		var hnovaos = $('#Hidden_NovaOS').val();
	}
	//console.log('hnovaos = '+hnovaos);
	if(hnovaos == "S"){
		$('.vincular').hide();
		$('.hnovaos').hide();
	}else{
		$('.vincular').show();
		$('.hnovaos').show();
	}
	
	
}

function mudaBuscaOS(novaos){
	
	var hnovaos = $('#Hidden_NovaOS').val();
	//console.log(hnovaos);
	
	if(hnovaos == "S"){
		$('.hnovaos').hide();
	}else{
		$('.hnovaos').show();
	}
	
}

function quais(){
	//alert('quais');
	var quais = $('#Quais').val();
	$('#Quais_Excluir').val(quais);
	if(quais == 1){
		var quais_texto = '"Apenas Esse" ';
	}else if(quais == 2){
		var quais_texto = '"Esse e os Anteriores" ';
	}else if(quais == 3){
		var quais_texto = '"Esse e os Posteriores" ';
	}else if(quais == 4){
		var quais_texto = '"Todos" ';
	}
	$("#Texto_Excluir").html('<div class="col-md-7 text-left alert alert-warning" role="alert">Voc� vai excluir ' + quais_texto + ' agendamento(s) vinculado(s) a esse!</div>');
}

//Fun��o que busca O.S. do cliente.
function clienteOT(id = null){
	
	if(id && id!= 'null'){
		var id_cliente = id;
	}else{
		var id_cliente = $('#idApp_Cliente').val();
	}
	
	//var id_cliente = $('#idApp_Cliente').val();
	
	var caminho2 = $('#Caminho2').val();
	//console.log(caminho2);
	//var caminho2 = '../../';
	//console.log(id_cliente);
	//console.log(id);
	
	//console.log(' <br>OrcaTrata<br> ');
		
	//console.log('<br> Hidden_idApp_OrcaTrata = '+ $('#Hidden_idApp_OrcaTrata').val());
	
	if(id_cliente) {
		//console.log(id);
		
		//$('#idApp_OrcaTrata').hide();
		$.getJSON(window.location.origin+ '/' + app + '/cadastros/pesquisar/OrcaTrata.php?search=',{idApp_Cliente: id_cliente, ajax: 'true'}, function(j){
			
			var options = '<option value="">-- Sel. O.S. --</option>';	
			for (var i = 0; i < j.length; i++) {
				if (j[i].id_OrcaTrata == $('#Hidden_idApp_OrcaTrata').val()) {
					options += '<option value="' + j[i].id_OrcaTrata + '" selected="selected">' + j[i].id_OrcaTrata + ' | ' + j[i].descricao_OrcaTrata + '</option>';
					buscaPet();
				} else {
					options += '<option value="' + j[i].id_OrcaTrata + '">' + j[i].id_OrcaTrata + ' | ' + j[i].descricao_OrcaTrata + '</option>';
				}
			}	
			$('#idApp_OrcaTrata').html(options).show();
			//$('.carregando').hide();
			//console.log(options);
		});
		
	} else {
		$('#idApp_OrcaTrata').html('<option value="">� Selecione um Cliente �</option>');
	}

}

//Fun��o que desabilita o bot�o fechar ap�s 1 click, evitando mais de um envio de formul�rio.
function DesabilitaBotaoSalvar () {	
	$('#botaoSalvar').hide();
	$('.aguardarsalvar').show();
}

//Fun��o que desabilita o bot�o fechar ap�s 1 click, evitando mais de um envio de formul�rio.
function DesabilitaBotaoFechar () {	
	$('#botaoFechar2').hide();
	$('.aguardar2').show();
}

function parseDate(texto) {
  let dataDigitadaSplit = texto.split("/");

  let dia = dataDigitadaSplit[0];
  let mes = dataDigitadaSplit[1];
  let ano = dataDigitadaSplit[2];


  if (ano.length < 4 && parseInt(ano) < 50) {
    ano = "20" + ano;
  } else if (ano.length < 4 && parseInt(ano) >= 50) {
    ano = "19" + ano;
  }
  ano = parseInt(ano);
  mes = mes - 1;

  return new Date(ano, mes, dia);
}

//Funcao das datas
function addData() {
	var dataDigitada = $('#Data').val();
  //var dataDigitada = document.getElementById('Data').value;
	//console.log('Data teste: ' + dataDigitada);
  //Pegar data Atual para somar
  var currentDate = parseDate(dataDigitada);

  //pegar data atual para exibir
  var currentDate1 = new Date();

  //Capturar Quantidade de meses
  var meses = "1";
  //Parse Int dos meses
  var a = parseInt(meses);


  //Adicionar meses 
  currentDate.setMonth(currentDate.getMonth() + a);

  //Trazer data Atual
  currentDate1.setDate(currentDate1.getDate());



  //Exibir data Atual
  document.getElementById('data').value = currentDate1.toLocaleDateString();


  //Exibir a data ja atualizada
  document.getElementById('dataAtualizada').value = currentDate.toLocaleDateString();

}

function dataehora(datainicio = null, horainicio = null) {
	//alert('dataehora');
	if(datainicio || horainicio){
		if(datainicio != "null" && horainicio == "null"){
			var dtinicio = datainicio;
			$('#Hidden_Data').val(dtinicio);
			var hrinicio = $('#Hidden_HoraInicio').val();
		}else if(datainicio == "null" && horainicio != "null"){
			var hrinicio = horainicio;
			$('#Hidden_HoraInicio').val(hrinicio);
			var dtinicio = $('#Hidden_Data').val();
		}
	}else{
		var dtinicio = $('#Data').val();
		$('#Hidden_Data').val(dtinicio);
		var hrinicio = $('#HoraInicio').val();
		$('#Hidden_HoraInicio').val(hrinicio);
	}
	var metodo = $('#metodo').val();
		//console.log('datainicio = '+datainicio);
		//console.log('horainicio = '+horainicio);
		//console.log('dtinicio = '+dtinicio);
		//console.log('hrinicio = '+hrinicio);
		
	if(dtinicio){
		var datainicial = dtinicio;
		// Digamos que este � o formato das suas datas
		// data = '30/03/2019';
		// Precisamos quebrar a string para retornar cada parte
		var datainicialSplit = datainicial.split('/');
		var day = datainicialSplit[0]; 
		var month = datainicialSplit[1];
		var year = datainicialSplit[2];
		// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
		//datainicial = new Date(year, month - 1, day);
		datainicial = year+'-'+month+'-'+day;
		//console.log('datainicial = '+datainicial);
	}
	if(hrinicio){
		var horainicial = hrinicio;
		horainicial = hrinicio+':00';
		//console.log('horainicial = '+horainicial);
	}	
	if(dtinicio && hrinicio){
		var dataehora = datainicial+' '+horainicial;
		//console.log('dataehora = '+dataehora);
		var dataehora_orig = dtinicio+ ' �s ' +hrinicio;
		//console.log('dataehora_orig = '+dataehora_orig);
	}
		
    $.ajax({
		
		url: window.location.origin+ '/' + app + '/cadastros/pesquisar/Horarios.php?id=' + dataehora,
		//url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=1000&idCliente=' + dataehora,

		// dataType json
        dataType: "json",
		//method:'get',
        // fun��o para de sucesso
        success: function (data) {
            //console.log('length = '+data.length);
			//console.log('metodo = '+metodo);
			if(metodo == 1){
				var quantidade = data.length;
				if(quantidade <= 0){
					$("#Horarios").html('<span>N�o Existem Agendamentos neste hor�rio: ' + dataehora_orig + '</span>');
				}else{
					$("#Horarios").html('<span>Existe(m) <strong>" ' +quantidade+' " </strong> Agendamento(s) neste hor�rio: ' + dataehora_orig + '</span>');
				}
			}else{
				var quantidade = data.length - 1;
				if(quantidade <= 0){
					$("#Horarios").html('<span>N�o Existem Agendamentos neste hor�rio: ' + dataehora_orig + '</span>');
				}else{
					$("#Horarios").html('<span>Existe(m) <strong>" ' +quantidade+' " </strong> Agendamento(s) neste hor�rio: ' + dataehora_orig + '</span>');
				}
			}
			//console.log('quantidade = '+quantidade);
			for (i = 0; i < data.length; i++) {

                if (data[i].dataehora == dataehora) {
					//console.log('id_Consulta = '+data[i].id);
					//$('#Cep').val(data[i].cepcliente);
                    break;
                }

            }//fim do la�o
		},
		error:function(data){
			//console.log('Nada encontrado');
			$("#Horarios").html('<span>N�o Existem Agendamentos neste hor�rio: ' + dataehora_orig + '</span>');
			//alert('Cep n�o encontrado. Confira o Cep e Tente Novamente');
			//$('#Cep').val(CepDestino);
		}
		
    });//termina o ajax
	
}

function qtd_ocorrencias(status_PorConsulta) {
	if(status_PorConsulta){
		var novo_status_PorConsulta = status_PorConsulta;
		$('#Hidden_Status_PorConsulta').val(novo_status_PorConsulta);
		var Hidden_Status_Vincular = $('#Hidden_Status_Vincular').val();
	}else{
		var novo_status_PorConsulta = $('#Hidden_Status_PorConsulta').val();
		
	}
	//$("#Ocorrencias").html('<span>'+ocorrencias+ '</span>');
		
		//console.log('Hidden_Status_Vincular = '+Hidden_Status_Vincular);
	
	
		var count_repet = $('#count_repet').val();
						//console.log('count_repet = '+count_repet);
		var metodo = $('#metodo').val();
						//console.log('metodo = '+metodo);
		//var ocorrencias = $('#Recorrencias').val();
						
		
		if(metodo == 1){
			var ocorrencias = $('#Recorrencias').val();
			$("#Ocorrencias").html('<span>'+ocorrencias+'</span>');
			
		}else{
			if(count_repet == 0){
				var ocorrencias = 1;
				$("#Ocorrencias").html('<span>1</span>');
			}else{
				var ocorrencias = count_repet;
				$("#Ocorrencias").html('<span>'+count_repet+'</span>');
			}
		}
			
		//console.log('status_PorConsulta = '+novo_status_PorConsulta);
	
		if(ocorrencias == 1){
			if(novo_status_PorConsulta == "N"){
				$('.novaos').hide();
				$('.vincular').show();
				$('.hnovaos').show();
				
			}else{
				$('.novaos').hide();
				$('.hnovaos').hide();
			}
		}else{
			$('.novaos').show();
			$('.vincular').hide();
			$('.hnovaos').hide();
		}
		//console.log('ocorrencias = '+ocorrencias);
		
	
}

function ocorrencias(repetir = null) {
	if(repetir){
		var status_repetir = repetir;
		$('#Hidden_Status_Repetir').val(status_repetir);
		if(repetir == 'N'){
			$('#Recorrencias').val('1');
			$('#Intervalo').val('');
			$('#Tempo').val('1');
			$('#Periodo').val('');
			$('#Tempo2').val('1');
		}
	}else{
		var status_repetir = $('#Hidden_Status_Repetir').val();
		if(status_repetir == 'N'){
			$('#Recorrencias').val('1');
		}
	}
	
	var ocorrencias = $('#Recorrencias').val();
	$("#Ocorrencias").html('<span>'+ocorrencias+ '</span>');

	//console.log('Repetir = '+repetir);
	//console.log('ocorrencias = '+ocorrencias);
	//console.log('Status_Repetir = '+status_repetir);
	
	var datainicial = $('#Data').val();
	// Digamos que este � o formato das suas datas
	// data = '30/03/2019';
	// Precisamos quebrar a string para retornar cada parte
	const datainicialSplit = datainicial.split('/');
	const day = datainicialSplit[0]; 
	const month = datainicialSplit[1];
	const year = datainicialSplit[2];
	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	datainicial = new Date(year, month - 1, day);
	
	var primeira = new Date(year, month - 1, day);
	var ultima = new Date(year, month - 1, day);
	var datatermino = new Date(year, month - 1, day);
	//console.log('Data Inicial: ' + datainicial);

	var intervalo = $('#Intervalo').val();
	var inter_int = parseInt(intervalo);
	var escala1 = $('#Tempo').val();	
	
	var periodo = $('#Periodo').val();
	var peri_int = parseInt(periodo);
	var escala2 = $('#Tempo2').val();
	
	if(escala1 == 1){
		primeira.setDate(primeira.getDate()+inter_int);
	}else if(escala1 == 2){
		primeira.setDate(primeira.getDate()+(inter_int*7));
	}else if(escala1 == 3){
		primeira.setMonth(primeira.getMonth()+inter_int);
	}else if(escala1 == 4){
		primeira.setFullYear(primeira.getFullYear()+inter_int);
	}
	
	if(escala2 == 1){
		ultima.setDate(ultima.getDate()+peri_int);
	}else if(escala2 == 2){
		ultima.setDate(ultima.getDate()+(peri_int*7));
	}else if(escala2 == 3){
		ultima.setMonth(ultima.getMonth()+peri_int);
	}else if(escala2 == 4){
		ultima.setFullYear(ultima.getFullYear()+peri_int);
	}
	
	var primeiraedit = primeira.toLocaleDateString();
	//console.log('Primeira Editada: ' + primeiraedit);
	$('#DataMinima').val(primeiraedit);		
	
	var ultimaedit = ultima.toLocaleDateString();
	//console.log('Ultima Editada: ' + ultimaedit);
	//$('#DataTermino').val(ultimaedit);
	
	const primeiraeditSplit = primeiraedit.split('/');
	const dayP = primeiraeditSplit[0]; 
	const monthP = primeiraeditSplit[1]; 
	const yearP = primeiraeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	primeiraedit = new Date(yearP, monthP - 1, dayP);	
	//console.log('Primeira Y-m-d: ' + primeiraedit);
	
	const ultimaeditSplit = ultimaedit.split('/');
	const dayU = ultimaeditSplit[0]; 
	const monthU = ultimaeditSplit[1]; 
	const yearU = ultimaeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	ultimaedit = new Date(yearU, monthU - 1, dayU);	
	//console.log('Ultimo Y-m-d: ' + ultimaedit);	
	
	
	const pastI = datainicial; // Outra data no passado
	
	const pastP = primeiraedit; // Outra data no passado
	const diffP = Math.abs(pastP.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysP = Math.ceil(diffP / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//console.log('Tempo Primeira: ' + daysP + ' dias');
	

	const pastU = ultimaedit; // Outra data no passado
	const diffU = Math.abs(pastU.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysU = Math.ceil(diffU / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//console.log('Tempo Ultimo: ' + daysU + ' dias');	
	
	//var ocorrencias = Math.ceil(daysU/daysP);
	//console.log('Ocorr�ncias: ' + ocorrencias + ' Vez(es)');
	//$('#Recorrencias').val(ocorrencias);
	
	//var ocorrencias = $('#Recorrencias').val();
	
	if(escala1 == 1){
		datatermino.setDate(datatermino.getDate()+(inter_int*(ocorrencias - 1)));
	}else if(escala1 == 2){
		datatermino.setDate(datatermino.getDate()+(inter_int*7*(ocorrencias - 1)));
	}else if(escala1 == 3){
		datatermino.setMonth(datatermino.getMonth()+(inter_int*(ocorrencias - 1)));
	}else if(escala1 == 4){
		datatermino.setFullYear(datatermino.getFullYear()+(inter_int*(ocorrencias - 1)));
	}		
	
	var dataterminoedit = datatermino.toLocaleDateString();
	//console.log('DataTermino : ' + dataterminoedit);
	$('#DataTermino').val(dataterminoedit);	
	
	
	const dataterminoeditSplit = dataterminoedit.split('/');
	const dayT = dataterminoeditSplit[0]; 
	const monthT = dataterminoeditSplit[1]; 
	const yearT = dataterminoeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	dataterminoedit = new Date(yearT, monthT - 1, dayT);	
	//console.log('datatermino Y-m-d: ' + dataterminoedit);	
	
	const pastT = dataterminoedit; // Outra data no passado
	const diffT = Math.abs(pastT.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysT = Math.ceil(diffT / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//const daysT = (daysT + 1); // Somo o dia de in�cio.
	var durante = daysT + 1;
	//console.log('DataT : ' + daysT + ' dias');
	//console.log('Periodo(Durante) : ' + durante + ' dias');	
	$('#Periodo').val(durante);
	$('#Tempo2').val('1');
}

function dateTermina() {
	
	var datainicial = $('#Data').val();
	// Digamos que este � o formato das suas datas
	// data = '30/03/2019';
	// Precisamos quebrar a string para retornar cada parte
	const datainicialSplit = datainicial.split('/');
	const day = datainicialSplit[0]; 
	const month = datainicialSplit[1];
	const year = datainicialSplit[2];
	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	datainicial = new Date(year, month - 1, day);
	
	var primeira = new Date(year, month - 1, day);
	var ultima = new Date(year, month - 1, day);
	var datatermino = new Date(year, month - 1, day);
	//console.log('Data Inicial: ' + datainicial);

	var intervalo = $('#Intervalo').val();
	var inter_int = parseInt(intervalo);
	var escala1 = $('#Tempo').val();	
	
	var periodo = $('#Periodo').val();
	var peri_int = parseInt(periodo);
	var escala2 = $('#Tempo2').val();
	
	if(escala1 == 1){
		primeira.setDate(primeira.getDate()+inter_int);
	}else if(escala1 == 2){
		primeira.setDate(primeira.getDate()+(inter_int*7));
	}else if(escala1 == 3){
		primeira.setMonth(primeira.getMonth()+inter_int);
	}else if(escala1 == 4){
		primeira.setFullYear(primeira.getFullYear()+inter_int);
	}
	
	if(escala2 == 1){
		ultima.setDate(ultima.getDate()+peri_int);
	}else if(escala2 == 2){
		ultima.setDate(ultima.getDate()+(peri_int*7));
	}else if(escala2 == 3){
		ultima.setMonth(ultima.getMonth()+peri_int);
	}else if(escala2 == 4){
		ultima.setFullYear(ultima.getFullYear()+peri_int);
	}
	
	var primeiraedit = primeira.toLocaleDateString();
	//console.log('Primeira Editada: ' + primeiraedit);
	$('#DataMinima').val(primeiraedit);		
	
	var ultimaedit = ultima.toLocaleDateString();
	//console.log('Ultima Editada: ' + ultimaedit);
	//$('#DataTermino').val(ultimaedit);
	
	const primeiraeditSplit = primeiraedit.split('/');
	const dayP = primeiraeditSplit[0]; 
	const monthP = primeiraeditSplit[1]; 
	const yearP = primeiraeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	primeiraedit = new Date(yearP, monthP - 1, dayP);	
	//console.log('Primeira Y-m-d: ' + primeiraedit);
	
	const ultimaeditSplit = ultimaedit.split('/');
	const dayU = ultimaeditSplit[0]; 
	const monthU = ultimaeditSplit[1]; 
	const yearU = ultimaeditSplit[2]; 

	// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	ultimaedit = new Date(yearU, monthU - 1, dayU);	
	//console.log('Ultimo Y-m-d: ' + ultimaedit);	
	
	
	const pastI = datainicial; // Outra data no passado
	
	const pastP = primeiraedit; // Outra data no passado
	const diffP = Math.abs(pastP.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysP = Math.ceil(diffP / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//console.log('Tempo Primeira: ' + daysP + ' dias');
	

	const pastU = ultimaedit; // Outra data no passado
	const diffU = Math.abs(pastU.getTime() - pastI.getTime()); // Subtrai uma data pela outra
	const daysU = Math.ceil(diffU / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).	
	//console.log('Tempo Ultimo: ' + daysU + ' dias');	
	
	var ocorrencias = Math.ceil(daysU/daysP);
	//console.log('Ocorr�ncias: ' + ocorrencias + ' Vez(es)');
	$('#Recorrencias').val(ocorrencias);

	if(escala1 == 1){
		datatermino.setDate(datatermino.getDate()+(inter_int*(ocorrencias - 1)));
	}else if(escala1 == 2){
		datatermino.setDate(datatermino.getDate()+(inter_int*7*(ocorrencias - 1)));
	}else if(escala1 == 3){
		datatermino.setMonth(datatermino.getMonth()+(inter_int*(ocorrencias - 1)));
	}else if(escala1 == 4){
		datatermino.setFullYear(datatermino.getFullYear()+(inter_int*(ocorrencias - 1)));
	}		
	
	var dataterminoedit = datatermino.toLocaleDateString();
	//console.log('DataTermino : ' + dataterminoedit);
	$('#DataTermino').val(dataterminoedit);	
	
}

function exibirentrega() {
		$('.Exibir_Troco').hide();
		$('.Exibir').hide();
		$('.QtdSoma').hide();
		$('.FormaPag').hide();
		$('.Liga').show();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').show();
		$('.Calcular').show();
		$('.Recalcular').hide();		
}

function formaPag(formapag){
	//alert('teste FormaPag');
	//console.log(formapag);
	if(formapag == "P"){
		$('.FormaPag').show();
	}else{
		$('.FormaPag').hide();
	}
}

function exibirTroco(pagocom){
	//alert('teste');
	//console.log(pagocom);
	if(pagocom){
		//console.log('pagocom = '+pagocom);
		if(pagocom == "7"){
			$('.Exibir_Troco').show();
		}else{
			$('.Exibir_Troco').hide();
		}
	}else{
		var formpag = $('#FormaPagamento').val();
		//console.log('formpag = '+formpag);
		if(formpag == "7"){
			$('.Exibir_Troco').show();
		}else{
			$('.Exibir_Troco').hide();
		}
	}
}

function tipoFrete(tipofrete){
	var RecarregaCepDestino = $('#RecarregaCepDestino').val();
	var RecarregaLogradouro = $('#RecarregaLogradouro').val();
	var RecarregaNumero = $('#RecarregaNumero').val();
	var RecarregaComplemento = $('#RecarregaComplemento').val();
	var RecarregaBairro = $('#RecarregaBairro').val();
	var RecarregaCidade = $('#RecarregaCidade').val();
	var RecarregaEstado = $('#RecarregaEstado').val();

	if(tipofrete == "1"){
		$('.Liga').show();
		$('.Desliga').hide();
		$('.Correios').hide();
		$('.Combinar').hide();
		$('.Retirada').show();
		$('.finalizar').show();			
		$('#Cep').val('00000000');
		$('#CepDestino').val(RecarregaCepDestino);
		$('#Logradouro').val(RecarregaLogradouro);
		$('#Numero').val(RecarregaNumero);
		$('#Complemento').val(RecarregaComplemento);
		$('#Bairro').val(RecarregaBairro);
		$('#Cidade').val(RecarregaCidade);
		$('#Estado').val(RecarregaEstado);
		$('#valorfrete').val('0.00');
		$('#prazoentrega').val('0');
		
	}		

	if(tipofrete == "2"){
		$('.Liga').hide();
		$('.Desliga').show();
		$('.Correios').hide();
		$('.Combinar').show();
		$('.Retirada').hide();
		$('.finalizar').show();			
		$('#Cep').val('00000000');
		$('#CepDestino').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#valorfrete').val('0.00');
		$('#prazoentrega').val('0');			
	}
	
	if(tipofrete == "3"){
		$('.Liga').hide();
		$('.Desliga').show();
		$('.Correios').show();
		$('.Combinar').hide();
		$('.Retirada').hide();
		$('.Calcular').show();
		$('.Recalcular').hide();			
		$('.finalizar').hide();
		$('#Cep').val('');
		$('#CepDestino').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#valorfrete').val('');
		$('#prazoentrega').val('');
		$('#valor_total').val('');
		$('#msg').html('');
	}		

}

function comentrega(valor2) {
	
	//console.log('valor2 = '+valor2);
	
	var id_Cliente = $('#idApp_Cliente').val();
	//console.log('id_Cliente = '+id_Cliente);

	var tipofrete = $('#ValorTipoFrete').val();
	//console.log('tipofrete = '+tipofrete);
	
	$('#Hidden_Entrega_Orca').val(valor2);	
	
	if(valor2 == 'S'){
	
		if(id_Cliente && id_Cliente!=0 && id_Cliente!= ''){
			buscaEnderecoCliente(id_Cliente);
		}else{
			$('#Cep').val('');
			$('#Logradouro').val('');
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val('');
			$('#Cidade').val('');
			$('#Estado').val('');
			$('#Referencia').val('');
			$('#ValorFrete').val('0,00');
			calculaTotal();
		}
		
	}else{
		$('#Cep').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#Referencia').val('');
		$('#ValorFrete').val('0,00');
		calculaTotal();
	}
}

function comentrega_for(valor2) {
	
	//console.log('valor2 = '+valor2);
	
	var id_Fornecedor = $('#idApp_Fornecedor').val();
	//console.log('id_Fornecedor = '+id_Fornecedor);

	var tipofrete = $('#ValorTipoFrete').val();
	//console.log('tipofrete = '+tipofrete);
	
	$('#Hidden_Entrega_Orca').val(valor2);	
	
	if(valor2 == 'S'){
	
		if(id_Fornecedor && id_Fornecedor!=0 && id_Fornecedor!= ''){
			buscaEnderecoFornecedor(id_Fornecedor);
		}else{
			$('#Cep').val('');
			$('#Logradouro').val('');
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val('');
			$('#Cidade').val('');
			$('#Estado').val('');
			$('#Referencia').val('');
			$('#ValorFrete').val('0,00');
			calculaTotal();
		}
		
	}else{
		$('#Cep').val('');
		$('#Logradouro').val('');
		$('#Numero').val('');
		$('#Complemento').val('');
		$('#Bairro').val('');
		$('#Cidade').val('');
		$('#Estado').val('');
		$('#Referencia').val('');
		$('#ValorFrete').val('0,00');
		calculaTotal();
	}
}

function buscaEnderecoCliente(id) {
	//console.log(id);
	//exit();
    $.ajax({

		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=100&idCliente=' + id,
        //url: window.location.origin+ '/' + app + '/EnderecoCliente_json.php?q=100&idCliente=' + id,
		// dataType json
        dataType: "json",
		//method:'get',
        // fun��o para de sucesso
        success: function (data) {
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {
					//console.log( data[i].enderecocliente);
					$('#Cep').val(data[i].cepcliente);
                    $('#Logradouro').val(data[i].enderecocliente);
					$('#Numero').val(data[i].numerocliente);
					$('#Complemento').val(data[i].complementocliente);
					$('#Bairro').val(data[i].bairrocliente);
					$('#Cidade').val(data[i].municipiocliente);
					$('#Estado').val(data[i].estadocliente);
					$('#Referencia').val(data[i].referenciacliente);
                    break;
                }

            }//fim do la�o
		}
		
    });//termina o ajax
	
}

function buscaEnderecoFornecedor(id) {
	//console.log(id);
	//exit();
    $.ajax({

		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=110&idFornecedor=' + id,
		// dataType json
        dataType: "json",
		//method:'get',
        // fun��o para de sucesso
        success: function (data) {
            for (i = 0; i < data.length; i++) {

                if (data[i].id == id) {
					//console.log( data[i].enderecofornecedor);
					$('#Cep').val(data[i].cepfornecedor);
                    $('#Logradouro').val(data[i].enderecofornecedor);
					$('#Numero').val(data[i].numerofornecedor);
					$('#Complemento').val(data[i].complementofornecedor);
					$('#Bairro').val(data[i].bairrofornecedor);
					$('#Cidade').val(data[i].municipiofornecedor);
					$('#Estado').val(data[i].estadofornecedor);
					$('#Referencia').val(data[i].referenciafornecedor);
                    break;
                }

            }//fim do la�o
		}
		
    });//termina o ajax
	
}

function dateDiff() {
	
	var dataorca = $('#DataOrca').val();
	var dataentregaorca = $('#DataEntregaOrca').val();
	
	// Digamos que este � o formato das suas datas
	// data = '30/03/2019';
	// Precisamos quebrar a string para retornar cada parte
	const dataorcaSplit = dataorca.split('/');

	const day = dataorcaSplit[0]; 
	const month = dataorcaSplit[1];
	const year = dataorcaSplit[2];
	
	const dataentregaorcaSplit = dataentregaorca.split('/');

	const day2 = dataentregaorcaSplit[0]; 
	const month2 = dataentregaorcaSplit[1]; 
	const year2 = dataentregaorcaSplit[2]; 

// Agora podemos inicializar o objeto Date, lembrando que o m�s come�a em 0, ent�o fazemos -1.
	dataorca = new Date(year, month - 1, day);
	dataentregaorca = new Date(year2, month2 - 1, day2);
	
	const now = new Date(); // Data de hoje
	const past = dataorca; // Outra data no passado
	const past2 = dataentregaorca; // Outra data no passado
	const diff = Math.abs(past2.getTime() - past.getTime()); // Subtrai uma data pela outra
	const days = Math.ceil(diff / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).

	// Mostra a diferen�a em dias
	//console.log('Prazo de entrega: ' + days + ' dias');	
	$('#PrazoEntrega').val(days);
}

function valorTipoFrete(valor, nome) {
	//alert('valorTipoFrete - funcionando');
	var caminho = $('#Caminho').val();
	var taxaentrega = $('#TaxaEntrega').val();
	var taxaentrega1 = taxaentrega.replace('.',',');
	//console.log(taxaentrega1 + ' TaxaEntrega');
	//console.log(caminho + ' Caminho valorTipoFrete');
	//console.log(valor + ' Tipo de entrega');
	$('#ValorTipoFrete').val(valor);
	if(valor == 1){
		$('#PrazoCorreios').val('0');
		$('#ValorFrete').val('0,00');
	}else if(valor == 2){
		$('#PrazoCorreios').val('0');
		$('#ValorFrete').val(taxaentrega1);
	}
	calculaPrazoEntrega();
	calculaTotal();
	//calculaTroco();
	//calculaParcelas();
}

function Procuraendereco() {
	//alert('Procuraendereco - funcionando');
	
	var tipofrete=$('#ValorTipoFrete').val();
	var Dados=$(this).serialize();
	var CepDestino=$('#Cep').val();
	var CepOrigem=$('#CepOrigem').val();
	//console.log(tipofrete + ' Tipo de entrega');
	$.ajax({
		url: 'https://viacep.com.br/ws/'+CepDestino+'/json/',
		method:'get',
		dataType:'json',
		data: Dados,
		success:function(Dados){
			//console.log(Dados);
			$('.ResultCep').html('').append('<div>'+Dados.logradouro+','+Dados.bairro+'-'+Dados.localidade+'-'+Dados.uf+'</div>');			
			//$('#Cep').val(CepDestino);
			$('#Logradouro').val(Dados.logradouro);
			$('#Numero').val('');
			$('#Complemento').val('');
			$('#Bairro').val(Dados.bairro);
			$('#Cidade').val(Dados.localidade);
			$('#Estado').val(Dados.uf);
			$('#Referencia').val('');
	
			if(tipofrete == 3){
				LoadFrete();
			}		
		
		},
		error:function(Dados){
			alert('Cep n�o encontrado. Confira o Cep e Tente Novamente');
			$('#Cep').val(CepDestino);
		}
	});
	
}

/*Atualiza o Prazo de Entrega do Correios e o valor do frete no Orcatrata */
function LoadFrete() {
	//var caminho = '../';
	var caminho = $('#Caminho').val();
	//console.log(caminho + ' Caminho LoadFrete');
	
	var prazo_prodserv = $('#PrazoProdServ').val();
	var dataorca = $('#DataOrca').val();
		const dataorcaSplit = dataorca.split('/');
		const day = dataorcaSplit[0]; 
		const month = dataorcaSplit[1];
		const year = dataorcaSplit[2];
	var datapedido = new Date(year, month - 1, day);
	var TotalOrca = $('#ValorRestanteOrca').val();
	var CepDestino = $('#Cep').val();
	var CepOrigem = $('#CepOrigem').val();
	var Peso = $('#Peso').val();
	var Formato = $('#Formato').val();
	var Comprimento = $('#Comprimento').val();
	var Altura = $('#Altura').val();
	var Largura = $('#Largura').val();
	var MaoPropria = $('#MaoPropria').val();
	var ValorDeclarado = $('#ValorDeclarado').val();
	var AvisoRecebimento = $('#AvisoRecebimento').val();
	var Codigo = $('#Codigo').val();
	var Diametro = $('#Diametro').val();

	$.ajax({
		//url: caminho + 'calcula-frete_model.php',
		//url: '../calcula-frete_model.php',
		url: window.location.origin+ '/' + app + '/calcula-frete_model.php',
		type:'POST',
		dataType:'html',
		cache: false,
		data: {CepDestino: CepDestino, 
				CepOrigem: CepOrigem, 
				Peso: Peso, 
				Formato: Formato,
				Comprimento: Comprimento,
				Altura: Altura,
				Largura: Largura,
				MaoPropria: MaoPropria,
				ValorDeclarado: ValorDeclarado,
				AvisoRecebimento: AvisoRecebimento,
				Codigo: Codigo,
				Diametro: Diametro},
		success:function(data){
			//console.log(data);
			$('.ResultadoPrecoPrazo').html(data);
			
			var prazo_correios = $('#prazo_correios').val();
			
			var prazo_entrega =  -(-prazo_prodserv -prazo_correios);
			$('#PrazoCorreios').val(prazo_correios);
			$('#PrazoEntrega').val(prazo_entrega);
			
			//console.log(prazo_prodserv);
			//console.log(prazo_correios);
			//console.log(prazo_entrega);
			
			var valor_frete2 = $('#valor_frete').val();
			$('#ValorFrete').val(valor_frete2);
			
			var valor_orca3 	= TotalOrca.replace(',','.');
			
			var valor_frete3 	= valor_frete2.replace(',','.');
			
			var totalpedido	= parseFloat(valor_frete3) + parseFloat(valor_orca3);
			
			var totalpedido2	= totalpedido.toFixed(2);
			
			var totalpedido3 = totalpedido2.replace('.',',');
			$('#ValorTotalOrca').val(totalpedido3);
			
			//var d = new Date();
			var d = new Date(datapedido);
			var data_entrega    = new Date(d.getTime() + (prazo_entrega * 24 * 60 * 60 * 1000));
			
			var mes = (data_entrega.getMonth() + 1);
			if(mes < 10){
				var novo_mes = "0" + mes;
			}else{
				var novo_mes = mes;
			}
			
			var dia = (data_entrega.getDate());
			if(dia < 10){
				var novo_dia = "0" + dia;
			}else{
				var novo_dia = dia;
			}
			
			var data_aparente = novo_dia + "/" + novo_mes + "/" + data_entrega.getFullYear();
			$('#DataEntregaOrca').val(data_aparente);

			if(valor_frete > "0.00"){
				$('#msg').html('<p style="color: green">C�lculo realizada com Sucesso!!</p>');
				$('.finalizar').show();
			}else{
				$('#msg').html('<p style="color: #FF0000">Erro ao realizar o C�lculo!!</p>');
				$('.finalizar').hide();
				//window.location = 'entrega.php';
			}
			
			calculaTotal();
			//calculaTroco();
			//calculaParcelas();
			
			$('#Cep').val(CepDestino);
			
		}, beforeSend: function(){
		
		}, error: function(jqXHR, textStatus, errorThrown){
			//console.log('Erro');
			$('#msg').html('<p style="color: #FF0000">Erro ao realizar o C�lculo!!</p>');
			//window.location = 'entrega.php';
			alert('Erro ao calcular. Confirme o Cep e Tente Novamente');
			$('#Cep').val(CepDestino);
			
		}
	});
	
}

/*Atualiza o Prazo de Entrega dos Produtos no Orcatrata (campo = PrazoProduto, soma = QtdSoma, somaproduto = ProdutoSoma)*/
function calculaPrazoProdutos(campo, soma, somaproduto, excluir, produtonum, countmax, adicionar, hidden) {
	//alert('calculaPrazoProdutos');
	prazoprodutos = 0;
    i = j = 1;

    if(excluir == 1){
        for(k=0; k<$("#"+countmax).val(); k++) {
            /*
            if(($("#"+hidden+i).val()))
                console.log('>> existe '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            else
                console.log('>> n�o '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            */
            if(i != produtonum && ($("#"+campo+i).val())) {
                prazoproduto = parseInt($("#"+campo+i).val());
				//console.log(prazoproduto + ' - Prazo de cada produto');
				if(prazoproduto >= prazoprodutos){
					prazoprodutos = prazoproduto;
				}else{
					prazoprodutos = prazoprodutos;
				}
				j++;
            }
            i++;
        }
    }
    else {
        if(adicionar)
            $("#"+countmax).val((parseInt($("#"+countmax).val())+1));

        for(k=1; k<=$("#"+countmax).val(); k++) {
            if($("#"+campo+k).val()) {
                prazoproduto = parseInt($("#"+campo+k).val());
				//console.log(prazoproduto + ' - Prazo de cada produto');
				if(prazoproduto >= prazoprodutos){
					prazoprodutos = prazoproduto;
				}else{
					prazoprodutos = prazoprodutos;
				}
				j++;
            }
            //j++;
        }
    }
	
	//console.log(prazoprodutos + ' - Prazo Total dos produtos');

	$("#PrazoProdutos").val(prazoprodutos);
	
    //console.log('>> ' + $("#PrazoProdutos").val());
	
	if(prazoprodutos >= 1){
		$('.PrazoProdutos').show();
	}else{
		$('.PrazoProdutos').hide();
	}
	
	calculaOrcamento();
	//break;
}

/*Atualiza o Prazo de Entrega dos Servi�os no Orcatrata (campo = PrazoServico, soma = QtdSoma, somaproduto = ServicoSoma)*/
function calculaPrazoServicos(campo, soma, somaproduto, excluir, produtonum, countmax, adicionar, hidden) {
	//alert('calculaPrazoServicos');
	prazoservicos = 0;
    i = j = 1;

    if(excluir == 1){
        for(k=0; k<$("#"+countmax).val(); k++) {
            /*
            if(($("#"+hidden+i).val()))
                console.log('>> existe '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            else
                console.log('>> n�o '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            */
            if(i != produtonum && ($("#"+campo+i).val())) {
                prazoservico = parseInt($("#"+campo+i).val());
				//console.log(prazoservico + ' - Prazo de cada produto');
				if(prazoservico >= prazoservicos){
					prazoservicos = prazoservico;
				}else{
					prazoservicos = prazoservicos;
				}
				j++;
            }
            i++;
        }
    }
    else {
        if(adicionar)
            $("#"+countmax).val((parseInt($("#"+countmax).val())+1));

        for(k=1; k<=$("#"+countmax).val(); k++) {
            if($("#"+campo+k).val()) {
                prazoservico = parseInt($("#"+campo+k).val());
				//console.log(prazoservico + ' - Prazo de cada produto');
				if(prazoservico >= prazoservicos){
					prazoservicos = prazoservico;
				}else{
					prazoservicos = prazoservicos;
				}
				j++;
            }
            //j++;
        }
    }
	
	//console.log(prazoservicos + ' - Prazo Total dos servicos');

	$("#PrazoServicos").val(prazoservicos);
	
    //console.log('>> ' + $("#PrazoServicos").val());
	
	if(prazoservicos >= 1){
		$('.PrazoServicos').show();
	}else{
		$('.PrazoServicos').hide();
	}
	
	calculaOrcamento();
	//break;	
}

/*Atualiza o Prazo de Entrega Total no Orcatrata */
function calculaPrazoEntrega() {
	//alert('calculaPrazoEntrega');
	
	var prazo_prodserv = $('#PrazoProdServ').val();	
	if($('#PrazoCorreios').val()){
		var prazo_correios = $('#PrazoCorreios').val();
	}else{
		var prazo_correios = 0;
	}
	
	var prazo_entrega =  -(-prazo_prodserv -prazo_correios);
	
	$('#PrazoEntrega').val(prazo_entrega);

	var dataorca = $('#DataOrca').val();
		const dataorcaSplit = dataorca.split('/');
		const day = dataorcaSplit[0]; 
		const month = dataorcaSplit[1];
		const year = dataorcaSplit[2];
	var datapedido = new Date(year, month - 1, day);
	
	//var d = new Date();
	var d = new Date(datapedido);
	var data_entrega    = new Date(d.getTime() + (prazo_entrega * 24 * 60 * 60 * 1000));
	
	var mes = (data_entrega.getMonth() + 1);
	if(mes < 10){
		var novo_mes = "0" + mes;
	}else{
		var novo_mes = mes;
	}
	
	var dia = (data_entrega.getDate());
	if(dia < 10){
		var novo_dia = "0" + dia;
	}else{
		var novo_dia = dia;
	}
	
	var data_aparente = novo_dia + "/" + novo_mes + "/" + data_entrega.getFullYear();
	$('#DataEntregaOrca').val(data_aparente);	
	
	
}

//Fun��o que desabilita os campos n�o disponiveis.
function camposDisponiveis () {
	$('.campos').hide();
	//document.getElementById('campos').style.display = "none";
	
}

//vari�vel de op��es necess�ria para o funcionamento do datepiker em divs
//geradas dinamicamente
var dateTimePickerOptions = {
    tooltips: {
        today: 'Hoje',
        clear: 'Limpar sele��o',
        close: 'Fechar este menu',
        selectMonth: 'Selecione um m�s',
        prevMonth: 'M�s anterior',
        nextMonth: 'Pr�ximo m�s',
        selectYear: 'Selecione um ano',
        prevYear: 'Ano anterior',
        nextYear: 'Pr�ximo ano',
        selectDecade: 'Selecione uma d�cada',
        prevDecade: 'D�cada anterior',
        nextDecade: 'Pr�xima d�cada',
        prevCentury: 'Centen�rio anterior',
        nextCentury: 'Pr�ximo centen�rio',
        incrementHour: 'Aumentar hora',
        decrementHour: 'Diminuir hora',
        incrementMinute: 'Aumentar minutos',
        decrementMinute: 'Diminuir minutos',
        incrementSecond: 'Aumentar segundos',
        decrementSecond: 'Diminuir segundos'
    },
    showTodayButton: true,
    showClose: true,
    format: 'DD/MM/YYYY',
    //minDate: moment(m + '/' + d + '/' + y),
    locale: 'pt-br'
}

//Fun��o que desabilita o bot�o submit ap�s 1 click, evitando mais de um envio de formul�rio.
function DesabilitaBotao (valor) {
	$('.aguardar').show();
	$('.exibir').hide();
	//document.getElementById('aguardar').style.display = "";
    if (valor) {
        document.getElementById('submeter').style.display = "none";
		document.getElementById('submeter2').style.display = "none";
		document.getElementById('submeter5').style.display = "none";
		document.getElementById('submeter6').style.display = "none";
		document.getElementById('submeter7').style.display = "none";
		document.getElementById('submeter8').style.display = "none";
        document.getElementById('aguardar').style.display = "";		
    }
    else {
        document.getElementById('submeter').style.display = "";
		document.getElementById('submeter2').style.display = "";
		document.getElementById('submeter5').style.display = "";
		document.getElementById('submeter6').style.display = "";
		document.getElementById('submeter7').style.display = "";
		document.getElementById('submeter8').style.display = "";
        document.getElementById('aguardar').style.display = "none";
    }
}

function DesabilitaBotaoExcluir (valor) {
    $('.aguardar').hide();
	$('.exibir').show();
    if (valor) {
        document.getElementById('submeter').style.display = "none";
		document.getElementById('submeter2').style.display = "none";
		document.getElementById('submeter3').style.display = "none";
		document.getElementById('submeter4').style.display = "none";
		document.getElementById('submeter5').style.display = "none";
		document.getElementById('submeter6').style.display = "none";
		document.getElementById('submeter7').style.display = "none";
		document.getElementById('submeter8').style.display = "none";
        document.getElementById('aguardar').style.display = "";
    }
    else {
        document.getElementById('submeter').style.display = "";
		document.getElementById('submeter2').style.display = "";
		document.getElementById('submeter3').style.display = "";
		document.getElementById('submeter4').style.display = "";
		document.getElementById('submeter5').style.display = "";
		document.getElementById('submeter6').style.display = "";
		document.getElementById('submeter7').style.display = "";
		document.getElementById('submeter8').style.display = "";
        document.getElementById('aguardar').style.display = "none";
    }
}

/*Atualiza o somat�rio do Qtd de Produtos no Orcatrata*/
function calculaQtdSoma(campo, soma, somaproduto, excluir, produtonum, countmax, adicionar, hidden) {

    qtdsoma = 0;
    i = j = 1;

    if(excluir == 1){
        for(k=0; k<$("#"+countmax).val(); k++) {
            /*
            if(($("#"+hidden+i).val()))
                console.log('>> existe '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            else
                console.log('>> n�o '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            */
            if(i != produtonum && ($("#"+campo+i).val())) {
                qtdsoma += parseInt($("#"+campo+i).val());
                j++;
            }
            i++;
        }
    }
    else {
        if(adicionar)
            $("#"+countmax).val((parseInt($("#"+countmax).val())+1));

        for(k=1; k<=$("#"+countmax).val(); k++) {
            if($("#"+campo+k).val()) {
                qtdsoma += parseInt($("#"+campo+k).val());
                j++;
            }
            //j++;
        }
    }

	$("#"+soma).html(qtdsoma);
    $("#"+somaproduto).html(j-1);
    //console.log('>> ' + qtdsoma);
	
	if(qtdsoma >= 1){
		$('.QtdSoma').show();
	}else{
		$('.QtdSoma').hide();
	}
}

/*Atualiza o somat�rio do Qtd Servi�os no Orcatrata*/
function calculaQtdSomaDev(campo, soma, somaproduto, excluir, produtonum, countmax, adicionar, hidden) {

    qtdsoma = 0;
    i = j = 1;

    if(excluir == 1){
        for(k=0; k<$("#"+countmax).val(); k++) {
            /*
            if(($("#"+hidden+i).val()))
                console.log('>> existe '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            else
                console.log('>> n�o '+$("#"+campo+i).val()+' <> '+hidden+' <> '+produtonum+' <> '+$("#"+somaproduto).html()+' <<>> '+i+' '+k);
            */
            if(i != produtonum && ($("#"+campo+i).val())) {
                qtdsoma += parseInt($("#"+campo+i).val());
                j++;
            }
            i++;
        }
    }
    else {
        if(adicionar)
            $("#"+countmax).val((parseInt($("#"+countmax).val())+1));

        for(k=1; k<=$("#"+countmax).val(); k++) {
            if($("#"+campo+k).val()) {
                qtdsoma += parseInt($("#"+campo+k).val());
                j++;
            }
            //j++;
        }
    }

    $("#"+soma).html(qtdsoma);
    $("#"+somaproduto).html(j-1);
    //console.log('>> ' + qtdsoma);

}

/*
 * Fun��o respons�vel por carregar valores nos respectivos campos do orcatrata
 * caso o bot�o Quitado seja alterado para SIM
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */

 /*Carrega a Data do Dia do lan�amento*/
 function carregaQuitado3(value, name, i, cadastrar = 0) {

    if (value == "S") {


        if (!$("#DataProcedimento"+i).val()) {
            if (cadastrar == 1)
                $("#DataProcedimento"+i).val($("#DataProcedimentoCli"+i).val())
            else
                $("#DataProcedimento"+i).val(currentDate.format('DD/MM/YYYY'))
        }


    }
    else {

        $("#DataProcedimento"+i).val("")

    }

}

 /*Carrega a Data do Dia do lan�amento*/
 function carregaQuitado2(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#ValorPago"+i).val() || $("#ValorPago"+i).val() == "0,00")
            $("#ValorPago"+i).val($("#ValorParcela"+i).val())

        if (!$("#DataPago"+i).val()) {
            if (cadastrar == 1){
				$("#DataPago"+i).val($("#DataVencimento"+i).val());
			}else if(cadastrar == 2){
				$("#DataPago"+i).val("");
			}else{
				$("#DataPago"+i).val(currentDate.format('DD/MM/YYYY'));
			}
                
        }


    }
    else {

        $("#ValorPago"+i).val("")
        $("#DataPago"+i).val("")

    }

}

/*Carrega a Data do Dia do Vencimento*/
function carregaQuitado(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#ValorPago"+i).val() || $("#ValorPago"+i).val() == "0,00")
            $("#ValorPago"+i).val($("#ValorParcela"+i).val())

		if (!$("#DataPago"+i).val()) {
            if (cadastrar == 1)
                $("#DataPago"+i).val($("#DataVencimento"+i).val())
            else
                $("#DataPago"+i).val($("#DataVencimento"+i).val())
        }

    }
    else {

        $("#ValorPago"+i).val("")
        $("#DataPago"+i).val("")

    }

}

 /*Carrega a Data e Hora da Entrega do Produto*/
 function carregaEntreguePrd(value, name, i, cadastrar = 0) {
	/*
    if (value == "S") {
		
        if (!$("#DataConcluidoProduto"+i).val() || !$("#HoraConcluidoProduto"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoProduto"+i).val("");
				$("#HoraConcluidoProduto"+i).val("");
			}else{
				$("#DataConcluidoProduto"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoProduto"+i).val(currentDate.format('HH:mm'));
			}  
        }
		
    }else{
		
        $("#DataConcluidoProduto"+i).val("");
        $("#HoraConcluidoProduto"+i).val("");
		
    }
	*/
}

 /*Carrega a Data e Hora da Entrega do Servi�o*/
 function carregaEntregueSrv(value, name, i, cadastrar = 0) {
	/*
    if (value == "S") {

        if (!$("#DataConcluidoServico"+i).val() || !$("#HoraConcluidoServico"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoServico"+i).val("");
				$("#HoraConcluidoServico"+i).val("");
			}else{
				$("#DataConcluidoServico"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoServico"+i).val(currentDate.format('HH:mm'));
			}    
        }
    }else {
        $("#DataConcluidoServico"+i).val("");
        $("#HoraConcluidoServico"+i).val("");
    }
	*/
}

 /*Carrega a Data e Hora da Conclus�o da Tarefa*/
 function carregaConcluido(value, name, cadastrar = 0) {
    if (value == "S") {
		if (cadastrar == 1){
			$("#DataConcluidoProcedimento").val($("#DataProcedimento").val());
			$("#HoraConcluidoProcedimento").val($("#HoraProcedimento").val());
		}else{
			$("#DataConcluidoProcedimento").val(currentDate.format('DD/MM/YYYY'));
			$("#HoraConcluidoProcedimento").val(currentDate.format('HH:mm'));
		}
    }else{
        $("#DataConcluidoProcedimento").val("");
        $("#HoraConcluidoProcedimento").val("");
    }
	
}

 /*Carrega a Data e Hora da Conclus�o do procedimento*/
 function carregaConclProc(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#DataConcluidoProcedimento"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoProcedimento"+i).val($("#DataProcedimento"+i).val());
				$("#HoraConcluidoProcedimento"+i).val($("#HoraProcedimento"+i).val());
			}else{
				$("#DataConcluidoProcedimento"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoProcedimento"+i).val(currentDate.format('HH:mm'));
			}  
        }
    }else{
        $("#DataConcluidoProcedimento"+i).val("");
        $("#HoraConcluidoProcedimento"+i).val("");
    }
	
}

 /*Carrega a Data e Hora da Conclus�o do procedimento*/
 function carregaAtivoFuncao(value, name, i, cadastrar = 0) {
	//alert('carregando');
	/*
    if (value == "S") {

        if (!$("#DataConcluidoProcedimento"+i).val()) {
            if (cadastrar == 1){
				$("#DataConcluidoProcedimento"+i).val($("#DataProcedimento"+i).val());
				$("#HoraConcluidoProcedimento"+i).val($("#HoraProcedimento"+i).val());
			}else{
				$("#DataConcluidoProcedimento"+i).val(currentDate.format('DD/MM/YYYY'));
				$("#HoraConcluidoProcedimento"+i).val(currentDate.format('HH:mm'));
			}  
        }
    }else{
		
        $("#DataConcluidoProcedimento"+i).val("");
        $("#HoraConcluidoProcedimento"+i).val("");
		
    }
	*/
}

 /*Carrega a Data e Hora da Entrega do Produto*/
 function carregaConclSubProc(value, name, i, cadastrar = 0) {

    if (value == "S") {
		if (cadastrar == 1){
			$("#DataConcluidoSubProcedimento"+i).val($("#DataSubProcedimento"+i).val());
			$("#HoraConcluidoSubProcedimento"+i).val($("#HoraSubProcedimento"+i).val());
		}else{
			$("#DataConcluidoSubProcedimento"+i).val(currentDate.format('DD/MM/YYYY'));
			$("#HoraConcluidoSubProcedimento"+i).val(currentDate.format('HH:mm'));
		}
    }else{
        $("#DataConcluidoSubProcedimento"+i).val("");
        $("#HoraConcluidoSubProcedimento"+i).val("");
    }
	
}

 /*Carrega a Data e Hora da Entrega do Produto*/
 function carregaDataPagoComissaoOrca(value, name, i, cadastrar = 0) {

    if (value == "S") {

        if (!$("#DataPagoComissaoOrca"+i).val()) {
            if (cadastrar == 1){
				$("#DataPagoComissaoOrca"+i).val("")
			}else{
				$("#DataPagoComissaoOrca"+i).val(currentDate.format('DD/MM/YYYY'));
			}  
        }
    }else{
        $("#DataPagoComissaoOrca"+i).val("");
    }
	
}
/*
 * Fun��o respons�vel por aplicar a m�scara de valor real com separa��o de
 * decimais e milhares.
 *
 * @param {float} value
 * @returns {decimal}
 */
function mascaraValorReal(value) {

    var r;

    r = value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    r = r.replace(/[,.]/g, function (m) {
        // m is the match found in the string
        // If `,` is matched return `.`, if `.` matched return `,`
        return m === ',' ? '.' : ',';
    });

    return r;

}

function buscaValor1Tabelas(id, campo, tabela, num, campo2, recorrencias) {
	//console.log('recorrencia no busca valor = ' +recorrencias);
    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor1_json.php?tabela=" + tabela + "&campo2=" + campo2 + "&recorrencias=" + recorrencias,
        // dataType json
        dataType: "json",
        // fun��o para de sucesso
        success: function (data) {

            // executo este la�o para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {
				if (id) {
					if (data[i].id == id) {
						$('#Escrever'+campo2+num).css("display","");
						$('#Entregue'+campo2+num).css("display","");
						//""ou posso usar assim, passando diretamente o qtdinc do id ""
						$('#Nome'+campo2+num).val(data[i].nomeprod);
						$('#Comissao'+campo2+num).val(data[i].comissaoprod);
						$('#ComissaoServico'+campo2+num).val(data[i].comissaoservico);
						$('#ComissaoCashBack'+campo2+num).val(data[i].comissaocashback);
						$('#Prazo'+campo2+num).val(data[i].prazoprod);
						$('#QtdIncremento'+campo2+num).val(data[i].qtdinc);
						$('#Qtd'+campo2+num).val(data[i].qtdprod);
						$('#idTab_Produtos_'+campo2+num).val(data[i].id_produto);
						$('#Prod_Serv_'+campo2+num).val(data[i].prod_serv);
						$('#idTab_Valor_'+campo2+num).val(data[i].id_valor);
						//$('#DataConcluido'+campo2+num).val(currentDate.format('DD/MM/YYYY'));
						//$('#HoraConcluido'+campo2+num).val(currentDate.format('HH:mm'));
						$('#DataConcluido'+campo2+num).val("");
						$('#HoraConcluido'+campo2+num).val("");
						//console.log( data[i].comissaoprod +' valor da comiss�o da venda');
						//console.log( data[i].comissaoservico +' valor da comiss�o do servico');
						//console.log( data[i].comissaocashback +' valor da comiss�o do cash');
						//carrega o valor no campo de acordo com a op��o selecionada
						$('#'+campo).val(data[i].valor);

						//if (tabela == area && $("#Qtd"+tabela+num).val()) {
						if ($("#Qtd"+campo2+num).val()) {
							calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val(),$("#ComissaoServico"+campo2+num).val(),$("#ComissaoCashBack"+campo2+num).val());
							break;
						}

						//para cada valor carregado o or�amento � calculado/atualizado
						//atrav�s da chamada de sua fun��o
						calculaOrcamento();
						break;
					}
				}else{
					$('#Escrever'+campo2+num).css("display","none");
					$('#Entregue'+campo2+num).css("display","none");
					//""ou posso usar assim, passando diretamente o qtdinc do id ""
					$('#Nome'+campo2+num).val("");
					$('#Comissao'+campo2+num).val("0");
					$('#ComissaoServico'+campo2+num).val("0");
					$('#ComissaoCashBack'+campo2+num).val("0");
					$('#QtdIncremento'+campo2+num).val("0");
					$('#Qtd'+campo2+num).val("0");
					$('#idTab_Produtos_'+campo2+num).val("0");
					$('#Prod_Serv_'+campo2+num).val("0");
					$('#idTab_Valor_'+campo2+num).val("0");
					$('#DataConcluido'+campo2+num).val("");
					$('#HoraConcluido'+campo2+num).val("");
					//console.log( data[i].comissaoprod +' valor da comiss�o da venda');
					//console.log( data[i].comissaoservico +' valor da comiss�o do servico');
					//console.log( data[i].comissaocashback +' valor da comiss�o do cash');
					//carrega o valor no campo de acordo com a op��o selecionada
					$('#'+campo).val("0");

					//if (tabela == area && $("#Qtd"+tabela+num).val()) {
					if ($("#Qtd"+campo2+num).val()) {
						calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val(),$("#ComissaoServico"+campo2+num).val(),$("#ComissaoCashBack"+campo2+num).val());
						break;
					}
				
					//para cada valor carregado o or�amento � calculado/atualizado
					//atrav�s da chamada de sua fun��o
					calculaOrcamento();
					break;
				}
				
				
            }//fim do la�o
        }
    });//termina o ajax

}

function buscaValor2Tabelas(id, campo, tabela, num, campo2) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor2_json.php?tabela=" + tabela + "&campo2=" + campo2,
        // dataType json
        dataType: "json",
        // fun��o para de sucesso
        success: function (data) {

            // executo este la�o para acessar os itens do objeto javaScript
            for (i = 0; i < data.length; i++) {
				if (id) {
					if (data[i].id == id) {
						$('#Escrever'+campo2+num).css("display","");
						$('#Entregue'+campo2+num).css("display","");
						//""ou posso usar assim, passando diretamente o qtdinc do id ""
						$('#Nome'+campo2+num).val(data[i].nomeprod);
						$('#idTab_Produtos_'+campo2+num).val(data[i].id_produto);
						$('#Prod_Serv_'+campo2+num).val(data[i].prod_serv);
						$('#Comissao'+campo2+num).val(data[i].comissaoprod);
						$('#ComissaoServico'+campo2+num).val(data[i].comissaoservico);
						$('#ComissaoCashBack'+campo2+num).val(data[i].comissaocashback);
						$('#DataConcluido'+campo2+num).val("");
						$('#HoraConcluido'+campo2+num).val("");
						//console.log( data[i].id_produto );
					
						//carrega o valor no campo de acordo com a op��o selecionada
						$('#'+campo).val(data[i].valor);

						//if (tabela == area && $("#Qtd"+tabela+num).val()) {
						if ($("#Qtd"+campo2+num).val()) {
							calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val(),$("#ComissaoServico"+campo2+num).val(),$("#ComissaoCashBack"+campo2+num).val());
							break;
						}

						//para cada valor carregado o or�amento � calculado/atualizado
						//atrav�s da chamada de sua fun��o
						calculaOrcamento();
						break;
					}
				}else{
					$('#Escrever'+campo2+num).css("display","none");
					$('#Entregue'+campo2+num).css("display","none");
					//""ou posso usar assim, passando diretamente o qtdinc do id ""
					$('#Nome'+campo2+num).val("");
					$('#Comissao'+campo2+num).val("0");
					$('#ComissaoServico'+campo2+num).val("0");
					$('#ComissaoCashBack'+campo2+num).val("0");
					$('#QtdIncremento'+campo2+num).val("0");
					$('#Qtd'+campo2+num).val("0");
					$('#idTab_Produtos_'+campo2+num).val("0");
					$('#Prod_Serv_'+campo2+num).val("0");
					$('#idTab_Valor_'+campo2+num).val("0");
					$('#DataConcluido'+campo2+num).val("");
					$('#HoraConcluido'+campo2+num).val("");
					//console.log( data[i].comissaoprod +' valor da comiss�o do produto');
					//carrega o valor no campo de acordo com a op��o selecionada
					$('#'+campo).val("0");

					//if (tabela == area && $("#Qtd"+tabela+num).val()) {
					if ($("#Qtd"+campo2+num).val()) {
						calculaSubtotal($("#idTab_"+campo2+num).val(),$("#Qtd"+campo2+num).val(),num,'OUTRO',campo2,$("#QtdIncremento"+campo2+num).val(),$("#Comissao"+campo2+num).val(),$("#ComissaoServico"+campo2+num).val(),$("#ComissaoCashBack"+campo2+num).val());
						break;
					}
				
					//para cada valor carregado o or�amento � calculado/atualizado
					//atrav�s da chamada de sua fun��o
					calculaOrcamento();
					break;
				}
            }//fim do la�o

        }
    });//termina o ajax


}

/*
 * Fun��o respons�vel por calcular o subtotal dos campos de produto
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */
function calculaSubtotal(valor, campo, num, tipo, tabela, qtdinc, comissao, comissaoservico, comissaocashback) {
	
	//console.log('venda -> '+comissao);
	//console.log('serv -> '+comissaoservico);
	//console.log('cash -> '+comissaocashback);
	//console.log(comissao.replace(",","."));
	//var comissaoprd = $("#Comissao"+tabela+num).val();
	//console.log(comissaoprd);
	//console.log(comissaoprd.replace(",","."));
    if (tipo == 'VP') {
        //vari�vel valor recebe o valor do produto selecionado
        var data = $("#Qtd"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var comissaoprd = $("#Comissao"+tabela+num).val();
		var comissaoserv = $("#ComissaoServico"+tabela+num).val();
		var comissaocash = $("#ComissaoCashBack"+tabela+num).val();
		//console.log(comissaoprd);
        //o subtotal � calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissaoprd / 100);
		var subtotalcomissaoservico = (subtotal * comissaoserv / 100);
		var subtotalcomissaocashback = (subtotal * comissaocash / 100);
		//console.log('Sub venda = '+subtotalcomissao);
		//console.log('Sub servico = '+subtotalcomissaoservico);
		//console.log('Sub cash = '+subtotalcomissaocashback);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * data.replace(".","").replace(",","."));
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else if (tipo == 'QTD') {
        //vari�vel quantidade recebe a quantidade do produto selecionado
        var data = $("#idTab_"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var comissaoprd = $("#Comissao"+tabela+num).val();
		var comissaoserv = $("#ComissaoServico"+tabela+num).val();
		var comissaocash = $("#ComissaoCashBack"+tabela+num).val();
		//console.log(comissaoprd);
		var qtdprd = $("#Qtd"+tabela+num).val();
        //o subtotal � calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissaoprd / 100);
		var subtotalcomissaoservico = (subtotal * comissaoserv / 100);
		var subtotalcomissaocashback = (subtotal * comissaocash / 100);
		//console.log('Sub venda = '+subtotalcomissao);
		//console.log('Sub servico = '+subtotalcomissaoservico);
		//console.log('Sub cash = '+subtotalcomissaocashback);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * qtdprd.replace(".","").replace(",","."));
	} else if (tipo == 'QTDINC') {
        //vari�vel quantidadeincremento recebe a quantidadeincremento do produto selecionado
        var data = $("#idTab_"+tabela+num).val();
		var qtdprdinc = $("#QtdIncremento"+tabela+num).val();
		var comissaoprd = $("#Comissao"+tabela+num).val();
		var comissaoserv = $("#ComissaoServico"+tabela+num).val();
		var comissaocash = $("#ComissaoCashBack"+tabela+num).val();
		//console.log(comissaoprd);
		var qtdprd = $("#Qtd"+tabela+num).val();
        //o subtotal � calculado como o produto da quantidade pelo seu valor
        var subtotal = (qtdprd * data.replace(".","").replace(",","."));
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissaoprd / 100);
		var subtotalcomissaoservico = (subtotal * comissaoserv / 100);
		var subtotalcomissaocashback = (subtotal * comissaocash / 100);
		//console.log('Sub venda = '+subtotalcomissao);
		//console.log('Sub servico = '+subtotalcomissaoservico);
		//console.log('Sub cash = '+subtotalcomissaocashback);
		var subtotalqtd = (qtdprdinc.replace(".","").replace(",",".") * qtdprd.replace(".","").replace(",","."));	
    } else {
		//o subtotal � calculado como o produto da quantidade pelo seu valor
		var subtotal = (valor.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
		//console.log(subtotal);
		var subtotalcomissao = (subtotal * comissao / 100);
		var subtotalcomissaoservico = (subtotal * comissaoservico / 100);
		var subtotalcomissaocashback = (subtotal * comissaocashback / 100);
		//console.log('Sub venda = '+subtotalcomissao);
		//console.log('Sub servico = '+subtotalcomissaoservico);
		//console.log('Sub cash = '+subtotalcomissaocashback);
		var subtotalqtd = (qtdinc.replace(".","").replace(",",".") * campo.replace(".","").replace(",","."));
    }

    subtotal 			= mascaraValorReal(subtotal);
	//subtotalcomissao 	= mascaraValorReal(subtotalcomissao);
	subtotalqtd1 		= subtotalqtd;
	
	subtotalcomissao	= parseFloat(subtotalcomissao);
	subtotalcomissao	= subtotalcomissao.toFixed(2);
	subtotalcomissao 	= subtotalcomissao.replace(',','.');	
	
	
	subtotalcomissaoservico	= parseFloat(subtotalcomissaoservico);
	subtotalcomissaoservico	= subtotalcomissaoservico.toFixed(2);
	subtotalcomissaoservico = subtotalcomissaoservico.replace(',','.');	
	
	subtotalcomissaocashback	= parseFloat(subtotalcomissaocashback);
	subtotalcomissaocashback	= subtotalcomissaocashback.toFixed(2);
	subtotalcomissaocashback 	= subtotalcomissaocashback.replace(',','.');
	
	//console.log('Sub venda = '+subtotalcomissao);
	//console.log('Sub servico = '+subtotalcomissaoservico);
	//console.log('Sub cash = '+subtotalcomissaocashback);	
	
	//console.log(subtotalqtd1 + ' - Quantidade do ' + tabela);
	//console.log(subtotal + ' - Subtotal do ' + tabela);
	//console.log(subtotalcomissao + ' - Subtotal da comiss�o do ' + tabela);
	
    //o subtotal � escrito no seu campo no formul�rio
    $('#Subtotal'+tabela+num).val(subtotal);
	$('#SubtotalComissao'+tabela+num).val(subtotalcomissao);
	$('#SubtotalComissaoServico'+tabela+num).val(subtotalcomissaoservico);
	$('#SubtotalComissaoCashBack'+tabela+num).val(subtotalcomissaocashback);
	$('#SubtotalQtd'+tabela+num).val(subtotalqtd1);

    //para cada vez que o subtotal for calculado o or�amento e o total restante
    //tamb�m ser�o atualizados
    calculaOrcamento();

}

/*
 * Fun��o respons�vel por calcular o or�amento total
 *
 * @returns {int}
 */
function calculaOrcamento() {

    //captura o n�mero incrementador do formul�rio, que controla quantos campos
    //foram acrescidos tanto para servi�os quanto para produtos
    var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    
	var subtotalservico = 0.00;
	var subtotalcomissaoservico = 0.00;
	var subtotalqtdservico = 0.00;
	var prazoservicos = 0.00;
	
	var subtotal = 0.00;
	var subtotalcomissao = 0.00;
	var subtotalqtd = 0.00;
	var prazoprodutos = 0.00;
	
    //vari�vel incrementadora
    var i = 0;
    //percorre todos os campos de servi�o, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos s�o ignorados
        if ($('#SubtotalServico'+i).val()){
            //subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));
            //subtotal -= parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));
			subtotalservico += parseFloat($('#SubtotalServico'+i).val().replace(".","").replace(",","."));
			subtotalcomissaoservico += parseFloat($('#SubtotalComissaoServico'+i).val());
			subtotalqtdservico += parseFloat($('#SubtotalQtdServico'+i).val().replace(".","").replace(",","."));
			
			prazoservico = parseFloat($('#PrazoServico'+i).val().replace(".","").replace(",","."));
			
			//console.log(prazoservico + ' - Prazo de cada servico');
			
			if(prazoservico >= prazoservicos){
				prazoservicos = prazoservico;
			}else{
				prazoservicos = prazoservicos;
			}
			//incrementa a vari�vel i
        }
		i++;
    }
	//console.log(subtotalcomissaoservico + ' - Total Comiss�o servico');
	//console.log(subtotalqtdservico + ' - Total Quantidade servico');
    //faz o mesmo que o la�o anterior mas agora para produtos
    var i = 0;
    while (i <= pc) {

        if ($('#SubtotalProduto'+i).val()){
            subtotal += parseFloat($('#SubtotalProduto'+i).val().replace(".","").replace(",","."));
			//subtotalcomissao += parseFloat($('#SubtotalComissaoProduto'+i).val().replace(".","").replace(",","."));
			subtotalcomissao += parseFloat($('#SubtotalComissaoProduto'+i).val());
			subtotalqtd += parseFloat($('#SubtotalQtdProduto'+i).val().replace(".","").replace(",","."));
			
			prazoproduto = parseFloat($('#PrazoProduto'+i).val().replace(".","").replace(",","."));
			
			//console.log(prazoproduto + ' - Parzo de cada produto');
			
			if(prazoproduto >= prazoprodutos){
				prazoprodutos = prazoproduto;
			}else{
				prazoprodutos = prazoprodutos;
			}
			
		}
		i++;
		
		
    }
	//console.log(prazoprodutos + ' - Parzo Total dos produtos');
	//console.log(prazoservicos + ' - Prazo Total dos servicos');

	//console.log(subtotalcomissao + ' - Total Comiss�o produto');
    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o v�rgula como separador de casas decimais
    subtotalservico = mascaraValorReal(subtotalservico);
	subtotal = mascaraValorReal(subtotal);
	//subtotalcomissao = mascaraValorReal(subtotalcomissao);
	subtotalqtd1 = subtotalqtd;
	prazoprodutos1 = prazoprodutos;
	subtotalqtd2 = subtotalqtdservico;
	prazoservicos1 = prazoservicos;
	//console.log(subtotalqtd1 + ' - Quantidade Total de produtos');
	//console.log(subtotalqtd2 + ' - Quantidade Total de servicos');
	//console.log(subtotal + ' - Valor Total de produtos');
	//console.log(subtotalcomissao + ' - Valor Total de comiss�o');
	var valorcomissao = -(-subtotalcomissaoservico -subtotalcomissao);
    //console.log(valorcomissao + ' - ValorComissao');
	//escreve o subtotal no campo do formul�rio
    $('#ValorDev').val(subtotalservico);
	//console.log(subtotalservico + ' - Valor Total de servicos');
	$('#ValorOrca').val(subtotal);
	//console.log(subtotal + ' - Valor Total de produtos');
	$('#ValorComissao').val(valorcomissao);
	
	$('#QtdPrdOrca').val(subtotalqtd1);
	$('#PrazoProdutos').val(prazoprodutos1);
	
	$('#QtdSrvOrca').val(subtotalqtd2);
	$('#PrazoServicos').val(prazoservicos1);
	
	if(prazoprodutos1 >= prazoservicos1){
		$('#PrazoProdServ').val(prazoprodutos1);
	}else{
		$('#PrazoProdServ').val(prazoservicos1);
	}
	calculaPrazoEntrega();
    calculaResta($("#ValorEntradaOrca").val());
	calculaTotal($("#ValorEntradaOrca").val());
}

/*
 * Fun��o respons�vel por calcular o subtotal dos campos de produto
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */
function calculaResta(entrada) {

    //recebe o valor do or�amento
	var orcamento = $("#ValorOrca").val();
	orcamento 	= orcamento.replace(".","").replace(",",".");
	orcamento		= parseFloat(orcamento);
	
	var devolucao = $("#ValorDev").val();
	devolucao 	= devolucao.replace(".","").replace(",",".");
	devolucao		= parseFloat(devolucao);
	
    //var resta 	= -(-orcamento.replace(".","").replace(",",".") - devolucao.replace(".","").replace(",","."));
    var resta 	= (orcamento + devolucao);
	
	//resta		= parseFloat(resta);
	//resta		= resta.toFixed(2);
	//resta 		= resta.replace(".",",");
    resta = mascaraValorReal(resta);

    //o valor � escrito no seu campo no formul�rio
    $('#ValorRestanteOrca').val(resta);
	
	//var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
	//tipoExtraOrca(tipoextraorca);	
	
	//calculaParcelas();
	calculaTotal();
}

function calculaTotal(entrada) {

	//console.log(nivelempresa +' - N�vel da Empresa');


	var valorrestanteorca = $("#ValorRestanteOrca").val();
	valorrestanteorca 	= valorrestanteorca.replace(".","").replace(",",".");
	valorrestanteorca	= parseFloat(valorrestanteorca);
	//console.log('Prd+Srv = '+valorrestanteorca);
	
	if($("#ValorFrete").val() == ''){
		var devolucao = '0,00';
	}else{
		var devolucao = $("#ValorFrete").val();
	}
	devolucao 	= devolucao.replace(".","").replace(",",".");
	devolucao	= parseFloat(devolucao);	
    
	//console.log('Taxa de Entrega = '+devolucao);

	//var valorsomaorca = -(- devolucao.replace(".","").replace(",",".") - valorrestanteorca.replace(".","").replace(",","."));
	var valorsomaorca = (devolucao + valorrestanteorca);
	//var valorsomaorca = -(- devolucao.replace(".","").replace(",",".") - valorrestanteorca);
	//console.log('Prd+Srv+Entrega 1 = '+valorsomaorca);	
	//valorsomaorca	= parseFloat(valorsomaorca);
	//valorsomaorca	= valorsomaorca.toFixed(2);
	//valorsomaorca 	= valorsomaorca.replace(".",",");
	valorsomaorca = mascaraValorReal(valorsomaorca);
	//console.log(restaT +' - Valor Total');
	//console.log('Prd+Srv+Entrega 2 = '+valorsomaorca);
	$("#ValorSomaOrca").val(valorsomaorca);	

	var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
	//console.log('tipoextraorca = '+tipoextraorca);
	tipoExtraOrca(tipoextraorca);	
	

	//calculaParcelas();
	
}

function calculaTotal_Antigo(entrada) {
	//recebe o Nivel da Empresa
	var nivelempresa = $("#NivelEmpresa").val();
	//console.log(nivelempresa +' - N�vel da Empresa');
	//console.log(valorextraorca +' - Valor extra');
    var orcamento = $("#ValorRestanteOrca").val();
	orcamento.replace(".","").replace(".",",");
	
	
	
	console.log( 'Valor Prd+Srv = '+orcamento);
	var devolucao = $("#ValorFrete").val();    
	
	
	var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
	var percextraorca = $('#PercExtraOrca').val();
	percextraorca = percextraorca.replace(".","").replace(",",".");
	console.log('Calcula Prd+SRV+Extra | Tipo Extra = '+tipoextraorca);	
	console.log('Calcula Prd+SRV+Extra | Perc Extra = '+percextraorca);		
	if(tipoextraorca == "V"){
		var valorextraorca = $("#ValorExtraOrca").val();
	}else if(tipoextraorca == "P"){
		if(percextraorca <= 0.00){
			var valorextraorca = 0.00;
			valorextraorca	= parseFloat(valorextraorca);
			valorextraorca	= valorextraorca.toFixed(2);
			
		}else{
			var valorextraorca = orcamento*percextraorca/100;
			valorextraorca	= parseFloat(valorextraorca);
			valorextraorca	= valorextraorca.toFixed(2);
		}
		
		
	}
	
	console.log('Calcula Prd+SRV+Extra | Valor Extra = '+valorextraorca);	
		//recebe o valor do or�amento

		
	if(nivelempresa >= 4){
		var valorsomaorca = -(- valorextraorca.replace(".","").replace(",",".") - orcamento.replace(".","").replace(",","."));
		var restaT = -(- devolucao.replace(".","").replace(",",".") - orcamento.replace(".","").replace(",",".") - valorextraorca.replace(".","").replace(",","."));
	}else{
		var valorsomaorca = -(- valorextraorca.replace(".","").replace(",","."));
		var restaT = -(- valorextraorca.replace(".","").replace(",","."));
	}
	valorsomaorca = mascaraValorReal(valorsomaorca);
	//console.log(valorsomaorca +' - Valor soma');
    restaT = mascaraValorReal(restaT);
	//console.log(restaT +' - Valor Total');
	

    //o valor � escrito no seu campo no formul�rio
    $('#ValorSomaOrca').val(valorsomaorca);
	$('#ValorTotalOrca').val(restaT);
	
	var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
	tipoExtraOrca(tipoextraorca);
	
	var tipodescorca = $('#Hidden_TipoDescOrca').val();
	tipoDescOrca(tipodescorca);
	//calculaParcelas();
	
}

function exibirExtraOrca(){
	//alert('teste');
	var exibirExtraOrca = $('#exibirExtraOrca').val();
	//console.log('Extra| Cadastar-Alterar/Status = ' +exibirExtraOrca);
	var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
	//console.log('#Hidden_TipoExtraOrca = '+tipoextraorca);
	if(exibirExtraOrca == '1'){
		if(tipoextraorca == 'P'){
			$('#PercExtraOrca').prop('readonly', false);
			$('#ValorExtraOrca').prop('readonly', true);
		}else if(tipoextraorca == 'V'){
			$('#PercExtraOrca').prop('readonly', true);
			$('#ValorExtraOrca').prop('readonly', false);
		}
	}else{
		$('#PercExtraOrca').prop('readonly', true);
		$('#ValorExtraOrca').prop('readonly', true);
	}	
}

function exibirDescOrca(){
	//alert('teste');
	//console.log(pagocom);


	var exibirDescOrca = $('#exibirDescOrca').val();
	
	//console.log('Desc| Cadastar-Alterar/Status = ' +exibirDescOrca);
	
	var tipodescorca = $('#Hidden_TipoDescOrca').val();
	//console.log('#Hidden_TipoDescOrca = '+tipodescorca);
	if(exibirDescOrca == '1'){
		if(tipodescorca == 'P'){
			$('#DescPercOrca').prop('readonly', false);
			$('#DescValorOrca').prop('readonly', true);
		}else if(tipodescorca == 'V'){
			$('#DescPercOrca').prop('readonly', true);
			$('#DescValorOrca').prop('readonly', false);
		}
	}else{
		$('#DescPercOrca').prop('readonly', true);
		$('#DescValorOrca').prop('readonly', true);
	}
		
}

function tipoExtraOrca(valor){
	//alert('teste tipoExtraOrca | valor = ' + valor);
	
	if(valor){
		if(valor == 'P'){
			$('#PercExtraOrca').prop('readonly', false);
			//$('#PercExtraOrca').prop('onkeyup', true);
			//$("#PercExtraOrca").on("click");
			$('#ValorExtraOrca').prop('readonly', true);
			//$('#ValorExtraOrca').prop('onkeyup', false);
			//$("#ValorExtraOrca").off("click");
		}else if(valor == 'V'){
			$('#PercExtraOrca').prop('readonly', true);
			//$('#PercExtraOrca').prop('onkeyup', false);
			//$("#PercExtraOrca").off("click");
			$('#ValorExtraOrca').prop('readonly', false);
			//$('#ValorExtraOrca').prop('onkeyup', true);
			//$("#ValorExtraOrca").on("click");
		}
		$('#Hidden_TipoExtraOrca').val(valor);
		var tipoextraorca = valor;
		if(tipoextraorca == 'P'){
			var desconto = 'Percentual';
			percExtraOrca();
		}else if(tipoextraorca == 'V'){
			var desconto = 'Valor';
			valorExtraOrca();
		}
	}else{
		var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
		//console.log('#Hidden_TipoExtraOrca = '+tipoextraorca);
		if(tipoextraorca == 'P'){
			var desconto = 'Percentual';
			percExtraOrca();
		}else if(tipoextraorca == 'V'){
			var desconto = 'Valor';
			valorExtraOrca();
		}
	}
	
	//var tipoextraorca = $('#Hidden_TipoExtraOrca').val();
	//console.log('Tipo. hidden ='+tipoextraorca);
	//console.log('Tipo. valor ='+valor);
	//console.log('Tipo. desconto ='+desconto);
}

function percExtraOrca(){
	//alert('teste percExtraOrca');
	
	var recorrencias = $('#Recorrencias').val();
	//console.log('Total de Recorrencias = ' + recorrencias);
	var valorsomaorca = $('#ValorSomaOrca').val();
	valorsomaorca 	= valorsomaorca.replace(".","").replace(",",".");
	valorsomaorca	= parseFloat(valorsomaorca);
	//valorsomaorca	= valorsomaorca.toFixed(2);
	//console.log('PercExtra. valorsomaorca = ' + valorsomaorca);
	
	var percextraorca = $('#PercExtraOrca').val();
	if(percextraorca){
		percextraorca = percextraorca.replace(".","").replace(",",".");
		percextraorca	= parseFloat(percextraorca);
		//percextraorca	= percextraorca.toFixed(2);
	}else{
		percextraorca	= 0;
	}
	//console.log('PercExtra. percextraorca = ' + percextraorca);
	if(valorsomaorca > 0){
	
		if(percextraorca > 0){	
			//console.log('percextraorca > 0 = SIM');
			var valorextraorca = percextraorca*valorsomaorca/100;
			valorextraorca	= parseFloat(valorextraorca);
			//valorextraorca	= valorextraorca.toFixed(2);
			
			//var valortotalorca = -(-valorsomaorca - valorextraorca);
			var valortotalorca = (valorsomaorca + valorextraorca);

		
		}else{
			//console.log('percextraorca > 0 = N�O');
			var valorextraorca 	= '0.00';
			var valortotalorca = valorsomaorca;
		}
		
		//console.log('PercExtra. valorextraorca = ' + valorextraorca);
		valortotalorca	= parseFloat(valortotalorca);
		valorextraorca	= parseFloat(valorextraorca);
		//valortotalorca	= valortotalorca.toFixed(2);
		//console.log('PercExtra. valortotalorca = ' + valortotalorca);
		var valor_s_extra = recorrencias*valorsomaorca;
		valor_s_extra	= parseFloat(valor_s_extra);
		valor_s_extra 	= mascaraValorReal(valor_s_extra);
		
		//valor_s_extra	= valor_s_extra.toFixed(2);
		//valor_s_extra 	= valor_s_extra.replace('.',',');
		
		var valor_c_extra = recorrencias*valortotalorca;
		valor_c_extra	= parseFloat(valor_c_extra);
		valor_c_extra 	= mascaraValorReal(valor_c_extra);
		
		//valor_c_extra	= valor_c_extra.toFixed(2);
		//valor_c_extra 	= valor_c_extra.replace('.',',');			
		
		//console.log('PercExtra. valorextraorca = ' + valorextraorca);

		
		//valorextraorca 	= valorextraorca.replace('.',',');
		//
		valortotalorca	= valortotalorca.toFixed(2);
		valortotalorca 	= valortotalorca.replace(".",",");
		
		valorextraorca	= valorextraorca.toFixed(2);
		valorextraorca 	= valorextraorca.replace(".",",");
		//valorextraorca = mascaraValorReal(valorextraorca);
		//console.log('PercExtra. valorextraorca = ' + valorextraorca);
		//valortotalorca = mascaraValorReal(valortotalorca);
		//console.log('PercExtra. valortotalorca = ' + valortotalorca);
		
		
		$('#ValorExtraOrca').val(valorextraorca);
		$('#ValorTotalOrca').val(valortotalorca);
		$('#Valor_C_Extra').val(valor_s_extra);
		$('#Valor_S_Extra').val(valor_c_extra);		
		
	}else{
		$('#ValorTotalOrca').val('0,00');
		$('#ValorExtraOrca').val('0,00');
		$('#Valor_C_Extra').val('0,00');
		$('#Valor_S_Extra').val('0,00');
	}
	
	var tipodescorca = $('#Hidden_TipoDescOrca').val();
	tipoDescOrca(tipodescorca);	
}

function valorExtraOrca(){
	//alert('teste valorExtraOrca');
	
	var recorrencias = $('#Recorrencias').val();
	//console.log('Total de Recorrencias = ' + recorrencias);
	var valorsomaorca = $('#ValorSomaOrca').val();
	valorsomaorca 	= valorsomaorca.replace(".","").replace(",",".");
	valorsomaorca	= parseFloat(valorsomaorca);
	//valorsomaorca	= valorsomaorca.toFixed(2);
	//console.log('ValorExtra. valorsomaorca = ' + valorsomaorca);


	if($('#ValorExtraOrca').val() == ''){
		var valorextraorca = '0,00';
	}else{
		var valorextraorca = $('#ValorExtraOrca').val();
	}
		
	valorextraorca = valorextraorca.replace(".","").replace(",",".");
	valorextraorca	= parseFloat(valorextraorca);
	//valorextraorca	= valorextraorca.toFixed(2);
	//console.log('ValorExtra. valorextraorca = ' + valorextraorca);
	
	//var valortotalorca = -(-valorsomaorca - valorextraorca);
	var valortotalorca = (valorsomaorca + valorextraorca);
	valortotalorca	= parseFloat(valortotalorca);
	//valortotalorca	= valortotalorca.toFixed(2);	
	
	//console.log('ValorExtra. Prdvalortotalorca = ' + valortotalorca);
	
	var valor_c_extra = recorrencias*valortotalorca;
	valor_c_extra	= parseFloat(valor_c_extra);
	valor_c_extra 	= mascaraValorReal(valor_c_extra);
	
	//valor_c_extra	= valor_c_extra.toFixed(2);
	//valor_c_extra 	= valor_c_extra.replace('.',',');
	
	var valor_s_extra = recorrencias*valorsomaorca;
	valor_s_extra	= parseFloat(valor_s_extra);
	valor_s_extra 	= mascaraValorReal(valor_s_extra);
	
	//valor_s_extra	= valor_s_extra.toFixed(2);
	//valor_s_extra 	= valor_s_extra.replace('.',',');	
	
	if(valorsomaorca <= 0.00){
		var percextraorca = '0,00';
	}else{
		var percextraorca = (valortotalorca - valorsomaorca)*100/valorsomaorca;
		percextraorca	= parseFloat(percextraorca);
		percextraorca 	= mascaraValorReal(percextraorca);
		
		//percextraorca	= percextraorca.toFixed(2);
		//percextraorca 	= percextraorca.replace('.',',');
	}
	
	//valortotalorca 	= valortotalorca.replace(".",",");
	valortotalorca = mascaraValorReal(valortotalorca);
	
	$('#ValorTotalOrca').val(valortotalorca);
	$('#PercExtraOrca').val(percextraorca);
	$('#Valor_C_Extra').val(valor_c_extra);
	$('#Valor_S_Extra').val(valor_s_extra);

	var tipodescorca = $('#Hidden_TipoDescOrca').val();
	
	tipoDescOrca(tipodescorca);		
}

function tipoDescOrca(valor){
	//alert('teste tipoDescOrca');
	//console.log('valor = ' + valor);
	if(valor){
		if(valor == 'P'){
			$('#DescPercOrca').prop('readonly', false);
			//$('#DescPercOrca').prop('onkeyup', true);
			//$("#DescPercOrca").on("click");
			$('#DescValorOrca').prop('readonly', true);
			//$('#DescValorOrca').prop('onkeyup', false);
			//$("#DescValorOrca").off("click");
		}else if(valor == 'V'){
			$('#DescPercOrca').prop('readonly', true);
			//$('#DescPercOrca').prop('onkeyup', false);
			//$("#DescPercOrca").off("click");
			$('#DescValorOrca').prop('readonly', false);
			//$('#DescValorOrca').prop('onkeyup', true);
			//$("#DescValorOrca").on("click");
		}
		$('#Hidden_TipoDescOrca').val(valor);
		var tipodescorca = valor;
		if(tipodescorca == 'P'){
			var desconto = 'Percentual';
			descPercOrca();
		}else if(tipodescorca == 'V'){
			var desconto = 'Valor';
			descValorOrca();
		}
	}else{
		var tipodescorca = $('#Hidden_TipoDescOrca').val();
		if(tipodescorca == 'P'){
			var desconto = 'Percentual';
			descPercOrca();
		}else if(tipodescorca == 'V'){
			var desconto = 'Valor';
			descValorOrca();
		}
	}

	//var tipodescorca = $('#Hidden_TipoDescOrca').val();
	//console.log('Tipo. hidden ='+tipodescorca);
	//console.log('Tipo. valor ='+valor);
	//console.log('Tipo. desconto ='+desconto);
}

function descPercOrca(usarcash){

	var valortotalorca = $('#ValorTotalOrca').val();
	valortotalorca 	= valortotalorca.replace(".","").replace(",",".");
	valortotalorca	= parseFloat(valortotalorca);
	//valortotalorca	= valortotalorca.toFixed(2);

	//console.log('PercDesc - valortotalorca = ' + valortotalorca);	
	
	var descpercorca = $('#DescPercOrca').val();
	if(descpercorca){
		descpercorca 	= descpercorca.replace(".","").replace(",",".");
		descpercorca	= parseFloat(descpercorca);
		//descpercorca	= descpercorca.toFixed(2);		
	}else{
		descpercorca	= 0;
	}	

	//console.log('PercDesc descpercorca = ' + descpercorca);

	if(valortotalorca > 0){
		//console.log('valortotalorca > 0 ');

		if(descpercorca <= 100){	
			//console.log('0 < descpercorca <= 100 == Sim');
			var descvalororca = descpercorca*valortotalorca/100;
			//descvalororca	= parseFloat(descvalororca);
			//descvalororca	= descvalororca.toFixed(2);
			//console.log('Perc. descvalororca = ' + descvalororca);			
			
			var subvalorfinal 	= (valortotalorca - descvalororca);
		}else{
			//console.log('0 < descpercorca <= 100 == N�o');
			var descvalororca = valortotalorca;
			//descvalororca	= parseFloat(descvalororca);
			//descvalororca	= descvalororca.toFixed(2);
			//var descpercorca = 100;
			$('#DescPercOrca').val('100,00');
			var subvalorfinal = 0.00;
		}
		
		//descvalororca 	= descvalororca.replace('.',',');
		descvalororca	= parseFloat(descvalororca);
		descvalororca 	= mascaraValorReal(descvalororca);
		
		subvalorfinal		= parseFloat(subvalorfinal);
		subvalorfinal 		= mascaraValorReal(subvalorfinal);
		
		//subvalorfinal		= subvalorfinal.toFixed(2);
		//subvalorfinal 		= subvalorfinal.replace('.',',');
		//console.log('Perc. subvalorfinal = ' + subvalorfinal);

		$('#DescValorOrca').val(descvalororca);
		$('#SubValorFinal').val(subvalorfinal);
		
	}else{
		$('#DescPercOrca').val('0,00');
		$('#DescValorOrca').val('0,00');
		$('#SubValorFinal').val('0,00');
	}
	usarcashback();

}

function descValorOrca(usarcash){

	var valortotalorca 	= $('#ValorTotalOrca').val();
	valortotalorca 		= valortotalorca.replace(".","").replace(",",".");
	valortotalorca		= parseFloat(valortotalorca);
	//valortotalorca		= valortotalorca.toFixed(2);
	
	if($('#DescValorOrca').val() == ''){
		var descvalororca = '0,00';
	}else{
		var descvalororca = $('#DescValorOrca').val();
	}

	descvalororca 	= descvalororca.replace(".","").replace(",",".");
	descvalororca	= parseFloat(descvalororca);
	//descvalororca	= descvalororca.toFixed(2);
	//console.log('PeloDesc-valortotalorca = ' + valortotalorca);
	//console.log('PeloDesc-descvalororca = ' + descvalororca);
	
	if(valortotalorca > 0){
	
		if(valortotalorca >= descvalororca){
			//console.log('valortotalorca >= descvalororca = SIM');
			//console.log('Total do Pedido = ' + valortotalorca);
			var subvalorfinal = (valortotalorca - descvalororca);
			subvalorfinal	= parseFloat(subvalorfinal);
			
			var descpercorca = (valortotalorca - subvalorfinal)*100/valortotalorca;
		}else{
			//console.log('valortotalorca >= descvalororca = N�O');
			descvalororca = valortotalorca;
			descvalororca	= parseFloat(descvalororca);
			descvalororca	= descvalororca.toFixed(2);
			descvalororca 	= descvalororca.replace('.',',');
			$('#DescValorOrca').val(descvalororca);
			var subvalorfinal = 0.00;
			subvalorfinal	= parseFloat(subvalorfinal);
			var descpercorca = 100;
		}

		descpercorca	= parseFloat(descpercorca);
		descpercorca 	= mascaraValorReal(descpercorca);
		
		//descpercorca	= descpercorca.toFixed(2);
		//descpercorca 	= descpercorca.replace('.',',');
		
		
		subvalorfinal 	= mascaraValorReal(subvalorfinal);
		//subvalorfinal	= parseFloat(subvalorfinal);
		//subvalorfinal	= subvalorfinal.toFixed(2);
		//subvalorfinal 	= subvalorfinal.replace('.',',');

		$('#DescPercOrca').val(descpercorca);
		$('#SubValorFinal').val(subvalorfinal);	
		
	}else{
		$('#DescPercOrca').val('0,00');
		$('#DescValorOrca').val('0,00');
		$('#SubValorFinal').val('0,00');
	}	
	usarcashback();
}

function comcliente(valor2) {
	
	//console.log('valor2 = '+valor2);
	
	var id_Cliente = $('#idApp_Cliente').val();
	//console.log('id_Cliente = '+id_Cliente);

	$('#Hidden_Cli_Forn_Orca').val(valor2);	
	
	if(valor2 == 'S'){
		if(id_Cliente && id_Cliente!=0 && id_Cliente!= ''){
			calculacashback(id_Cliente);
		}else{
			$('#CashBackOrca').val('0,00');
			usarcashback();
		}
	}else{
		$('#CashBackOrca').val('0,00');
		usarcashback();
	}
}

function comfornecedor(valor2) {
	
	//console.log('valor2 = '+valor2);
	
	var id_Fornecedor = $('#idApp_Fornecedor').val();
	//console.log('id_Fornecedor = '+id_Fornecedor);

	$('#Hidden_Cli_Forn_Orca').val(valor2);	
	
	if(valor2 == 'S'){
		if(id_Fornecedor && id_Fornecedor!=0 && id_Fornecedor!= ''){
			calculacashback(id_Fornecedor);
		}else{
			$('#CashBackOrca').val('0,00');
			usarcashback();
		}
	}else{
		$('#CashBackOrca').val('0,00');
		usarcashback();
	}
}

function calculacashback(id_Cliente) {
	//console.log('id_Cliente = '+id_Cliente);
	//console.log('metodo = '+$('#metodo').val());
	
	if(id_Cliente && id_Cliente!=0 && id_Cliente!= ''){
		var id = id_Cliente;
	}else if($('#idApp_Cliente').val()){
		var id = $('#idApp_Cliente').val();
	}else{
		var id = 'null';
	}	
	$('#Hidden_idApp_Cliente').val(id);
	//console.log('id = '+id);
	
	var comcliente = $('#Hidden_Cli_Forn_Orca').val();
	
	//console.log('comcliente = '+comcliente);
	
	if($('#metodo').val() && $('#metodo').val() == 1){
		//console.log('AtivoCashBack = '+$('#AtivoCashBack').val());
		if($('#AtivoCashBack').val() && $('#AtivoCashBack').val() == "S"){

			if(comcliente == "S"){

				var ocorrencias = $('#Recorrencias').val();
				//console.log('ocorrencias = '+ocorrencias);
				
				$.ajax({
					
					url: window.location.origin+ '/' + app + '/cadastros/pesquisar/CashBack.php?id=' + id,
					dataType: "json",
					
					success: function (data) {
						var cashback_0	= data[0]['cashtotal'];
						var validade_0	= data[0]['validade'];
						var partesData = validade_0.split("-");
						
						var dia = parseInt(partesData[2]);
						var mes = parseInt(partesData[1]);
						var ano = parseInt(partesData[0]);
						var validade 	= partesData[2]+'/'+partesData[1]+'/'+partesData[0];

						var validade_2 	= new Date(ano, mes - 1, dia);
						//var data_hoje	= new Date();
						
						if(validade_2 >= data_hoje){
							//CashBackOrca	= parseFloat(data);
							CashBackOrca	= parseFloat(cashback_0);
						}else{
							CashBackOrca	= 0.00;
						}
						
						//CashBackOrca	= CashBackOrca/ocorrencias;
						CashBackOrca 	= mascaraValorReal(CashBackOrca);
						
						//CashBackOrca	= CashBackOrca.toFixed(2);
						//CashBackOrca 	= CashBackOrca.replace(".",",");
						
						$('#CashBackOrca').val(CashBackOrca);
						$('#ValidadeCashBackOrca').val(validade);
						//console.log('CashBackOrca = '+CashBackOrca);
						usarcashback();
						
					},
					error:function(data){
						//console.log('Nada encontrado');
						$('#ValidadeCashBackOrca').val('');
						$('#CashBackOrca').val('0,00');
						usarcashback();
					}
				});//termina o ajax
			}	
		}
	}	
}

function usarcashback(usarcash) {
	//alert('usarcashback');
	if(usarcash){
		var Hidden_UsarCashBack	= usarcash;
		$('#Hidden_UsarCashBack').val(usarcash);
	}else{
		var Hidden_UsarCashBack	= $('#Hidden_UsarCashBack').val();
	}

	
	var metodo = $('#metodo').val();
	//console.log('metodo = ' + metodo);	
	
	var recorrencias = $('#Recorrencias').val();
	recorrencias		= parseFloat(recorrencias);
	//console.log('Total de Recorrencias = ' + recorrencias);	
	
	var valortotalorca 	= $('#ValorTotalOrca').val();
	valortotalorca 		= valortotalorca.replace(".","").replace(",",".");
	valortotalorca		= parseFloat(valortotalorca);
	//valortotalorca		= valortotalorca.toFixed(2);	
	
	var subvalorfinal = $('#SubValorFinal').val();
	subvalorfinal 	= subvalorfinal.replace(".","").replace(",",".");
	subvalorfinal	= parseFloat(subvalorfinal);
	//subvalorfinal	= subvalorfinal.toFixed(2);

	var cashbackorca 	= $('#CashBackOrca').val();
	cashbackorca 		= cashbackorca.replace(".","").replace(",",".");
	cashbackorca		= parseFloat(cashbackorca);	
	//console.log('CashBack-cashbackorca = ' + cashbackorca);
	
	//console.log('CashBack-valortotalorca = ' + valortotalorca);
	//console.log('CashBack-subvalorfinal = ' + subvalorfinal);	
	
	if(Hidden_UsarCashBack == 'S'){
		if(subvalorfinal >= cashbackorca){
			var valorfinalorca = (subvalorfinal - cashbackorca);
		}else{
			var valorfinalorca = '0.00';
		}	
	}else{
		var valorfinalorca = subvalorfinal;
	}
	
	valorfinalorca	= parseFloat(valorfinalorca);
	//valorfinalorca	= valorfinalorca.toFixed(2);
	/*
	if(recorrencias > 1){	
		if(metodo == 1){
			var valor_s_desc = valorfinalorca + (recorrencias - 1)*subvalorfinal;
			var valor_c_desc = (recorrencias - 1)*subvalorfinal;	
			
			valor_s_desc	= parseFloat(valor_s_desc);
			valor_s_desc 	= mascaraValorReal(valor_s_desc);

			valor_c_desc	= parseFloat(valor_c_desc);
			valor_c_desc 	= mascaraValorReal(valor_c_desc);		
			
			$('#Valor_C_Desc').val(valor_c_desc);
			$('#Valor_S_Desc').val(valor_s_desc);
		
		
		}else if(metodo == 2){
			
			var valor_c_desc = $('#Valor_C_Desc').val();
			valor_c_desc 	= valor_c_desc.replace(".","").replace(",",".");
			valor_c_desc	= parseFloat(valor_c_desc);	
			
			console.log(valor_c_desc);
			var valor_s_desc = valorfinalorca + valor_c_desc;
			valor_s_desc	= parseFloat(valor_s_desc);
			valor_s_desc 	= mascaraValorReal(valor_s_desc);
			console.log(valor_s_desc);
			$('#Valor_S_Desc').val(valor_s_desc);
			
		}else{
			var valor_s_desc = 0.00;
			var valor_c_desc = 0.00;
			
			valor_s_desc	= parseFloat(valor_s_desc);
			valor_s_desc 	= mascaraValorReal(valor_s_desc);

			valor_c_desc	= parseFloat(valor_c_desc);
			valor_c_desc 	= mascaraValorReal(valor_c_desc);		
			
			$('#Valor_C_Desc').val(valor_c_desc);
			$('#Valor_S_Desc').val(valor_s_desc);			
			
		}
	}else{
		var valor_s_desc = valorfinalorca;
		var valor_c_desc = 0.00;
			
		valor_s_desc	= parseFloat(valor_s_desc);
		valor_s_desc 	= mascaraValorReal(valor_s_desc);

		valor_c_desc	= parseFloat(valor_c_desc);
		valor_c_desc 	= mascaraValorReal(valor_c_desc);		
		
		$('#Valor_C_Desc').val(valor_c_desc);
		$('#Valor_S_Desc').val(valor_s_desc);	
	}
	*/
	

	//valorfinalorca 	= valorfinalorca.replace('.',',');
	subvalorfinal 	= mascaraValorReal(subvalorfinal);
	valorfinalorca 	= mascaraValorReal(valorfinalorca);	
	
	$('#ValorFinalOrca').val(valorfinalorca);		

	/*
	valor_s_desc	= parseFloat(valor_s_desc);
	valor_s_desc 	= mascaraValorReal(valor_s_desc);

	valor_c_desc	= parseFloat(valor_c_desc);
	valor_c_desc 	= mascaraValorReal(valor_c_desc);
	
	$('#Valor_C_Desc').val(valor_c_desc);
	$('#Valor_S_Desc').val(valor_s_desc);
	*/	
	
	if(metodo == 1){
		//console.log('calculaParcelas = SIM');
		calculaParcelas();
	}
	calculaTroco();	
	calculaTotalOS(subvalorfinal, valorfinalorca);
}

function calculaTotalOS(subvalorfinal, valorfinalorca) {
	
	if(subvalorfinal && valorfinalorca){
		
		subvalorfinal 	= subvalorfinal.replace(".","").replace(",",".");
		subvalorfinal	= parseFloat(subvalorfinal);
		subvalorfinal	= subvalorfinal.toFixed(2);
	
		valorfinalorca 	= valorfinalorca.replace(".","").replace(",",".");
		valorfinalorca	= parseFloat(valorfinalorca);
		valorfinalorca	= valorfinalorca.toFixed(2);
		
		//console.log('subvalorfinal = ' + subvalorfinal);	
		//console.log('valorfinalorca = ' + valorfinalorca);	
		
		var metodo = $('#metodo').val();
		//console.log('metodo = ' + metodo);
		
		var recorrencias = $('#Recorrencias').val();
		recorrencias		= parseFloat(recorrencias);
		//console.log('Total de Recorrencias = ' + recorrencias);	

		if(recorrencias > 1){	
			if(metodo == 1){
				var valor_s_desc = -(-valorfinalorca -(recorrencias - 1)*subvalorfinal);
				var valor_c_desc = (recorrencias - 1)*subvalorfinal;	
				
				valor_s_desc	= parseFloat(valor_s_desc);
				valor_s_desc 	= mascaraValorReal(valor_s_desc);

				valor_c_desc	= parseFloat(valor_c_desc);
				valor_c_desc 	= mascaraValorReal(valor_c_desc);		
				
				//console.log('valor_c_desc = ' + valor_c_desc);
				//console.log('valor_s_desc = ' + valor_s_desc);
				
				$('#Valor_C_Desc').val(valor_c_desc);
				$('#Valor_S_Desc').val(valor_s_desc);
			
			
			}else if(metodo == 2){
				
				var valor_c_desc = $('#Valor_C_Desc').val();
				
				valor_c_desc 	= valor_c_desc.replace(".","").replace(",",".");
				
				valor_c_desc	= parseFloat(valor_c_desc);
				
				valor_c_desc		= valor_c_desc.toFixed(2);	
				
				//console.log('valor_c_desc = ' + valor_c_desc);
				
				var valor_s_desc = -(-valorfinalorca -valor_c_desc);
				
				valor_s_desc	= parseFloat(valor_s_desc);
				valor_s_desc 	= mascaraValorReal(valor_s_desc);
				
				//console.log('valor_s_desc = ' + valor_s_desc);
				
				$('#Valor_S_Desc').val(valor_s_desc);
				
			}else{
				var valor_s_desc = 0.00;
				var valor_c_desc = 0.00;
				
				valor_s_desc	= parseFloat(valor_s_desc);
				valor_s_desc 	= mascaraValorReal(valor_s_desc);

				valor_c_desc	= parseFloat(valor_c_desc);
				valor_c_desc 	= mascaraValorReal(valor_c_desc);		
				
				$('#Valor_C_Desc').val(valor_c_desc);
				$('#Valor_S_Desc').val(valor_s_desc);			
				
			}
		}else{
			var valor_s_desc = valorfinalorca;
			var valor_c_desc = 0.00;
				
			valor_s_desc	= parseFloat(valor_s_desc);
			valor_s_desc 	= mascaraValorReal(valor_s_desc);

			valor_c_desc	= parseFloat(valor_c_desc);
			valor_c_desc 	= mascaraValorReal(valor_c_desc);		
			
			$('#Valor_C_Desc').val(valor_c_desc);
			$('#Valor_S_Desc').val(valor_s_desc);	
		}
	}
}

function calculaTroco(entrada) {

    //recebe o valor do or�amento
    //var orcamento = $("#ValorRestanteOrca").val();
	//var orcamento = $("#ValorTotalOrca").val();
	var orcamento = $("#ValorFinalOrca").val();
	orcamento = orcamento.replace(".","").replace(",",".");
	orcamento	= parseFloat(orcamento);
	var devolucao = $("#ValorDinheiro").val();
	devolucao = devolucao.replace(".","").replace(",",".");
	devolucao	= parseFloat(devolucao);
    //console.log('Valor Final = '+orcamento);
    //console.log('Valor Dinheiro = '+devolucao);
	
	if(devolucao > orcamento){
		//console.log('devolucao > orcamento =  SIM');
		var resta = (devolucao - orcamento);
		resta = mascaraValorReal(resta);
	}else{
		//console.log('devolucao > orcamento =  N�O');
		var resta = '0,00';
	}
	
    //o valor � escrito no seu campo no formul�rio
    $('#ValorTroco').val(resta);
	
}
 
function calculaParcelas(mod) {
    //alert();
	//captura os valores dos campos indicados
    //var resta = $("#ValorRestanteOrca").val();
	//console.log(mod + ' - mod');
	var formapag = $("#FormaPagamento").val();
	//console.log(formapag + ' - forma de pagamento');
	var resta = $("#ValorFinalOrca").val();
	//var resta = $("#ValorTotalOrca").val();
    var parcelas = $("#QtdParcelasOrca").val();
    //console.log('QtdParcelasOrca = ' +parcelas);
	if(parcelas){	
		if(parcelas == 0){
			parcelas = 1;
		}

		//$("#QtdParcelasOrca").val(parcelas);
		var vencimento = $("#DataVencimentoOrca").val();

		//valor de cada parcela
		if(mod){
			if(mod == "P"){
				var parcorca = (resta.replace(".","").replace(",",".") / parcelas);
			}else{
				var parcorca = (resta.replace(".","").replace(",",".") / 1);
			}	
		}else{
			var parcorca = (resta.replace(".","").replace(",",".") / parcelas);
		}	
		parcorca = mascaraValorReal(parcorca);
		
		//pega a data do primeiro vencimento e separa em dia, m�s e ano
		var split = vencimento.split("/");

		//define a data do primeiro vencimento no formato do momentjs
		var currentDate = moment(split[2]+'-'+split[1]+'-'+split[0]);

		//console.log(currentDate.format('DD-MM-YYYY'));
		//console.log(futureMonth.format('DD-MM-YYYY'));
		//alert('>>v '+vencimento+'::d1 '+currentDate.format('DD/MM/YYYY')+'::d2 '+futureMonth.format('DD/MM/YYYY')+'::d3 '+futureMonthEnd.format('DD/MM/YYYY')+'<<');

		//caso as parcelas j� tenham sido geradas elas ser�o exclu�das para que
		//sejam geradas novas parcelas
		$(".input_fields_parcelas").empty();

		//gera os campos de parcelas
		for (i=1; i<=parcelas; i++) {
			
			if (i >= 2) {
				//console.log( $("#FormaPagamentoParcela"+(i-1)).val() );
				var chosen;
				chosen = $("#FormaPagamentoParcela"+(i-1)).val();
				//console.log( chosen + ' :: ' + i );
			}		
			
		
			//calcula as datas das pr�ximas parcelas
			var futureMonth = moment(currentDate).add(i-1, 'M');
			var futureMonthEnd = moment(futureMonth).endOf('month');

			if(currentDate.date() != futureMonth.date() && futureMonth.isSame(futureMonthEnd.format('YYYY-MM-DD')))
				futureMonth = futureMonth.add(i-1, 'd');

			$(".input_fields_parcelas").append('\
				<div class="form-group">\
					<div class="panel panel-warning">\
						<div class="panel-heading">\
							<div class="row">\
								<div class="col-md-1">\
									<label for="Parcela">Prcl.:'+i+'</label><br>\
									<input type="text" class="form-control" maxlength="6"\
										   name="Parcela'+i+'" value="'+i+'/'+parcelas+'">\
								</div>\
								<div class="col-md-2">\
									<label for="FormaPagamentoParcela'+i+'">FormaPag:</label>\
									<select data-placeholder="Selecione uma op��o..." class="form-control Chosen_Parcela"\
											 id="FormaPagamentoParcela'+i+'" name="FormaPagamentoParcela'+i+'">\
										<option value="'+formapag+'"></option>\
									</select>\
								</div>\
								<div class="col-md-2">\
									<label for="ValorParcela">Valor Parcela:</label><br>\
									<div class="input-group" id="txtHint">\
										<span class="input-group-addon" id="basic-addon1">R$</span>\
										<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
												id="ValorParcela'+i+'" name="ValorParcela'+i+'" value="'+parcorca+'">\
									</div>\
								</div>\
								<div class="col-md-2">\
									<label for="DataVencimento">Vencimento</label>\
									<div class="input-group DatePicker">\
										<span class="input-group-addon" disabled>\
											<span class="glyphicon glyphicon-calendar"></span>\
										</span>\
										<input type="text" class="form-control Date" id="DataVencimento'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
											   name="DataVencimento'+i+'" value="'+futureMonth.format('DD/MM/YYYY')+'">\
									</div>\
								</div>\
								<div class="col-md-2">\
									<label for="Quitado">Parc.Quitada?</label><br>\
									<div class="btn-group" data-toggle="buttons">\
										<label class="btn btn-warning active" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'N">\
										<input type="radio" name="Quitado'+i+'" id="rdgrldnmc_cal_parc"\
											onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="N" checked>N�o\
										</label>\
										<label class="btn btn-default" name="radio_Quitado'+i+'" id="radio_Quitado'+i+'S">\
										<input type="radio" name="Quitado'+i+'" id="rdgrldnmc_cal_parc"\
											onchange="carregaQuitado(this.value,this.name,'+i+',1)" autocomplete="off" value="S">Sim\
										</label>\
									</div>\
								</div>\
								<div class="col-md-2">\
									<div id="Quitado'+i+'" style="display:none">\
										<label for="DataPago">Pagamento</label>\
										<div class="input-group DatePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-calendar"></span>\
											</span>\
											<input type="text" class="form-control Date" id="DataPago'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
												   name="DataPago'+i+'" value="">\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>'
			);

			//get a reference to the select element
			$select2 = $('#FormaPagamentoParcela'+i);
			//console.log( $select2 + ' :: ' + i );
			//request the JSON data and parse into the select element
			$.ajax({
				url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=70',
				dataType: 'JSON',
				type: "GET",
				success: function (data) {
					//clear the current content of the select
					$select2.html('');
					//iterate over the data and append a select option
					$select2.append('<option value="">-- Sel. FormaPag. --</option>');
					$.each(data, function (key, val) {
						//alert(val.id);
						$select2.append('<option value="' + val.id + '">' + val.name + '</option>');
					})
					$('.Chosen_Parcela').chosen({
						disable_search_threshold: 10,
						multiple_text: "Selecione uma ou mais op��es",
						single_text: "Selecione uma op��o",
						no_results_text: "Nenhum resultado para",
						width: "100%"
					});
				},
				error: function () {
					//alert('erro listadinamicaB');
					//if there is an error append a 'none available' option
					$select2.html('<option id="-1">ERRO</option>');
				}

			});	
	
		
		}
	
		//habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);

		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="rdgrldnmc_cal_parc"]').change(function() {

			var value_prc = $(this).val();
			var name_prc = $(this).attr("name");

			//console.log(value_prc + ' <<>> ' + name);

			$('label[name="radio_' + name_prc + '"]').removeClass();
			$('label[name="radio_' + name_prc + '"]').addClass("btn btn-default");
			$('#radio_' + name_prc + value_prc).addClass("btn btn-warning active");
			//$('#radiogeral'+ value_prc).addClass("btn btn-warning active");
			
			if(value_prc == "S"){
				$("#"+name_prc).css("display","");
			}else{
				$("#"+name_prc).css("display","none");
			}

		});	
		//console.log('SIM calculou parcelas');
	}else{
		//console.log('N�O calculou parcelas');
	}
	
}

function adicionaParcelas() {
	
	var formapag = $("#FormaPagamento").val();
	//console.log(formapag + ' - forma de pagamento');
	
	var pr = $("#PRCount").val(); //initlal text box count
	pr++; //text box increment
	$("#PRCount").val(pr);
	
	if (pr >= 2) {
		//console.log( $("#FormaPagamentoParcela"+(pr-1)).val() );
		var chosen;
		chosen = $("#FormaPagamentoParcela"+(pr-1)).val();
		//console.log( chosen + ' :: ' + pr );
	}
	
    //Captura a data do dia e carrega no campo correspondente
    
	//var currentDate = moment();
	
    $(".input_fields_wrap21").append('\
		<div class="form-group" id="21div'+pr+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="Parcela">Prcl.:</label><br>\
							<input type="text" class="form-control" maxlength="6"\
								   name="Parcela'+pr+'" value="Ex.">\
						</div>\
						<div class="col-md-2">\
							<label for="FormaPagamentoParcela'+pr+'">FormaPag:</label>\
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen_Parcela"\
									 id="FormaPagamentoParcela'+pr+'" name="FormaPagamentoParcela'+pr+'">\
								<option value="'+formapag+'"></option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorParcela">Valor:</label><br>\
							<div class="input-group" id="txtHint">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
										id="ValorParcela'+pr+'" name="ValorParcela'+pr+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataVencimento">Vencimento</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" id="DataVencimento'+pr+'" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataVencimento'+pr+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="Quitado">Parc.Quitado?</label><br>\
							<div class="btn-group" data-toggle="buttons">\
								<label class="btn btn-warning active" name="radio_Quitado'+pr+'" id="radio_Quitado'+pr+'N">\
								<input type="radio" name="Quitado'+pr+'" id="rdgrldnmc_adic_parc"\
									onchange="carregaQuitado(this.value,this.name,'+pr+',1)" autocomplete="off" value="N" checked>N�o\
								</label>\
								<label class="btn btn-default" name="radio_Quitado'+pr+'" id="radio_Quitado'+pr+'S">\
								<input type="radio" name="Quitado'+pr+'" id="rdgrldnmc_adic_parc"\
									onchange="carregaQuitado(this.value,this.name,'+pr+',1)" autocomplete="off" value="S">Sim\
								</label>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<div id="Quitado'+pr+'" style="display:none">\
								<label for="DataPago">Pagamento</label>\
								<div class="input-group DatePicker">\
									<span class="input-group-addon" disabled>\
										<span class="glyphicon glyphicon-calendar"></span>\
									</span>\
									<input type="text" class="form-control Date" id="DataPago'+pr+'" maxlength="10" placeholder="DD/MM/AAAA"\
										   name="DataPago'+pr+'" value="">\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+pr+'" class="remove_field21 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</a>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>'
	); //add input box
	
	//get a reference to the select element
	$select2 = $('#FormaPagamentoParcela'+pr);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=70',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select2.html('');
			//iterate over the data and append a select option
			$select2.append('<option value="">-- Sel. FormaPag. --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select2.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen_Parcela').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select2.html('<option id="-1">ERRO</option>');
		}

	});	
	
	//habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
	$('.DatePicker').datetimepicker(dateTimePickerOptions);	
	
    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="rdgrldnmc_adic_parc"]').change(function() {

        var value_prc = $(this).val();
        var name_prc = $(this).attr("name");
        //console.log(value_prc + ' <<>> ' + name_prc);
		
		$('label[name="radio_' + name_prc + '"]').removeClass();
        $('label[name="radio_' + name_prc + '"]').addClass("btn btn-default");
        $('#radio_' + name_prc + value_prc).addClass("btn btn-warning active");
		
		if(value_prc == "S"){
			$("#"+name_prc).css("display","");
		}else{
			$("#"+name_prc).css("display","none");
		}
    });
}

/*
 * Fun��o respons�vel por calcular as parcelas do or�amento em fun��o do dados
 * informados no formul�rio (valor restante / parcelas e datas do vencimento)
 */

function adicionaDias(mod) {
    //alert();
	
	$(".input_fields_dias").empty();

    //gera os campos de parcelas
    for (i=1; i<=7; i++) {
		
		//var dia = i;
		if (i == 1){
			var dia_semana = 'SEGUNDA';
		}else if(i == 2){
			var dia_semana = 'TERCA';
		}else if(i == 3){
			var dia_semana = 'QUARTA';
		}else if(i == 4){
			var dia_semana = 'QUINTA';
		}else if(i == 5){
			var dia_semana = 'SEXTA';
		}else if(i == 6){
			var dia_semana = 'SABADO';
		}else if(i == 7){
			var dia_semana = 'DOMINGO';
		}

        $(".input_fields_dias").append('\
            <div class="col-md-2">\
				<div class="panel panel-warning">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-12">\
								<label for="Aberto_Prom">'+dia_semana+'</label><br>\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_Aberto_Prom'+i+'" id="radio_Aberto_Prom'+i+'N">\
									<input type="radio" name="Aberto_Prom'+i+'" id="rdgrldnmc_add_dias"\
										 autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_Aberto_Prom'+i+'" id="radio_Aberto_Prom'+i+'S">\
									<input type="radio" name="Aberto_Prom'+i+'" id="rdgrldnmc_add_dias"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>'
        );

    }
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="rdgrldnmc_add_dias"]').change(function() {

        var value_add_dias = $(this).val();
        var name_add_dias = $(this).attr("name");

        //console.log(value_add_dias + ' <<>> ' + name);

        $('label[name="radio_' + name_add_dias + '"]').removeClass();
        $('label[name="radio_' + name_add_dias + '"]').addClass("btn btn-default");
        $('#radio_' + name_add_dias + value_add_dias).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_add_dias).addClass("btn btn-warning active");
		
		if(value_add_dias == "S"){
			$("#"+name_add_dias).css("display","");
		}else{
			$("#"+name_add_dias).css("display","none");
		}

    });
	
	
}

/*
$(document).on('focus',".input_fields_parcelas", function(){
    $(this).datepicker();
});
*/
/*
 * Fun��o respons�vel por calcular as parcelas do or�amento em fun��o do dados
 * informados no formul�rio (valor restante / parcelas e datas do vencimento)
 */

function adicionaTamanhos() {

    var pc = $("#PMCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pc++; //text box increment
    $("#PMCount").val(pc);
    //console.log(pc);

    if (pc >= 2) {
        //console.log( $("#listadinamicac"+(pc-1)).val() );
        var chosen;
        chosen = $("#listadinamicac"+(pc-1)).val();
        //console.log( chosen + ' :: ' + pc );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap30").append('\
        <div class="form-group" id="30div'+pc+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-2">\
							<label for="Cat_Prod'+pc+'">Cat_Prod</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="Cat_Prod'+pc+'" placeholder="0"\
									name="Cat_Prod'+pc+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pc+'" class="remove_field30 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicac'+pc);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=7',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            //$select.append('<option value="" checked>Baixa</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");
        //$('#radiogeral'+ value).addClass("btn btn-warning active");

    });

}

function adicionaFuncao() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);
	
    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="idTab_Funcao'+pt+'">Fun��o '+pt+':</label>\
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen3"\
									 id="listadinamicad'+pt+'" name="idTab_Funcao'+pt+'">\
								<option value=""></option>\
							</select>\
						</div>\
						<div class="col-md-3">\
							<label for="Comissao_Funcao'+pt+'">Comissao_Funcao :</label><br>\
							<div class="input-group id="Comissao_Funcao'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="Comissao_Funcao'+pt+'" maxlength="10" placeholder="0,00" \
									name="Comissao_Funcao'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-3">\
							<label for="Ativo_Funcao">Ativo?</label><br>\
							<div class="btn-group" data-toggle="buttons">\
								<label class="btn btn-default" name="radio_Ativo_Funcao'+pt+'" id="radio_Ativo_Funcao'+pt+'N">\
								<input type="radio" name="Ativo_Funcao'+pt+'" id="radiogeraldinamico_subproc"\
									onchange="carregaAtivoFuncao(this.value,this.name,'+pt+',0)" autocomplete="off" value="N">N�o\
								</label>\
								<label class="btn btn-warning active" name="radio_Ativo_Funcao'+pt+'" id="radio_Ativo_Funcao'+pt+'S">\
								<input type="radio" name="Ativo_Funcao'+pt+'" id="radiogeraldinamico_subproc"\
									onchange="carregaAtivoFuncao(this.value,this.name,'+pt+',0)" autocomplete="off" value="S" checked>Sim\
								</label>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
					<div class="row">\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);
	
	
	//get a reference to the select element
	$select3 = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=2',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select3.html('');
			//iterate over the data and append a select option
			$select3.append('<option value="">-- Sel. Fun��o --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select3.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen3').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select3.html('<option id="-1">ERRO</option>');
		}

	});	
	
	/*
	// o modo abaixo,  de buscar fun��es, traz a op��o selecionada no campo anterior//
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=2',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="radiogeraldinamico_subproc"]').change(function() {

        var value_subproc = $(this).val();
        var name_subproc = $(this).attr("name");

        //console.log(value_subproc + ' <<>> ' + name_subproc);

        $('label[name="radio_' + name_subproc + '"]').removeClass();
        $('label[name="radio_' + name_subproc + '"]').addClass("btn btn-default");
        $('#radio_' + name_subproc + value_subproc).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_subproc).addClass("btn btn-warning active");
		
		if(value_subproc == "S"){
			$("#"+name_subproc).css("display","");
		}else{
			$("#"+name_subproc).css("display","none");
		}
		
	});

}

/*
 * Fun��o respons�vel por adicionar novos campos de Procedimento dinamicamente no
 * formul�rio de or�amento/tratametno
 */
function adicionaProcedimento() {

    var pn = $("#PMCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pn++; //text box increment
    $("#PMCount").val(pn);
    //console.log(pn);

    if (pn >= 2) {
        //console.log( $("#listadinamicac"+(pn-1)).val() );
        var chosen;
        chosen = $("#listadinamica_comp"+(pn-1)).val();
        //console.log( chosen + ' :: ' + pn );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pn+'">\
			<div class="panel panel-warning">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="Procedimento'+pn+'">Proced.:</label>\
							<textarea class="form-control" id="Procedimento'+pn+'"\
									  name="Procedimento'+pn+'"></textarea>\
						</div>\
						<div class="col-md-4">\
							<label for="Compartilhar'+pn+'">Quem Fazer:</label>\
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen3"\
									 id="listadinamica_comp'+pn+'" name="Compartilhar'+pn+'">\
								<option value=""></option>\
							</select>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="DataProcedimento'+pn+'">Data do Proced.:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
									   name="DataProcedimento'+pn+'" id="DataProcedimento'+pn+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="HoraProcedimento'+pn+'">Hora Proced.</label>\
							<div class="input-group TimePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-time"></span>\
								</span>\
								<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
									   name="HoraProcedimento'+pn+'"  id="HoraProcedimento'+pn+'" value="'+currentDate.format('HH:mm')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ConcluidoProcedimento">Proc. Concl.? </label><br>\
							<div class="btn-group" data-toggle="buttons">\
								<label class="btn btn-warning active" name="radio_ConcluidoProcedimento'+pn+'" id="radio_ConcluidoProcedimento'+pn+'N">\
								<input type="radio" name="ConcluidoProcedimento'+pn+'" id="rdgrldnmc_prm"\
									onchange="carregaConclProc(this.value,this.name,'+pn+',0)" autocomplete="off" value="N" checked>N�o\
								</label>\
								<label class="btn btn-default" name="radio_ConcluidoProcedimento'+pn+'" id="radio_ConcluidoProcedimento'+pn+'S">\
								<input type="radio" name="ConcluidoProcedimento'+pn+'" id="rdgrldnmc_prm"\
									onchange="carregaConclProc(this.value,this.name,'+pn+',0)" autocomplete="off" value="S">Sim\
								</label>\
							</div>\
						</div>\
						<div class="col-md-4">\
							<div class="row">\
								<div id="ConcluidoProcedimento'+pn+'" style="display:none">\
									<div class="col-md-6">\
										<label for="DataConcluidoProcedimento'+pn+'">Data Concl</label>\
										<div class="input-group DatePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-calendar"></span>\
											</span>\
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
												   name="DataConcluidoProcedimento'+pn+'"  id="DataConcluidoProcedimento'+pn+'" value="">\
										</div>\
									</div>\
									<div class="col-md-6">\
										<label for="HoraConcluidoProcedimento'+pn+'">Hora Concl.</label>\
										<div class="input-group TimePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-time"></span>\
											</span>\
											<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
												   name="HoraConcluidoProcedimento'+pn+'"  id="HoraConcluidoProcedimento'+pn+'" value="">\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pn+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

		
	//get a reference to the select element
	$select3 = $('#listadinamica_comp'+pn);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json3.php?q=30',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select3.html('');
			//iterate over the data and append a select option
			$select3.append('<option value="">-- Sel. Quem Fazer --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select3.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen3').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select3.html('<option id="-1">ERRO</option>');
		}

	});	

    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="rdgrldnmc_prm"]').change(function() {

        var value_prm = $(this).val();
        var name_prm = $(this).attr("name");

        //console.log(value_prm + ' <<>> ' + name_prm);

        $('label[name="radio_' + name_prm + '"]').removeClass();
        $('label[name="radio_' + name_prm + '"]').addClass("btn btn-default");
        $('#radio_' + name_prm + value_prm).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_prm).addClass("btn btn-warning active");
		if(value_prm == "S"){
			$("#"+name_prm).css("display","");
		}else{
			$("#"+name_prm).css("display","none");
		}
		
    });
	
}

/*
 * Fun��o respons�vel por adicionar novos campos de SubTarefas dinamicamente no
 * formul�rio de tarefa
 */
function adicionaSubProcedimento() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    if (pt >= 2) {
        //console.log( $("#listadinamicae"+(pt-1)).val() );
        var chosen2;
        chosen2 = $("#listadinamicae"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }	

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-6">\
							<label for="SubProcedimento'+pt+'">A��o:</label>\
							<textarea class="form-control" id="SubProcedimento'+pt+'"\
									  name="SubProcedimento'+pt+'"></textarea>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="DataSubProcedimento'+pt+'">Cadastrada em:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" readonly=""\
									   name="DataSubProcedimento'+pt+'" id="DataSubProcedimento'+pt+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="HoraSubProcedimento'+pt+'">�s</label>\
							<div class="input-group TimePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-time"></span>\
								</span>\
								<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
									   name="HoraSubProcedimento'+pt+'"  id="HoraSubProcedimento'+pt+'" value="'+currentDate.format('HH:mm')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ConcluidoSubProcedimento">Concluido? </label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'N">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico_subproc"\
										onchange="carregaConclSubProc(this.value,this.name,'+pt+',0)" autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'S">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico_subproc"\
										onchange="carregaConclSubProc(this.value,this.name,'+pt+',0)" autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-4">\
							<div id="ConcluidoSubProcedimento'+pt+'" style="display:none">\
								<div class="row">\
									<div class="col-md-6">\
										<label for="DataConcluidoSubProcedimento'+pt+'">Data Concl</label>\
										<div class="input-group DatePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-calendar"></span>\
											</span>\
											<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
												   name="DataConcluidoSubProcedimento'+pt+'"  id="DataConcluidoSubProcedimento'+pt+'" value="">\
										</div>\
									</div>\
									<div class="col-md-6">\
										<label for="HoraConcluidoSubProcedimento'+pt+'">�s</label>\
										<div class="input-group TimePicker">\
											<span class="input-group-addon" disabled>\
												<span class="glyphicon glyphicon-time"></span>\
											</span>\
											<input type="text" class="form-control Time" maxlength="5" placeholder="HH:MM" readonly=""\
												   name="HoraConcluidoSubProcedimento'+pt+'"  id="HoraConcluidoSubProcedimento'+pt+'" value="">\
										</div>\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=7',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            //$select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	
    //get a reference to the select2 element
    $select2 = $('#listadinamicae'+pt);	
	
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=10',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select2
            $select2.html('');
            //iterate over the data and append a select2 option
            //$select2.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen2)
                    $select2.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select2.html('<option id="-1">ERRO</option>');
        }

    });	
	
    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="radiogeraldinamico_subproc"]').change(function() {

        var value_subproc = $(this).val();
        var name_subproc = $(this).attr("name");

        //console.log(value_subproc + ' <<>> ' + name_subproc);

        $('label[name="radio_' + name_subproc + '"]').removeClass();
        $('label[name="radio_' + name_subproc + '"]').addClass("btn btn-default");
        $('#radio_' + name_subproc + value_subproc).addClass("btn btn-warning active");
        //$('#radiogeral'+ value_subproc).addClass("btn btn-warning active");
		
		if(value_subproc == "S"){
			$("#"+name_subproc).css("display","");
		}else{
			$("#"+name_subproc).css("display","none");
		}
		
	});

}

function adicionaSubTarefa() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    if (pt >= 2) {
        //console.log( $("#listadinamicae"+(pt-1)).val() );
        var chosen2;
        chosen2 = $("#listadinamicae"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }	

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="SubProcedimento'+pt+'">A��o:</label>\
							<textarea class="form-control" id="SubProcedimento'+pt+'"\
									  name="SubProcedimento'+pt+'"></textarea>\
						</div>\
						<div class="col-md-2">\
							<label for="DataSubProcedimento'+pt+'">Iniciar em:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataSubProcedimento'+pt+'" value="'+currentDate.format('DD/MM/YYYY')+'">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="DataSubProcedimentoLimite'+pt+'">Concluir em:</label>\
							<div class="input-group DatePicker">\
								<span class="input-group-addon" disabled>\
									<span class="glyphicon glyphicon-calendar"></span>\
								</span>\
								<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"\
									   name="DataSubProcedimentoLimite'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ConcluidoSubProcedimento">Concluido? </label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'N">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico"\
										autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_ConcluidoSubProcedimento'+pt+'" id="radio_ConcluidoSubProcedimento'+pt+'S">\
									<input type="radio" name="ConcluidoSubProcedimento'+pt+'" id="radiogeraldinamico"\
										autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=7',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            //$select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	
    //get a reference to the select2 element
    $select2 = $('#listadinamicae'+pt);	
	
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=10',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select2
            $select2.html('');
            //iterate over the data and append a select2 option
            //$select2.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen2)
                    $select2.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select2.html('<option id="-1">ERRO</option>');
        }

    });	
	
    //permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");
        //$('#radiogeral'+ value).addClass("btn btn-warning active");

    });	

}

function adicionaValor() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-3">\
							<label for="ValorProduto'+pt+'">Valor :</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=5',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });

}

function adicionaValor2() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-4">\
							<label for="Fornecedor'+pt+'">Fornecedor:</label>\
							<select data-placeholder="Selecione uma op��o..." class="form-control"\
									 id="listadinamicad'+pt+'" name="Fornecedor'+pt+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
						<div class="col-md-4">\
							<label for="Convdesc'+pt+'">Descri��o:</label>\
							<input type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value="">\
						</div>\
						<div class="col-md-3">\
							<label for="ValorProduto'+pt+'">Valor :</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=5',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });

}

function adiciona_atributo() {
	
    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

	if (pt >= 2) {
        //console.log( $("#listadinamica2"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamica2"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }
	
    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-5">\
							<label for="idTab_Atributo">Atributo '+pt+':</label><br>\
							<select class="form-control Chosen" id="listadinamica2'+pt+'" name="idTab_Atributo'+pt+'">\
								<option value="">-- Selecione o Atributo --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
	
	//get a reference to the select element
	$select = $('#listadinamica2'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=16',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Selecione o Atributo--</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op??es",
				single_text: "Selecione uma op??o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	

}

function adiciona_opcao() {

	var pt2 = $("#POCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt2++; //text box increment
    $("#POCount").val(pt2);
    //console.log(pt2);

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-6">\
							<label for="Opcao'+pt2+'">Opcao '+pt2+'</label><br>\
							<input type="text" class="form-control" id="Opcao'+pt2+'" maxlength="44"\
								name="Opcao'+pt2+'" value="">\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt2+'" class="remove_field32 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
	
}

function adiciona_opcao_select2() {

	var pt2 = $("#PT2Count").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt2++; //text box increment
    $("#PT2Count").val(pt2);
    //console.log(pt2);

    if (pt2 >= 2) {
        //console.log( $("#listadinamica2"+(pt2-1)).val() );
        var chosen;
        chosen = $("#listadinamica2"+(pt2-1)).val();
        //console.log( chosen + ' :: ' + pt2 );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-success">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-10">\
							<label for="idTab_Opcao2">Opcao '+pt2+'</label><br>\
							<select class="form-control Chosen2" id="listadinamica2'+pt2+'" name="idTab_Opcao2'+pt2+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt2+'" class="remove_field32 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
	
	//get a reference to the select element
	$select = $('#listadinamica2'+pt2);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=102',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Opcao Atr. 1 --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen2').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1"></option>');
		}

	});	
	
}

function adiciona_precos() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="TempoDeEntrega'+pt+'">Prazo De Entrega</label><br>\
							<div class="input-group id="TempoDeEntrega'+pt+'">\
								<input type="text" class="form-control Numero text-right" id="TempoDeEntrega'+pt+'" maxlength="3" placeholder="0" \
									name="TempoDeEntrega'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">Dia(s)</span>\
							</div>\
						</div>\
						<div class="col-md-4">\
							<label for="Convdesc'+pt+'">Desc. Embal:</label>\
							<textarea type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value=""></textarea>\
						</div>\
						<div class="col-md-1 text-right">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="ComissaoVenda'+pt+'">ComissaoVenda</label><br>\
							<div class="input-group id="ComissaoVenda'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoVenda'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoVenda'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoServico'+pt+'">ComissaoServico</label><br>\
							<div class="input-group id="ComissaoServico'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoServico'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoServico'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoCashBack'+pt+'">CashBack</label><br>\
							<div class="input-group id="ComissaoCashBack'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoCashBack'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoCashBack'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaBalcaoPreco">VendaBalcao?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'N">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'S">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaSitePreco">VendaSite?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'N">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'S">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
    
	//permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");

    });	
	
}

function adiciona_item_promocao() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-6">\
							<label for="idTab_Produtos">Item '+pt+'*:</label><br>\
							<select class="form-control Chosen" id="listadinamicad'+pt+'" name="idTab_Produtos'+pt+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd*:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdEmb*:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">ValorEmbal*:</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="TempoDeEntrega'+pt+'">Prazo De Entrega:</label><br>\
							<div class="input-group id="TempoDeEntrega'+pt+'">\
								<input type="text" class="form-control Numero text-right" id="TempoDeEntrega'+pt+'" maxlength="3" placeholder="0" \
									name="TempoDeEntrega'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">Dia(s)</span>\
							</div>\
						</div>\
						<div class="col-md-4">\
							<label for="Convdesc'+pt+'">Desc. Embal:</label>\
							<textarea type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value=""></textarea>\
						</div>\
						<div class="col-md-1 text-right">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-2">\
							<label for="ComissaoVenda'+pt+'">ComissaoVenda:</label><br>\
							<div class="input-group id="ComissaoVenda'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoVenda'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoVenda'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoServico'+pt+'">ComissaoServico:</label><br>\
							<div class="input-group id="ComissaoServico'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoServico'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoServico'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoCashBack'+pt+'">CashBack:</label><br>\
							<div class="input-group id="ComissaoCashBack'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoCashBack'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoCashBack'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
    
	//permite o uso de radio buttons nesse bloco din�mico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //console.log(value + ' <<>> ' + name);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");

    });	
	
}
 
function adiciona_item_promocao2() {

	var pt2 = $("#PT2Count").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt2++; //text box increment
    $("#PT2Count").val(pt2);
    //console.log(pt2);

    if (pt2 >= 2) {
        //console.log( $("#listadinamica2"+(pt2-1)).val() );
        var chosen;
        chosen = $("#listadinamica2"+(pt2-1)).val();
        //console.log( chosen + ' :: ' + pt2 );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap32").append('\
        <div class="form-group" id="32div'+pt2+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto2">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto2'+pt2+'" placeholder="0"\
								    name="QtdProdutoDesconto2'+pt2+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-5">\
							<label for="idTab_Produtos2">Item '+pt2+':</label><br>\
							<select class="form-control Chosen2" id="listadinamica2'+pt2+'" name="idTab_Produtos2'+pt2+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc2'+pt2+'">Desc. Embal:</label>\
							<input type="text" class="form-control" id="Convdesc2'+pt2+'"\
									  name="Convdesc2'+pt2+'" value="">\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento2">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento2'+pt2+'" placeholder="0"\
								    name="QtdProdutoIncremento2'+pt2+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto2'+pt2+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto2'+pt2+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto2'+pt2+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto2'+pt2+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt2+'" class="remove_field32 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamica2'+pt2);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=13',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen2').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
	
}
 
function adiciona_item_promocao3() {

    var pt3 = $("#PT3Count").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt3++; //text box increment
    $("#PT3Count").val(pt3);
    //console.log(pt3);

    if (pt3 >= 2) {
        //console.log( $("#listadinamica3"+(pt3-1)).val() );
        var chosen;
        chosen = $("#listadinamica3"+(pt3-1)).val();
        //console.log( chosen + ' :: ' + pt3 );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap33").append('\
        <div class="form-group" id="33div'+pt3+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto3">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto3'+pt3+'" placeholder="0"\
								    name="QtdProdutoDesconto3'+pt3+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-5">\
							<label for="idTab_Produtos3">Item '+pt3+':</label><br>\
							<select class="form-control Chosen3" id="listadinamica3'+pt3+'" name="idTab_Produtos3'+pt3+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc3'+pt3+'">Desc. Embal:</label>\
							<input type="text" class="form-control" id="Convdesc3'+pt3+'"\
									  name="Convdesc3'+pt3+'" value="">\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento3">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento3'+pt3+'" placeholder="0"\
								    name="QtdProdutoIncremento3'+pt3+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto3'+pt3+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto3'+pt3+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto3'+pt3+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto3'+pt3+'" value="">\
							</div>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<button type="button" id="'+pt3+'" class="remove_field33 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	/*
    //get a reference to the select element
    $select = $('#listadinamicad'+pt);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=12',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma op��o --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                if (val.id == chosen)
                    $select.append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                else
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaB');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });
	*/
	
	//get a reference to the select element
	$select = $('#listadinamica3'+pt3);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=14',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen3').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});	
	
}

function adiciona_item_promocao5() {

    var pt = $("#PTCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    pt++; //text box increment
    $("#PTCount").val(pt);
    //console.log(pt);

    if (pt >= 2) {
        //console.log( $("#listadinamicad"+(pt-1)).val() );
        var chosen;
        chosen = $("#listadinamicad"+(pt-1)).val();
        //console.log( chosen + ' :: ' + pt );
    }

    //Captura a data do dia e carrega no campo correspondente
    //var currentDate = moment();

    $(".input_fields_wrap3").append('\
        <div class="form-group" id="3div'+pt+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-1">\
							<label for="QtdProdutoDesconto">QtdPrd:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoDesconto'+pt+'" placeholder="0"\
								    name="QtdProdutoDesconto'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-6">\
							<label for="idTab_Produtos">Item '+pt+':</label><br>\
							<select class="form-control Chosen" id="listadinamicad'+pt+'" name="idTab_Produtos'+pt+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
						<div class="col-md-2">\
							<label for="Convdesc'+pt+'">Desc. Embal:</label>\
							<textarea type="text" class="form-control" id="Convdesc'+pt+'"\
									  name="Convdesc'+pt+'" value=""></textarea>\
						</div>\
						<div class="col-md-1">\
							<label for="QtdProdutoIncremento">QtdEmb:</label><br>\
							<div class="input-group">\
								<input type="text" class="form-control Numero" maxlength="10" id="QtdProdutoIncremento'+pt+'" placeholder="0"\
								    name="QtdProdutoIncremento'+pt+'" value="1">\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ValorProduto'+pt+'">ValorEmbal</label><br>\
							<div class="input-group id="ValorProduto'+pt+'">\
								<span class="input-group-addon" id="basic-addon1">R$</span>\
								<input type="text" class="form-control Valor" id="ValorProduto'+pt+'" maxlength="10" placeholder="0,00" \
									name="ValorProduto'+pt+'" value="">\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-1 text-right"></div>\
						<div class="col-md-2">\
							<label for="AtivoPreco">Ativo?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_AtivoPreco'+pt+'" id="radio_AtivoPreco'+pt+'N">\
									<input type="radio" name="AtivoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_AtivoPreco'+pt+'" id="radio_AtivoPreco'+pt+'S">\
									<input type="radio" name="AtivoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaBalcaoPreco">VendaBalcao?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'N">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_VendaBalcaoPreco'+pt+'" id="radio_VendaBalcaoPreco'+pt+'S">\
									<input type="radio" name="VendaBalcaoPreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="VendaSitePreco">VendaSite?</label><br>\
							<div class="form-group">\
								<div class="btn-group" data-toggle="buttons">\
									<label class="btn btn-warning active" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'N">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="N" checked>N�o\
									</label>\
									<label class="btn btn-default" name="radio_VendaSitePreco'+pt+'" id="radio_VendaSitePreco'+pt+'S">\
									<input type="radio" name="VendaSitePreco'+pt+'" id="radiogeraldinamico"\
										 autocomplete="off" value="S">Sim\
									</label>\
								</div>\
							</div>\
						</div>\
						<div class="col-md-2">\
							<label for="ComissaoVenda'+pt+'">Comissao</label><br>\
							<div class="input-group id="ComissaoVenda'+pt+'">\
								<input type="text" class="form-control Valor text-right" id="ComissaoVenda'+pt+'" maxlength="10" placeholder="0,00" \
									name="ComissaoVenda'+pt+'" value="">\
								<span class="input-group-addon" id="basic-addon1">%</span>\
							</div>\
						</div>\
						<div class="col-md-2 text-right"></div>\
						<div class="col-md-1 text-right">\
							<label><br></label><br>\
							<button type="button" id="'+pt+'" class="remove_field3 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</button>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box
    //habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

	//get a reference to the select element
	$select = $('#listadinamicad'+pt);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=122',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Produto --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});
	
	//permite o uso de radio buttons nesse bloco din�mico
	$('input:radio[id="radiogeraldinamico"]').change(function() {

		var value = $(this).val();
		var name = $(this).attr("name");

		//console.log(value + ' <<>> ' + name);

		$('label[name="radio_' + name + '"]').removeClass();
		$('label[name="radio_' + name + '"]').addClass("btn btn-default");
		$('#radio_' + name + value).addClass("btn btn-warning active");

	});	
	
}
/*
  * Fun��o criada para funcionar junto com o recurso de hide/show do jquery nos
  * casos de radio button, que exigem um tratamento especial para funcionar
  * corretamente
  *
  * @param {string} campo
  * @param {string} hideshow
  */
 function radioButtonColorNS(campo, hideshow) {

     if (hideshow == 'showradio') {
        active = 'showradio';
        not = 'hideradio';
     } else {
        active = 'hideradio';
        not = 'showradio';
     }

     $('label[name="' + campo + '_' + not + '"]').removeClass();
     $('label[name="' + campo + '_' + not + '"]').addClass("btn btn-default");

     $('label[name="' + campo + '_' + active + '"]').removeClass();
     $('label[name="' + campo + '_' + active + '"]').addClass("btn btn-warning active");

 }

/*
 * Fun��o respons�vel por capturar o servi�o/produto selecionado e buscar seu valor
 * correspondente no arquivo Valor_json.php. Ap�s obter o valor ele �
 * aplicado no campo de Valor correspondente.
 *
 * @param {int} id
 * @param {string} campo
 * @param {string} tabela
 * @returns {decimal}
 */

function adicionaTipo() {

    var at = $("#TCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    at++; //text box increment
    $("#TCount").val(at);
    //console.log(at);

    if (at >= 2) {
        //console.log( $("#listadinamicad"+(at-1)).val() );
        var chosen;
        chosen = $("#listadinamica99"+(at-1)).val();
        //console.log( chosen + ' :: ' + at );
		
    }

    $(".input_fields_wrap99").append('\
        <div class="form-group" id="99div'+at+'">\
			<div class="panel panel-info">\
				<div class="panel-heading">\
					<div class="row">\
						<div class="col-md-10">\
							<label for="idTab_Opcao2">Opcao '+at+'</label><br>\
							<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" id="listadinamica99'+at+'" name="idTab_Opcao2'+at+'">\
								<option value="">-- Selecione uma op��o --</option>\
							</select>\
						</div>\
						<div class="col-md-1">\
							<label><br></label><br>\
							<a href="#" id="'+at+'" class="remove_field99 btn btn-danger">\
								<span class="glyphicon glyphicon-trash"></span>\
							</a>\
						</div>\
					</div>\
				</div>\
			</div>\
        </div>'
    ); //add input box

	//get a reference to the select element
	$select = $('#listadinamica99'+at);

	//request the JSON data and parse into the select element
	$.ajax({
		url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=101',
		dataType: 'JSON',
		type: "GET",
		success: function (data) {
			//clear the current content of the select
			$select.html('');
			//iterate over the data and append a select option
			$select.append('<option value="">-- Sel. Opcao --</option>');
			$.each(data, function (key, val) {
				//alert(val.id);
				$select.append('<option value="' + val.id + '">' + val.name + '</option>');
			})
			$('.Chosen').chosen({
				disable_search_threshold: 10,
				multiple_text: "Selecione uma ou mais op��es",
				single_text: "Selecione uma op��o",
				no_results_text: "Nenhum resultado para",
				width: "100%"
			});
		},
		error: function () {
			//alert('erro listadinamicaB');
			//if there is an error append a 'none available' option
			$select.html('<option id="-1">ERRO</option>');
		}

	});

}

$("#first-choice").change(function () {

    var $dropdown = $(this);
    var items = [];

    $.getJSON("dt.json", function (data) {

        $.each(data, function (key, val) {
            items.push(val + '<br>');
        });

        $.getJSON("data.json", function (data) {

            var key = $dropdown.val();
            var vals = [];

            if (key == 'beverages')
                vals = data.beverages.split(",");
            else if (key == 'snacks')
                vals = data.snacks.split(",");
            else
                vals = ['Please choose from above'];

            var $secondChoice = $("#second-choice");
            $secondChoice.empty();
            $.each(vals, function (index, value) {
                $secondChoice.append("<option>" + value + "</option>");
            });
            $(".Chosen").trigger("chosen:updated");
        });

        $("#demo").html(items);
        //alert('opa');
    });

});

//Fun��es dos produtos do formul�rio de receiras e despesas
$(document).ready(function () {

    $(".Date").mask("99/99/9999");
	$(".Cnpj").mask("99.999.999/9999-99");
    $(".Time").mask("99:99");
    $(".Cpf").mask("99999999999");
    $(".Cep").mask("99999999");
	$(".Rg").mask("999999999");
    $(".TituloEleitor").mask("9999.9999.9999");
    $(".Valor").mask("#.##0,00", {reverse: true});
    $(".ValorPeso").mask("#.##0,000", {reverse: true});
	$(".Peso").mask("#.##0,000", {reverse: true});
    $('.Numero').mask('0#');

    $(".Celular").mask("99999999999");
    $(".CelularVariavel").on("blur", function () {
        var last = $(this).val().substr($(this).val().indexOf("-") + 1);

        if (last.length == 3) {
            var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
            var lastfour = move + last;

            var first = $(this).val().substr(0, 9);

            $(this).val(first + '-' + lastfour);
        }
    });

	
    $("[data-toggle='tooltip']").tooltip();

    $('input:radio[id="radio"]').change(function() {

        var value = $(this).val();

        if (value == 1)
            var btn = "btn btn-warning active";
        else if (value == 2)
            var btn = "btn btn-success active";
        else if (value == 3)
            var btn = "btn btn-primary active";
        else
            var btn = "btn btn-danger active";

        $('label[name="radio"]').removeClass();
        $('label[name="radio"]').addClass("btn btn-default");
        $('#radio'+ value).addClass(btn);

    });

    //permite o uso de radio buttons em blocos est�ticos
    $('input:radio[id="radiobutton"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radiobutton_' + name + '"]').removeClass();
        $('label[name="radiobutton_' + name + '"]').addClass("btn btn-default");
        $('#radiobutton_' + name + value).addClass("btn btn-warning active");

    });

    //permite o uso de radio buttons em blocos din�micos
    $('input:radio[id="radiobuttondinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radiobutton_' + name + '"]').removeClass();
        $('label[name="radiobutton_' + name + '"]').addClass("btn btn-default");
        $('#radiobutton_' + name + value).addClass("btn btn-warning active");

    });
	
    //permite o uso de radio buttons em blocos din�micos
    $('input:radio[id="VendaSite1"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radiobutton_' + name + '"]').removeClass();
        $('label[name="radiobutton_' + name + '"]').addClass("btn btn-default");
        $('#radiobutton_' + name + value).addClass("btn btn-warning active");

    });	
	
    //adiciona campos dinamicamente dos Produtos Vendidos 
	var pc = $("#PCount").val(); //initlal text box count
	$(".add_field_button9").click(function(e){ //on add input button click
		
        var recorrencias = $('#Recorrencias').val();
		//console.log('Recorrencias no produto = ' + recorrencias);
		
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco = 'q=90';
			var tipo_orca = $('#Tipo_Orca').val();
			//var escrita = 'readonly=""';
			var escrita = '';
			var buscavalor = 'buscaValor1Tabelas';
			var tblbusca = 'Valor';
		}
		if (negocio == 2) {
			var endereco = 'q=20';
			var tipo_orca = $('#Tipo_Orca').val();
			var escrita = '';
			var buscavalor = 'buscaValor2Tabelas';
			var tblbusca = 'Produtos';
		}
		
		var empresa = $('#Empresa').val();
		//console.log( empresa );
		////Ver uma solu��o para os campos dispon�veis da empresa 42
		if(empresa == 42) {
			$('.campos').show();
		}
		if(empresa == 2) {
			$('.campos').hide();
		}

		e.preventDefault();
		
        pc++; //text box increment
        $("#PCount").val(pc);
		//console.log($("#PCount").val(pc));
        $(".input_fields_wrap9").append('\
            <div class="form-group" id="9div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
						<div class="row">\
							<div class="col-md-8">\
								<input type="hidden" class="form-control" id="idTab_Valor_Produto'+pc+'" name="idTab_Valor_Produto'+pc+'" value="">\
								<input type="hidden" class="form-control" id="idTab_Produtos_Produto'+pc+'" name="idTab_Produtos_Produto'+pc+'" value="">\
								<input type="hidden" class="form-control" id="ComissaoProduto'+pc+'" name="ComissaoProduto'+pc+'" value="0.00">\
								<input type="hidden" class="form-control" id="ComissaoServicoProduto'+pc+'" name="ComissaoServicoProduto'+pc+'" value="0.00">\
								<input type="hidden" class="form-control" id="ComissaoCashBackProduto'+pc+'" name="ComissaoCashBackProduto'+pc+'" value="0.00">\
								<input type="hidden" class="form-control" id="Prod_Serv_Produto'+pc+'" name="Prod_Serv_Produto'+pc+'" value="">\
								<input type="hidden" class="form-control" id="NomeProduto'+pc+'" name="NomeProduto'+pc+'" value="">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="idTab_Produto">Produto '+pc+':</label><br>\
										<select class="form-control Chosen" id="listadinamicab'+pc+'" name="idTab_Produto'+pc+'" onchange="'+buscavalor+'(this.value,this.name,\''+tblbusca+'\','+pc+',\'Produto\','+recorrencias+'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')">\
											<option value="">-- Selecione uma op��o --</option>\
										</select>\
									</div>\
								</div>\
								<div id="EscreverProduto'+pc+'" style="display:none">\
									<div class="row">\
										<div class="col-md-2">\
											<label for="QtdProduto">Qtd.Item</label><br>\
											<input type="text" class="form-control Numero" maxlength="10" id="QtdProduto'+pc+'" placeholder="0"\
												onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
											   autofocus name="QtdProduto'+pc+'" value="1">\
										</div>\
										<div class="col-md-2">\
											<label for="QtdIncrementoProduto">Qtd.Embl</label><br>\
											<input type="text" class="form-control Numero" maxlength="10" id="QtdIncrementoProduto'+pc+'" placeholder="0" '+ escrita +' \
												onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTDINC\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeydown="calculaSubtotal(this.value,this.name,'+pc+',\'QTDINC\',\'Produto\'),calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
											   name="QtdIncrementoProduto'+pc+'" value="1">\
										</div>\
										<input type="hidden" class="form-control" id="SubtotalComissaoProduto'+pc+'" name="SubtotalComissaoProduto'+pc+'" value="0.00">\
										<input type="hidden" class="form-control" id="SubtotalComissaoServicoProduto'+pc+'" name="SubtotalComissaoServicoProduto'+pc+'" value="0.00">\
										<input type="hidden" class="form-control" id="SubtotalComissaoCashBackProduto'+pc+'" name="SubtotalComissaoCashBackProduto'+pc+'" value="0.00">\
										<div class="col-md-2">\
											<label for="SubtotalQtdProduto">Sub.Qtd.Prod</label><br>\
											<div id="txtHint">\
												<input type="text" class="form-control Numero text-left" maxlength="10" readonly="" id="SubtotalQtdProduto'+pc+'"\
													   name="SubtotalQtdProduto'+pc+'" value="">\
											</div>\
										</div>\
										<div class="col-md-3">\
											<label for="ValorProduto">Valor da Embl</label><br>\
											<div class="input-group id="txtHint">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
													onfocus="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')" onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\',\'Produto\')"\
													name="ValorProduto'+pc+'" value="">\
											</div>\
										</div>\
										<div class="col-md-3">\
											<label for="SubtotalProduto">Sub.Valor.Prod</label><br>\
											<div class="input-group id="txtHint">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="SubtotalProduto'+pc+'" readonly=""\
													   name="SubtotalProduto'+pc+'" value="">\
											</div>\
										</div>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-4">\
								<div class="row">\
									<div class="col-md-7">\
										<label for="ObsProduto">Obs</label><br>\
										<input type="text" class="form-control" maxlength="200" placeholder="Observacao:" id="ObsProduto'+pc+'"\
										   name="ObsProduto'+pc+'" value=""></input>\
									</div>\
									<div class="col-md-3">\
										<label for="PrazoProduto">Prazo</label><br>\
										<input type="text" class="form-control Numero" maxlength="3" placeholder="0" id="PrazoProduto'+pc+'"\
											onkeyup="calculaPrazoProdutos(\'PrazoProduto\',\'QtdSoma\',\'ProdutoSoma\',0,0,\'CountMax\',0,\'ProdutoHidden\')"\
											name="PrazoProduto'+pc+'" value="0" >\
									</div>\
									<div class="col-md-1 text-left">\
										<label><br></label><br>\
										<a href="#" id="'+pc+'" class="remove_field9 btn btn-danger"\
												onclick="calculaQtdSoma(\'QtdProduto\',\'QtdSoma\',\'ProdutoSoma\',1,'+pc+',\'CountMax\',0,\'ProdutoHidden\')">\
											<span class="glyphicon glyphicon-trash"></span>\
										</a>\
									</div>\
								</div>\
								<div id="EntregueProduto'+pc+'" style="display:none">\
									<div class="row">\
										<div class="col-md-6">\
											<label for="DataConcluidoProduto">Data Entrega</label>\
											<div class="input-group DatePicker">\
												<span class="input-group-addon" disabled>\
													<span class="glyphicon glyphicon-calendar"></span>\
												</span>\
												<input type="text" class="form-control Date" id="DataConcluidoProduto'+pc+'" maxlength="10" placeholder="DD/MM/AAAA"\
													   name="DataConcluidoProduto'+pc+'" value="">\
											</div>\
										</div>\
										<div class="col-md-6">\
											<label for="HoraConcluidoProduto">Hora Entrega</label>\
											<div class="input-group TimePicker">\
												<span class="input-group-addon" disabled>\
													<span class="glyphicon glyphicon-time"></span>\
												</span>\
												<input type="text" class="form-control Time" id="HoraConcluidoProduto'+pc+'" maxlength="5" placeholder="HH:MM"\
													   name="HoraConcluidoProduto'+pc+'" value="">\
											</div>\
										</div>\
									</div>\
									<div class="row">\
										<div class="col-md-6">\
											<label for="ConcluidoProduto">Entregue? </label><br>\
											<div class="btn-group" data-toggle="buttons">\
												<label class="btn btn-warning active" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'N">\
												<input type="radio" name="ConcluidoProduto'+pc+'" id="rdgrldnmc_prd"\
													onchange="carregaEntreguePrd(this.value,this.name,'+pc+',0)" autocomplete="off" value="N" checked>N�o\
												</label>\
												<label class="btn btn-default" name="radio_ConcluidoProduto'+pc+'" id="radio_ConcluidoProduto'+pc+'S">\
												<input type="radio" name="ConcluidoProduto'+pc+'" id="rdgrldnmc_prd"\
													onchange="carregaEntreguePrd(this.value,this.name,'+pc+',0)" autocomplete="off" value="S" >Sim\
												</label>\
											</div>\
										</div>\
									</div>\
									<div id="ConcluidoProduto'+pc+'" style="display:none">\
									</div>\
								</div>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos 
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		//Falta habilitar o bot�o de Tempo ap�s a gera��o dos campos din�micos 
		//$('.TimePicker').datetimepicker(TimePickerOptions);
		
		//get a reference to the select element

		$select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
			
			//url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=90',
			url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco + "&tipo_orca=" + tipo_orca,
			
			dataType: 'JSON',
            type: "GET",
            success: function (data) {
				//clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma op��o --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });
		
		//get a reference to the select element
        $select20 = $('#listadinamica_prof_prod'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=3',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select20.html('');
                //iterate over the data and append a select option
                $select20.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select20.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen20').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select20.html('<option id="-1">ERRO</option>');
            }

        });		
		
		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="rdgrldnmc_prd"]').change(function() {
			
			var value_prd = $(this).val();
			var name_prd = $(this).attr("name");
			//console.log(value_prd + ' <<>> ' + name_prd);
			$('label[name="radio_' + name_prd + '"]').removeClass();
			$('label[name="radio_' + name_prd + '"]').addClass("btn btn-default");
			$('#radio_' + name_prd + value_prd).addClass("btn btn-warning active");
			
			if(value_prd == "S"){
				$("#"+name_prd).css("display","");
			}else{
				$("#"+name_prd).css("display","none");
			}
		});

    });
		
	//adiciona campos dinamicamente dos Servi�os 
    var ps = $("#SCount").val(); //initlal text box count
	$(".add_field_button10").click(function(e){ //on add input button click
        var recorrencias = $('#Recorrencias').val();
		//console.log('Recorrencias no servi�o = ' + recorrencias);
		var negocio = $('#Negocio').val();
		//console.log( negocio );
		
		if (negocio == 1) {
			var endereco_serv = 'q=902';
			var tipo_orca = $('#Tipo_Orca').val();
			//console.log( tipo_orca );
			var escrita_serv = 'readonly=""';
			var buscavalor_serv = 'buscaValor1Tabelas';
			var tblbusca_serv = 'Valor';
		}
		if (negocio == 2) {
			var endereco_serv = 'q=202';
			var tipo_orca = $('#Tipo_Orca').val();
			var escrita_serv = '';
			var buscavalor_serv = 'buscaValor2Tabelas';
			var tblbusca_serv = 'Produtos';
		}
		
		e.preventDefault();
    
		ps++; //text box increment
		$("#SCount").val(ps);
		
		$(".input_fields_wrap10").append('\
			<div class="form-group" id="10div'+ps+'">\
				<div class="panel panel-danger">\
					<div class="panel-heading">\
						<div class="row">\
							<div class="col-md-8">\
								<input type="hidden" class="form-control" id="idTab_Valor_Servico'+ps+'" name="idTab_Valor_Servico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="idTab_Produtos_Servico'+ps+'" name="idTab_Produtos_Servico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="ComissaoServico'+ps+'" name="ComissaoServico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="ComissaoServicoServico'+ps+'" name="ComissaoServicoServico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="ComissaoCashBackServico'+ps+'" name="ComissaoCashBackServico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="Prod_Serv_Servico'+ps+'" name="Prod_Serv_Servico'+ps+'" value="">\
								<input type="hidden" class="form-control" id="NomeServico'+ps+'" name="NomeServico'+ps+'" value="">\
								<div class="row">\
									<div class="col-md-12">\
										<label for="idTab_Servico">Servico '+ps+':</label><br>\
										<select class="form-control Chosen4" id="listadinamica'+ps+'"  name="idTab_Servico'+ps+'" onchange="'+buscavalor_serv+'(this.value,this.name,\''+tblbusca_serv+'\','+ps+',\'Servico\','+recorrencias+'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')">\
											<option value="">-- Selecione uma op��o --</option>\
										</select>\
									</div>\
								</div>\
								<div id="EscreverServico'+ps+'" style="display:none">\
									<div class="row">\
										<div class="col-md-2">\
											<label for="QtdServico">Qtd</label><br>\
											<input type="text" class="form-control Numero" maxlength="10" id="QtdServico'+ps+'" placeholder="0"\
												onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'QTD\',\'Servico\'),calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
												name="QtdServico'+ps+'" value="1">\
										</div>\
										<div class="col-md-2">\
											<label for="QtdIncrementoServico">QtdEmb</label><br>\
											<input type="text" class="form-control Numero" id="QtdIncrementoServico'+ps+'" name="QtdIncrementoServico'+ps+'" value="1" readonly="">\
										</div>\
										<div class="col-md-2">\
											<label for="SubtotalQtdServico">Sub.Qtd.Serv</label><br>\
											<input type="text" class="form-control Numero" id="SubtotalQtdServico'+ps+'" name="SubtotalQtdServico'+ps+'" value="" readonly="">\
										</div>\
										<input type="hidden" class="form-control" id="SubtotalComissaoServico'+ps+'" name="SubtotalComissaoServico'+ps+'" value="0.00">\
										<input type="hidden" class="form-control" id="SubtotalComissaoServicoServico'+ps+'" name="SubtotalComissaoServicoServico'+ps+'" value="0.00">\
										<input type="hidden" class="form-control" id="SubtotalComissaoCashBackServico'+ps+'" name="SubtotalComissaoCashBackServico'+ps+'" value="0.00">\
										<div class="col-md-3">\
											<label for="ValorServico">Valor da Embl</label><br>\
											<div class="input-group">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
													onkeyup="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')" onchange="calculaSubtotal(this.value,this.name,'+ps+',\'VP\',\'Servico\')"\
													name="ValorServico'+ps+'" value="">\
											</div>\
										</div>\
										<div class="col-md-3">\
											<label for="SubtotalServico">Sub.Valor.Serv.</label><br>\
											<div class="input-group id="txtHint">\
												<span class="input-group-addon" id="basic-addon1">R$</span>\
												<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="SubtotalServico'+ps+'"\
													   name="SubtotalServico'+ps+'" value="">\
											</div>\
										</div>\
									</div>\
									<div class="row">\
										<div class="col-md-3">\
											<label for="ProfissionalServico_1'+ps+'">Profissional 1:</label>\
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen_1"\
													 id="listadinamica_prof_1'+ps+'" name="ProfissionalServico_1'+ps+'">\
												<option value=""></option>\
											</select>\
										</div>\
										<div class="col-md-3">\
											<label for="ProfissionalServico_2'+ps+'">Profissional 2:</label>\
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen_2"\
													 id="listadinamica_prof_2'+ps+'" name="ProfissionalServico_2'+ps+'">\
												<option value=""></option>\
											</select>\
										</div>\
										<div class="col-md-3">\
											<label for="ProfissionalServico_3'+ps+'">Profissional 3:</label>\
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen_3"\
													 id="listadinamica_prof_3'+ps+'" name="ProfissionalServico_3'+ps+'">\
												<option value=""></option>\
											</select>\
										</div>\
										<div class="col-md-3">\
											<label for="ProfissionalServico_4'+ps+'">Profissional 4:</label>\
											<select data-placeholder="Selecione uma op��o..." class="form-control Chosen_4"\
													 id="listadinamica_prof_4'+ps+'" name="ProfissionalServico_4'+ps+'">\
												<option value=""></option>\
											</select>\
										</div>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-4">\
								<div class="row">\
									<div class="col-md-7">\
										<label for="ObsServico">Obs</label><br>\
										<input type="text" class="form-control " maxlength="200" id="ObsServico'+ps+'" placeholder="Observacao"\
											name="ObsServico'+ps+'" value="">\
									</div>\
									<div class="col-md-3">\
										<label for="PrazoServico">Prazo</label><br>\
										<input type="text" class="form-control Numero" maxlength="3" placeholder="0" id="PrazoServico'+ps+'"\
											onkeyup="calculaPrazoServicos(\'PrazoServico\',\'QtdSomaDev\',\'ServicoSoma\',0,0,\'CountMax2\',0,\'ServicoHidden\')"\
											name="PrazoServico'+ps+'" value="0" >\
									</div>\
									<div class="col-md-1 text-left">\
										<label><br></label><br>\
										<a href="#" id="'+ps+'" class="remove_field10 btn btn-danger"\
											onclick="calculaQtdSomaDev(\'QtdServico\',\'QtdSomaDev\',\'ServicoSoma\',1,'+ps+',\'CountMax2\',0,\'ServicoHidden\')">\
											<span class="glyphicon glyphicon-trash"></span>\
										</a>\
									</div>\
								</div>\
								<div id="EntregueServico'+ps+'" style="display:none">\
									<div class="row">\
										<div class="col-md-6">\
											<label for="DataConcluidoServico">Data Entrega</label>\
											<div class="input-group DatePicker">\
												<span class="input-group-addon" disabled>\
													<span class="glyphicon glyphicon-calendar"></span>\
												</span>\
												<input type="text" class="form-control Date" id="DataConcluidoServico'+ps+'" maxlength="10" placeholder="DD/MM/AAAA"\
													   name="DataConcluidoServico'+ps+'" value="">\
											</div>\
										</div>\
										<div class="col-md-6">\
											<label for="HoraConcluidoServico">Hora Entrega</label>\
											<div class="input-group TimePicker">\
												<span class="input-group-addon" disabled>\
													<span class="glyphicon glyphicon-time"></span>\
												</span>\
												<input type="text" class="form-control Time" id="HoraConcluidoServico'+ps+'" maxlength="5" placeholder="HH:MM"\
													   name="HoraConcluidoServico'+ps+'" value="">\
											</div>\
										</div>\
									</div>\
									<div class="row">\
										<div class="col-md-6">\
											<label for="ConcluidoServico">Entregue? </label><br>\
											<div class="btn-group" data-toggle="buttons">\
												<label class="btn btn-warning active" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'N">\
												<input type="radio" name="ConcluidoServico'+ps+'" id="rdgrldnmc_srv"\
													onchange="carregaEntregueSrv(this.value,this.name,'+ps+',0)" autocomplete="off" value="N" checked>N�o\
												</label>\
												<label class="btn btn-default" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'S">\
												<input type="radio" name="ConcluidoServico'+ps+'" id="rdgrldnmc_srv"\
													onchange="carregaEntregueSrv(this.value,this.name,'+ps+',0)" autocomplete="off" value="S" >Sim\
												</label>\
											</div>\
										</div>\
									</div>\
									<div id="ConcluidoServico'+ps+'" style="display:none">\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>'
		); //add input box

		//habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
		$select = $('#listadinamica'+ps);

		//request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?' + endereco_serv + "&tipo_orca=" + tipo_orca,
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma op��o --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen4').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });
		
		//get a reference to the select element
        $select_1 = $('#listadinamica_prof_1'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=30',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select_1.html('');
                //iterate over the data and append a select option
                $select_1.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select_1.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen_1').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select_1.html('<option id="-1">ERRO</option>');
            }

        });	
		
		//get a reference to the select element
        $select_2 = $('#listadinamica_prof_2'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=30',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select_2.html('');
                //iterate over the data and append a select option
                $select_2.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select_2.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen_2').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select_2.html('<option id="-1">ERRO</option>');
            }

        });	
		
		//get a reference to the select element
        $select_3 = $('#listadinamica_prof_3'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=30',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select_3.html('');
                //iterate over the data and append a select option
                $select_3.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select_3.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen_3').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select_3.html('<option id="-1">ERRO</option>');
            }

        });	
		
		//get a reference to the select element
        $select_4 = $('#listadinamica_prof_4'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json2.php?q=30',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select_4.html('');
                //iterate over the data and append a select option
                $select_4.append('<option value="">-- Sel. Profis. --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select_4.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen_4').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select_4.html('<option id="-1">ERRO</option>');
            }

        });		

		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="rdgrldnmc_srv"]').change(function() {

			var value_srv = $(this).val();
			var name_srv = $(this).attr("name");

			//console.log(value_srv + ' <<>> ' + name_srv);

			$('label[name="radio_' + name_srv + '"]').removeClass();
			$('label[name="radio_' + name_srv + '"]').addClass("btn btn-default");
			$('#radio_' + name_srv + value_srv).addClass("btn btn-warning active");
		
			if(value_srv == "S"){
				$("#"+name_srv).css("display","");
			}else{
				$("#"+name_srv).css("display","none");
			}

		});
		
	});
			
    //adiciona campos dinamicamente das Categorias
    var ps = $("#SCount").val(); //initlal text box count
    $(".add_field_button93").click(function(e){ //on add input button click
        
		// Coloquei esse c�digo aqui, mas n�o sei se est� fazendo diferen�a!!!/////
		if (ps >= 2) {
			//console.log( $("#listadinamicah"+(ps-1)).val() );
			var chosen;
			chosen = $("#listadinamicah"+(ps-1)).val();
			//console.log( chosen + ' :: ' + ps );
		}
		
		// Termina aqui!!! ////
		
		e.preventDefault();
		
        ps++; //text box increment
        $("#SCount").val(ps);

        $(".input_fields_wrap93").append('\
            <div class="form-group" id="93div'+ps+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
                        <div class="row">\
							<div class="col-md-10">\
								<label for="Cat_Prod'+ps+'">Cat_Prod:</label>\
								<select data-placeholder="Selecione uma op��o..." class="form-control"\
										 id="listadinamicah'+ps+'" name="Cat_Prod'+ps+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+ps+'" class="remove_field93 btn btn-danger"\
										onclick="calculaQtdSoma(\'Cat_Prod\',\'QtdSoma\',\'ProdutoSoma\',1,'+ps+',\'CountMax\',0,\'ProdutoHidden\')">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
        $select = $('#listadinamicah'+ps);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=93',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma op��o --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });				

		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
		
    //adiciona campos dinamicamente das Cor e Tipos	
    var pc = $("#PCount").val(); //initlal text box count
    $(".add_field_button92").click(function(e){ //on add input button click
        
		e.preventDefault();
		/*
		// Coloquei esse c�digo aqui, mas n�o sei se est� fazendo diferen�a!!!/////
		if (pc >= 2) {
			//console.log( $("#listadinamica10"+(pc-1)).val() );
			var chosen;
			chosen = $("#listadinamica10"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );			
		}
		*/
        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap92").append('\
            <div class="form-group" id="92div'+pc+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
						<div class="row">\
							<div class="col-md-10">\
								<label for="Cor_Prod'+pc+'">Tipo '+pc+'</label>\
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen" \
										 id="listadinamica10'+pc+'" name="Cor_Prod'+pc+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+pc+'" class="remove_field92 btn btn-danger">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//get a reference to the select element
        $select = $('#listadinamica10'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=92',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma op��o --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });		
		
		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
	
    //adiciona campos dinamicamente do Atributo 2
    var pm = $("#PMCount").val(); //initlal text box count
    $(".add_field_button91").click(function(e){ //on add input button click
        
		e.preventDefault();

		// Coloquei esse c�digo aqui, mas n�o sei se est� fazendo diferen�a!!!/////
		if (pm >= 2) {
			//console.log( $("#listadinamicag"+(pm-1)).val() );
			var chosen;
			chosen = $("#listadinamicag"+(pm-1)).val();
			//console.log( chosen + ' :: ' + pm );			
		}
		
        pm++; //text box increment
        $("#PMCount").val(pm);

        $(".input_fields_wrap91").append('\
            <div class="form-group" id="91div'+pm+'">\
                <div class="panel panel-warning">\
                    <div class="panel-heading">\
						<div class="row">\
							<div class="col-md-10">\
								<label for="idTab_Opcao3'+pm+'">Opcao '+pm+'</label>\
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen91" \
										 id="listadinamicag'+pm+'" name="idTab_Opcao3'+pm+'">\
									<option value=""></option>\
								</select>\
							</div>\
							<div class="col-md-1">\
								<label><br></label><br>\
								<a href="#" id="'+pm+'" class="remove_field91 btn btn-danger">\
									<span class="glyphicon glyphicon-trash"></span>\
								</a>\
							</div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//get a reference to the select element
        $select = $('#listadinamicag'+pm);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=101',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Sel. Op��o Atr. 2 --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen91').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1"></option>');
            }

        });		
		
		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });
	
    //adiciona campos dinamicamente dos Produtos Derivados 
    var pd = $("#PDCount").val(); //initlal text box count
    $(".add_field_button97").click(function(e){ //on add input button click
        e.preventDefault();
		/*
		// Coloquei esse c�digo aqui, mas n�o sei se est� fazendo diferen�a!!!/////
		if (pc >= 2) {
			//console.log( $("#listadinamicag"+(pc-1)).val() );
			var chosen;
			chosen = $("#listadinamicam"+(pc-1)).val();
			//console.log( chosen + ' :: ' + pc );
			var chosen2;
			chosen2 = $("#listadinamican"+(pc-1)).val();			
		}
		*/
		// Termina aqui!!! ////		
		
        pd++; //text box increment
        $("#PDCount").val(pd);

        $(".input_fields_wrap97").append('\
            <div class="form-group" id="97div'+pd+'">\
                <div class="panel panel-success">\
                    <div class="panel-heading">\
                        <div class="row">\
							<div class="col-md-3">\
								<label for="Nome_Prod'+pd+'">Produto '+pd+'</label>\
								<input type="text" class="form-control" id="Nome_Prod'+pd+'" readonly=""\
										  name="Nome_Prod'+pd+'" value="">\
							</div>\
							<div class="col-md-3">\
								<label for="Opcao_Atributo_2'+pd+'">Atributo1</label>\
								<select data-placeholder="Selecione uma op��o..." class="form-control Chosen2" id="listadinamican'+pd+'" name="Opcao_Atributo_2'+pd+'">\
									<option value="">-- Selecione uma op��o --</option>\
								</select>\
							</div>\
							<div class="col-md-3">\
                                <label for="Opcao_Atributo_1'+pd+'">Atributo2</label>\
                                <select data-placeholder="Selecione uma op��o..." class="form-control Chosen" id="listadinamicam'+pd+'" name="Opcao_Atributo_1'+pd+'">\
                                    <option value="">-- Selecione uma op��o --</option>\
                                </select>\
                            </div>\
							<div class="col-md-2">\
								<label for="Valor_Produto'+pd+'">Valor Custo</label><br>\
								<div class="input-group id="Valor_Produto'+pd+'">\
									<span class="input-group-addon" id="basic-addon1">R$</span>\
									<input type="text" class="form-control Valor" id="Valor_Produto'+pd+'" maxlength="10" placeholder="0,00" \
										name="Valor_Produto'+pd+'" value="">\
								</div>\
							</div>\
							<div class="col-md-1">\
                                <label><br></label><br>\
                                <a href="#" id="'+pd+'" class="remove_field97 btn btn-danger">\
                                    <span class="glyphicon glyphicon-trash"></span>\
                                </a>\
                            </div>\
						</div>\
                    </div>\
                </div>\
            </div>'
        ); //add input box

		//habilita o bot�o de calend�rio ap�s a gera��o dos campos din�micos
		$('.DatePicker').datetimepicker(dateTimePickerOptions);
		
		//get a reference to the select element
        $select = $('#listadinamicam'+pd);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=97',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Sel. Opcao --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1"></option>');
            }

        });
		
		//get a reference to the select element
        $select2 = $('#listadinamican'+pd);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=98',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select2.html('');
                //iterate over the data and append a select option
                $select2.append('<option value="">-- Sel. Opcao --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select2.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
                $('.Chosen2').chosen({
                    disable_search_threshold: 10,
                    multiple_text: "Selecione uma ou mais op��es",
                    single_text: "Selecione uma op��o",
                    no_results_text: "Nenhum resultado para",
                    width: "100%"
                });
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select2.html('<option id="-1"></option>');
            }

        });		

		//permite o uso de radio buttons nesse bloco din�mico
		$('input:radio[id="radiogeraldinamico"]').change(function() {

			var value = $(this).val();
			var name = $(this).attr("name");

			//console.log(value + ' <<>> ' + name);

			$('label[name="radio_' + name + '"]').removeClass();
			$('label[name="radio_' + name + '"]').addClass("btn btn-default");
			$('#radio_' + name + value).addClass("btn btn-warning active");

		});

    });	
			
    //Remove os campos adicionados de Produtos No Or�amento dinamicamente
    $(".input_fields_wrap9").on("click",".remove_field9", function(e){ //user click on remove text
        $("#9div"+$(this).attr("id")).remove();
        //ap�s remover o campo refaz o c�lculo do or�amento e total restante
        calculaOrcamento();
    })	

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap10").on("click",".remove_field10", function(e){ //user click on remove text
        $("#10div"+$(this).attr("id")).remove();
        //ap�s remover o campo refaz o c�lculo do or�amento e total restante
        calculaOrcamento();
    })
	
    //Remove os campos adicionados dinamicamente das Categorias
    $(".input_fields_wrap93").on("click",".remove_field93", function(e){ //user click on remove text
        $("#93div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente das Cores e Tipos
    $(".input_fields_wrap92").on("click",".remove_field92", function(e){ //user click on remove text
        $("#92div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente das Tamanhos
    $(".input_fields_wrap91").on("click",".remove_field91", function(e){ //user click on remove text
        $("#91div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados de Produtos No Or�amento do CONSULTOR dinamicamente
    $(".input_fields_wrap97").on("click",".remove_field97", function(e){ //user click on remove text
        $("#97div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados de Produtos No Or�amento do CONSULTOR dinamicamente
    $(".input_fields_wrap99").on("click",".remove_field99", function(e){ //user click on remove text
        $("#99div"+$(this).attr("id")).remove();
    })

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap3").on("click",".remove_field3", function(e){ //user click on remove text
		$("#3div"+$(this).attr("id")).remove();
    })	
	
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap32").on("click",".remove_field32", function(e){ //user click on remove text
        $("#32div"+$(this).attr("id")).remove();
    })
	
    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap33").on("click",".remove_field33", function(e){ //user click on remove text
        $("#33div"+$(this).attr("id")).remove();
    })	

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap30").on("click",".remove_field30", function(e){ //user click on remove text
        $("#30div"+$(this).attr("id")).remove();
    })
	
    //Remove as PARCELAS dinamicamente
    $(".input_fields_wrap21").on("click",".remove_field21", function(e){ //user click on remove text
        $("#21div"+$(this).attr("id")).remove();
    })
	
    /*
     * Fun��o para capturar o valor escolhido no campo select (Servi�o e Produto, por exemplo)
     */
    $("#addValues").change(function () {
        //var n = $(this).attr("value");
        //var n = $("option:selected", this);

        alert (this.value);

        //alert('oi');
    });

    /*
     * As duas fun��es a seguir servem para exibir ou ocultar uma div em fun��o
     * do seu nome
     */
    $("input[id$='hide']").click(function () {
        var n = $(this).attr("name");
        $("#" + n).hide();
    });
    $("input[id$='show']").click(function () {
        var n = $(this).attr("name");
        $("#" + n).show();
    });

    /*
     * Mesma fun��o que a de cima mas com uma modifica��o para funcionar nos
     * radios buttons e permitir a altern�ncia da cor do bot�o
     */
     $("input[id$='hideradio']").change(function () {
         var n = $(this).attr("name");
         $("#" + n).hide();
         radioButtonColorNS(n, 'hideradio');
     });
     $("input[id$='showradio']").change(function () {
         var n = $(this).attr("name");
         $("#" + n).show();
         radioButtonColorNS(n, 'showradio');
     });

    /*
     * A fun��o a seguir servem para exibir ou ocultar uma div em fun��o do
     * valor selecionado no select/pulldown
     */
    $('#SelectShowHide').change(function () {
        $('.colors').hide();
        $('.div' + $(this).val()).show();
    });

    $('#SelectShowHideId').change(function () {
        var n = $(this).attr("name");
        //alert(n + $(this).val());
        //$('#' + n).hide();
        $('.' + n).hide();
        $('#' + n + $(this).val()).show();
    });

    $('.Chosen').chosen({
        disable_search_threshold: 10,
        multiple_text: "Selecione uma ou mais op��es",
        single_text: "Selecione uma op��o",
        no_results_text: "Nenhum resultado para",
        width: "100%"
    });

    $("button.fc-today-button").click(function () {
        $('#datepickerinline').datetimepicker({
            today: '2011-01-01',
        });
        alert(date);
    });
	
    $('.DatePicker').datetimepicker(dateTimePickerOptions);
    $('.TimePicker').datetimepicker({
        tooltips: {
            today: 'Hoje',
            clear: 'Limpar sele��o',
            close: 'Fechar este menu',
            selectMonth: 'Selecione um m�s',
            prevMonth: 'M�s anterior',
            nextMonth: 'Pr�ximo m�s',
            selectYear: 'Selecione um ano',
            prevYear: 'Ano anterior',
            nextYear: 'Pr�ximo ano',
            selectDecade: 'Selecione uma d�cada',
            prevDecade: 'D�cada anterior',
            nextDecade: 'Pr�xima d�cada',
            prevCentury: 'Centen�rio anterior',
            nextCentury: 'Pr�ximo centen�rio',
            incrementHour: 'Aumentar hora',
            decrementHour: 'Diminuir hora',
            incrementMinute: 'Aumentar minutos',
            decrementMinute: 'Diminuir minutos',
            incrementSecond: 'Aumentar segundos',
            decrementSecond: 'Diminuir segundos',
        },
        showTodayButton: true,
        showClose: true,
        //stepping: 30,
        format: 'HH:mm',
        locale: 'pt-br'
    });
});

$('#datepickerinline').datetimepicker({
    tooltips: {
        today: 'Hoje',
        clear: 'Limpar sele��o',
        close: 'Fechar este menu',
        selectMonth: 'Selecione um m�s',
        prevMonth: 'M�s anterior',
        nextMonth: 'Pr�ximo m�s',
        selectYear: 'Selecione um ano',
        prevYear: 'Ano anterior',
        nextYear: 'Pr�ximo ano',
        selectDecade: 'Selecione uma d�cada',
        prevDecade: 'D�cada anterior',
        nextDecade: 'Pr�xima d�cada',
        prevCentury: 'Centen�rio anterior',
        nextCentury: 'Pr�ximo centen�rio',
        incrementHour: 'Aumentar hora',
        decrementHour: 'Diminuir hora',
        incrementMinute: 'Aumentar minutos',
        decrementMinute: 'Diminuir minutos',
        incrementSecond: 'Aumentar segundos',
        decrementSecond: 'Diminuir segundos'
    },
    inline: true,
    showTodayButton: true,
    //showClear: true,
    format: 'DD/MM/YYYY',
    //defaultDate: '2015-01-01',
    locale: 'pt-br'
});

$("#datepickerinline").on("dp.change", function (e) {
    var d = new Date(e.date);
    $('#calendar').fullCalendar('gotoDate', d);
});

/*
 * veio junto com o �ltimo datetimepicker, n�o parei pra analisar sua relev�ncia
 * vou deixar aqui por enquanto
 * http://eonasdan.github.io/bootstrap-datetimepicker/
 * */

ko.bindingHandlers.dateTimePicker = {
    init: function (element, valueAccessor, allBindingsAccessor) {
        //initialize datepicker with some optional options
        var options = allBindingsAccessor().dateTimePickerOptions || {};
        $(element).datetimepicker(options);
        //when a user changes the date, update the view model
        ko.utils.registerEventHandler(element, "dp.change", function (event) {
            var value = valueAccessor();
            if (ko.isObservable(value)) {
                if (event.date != null && !(event.date instanceof Date)) {
                    value(event.date.toDate());
                } else {
                    value(event.date);
                }
            }
        });
        ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
            var picker = $(element).data("DateTimePicker");
            if (picker) {
                picker.destroy();
            }
        });
    },
    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {

        var picker = $(element).data("DateTimePicker");
        //when the view model is updated, update the widget
        if (picker) {
            var koDate = ko.utils.unwrapObservable(valueAccessor());
            //in case return from server datetime i am get in this form for example /Date(93989393)/ then fomat this
            koDate = (typeof (koDate) !== 'object') ? new Date(parseFloat(koDate.replace(/[^0-9]/g, ''))) : koDate;
            picker.date(koDate);
        }
    }
};

function EventModel() {
    this.ScheduledDate = ko.observable('');
}
ko.applyBindings(new EventModel());
/*
 $("#inputDate").mask("99/99/9999");
 $("#inputDate0").mask("99/99/9999");
 $("#inputDate1").mask("99/99/9999");
 $("#inputDate2").mask("99/99/9999");
 $("#inputDate3").mask("99/99/9999");
 $("#Cpf").mask("999.999.999-99");
 $("#Cep").mask("99999-999");
 $("#TituloEleitor").mask("9999.9999.9999");
 */

$('#popoverData').popover();
$('#popoverOption').popover({trigger: "hover"});
var tempo = 5 * 60 * 60 * 1000;
//var tempo = 10 * 1000;
//var date = new Date(new Date().valueOf() + 60 * 60 * 1000);
var date = new Date(new Date().valueOf() + tempo);
$('#clock').countdown(date, function (event) {
    $(this).html(event.strftime('%H:%M:%S'));
});
var branco = tempo - 1200000;
$('#countdowndiv').delay(branco).queue(function () {
    $(this).addClass("btn-warning");
});
$('#submit').on('click', function () {
    var $btn = $(this).button('loading')
})

jQuery(document).ready(function ($) {
    $(".clickable-row").click(function () {
        if(!$(event.target).hasClass('notclickable'))
           window.location = $(this).data("href");
        else
            event.stopPropagation();
    });

});
setTimeout(function () {
    $('#hidediv').fadeOut('slow');
}, 3000); // <-- time in milliseconds

setTimeout(function () {
    $('#hidediverro').fadeOut('slow');
}, 10000); // <-- time in milliseconds

$(document).ready(function () {
    $(".js-data-example-ajax").select2({
        ajax: {
            url: "https://api.github.com/search/repositories",
            //url: "http://localhost/sisgef/testebd.php",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, page) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                return {
                    results: data.items
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
});
$(document).ready(function () {
    $(".js-example-basic-single").select2();
});
//Determina a raiz do site
var pathArray = window.location.pathname.split('/');
var basePath = window.location.protocol + "//" + window.location.host + "/" + pathArray[1];
$("#series").remoteChained({
    parents: "#mark",
    url: basePath + "/api/teste.php"
});
$("#StatusAntigo").remoteChained({
    parents: "#Especialidade",
    url: basePath + "/api/teste.php",
    loading: "Carregando...",
});
$('#Chosen').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#id_Municipio').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Uf').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Municipio').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#EstadoCivil').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Especialidade').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Cid').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Prestador').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Cirurgia').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Status').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Posicao').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais op��es",
    single_text: "Selecione uma op��o",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#calendar').fullCalendar({
	header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    eventSources: [{
            url: 'Consulta_json.php', // use the `url` property
        }],
    //allDayDefault: true,
    //defaultView: 'agendaWeek',
    defaultView: 'month',
    //contentHeight: 700,
    //height: 'auto',
    height: 500,
    //handleWindowResize: false,
    //aspectRatio: 2,
	//showNonCurrentDates: false,
	fixedWeekCount: false,
    firstDay: '0',
    scrollTime: '06:00',
	//eventLimit: false,
	eventLimit: 6,

	minTime: $('#AgendaI').val(),
    maxTime: $('#AgendaF').val(),	
	
	//minTime: horarioAgendaI,
    //maxTime: horarioAgendaF,	
	
	//minTime: '00:00',
    //maxTime: '24:00',
	
    nowIndicator: true,
    selectable: true,
    //selectHelper: true,
    editable: false,
    timezone: "local",
    lang: 'pt-br',
    eventAfterRender: function (event, element) {
		//console.log('CadastrarPet = '+event.CadastrarPet);
		//console.log('CadastrarDep = '+event.CadastrarDep);
        if (event.Evento == 1){
            var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b>" + event.Obs + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Ocorr�ncia:</b> " + event.Recorrencia + " <b> - </b> " + event.Repeticao + "<br>\n\<b>Termina em:</b> " + event.DataTermino;
        }else{
            if (event.Paciente == 'D'){
                var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs  + "<br>\n\<b>Prof.:</b> " + event.Profissional + "<br>\n\<b>Cliente: </b>" + event.titlecliente + "</b><br><b>Respons�vel:</b> " + event.subtitle + "<br><b>Tel.:</b> " + event.CelularCliente + 
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta + "<br>\n\<b>Ocorr�ncia:</b> " + event.Recorrencia + " <b> - </b> " + event.Repeticao + "<br><b>Termina em:</b> " + event.DataTermino + "<br><b>OS:</b> " + event.OS;
            }else{
                if(event.CadastrarPet == 'S'){
					var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs + "<br>\n\<b>Cliente: </b>" + event.titlecliente + "<b> " + "<br><b>Tel.:</b> " + event.CelularCliente + "<b> " + "<br><b>Pet:</b> " + event.titlepet + "<br>\n\<b>Prof.:</b> " + event.Profissional +  
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta + "<br>\n\<b>Ocorr�ncia:</b> " + event.Recorrencia + " <b> - </b> " + event.Repeticao + "<br><b>Termina em:</b> " + event.DataTermino + "<br><b>OS:</b> " + event.OS;
				}else if(event.CadastrarDep == 'S'){
					var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs + "<br>\n\<b>Cliente: </b>" + event.titlecliente + "<b> " + "<br><b>Tel.:</b> " + event.CelularCliente + "<b> " + "<br><b>Depend.:</b> " + event.titledep + "<br>\n\<b>Prof.:</b> " + event.Profissional +
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta + "<br>\n\<b>Ocorr�ncia:</b> " + event.Recorrencia + " <b> - </b> " + event.Repeticao + "<br><b>Termina em:</b> " + event.DataTermino + "<br><b>OS:</b> " + event.OS;
				}else{
					var title = "<b>Empresa:</b> " + event.NomeEmpresaEmp + "<br>\n\<b>Evento: </b> " + event.Obs + "<br>\n\<b>Cliente: </b>" + event.titlecliente + "<b> " + "<br><b>Tel.:</b> " + event.CelularCliente + "<b> " + "<br>\n\<b>Prof.:</b> " + event.Profissional + 
							"<br>\n\<b>Tipo: </b> " + event.TipoConsulta + "<br>\n\<b>Ocorr�ncia:</b> " + event.Recorrencia + " <b> - </b> " + event.Repeticao + "<br><b>Termina em:</b> " + event.DataTermino + "<br><b>OS:</b> " + event.OS;
				}
			}
		}
        $(element).tooltip({
            title: title,
            container: 'body',
            position: {my: "left bottom-3", at: "center top"},
            placement: 'auto top',
            html: true,
            delay: {"show": 500, "hide": 100},
            template: '<div class="tooltip" role="tooltip" ><div class="tooltip-inner" \n\
                    style="color: #000; border-radius: 4px; text-align: left; border-width: thin; border-style: solid; \n\
                    border-color: #000; background-color: #fff; white-space:pre-wrap;"></div></div>'
        });
    },
    /*
    selectConstraint: {
        start: agora,
        end: '2099-12-31T23:59:00'
    },*/
    select: function (start, end, jsEvent, view) {
        //var re = new RegExp(/^.*\//);
        //window.location = re.exec(window.location.href) + 'cliente/pesquisar?start=' + start + '&end=' + end;

        //alert(start + ' :: ' + end);

        //endtime = $.fullCalendar.formatDate(end, 'HH:mm');
        //starttime = $.fullCalendar.formatDate(start, 'DD/MM/YYYY, HH:mm');
        //var slot = 'start=' + start + '&end=' + end;

        $('#fluxo #start').val(start);
        $('#fluxo #end').val(end);
        //$('#fluxo #slot').text(slot);
        $('#fluxo').modal('show');
    },
});

/*
 * Redireciona o usu�rio de acordo com a op��o escolhida no modal da agenda,
 * que surge ao clicar em algum slot de tempo vazio.
 */

function redirecionar_Funcionando(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consulta/cadastrar_evento' : url = 'consulta/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}
 
 function redirecionar(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    //(x == 1) ? url = 'consulta/cadastrar_evento' : url = 'cliente/pesquisar';
    (x == 1) ? url = 'consulta/cadastrar_evento' : url = 'consulta/cadastrar2';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

function redirecionar1(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consultaconsultor/cadastrar_evento' : url = 'consultaconsultor/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

function redirecionar2(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consultafuncionario/cadastrar_evento' : url = 'consultafuncionario/cadastrar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

function redirecionar3(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 3) ? url = 'consulta/cadastrar_particular' : url = 'cliente/pesquisar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

/*
 * Fun��o para capturar a url com o objetivo de obter a data, ap�s criar/alterar
 * uma consulta, e assim usar a fun��o gotoDate do Fullcalendar para mostrar a
 * agenda na data escolhida
 */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
var gtd = getUrlParameter('gtd');
(gtd) ? $('#calendar').fullCalendar('gotoDate', gtd) : false;

