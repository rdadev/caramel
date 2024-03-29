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
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <main class="acessos">
        <section class="cadastro">
            <div class="container">
                <div class="containerzinho esquerda">
                    <div class="logotipo logo"><a href="../index.php">Caramel</a></div>
                    <h1>Seja um entregador</h1>
                    <p>Você pode começar hoje fazendo entregas para petshops pela plataforma, gerando renda extra</p>
                    <form class="formulario" action="conta.php" method="" autocomplete="off">
                        <fieldset>
                            <input class="entradas" type="text" placeholder="Nome completo"/>
                            <input class="entradas" type="text" maxlength="11" placeholder="CPF (somente números)"/>
                            <input class="entradas" type="email" placeholder="Seu melhor email"/>
                            <input class="entradas" type="password" minlength="8" placeholder="Crie uma senha"/>
                            <button class="prox botao" type="button">Próximo</button>
                            <span class="acao">Já é entregador parceiro? <a class="linkacao" href="login.php">Fazer login</a></span>    
                        </fieldset>
                        <fieldset>
                            <select class="entradas selections">
                                <option value="" selected>Veículo</option>
                                <option value="1">Moto</option>
                                <option value="3">Carro</option>
                                <option value="2">Bicicleta</option>
                            </select>
                            <input class="entradas" type="text" placeholder="Placa"/>
                            <input class="entradas" type="text" maxlength="11" placeholder="CNH (somente números)"/>
                            <input class="entradas" type="text" onfocus="(this.type='date')" placeholder="Primeira habilitação"/>
                            <input class="entradas" type="text" onfocus="(this.type='date')" placeholder="Vencimento"/>
                            <button class="prox botao smb" type="button">Próximo</button>
                        </fieldset>
                        <fieldset>
                            <div class="entraf">
                                <label class="lbs" for="imagem">CNH (Frente e verso)</label>
                                <input type="file" id="ipimg" accept="image/*" onchange="mostraImagem('imgresult', 'ipimg', true)"/>
                                <div class="arquivo" onclick="selecionaArquivo('ipimg')">
                                    <img id="imgresult" src="../images/blank.svg" alt="Selecione um arquivo"/>
                                </div>
                            </div>
                            <span class="termos"><p>Ao clicar em confirmar você concorda com a <a href="../privacidade/index.php" target="_blank">política de privacidade</a> e os <a href="../termos/index.php" target="_blank">termos</a> da plataforma</p></span>
                            <input class="botao smb" type="submit" value="Confirmar"/>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>