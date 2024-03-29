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
    <script defer type="text/javascript" src="../sources/script.js"></script>
    <title>Caramel</title>
</head>
<body>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div id="blockpage" class="block" onclick="fecharMenuMobile()"></div>
    <header id="cabecalho">
        <div id="box" class="container">
            <div class="hamburger" onclick="abrirMenuMobile()" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" width="34px" height="34px"><path d="M106.087 834.811v-89.26h748.92v89.26h-748.92Zm0-214.608v-89.261h748.92v89.261h-748.92Zm0-213.754v-89.42h748.92v89.42h-748.92Z" fill="#4e4e4e"/></svg></div>
            <div class="logotipo"><a href="../index.php">Caramel</a></div>
            <nav id="menus" class="navegacao">
                <div id="fechar" class="esconder" onclick="fecharMenuMobile()">Fechar</div>
                <ul id="lista" class="menu">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../lojista/login.php">Lojistas</a></li>
                    <li><a href="../entregador/login.php">Entregadores</a></li>
                    <li><a href="../suporte/index.php">Suporte</a></li>
                    <li><a href="../sobre/index.php">Sobre</a></li>
                </ul>
                <ul id="acoes" class="botoes">
                    <li class="principal"><a href="../usuario/login.php">Entrar</a></li>
                    <li class="secundario"><a href="../usuario/cadastro.php">Cadastrar</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="conteudo">
            <div class="container">
                <h3 class="caminho"><a href="../index.php">Home</a> > <a href="index.php">Suporte</a> > <a href="entregadores.php">Entregadores</a></h3>
                <h2>Entregadores</h2>

                <button class="acordeon">Tópico de ajuda</button>
                <div class="painel">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.</p>
                </div>
                <button class="acordeon">Tópico de ajuda</button>
                <div class="painel">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.</p>
                </div>
                <button class="acordeon">Tópico de ajuda</button>
                <div class="painel">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.</p>
                </div>
                <button class="acordeon">Tópico de ajuda</button>
                <div class="painel">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.</p>
                </div>
                <button class="acordeon">Tópico de ajuda</button>
                <div class="painel">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dolores libero provident accusamus voluptatibus iste culpa. Voluptatibus fugiat eveniet natus sequi illo odit pariatur quas, eum ullam amet hic sapiente.</p>
                </div>
            </div>
        </section>
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