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
<body class="corpo">
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    
    <dialog id="confirmacao" class="avaliar" onkeydown="removeBlur()">
        <div class="cabeca">
            <h1>Confirmação</h1>
            <button class="mdfechar" type="button" onclick="fecharModal('#confirmacao')"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button>
        </div>
        <div class="conteudo">
            <p>Ir para <b>Avenida Opet, 865, Bloco A, Rebouças CEP 80230030.</b> Deseja confirmar o início de rota para o pedido selecionado?</p>
            <a class="bta" href="mapa.php">Confirmar</a>
        </div>
    </dialog>

    <main>
        <div class="logotipo logor"><a href="../index.php">Caramel</a></div>
        <div class="caixa">
            <div class="aviso">
                <img src="../images/celular.png" alt="Celular"/>
                <h1>Acesso via celular</h1>
                <p>O portal do entregador é exclusivo para acesso em celulares, acompanhe e gerencie entregas abrindo o portal no celular</p>
                <a href="../index.php">Início</a>
            </div>
        </div>
        <div class="portal">
            <header>
                <div class="container">
                    <h1>Rota atual</h1>
                    <a href="../index.php" class="saida"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" ><path d="M179.761 941.978q-27.698 0-48.034-20.265-20.336-20.266-20.336-47.865V278.152q0-27.697 20.336-48.033 20.336-20.337 48.034-20.337h292.674v68.37H179.761v595.696h292.674v68.13H179.761Zm486.478-182.369-48.978-48.5 101.043-101.044H371.891v-68.13h344.413L615.261 440.891l48.978-48.5L848.609 577l-182.37 182.609Z"/></svg></a>
                </div>
            </header>

            <section class="rotas sm">
                <div class="container">
                    <ul>
                        <li>
                            <div class="inteiro">
                                <h3>Petshop Mundopet</h3>
                                <p class="vlr">R$ 8,90</p>
                            </div>
                            <div class="inteiro">
                                <p class="km">5,2Km • 3 pedidos</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="enderecos">
                <div class="container">
                    <ul>
                        <li>
                            <div class="inteiro">
                                <h3>Avenida Opet, 865</h3>
                                <p class="ordenacao">#650120</p>
                            </div>
                            <div class="inteiro baixinho">
                                <p>Bloco A</p>
                            </div>
                            <button class="btl" onclick="abrirModal('#confirmacao')">Vou para lá</button>
                        </li>
                        <li>
                            <div class="inteiro">
                                <h3>Rua do Brasil, 10</h3>
                                <p class="ordenacao">#650128</p>
                            </div>
                            <div class="inteiro baixinho">
                                <p>Bloco B</p>
                            </div>
                            <button class="btl" onclick="abrirModal('#confirmacao')">Vou para lá</button>
                        </li>
                        <li>
                            <div class="inteiro">
                                <h3>Passarela Azul, 86</h3>
                                <p class="ordenacao">#650123</p>
                            </div>
                            <div class="inteiro baixinho">
                                <p>Apto 801</p>
                            </div>
                            <button class="btl" onclick="abrirModal('#confirmacao')">Vou para lá</button>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="mobnavs">
                <a href="dashboard.php"><div class="mobnav">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.152 873.848h143.783V621.935h228.13v251.913h143.783V486.957L480 293.63 222.152 487.036v386.812Zm-68.13 68.13V452.891L480 208.348l326.218 244.543v489.087H528.565V687.435h-97.13v254.543H154.022ZM480 583.239Z"/></svg>
                    <p>Home</p>
                </div></a>
                <a href="rotas.php"><div class="mobnav">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M355-120q-65 0-110-45.531T200-275v-349q-35-13-57.5-41.263-22.5-28.264-22.5-64.404Q120-776 152.5-808t78-32q45.5 0 77.5 32.138 32 32.139 32 78.051Q340-694 317.5-665.5 295-637 260-624v349q0 39.188 27.5 67.094Q315-180 355.5-180t67.5-27.906q27-27.906 27-67.094v-410q0-65 45-110t110-45q65 0 110 45t45 110v349q35 13 57.5 41.365Q840-266.27 840-230q0 45-32.083 77.5Q775.833-120 730-120q-45 0-77.5-32.5T620-230q0-36.297 22.5-65.148Q665-324 700-336v-349q0-40-27.5-67.5T605-780q-40 0-67.5 27.5T510-685v410q0 63.938-45 109.469Q420-120 355-120ZM230.5-680q20.5 0 35-15t14.5-35.5q0-20.5-14.375-35T230-780q-20 0-35 14.375T180-730q0 20 15 35t35.5 15Zm500 500q20.5 0 35-15t14.5-35.5q0-20.5-14.375-35T730-280q-20 0-35 14.375T680-230q0 20 15 35t35.5 15ZM230-730Zm500 500Z"/></svg>
                    <p>Rotas</p>
                </div></a>
                <a href="../suporte/index.php" target="_blank"><div class="mobnav">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M484-247q16 0 27-11t11-27q0-16-11-27t-27-11q-16 0-27 11t-11 27q0 16 11 27t27 11Zm-35-146h59q0-26 6.5-47.5T555-490q31-26 44-51t13-55q0-53-34.5-85T486-713q-49 0-86.5 24.5T345-621l53 20q11-28 33-43.5t52-15.5q34 0 55 18.5t21 47.5q0 22-13 41.5T508-512q-30 26-44.5 51.5T449-393Zm31 313q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-156t86-127Q252-817 325-848.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 82-31.5 155T763-197.5q-54 54.5-127 86T480-80Zm0-60q142 0 241-99.5T820-480q0-142-99-241t-241-99q-141 0-240.5 99T140-480q0 141 99.5 240.5T480-140Zm0-340Z"/></svg>
                    <p>Ajuda</p>
                </div></a>
                <a href="conta.php"><div class="mobnav">
                    <svg xmlns="http://www.w3.org/2000/svg"viewBox="0 96 960 960"><path d="M222.957 798.37q62.76-43.522 124.521-66.783 61.761-23.261 132.626-23.261 70.865 0 133.242 23.445 62.376 23.444 124.697 66.599 43.522-54.24 61.663-108.153Q817.848 636.303 817.848 576q0-143.863-96.98-240.856-96.98-96.992-240.826-96.992t-240.868 96.992Q142.152 432.137 142.152 576q0 60.283 18.528 114.139 18.529 53.856 62.277 108.231Zm256.857-190.696q-58.569 0-98.409-40.045-39.84-40.044-39.84-98.456 0-58.412 40.026-98.39 40.026-39.979 98.595-39.979 58.569 0 98.409 40.165 39.84 40.164 39.84 98.576 0 58.412-40.026 98.27-40.026 39.859-98.595 39.859Zm.514 374.304q-83.524 0-157.573-31.928t-129.46-87.333q-55.41-55.406-87.342-129.234-31.931-73.828-31.931-157.769 0-83.671 31.978-157.366 31.978-73.696 87.315-129.033 55.337-55.337 129.177-87.435 73.839-32.098 157.794-32.098 83.671 0 157.366 32.098 73.696 32.098 129.033 87.435 55.337 55.337 87.435 129.085 32.098 73.747 32.098 157.272 0 83.524-32.098 157.6t-87.435 129.413Q711.348 918.022 637.6 950q-73.747 31.978-157.272 31.978Zm-.328-68.13q54.283 0 105.587-15.522t102.304-54.804q-51.239-35.761-102.804-54.163Q533.522 770.957 480 770.957q-53.522 0-104.967 18.402-51.446 18.402-102.685 54.163 51 39.282 102.185 54.804Q425.717 913.848 480 913.848Zm0-369.044q33.251 0 54.408-21.021 21.157-21.022 21.157-54.424t-21.157-54.544Q513.251 393.674 480 393.674q-33.251 0-54.408 21.141-21.157 21.142-21.157 54.544t21.157 54.424q21.157 21.021 54.408 21.021Zm0-75.565Zm.239 373.283Z"/></svg>
                    <p>Conta</p>
                </div></a>
            </section>
        </div>
    </main>
</body>
</html>