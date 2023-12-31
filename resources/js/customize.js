import $, { isNumeric } from "jquery";

$(function () {

    var formAttributes = {
        santoId: null,
        santoNome: null,
        tipoPresente: null,
        valorDinheiro: null,
        tamanhoFralda: null,
        nomeConvidado: null,
        telefoneConvidado: null
    };

    var valorMinimoBilhete = 30;

    var iDsPassos = {
        1: "passo-1-bilhete-santos",
        2: "passo-2-bilhete-santos",
        3: "passo-3-bilhete-santos"
    };
    var quantidadePassos = Object.keys(iDsPassos).length;

    function validarPassos(passo) {
        switch (passo) {
            case 1:
                return validarPasso1();
            case 2:
                return validarPasso2();
        }
    }

    function validarPasso1() {
        if (!formAttributes.santoId) {
            alert('Erro:  Santo não foi escolhido');
            return false;
        }

        if (!formAttributes.santoNome) {
            alert('Erro: Santo não foi escolhido');
            return false;
        }

        return true;
    }

    function validarPasso2() {

        formAttributes.telefoneConvidado = formAttributes.telefoneConvidado.replace(/[^\d]+/g, '');

        if (!formAttributes.nomeConvidado) {
            alert('Erro: Informe seu nome');
            return false;
        }

        if (!formAttributes.telefoneConvidado) {
            alert('Erro: Informe seu telefone');
            return false;
        }

        if (!validatePhone(formAttributes.telefoneConvidado)) {
            alert('Erro: Telefone Inválido. Informe DDD+TELEFONE');
            return false;
        }

        return true;
    }

    function validatePhone(phone) {
        var regex = new RegExp('^((1[1-9])|([2-9][0-9]))((3[0-9]{3}-[0-9]{4})|(9[0-9]{3}[0-9]{5}))$');
        return regex.test(phone)
    }


    // PASSO 1
    hoverAndSelectElements('.box-santo.livre')

    $('.box-santo.livre').click(function () {
        formAttributes.santoId = $(this).data('santo-id');
        formAttributes.santoNome = $(this).data('santo-nome').replace('_', ' ');
    });


    // PASSO 2
    hoverAndSelectElements('.tipo-presente');
    hoverAndSelectElements('.tamanho-fralda');

    $('.tipo-presente').click(function () {
        formAttributes.tipoPresente = $(this).data('tipo-presente');
    });


    $('#tipo-presente-dinheiro').click(function () {
        hideElement('.tipo-presente-complemento');
        showBlockElement('#tipo-presente-dinheiro-complemento');
        $('#valor-presente-dinheiro').val('');
    });

    $('#valor-presente-dinheiro').keyup(function () {
        formAttributes.valorDinheiro = $(this).val();
        if (parseFloat($(this).val()) >= valorMinimoBilhete) {

        }
    });

    $('#tipo-presente-fraldas').click(function () {
        hideElement('.tipo-presente-complemento');
        showFlexElement('#tipo-presente-fraldas-complemento');
        removeAllSelectAndHover('.tamanho-fralda');
    });


    $('.tamanho-fralda').click(function () {
        formAttributes.tamanhoFralda = $(this).data('tamanho-fralda');
    });


    // ETAPA 3
    $('.dados-convidado').keyup(function () {
        var reqlength = $('.dados-convidado').length;

        var value = $('.dados-convidado').filter(function () {
            return $(this).val() != '';
        });

        if (value.length >= 0 && (value.length !== reqlength)) {

        } else {

        }
    });

    $('#nome-convidado').keyup(function () {
        formAttributes.nomeConvidado = $(this).val();
    });


    $('#telefone-convidado').keyup(function () {
        formAttributes.telefoneConvidado = $(this).val();
    });





    // BOTÕES RIFA
    var passoAtualId = 1;

    $('#botao-proximo-passo').click(function () {

        if (validarPassos(passoAtualId)) {

            $('html,body').animate({ scrollTop: $('#' + iDsPassos[passoAtualId]).offset().top - 300 }, 100);
            if (passoAtualId == 1) {
                showBlockElement('#botao-passo-anterior');
            }
            var proximoPasso = passoAtualId + 1;

            if (proximoPasso == quantidadePassos) { //é ultimo passo?
                fillInfoConfirmation(formAttributes);

                hideElement('#botao-proximo-passo');
                showBlockElement('#botao-enviar-informacoes');


                if (formAttributes.tipoPresente == "fraldas") {
                    showElement('#linha-tamanho-fralda');
                    hideElement('#linha-valor-dinheiro');
                    hideElement('#confirmacao-texto-dinheiro')
                } else if (formAttributes.tipoPresente == "dinheiro") {
                    showElement('#confirmacao-texto-dinheiro')
                    showElement('#linha-valor-dinheiro');
                    hideElement('#linha-tamanho-fralda');
                }
            }

            hideElement('.passo-bilhete-santos');
            showFlexElement('#' + iDsPassos[proximoPasso]);
            passoAtualId = proximoPasso;
        }
    });



    $('#botao-enviar-informacoes').click(function () {

        validarPasso1();
        validarPasso2();
        fillFormInputs(formAttributes);

        $("#formulario_bilhete").trigger('submit');
    });

    $('#botao-passo-anterior').click(function () {

        $('html,body').animate({ scrollTop: $('#' + iDsPassos[passoAtualId]).offset().top - 300 }, 100);
        passoAtualId -= 1;
        if (passoAtualId == 1) {
            hideElement('#botao-passo-anterior');
        }
        if (passoAtualId < quantidadePassos) {
            showBlockElement('#botao-proximo-passo');
            hideElement('#botao-enviar-informacoes');
        }
        hideElement('.passo-bilhete-santos');
        showFlexElement('#' + iDsPassos[passoAtualId]);
    });

    $('.telefone-mask').mask('(00) 00009-0000');


    $('#sorteador').on('submit',function(){
        var quantidadeNumerosEscolhida = $('#quantidade_numeros_sorteio').val();

        if(quantidadeNumerosEscolhida < 1){
            alert('Quantidade de números para sorteio inválida');
            return false;
        }

        return true;
    });

});


