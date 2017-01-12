// JavaScript Document

var date = new Date();
var d = date.getDate();
var m = date.getMonth() + 1;
var y = date.getFullYear();
var n = date.toISOString();
var tam = n.length - 5;
var agora = n.substring(0, tam);

//sequencia de comandos necessária para estrair a pasta raiz do endereço,
//ou seja, qual módulo está sendo utilizado (ex: salao, odonto, etc)
app = window.location.pathname;
app = app.substring(1);
pos = app.indexOf('/');
app = app.substring(0, pos);

//variável de opções necessária para o funcionamento do datepiker em divs
//geradas dinamicamente
var dateTimePickerOptions = {
    tooltips: {
        today: 'Hoje',
        clear: 'Limpar seleção',
        close: 'Fechar este menu',
        selectMonth: 'Selecione um mês',
        prevMonth: 'Mês anterior',
        nextMonth: 'Próximo mês',
        selectYear: 'Selecione um ano',
        prevYear: 'Ano anterior',
        nextYear: 'Próximo ano',
        selectDecade: 'Selecione uma década',
        prevDecade: 'Década anterior',
        nextDecade: 'Próxima década',
        prevCentury: 'Centenário anterior',
        nextCentury: 'Próximo centenário',
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

/*
 * Função responsável por aplicar a máscara de valor real com separação de
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

/*
 * Função responsável por calcular o subtotal dos campos de produto
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */
function calculaResta(entrada) {

    //recebe o valor do orçamento
    var orcamento = $("#ValorOrca").val();
    var resta = (orcamento.replace(".","").replace(",",".") - entrada.replace(".","").replace(",","."));

    resta = mascaraValorReal(resta);

    //o valor é escrito no seu campo no formulário
    $('#ValorResOrca').val(resta);

}

/*
$(document).on('focus',".input_fields_parcelas", function(){
    $(this).datepicker();
});
*/
/*
 * Função responsável por calcular as parcelas do orçamento em função do dados
 * informados no formulário (valor restante / parcelas e datas do vencimento)
 */
function calculaParcelas() {

    //captura os valores dos campos indicados
    var resta = $("#ValorResOrca").val();
    var parcelas = $("#QtdParcOrca").val();
    var vencimento = $("#DataVencOrca").val();

    //valor de cada parcela
    var parcorca = (resta.replace(".","").replace(",",".") / parcelas);
    parcorca = mascaraValorReal(parcorca);

    //pega a data do primeiro vencimento e separa em dia, mês e ano
    var split = vencimento.split("/");

    //define a data do primeiro vencimento no formato do momentjs
    var currentDate = moment(split[2]+'-'+split[1]+'-'+split[0]);

    //console.log(currentDate.format('DD-MM-YYYY'));
    //console.log(futureMonth.format('DD-MM-YYYY'));
    //alert('>>v '+vencimento+'::d1 '+currentDate.format('DD/MM/YYYY')+'::d2 '+futureMonth.format('DD/MM/YYYY')+'::d3 '+futureMonthEnd.format('DD/MM/YYYY')+'<<');

    //caso as parcelas já tenham sido geradas elas serão excluídas para que
    //sejam geradas novas parcelas
    $(".input_fields_parcelas").empty();

    //gera os campos de parcelas
    for (i=1; i<=parcelas; i++) {

        //calcula as datas das próximas parcelas
        var futureMonth = moment(currentDate).add(i, 'M');
        var futureMonthEnd = moment(futureMonth).endOf('month');

        if(currentDate.date() != futureMonth.date() && futureMonth.isSame(futureMonthEnd.format('YYYY-MM-DD')))
            futureMonth = futureMonth.add(i, 'd');

        $(".input_fields_parcelas").append('\
            <div class="form-group">\
                <div class="row">\
                    <div class="col-md-1">\
                        <label for="ParcRec">Parcela:</label><br>\
                        <input type="text" class="form-control" maxlength="6" readonly=""\
                               name="ParcRec'+i+'" value="'+i+'/'+parcelas+'">\
                    </div>\
                    <div class="col-md-2">\
                        <label for="ValorParcRec">Valor Parcela:</label><br>\
                        <div class="input-group" id="txtHint">\
                            <span class="input-group-addon" id="basic-addon1">R$</span>\
                            <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly=""\
                                   name="ValorParcRec'+i+'" value="'+parcorca+'">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <label for="DataVencRec">Data Venc. Parc.</label>\
                        <div class="input-group">\
                            <input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA" readonly=""\
                                   name="DataVencRec'+i+'" value="'+futureMonth.format('DD/MM/YYYY')+'">\
                            <span class="input-group-addon" disabled>\
                                <span class="glyphicon glyphicon-calendar"></span>\
                            </span>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <label for="ValorPagoRec">Valor Pago:</label><br>\
                        <div class="input-group" id="txtHint">\
                            <span class="input-group-addon" id="basic-addon1">R$</span>\
                            <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"\
                                   name="ValorPagoRec'+i+'" value="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <label for="DataPagoRec">Data Pag.</label>\
                        <div class="input-group DatePicker">\
                            <input type="text" class="form-control Date" id="DataPagoRec'+i+'" maxlength="10" placeholder="DD/MM/AAAA"\
                                   name="DataPagoRec'+i+'" value="">\
                            <span class="input-group-addon" disabled>\
                                <span class="glyphicon glyphicon-calendar"></span>\
                            </span>\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <label for="QuitRec">Quitado?</label><br>\
                        <div class="form-group">\
                            <div class="btn-group" data-toggle="buttons">\
                                <label class="btn btn-warning active" name="radio_idTab_TipoConcluido'+i+'" id="radio_idTab_TipoConcluido'+i+'N">\
                                <input type="radio" name="idTab_TipoConcluido'+i+'" id="radiogeraldinamico"\
                                    autocomplete="off" value="N" checked>Não\
                                </label>\
                                <label class="btn btn-default" name="radio_idTab_TipoConcluido'+i+'" id="radio_idTab_TipoConcluido'+i+'S">\
                                <input type="radio" name="idTab_TipoConcluido'+i+'" id="radiogeraldinamico"\
                                    autocomplete="off" value="S" checked>Sim\
                                </label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>'
        );

    }
    //habilita o botão de calendário após a geração dos campos dinâmicos
    $('.DatePicker').datetimepicker(dateTimePickerOptions);

    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");
        //$('#radiogeral'+ value).addClass("btn btn-warning active");

    });
}

