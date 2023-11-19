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

            if ($codigo == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo código encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                $confirmacao = $conn -> prepare("SELECT * FROM tbl_lojistas WHERE DS_EMAIL_LOJISTA = :email");
                $confirmacao -> bindValue(":email", $email);
                $confirmacao -> execute();

                if ($confirmacao -> rowCount() == 1) {
                    $consulta = $confirmacao -> fetch();
                    if ($consulta["ST_CONFIRMACAO_LOJISTA"] != true && $consulta["NR_CONFIRMACAO_LOJISTA"] == $codigo) {
                        $sql = $conn -> prepare("UPDATE tbl_lojistas SET ST_CONFIRMACAO_LOJISTA = 1, NR_CONFIRMACAO_LOJISTA = NULL WHERE ID_LOJISTA = :id;");
                        $sql -> bindValue(":id", $consulta["ID_LOJISTA"]);
                        $sql -> execute();

                        $sql = $conn -> prepare("UPDATE tbl_lojas SET NR_CONFIRMACAO_LOJA = NULL WHERE ID_LOJA = :id;");
                        $sql -> bindValue(":id", $consulta["ID_LOJA"]);
                        $sql -> execute();

                        echo ("<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'E-mail confirmado!',
                            text: 'Seu cadastro foi efetivado em nossa plataforma. Agora você pode fazer login. Clique em OK para continuar.',
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

                    } else if ($consulta["ST_CONFIRMACAO_LOJISTA"] == true) {
                        echo ("<script>Swal.fire({icon: 'success', title: 'E-mail já confirmado', text: 'O e-mail informado já foi confirmado anteriormente. Não é necessário realizar a validação novamente.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                    } else if ($consulta["ST_CONFIRMACAO_LOJISTA"] != $codigo) {
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
                    <h1>Confirmar conta</h1>
                    <p>Insira o código de seis dígitos enviado no seu e-mail para confirmar o cadastro.</p>
                    <form class="formulario" method="POST" action="confirmacao.php" autocomplete="off">
                        <input name="email" class="entradas" type="email" placeholder="email@email.com.br" value="<?php if (isset($_GET["email"])) { echo($_GET["email"]);}; ?>" required/>
                        <input name="codigo" class="entradas" type="number" maxlength="6" placeholder="000000" value="<?php if (isset($_GET["codigo"])) { echo($_GET["codigo"]);}; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required/>
                        <input class="botao" type="submit" name="confirmar" value="Confirmar"/>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>