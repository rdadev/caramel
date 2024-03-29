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
        <section class="titulo"><h1>Podemos ajudar?</h1></section>
        <section class="conteudo">
            <div class="container">
                <h2>Categorias</h2>
                <div class="secoes">
                    <a class="secao esquerda" href="pedidos.php"><div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path class="icone" d="m450-360 200-129-200-129v258ZM100-80q-24 0-42-18t-18-42v-459h60v459h609v60H100Zm120-120q-24 0-42-18t-18-42v-518h242v-82q0-24 18-42t42-18h156q24 0 42 18t18 42v82h242v518q0 24-18 42t-42 18H220Zm0-60h640v-458H220v458Zm242-518h156v-82H462v82ZM220-260v-458 458Z"/></svg>
                        <h3 class="titulo-botao">Pedidos</h3>
                        <p>Soluções relacionadas aos pedidos</p>
                    </div></a>
                    <a class="secao direita" href="pagamentos.php"><div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path class="icone" d="M880-740v520q0 24-18 42t-42 18H140q-24 0-42-18t-18-42v-520q0-24 18-42t42-18h680q24 0 42 18t18 42ZM140-631h680v-109H140v109Zm0 129v282h680v-282H140Zm0 282v-520 520Z"/></svg>
                        <h3 class="titulo-botao">Pagamento</h3>
                        <p>Soluções relacionadas ao checkout</p>
                    </div></a> 
                    <a class="secao esquerda" href="conta.php"><div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path class="icone" d="M222.957 798.37q62.76-43.522 124.521-66.783 61.761-23.261 132.626-23.261 70.865 0 133.242 23.445 62.376 23.444 124.697 66.599 43.522-54.24 61.663-108.153Q817.848 636.303 817.848 576q0-143.863-96.98-240.856-96.98-96.992-240.826-96.992t-240.868 96.992Q142.152 432.137 142.152 576q0 60.283 18.528 114.139 18.529 53.856 62.277 108.231Zm256.857-190.696q-58.569 0-98.409-40.045-39.84-40.044-39.84-98.456 0-58.412 40.026-98.39 40.026-39.979 98.595-39.979 58.569 0 98.409 40.165 39.84 40.164 39.84 98.576 0 58.412-40.026 98.27-40.026 39.859-98.595 39.859Zm.514 374.304q-83.524 0-157.573-31.928t-129.46-87.333q-55.41-55.406-87.342-129.234-31.931-73.828-31.931-157.769 0-83.671 31.978-157.366 31.978-73.696 87.315-129.033 55.337-55.337 129.177-87.435 73.839-32.098 157.794-32.098 83.671 0 157.366 32.098 73.696 32.098 129.033 87.435 55.337 55.337 87.435 129.085 32.098 73.747 32.098 157.272 0 83.524-32.098 157.6t-87.435 129.413Q711.348 918.022 637.6 950q-73.747 31.978-157.272 31.978Zm-.328-68.13q54.283 0 105.587-15.522t102.304-54.804q-51.239-35.761-102.804-54.163Q533.522 770.957 480 770.957q-53.522 0-104.967 18.402-51.446 18.402-102.685 54.163 51 39.282 102.185 54.804Q425.717 913.848 480 913.848Zm0-369.044q33.251 0 54.408-21.021 21.157-21.022 21.157-54.424t-21.157-54.544Q513.251 393.674 480 393.674q-33.251 0-54.408 21.141-21.157 21.142-21.157 54.544t21.157 54.424q21.157 21.021 54.408 21.021Zm0-75.565Zm.239 373.283Z"/></svg>
                        <h3 class="titulo-botao">Conta</h3>
                        <p>Soluções relacionadas ao login e a conta</p>
                    </div></a>
                    <a class="secao direita" href="politicas.php"><div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path class="icone" d="M222.957 987q-47.377 0-80.374-32.996-32.996-32.997-32.996-80.486V742.652h129.869V171.935l61.235 60.956 60.996-60.956 60.756 60.956 61.235-60.956 60.757 60.956 61.195-60.956 60.957 60.956 61.196-60.956 60.956 60.956 61.674-60.956V873.63q0 47.377-33.066 80.374Q784.281 987 737.043 987H222.957Zm514.206-68.37q19.88 0 32.38-12.513 12.5-12.514 12.5-32.534V281.022H307.587v461.63h384.456V873.63q0 20 12.62 32.5t32.5 12.5ZM360.587 440.457v-60h235.456v60H360.587Zm0 134v-60h235.456v60H360.587Zm328.456-134q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9Zm0 129q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9ZM221.957 918.63h401.956V811.022H177.957v62.608q0 20 12.65 32.5t31.35 12.5Zm-44 0V811.022 918.63Z"/></svg>
                        <h3 class="titulo-botao">Políticas</h3>
                        <p>Nossos termos e políticas</p>
                    </div></a>
                    <a class="secao esquerda" href="entregadores.php"><div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path class="icone" d="M158.435 857.435q-65.718 0-112.076-45.978Q0 765.478 0 699q0-65.761 44.902-111.261t109.424-46.217l-44.369-34.087H0v-55.5h182.674l99 62.391 158.522-59.761h134.739l-75.848-97.13H412v-62.87h118.761l85.761 110.761L746 340.848v107.587h-96.565l82.608 106.891q16.761-6.522 33.642-10.141 16.88-3.62 34.88-3.62 66.478 0 112.957 45.978Q960 633.522 960 700t-46.478 111.957q-46.479 45.478-112.957 45.478-65.717 0-111.456-45.859Q643.37 765.717 643.37 700q0-30 9.88-57.12 9.88-27.119 29.641-48.88l-33.326-42.848-145.043 222.283H395.957L316.63 701.63q-.956 65.761-46.695 110.783-45.739 45.022-111.5 45.022Zm0-62.87q40.282 0 67.924-28.022Q254 738.522 254 699q0-39.522-27.641-67.543-27.642-28.022-67.924-28.022-39.522 0-67.663 27.641Q62.63 658.717 62.63 699q0 40.283 28.142 67.924 28.141 27.641 67.663 27.641Zm294.239-277.13-170.609 64.043 170.609-64.043h144.5-144.5Zm347.891 277.13q40.283 0 68.544-27.522Q897.37 739.522 897.37 700q0-40.283-28.261-68.424-28.261-28.141-68.544-28.141-39.522 0-67.043 28.141Q706 659.717 706 700q0 39.522 27.522 67.043 27.521 27.522 67.043 27.522Zm-329.717-84 126.326-193.13h-144.5l-170.609 64.043 136.848 129.087h51.935Z"/></svg>
                        <h3 class="titulo-botao">Entregadores</h3>
                        <p>Soluções relacionadas a plataforma de entregadores</p>
                    </div></a>
                    <a class="secao direita" href="lojistas.php"><div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path class="icone" d="M846.935 537.957V876q0 27.599-20.336 47.865-20.336 20.266-48.034 20.266h-598.13q-27.599 0-47.865-20.266-20.266-20.266-20.266-47.865V538.913q-28.478-25.435-36.76-61.405-8.283-35.97 2.717-71.182l43-135q8.717-28.913 30.152-45.228 21.435-16.316 49.587-16.316h553q29.86 0 52.56 16.816 22.701 16.815 31.179 44.728l44 135q11 35 1.979 70.717-9.022 35.718-36.783 60.914ZM570 503.848q27.917 0 47.383-18.163 19.465-18.163 15.465-44.446l-24.761-163.087h-95.935V441q0 25.333 16.372 44.09 16.373 18.758 41.476 18.758Zm-187.112 0q26.932 0 45.946-18.258 19.014-18.257 19.014-44.59V278.152h-95.935l-24.761 163.087q-3.761 25.044 13.283 43.826 17.043 18.783 42.453 18.783Zm-181.832 0q23.227 0 40.129-16.142 16.902-16.141 19.663-39.184l25.761-170.37h-95.935l-45.522 144.326q-9.761 30.573 7.522 55.971 17.283 25.399 48.382 25.399Zm556.944 0q31.043 0 48.826-24.924t8.022-56.446l-45.522-144.326H673.63l25.522 170.37q2.761 23.043 19.639 39.184Q735.67 503.848 758 503.848ZM180.435 876h598.13V571.218q1.718.76-5.663.76h-14.935q-23.771 0-46.51-10.021-22.74-10.022-45.457-31.305-16.239 19.283-40.295 30.305-24.055 11.021-52.64 11.021-29.587 0-51.206-8.141-21.62-8.141-41.859-27.185-15.413 17.27-38.326 26.298-22.913 9.028-51.661 9.028-30.535 0-54.568-10.528-24.033-10.528-41.445-30.798-24.717 20.522-48.196 30.924-23.478 10.402-44.804 10.402h-12.783q-6.021 0-7.782-.76V876Zm598.13 0h-598.13 598.13Z"/></svg>
                        <h3 class="titulo-botao">Lojistas</h3>
                        <p>Soluções relacionadas a plataforma de lojistas</p>
                    </div></a> 
                </div>
            </div>
        </section>
        <section class="conteudo">
            <div class="container">
                <h2>Mensagem</h2>
                <form method="" action="index.php">
                    <fieldset>
                        <input type="text" class="txti esqinput" placeholder="Nome"/>
                        <input type="text" class="txti dirinput" placeholder="Email"/>
                    </fieldset>
                    <textarea id="editor" class="edicao"></textarea>
                    <input type="submit" value="Enviar" class="bta"/>
                </form>
                
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
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
        .create( document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
    </script>
</body>
</html>