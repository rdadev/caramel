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
        include ("../sources/config.php");
        if(isset($_GET['search'])) {
            $termo = $_GET['search'];

            $produtos = $conn -> prepare("SELECT tbl_produtos.ID_PRODUTO, tbl_produtos.ID_LOJA, tbl_produtos.DS_CAMINHO_IMAGEM_PRODUTO, tbl_produtos.NM_PRODUTO, tbl_produtos.DS_PRODUTO, tbl_lojas.NM_LOJA, tbl_produtos.VL_VENDA_PRODUTO, tbl_medidas.DS_NOMENCLATURA_MEDIDA, tbl_medidas.SG_MEDIDA, tbl_produtos.QT_UNIDADE_PRODUTO FROM tbl_produtos, tbl_lojas, tbl_medidas WHERE ST_ATIVIDADE_PRODUTO = 1 AND tbl_lojas.ID_LOJA = tbl_produtos.ID_LOJA AND tbl_medidas.ID_MEDIDA = tbl_produtos.ID_MEDIDA AND tbl_produtos.NM_PRODUTO LIKE :produto ORDER BY RAND()");
            $produtos -> bindValue(":produto", "%".$termo."%");
            $produtos -> execute();
        } else {
            echo("<script>window.location.replace('index.php');</script>");
        };
    ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div class="block" onclick="fecharLateral()"></div>
    <?php include("../usuario/header.php"); ?>
    <main>
    <section>
        <div class="container">
            <h1>Resultado da busca por: <?php echo($termo) ?></h1>
            <div class="produtos">
                <?php
                    if($produtos -> rowCount() != 0){  
                        while($produto = $produtos -> fetch()){ 
                            echo ("
                            <div class='produto' onclick=\"abrirModal('#prd".$produto["ID_PRODUTO"]."')\">
                            <div class='imagem'><img src='".$produto["DS_CAMINHO_IMAGEM_PRODUTO"]."' alt='Produto'/></div>
                            <div class='descritivo'>
                                <h4>".$produto["NM_PRODUTO"]."</h4>
                                <p class='descricao'>".$produto["DS_PRODUTO"]."</p>
                                <p class='peso'>".$produto["DS_NOMENCLATURA_MEDIDA"]." ".$produto["QT_UNIDADE_PRODUTO"]." ".$produto["SG_MEDIDA"]."</p>
                                <p class='local'>Vendido por <b>".$produto["NM_LOJA"]."</b></p>
                                <p class='preco'>R$ ".$produto["VL_VENDA_PRODUTO"]."</p>
                            </div>
                        </div>
                        <dialog id='prd".$produto["ID_PRODUTO"]."' class='mdproduto' onkeydown='removeBlur()'>
                            <div class='cabeca'>
                                <h1>Produto</h1>
                                <button class='mdfechar' type='button' onclick=\"fecharModal('#prd".$produto["ID_PRODUTO"]."')\"><svg xmlns='http://www.w3.org/2000/svg' height='28' viewBox='0 96 960 960' width='28'><path d='m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z'/></svg></button>
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
                                        <p class='local'>Vendido por <b>".$produto["NM_LOJA"]."</b></p>
                                        <p class='preco'>R$ ".$produto["VL_VENDA_PRODUTO"]."</p>
                                    </div>
                                    <div class='botoes'>
                                        <form action='cart.php' method='POST'>
                                        <input name='pg' class='hidden' type='text' value='1'/>
                                        <input name='id_petshop' type='text' class='hidden' value='".$produto["ID_LOJA"]."'/>
                                            <input name='id_produto' type='text' class='hidden' value='".$produto["ID_PRODUTO"]."'/>
                                            <div class='quantidade'>
                                                <button type='button' onclick=\"rmQuantProduto('#prq".$produto["ID_PRODUTO"]."')\">-</button>
                                                <input name='quantidade' id='prq".$produto["ID_PRODUTO"]."' type='text' value='1' readonly/>
                                                <button type='button' onclick=\"adQuantProduto('#prq".$produto["ID_PRODUTO"]."')\">+</button>
                                            </div>
                                            <input name='adicionar_carrinho' type='submit' class='bta' value='Adicionar ao carrinho'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </dialog>
                            ");
                        };
                    };
                ?>
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