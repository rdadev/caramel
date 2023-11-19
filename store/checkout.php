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
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body>
    <?php
        include("../sources/config.php");

        $carrinho = $conn -> prepare("SELECT tbl_carrinho.ID_CARRINHO, tbl_carrinho.ID_LOJA, tbl_lojas.HR_TEMPO_ENTREGA_LOJA, tbl_lojas.VL_TAXA_ENTREGA_LOJA, tbl_lojas.NM_LOJA FROM tbl_carrinho, tbl_lojas WHERE tbl_carrinho.ID_USUARIO = :id AND tbl_carrinho.ID_LOJA = tbl_lojas.ID_LOJA");
        $carrinho -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
        $carrinho -> execute();
        $store = $carrinho -> fetch();

        $carrinho3 = $conn -> prepare("SELECT tbl_carrinho.ID_CARRINHO, tbl_carrinho.ID_PRODUTO, tbl_carrinho.ID_LOJA, tbl_carrinho.QT_CARRINHO, tbl_produtos.DS_PRODUTO, tbl_carrinho.QT_CARRINHO, tbl_produtos.NM_PRODUTO, tbl_produtos.DS_CAMINHO_IMAGEM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO, tbl_medidas.DS_NOMENCLATURA_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.QT_UNIDADE_PRODUTO FROM tbl_carrinho, tbl_produtos, tbl_medidas WHERE ID_USUARIO = :id AND tbl_carrinho.ID_PRODUTO = tbl_produtos.ID_PRODUTO AND tbl_produtos.ID_MEDIDA = tbl_medidas.ID_MEDIDA");
        $carrinho3 -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
        $carrinho3 -> execute();

        $carrinho4 = $conn -> prepare("SELECT tbl_carrinho.ID_CARRINHO, tbl_carrinho.ID_PRODUTO, tbl_carrinho.ID_LOJA, tbl_carrinho.QT_CARRINHO, tbl_produtos.DS_PRODUTO, tbl_carrinho.QT_CARRINHO, tbl_produtos.NM_PRODUTO, tbl_produtos.DS_CAMINHO_IMAGEM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO, tbl_medidas.DS_NOMENCLATURA_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.QT_UNIDADE_PRODUTO FROM tbl_carrinho, tbl_produtos, tbl_medidas WHERE ID_USUARIO = :id AND tbl_carrinho.ID_PRODUTO = tbl_produtos.ID_PRODUTO AND tbl_produtos.ID_MEDIDA = tbl_medidas.ID_MEDIDA");
        $carrinho4 -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
        $carrinho4 -> execute();

        $usuario = $conn -> prepare("SELECT * FROM tbl_usuarios WHERE ID_USUARIO = :id");
        $usuario -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
        $usuario -> execute();
        $dados = $usuario -> fetch();

        if ($carrinho -> rowCount() == 0) {
            echo("<script>window.location.replace('index.php');</script>");
        } else {
            if (isset($_POST["pedir"])) {
                $cep = $_POST["cep"];
                $cidade = $_POST["cidade"];
                $estado = $_POST["estado"];
                $bairro = $_POST["bairro"];
                $logradouro = $_POST["logradouro"];
                $complemento = $_POST["complemento"];
                $logistica = $_POST["logistica"];
                $pagamento = $_POST["pagamento"];
                $observacao = $_POST["observacao"];
                $unico = mt_rand(1, 2147483647);
                $total = 0;
    
                // CALCULA TOTAL DO PEDIDO
                if ($carrinho3 -> rowCount() != 0) { 
                    while ($produto = $carrinho3 -> fetch()) {
                        $total = $total + ($produto["VL_VENDA_PRODUTO"] * $produto["QT_CARRINHO"]);
                    };
                };
    
                // VERIFICACAO DE DUPLICIDADES
                $verifica_id = $conn -> prepare("SELECT ID_PEDIDO FROM tbl_pedidos WHERE ID_PEDIDO = :id");
                $verifica_id -> bindValue(":id", $unico);
                $verifica_id -> execute();
    
                $verifica_andamento = $conn -> prepare("SELECT ID_PEDIDO FROM tbl_pedidos WHERE ID_USUARIO = :id AND ST_PEDIDO IN (1,2,3) AND ST_RECUSA_PEDIDO <> 1");
                $verifica_andamento -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
                $verifica_andamento -> execute();
    
                if ($verifica_id -> rowCount() == 1) {
                do {
                    $unico = mt_rand(1, 2147483647);
                    $verifica_id = $conn -> prepare("SELECT ID_PEDIDO FROM tbl_pedidos WHERE ID_PEDIDO = :id");
                    $verifica_id -> bindValue(":id", $unico);
                    $verifica_id -> execute();
                } while ($verifica_id -> rowCount() == 1);
    
                } else if ($verifica_andamento -> rowCount() > 0) {
                    echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'Já existe um pedido em andamento, conclua o pedido antes de realizar outro.'});</script>");
                } else {
                    if($cep == "") {
                        $sql = $conn -> prepare("INSERT INTO tbl_pedidos (ID_PEDIDO, ID_USUARIO, DT_TRANSACAO_PEDIDO, ST_PEDIDO, NR_TIPO_ENTREGA_PEDIDO, VL_TOTAL_PEDIDO, DS_OBSERVACAO_PEDIDO, ID_LOJA, NR_CEP_PEDIDO, NM_CIDADE_PEDIDO, SG_UF_PEDIDO, NM_BAIRRO_PEDIDO, DS_LOGRADOURO_PEDIDO, DS_COMPLEMENTO_PEDIDO, ID_PAGAMENTO) VALUES (:id, :usuario, NOW(), 1, :entrega, :total, :observacao, :loja, :cep, :cidade, :estado, :bairro, :logradouro, :complemento, :pagamento);");
                        $sql -> bindValue(":id", $unico);
                        $sql -> bindValue(":usuario", $_SESSION["SSO_USUARIO_CARAMEL"]);
                        $sql -> bindValue(":entrega", $logistica);
                        $sql -> bindValue(":total", $total);
                        $sql -> bindValue(":observacao", $observacao);
                        $sql -> bindValue(":loja", $store["ID_LOJA"]);
                        $sql -> bindValue(":cep", $dados["NR_CEP_USUARIO"]);
                        $sql -> bindValue(":cidade", $dados["NM_CIDADE_USUARIO"]);
                        $sql -> bindValue(":estado", $dados["SG_UF_USUARIO"]);
                        $sql -> bindValue(":bairro", $dados["NM_BAIRRO_USUARIO"]);
                        $sql -> bindValue(":logradouro", $dados["DS_LOGRADOURO_USUARIO"]);
                        $sql -> bindValue(":complemento", $dados["DS_COMPLEMENTO_USUARIO"]);
                        $sql -> bindValue(":pagamento", $pagamento);
                        $sql -> execute();
    
                        while ($produto = $carrinho4 -> fetch()) {
                            $sql = $conn -> prepare("INSERT INTO tbl_produtos_pedidos (ID_PRODUTO, ID_PEDIDO, QT_PRODUTO_PEDIDO) VALUES (:produto, :pedido, :qtde);");
                            $sql -> bindValue(":produto", $produto["ID_PRODUTO"]);
                            $sql -> bindValue(":pedido", $unico);
                            $sql -> bindValue(":qtde", $produto["QT_CARRINHO"]);
                            $sql -> execute();
    
                            $sql = $conn -> prepare("DELETE FROM tbl_carrinho WHERE ID_CARRINHO = :id");
                            $sql -> bindValue(":id", $produto["ID_CARRINHO"]);
                            $sql -> execute();
                        };
                    } else {
                        $sql = $conn -> prepare("INSERT INTO tbl_pedidos (ID_PEDIDO, ID_USUARIO, DT_TRANSACAO_PEDIDO, ST_PEDIDO, NR_TIPO_ENTREGA_PEDIDO, VL_TOTAL_PEDIDO, DS_OBSERVACAO_PEDIDO, ID_LOJA, NR_CEP_PEDIDO, NM_CIDADE_PEDIDO, SG_UF_PEDIDO, NM_BAIRRO_PEDIDO, DS_LOGRADOURO_PEDIDO, DS_COMPLEMENTO_PEDIDO, ID_PAGAMENTO) VALUES (:id, :usuario, NOW(), 1, :entrega, :total, :observacao, :loja, :cep, :cidade, :estado, :bairro, :logradouro, :complemento, :pagamento);");
                        $sql -> bindValue(":id", $unico);
                        $sql -> bindValue(":usuario", $_SESSION["SSO_USUARIO_CARAMEL"]);
                        $sql -> bindValue(":entrega", $logistica);
                        $sql -> bindValue(":total", $total);
                        $sql -> bindValue(":observacao", $observacao);
                        $sql -> bindValue(":loja", $store["ID_LOJA"]);
                        $sql -> bindValue(":cep", $cep);
                        $sql -> bindValue(":cidade", $cidade);
                        $sql -> bindValue(":estado", $estado);
                        $sql -> bindValue(":bairro", $bairro);
                        $sql -> bindValue(":logradouro", $logradouro);
                        $sql -> bindValue(":complemento", $complemento);
                        $sql -> bindValue(":pagamento", $pagamento);
                        $sql -> execute();
    
                        while ($produto = $carrinho4 -> fetch()) {
                            $sql = $conn -> prepare("INSERT INTO tbl_produtos_pedidos (ID_PRODUTO, ID_PEDIDO, QT_PRODUTO_PEDIDO) VALUES (:produto, :pedido, :qtde);");
                            $sql -> bindValue(":produto", $produto["ID_PRODUTO"]);
                            $sql -> bindValue(":pedido", $unico);
                            $sql -> bindValue(":qtde", $produto["QT_CARRINHO"]);
                            $sql -> execute();
    
                            $sql = $conn -> prepare("DELETE FROM tbl_carrinho WHERE ID_CARRINHO = :id");
                            $sql -> bindValue(":id", $produto["ID_CARRINHO"]);
                            $sql -> execute();
                        };
                    };
                    echo("<script>window.location.replace('pedidos.php');</script>");
                };
            };
        };

        $carrinho2 = $conn -> prepare("SELECT tbl_carrinho.ID_CARRINHO, tbl_carrinho.ID_PRODUTO, tbl_carrinho.ID_LOJA, tbl_carrinho.QT_CARRINHO, tbl_produtos.DS_PRODUTO, tbl_carrinho.QT_CARRINHO, tbl_produtos.NM_PRODUTO, tbl_produtos.DS_CAMINHO_IMAGEM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO, tbl_medidas.DS_NOMENCLATURA_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.QT_UNIDADE_PRODUTO FROM tbl_carrinho, tbl_produtos, tbl_medidas WHERE ID_USUARIO = :id AND tbl_carrinho.ID_PRODUTO = tbl_produtos.ID_PRODUTO AND tbl_produtos.ID_MEDIDA = tbl_medidas.ID_MEDIDA");
        $carrinho2 -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
        $carrinho2 -> execute();
    ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div class="block" onclick="fecharLateral()"></div>
    <header class="cabeça">
        <div class="container">
            <div class="logotipo lgcheckout"><a href="index.php">Caramel</a></div>
        </div>
    </header>
    <main>
        <section class="checkout abfinal">
            <div class="container">
                <div class="esquerda">
                    <div class="dados">
                        <form method="POST" action="checkout.php" autocomplete="off">
                            <button type="button" class="btvoltar" onclick="window.history.back()"><svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M359-242 120-481l239-239 43 43-166 166h604v60H236l166 166-43 43Z"/></svg> Voltar</button>
                            <h1 class="heads">Finalize seu pedido</h1>
                            <fieldset class="endereco">
                                <h3>Endereço da entrega</h3>
                                    <img src="../images/endereco.jpg" alt="Mapa"/>
                                    <span class="local">
                                        <h4 id="place"><?php echo($dados["DS_LOGRADOURO_USUARIO"]); ?></h4>
                                        <h5 id="complement"><?php echo($dados["DS_COMPLEMENTO_USUARIO"]); ?> - <?php echo($dados["NM_CIDADE_USUARIO"]); ?>/<?php echo($dados["SG_UF_USUARIO"]); ?></h5>
                                    </span>
                                    <button type="button" class="acao" onclick="abrirModal('#mdendereco')">Mudar</button>
                                    <dialog id="mdendereco" onkeydown="removeBlur()">
                                        <div class="cabeca">
                                            <h1>Entrega</h1>
                                            <button class="mdfechar" type="button" onclick="fecharModal('#mdendereco');"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button>
                                        </div>
                                        <div class="conteudo">
                                            <label class="lblocal" for="cep">CEP</label>
                                            <input class="txti cep" id="cep" type="text" name="cep" onchange="consultarCEP()" placeholder="CEP"/>
                                            <div class="endsm"><label class="lblocal" for="cidade">Cidade</label>
                                            <input class="txti" id="cidade" type="text" name="cidade" placeholder="Cidade"/></div>
                                            <div class="endcm"><label class="lblocal" for="estado">Estado</label>
                                            <input class="txti" id="estado" type="text" name="estado" placeholder="UF"/></div>
                                            <div class="endsm"><label class="lblocal" for="bairro">Bairro</label>
                                            <input class="txti" id="bairro" type="text" name="bairro" placeholder="Bairro"/></div>
                                            <div class="endrcm"><label class="lblocal" for="logradouro">Logradouro</label>
                                            <input class="txti" id="logradouro" type="text" name="logradouro" placeholder="Logradouro"/></div>
                                            <div class="endrsm"><label class="lblocal" for="complemento">Complemento</label>
                                            <input class="txti" id="complemento" type="text" name="complemento" placeholder="Complemento"/></div>
                                            <button class="bta" type="button" onclick="fecharModal('#mdendereco'); exibeEndereco();" style="display: inline;">Alterar</button>
                                        </div>
                                    </dialog>
                            </fieldset>
                            <fieldset class="logistica">
                                <h3>Entrega</h3>
                                    <label for="log1">
                                        <div id="boxlog1" class="tipoent select">
                                            <p class="p1">Entrega</p><p class="p2"><?php echo($store["HR_TEMPO_ENTREGA_LOJA"]); ?> min</p>
                                            <p class="p3">R$ <?php echo($store["VL_TAXA_ENTREGA_LOJA"]); ?></p>
                                        </div>
                                    </label>
                                    <input id="log1" class="fantasma" onchange="logCheckout()" type="radio" name="logistica" value="1" checked/>
                                    
                                    <label for="log2">
                                        <div id="boxlog2" class="tipoent">
                                            <p class="p1">Retirada</p>
                                            <p class="p2">20 min</p>
                                            <p class="p3">Grátis</p>
                                        </div>
                                    </label>
                                    <input id="log2" class="fantasma" onchange="logCheckout()" type="radio" name="logistica" value="2"/>     
                            </fieldset>
                            <fieldset class="pagamentos">
                                <h3>Pagamento</h3>
                                <label for="pag1">
                                    <div id="boxpag1" class="pagto select">
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><defs/><g fill="#cacaca" fill-rule="evenodd"><path d="M112.57 391.19c20.056 0 38.928-7.808 53.12-22l76.693-76.692c5.385-5.404 14.765-5.384 20.15 0l76.989 76.989c14.191 14.172 33.045 21.98 53.12 21.98h15.098l-97.138 97.139c-30.326 30.344-79.505 30.344-109.85 0l-97.415-97.416h9.232zm280.068-271.294c-20.056 0-38.929 7.809-53.12 22l-76.97 76.99c-5.551 5.53-14.6 5.568-20.15-.02l-76.711-76.693c-14.192-14.191-33.046-21.999-53.12-21.999h-9.234l97.416-97.416c30.344-30.344 79.523-30.344 109.867 0l97.138 97.138h-15.116z"/><path d="M22.758 200.753l58.024-58.024h31.787c13.84 0 27.384 5.605 37.172 15.394l76.694 76.693c7.178 7.179 16.596 10.768 26.033 10.768 9.417 0 18.854-3.59 26.014-10.75l76.989-76.99c9.787-9.787 23.331-15.393 37.171-15.393h37.654l58.3 58.302c30.343 30.344 30.343 79.523 0 109.867l-58.3 58.303H392.64c-13.84 0-27.384-5.605-37.171-15.394l-76.97-76.99c-13.914-13.894-38.172-13.894-52.066.02l-76.694 76.674c-9.788 9.788-23.332 15.413-37.172 15.413H80.782L22.758 310.62c-30.344-30.345-30.344-79.524 0-109.868"/></g></svg>
                                        <p class="p1">Pagar com Pix</p>
                                        <p class="p2">Use o QR Code ou copie o código gerado</p>
                                    </div>
                                </label>
                                <input id="pag1" class="fantasma" onchange="pagCheckout()" type="radio" name="pagamento" value="4" checked/>        
    
                                <label for="pag2">
                                    <div id="boxpag2" class="pagto">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48"><path fill="#cacaca" d="M880 316v520q0 24-18 42t-42 18H140q-24 0-42-18t-18-42V316q0-24 18-42t42-18h680q24 0 42 18t18 42ZM140 425h680V316H140v109Zm0 129v282h680V554H140Zm0 282V316v520Z"/></svg>
                                        <p class="p1">Pagar com crédito</p>
                                        <p class="p2">Use o cartão de crédito para pagamento</p>
                                    </div>
                                </label>
                                <input id="pag2" class="fantasma" onchange="pagCheckout()" type="radio" name="pagamento" value="2"/>        
    
                                <label for="pag3">
                                    <div id="boxpag3" class="pagto">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48"><path fill="#cacaca" d="M880 316v520q0 24-18 42t-42 18H140q-24 0-42-18t-18-42V316q0-24 18-42t42-18h680q24 0 42 18t18 42ZM140 425h680V316H140v109Zm0 129v282h680V554H140Zm0 282V316v520Z"/></svg>
                                        <p class="p1">Pagar com débito</p>
                                        <p class="p2">Use o cartão de débito para pagamento</p>
                                    </div>
                                </label>
                                <input id="pag3" class="fantasma" onchange="pagCheckout()" type="radio" name="pagamento" value="3"/>        
                            
                                <label id="lbd" for="pag4" class="fantasma">
                                    <div id="boxpag4" class="pagto">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48"><path fill="#cacaca" d="M540 636q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM220 776q-24.75 0-42.375-17.625T160 716V316q0-24.75 17.625-42.375T220 256h640q24.75 0 42.375 17.625T920 316v400q0 24.75-17.625 42.375T860 776H220Zm100-60h440q0-42 29-71t71-29V416q-42 0-71-29t-29-71H320q0 42-29 71t-71 29v200q42 0 71 29t29 71Zm480 180H100q-24.75 0-42.375-17.625T40 836V376h60v460h700v60ZM220 716V316v400Z"/></svg>
                                        <p class="p1">Pagar com dinheiro</p>
                                        <p class="p2">Pague em dinheiro durante a retirada</p>
                                    </div>
                                </label>
                                <input id="pag4" class="fantasma" onchange="pagCheckout()" type="radio" name="pagamento" value="1"/>        
                            </fieldset>
                            <fieldset class="observacao">
                                <h3>Observações</h3>
                                <input class="txti" type="text" placeholder="Ex.: Colocar os petiscos separados da ração" name="observacao"/>
                            </fieldset>
                            <input type="submit" class="bta" name="pedir" value="Fazer pedido"/>
                        </form>
                    </div>
                </div>
                <div class="direita">
                    <div class="cartout">
                        <div class="conteudo sm">
                            <h4>Seu pedido em</h4>
                            <div class="titulo">
                                <h3><?php if ($carrinho2 -> rowCount() != 0) {echo($store["NM_LOJA"]);} ?></h3>
                                <a href="<?php if ($carrinho2 -> rowCount() != 0) {echo("petshop.php?id=".$store["ID_LOJA"]);} ?>">Ver opções</a>
                            </div>
                        <ul class="items">
                            <?php
                                $total = 0;
                                if ($carrinho2 -> rowCount() != 0) { 
                                    while ($produto = $carrinho2 -> fetch()) {
                                        echo("
                                            <li class='item'>
                                            <div class='cproduto'>      
                                            <p>".$produto["QT_CARRINHO"]."x ".$produto["NM_PRODUTO"]."</p>
                                                <h3>R$ ".$produto["QT_CARRINHO"] * $produto["VL_VENDA_PRODUTO"]."</h3>
                                            </div>
                                            </li>
                                        ");

                                        $total = $total + ($produto["VL_VENDA_PRODUTO"] * $produto["QT_CARRINHO"]);
                                    };
                                };
                            ?>
                        </ul>
                        <div class="item subtotais" style="border-bottom: none">
                            <span><p style="float: left">Subtotal</p><p style="float: right">R$ <?php echo($total) ?></p></span>
                            <span><p style="float: left">Taxa de entrega</p><p style="float: right">R$ <?php echo($store["VL_TAXA_ENTREGA_LOJA"]); ?></p></span>
                        </div>
                        </div>
                        <div class="totais tcheckout">
                            <span><h3 style="float: left">Total</h3><h3 style="float: right">R$ <?php echo($total + $store["VL_TAXA_ENTREGA_LOJA"]); ?></h3></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
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
    </main>
</body>
</html>