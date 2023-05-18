// Sombra do cabeçalho ao rolar
$(document).on("scroll",function(){
    if($(document).scrollTop()>30){
        $("#cabecalho").removeClass("encaixado").addClass("sombreado"); 
    } else{
        $("#cabecalho").removeClass("sombreado").addClass("encaixado");
    }
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