/*
 * Função responsável por adicionar novos campos de serviço dinamicamente no
 * formulário de orçamento/tratametno
 */
function adicionaServico() {

    var ps = $("#SCount").val(); //initlal text box count

    //alert( $("#SCount").val() );
    ps++; //text box increment
    $("#SCount").val(ps);
    //console.log(ps);

    $(".input_fields_wrap").append('\
        <div class="form-group" id="1div'+ps+'">\
            <div class="row">\
                <div class="col-md-3">\
                    <label for="idTab_Servico">Serviços:</label><br>\
                    <select class="form-control" id="listadinamica'+ps+'" onchange="buscaValor(this.value,this.name,\'Servico\')" name="idTab_Servico'+ps+'">\
                        <option value="">-- Selecione uma opção --</option>\
                    </select>\
                </div>\
                <div class="col-md-2">\
                    <label for="ValorVendaServico">Valor do Serviço:</label><br>\
                    <div class="input-group" id="txtHint">\
                        <span class="input-group-addon" id="basic-addon1">R$</span>\
                        <input type="text" class="form-control Valor" id="idTab_Servico'+ps+'" maxlength="10" placeholder="0,00" \
                               name="ValorVendaServico'+ps+'" value="">\
                    </div>\
                </div>\
                <div class="col-md-3">\
                    <label for="ObsServico'+ps+'">Obs:</label><br>\
                    <input type="text" class="form-control" id="ObsServico'+ps+'" maxlength="250"\
                           name="ObsServico'+ps+'" value="">\
                </div>\
                <div class="col-md-2">\
                    <label for="ConcluidoServico">Concluído? </label><br>\
                    <div class="form-group">\
                        <div class="btn-group" data-toggle="buttons">\
                            <label class="btn btn-warning active" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'N">\
                            <input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
                                autocomplete="off" value="N" checked>Não\
                            </label>\
                            <label class="btn btn-default" name="radio_ConcluidoServico'+ps+'" id="radio_ConcluidoServico'+ps+'S">\
                            <input type="radio" name="ConcluidoServico'+ps+'" id="radiogeraldinamico"\
                                autocomplete="off" value="S">Sim\
                            </label>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-md-2">\
                    <label><br></label><br>\
                    <a href="#" id="'+ps+'" class="remove_field btn btn-danger">\
                        <span class="glyphicon glyphicon-trash"></span>\
                    </a>\
                </div>\
            </div>\
        </div>'
    ); //add input box

    //get a reference to the select element
    $select = $('#listadinamica'+ps);

    //request the JSON data and parse into the select element
    $.ajax({
        url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=1',
        dataType: 'JSON',
        type: "GET",
        success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            $select.append('<option value="">-- Selecione uma opção --</option>');
            $.each(data, function (key, val) {
                //alert(val.id);
                $select.append('<option value="' + val.id + '">' + val.name + '</option>');
            })
        },
        error: function () {
            //alert('erro listadinamicaA');
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">ERRO</option>');
        }

    });

    //permite o uso de radio buttons nesse bloco dinâmico
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

 /*
  * Função criada para funcionar junto com o recurso de hide/show do jquery nos
  * casos de radio button, que exigem um tratamento especial para funcionar
  * corretamente
  *
  * @param {string} campo
  * @param {string} hideshow
  */
 function radioButtonColorNS(campo, hideshow) {

     if (hideshow == 'show') {
        active = 'show';
        not = 'hide';
     } else {
        active = 'hide';
        not = 'show';
     }

     $('label[name="StatusOrca_' + not + '"]').removeClass();
     $('label[name="StatusOrca_' + not + '"]').addClass("btn btn-default");

     $('label[name="StatusOrca_' + active + '"]').removeClass();
     $('label[name="StatusOrca_' + active + '"]').addClass("btn btn-warning active");

 }

