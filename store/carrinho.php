<?php
    if(!isset($_SESSION["SSO_USUARIO_CARAMEL"])){
        header("location: ../usuario/login.php");
    };

    include("../sources/config.php");
    $carrinho = $conn -> prepare("SELECT tbl_carrinho.ID_CARRINHO, tbl_carrinho.ID_LOJA, tbl_lojas.VL_TAXA_ENTREGA_LOJA, tbl_lojas.NM_LOJA FROM tbl_carrinho, tbl_lojas WHERE tbl_carrinho.ID_USUARIO = :id AND tbl_carrinho.ID_LOJA = tbl_lojas.ID_LOJA");
    $carrinho -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
    $carrinho -> execute();
    $store = $carrinho -> fetch();

    $carrinho2 = $conn -> prepare("SELECT tbl_carrinho.ID_CARRINHO, tbl_carrinho.ID_PRODUTO, tbl_carrinho.ID_LOJA, tbl_carrinho.QT_CARRINHO, tbl_produtos.DS_PRODUTO, tbl_carrinho.QT_CARRINHO, tbl_produtos.NM_PRODUTO, tbl_produtos.DS_CAMINHO_IMAGEM_PRODUTO, tbl_produtos.VL_VENDA_PRODUTO, tbl_medidas.DS_NOMENCLATURA_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.QT_UNIDADE_PRODUTO FROM tbl_carrinho, tbl_produtos, tbl_medidas WHERE ID_USUARIO = :id AND tbl_carrinho.ID_PRODUTO = tbl_produtos.ID_PRODUTO AND tbl_produtos.ID_MEDIDA = tbl_medidas.ID_MEDIDA");
    $carrinho2 -> bindValue(":id", $_SESSION["SSO_USUARIO_CARAMEL"]);
    $carrinho2 -> execute();
?>

<section id="carrinho" class="lateral">
        <div class="fechar"><span>Meu carrinho</span><button type="button" onclick="fecharLateral()"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button></div>
        <div class="conteudo comfundo <?php if ($carrinho2 -> rowCount() == 0) {echo("hidden"); } ?>">
            <h4>Seu pedido em</h4>
            <div class="titulo">
                <h3><?php if ($carrinho2 -> rowCount() != 0) {echo($store["NM_LOJA"]);} ?></h3>
                <a href="<?php if ($carrinho2 -> rowCount() != 0) {echo("petshop.php?id=".$store["ID_LOJA"]);} ?>">Ver opções</a>
            </div>
            <ul>
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
                                <button type='button' class='acoes' style='color: var(--principal)' onclick='abrirModal(\"#edit".$produto["ID_PRODUTO"]."\")'>Editar</button>
                                <dialog id='edit".$produto["ID_PRODUTO"]."' class='mdproduto' onkeydown='removeBlur()'>
                                    <div class='cabeca'>
                                        <h1>Produto</h1>
                                        <button class='mdfechar' type='button' onclick='fecharModal(\"#edit".$produto["ID_PRODUTO"]."\")'><svg xmlns='http://www.w3.org/2000/svg' height='28' viewBox='0 96 960 960' width='28'><path d='m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z'/></svg></button>
                                    </div>
                                    <div class='conteudo'>
                                        <div class='esquerda'>
                                            <img src='".$produto["DS_CAMINHO_IMAGEM_PRODUTO"]."' alt='Produto'/>
                                        </div>
                                        <div class='direita'>
                                            <div class='mdsc'>
                                                <h4>".$produto["NM_PRODUTO"]."</h4>
                                                <p class='descricao'>".$produto["DS_PRODUTO"]."</p>
                                                <p class='peso'>".$produto["DS_NOMENCLATURA_MEDIDA"]." ".$produto["QT_UNIDADE_PRODUTO"]." ".$produto["SG_MEDIDA"]."</p>
                                                <p class='local'>Vendido por <b>".$store["NM_LOJA"]."</b></p>
                                                <p class='preco'>R$ ".$produto["VL_VENDA_PRODUTO"]."</p>
                                            </div>
                                            <div class='botoes'>
                                            <form action='cart.php' method='POST'>
                                            <input name='pg' class='hidden' type='text' value='1'/>
                                                <input name='id' type='text' class='hidden' value='".$produto["ID_CARRINHO"]."'/>
                                                <div class='quantidade'>
                                                    <button type='button' onclick=\"rmQuantProduto('#edt".$produto["ID_PRODUTO"]."')\">-</button>
                                                    <input name='quantidade' id='edt".$produto["ID_PRODUTO"]."' type='text' value='".$produto["QT_CARRINHO"]."' readonly/>
                                                    <button type='button' onclick=\"adQuantProduto('#edt".$produto["ID_PRODUTO"]."')\">+</button>
                                                </div>
                                                <input name='editar_carrinho' type='submit' class='bta' value='Salvar edição'/>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </dialog>
                
                                <form action='cart.php' method='POST'>
                                    <input name='id' type='text' class='hidden' value='".$produto["ID_CARRINHO"]."'/>
                                    <input type='submit' class='acoes' name='remover_produto' value='Remover'/>
                                </form>
                                
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
        <div id="total" class="fundo totais <?php if ($carrinho2 -> rowCount() == 0) {echo("hidden"); } ?>">
            <span><h3 style="float: left">Total</h3><h3 style="float: right">R$ <?php echo($total + $store["VL_TAXA_ENTREGA_LOJA"]); ?></h3></span>
            <a href="checkout.php" class="bta">Finalizar pedido</a>
        </div>
    </section>