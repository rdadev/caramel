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

// Função do rádio logistica checkout
function logCheckout() {
    const pix = document.querySelector("#pag1");
    if ($("#log1").prop("checked")) {
        $("#lbd").addClass("fantasma");
        pix.checked = true;
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
    $("aside").addClass("blur");
    modal.showModal();
};

// Fecha o modal
function fecharModal(elemento) {
    const modal = document.querySelector(elemento);
    $("header").removeClass("blur");
    $("section").removeClass("blur");
    $("footer").removeClass("blur");
    $("aside").removeClass("blur");
    modal.close();
};

// Remover blur do fundo
function removeBlur() {
    document.onkeydown = function(e) {
        if(e.key == "Escape") {
            $("header").removeClass("blur");
            $("section").removeClass("blur");
            $("footer").removeClass("blur");
            $("aside").removeClass("blur");
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
      };
   };
};

// Abertura e fechamento da loja 
function abrirLoja() {
    const status = document.querySelector("#funcionamento");
    const titulo = document.querySelector("#mljtit");
    const descricao = document.querySelector("#mljdesc");

    if (status.value == "aberta") {
        abrirModal('#mdloja');
        titulo.textContent = "Abertura de turno";
        descricao.textContent = "Deseja realizar a abertura de turno da loja? A loja ficará visível na busca da plataforma e clientes poderão comprar e visitar sua página";

    } else if (status.value == "fechada") {
        abrirModal('#mdloja');
        titulo.textContent = "Fechamento de turno";
        descricao.textContent = "Deseja realizar o fechamento de turno da loja? A loja ficará invisível na busca da plataforma e clientes não poderão comprar na sua loja";
    };
};

// Cancelamento de abertura ou fechamento da loja
function cancelarTurno() {
    const status = document.querySelector("#funcionamento");
    const statusmob = document.querySelector("#funcionamobile");
    if (status.value == "aberta") {
        status.value = "fechada";
        statusmob.value = "Loja fechada";
    } else if (status.value == "fechada") {
        status.value = "aberta";
        statusmob.value = "Loja aberta";
    };
};

// Tabelas 
function tabelasData(nome) {
    $(nome).DataTable({
        paging: true,
        searching: false,
        ordering: false,
        info: true,
        processing: false,
        "language": {
            "decimal":        "",
            "emptyTable":     "Nenhum registro encontrado",
            "info":           "_TOTAL_ registro(s) listado(s)",
            "infoEmpty":      "Nenhum registro encontrado",
            "infoFiltered":   "(Filtrando em _MAX_ registros)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Exibindo _MENU_ registros",
            "loadingRecords": "Aguarde, carregando",
            "processing":     "",
            "search":         "Pesquisa:",
            "zeroRecords":    "Nenhum registro encontrado",
                "paginate": {
                    "first":      "<<",
                    "last":       ">>",
                    "next":       ">",
                    "previous":   "<"
            },
        "aria": {
            "sortAscending":  ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
            }
        }
    });
};

// Abertura da navegação do dashboard do lojista
function abrirSidebar() {
    $("aside").toggleClass("asidepos");
    $(".blocksidebar").toggleClass("mostrar");
};

// Abertura da exibição lateral do dashboard
function abrirLateral(id) {
    fecharLateral();
    $(".block").addClass("mostrar");
    $(id).addClass("poslateral");
}

// Abre o fundo para os deslizes laterais que tenham
function abrirFundo(id) {
    $(id).addClass("poslateral");
};

// Fechamento da exibição lateral do dashboard
function fecharLateral() {
    $(".block").removeClass("mostrar");
    $(".lateral").removeClass("poslateral");
    $(".fundo").removeClass("poslateral");
};

function passaAndamento(status) {
    sessionStorage.setItem('andamentoPedido', status);
};

// Loading no botão de pedidos ao clicar
function executarPedido(bt, parametro) {
    const botao = document.querySelector(bt);
    botao.textContent = "Aguarde ...";
    $(bt).addClass("btcarregando");

    setTimeout(function() { 
        detalharPedido(parametro);
        window.scrollTo(0, 0);
    }, 500);

};

// Status do pedido na tela de confirmação do pedido
function detalharPedido(status) {
    if (status == "concluido") {
        $(".status").css("display", "none");
        $(".btcontato").css("display", "inline");
        const info = document.querySelector("#infocliente");
        const stat = document.querySelector("#andamento");
        const local = document.querySelector("#endereco");
        const prev = document.querySelector("#previsao");
        info.textContent = "Ana Castro • Pedido #827649";
        stat.textContent = "Concluído";
        local.textContent = "Avenida Opet, 99 • Rebouças • Curitiba/PR • 2,5km • CEP 80230-030";
        prev.innerHTML = "Entregue às <b>16:15<b/>";
        $("#andamento").addClass("statpos");
        $(".btimpressao").css("display", "inline");
        $(".btentrega").css("display", "none");
        $(".btconfirmar").css("display", "none");
        $(".cobranca").css("display", "block");
    }

    else if (status == "preparando") {
        $(".status").css("display", "none");
        $(".btcontato").css("display", "inline");
        const info = document.querySelector("#infocliente");
        const stat = document.querySelector("#andamento");
        const local = document.querySelector("#endereco");
        const prev = document.querySelector("#previsao");
        info.textContent = "Ana Castro • Pedido #827649";
        stat.textContent = "Preparando pedido";
        local.textContent = "Avenida Opet, 99 • Rebouças • Curitiba/PR • 2,5km • CEP 80230-030";
        prev.innerHTML = "Entrega prevista <b>16:20<b/>";
        $("#andamento").addClass("statpos");
        $(".btimpressao").css("display", "inline");
        $(".btentrega").css("display", "inline");
        $(".btconfirmar").css("display", "none");
        $(".cobranca").css("display", "block");
    }

    else if (status == "entregando") {
        $(".status").css("display", "none");
        $(".btcontato").css("display", "inline");
        const info = document.querySelector("#infocliente");
        const stat = document.querySelector("#andamento");
        const local = document.querySelector("#endereco");
        const prev = document.querySelector("#previsao");
        info.textContent = "Ana Castro • Pedido #827649";
        stat.textContent = "Rota de entrega";
        local.textContent = "Avenida Opet, 99 • Rebouças • Curitiba/PR • 2,5km • CEP 80230-030";
        prev.innerHTML = "Entrega prevista <b>16:20<b/>";
        $("#andamento").addClass("statpos");
        $(".btimpressao").css("display", "inline");
        $(".btentrega").css("display", "none");
        $(".btconfirmar").css("display", "none");
        $(".cobranca").css("display", "block");
    };
};

function abreDropDown(id) {
    $(id).toggleClass('dpexibir');
};

// Seleciona o arquivo ao clicar
function selecionaArquivo(id) {
    input = document.getElementById(id);
    input.click();
};

// Visualizar arquivo ao colocar
function mostraImagem(id, input) {
    let reader = new FileReader();
    imagem = document.getElementById(id);
    arquivo = document.getElementById(input);

    reader.onload = () => {
        imagem.src = reader.result;
        $(imagem).css("object-fit", "contain");
    }

    reader.readAsDataURL(arquivo.files[0]);
};

// Preencher informações do produto
function alterarProduto() {
    abrirLateral('#manproduto');
    abrirFundo('#fdproduto');

    const nome = document.getElementById("nome");
    const descricao = document.getElementById("descricao");
    const codigo = document.getElementById("codigo");
    const medida = document.getElementById("medida");
    const preco = document.getElementById("preco");
    imagem = document.getElementById("imgresult");
    nome.value = "Ração Golden Special Adultos Sabor Frango Pacote 15Kg";
    descricao.textContent = "Golden Formula Adultos Frango e Carne utiliza proteína de carne bovina e não sabores artificiais e contém o nível ideal de todos os nutrientes.";
    codigo.value = "11503";
    medida.value = "PC - Pacote";
    preco.value = "R$ 59,90";
    imagem.src = "../images/produtos/produto1.jpg";
    $(imagem).css("object-fit", "contain");
};

// Limpa campos do cadastro
function zerarCadastro() {
    const nome = document.getElementById("nome");
    const descricao = document.getElementById("descricao");
    const codigo = document.getElementById("codigo");
    const medida = document.getElementById("medida");
    const preco = document.getElementById("preco");
    imagem = document.getElementById("imgresult");
    nome.value = "";
    descricao.textContent = "";
    codigo.value = "";
    medida.value = "UN - Unidade";
    preco.value = "";
    imagem.src = "../images/blank.svg";
    $(imagem).css("object-fit", "cover");
};