/*
 * Função responsável por capturar o serviço/produto selecionado e buscar seu valor
 * correspondente no arquivo Valor_json.php. Após obter o valor ele é
 * aplicado no campo de Valor correspondente.
 *
 * @param {int} id
 * @param {string} campo
 * @param {string} tabela
 * @returns {decimal}
 */
function buscaValor(id, campo, tabela) {

    $.ajax({
        // url para o arquivo json.php
        url: window.location.origin + "/" + app + "/Valor_json.php?tabela=" + tabela,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            // executo este laço para ecessar os itens do objeto javaScript
            for ($i = 0; $i < data.length; $i++) {

                if (data[$i].id == id) {

                    //carrega o valor no campo de acordo com a opção selecionada
                    $('#'+campo).val(data[$i].valor);

                    //para cada valor carregado o orçamento é calculado/atualizado
                    //através da chamada de sua função
                    calculaOrcamento();
                    calculaResta($("#ValorEntOrca").val())
                    break;
                }

            }//fim do laço

        }
    });//termina o ajax


}

/*
 * Função responsável por calcular o subtotal dos campos de produto
 *
 * @param {int} quant
 * @param {string} campo
 * @param {int} num
 * @returns {decimal}
 */
function calculaSubtotal(valor, campo, num, tipo) {

    if (tipo == 'VP') {
        //variável valor recebe o valor do produto selecionado
        var data = $("#Qtd"+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor.replace(".","").replace(",",".") * data);
        //alert('>>>'+valor+' :: '+campo+' :: '+num+' :: '+tipo+'<<<');
    } else {
        //variável valor recebe o valor do produto selecionado
        var data = $("#idTab_Produto"+num).val();

        //o subtotal é calculado como o produto da quantidade pelo seu valor
        var subtotal = (valor * data.replace(".","").replace(",","."));
    }

    subtotal = mascaraValorReal(subtotal);
    //o subtotal é escrito no seu campo no formulário
    $('#QuantidadeProduto'+num).val(subtotal);

    //para cada vez que o subtotal for calculado o orçamento e o total restante
    //também serão atualizados
    calculaOrcamento();
    calculaResta($("#ValorEntOrca").val())

}

/*
 * Função responsável por calcular o orçamento total
 *
 * @returns {int}
 */
