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
    $("#lista").removeClass("menu").addClass("mobile"); 
    $("#menus").addClass("navmobile");
    $("#box").removeClass("container");
    $("#fechar").removeClass("esconder").addClass("exibir");
    $("section").addClass("blur");
    $("footer").addClass("blur");
    $("#acoes").removeClass("botoes").addClass("bmobile");
};

// Fechar menu para dispositivos móveis
function fecharMenuMobile() {
    $("#lista").removeClass("mobile").addClass("menu"); 
    $("#menus").removeClass("navmobile");
    $("#box").addClass("container");
    $("#fechar").removeClass("exibir").addClass("esconder");
    $("section").removeClass("blur");
    $("footer").removeClass("blur");
    $("#acoes").removeClass("bmobile").addClass("botoes");
};