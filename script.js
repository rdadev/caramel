// Sombra do cabeçalho ao rolar
$(document).on("scroll",function(){
    if($(document).scrollTop()>30){
        $("#cabecalho").removeClass("encaixado").addClass("sombreado"); 
    } else {
        $("#cabecalho").removeClass("sombreado").addClass("encaixado");
    };
});

// Navegação dos formulários de cadastro (troca de fieldset)
$(function() {
    var atual, anterior, proximo;

    $(".prox").click(function() {
        $(".carregamento").css("animation", "none");
        setTimeout(function() { 
            $(".carregamento").css("animation", "carregar 0.7s"); 
        }, 10);
        atual = $(this).parent();
        proximo = $(this).parent().next();
        atual.hide();
        proximo.show();
    });

    $(".prev").click(function() {
        $(".carregamento").css("animation", "none");
        setTimeout(function() { 
            $(".carregamento").css("animation", "carregar 0.7s"); 
        }, 10);
        atual = $(this).parent();
        anterior = $(this).parent().prev();
        atual.hide();
        anterior.show();
    });
});

// Abrir menu para dispositivos móveis
function abrirMenuMobile() {
    $("#menus").addClass("navmobile");
    $(".navmobile").css("animation", "deslizar 0.3s");
    $(".navmobile").css("left", "0");
    $("body").css("overflow", "hidden");
    $("#lista").removeClass("menu").addClass("mobile"); 
    $("#fechar").removeClass("esconder").addClass("exibir");
    $("section").addClass("blur");
    $("footer").addClass("blur");
    $("#blockpage").addClass("mostrar");
    $("#acoes").removeClass("botoes").addClass("bmobile");
};

// Fechar menu para dispositivos móveis
function fecharMenuMobile() {
    $(".navmobile").css("animation", "voltar 0.3s");
    $(".navmobile").css("left", "-100%");
    $("body").css("overflow", "auto");

    setTimeout(function(){
        $("#lista").removeClass("mobile").addClass("menu"); 
        $("#menus").removeClass("navmobile");
        $("#fechar").removeClass("exibir").addClass("esconder");
        $("section").removeClass("blur");
        $("footer").removeClass("blur");
        $("#blockpage").removeClass("mostrar");
        $("#acoes").removeClass("bmobile").addClass("botoes");
    }, 350);
};

// Abrir e fechar carrinho 
function abrirCarrinho() {
    $("#cart").toggleClass("poscarrinho");
    $("#total").toggleClass("postotal");
    $("#blockpage").toggleClass("mostrar");
};

const rdPix = document.querySelector("#pag1");

// Função do rádio logistica checkout
function logCheckout() {
    if ($("#log1").prop("checked")) {
        $("#lbd").addClass("fantasma");
        rdPix.checked = true;
        pagCheckout();
        $(".tipoent").removeClass("select");
        $("#boxlog1").addClass("select");
    } else if ($("#log2").prop("checked")) {
        $(".tipoent").removeClass("select");
        $("#lbd").removeClass("fantasma");
        $("#boxlog2").addClass("select");
    };
};

// Função do rádio pagamento checkout
function pagCheckout() {
    if ($("#pag1").prop("checked")) {
        $(".pagto").removeClass("select");
        $("#boxpag1").addClass("select");
    } else if ($("#pag2").prop("checked")) {
        $(".pagto").removeClass("select");
        $("#boxpag2").addClass("select");
    } else if ($("#pag3").prop("checked")) {
        $(".pagto").removeClass("select");
        $("#boxpag3").addClass("select");
    } else if ($("#pag4").prop("checked")) {
        $(".pagto").removeClass("select");
        $("#boxpag4").addClass("select");
    };
};

// Abre o modal
function abrirModal(elemento) {
    const modal = document.querySelector(elemento);
    $("header").addClass("blur");
    $("section").addClass("blur");
    $("footer").addClass("blur");
    modal.showModal();
};

// Fecha o modal
function fecharModal(elemento) {
    const modal = document.querySelector(elemento);
    $("header").removeClass("blur");
    $("section").removeClass("blur");
    $("footer").removeClass("blur");
    modal.close();
};

// Remover blur do fundo
function removeBlur() {
    document.onkeydown = function(e) {
        if(e.key === "Escape") {
            $("header").removeClass("blur");
            $("section").removeClass("blur");
            $("footer").removeClass("blur");
        };
    };
};

// Adicionar quantidade de produto no carrinho
function adQuantProduto(cod) {
    var atual = document.querySelector(cod).value;
    var soma = parseInt(atual) + 1;
    document.querySelector(cod).value = soma;
};

// Remove quantidade de produto no carrinho
function rmQuantProduto(cod) {
    var atual = document.querySelector(cod).value;
    if (atual == 1) {

    }
    else {
        var soma = parseInt(atual) - 1;
        document.querySelector(cod).value = soma;
    }
};

// Abre pesquisa no mobile
function abrirPesquisa() {
    var largura = window.innerWidth;
    if (largura < 1050) {
        $(".logotipo").toggleClass("fantasma");
        $(".buttons").toggleClass("fantasma");
        $(".buscar").toggleClass("buscamob");
        const inp = document.querySelector("#buscagem");
        inp.focus();
    };
};

// Exibir endereço alterado no checkout
function exibeEndereco() {
    const inpendereco = document.querySelector("#logradouro");
    const inpcomplemento = document.querySelector("#complemento");
    const inpcidade = document.querySelector("#cidade");
    const inpestado = document.querySelector("#estado");

    let endereco = inpendereco.value;
    let complemento = inpcomplemento.value;
    let cidade = inpcidade.value;
    let estado = inpestado.value;

    const titulo1 = document.querySelector("#place");
    const titulo2 = document.querySelector("#complement");
    titulo1.textContent = endereco;
    titulo2.textContent = complemento+" - "+cidade+"/"+estado;
};