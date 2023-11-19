<?php
    session_start();
    if(!isset($_SESSION["SSO_LOJISTA_CARAMEL"])){
        header("location: login.php");
    } else {
        include("../sources/config.php");
        $usuario = $_SESSION["SSO_LOJISTA_CARAMEL"];
        $consultar = $conn -> prepare("SELECT ID_PERMISSAO_LOJISTA, ID_LOJA, ST_ATIVIDADE_LOJISTA FROM tbl_lojistas WHERE ID_LOJISTA = :id");
        $consultar -> bindValue(":id", $usuario);
        $consultar -> execute();
        $iniget = $consultar -> fetch();

        if($iniget["ID_PERMISSAO_LOJISTA"] == 4) { header("location: negado.php"); } // ATENDENTE
        if($iniget["ST_ATIVIDADE_LOJISTA"] == 0) { header("location: negado.php"); } // NEGA QUANDO DESATIVADO
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../sources/script.js"></script>
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body class="portal">
    <?php
        if(isset($_POST["atualiza_estoque"])) {
            $id = $_POST["id"];
            $atual = $_POST["qtde_atual"];
            $nova = $_POST["nova_qtde"];
            if(isset($_POST["modo_compra"])) { $compra = true; } else { $compra = false; };

            if ($nova == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo nova quantidade encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                if ($compra == true) {
                    $qtde_final = $atual + $nova;
                } else {
                    $qtde_final = $nova;
                };

                $sql = $conn -> prepare("UPDATE tbl_produtos SET QT_ESTOQUE_PRODUTO = :quantidade WHERE ID_PRODUTO = :id AND ID_LOJA = :loja");
                $sql -> bindValue(":id", $id);
                $sql -> bindValue(":loja", $iniget["ID_LOJA"]);
                $sql -> bindValue(":quantidade", $qtde_final);
                $sql -> execute();
    
                    echo ("<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Estoque atualizado',
                            text: 'O estoque foi atualizado com sucesso! O estoque do item já está atualizado na base de sua loja.',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
     
                            };
                        })
                    </script>");
            }
        };

        $secoes = $conn -> prepare("SELECT * FROM tbl_secoes WHERE ID_LOJA = :id AND ST_EXCLUIDO_SECAO = 0");
        $secoes -> bindValue(":id", $iniget["ID_LOJA"]);
        $secoes -> execute();

        $produtos = $conn -> prepare("SELECT tbl_produtos.ID_PRODUTO, tbl_produtos.NM_PRODUTO, tbl_produtos.QT_ESTOQUE_PRODUTO, tbl_medidas.SG_MEDIDA, tbl_secoes.NM_SECAO FROM tbl_produtos, tbl_secoes, tbl_medidas WHERE tbl_medidas.ID_MEDIDA = tbl_produtos.ID_MEDIDA AND tbl_secoes.ID_SECAO = tbl_produtos.ID_SECAO AND tbl_produtos.ID_LOJA = :loja AND tbl_produtos.ST_ESTOQUE_PRODUTO = 1 AND tbl_produtos.ST_ATIVIDADE_PRODUTO = 1");
        $produtos -> bindValue(":loja", $iniget["ID_LOJA"]);
        $produtos -> execute();
    ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div class="block blocksidebar" onclick="abrirSidebar()"></div>
    <div class="block" onclick="fecharLateral()"></div>
    <?php include("header.php"); ?>

    <dialog id="mdajuste" onkeydown="removeBlur()">
        <div class="cabeca">
            <h1>Ajuste de estoque</h1>
            <button class="mdfechar" type="button" onclick="fecharModal('#mdajuste')"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button>
        </div>
        <div class="conteudo">
            <form method="POST" action="estoque.php">
                <input name="id" type="text" class="hidden" id="id_produto"/>
                <input name="qtde_atual" type="text" class="hidden" id="qtde_produto"/>
                <input name="nova_qtde" type="number" step=".001" placeholder="Quantidade atual" class="txti qtde" required/>
                <div class="labelcheck">
                    <p class="left fit">Adicionar ao atual (modo compra)</p>
                    <label class="switch right">
                        <input name="modo_compra" type="checkbox"/>
                        <span class="slider round"></span>
                    </label>
                </div>
                <p class="obs">Ao término do estoque o produto será pausado automaticamente e não ficará visível na página na loja</p>
            <input name="atualiza_estoque" type="submit" class="bta rbtcontent" value="Confirmar"/>
            <button type="button" class="btb rbtcontent" onclick="fecharModal('#mdajuste')">Cancelar</button>
            </form>
        </div>
    </dialog>

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
                <li id="menu-pedidos"><a href="pedidos.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-50 0-85-35t-35-85v-80q0-17 11.5-28.5T160-320h80v-531q0-9 8-11t16 6l36 36 46-46q6-6 14-6t14 6l46 46 46-46q6-6 14-6t14 6l46 46 46-46q6-6 14-6t14 6l46 46 46-46q6-6 14-6t14 6l46 46 36-36q8-8 16-6.5t8 11.5v651q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-560H320v440h320q17 0 28.5 11.5T680-280v80q0 17 11.5 28.5T720-160ZM399-600q-17 0-28-11.5T360-640q0-17 11.5-28.5T400-680h160q17 0 28.5 11.5T600-640q0 17-11.5 28.5T560-600H399Zm0 120q-17 0-28-11.5T360-520q0-17 11.5-28.5T400-560h160q17 0 28.5 11.5T600-520q0 17-11.5 28.5T560-480H399Zm281-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600Zm0 120q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm-40 0v-80 80Z"/></svg>Pedidos</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3){echo("hidden");};?>" id="menu-avaliacoes"><a href="avaliacoes.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-129q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-531q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-488L662-361l44 189q3 13-2 23.5T690-131q-9 7-21 8t-23-6L480-229Zm0-201Z"/></svg>Avaliações</a></li>
                <h5 id="titulo-catalogo">Catálogo</h5>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3){echo("hidden");};?>" id="menu-produtos"><a href="produtos.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm34 440q-45 0-68-39.5t-2-78.5l54-98-144-304H79q-17 0-28-11.5T40-840q0-17 11.5-28.5T80-880h65q11 0 21 6t15 17l27 57h590q27 0 37 20t-1 42L692-482q-11 20-29 31t-41 11H324l-44 80h441q17 0 28 11.5t11 28.5q0 17-11.5 28.5T720-280H280Zm62-240h280-280Z"/></svg>Produtos</a></li>
                <li class="active" id="menu-estoque"><a href="estoque.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M224.118-161Q175-161 140.5-195 106-229 106-279h-6q-24.75 0-42.375-17.625T40-339v-401q0-24 18-42t42-18h519q24.75 0 42.375 17.625T679-740v107h90q7.5 0 13.5 3t10.5 9l121 161q3 3.75 4.5 8.25T920-442v133q0 12.75-8.625 21.375T890-279h-41q0 50-34.382 84-34.383 34-83.5 34Q682-161 647.5-195 613-229 613-279H342q0 50-34.382 84-34.383 34-83.5 34ZM224-221q24 0 41-17t17-41q0-24-17-41t-41-17q-24 0-41 17t-17 41q0 24 17 41t41 17ZM100-740v401h22q17-27 43.041-43 26.041-16 58-16t58.459 16.5Q308-365 325-339h294v-401H100Zm631 519q24 0 41-17t17-41q0-24-17-41t-41-17q-24 0-41 17t-17 41q0 24 17 41t41 17Zm-52-204h186L754-573h-75v148ZM360-540Z"/></svg> Estoque</a></li>
                <h5>Configurações</h5>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3 || $iniget['ID_PERMISSAO_LOJISTA'] == 2){echo("hidden");};?>" id="menu-perfil"><a href="perfil.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M201-120q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518v318q0 33-23.5 56.5T761-120H201Zm368-440q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z"/></svg>Perfil</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3 || $iniget['ID_PERMISSAO_LOJISTA'] == 2){echo("hidden");};?>" id="menu-usuarios"><a href="usuarios.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M38-160v-94q0-35 18-63.5t50-42.5q73-32 131.5-46T358-420q62 0 120 14t131 46q32 14 50.5 42.5T678-254v94H38Zm700 0v-94q0-63-32-103.5T622-423q69 8 130 23.5t99 35.5q33 19 52 47t19 63v94H738ZM358-481q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42Zm360-150q0 66-42 108t-108 42q-11 0-24.5-1.5T519-488q24-25 36.5-61.5T568-631q0-45-12.5-79.5T519-774q11-3 24.5-5t24.5-2q66 0 108 42t42 108ZM98-220h520v-34q0-16-9.5-31T585-306q-72-32-121-43t-106-11q-57 0-106.5 11T130-306q-14 6-23 21t-9 31v34Zm260-321q39 0 64.5-25.5T448-631q0-39-25.5-64.5T358-721q-39 0-64.5 25.5T268-631q0 39 25.5 64.5T358-541Zm0 321Zm0-411Z"/></svg>Usuários</a></li>
                <li class="<?php if($iniget['ID_PERMISSAO_LOJISTA'] == 4 || $iniget['ID_PERMISSAO_LOJISTA'] == 3 || $iniget['ID_PERMISSAO_LOJISTA'] == 2){echo("hidden");};?>" id="menu-definicoes"><a href="definicoes.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M546-80H414q-11 0-19.5-7T384-105l-16-101q-19-7-40-19t-37-25l-93 43q-11 5-22 1.5T159-220L93-337q-6-10-3-21t12-18l86-63q-2-9-2.5-20.5T185-480q0-9 .5-20.5T188-521l-86-63q-9-7-12-18t3-21l66-117q6-11 17-14.5t22 1.5l93 43q16-13 37-25t40-18l16-102q2-11 10.5-18t19.5-7h132q11 0 19.5 7t10.5 18l16 101q19 7 40.5 18.5T669-710l93-43q11-5 22-1.5t17 14.5l66 116q6 10 3.5 21.5T858-584l-86 61q2 10 2.5 21.5t.5 21.5q0 10-.5 21t-2.5 21l86 62q9 7 12 18t-3 21l-66 117q-6 11-17 14.5t-22-1.5l-93-43q-16 13-36.5 25.5T592-206l-16 101q-2 11-10.5 18T546-80Zm-66-270q54 0 92-38t38-92q0-54-38-92t-92-38q-54 0-92 38t-38 92q0 54 38 92t92 38Zm0-60q-29 0-49.5-20.5T410-480q0-29 20.5-49.5T480-550q29 0 49.5 20.5T550-480q0 29-20.5 49.5T480-410Zm0-70Zm-44 340h88l14-112q33-8 62.5-25t53.5-41l106 46 40-72-94-69q4-17 6.5-33.5T715-480q0-17-2-33.5t-7-33.5l94-69-40-72-106 46q-23-26-52-43.5T538-708l-14-112h-88l-14 112q-34 7-63.5 24T306-642l-106-46-40 72 94 69q-4 17-6.5 33.5T245-480q0 17 2.5 33.5T254-413l-94 69 40 72 106-46q24 24 53.5 41t62.5 25l14 112Z"/></svg>Definições</a></li>
                <li id="menu-conta"><a href="conta.php">Conta<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M222-255q63-44 125-67.5T480-346q71 0 133.5 23.5T739-255q44-54 62.5-109T820-480q0-145-97.5-242.5T480-820q-145 0-242.5 97.5T140-480q0 61 19 116t63 109Zm257.814-195Q422-450 382.5-489.686q-39.5-39.686-39.5-97.5t39.686-97.314q39.686-39.5 97.5-39.5t97.314 39.686q39.5 39.686 39.5 97.5T577.314-489.5q-39.686 39.5-97.5 39.5Zm.654 370Q398-80 325-111.5q-73-31.5-127.5-86t-86-127.266Q80-397.532 80-480.266T111.5-635.5q31.5-72.5 86-127t127.266-86q72.766-31.5 155.5-31.5T635.5-848.5q72.5 31.5 127 86t86 127.032q31.5 72.532 31.5 155T848.5-325q-31.5 73-86 127.5t-127.032 86q-72.532 31.5-155 31.5ZM480-140q55 0 107.5-16T691-212q-51-36-104-55t-107-19q-54 0-107 19t-104 55q51 40 103.5 56T480-140Zm0-370q34 0 55.5-21.5T557-587q0-34-21.5-55.5T480-664q-34 0-55.5 21.5T403-587q0 34 21.5 55.5T480-510Zm0-77Zm0 374Z"/></svg></a></li>
                <h5>Legal</h5>
                <li id="menu-suporte"><a href="../suporte/index.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M478-240q21 0 35.5-14.5T528-290q0-21-14.5-35.5T478-340q-21 0-35.5 14.5T428-290q0 21 14.5 35.5T478-240Zm2 160q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Zm4-172q25 0 43.5 16t18.5 40q0 22-13.5 39T502-525q-23 20-40.5 44T444-427q0 14 10.5 23.5T479-394q15 0 25.5-10t13.5-25q4-21 18-37.5t30-31.5q23-22 39.5-48t16.5-58q0-51-41.5-83.5T484-720q-38 0-72.5 16T359-655q-7 12-4.5 25.5T368-609q14 8 29 5t25-17q11-15 27.5-23t34.5-8Z"/></svg>Ajuda</a></li>
                <li id="menu-politicas"><a href="../suporte/politicas.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M478-240q21 0 35.5-14.5T528-290q0-21-14.5-35.5T478-340q-21 0-35.5 14.5T428-290q0 21 14.5 35.5T478-240Zm2 160q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Zm4-172q25 0 43.5 16t18.5 40q0 22-13.5 39T502-525q-23 20-40.5 44T444-427q0 14 10.5 23.5T479-394q15 0 25.5-10t13.5-25q4-21 18-37.5t30-31.5q23-22 39.5-48t16.5-58q0-51-41.5-83.5T484-720q-38 0-72.5 16T359-655q-7 12-4.5 25.5T368-609q14 8 29 5t25-17q11-15 27.5-23t34.5-8Z"/></svg>Políticas</a></li>
            </ul>
        </nav>
    </aside>

    <main class="exibicao">
        <section class="dsh">
            <div class="titulor"><h2>Estoque</h2></div>
            <div class="filtragem">
                <div class="menor">
                    <label for="categoria">Seção</label>
                    <select class="txti">
                        <?php if($secoes -> rowCount() != 0){ while($row = $secoes -> fetch()){ echo("<option value='".$row["ID_SECAO"]."'>".$row["NM_SECAO"]."</option>"); }; }; ?>
                    </select>
                </div>
                <div class="grande"> 
                    <label for="busca">Busca</label>
                    <input type="text" class="txti" placeholder="Busca de produtos"/>
                </div>
                <div class="pedidors fim">
                    <button type="button" class="bta btfiltro">Filtrar</button>
                </div>
            </div>
            <div class="tabelamento">
                <table id="tblestoque" class="tabela">
                    <thead>
                        <tr class=cabecalho>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Seção</th>
                            <th>Unidade</th>
                            <th>Atual</th>
                            <th>Ação</th>
                        </tr>
                    <tbody>
                        <?php
                            while($row_produtos = $produtos -> fetch()) {
                                echo "<tr>";
                                echo "
                                    <td>".$row_produtos["ID_PRODUTO"]."</td>
                                    <td>".$row_produtos["NM_PRODUTO"]."</td>
                                    <td>".$row_produtos["NM_SECAO"]."</td>
                                    <td>".$row_produtos["SG_MEDIDA"]."</td>
                                    <td>".$row_produtos["QT_ESTOQUE_PRODUTO"]."</td>
                                    <td><button type='button' class='btlink' onclick=\"ajusteEstoque('".$row_produtos["ID_PRODUTO"]."', '".$row_produtos["QT_ESTOQUE_PRODUTO"]."')\">Ajustar</button></td>
                                ";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php include("avisos.php"); ?>
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
        tabelasData('#tblestoque');
        leituraUsuario();
    });
    </script>

    <script>
        $('.qtde').mask('00.000', {reverse: false});
    </script>
</body>
</html>