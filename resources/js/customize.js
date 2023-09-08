import $, { isNumeric } from "jquery";



$(function () {

    var formAttributes = {
        santoId: null,
        santoNome: null,
        tipoPresente: null,
        valorDinheiro: null,
        tamanhoFralda: null,
        nomeConvidado: null,
        emailConvidado: null,
        telefoneConvidado: null
    };

    var valorMinimoRifa = 10;

    var iDsPassos = {
        1: "passo-1-rifa-santos",
        2: "passo-2-rifa-santos",
        3: "passo-3-rifa-santos",
        4: "passo-4-rifa-santos",
    };
    var quantidadePassos = Object.keys(iDsPassos).length;

    function validarPassos(passo) {
        switch (passo) {
            case 1:
                return validarPasso1();
            case 2:
                return validarPasso2();
            case 3:
                return validarPasso3();
            case 4:
                return validarPasso4();
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
        if (!formAttributes.tipoPresente) {
            alert('Erro: Tipo de presente não foi escolhido');
            return false;
        }

        if (formAttributes.tipoPresente == "fraldas" && !formAttributes.tamanhoFralda) {
            alert('Erro: Tamanho de fraldas não foi escolhido');
            return false;
        }

        if (formAttributes.tipoPresente == "dinheiro") {
            if (!formAttributes.valorDinheiro) {
                alert('Erro: Valor em dinheiro não foi preenchido');
                return false;
            }

            var floatValue = parseFloat(formAttributes.valorDinheiro);


            if (!floatValue || floatValue < 10) {
                alert('Erro: Valor mínimo da rifa é R$ 10,00');
                return false;
            }
        }


        return true;
    }

    function validarPasso3() {
        if (!formAttributes.nomeConvidado) {
            alert('Erro: Informe seu nome');
            return false;
        }

        if (!formAttributes.emailConvidado) {
            alert('Erro: Informe seu email');
            return false;
        }

        if (!validateEmail(formAttributes.emailConvidado)) {
            alert('Erro: Email Inválido');
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


    function validateEmail(inputText) {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return inputText.match(mailformat);
    }

    function validarPasso4() {
        return true;
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
        if (parseFloat($(this).val()) >= valorMinimoRifa) {

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

    $('#email-convidado').keyup(function () {
        formAttributes.emailConvidado = $(this).val();
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

            hideElement('.passo-rifa-santos');
            showFlexElement('#' + iDsPassos[proximoPasso]);
            passoAtualId = proximoPasso;
        }
    });



    $('#botao-enviar-informacoes').click(function () {
        validarPasso1();
        validarPasso2();
        validarPasso3();
        validarPasso4();
        fillFormInputs(formAttributes);

        $("#formulario_rifa").trigger('submit');
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
        hideElement('.passo-rifa-santos');
        showFlexElement('#' + iDsPassos[passoAtualId]);
    });
});


function fillInfoConfirmation(formAttributes) {
    $('#linha-santo .value').html("").append(formAttributes.santoNome);
    $('#linha-tipo-presente .value').html("").append(formAttributes.tipoPresente);
    $('#linha-valor-dinheiro .value').html("").append(formAttributes.valorDinheiro);
    $('#linha-tamanho-fralda .value').html("").append(formAttributes.tamanhoFralda);
    $('#linha-nome-convidado .value').html("").append(formAttributes.nomeConvidado);
    $('#linha-email-convidado .value').html("").append(formAttributes.emailConvidado);
    $('#linha-telefone-convidado .value').html("").append(formAttributes.telefoneConvidado);
    $('#confirmacao-texto-dinheiro #valor-dinheiro').html("").append(formAttributes.valorDinheiro);


}

function fillFormInputs(formAttributes) {
    $("#santo_escolhido").val(formAttributes.santoId);
    $("#tipo_presente").val(formAttributes.tipoPresente);
    $("#valor_dinheiro").val(formAttributes.valorDinheiro);
    $("#tamanho_fralda").val(formAttributes.tamanhoFralda);
    $("#nome_convidado").val(formAttributes.nomeConvidado);
    $("#email_convidado").val(formAttributes.emailConvidado);
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
        $('html,body').animate({ scrollTop: $('#botoes-rifa').offset().top - 200 }, 100);
    });

    $(element + ".selected").click(function () {
        $(".box-santo").removeClass('not_selected not_hovered hovered selected')
    });

}