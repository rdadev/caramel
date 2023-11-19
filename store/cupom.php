<?php
    session_start();
    if(!isset($_SESSION["SSO_USUARIO_CARAMEL"])){
        header("location: ../usuario/login.php");
    };
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/icon" href="../images/icon.ico"/>
    <link rel="stylesheet" type="text/css" href="../sources/global.css"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../sources/script.js"></script>
    <title>Caramel</title>
</head>
<body>
    <?php
    include("../sources/config.php");

        if(isset($_GET["pedido"])){ 
            $pedido = $_GET["pedido"];
            $consulta = $conn -> prepare("SELECT tbl_pedidos.ID_PEDIDO, tbl_pedidos.ID_LOJA, tbl_pedidos.ST_AVALIACAO_PEDIDO, tbl_lojas.NM_LOJA, tbl_lojas.HR_TEMPO_ENTREGA_LOJA, tbl_pedidos.VL_TOTAL_PEDIDO, tbl_lojas.VL_TAXA_ENTREGA_LOJA, tbl_pedidos.NR_CEP_PEDIDO, tbl_pedidos.NM_CIDADE_PEDIDO, tbl_pedidos.SG_UF_PEDIDO, tbl_pedidos.NM_BAIRRO_PEDIDO, tbl_pedidos.DS_LOGRADOURO_PEDIDO, tbl_pedidos.DS_COMPLEMENTO_PEDIDO, tbl_pedidos.DT_TRANSACAO_PEDIDO, tbl_tipo_pagamentos.NM_PAGAMENTO, tbl_pedidos.ST_PEDIDO FROM tbl_pedidos, tbl_tipo_pagamentos, tbl_lojas WHERE tbl_pedidos.ID_USUARIO = :usuario AND tbl_pedidos.ID_PEDIDO = :pedido AND tbl_pedidos.ID_PAGAMENTO = tbl_tipo_pagamentos.ID_PAGAMENTO AND tbl_lojas.ID_LOJA = tbl_pedidos.ID_LOJA");
            $consulta -> bindValue(":usuario", $_SESSION["SSO_USUARIO_CARAMEL"]);
            $consulta -> bindValue(":pedido", $pedido);
            $consulta -> execute();
            $dados = $consulta -> fetch();

            if ($consulta -> rowCount() > 0){

            } else {
                echo("<script>window.location.replace('pedidos.php');</script>");
            };

        } else if (isset($_POST["avaliacao"])) {
            $id = $_POST["id_pedido"];
            $loja = $_POST["id_loja"];
            $comentario = $_POST["comentario"];
            $classificacao = $_POST["classificacao"];

            if ($comentario == "") {
                $comentario = "Nenhum comentário.";
            };

            $avaliar = $conn -> prepare("INSERT INTO tbl_avaliacoes (ID_USUARIO, ID_PEDIDO, TX_AVALIACAO, DT_POSTAGEM_AVALIACAO, DS_COMENTARIO_AVALIACAO, ID_LOJA) VALUES (:usuario, :pedido, :classificacao, NOW(), :comentario, :loja)");
            $avaliar -> bindValue(":usuario", $_SESSION["SSO_USUARIO_CARAMEL"]);
            $avaliar -> bindValue(":pedido", $id);
            $avaliar -> bindValue(":classificacao", $classificacao);
            $avaliar -> bindValue(":comentario", $comentario);
            $avaliar -> bindValue(":loja", $loja);
            $avaliar -> execute();

            $trava = $conn -> prepare("UPDATE tbl_pedidos SET ST_AVALIACAO_PEDIDO = 1 WHERE ID_PEDIDO = :id");
            $trava -> bindValue(":id", $id);
            $trava -> execute();

            echo("<script>window.location.replace('cupom.php?pedido=".$id."');</script>");

        } else {
            echo("<script>window.location.replace('pedidos.php');</script>");
        };

        $produtos = $conn -> prepare("SELECT tbl_produtos_pedidos.QT_PRODUTO_PEDIDO, tbl_produtos.NM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO FROM tbl_produtos_pedidos, tbl_produtos WHERE tbl_produtos_pedidos.ID_PEDIDO = :id AND tbl_produtos_pedidos.ID_PRODUTO = tbl_produtos.ID_PRODUTO");
        $produtos -> bindValue(":id", $pedido);
        $produtos -> execute();
    ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div class="block" onclick="fecharLateral()"></div>
    <?php include("../usuario/header.php"); ?>

    <main>
        <section>
            <div class="container">
                <div class="cupom">
                    <a href="pedidos.php" class="btvoltar"><svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M359-242 120-481l239-239 43 43-166 166h604v60H236l166 166-43 43Z"/></svg> Voltar</a>
                    <h1><?php echo($dados["NM_LOJA"]) ?></h1>
                    <h3>Previsão de entrega</h3>
                    <p class="pentegra"><?php echo($dados["HR_TEMPO_ENTREGA_LOJA"]) ?> min</p>
                    <ul class="prds">
                        <?php
                            if ($produtos -> rowCount() > 0) {
                                while($produto = $produtos -> fetch()){ 
                                    echo("
                                    <li class='cupomproduto'>
                                        <p>".$produto["QT_PRODUTO_PEDIDO"]."x ".$produto["NM_PRODUTO"]."</p>
                                        <h3>R$ ".$produto["QT_PRODUTO_PEDIDO"] * $produto["VL_VENDA_PRODUTO"]."</h3>
                                    </li>
                                    ");
                                };
                            };
                        ?>
                    </ul>
                    <h3>Subtotal</h3>
                    <div class="subtotais">
                        <span><p style="float: left">Produtos</p><p style="float: right">R$ <?php echo($dados["VL_TOTAL_PEDIDO"]) ?></p></span>
                        <span><p style="float: left">Taxa de entrega</p><p style="float: right">R$ <?php echo($dados["VL_TAXA_ENTREGA_LOJA"]) ?></p></span>
                    </div>
                    <div class="scmiscelanea">
                        <h3>Entrega em</h3>
                        <p class="miscelanea"><?php echo($dados["DS_LOGRADOURO_PEDIDO"]) ?>, <?php echo($dados["DS_COMPLEMENTO_PEDIDO"]) ?>, <?php echo($dados["NM_CIDADE_PEDIDO"]) ?> - <?php echo($dados["SG_UF_PEDIDO"]) ?></p>
                    </div>
                    <div class="scmiscelanea">
                        <h3>Pedido</h3>
                        <p class="miscelanea">#<?php echo($dados["ID_PEDIDO"]) ?></p>
                    </div>
                    <div class="scmiscelanea">
                        <h3>Data do pedido</h3>
                        <p class="miscelanea"><?php echo(date('d/m/Y H:i', strtotime($dados["DT_TRANSACAO_PEDIDO"]))); ?></p>
                    </div>
                    <div class="scmiscelanea">
                        <h3>Pagamento</h3>
                        <p class="miscelanea"><?php echo($dados["NM_PAGAMENTO"]) ?></p>
                    </div>
                    <div class="scmiscelanea" style="border-bottom: none">
                        <h3>Status do pedido</h3>
                        <p id="pstatus" class="miscelanea">
                            <?php 
                                if ($dados["ST_PEDIDO"] == 1) {
                                    echo("Aguardando confirmação");
                                } else if ($dados["ST_PEDIDO"] == 2) {
                                    echo("Preparando");
                                } else if ($dados["ST_PEDIDO"] == 3) {
                                    echo("Em rota de entrega");
                                } else {
                                    echo("Concluído");
                                };
                            ?>    
                        </p>
                    </div>
                    <button type="button" class="bta print" onclick="window.print()">Imprimir</button>
                    
                    <?php
                        if($dados["ST_PEDIDO"] == 4 AND $dados["ST_AVALIACAO_PEDIDO"] == 0) {
                            echo("<button id='btaval' type='button' class='btb print' onclick='abrirModal(\"#avaliacao\")'>Avaliar loja</button>");
                        };
                    ?>
                </div>
            </div>
        </section>

        <dialog id="avaliacao" class="avaliar" onkeydown="removeBlur()">
            <div class="cabeca">
                <h1>Avaliação da loja</h1>
                <button class="mdfechar" type="button" onclick="fecharModal('#avaliacao')"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button>
            </div>
            <div class="conteudo">
                <form class="faval" method="POST" action="cupom.php" autocomplete="off">
                    <h4 class="lbs">Experiência</h4>
                    <input type="text" name="id_pedido" class="hidden" value="<?php echo($dados["ID_PEDIDO"]) ?>"/>
                    <input type="text" name="id_loja" class="hidden" value="<?php echo($dados["ID_LOJA"]) ?>"/>
                    <div class="estrelinhas">
                        <label for="class1"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 -960 960 960" width="28" id="sel1"><path d="m323-205 157-94 157 95-42-178 138-120-182-16-71-168-71 167-182 16 138 120-42 178Zm157-24L294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Zm0-206Z"/></svg><svg xmlns="http://www.w3.org/2000/svg" id="star1" class="fantasma" viewBox="0 -960 960 960" width="28" height="28"><path d="M480-229 294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Z"/></svg></label>
                        <input type="radio" class="fantasma" id="class1" name="classificacao" value="1" onchange="classificaLoja()">
                        <label for="class2"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 -960 960 960" width="28" id="sel2"><path d="m323-205 157-94 157 95-42-178 138-120-182-16-71-168-71 167-182 16 138 120-42 178Zm157-24L294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Zm0-206Z"/></svg><svg xmlns="http://www.w3.org/2000/svg" id="star2" class="fantasma" viewBox="0 -960 960 960" width="28" height="28"><path d="M480-229 294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Z"/></svg></label>
                        <input type="radio" class="fantasma" id="class2" name="classificacao" value="2" onchange="classificaLoja()">
                        <label for="class3"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 -960 960 960" width="28" id="sel3"><path d="m323-205 157-94 157 95-42-178 138-120-182-16-71-168-71 167-182 16 138 120-42 178Zm157-24L294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Zm0-206Z"/></svg><svg xmlns="http://www.w3.org/2000/svg" id="star3" class="fantasma" viewBox="0 -960 960 960" width="28" height="28"><path d="M480-229 294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Z"/></svg></label>
                        <input type="radio" class="fantasma" id="class3" name="classificacao" value="3" onchange="classificaLoja()">
                        <label for="class4"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 -960 960 960" width="28" id="sel4"><path d="m323-205 157-94 157 95-42-178 138-120-182-16-71-168-71 167-182 16 138 120-42 178Zm157-24L294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Zm0-206Z"/></svg><svg xmlns="http://www.w3.org/2000/svg" id="star4" class="fantasma" viewBox="0 -960 960 960" width="28" height="28"><path d="M480-229 294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Z"/></svg></label>
                        <input type="radio" class="fantasma" id="class4" name="classificacao" value="4" onchange="classificaLoja()">
                        <label for="class5"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 -960 960 960" width="28" id="sel5"><path d="m323-205 157-94 157 95-42-178 138-120-182-16-71-168-71 167-182 16 138 120-42 178Zm157-24L294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Zm0-206Z"/></svg><svg xmlns="http://www.w3.org/2000/svg" id="star5" class="fantasma" viewBox="0 -960 960 960" width="28" height="28"><path d="M480-229 294-117q-8 5-17 4.5t-16-5.5q-7-5-10.5-13t-1.5-18l49-212-164-143q-8-7-9.5-15.5t.5-16.5q2-8 9-13.5t17-6.5l217-19 84-200q4-9 12-13.5t16-4.5q8 0 16 4.5t12 13.5l84 200 217 19q10 1 17 6.5t9 13.5q2 8 .5 16.5T826-504L662-361l49 212q2 10-1.5 18T699-118q-7 5-16 5.5t-17-4.5L480-229Z"/></svg></label>
                        <input type="radio" class="fantasma" id="class5" name="classificacao" value="5" onchange="classificaLoja()">
                    </div>
                    <h4 class="place2 lbs">Comentário</h4>
                    <input type="text" name="comentario" class="txti" placeholder="Conte sua experiência (opcional)"/>
                    <p class="obs">Obs.: Sua avaliação será postada publicamente na página da loja e irá exibir seu primeiro nome como título</p>
                    <input type="submit" class="bta" name="avaliacao" value="Enviar"/>
                </form>
            </div>
        </dialog>

        <section class="mobnavs">
            <a href="index.php"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.152 873.848h143.783V621.935h228.13v251.913h143.783V486.957L480 293.63 222.152 487.036v386.812Zm-68.13 68.13V452.891L480 208.348l326.218 244.543v489.087H528.565V687.435h-97.13v254.543H154.022ZM480 583.239Z"/></svg>
                <p>Home</p>
            </div></a>
            <button class="bt" type="button" onclick="abrirPesquisa()"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M795.761 941.696 531.326 677.5q-29.761 25.264-69.6 39.415-39.84 14.15-85.161 14.15-109.835 0-185.95-76.195Q114.5 578.674 114.5 471t76.196-183.87q76.195-76.195 184.369-76.195t183.87 76.195q75.695 76.196 75.695 184.02 0 43.328-13.641 82.97-13.641 39.641-40.924 74.402L845.5 891.957l-49.739 49.739ZM375.65 662.935q79.73 0 135.29-56.245Q566.5 550.446 566.5 471t-55.595-135.69q-55.595-56.245-135.255-56.245-80.494 0-136.757 56.245Q182.63 391.554 182.63 471t56.228 135.69q56.227 56.245 136.792 56.245Z"/></svg>
                <p>Pesquisa</p>
            </div></button>
            <a href="pedidos.php"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.957 987q-47.377 0-80.374-32.996-32.996-32.997-32.996-80.486V742.652h129.869V171.935l61.235 60.956 60.996-60.956 60.756 60.956 61.235-60.956 60.757 60.956 61.195-60.956 60.957 60.956 61.196-60.956 60.956 60.956 61.674-60.956V873.63q0 47.377-33.066 80.374Q784.281 987 737.043 987H222.957Zm514.206-68.37q19.88 0 32.38-12.513 12.5-12.514 12.5-32.534V281.022H307.587v461.63h384.456V873.63q0 20 12.62 32.5t32.5 12.5ZM360.587 440.457v-60h235.456v60H360.587Zm0 134v-60h235.456v60H360.587Zm328.456-134q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9Zm0 129q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9ZM221.957 918.63h401.956V811.022H177.957v62.608q0 20 12.65 32.5t31.35 12.5Zm-44 0V811.022 918.63Z"/></svg>
                <p>Pedidos</p>
            </div></a>
            <a href="../usuario/conta.php"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg"viewBox="0 96 960 960"><path d="M222.957 798.37q62.76-43.522 124.521-66.783 61.761-23.261 132.626-23.261 70.865 0 133.242 23.445 62.376 23.444 124.697 66.599 43.522-54.24 61.663-108.153Q817.848 636.303 817.848 576q0-143.863-96.98-240.856-96.98-96.992-240.826-96.992t-240.868 96.992Q142.152 432.137 142.152 576q0 60.283 18.528 114.139 18.529 53.856 62.277 108.231Zm256.857-190.696q-58.569 0-98.409-40.045-39.84-40.044-39.84-98.456 0-58.412 40.026-98.39 40.026-39.979 98.595-39.979 58.569 0 98.409 40.165 39.84 40.164 39.84 98.576 0 58.412-40.026 98.27-40.026 39.859-98.595 39.859Zm.514 374.304q-83.524 0-157.573-31.928t-129.46-87.333q-55.41-55.406-87.342-129.234-31.931-73.828-31.931-157.769 0-83.671 31.978-157.366 31.978-73.696 87.315-129.033 55.337-55.337 129.177-87.435 73.839-32.098 157.794-32.098 83.671 0 157.366 32.098 73.696 32.098 129.033 87.435 55.337 55.337 87.435 129.085 32.098 73.747 32.098 157.272 0 83.524-32.098 157.6t-87.435 129.413Q711.348 918.022 637.6 950q-73.747 31.978-157.272 31.978Zm-.328-68.13q54.283 0 105.587-15.522t102.304-54.804q-51.239-35.761-102.804-54.163Q533.522 770.957 480 770.957q-53.522 0-104.967 18.402-51.446 18.402-102.685 54.163 51 39.282 102.185 54.804Q425.717 913.848 480 913.848Zm0-369.044q33.251 0 54.408-21.021 21.157-21.022 21.157-54.424t-21.157-54.544Q513.251 393.674 480 393.674q-33.251 0-54.408 21.141-21.157 21.142-21.157 54.544t21.157 54.424q21.157 21.021 54.408 21.021Zm0-75.565Zm.239 373.283Z"/></svg>
                <p>Conta</p>
            </div></a>
        </section>
    
        <?php include ("carrinho.php"); ?>
    </main>
 
    <footer>
        <div class="container">
            <div class="copyright"><p>Copyright © 2023 Caramel</p></div>
            <div class="links">
                <ul>
                    <li><a href="../sobre/index.php">Sobre</a></li>
                    <li><a href="../privacidade/index.php">Privacidade</a></li>
                    <li><a href="../termos/index.php">Termos</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>