<?php
    include("../sources/config.php");
    $usuario = $_SESSION["SSO_LOJISTA_CARAMEL"];

    $consulta_cab = $conn -> prepare("SELECT tbl_lojistas.NM_LOJISTA, tbl_lojistas.ID_LOJA, tbl_lojas.NM_LOJA, tbl_lojas.DS_CAMINHO_IMAGEM_LOJA, tbl_lojas.ST_TURNO_LOJA FROM tbl_lojistas, tbl_lojas WHERE tbl_lojas.ID_LOJA = tbl_lojistas.ID_LOJA AND tbl_lojistas.ID_LOJISTA = :id");
    $consulta_cab -> bindValue(":id", $usuario);
    $consulta_cab -> execute();
    $dados_cabecalho = $consulta_cab -> fetch();
?>

<header>
        <div class="dash">
            <div class="hamburger" onclick="abrirSidebar()" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" width="32" height="32"><path d="M106.087 834.811v-89.26h748.92v89.26h-748.92Zm0-214.608v-89.261h748.92v89.261h-748.92Zm0-213.754v-89.42h748.92v89.42h-748.92Z" fill="#4e4e4e"/></svg></div>
            <div class="plogotipo"><a href="dashboard.php">Caramel</a></div>
            <div class="loja">
                <img src="<?php echo($dados_cabecalho["DS_CAMINHO_IMAGEM_LOJA"]) ?>" alt="Logotipo Petshop"/>
                <div class="txloja">
                    <h2><?php echo($dados_cabecalho["NM_LOJA"]) ?></h2>
                    <p><?php echo($dados_cabecalho["NM_LOJISTA"]) ?></p>
                </div>
            </div>
            <div class="btsdir">
                <ul class="buttons">
                    <li><a href="../logout.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" ><path d="M179.761 941.978q-27.698 0-48.034-20.265-20.336-20.266-20.336-47.865V278.152q0-27.697 20.336-48.033 20.336-20.337 48.034-20.337h292.674v68.37H179.761v595.696h292.674v68.13H179.761Zm486.478-182.369-48.978-48.5 101.043-101.044H371.891v-68.13h344.413L615.261 440.891l48.978-48.5L848.609 577l-182.37 182.609Z"/></svg></a></li>
                    <li><button type="button" onclick="abrirLateral('#avisos')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M190-200q-12.75 0-21.375-8.675-8.625-8.676-8.625-21.5 0-12.825 8.625-21.325T190-260h54v-306q0-82 49.5-148.5T424-798v-29q0-23 16.265-38 16.264-15 39.5-15Q503-880 519.5-865t16.5 38v29q81 17 131 83.5T717-566v306h53q12.75 0 21.375 8.675 8.625 8.676 8.625 21.5 0 12.825-8.625 21.325T770-200H190Zm290-295Zm0 415q-32 0-56-23.5T400-160h160q0 33-23.5 56.5T480-80ZM304-260h353v-306q0-75-50.5-126.5t-125-51.5q-74.5 0-126 51.5T304-566v306Z"/></svg></li>
                </ul>
                <div class="situacao">
                    <select id="funcionamento" onchange="abrirLoja();">
                        <option <?php if($dados_cabecalho["ST_TURNO_LOJA"] == 0){echo("selected");}; ?> class="dpdown" value="0">Fechada</option>
                        <option <?php if($dados_cabecalho["ST_TURNO_LOJA"] == 1){echo("selected");}; ?> class="dpdown" value="1">Aberta</option>
                     </select>
                </div>
            </div>
        </div>
</header>

<dialog id="mdloja" onkeydown="removeBlur()">
        <div class="cabeca">
            <h1 id="mljtit">Abertura da loja</h1>
            <button class="mdfechar" type="button" onclick="fecharModal('#mdloja'); cancelarTurno();"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button>
        </div>
        <div class="conteudo">
            <img src="../images/shop.png" alt="Loja"/>
            <p id="mljdesc">Deseja realizar a abertura de turno da loja? A loja ficará visível na busca da plataforma e clientes poderão comprar e visitar sua página</p>
            <form action="turno.php" method="POST"><input type="submit" class="bta rbtcontent" Value="Confirmar" name="turno"/></form>
            <button name="turno" type="button" class="btb rbtcontent" onclick="fecharModal('#mdloja'); cancelarTurno()">Cancelar</button>
        </div>
</dialog>