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
    $(".carrinho").toggleClass("poscarrinho");
    $(".totais").toggleClass("postotal");
    $(".block").toggleClass("mostrar");
    $(".sobreloja").removeClass("posloja");
    $(".blockloja").removeClass("mostrar");
    $(".classificados").removeClass("posclassificacao");
    $(".blockclass").removeClass("mostrar");
};

// Abre a descrição da loja na página da loja
function abrirDetalhesLoja() {
    $(".sobreloja").toggleClass("posloja");
    $(".blockloja").toggleClass("mostrar");
    $(".carrinho").removeClass("poscarrinho");
    $(".totais").removeClass("postotal");
    $(".block").removeClass("mostrar");
    $(".classificados").removeClass("posclassificacao");
    $(".blockclass").removeClass("mostrar");
};

// Abrir comentários e classificação sobre a loja
function abrirClassificacao() {
    $(".classificados").toggleClass("posclassificacao");
    $(".blockclass").toggleClass("mostrar");
    $(".sobreloja").removeClass("posloja");
    $(".blockloja").removeClass("mostrar");
    $(".carrinho").removeClass("poscarrinho");
    $(".totais").removeClass("postotal");
    $(".block").removeClass("mostrar");
};

// Abertura do chat do pedido atual
function abrirChat() {
    $(".chat").toggleClass("poschat");
    $(".digitador").toggleClass("posdigitador");
    $(".blockchat").toggleClass("mostrar");
    $(".carrinho").removeClass("poscarrinho");
    $(".totais").removeClass("postotal");
    $(".block").removeClass("mostrar");
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

// Passar termo de pesquisa para a página de pesquisa
function passaPesquisa() {
    const busca = document.querySelector("#buscagem");
    sessionStorage.setItem('termoBusca', busca.value);
};

// Classificação da loja (jogo dos rádios)
function classificaLoja() {
    if ($("#class1").prop("checked")) {
        // Marca
        $("#star1").removeClass("fantasma");
        $("#sel1").addClass("fantasma");

        // Desmarca outros 
        $("#star2").addClass("fantasma");
        $("#sel2").removeClass("fantasma");
        $("#star3").addClass("fantasma");
        $("#sel3").removeClass("fantasma");
        $("#star4").addClass("fantasma");
        $("#sel4").removeClass("fantasma");
        $("#star5").addClass("fantasma");
        $("#sel5").removeClass("fantasma");

    } else if ($("#class2").prop("checked")) {
         // Marca
        $("#star1").removeClass("fantasma");
        $("#sel1").addClass("fantasma");
        $("#star2").removeClass("fantasma");
        $("#sel2").addClass("fantasma");

        // Desmarca outros 
        $("#star3").addClass("fantasma");
        $("#sel3").removeClass("fantasma");
        $("#star4").addClass("fantasma");
        $("#sel4").removeClass("fantasma");
        $("#star5").addClass("fantasma");
        $("#sel5").removeClass("fantasma");

    } else if ($("#class3").prop("checked")) {
         // Marca
        $("#star1").removeClass("fantasma");
        $("#sel1").addClass("fantasma");
        $("#star2").removeClass("fantasma");
        $("#sel2").addClass("fantasma");
        $("#star3").removeClass("fantasma");
        $("#sel3").addClass("fantasma");

        // Desmarca outros 
        $("#star4").addClass("fantasma");
        $("#sel4").removeClass("fantasma");
        $("#star5").addClass("fantasma");
        $("#sel5").removeClass("fantasma");

    } else if ($("#class4").prop("checked")) {
         // Marca
         $("#star1").removeClass("fantasma");
         $("#sel1").addClass("fantasma");
         $("#star2").removeClass("fantasma");
         $("#sel2").addClass("fantasma");
         $("#star3").removeClass("fantasma");
         $("#sel3").addClass("fantasma");
         $("#star4").removeClass("fantasma");
         $("#sel4").addClass("fantasma");
 
         // Desmarca outros 
         $("#star5").addClass("fantasma");
         $("#sel5").removeClass("fantasma");
 
    } else if ($("#class5").prop("checked")) {
         // Marca
         $("#star1").removeClass("fantasma");
         $("#sel1").addClass("fantasma");
         $("#star2").removeClass("fantasma");
         $("#sel2").addClass("fantasma");
         $("#star3").removeClass("fantasma");
         $("#sel3").addClass("fantasma");
         $("#star4").removeClass("fantasma");
         $("#sel4").addClass("fantasma");
         $("#star5").removeClass("fantasma");
         $("#sel5").addClass("fantasma");
    };
};

// Passar status do pedido para a página de cupom
function passaStatus(status) {
    sessionStorage.setItem('statusPedido', status);
};

// Abertura de acordeon 
var acc = document.getElementsByClassName("acordeon");
var i;

for (i = 0; i < acc.length; i++) {
    var acc = document.getElementsByClassName("acordeon");
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].onclick = function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        var acord = this;
        if (panel.style.maxHeight){
          panel.style.maxHeight = null;
          panel.style.padding = "0px 20px";
          panel.style.borderBottom = "none";
          acord.style.borderRadius = "8px";
        } else {
          acord.style.borderRadius = "8px 8px 0 0";
          panel.style.padding = "20px";
          panel.style.maxHeight = panel.scrollHeight + "px";
          panel.style.borderBottom = "1px solid var(--bordas)";
        } 
      }
    }
};