<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/icon" href="../images/icon.ico"/>
    <link rel="stylesheet" type="text/css" href="../sources/global.css"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body class="entrada">
    <?php
        include("../sources/config.php");

        if(isset($_POST["confirmar"])) {
            $codigo = $_POST["codigo"];
            $email = $_POST["email"];
            $senha = md5($_POST["senha"]);

            if ($codigo == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo código encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($senha == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo senha encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                $confirmacao = $conn -> prepare("SELECT * FROM tbl_lojistas WHERE DS_EMAIL_LOJISTA = :email");
                $confirmacao -> bindValue(":email", $email);
                $confirmacao -> execute();
    
                if ($confirmacao -> rowCount() == 1) {
                    $consulta = $confirmacao -> fetch();
                    if ($consulta["NR_CONFIRMACAO_LOJISTA"] == $codigo) {
                        $executa = $conn -> prepare("UPDATE tbl_lojistas SET DS_SENHA_LOJISTA = :senha, NR_CONFIRMACAO_LOJISTA = NULL WHERE ID_LOJISTA = :id;");
                        $executa -> bindValue(":id", $consulta["ID_LOJISTA"]);
                        $executa -> bindValue(":senha", $senha);
                        $executa -> execute();
                        echo ("<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Senha redefinida',
                            text: 'Sua senha foi alterada. Agora você pode fazer login. Clique em OK para continuar.',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace('login.php');
                            };
                        })
                        </script>");
    
                    } else if ($consulta["NR_CONFIRMACAO_LOJISTA"] != $codigo) {
                        echo ("<script>Swal.fire({icon: 'error', title: 'Código inválido', text: 'O código informado é inválido, tente novamente.'});</script>");
                    } else {
                        echo ("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O e-mail informado já foi confirmado ou o código é inválido.'});</script>");
                    };
                } else {
                    echo ("<script>Swal.fire({icon: 'error', title: 'Usuário inexistente', text: 'Não há nenhum cadastro ativo com o e-mail informado, tente novamente.'});</script>");
                };
            };
        };
    ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <main class="acessos">
        <section class="login">
            <div class="container">
                <div class="containerzinho direita forgot">
                    <div class="logotipo logo"><a href="../index.php">Caramel</a></div>
                    <h1>Redefinir senha</h1>
                    <p>Insira os dados abaixo para redefinir sua senha no Caramel.</p>
                    <form class="formulario" method="POST" action="redefinicao.php" autocomplete="off">
                        <input class="entradas" type="email" placeholder="email@dominio.com.br" id="email" name="email" value="<?php if (isset($_GET["email"])) { echo($_GET["email"]);}; ?>" required/>
                        <input class="entradas" type="number" placeholder="000000" maxlength="6" name="codigo" value="<?php if (isset($_GET["codigo"])) { echo($_GET["codigo"]);}; ?>" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
                        <input class="entradas" type="password" minlength="8" maxlength="80" placeholder="Nova senha" id="senha" name="senha" required/>
                        <input class="botao" type="submit" value="Enviar" name="confirmar"/>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>