function fillInfoConfirmation(formAttributes) {
    $('#linha-santo .value').html("").append(formAttributes.santoNome);
    $('#linha-tipo-presente .value').html("").append(formAttributes.tipoPresente);
    $('#linha-valor-dinheiro .value').html("").append(formAttributes.valorDinheiro);
    $('#linha-tamanho-fralda .value').html("").append(formAttributes.tamanhoFralda);
    $('#linha-nome-convidado .value').html("").append(formAttributes.nomeConvidado);
    $('#linha-telefone-convidado .value').html("").append(formAttributes.telefoneConvidado).mask('(00) 00009-0000');
    $('#confirmacao-texto-dinheiro #valor-dinheiro').html("").append(formAttributes.valorDinheiro);


}

function fillFormInputs(formAttributes) {
    $("#santo_escolhido").val(formAttributes.santoId);
    $("#nome_convidado").val(formAttributes.nomeConvidado);
    $("#telefone_convidado").val(formAttributes.telefoneConvidado);
}

function showElement(element) {
    $(element).removeClass('d-none');
}

function showBlockElement(element) {
    $(element).addClass('d-block').removeClass('d-none');
}

function showFlexElement(element) {
    $(element).addClass('d-flex').removeClass('d-none');
}

function hideElement(element) {
    $(element).addClass('d-none').removeClass('d-block d-flex');
}

function removeAllSelectAndHover(element) {
    $(element).addClass().removeClass('selected hovered not_selected not_hovered');
}

function hoverAndSelectElements(element) {
    $(element).hover(function () {
        $(element).addClass('not_hovered');
        $(this).removeClass('not_hovered').addClass('hovered');
    }, function () {
        $(element).removeClass('not_hovered hovered');
    });

    $(element).click(function () {

        $(element).addClass('not_selected not_hovered').removeClass('selected hovered');
        $(this).removeClass('not_selected not_hovered').addClass('selected');
        $('html,body').animate({ scrollTop: $('#botoes-bilhete').offset().top - 200 }, 100);
    });

    $(element + ".selected").click(function () {
        $(".box-santo").removeClass('not_selected not_hovered hovered selected')
    });

}

