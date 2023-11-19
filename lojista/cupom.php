<?php
    session_start();
    if(!isset($_SESSION["SSO_LOJISTA_CARAMEL"])){
        header("location: login.php");
    } else {
        include("../sources/config.php");
        $usuario = $_SESSION["SSO_LOJISTA_CARAMEL"];
        $consultar = $conn -> prepare("SELECT ID_PERMISSAO_LOJISTA, ID_LOJA, ST_ATIVIDADE_LOJISTA, ID_LOJISTA FROM tbl_lojistas WHERE ID_LOJISTA = :id");
        $consultar -> bindValue(":id", $usuario);
        $consultar -> execute();
        $iniget = $consultar -> fetch();
        
        if($iniget["ST_ATIVIDADE_LOJISTA"] == 0) { header("location: negado.php"); } // NEGA QUANDO DESATIVADO
    }
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../sources/script.js"></script>
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body class="portal">
    <?php
        if(isset($_POST["detalhar"])) {
            $id = $_POST["id"];
            $pedido = $conn -> prepare("SELECT * FROM tbl_pedidos WHERE ID_PEDIDO  = :id AND ID_LOJA = :loja");
            $pedido -> bindValue(":id", $id);
            $pedido -> bindValue(":loja", $iniget["ID_LOJA"]);
            $pedido -> execute();
            $dados = $pedido -> fetch();

            $detalhes = $conn -> prepare("SELECT tbl_tipo_pagamentos.NM_PAGAMENTO, tbl_lojistas.NM_LOJISTA FROM tbl_tipo_pagamentos, tbl_pedidos, tbl_lojistas WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_tipo_pagamentos.ID_PAGAMENTO = tbl_pedidos.ID_PAGAMENTO AND tbl_lojistas.ID_LOJISTA = tbl_pedidos.ID_LOJISTA");
            $detalhes -> bindValue(":id", $id);
            $detalhes -> execute();
            $detalhe = $detalhes -> fetch();

            $usuario = $conn -> prepare("SELECT tbl_usuarios.NR_TELEFONE_USUARIO, tbl_usuarios.NM_USUARIO FROM tbl_usuarios, tbl_pedidos WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_usuarios.ID_USUARIO = tbl_pedidos.ID_USUARIO");
            $usuario -> bindValue(":id", $id);
            $usuario -> execute();
            $user = $usuario -> fetch();

            $produtos = $conn -> prepare("SELECT tbl_produtos_pedidos.ID_PRODUTO, tbl_produtos_pedidos.QT_PRODUTO_PEDIDO, tbl_produtos.ID_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.NM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO FROM tbl_produtos_pedidos, tbl_produtos, tbl_medidas WHERE tbl_produtos_pedidos.ID_PEDIDO  = :id AND tbl_produtos.ID_PRODUTO = tbl_produtos_pedidos.ID_PRODUTO AND tbl_medidas.ID_MEDIDA = tbl_produtos.ID_MEDIDA");
            $produtos -> bindValue(":id", $id);
            $produtos -> execute();

        } else if (isset($_POST["confirmar"])) {
            $id = $_POST["id"];

            $atualiza = $conn -> prepare("UPDATE tbl_pedidos SET ST_PEDIDO = 2, ID_LOJISTA = :lojista WHERE ID_PEDIDO = :id");
            $atualiza -> bindValue(":id", $id);
            $atualiza -> bindValue(":lojista", $iniget["ID_LOJISTA"]);
            $atualiza -> execute();

            $pedido = $conn -> prepare("SELECT * FROM tbl_pedidos WHERE ID_PEDIDO  = :id AND ID_LOJA = :loja");
            $pedido -> bindValue(":id", $id);
            $pedido -> bindValue(":loja", $iniget["ID_LOJA"]);
            $pedido -> execute();
            $dados = $pedido -> fetch();

            $detalhes = $conn -> prepare("SELECT tbl_tipo_pagamentos.NM_PAGAMENTO, tbl_lojistas.NM_LOJISTA FROM tbl_tipo_pagamentos, tbl_pedidos, tbl_lojistas WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_tipo_pagamentos.ID_PAGAMENTO = tbl_pedidos.ID_PAGAMENTO AND tbl_lojistas.ID_LOJISTA = tbl_pedidos.ID_LOJISTA");
            $detalhes -> bindValue(":id", $id);
            $detalhes -> execute();
            $detalhe = $detalhes -> fetch();

            $usuario = $conn -> prepare("SELECT tbl_usuarios.NR_TELEFONE_USUARIO, tbl_usuarios.NM_USUARIO FROM tbl_usuarios, tbl_pedidos WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_usuarios.ID_USUARIO = tbl_pedidos.ID_USUARIO");
            $usuario -> bindValue(":id", $id);
            $usuario -> execute();
            $user = $usuario -> fetch();

            $produtos = $conn -> prepare("SELECT tbl_produtos_pedidos.ID_PRODUTO, tbl_produtos_pedidos.QT_PRODUTO_PEDIDO, tbl_produtos.ID_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.NM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO FROM tbl_produtos_pedidos, tbl_produtos, tbl_medidas WHERE tbl_produtos_pedidos.ID_PEDIDO  = :id AND tbl_produtos.ID_PRODUTO = tbl_produtos_pedidos.ID_PRODUTO AND tbl_medidas.ID_MEDIDA = tbl_produtos.ID_MEDIDA");
            $produtos -> bindValue(":id", $id);
            $produtos -> execute();

        } else if (isset($_POST["recusar"])) {
            $id = $_POST["id"];

            $atualiza = $conn -> prepare("UPDATE tbl_pedidos SET ST_RECUSA_PEDIDO = 1 WHERE ID_PEDIDO = :id");
            $atualiza -> bindValue(":id", $id);
            $atualiza -> execute();
            echo("<script>window.location.replace('pedidos.php');</script>");

        } else if (isset($_POST["despachar"])) {
            $id = $_POST["id"];

            $atualiza = $conn -> prepare("UPDATE tbl_pedidos SET ST_PEDIDO = 3 WHERE ID_PEDIDO = :id");
            $atualiza -> bindValue(":id", $id);
            $atualiza -> execute();

            $pedido = $conn -> prepare("SELECT * FROM tbl_pedidos WHERE ID_PEDIDO  = :id AND ID_LOJA = :loja");
            $pedido -> bindValue(":id", $id);
            $pedido -> bindValue(":loja", $iniget["ID_LOJA"]);
            $pedido -> execute();
            $dados = $pedido -> fetch();

            $detalhes = $conn -> prepare("SELECT tbl_tipo_pagamentos.NM_PAGAMENTO, tbl_lojistas.NM_LOJISTA FROM tbl_tipo_pagamentos, tbl_pedidos, tbl_lojistas WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_tipo_pagamentos.ID_PAGAMENTO = tbl_pedidos.ID_PAGAMENTO AND tbl_lojistas.ID_LOJISTA = tbl_pedidos.ID_LOJISTA");
            $detalhes -> bindValue(":id", $id);
            $detalhes -> execute();
            $detalhe = $detalhes -> fetch();

            $usuario = $conn -> prepare("SELECT tbl_usuarios.NR_TELEFONE_USUARIO, tbl_usuarios.NM_USUARIO FROM tbl_usuarios, tbl_pedidos WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_usuarios.ID_USUARIO = tbl_pedidos.ID_USUARIO");
            $usuario -> bindValue(":id", $id);
            $usuario -> execute();
            $user = $usuario -> fetch();

            $produtos = $conn -> prepare("SELECT tbl_produtos_pedidos.ID_PRODUTO, tbl_produtos_pedidos.QT_PRODUTO_PEDIDO, tbl_produtos.ID_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.NM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO FROM tbl_produtos_pedidos, tbl_produtos, tbl_medidas WHERE tbl_produtos_pedidos.ID_PEDIDO  = :id AND tbl_produtos.ID_PRODUTO = tbl_produtos_pedidos.ID_PRODUTO AND tbl_medidas.ID_MEDIDA = tbl_produtos.ID_MEDIDA");
            $produtos -> bindValue(":id", $id);
            $produtos -> execute();

        } else if (isset($_POST["entregue"])) {
            $id = $_POST["id"];

            $atualiza = $conn -> prepare("UPDATE tbl_pedidos SET ST_PEDIDO = 4, DT_ENTREGA_PEDIDO = NOW() WHERE ID_PEDIDO = :id");
            $atualiza -> bindValue(":id", $id);
            $atualiza -> execute();

            $pedido = $conn -> prepare("SELECT * FROM tbl_pedidos WHERE ID_PEDIDO  = :id AND ID_LOJA = :loja");
            $pedido -> bindValue(":id", $id);
            $pedido -> bindValue(":loja", $iniget["ID_LOJA"]);
            $pedido -> execute();
            $dados = $pedido -> fetch();

            $detalhes = $conn -> prepare("SELECT tbl_tipo_pagamentos.NM_PAGAMENTO, tbl_lojistas.NM_LOJISTA FROM tbl_tipo_pagamentos, tbl_pedidos, tbl_lojistas WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_tipo_pagamentos.ID_PAGAMENTO = tbl_pedidos.ID_PAGAMENTO AND tbl_lojistas.ID_LOJISTA = tbl_pedidos.ID_LOJISTA");
            $detalhes -> bindValue(":id", $id);
            $detalhes -> execute();
            $detalhe = $detalhes -> fetch();

            $usuario = $conn -> prepare("SELECT tbl_usuarios.NR_TELEFONE_USUARIO, tbl_usuarios.NM_USUARIO FROM tbl_usuarios, tbl_pedidos WHERE tbl_pedidos.ID_PEDIDO = :id AND tbl_usuarios.ID_USUARIO = tbl_pedidos.ID_USUARIO");
            $usuario -> bindValue(":id", $id);
            $usuario -> execute();
            $user = $usuario -> fetch();

            $produtos = $conn -> prepare("SELECT tbl_produtos_pedidos.ID_PRODUTO, tbl_produtos_pedidos.QT_PRODUTO_PEDIDO, tbl_produtos.ID_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.NM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO FROM tbl_produtos_pedidos, tbl_produtos, tbl_medidas WHERE tbl_produtos_pedidos.ID_PEDIDO  = :id AND tbl_produtos.ID_PRODUTO = tbl_produtos_pedidos.ID_PRODUTO AND tbl_medidas.ID_MEDIDA = tbl_produtos.ID_MEDIDA");
            $produtos -> bindValue(":id", $id);
            $produtos -> execute();

        } else {
            echo("<script>window.location.replace('pedidos.php');</script>");
        };
    ?>

    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div class="block blocksidebar" onclick="abrirSidebar()"></div>
    <div class="block" onclick="fecharLateral()"></div>
    <?php include("header.php"); ?>

    <aside>
        <nav>
            <ul class="navbar">
                <div class="sitmobile">
                    <select id="funcionamobile" onchange="abrirLoja()">
                        <option selected class="dpdown" value="aberta">Loja aberta</option>
                        <option class="dpdown" value="fechada">Loja fechada</option>
                     </select>
                </div>
                <li id="menu-dashboard"><a href="dashboard.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm0 80q-33 0-56.5-23.5T160-200v-360q0-19 8.5-36t23.5-28l240-180q11-8 23-12t25-4q13 0 25 4t23 12l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H520v-240h-80v240H240Zm240-350Z"/></svg>Início</a></li>
                <li id="menu-pedidos" class="active"><a href="pedidos.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-50 0-85-35t-35-85v-80q0-17 11.5-28.5T160-320h80v-531q0-9 8-11t16 6l36 36 46-46q6-6 14-6t14 6l46 46 46-46q6-6 14-6t14 6l46 46 46-46q6-6 14-6t14 6l46 46 46-46q6-6 14-6t14 6l46 46 36-36q8-8 16-6.5t8 11.5v651q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-560H320v440h320q17 0 28.5 11.5T680-280v80q0 17 11.5 28.5T720-160ZM399-600q-17 0-28-11.5T360-640q0-17 11.5-28.5T400-680h160q17 0 28.5 11.5T600-640q0 17-11.5 28.5T560-600H399Zm0 120q-17 0-28-11.5T360-520q0-17 11.5-28.5T400-560h160q17 0 28.5 11.5T600-520q0 17-11.5 28.5T560-480H399Zm281-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600Zm0 120q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm-40 0v-80 80Z"/></svg>Pedidos</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3){echo("hidden");};?>" id="menu-avaliacoes"><a href="avaliacoes.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-129q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-531q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-488L662-361l44 189q3 13-2 23.5T690-131q-9 7-21 8t-23-6L480-229Zm0-201Z"/></svg>Avaliações</a></li>
                <h5 class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4){echo("hidden");};?>" id="titulo-catalogo">Catálogo</h5>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3){echo("hidden");};?>" id="menu-produtos"><a href="produtos.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm34 440q-45 0-68-39.5t-2-78.5l54-98-144-304H79q-17 0-28-11.5T40-840q0-17 11.5-28.5T80-880h65q11 0 21 6t15 17l27 57h590q27 0 37 20t-1 42L692-482q-11 20-29 31t-41 11H324l-44 80h441q17 0 28 11.5t11 28.5q0 17-11.5 28.5T720-280H280Zm62-240h280-280Z"/></svg>Produtos</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4){echo("hidden");};?>" id="menu-estoque"><a href="estoque.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M224.118-161Q175-161 140.5-195 106-229 106-279h-6q-24.75 0-42.375-17.625T40-339v-401q0-24 18-42t42-18h519q24.75 0 42.375 17.625T679-740v107h90q7.5 0 13.5 3t10.5 9l121 161q3 3.75 4.5 8.25T920-442v133q0 12.75-8.625 21.375T890-279h-41q0 50-34.382 84-34.383 34-83.5 34Q682-161 647.5-195 613-229 613-279H342q0 50-34.382 84-34.383 34-83.5 34ZM224-221q24 0 41-17t17-41q0-24-17-41t-41-17q-24 0-41 17t-17 41q0 24 17 41t41 17ZM100-740v401h22q17-27 43.041-43 26.041-16 58-16t58.459 16.5Q308-365 325-339h294v-401H100Zm631 519q24 0 41-17t17-41q0-24-17-41t-41-17q-24 0-41 17t-17 41q0 24 17 41t41 17Zm-52-204h186L754-573h-75v148ZM360-540Z"/></svg> Estoque</a></li>
                <h5>Configurações</h5>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3 || $iniget['ID_PERMISSAO_LOJISTA'] == 2){echo("hidden");};?>" id="menu-perfil"><a href="perfil.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M201-120q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518v318q0 33-23.5 56.5T761-120H201Zm368-440q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z"/></svg>Perfil</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3 || $iniget['ID_PERMISSAO_LOJISTA'] == 2){echo("hidden");};?>" id="menu-usuarios"><a href="usuarios.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M38-160v-94q0-35 18-63.5t50-42.5q73-32 131.5-46T358-420q62 0 120 14t131 46q32 14 50.5 42.5T678-254v94H38Zm700 0v-94q0-63-32-103.5T622-423q69 8 130 23.5t99 35.5q33 19 52 47t19 63v94H738ZM358-481q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42Zm360-150q0 66-42 108t-108 42q-11 0-24.5-1.5T519-488q24-25 36.5-61.5T568-631q0-45-12.5-79.5T519-774q11-3 24.5-5t24.5-2q66 0 108 42t42 108ZM98-220h520v-34q0-16-9.5-31T585-306q-72-32-121-43t-106-11q-57 0-106.5 11T130-306q-14 6-23 21t-9 31v34Zm260-321q39 0 64.5-25.5T448-631q0-39-25.5-64.5T358-721q-39 0-64.5 25.5T268-631q0 39 25.5 64.5T358-541Zm0 321Zm0-411Z"/></svg>Usuários</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3 || $iniget['ID_PERMISSAO_LOJISTA'] == 2){echo("hidden");};?>" id="menu-definicoes"><a href="definicoes.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M546-80H414q-11 0-19.5-7T384-105l-16-101q-19-7-40-19t-37-25l-93 43q-11 5-22 1.5T159-220L93-337q-6-10-3-21t12-18l86-63q-2-9-2.5-20.5T185-480q0-9 .5-20.5T188-521l-86-63q-9-7-12-18t3-21l66-117q6-11 17-14.5t22 1.5l93 43q16-13 37-25t40-18l16-102q2-11 10.5-18t19.5-7h132q11 0 19.5 7t10.5 18l16 101q19 7 40.5 18.5T669-710l93-43q11-5 22-1.5t17 14.5l66 116q6 10 3.5 21.5T858-584l-86 61q2 10 2.5 21.5t.5 21.5q0 10-.5 21t-2.5 21l86 62q9 7 12 18t-3 21l-66 117q-6 11-17 14.5t-22-1.5l-93-43q-16 13-36.5 25.5T592-206l-16 101q-2 11-10.5 18T546-80Zm-66-270q54 0 92-38t38-92q0-54-38-92t-92-38q-54 0-92 38t-38 92q0 54 38 92t92 38Zm0-60q-29 0-49.5-20.5T410-480q0-29 20.5-49.5T480-550q29 0 49.5 20.5T550-480q0 29-20.5 49.5T480-410Zm0-70Zm-44 340h88l14-112q33-8 62.5-25t53.5-41l106 46 40-72-94-69q4-17 6.5-33.5T715-480q0-17-2-33.5t-7-33.5l94-69-40-72-106 46q-23-26-52-43.5T538-708l-14-112h-88l-14 112q-34 7-63.5 24T306-642l-106-46-40 72 94 69q-4 17-6.5 33.5T245-480q0 17 2.5 33.5T254-413l-94 69 40 72 106-46q24 24 53.5 41t62.5 25l14 112Z"/></svg>Definições</a></li>
                <li id="menu-conta"><a href="conta.php">Conta<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M222-255q63-44 125-67.5T480-346q71 0 133.5 23.5T739-255q44-54 62.5-109T820-480q0-145-97.5-242.5T480-820q-145 0-242.5 97.5T140-480q0 61 19 116t63 109Zm257.814-195Q422-450 382.5-489.686q-39.5-39.686-39.5-97.5t39.686-97.314q39.686-39.5 97.5-39.5t97.314 39.686q39.5 39.686 39.5 97.5T577.314-489.5q-39.686 39.5-97.5 39.5Zm.654 370Q398-80 325-111.5q-73-31.5-127.5-86t-86-127.266Q80-397.532 80-480.266T111.5-635.5q31.5-72.5 86-127t127.266-86q72.766-31.5 155.5-31.5T635.5-848.5q72.5 31.5 127 86t86 127.032q31.5 72.532 31.5 155T848.5-325q-31.5 73-86 127.5t-127.032 86q-72.532 31.5-155 31.5ZM480-140q55 0 107.5-16T691-212q-51-36-104-55t-107-19q-54 0-107 19t-104 55q51 40 103.5 56T480-140Zm0-370q34 0 55.5-21.5T557-587q0-34-21.5-55.5T480-664q-34 0-55.5 21.5T403-587q0 34 21.5 55.5T480-510Zm0-77Zm0 374Z"/></svg></a></li>
                <h5>Legal</h5>
                <li id="menu-suporte"><a href="../suporte/index.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M478-240q21 0 35.5-14.5T528-290q0-21-14.5-35.5T478-340q-21 0-35.5 14.5T428-290q0 21 14.5 35.5T478-240Zm2 160q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Zm4-172q25 0 43.5 16t18.5 40q0 22-13.5 39T502-525q-23 20-40.5 44T444-427q0 14 10.5 23.5T479-394q15 0 25.5-10t13.5-25q4-21 18-37.5t30-31.5q23-22 39.5-48t16.5-58q0-51-41.5-83.5T484-720q-38 0-72.5 16T359-655q-7 12-4.5 25.5T368-609q14 8 29 5t25-17q11-15 27.5-23t34.5-8Z"/></svg>Ajuda</a></li>
                <li id="menu-politicas"><a href="../suporte/politicas.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M478-240q21 0 35.5-14.5T528-290q0-21-14.5-35.5T478-340q-21 0-35.5 14.5T428-290q0 21 14.5 35.5T478-240Zm2 160q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Zm4-172q25 0 43.5 16t18.5 40q0 22-13.5 39T502-525q-23 20-40.5 44T444-427q0 14 10.5 23.5T479-394q15 0 25.5-10t13.5-25q4-21 18-37.5t30-31.5q23-22 39.5-48t16.5-58q0-51-41.5-83.5T484-720q-38 0-72.5 16T359-655q-7 12-4.5 25.5T368-609q14 8 29 5t25-17q11-15 27.5-23t34.5-8Z"/></svg>Políticas</a></li>
            </ul>
        </nav>pedido
    </aside>

    <main class="exibicao">
        <section class="dsh">  
            <a href="pedidos.php" class="btvoltar"><svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M359-242 120-481l239-239 43 43-166 166h604v60H236l166 166-43 43Z"/></svg> Voltar</a>
            <br/><br/>
            <?php
                if ($dados["NR_TIPO_ENTREGA_PEDIDO"] == 1) {
                    $logistica = "Entrega própria";
                } else {
                    $logistica = "Retirada pelo cliente";
                };

                if ($dados["ST_PEDIDO"] == 1) {
                    echo("
                        <div class='status'>
                            <h3>Confirme o pedido para mais detalhes</h3>
                            <p>As informações do cliente estarão ocultas até a confirmação do pedido</p>
                        </div>
                        <div class='titulor'><h2 id='infocliente'>Pedido #".$dados["ID_PEDIDO"]."</h2><p>Feito às ".date('H:i', strtotime($dados["DT_TRANSACAO_PEDIDO"]))."</p></div>
                        <div class='alertas'>
                            <div class='alerta'>
                                <p id='previsao'>Entrega prevista <b>16:20</b></p>
                            </div>
                            <div class='alerta'>
                                <p id='andamento' class='andamento'>Aguardando confirmação</p>
                            </div>
                        </div>
                        <div class='log'>
                            <p><span class='tipo'>".$logistica."</span><span class='endereco' id='endereco'>".$dados["NM_BAIRRO_PEDIDO"]." • ".$dados["NM_CIDADE_PEDIDO"]."/".$dados["SG_UF_PEDIDO"]." • CEP ".$dados["NR_CEP_PEDIDO"]."</span></p>
                        </div>
                    ");
                } else if ($dados["ST_PEDIDO"] == 2) {
                    echo("
                        <div class='titulor'><h2 id='infocliente'>".ucwords(strtolower($user["NM_USUARIO"]))." • Pedido #".$dados["ID_PEDIDO"]."</h2><p>Feito às ".date('H:i', strtotime($dados["DT_TRANSACAO_PEDIDO"]))."</p></div>
                        <div class='alertas'>
                            <div class='alerta'>
                                <p id='previsao'>Entrega prevista <b>16:20</b></p>
                            </div>
                            <div class='alerta' id='atendente'>
                                <p>Atendente <b>".ucwords(strtolower($detalhe["NM_LOJISTA"]))."</b></p>
                            </div>
                            <div class='alerta'>
                                <p id='andamento' class='andamento'>Preparando o pedido</p>
                            </div>
                            <a href='tel:".$user["NR_TELEFONE_USUARIO"]."' class='btl btcontato telefone'>".$user["NR_TELEFONE_USUARIO"]."</a>
                        </div>
                        <div class='log'>
                            <p><span class='tipo'>".$logistica."</span><span class='endereco' id='endereco'>".$dados["DS_LOGRADOURO_PEDIDO"].", ".$dados["DS_COMPLEMENTO_PEDIDO"]." • ".$dados["NM_BAIRRO_PEDIDO"]." • ".$dados["NM_CIDADE_PEDIDO"]."/".$dados["SG_UF_PEDIDO"]." • CEP ".$dados["NR_CEP_PEDIDO"]."</span></p>
                        </div>
                    ");
                } else if ($dados["ST_PEDIDO"] == 3) {
                    echo("
                        <div class='titulor'><h2 id='infocliente'>".ucwords(strtolower($user["NM_USUARIO"]))." • Pedido #".$dados["ID_PEDIDO"]."</h2><p>Feito às ".date('H:i', strtotime($dados["DT_TRANSACAO_PEDIDO"]))."</p></div>
                        <div class='alertas'>
                            <div class='alerta'>
                                <p id='previsao'>Entrega prevista <b>16:20</b></p>
                            </div>
                            <div class='alerta' id='atendente'>
                                <p>Atendente <b>".ucwords(strtolower($detalhe["NM_LOJISTA"]))."</b></p>
                            </div>
                            <div class='alerta'>
                                <p id='andamento' class='andamento'>Em rota de entrega</p>
                            </div>
                            <a href='tel:".$user["NR_TELEFONE_USUARIO"]."' class='btl btcontato telefone'>".$user["NR_TELEFONE_USUARIO"]."</a>
                        </div>
                        <div class='log'>
                            <p><span class='tipo'>".$logistica."</span><span class='endereco' id='endereco'>".$dados["DS_LOGRADOURO_PEDIDO"].", ".$dados["DS_COMPLEMENTO_PEDIDO"]." • ".$dados["NM_BAIRRO_PEDIDO"]." • ".$dados["NM_CIDADE_PEDIDO"]."/".$dados["SG_UF_PEDIDO"]." • CEP ".$dados["NR_CEP_PEDIDO"]."</span></p>
                        </div>
                    ");

                } else {
                    echo("
                    <div class='titulor'><h2 id='infocliente'>".ucwords(strtolower($user["NM_USUARIO"]))." • Pedido #".$dados["ID_PEDIDO"]."</h2><p>Feito às ".date('H:i', strtotime($dados["DT_TRANSACAO_PEDIDO"]))."</p></div>
                    <div class='alertas'>
                        <div class='alerta'>
                            <p id='previsao'>Entrega prevista <b>16:20</b></p>
                        </div>
                        <div class='alerta' id='atendente'>
                            <p>Atendente <b>".ucwords(strtolower($detalhe["NM_LOJISTA"]))."</b></p>
                        </div>
                        <div class='alerta'>
                            <p id='andamento' class='andamento'>Concluído</p>
                        </div>
                    </div>
                    <div class='log'>
                        <p><span class='tipo'>".$logistica."</span><span class='endereco' id='endereco'>".$dados["DS_LOGRADOURO_PEDIDO"].", ".$dados["DS_COMPLEMENTO_PEDIDO"]." • ".$dados["NM_BAIRRO_PEDIDO"]." • ".$dados["NM_CIDADE_PEDIDO"]."/".$dados["SG_UF_PEDIDO"]." • CEP ".$dados["NR_CEP_PEDIDO"]."</span></p>
                    </div>
                ");
                }
            ?>
            

            <div class="tabelamento">
                <table id="tblitens" class="tabela">
                    <thead>
                        <tr class=cabecalho>
                            <th>Código</th>
                            <th>Quantidade</th>
                            <th>Descrição</th>
                            <th>Total</th>
                        </tr>
                    <tbody>
                        <?php
                            $total = 0;
                            if ($produtos -> rowCount() > 0) {
                                while($produto = $produtos -> fetch()){ 
                                    echo ("
                                    <tr>
                                    <td>".$produto["ID_PRODUTO"]."</td>
                                    <td>".$produto["QT_PRODUTO_PEDIDO"]."x</td>
                                    <td>".$produto["NM_PRODUTO"]."</td>
                                    <td>R$ ".$produto["VL_VENDA_PRODUTO"] * $produto["QT_PRODUTO_PEDIDO"]."</td>
                                    </tr>
                                    ");
                                    $total = $total + ($produto["VL_VENDA_PRODUTO"] * $produto["QT_PRODUTO_PEDIDO"]);
                                };
                            };
                        ?>
                    </tbody>
                </table>
            </div>

            <form action="cupom.php" method="POST">
                <input type="text" class="hidden" value="<?php echo("$id"); ?>" name="id"/>
                <?php
                    if ($dados["ST_PEDIDO"] == 1) {
                        echo ("<input type='submit' class='bta btconfirmar' name='confirmar' id='confirmacao' value='Confirmar'/>");
                        echo ("<input type='submit' class='btb btconfirmar' name='recusar' id='recusar' value='Recusar'/>");
                    } else if ($dados["ST_PEDIDO"] == 2) {
                        echo(" 
                        <div class='cobranca'>
                            <p><span class='tipo'>".$detalhe["NM_PAGAMENTO"]."</span><span class='pagamento'>Total do pedido <b>R$ ".$total."</b></span></p>
                        </div>
                        <div class='observacao'>
                            <p>Observação: <b>".$dados["DS_OBSERVACAO_PEDIDO"]."</b></p>
                        </div>
                        ");

                        echo ("<input type='submit' class='bta btconfirmar' name='despachar' id='confirmacao' value='Despachar'/>");
                        echo ("<button type='button' class='btb btimpressao' onclick='window.print()'><svg xmlns='http://www.w3.org/2000/svg' height='24' viewBox='0 -960 960 960' width='24'><path class='impressora' d='M658-648v-132H302v132h-60v-162q0-12.75 8.625-21.375T272-840h416q12.75 0 21.375 8.625T718-810v162h-60Zm-518 60h680-680Zm599 95q12 0 21-9t9-21q0-12-9-21t-21-9q-12 0-21 9t-9 21q0 12 9 21t21 9ZM302-180h356v-192H302v192Zm0 60q-24.75 0-42.375-17.625T242-180v-116H110q-12.75 0-21.375-8.625T80-326v-216q0-45.05 30.5-75.525Q141-648 186-648h588q45.05 0 75.525 30.475Q880-587.05 880-542v216q0 12.75-8.625 21.375T850-296H718v116q0 24.75-17.625 42.375T658-120H302Zm518-236v-186.215Q820-562 806.775-575 793.55-588 774-588H186q-19.55 0-32.775 13.225Q140-561.55 140-542v186h102v-76h476v76h102Z'/></svg></button>");
                    } else if ($dados["ST_PEDIDO"] == 3) {
                        echo(" 
                        <div class='cobranca'>
                            <p><span class='tipo'>".$detalhe["NM_PAGAMENTO"]."</span><span class='pagamento'>Total do pedido <b>R$ ".$total."</b></span></p>
                        </div>
                        <div class='observacao'>
                            <p>Observação: <b>".$dados["DS_OBSERVACAO_PEDIDO"]."</b></p>
                        </div>
                        ");

                        echo ("<input type='submit' class='bta btconfirmar' name='entregue' id='confirmacao' value='Finalizar'/>");
                        echo ("<button type='button' class='btb btimpressao' onclick='window.print()'><svg xmlns='http://www.w3.org/2000/svg' height='24' viewBox='0 -960 960 960' width='24'><path class='impressora' d='M658-648v-132H302v132h-60v-162q0-12.75 8.625-21.375T272-840h416q12.75 0 21.375 8.625T718-810v162h-60Zm-518 60h680-680Zm599 95q12 0 21-9t9-21q0-12-9-21t-21-9q-12 0-21 9t-9 21q0 12 9 21t21 9ZM302-180h356v-192H302v192Zm0 60q-24.75 0-42.375-17.625T242-180v-116H110q-12.75 0-21.375-8.625T80-326v-216q0-45.05 30.5-75.525Q141-648 186-648h588q45.05 0 75.525 30.475Q880-587.05 880-542v216q0 12.75-8.625 21.375T850-296H718v116q0 24.75-17.625 42.375T658-120H302Zm518-236v-186.215Q820-562 806.775-575 793.55-588 774-588H186q-19.55 0-32.775 13.225Q140-561.55 140-542v186h102v-76h476v76h102Z'/></svg></button>");
                    } else {
                        echo(" 
                        <div class='cobranca'>
                            <p><span class='tipo'>".$detalhe["NM_PAGAMENTO"]."</span><span class='pagamento'>Total do pedido <b>R$ ".$total."</b></span></p>
                        </div>
                        <div class='observacao'>
                            <p>Observação: <b>".$dados["DS_OBSERVACAO_PEDIDO"]."</b></p>
                        </div>
                        ");

                        echo ("<button type='button' class='btb btimpressao' onclick='window.print()'><svg xmlns='http://www.w3.org/2000/svg' height='24' viewBox='0 -960 960 960' width='24'><path class='impressora' d='M658-648v-132H302v132h-60v-162q0-12.75 8.625-21.375T272-840h416q12.75 0 21.375 8.625T718-810v162h-60Zm-518 60h680-680Zm599 95q12 0 21-9t9-21q0-12-9-21t-21-9q-12 0-21 9t-9 21q0 12 9 21t21 9ZM302-180h356v-192H302v192Zm0 60q-24.75 0-42.375-17.625T242-180v-116H110q-12.75 0-21.375-8.625T80-326v-216q0-45.05 30.5-75.525Q141-648 186-648h588q45.05 0 75.525 30.475Q880-587.05 880-542v216q0 12.75-8.625 21.375T850-296H718v116q0 24.75-17.625 42.375T658-120H302Zm518-236v-186.215Q820-562 806.775-575 793.55-588 774-588H186q-19.55 0-32.775 13.225Q140-561.55 140-542v186h102v-76h476v76h102Z'/></svg></button>");
                    }
                ?>
            </form>
        </section>

        <?php include("avisos.php"); ?>
        <section id="chat" class="lateral">
            <div class="fechar"><span>Chat</span><button type="button" onclick="fecharLateral()"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button></div>
            <div class="conteudo mensagens comfundo">
                <div class="introchat">
                    <img src="../images/usuario.png" alt="Icone usuário"/>
                    <h2>Ana Castro</h2>
                </div>
                <div class="chat">
                    <ul class="dias">
                        <li class="dia">
                            <h6>22 de maio, 16:24h</h6>
                            <ul class="Chat">
                                <li class="msusuario">Olá! Bom dia!</li>
                                <li class="msusuario">Meu pedido está demorando</li>
                                <br/>
                                <li class="msloja">Bom dia Ana! Vamos verificar o ocorrido.</li>
                                <br/>
                                <li class="msusuario">Tá ok! Muito obrigado.</li>
                                <br/>
                                <li class="msloja">Houve um problema durante a entrega, iremos enviar novamente</li>
                                <br/>
                                <li class="msusuario">Perfeito</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="digitador" class="fundo">
                <input type="text" class="txti" placeholder="Enviar mensagem"/>
            </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="dash">
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

    <script>
        $(document).ready(function() {
            tabelasData('#tblitens');
            $('.telefone').mask('(00) 00000-0000');
        });
    </script>
</body>
</html>