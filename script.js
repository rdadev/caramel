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
    $('.navmobile').css("animation", "deslizar 0.3s");
    $('.navmobile').css("left", "0");
    $("#lista").removeClass("menu").addClass("mobile"); 
    $("#fechar").removeClass("esconder").addClass("exibir");
    $("section").addClass("blur");
    $("footer").addClass("blur");
    $("#acoes").removeClass("botoes").addClass("bmobile");
};

// Fechar menu para dispositivos móveis
function fecharMenuMobile() {
    $('.navmobile').css("animation", "voltar 0.3s");
    $('.navmobile').css("left", "-100%");

    setTimeout(function(){
        $("#lista").removeClass("mobile").addClass("menu"); 
        $("#menus").removeClass("navmobile");
        $("#fechar").removeClass("exibir").addClass("esconder");
        $("section").removeClass("blur");
        $("footer").removeClass("blur");
        $("#acoes").removeClass("bmobile").addClass("botoes");
    }, 350);
};