function calculaOrcamento() {

    //captura o número incrementador do formulário, que controla quantos campos
    //foram acrescidos tanto para serviços quanto para produtos
    var sc = parseFloat($('#SCount').val().replace(".","").replace(",","."));
    var pc = parseFloat($('#PCount').val().replace(".","").replace(",","."));
    //define o subtotal inicial em 0.00
    var subtotal = 0.00;

    //variável incrementadora
    var i = 1;
    //percorre todos os campos de serviço, somando seus valores
    while (i <= sc) {

        //soma os valores apenas dos campos que existirem, o que forem apagados
        //ou removidos são ignorados
        if ($('#idTab_Servico'+i).val())
            subtotal += parseFloat($('#idTab_Servico'+i).val().replace(".","").replace(",","."));

        //incrementa a variável i
        i++;
    }

    //faz o mesmo que o laço anterior mas agora para produtos
    var i = 1;
    while (i <= pc) {

        if ($('#QuantidadeProduto'+i).val())
            subtotal += parseFloat($('#QuantidadeProduto'+i).val().replace(".","").replace(",","."));

        i++;
    }

    //calcula o subtotal, configurando para duas casas decimais e trocando o
    //ponto para o vírgula como separador de casas decimais
    subtotal = mascaraValorReal(subtotal);

    //escreve o subtotal no campo do formulário
    $('#ValorOrca').val(subtotal);
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

$(document).ready(function () {

    $(".Date").mask("99/99/9999");
    $(".Time").mask("99:99");
    $(".Cpf").mask("999.999.999-99");
    $(".Cep").mask("99999-999");
    $(".TituloEleitor").mask("9999.9999.9999");
    $(".Valor").mask("#.##0,00", {reverse: true});

    $(".Celular").mask("(99) 99999-9999");
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

    $('input:radio[id="radiogeral"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //alert(name + ' ' + value);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radiogeral'+ value).addClass("btn btn-warning active");

    });

    //permite o uso de radio buttons nesse bloco dinâmico
    $('input:radio[id="radiogeraldinamico"]').change(function() {

        var value = $(this).val();
        var name = $(this).attr("name");

        //alert(name + ' ' + value);

        $('label[name="radio_' + name + '"]').removeClass();
        $('label[name="radio_' + name + '"]').addClass("btn btn-default");
        $('#radio_' + name + value).addClass("btn btn-warning active");
        //$('#radiogeral'+ value).addClass("btn btn-warning active");

    });

    //adiciona campos dinamicamente
    var pc = 1; //initlal text box count
    $(".add_field_button2").click(function(e){ //on add input button click
        e.preventDefault();

        pc++; //text box increment
        $("#PCount").val(pc);

        $(".input_fields_wrap2").append('\
            <div class="form-group" id="2div'+pc+'">\
                <div class="row">\
                    <div class="col-md-4">\
                        <label for="idTab_Produto">Produto:</label><br>\
                        <select class="form-control" id="listadinamicab'+pc+'" onchange="buscaValor(this.value,this.name,\'Produto\')" name="idTab_Produto'+pc+'">\
                            <option value="">-- Selecione uma opção --</option>\
                        </select>\
                    </div>\
                    <div class="col-md-3">\
                        <label for="ValorProduto">Valor do Produto:</label><br>\
                        <div class="input-group id="txtHint">\
                            <span class="input-group-addon" id="basic-addon1">R$</span>\
                            <input type="text" class="form-control Valor" id="idTab_Produto'+pc+'" maxlength="10" placeholder="0,00" \
                                onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'VP\')"\
                                name="ValorProduto'+pc+'" value="">\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <label for="QuantidadeProduto">Qtd:</label><br>\
                        <div class="input-group">\
                            <input type="text" class="form-control" maxlength="3" id="Qtd'+pc+'" placeholder="0"\
                                onkeyup="calculaSubtotal(this.value,this.name,'+pc+',\'QTD\')"\
                                name="QuantidadeProduto'+pc+'" value="">\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <label for="Subtotal">Subtotal:</label><br>\
                        <div class="input-group id="txtHint">\
                            <span class="input-group-addon" id="basic-addon1">R$</span>\
                            <input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" readonly="" id="QuantidadeProduto'+pc+'"\
                                   name="Subtotal'+pc+'" value="">\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <label><br></label><br>\
                        <a href="#" id="'+pc+'" class="remove_field2 btn btn-danger">\
                            <span class="glyphicon glyphicon-trash"></span>\
                        </a>\
                    </div>\
                </div>\
            </div>'
        ); //add input box


        //get a reference to the select element
        $select = $('#listadinamicab'+pc);

        //request the JSON data and parse into the select element
        $.ajax({
            url: window.location.origin+ '/' + app + '/Getvalues_json.php?q=2',
            dataType: 'JSON',
            type: "GET",
            success: function (data) {
                //clear the current content of the select
                $select.html('');
                //iterate over the data and append a select option
                $select.append('<option value="">-- Selecione uma opção --</option>');
                $.each(data, function (key, val) {
                    //alert(val.id);
                    $select.append('<option value="' + val.id + '">' + val.name + '</option>');
                })
            },
            error: function () {
                //alert('erro listadinamicaB');
                //if there is an error append a 'none available' option
                $select.html('<option id="-1">ERRO</option>');
            }

        });

    });

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap").on("click",".remove_field", function(e){ //user click on remove text
        $("#1div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
        calculaResta($("#ValorEntOrca").val())
    })

    //Remove os campos adicionados dinamicamente
    $(".input_fields_wrap2").on("click",".remove_field2", function(e){ //user click on remove text
        $("#2div"+$(this).attr("id")).remove();
        //após remover o campo refaz o cálculo do orçamento e total restante
        calculaOrcamento();
        calculaResta($("#ValorEntOrca").val())
    })

    /*
     * Função para capturar o valor escolhido no campo select (Serviço e Produto, por exemplo)
     */
    $("#addValues").change(function () {
        //var n = $(this).attr("value");
        //var n = $("option:selected", this);

        alert (this.value);

        //alert('oi');
    });

    /*
     * As duas funções a seguir servem para exibir ou ocultar uma div em função
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
     * Mesma função que a de cima mas com uma modificação para funcionar nos
     * radios buttons
     */
     $("input[id$='hide']").change(function () {
         var n = $(this).attr("name");
         $("#" + n).hide();
         radioButtonColorNS(n, 'hide');
     });
     $("input[id$='show']").change(function () {
         var n = $(this).attr("name");
         $("#" + n).show();
         radioButtonColorNS(n, 'show');
     });

    /*
     * A função a seguir servem para exibir ou ocultar uma div em função do
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
        multiple_text: "Selecione uma ou mais opções",
        single_text: "Selecione uma opção",
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
            clear: 'Limpar seleção',
            close: 'Fechar este menu',
            selectMonth: 'Selecione um mês',
            prevMonth: 'Mês anterior',
            nextMonth: 'Próximo mês',
            selectYear: 'Selecione um ano',
            prevYear: 'Ano anterior',
            nextYear: 'Próximo ano',
            selectDecade: 'Selecione uma década',
            prevDecade: 'Década anterior',
            nextDecade: 'Próxima década',
            prevCentury: 'Centenário anterior',
            nextCentury: 'Próximo centenário',
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
        clear: 'Limpar seleção',
        close: 'Fechar este menu',
        selectMonth: 'Selecione um mês',
        prevMonth: 'Mês anterior',
        nextMonth: 'Próximo mês',
        selectYear: 'Selecione um ano',
        prevYear: 'Ano anterior',
        nextYear: 'Próximo ano',
        selectDecade: 'Selecione uma década',
        prevDecade: 'Década anterior',
        nextDecade: 'Próxima década',
        prevCentury: 'Centenário anterior',
        nextCentury: 'Próximo centenário',
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
 * veio junto com o último datetimepicker, não parei pra analisar sua relevância
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
        window.document.location = $(this).data("href");
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
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#id_Municipio').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Uf').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Municipio').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#EstadoCivil').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "70%"
});
$('#Especialidade').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Cid').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Prestador').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Cirurgia').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Status').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
    no_results_text: "Nenhum resultado para",
    width: "100%"
});
$('#Posicao').chosen({
    disable_search_threshold: 10,
    multiple_text: "Selecione uma ou mais opções",
    single_text: "Selecione uma opção",
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
    defaultView: 'agendaWeek',
    //contentHeight: 700,
    height: 'auto',
    //handleWindowResize: false,
    //aspectRatio: 2,

    minTime: '07:00',
    maxTime: '21:00',
    //minTime: '00:00',
    //maxTime: '24:00',
    nowIndicator: true,
    selectable: true,
    //selectHelper: true,
    editable: false,
    timezone: "local",
    lang: 'pt-br',
    eventAfterRender: function (event, element) {

        if (event.Evento == 1)
            var title = "<b>Evento Agendado</b><br><br><b>Obs:</b> " + event.Obs;
        else {

            if (event.Paciente == 'D')
                var title = "<b>" + event.title + "</b><br><b>Responsável:</b> " + event.subtitle + "<br>\n\<b>Tipo de Consulta:</b> " + event.TipoConsulta + "<br><b>Procedimento:</b> " + event.Procedimento + "<br><b>Profissional:</b> " + event.Profissional;
            else
                var title = "<b>" + event.title + "</b><br>\n\<b>Tipo de Consulta:</b> " + event.TipoConsulta + "<br><b>Procedimento:</b> " + event.Procedimento + "<br><b>Profissional:</b> " + event.Profissional;
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
 * Redireciona o usuário de acordo com a opção escolhida no modal da agenda,
 * que surge ao clicar em algum slot de tempo vazio.
 */
function redirecionar(x) {

    var re = new RegExp(/^.*\//);
    var start = moment($("#start").val());
    var end = moment($("#end").val());
    (x == 1) ? url = 'consulta/cadastrar_evento' : url = 'cliente/pesquisar';
    window.location = re.exec(window.location.href) + url + '?start=' + start + '&end=' + end
}

/*
 * Função para capturar a url com o objetivo de obter a data, após criar/alterar
 * uma consulta, e assim usar a função gotoDate do Fullcalendar para mostrar a
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
