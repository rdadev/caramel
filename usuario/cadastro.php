<?php
    session_start();
        if(isset($_SESSION["SSO_USUARIO_CARAMEL"])){
        header("location: ../store/index.php");
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
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <script type="text/javascript" src="../sources/masks.js"></script>
    <title>Caramel</title>
</head>
<body class="cadastramento">
    <?php
        include("../sources/config.php");

        if(isset($_POST["cadastrar"])) {
            $cpf1 = str_replace("-", "",$_POST["cpf"]);
            $cpf = str_replace(".", "",$cpf1);

            $nome = strtoupper($_POST["nome"]);
            $email = strtolower($_POST["email"]);
            $senha = md5($_POST["senha"]);
            $cep = str_replace("-", "",$_POST["cep"]);
            $cidade = $_POST["cidade"];
            $estado = $_POST["estado"];
            $bairro = $_POST["bairro"];
            $logradouro = $_POST["logradouro"];
            $complemento = $_POST["complemento"];
            $rand = mt_rand(1, 999999);
            $codigo = str_pad($rand, 6, 0, STR_PAD_LEFT);

            if ($nome == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo nome encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($senha == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo senha encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cep == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo CEP encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cidade == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo cidade encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($estado == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo estado encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($bairro == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo bairro encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($logradouro == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo logradouro encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cpf == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo CPF encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                $verifica_cpf = $conn -> prepare("SELECT NR_CPF_USUARIO FROM tbl_usuarios WHERE NR_CPF_USUARIO = :cpf");
                $verifica_cpf -> bindValue(":cpf", $cpf);
                $verifica_cpf -> execute();

                $verifica_email = $conn -> prepare("SELECT DS_EMAIL_USUARIO FROM tbl_usuarios WHERE DS_EMAIL_USUARIO = :email");
                $verifica_email -> bindValue(":email", $email);
                $verifica_email -> execute();

                if ($verifica_cpf -> rowCount() == 1) { 
                    echo("<script>Swal.fire({icon: 'error', title: 'Usuário já existente', text: 'Já existe uma conta cadastrada com o CPF informado. Por favor, tente novamente.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                } else if ($verifica_email -> rowCount() == 1) {
                    echo("<script>Swal.fire({icon: 'error', title: 'Usuário já existente', text: 'Já existe uma conta cadastrada com o e-mail informado, tente com outra conta de e-mail.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                } else {
                    $cadastro = $conn -> prepare("INSERT INTO tbl_usuarios (NM_USUARIO, DS_SENHA_USUARIO, NR_CPF_USUARIO, DS_EMAIL_USUARIO, NR_TELEFONE_USUARIO, ST_CONFIRMACAO_USUARIO, NR_CONFIRMACAO_USUARIO, NR_CEP_USUARIO, NM_CIDADE_USUARIO, SG_UF_USUARIO, NM_BAIRRO_USUARIO, DS_LOGRADOURO_USUARIO, DS_COMPLEMENTO_USUARIO) VALUES (:nome, :senha, :cpf, :email, NULL, 0, :codigo, :cep, :cidade, :estado, :bairro, :logradouro, :complemento);");
                    $cadastro -> bindValue(":nome", $nome);
                    $cadastro -> bindValue(":senha", $senha);
                    $cadastro -> bindValue(":cpf", $cpf);
                    $cadastro -> bindValue(":email", $email);
                    $cadastro -> bindValue(":cep", $cep);
                    $cadastro -> bindValue(":cidade", $cidade);
                    $cadastro -> bindValue(":estado", $estado);
                    $cadastro -> bindValue(":bairro", $bairro);
                    $cadastro -> bindValue(":logradouro", $logradouro);
                    $cadastro -> bindValue(":complemento", $complemento);
                    $cadastro -> bindValue(":codigo", $codigo);
                    $cadastro -> execute();

                    $subject = "Bem-vindo(a) ao Caramel, ative sua conta agora mesmo!";
                    $message = "
                        Olá, ".$nome."!
                        <br/>
                        Recebemos sua solicitação de cadastro, agora é preciso um passo essencial, ativar sua conta. Para isso, existe abaixo um código de confirmação que você pode inserir na <a href='https://caramel.app.br/usuario/confirmacao.php'>página de confirmação</a> ou clicando no link abaixo para confirmar automaticamente.
                        <br/><br/>
                        Código: <b>".$codigo."</b>
                        <br/>
                        Link de confirmação: <a href='https://caramel.app.br/usuario/confirmacao.php?email=".$email."&codigo=".$codigo."'>https://caramel.app.br/usuario/confirmacao.php?email=".$email."&codigo=".$codigo."</a>
                        <br/><br/>
                        --
                        <br/>
                        Atenciosamente,
                        <br/>
                        Equipe Caramel.
                    ";
                    $headers = "MIME-Version: 1.1\r\n";
                    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                    $headers .= 'From: Caramel <info@caramel.com.br>';
                    mail($email, $subject, $message, $headers);

                    echo ("<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Cadastro realizado',
                        text: 'Seus dados foram salvos com sucesso, verifique sua caixa de entrada para confirmar sua conta.',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        denyButtonText: `Don't save`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace('confirmacao.php?email=".$email."');
                        };
                    })
                    </script>");
                };
            };
        }; 
    ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <main class="acessos">
        <section class="cadastro">
            <div class="container">
                <div class="containerzinho esquerda">
                    <div class="logotipo logo"><a href="../index.php">Caramel</a></div>
                    <h1>Cadastre-se como usuário</h1>
                    <p>Uma nova experiência em petshops, obtenha descontos exclusivos</p>
                    <form class="formulario" action="cadastro.php" method="POST" autocomplete="off">
                        <fieldset>
                            <input class="entradas" type="text" placeholder="Nome completo" name="nome" required/>
                            <input class="entradas" id="cpf" type="text" placeholder="CPF (somente números)" name="cpf" required/>
                            <input class="entradas" type="email" placeholder="Seu melhor email" name="email" required/>
                            <input class="entradas" type="password" minlength="8" placeholder="Crie uma senha" name="senha" required maxlenght="65"/>
                            <button class="prox botao" type="button">Próximo</button>
                            <span class="acao">Já possui uma conta? <a class="linkacao" href="login.php">Fazer login</a></span>
                        </fieldset>
                        <fieldset>
                            <input id="cep" onchange="consultarCEP();" class="entradas" type="text" placeholder="CEP" name="cep" minlenght="8" maxlength="8" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required/>
                            <input id="cidade" class="entradas" type="text" placeholder="Cidade" name="cidade" required/>
                            <input id="estado" class="entradas" type="text" placeholder="Estado" name="estado" required maxlenght="2"/>
                            <input id="bairro" class="entradas" type="text" placeholder="Bairro" name="bairro" required/>
                            <input id="logradouro" class="entradas" type="text" placeholder="Logradouro" name="logradouro" required/>
                            <input id="complemento" class="entradas" type="text" placeholder="Complemento" name="complemento"/>
                            <span class="termos"><p>Ao clicar em confirmar você concorda com a <a href="../privacidade/index.php" target="_blank">política de privacidade</a> e os <a href="../termos/index.php" target="_blank">termos</a> da plataforma</p></span>
                            <input class="botao smb" type="submit" value="Confirmar" name="cadastrar"/>
                        </fieldset>
                    </form>
                    <script type="text/javascript"> 
                        $("#telefone").mask("(00) 00000-0000");
                        $("#cep").mask("00000-000");
                        $('#cpf').mask('000.000.000-00', {reverse: true});
                    </script>
                </div>
            </div>
        </section>
    </main>
</body>
</html>