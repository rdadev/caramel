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
            $email = $_POST["email"];
            $codigo = $_POST["codigo"];

            if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");  
            } else if ($codigo == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo código encontra-se vazio. Preencha os campos corretamente.'});</script>");  
            } else {
                $consultar = $conn -> prepare("SELECT * FROM tbl_lojas WHERE DS_TEMPMAIL_LOJA = :email AND NR_CONFIRMACAO_LOJA = :codigo AND ST_TEMPMAIL_LOJA = 1");
                $consultar -> bindValue(":email", $email);
                $consultar -> bindValue(":codigo", $codigo);
                $consultar -> execute();

                if($consultar -> rowCount() == 0) { 
                    $consultar2 = $conn -> prepare("SELECT * FROM tbl_lojistas WHERE DS_TEMPMAIL_LOJISTA = :email AND NR_CONFIRMACAO_LOJISTA = :codigo AND ST_TEMPMAIL_LOJISTA = 1");
                    $consultar2 -> bindValue(":email", $email);
                    $consultar2 -> bindValue(":codigo", $codigo);
                    $consultar2 -> execute();

                    if($consultar2 -> rowCount() == 0) { 
                        echo ("<script>Swal.fire({icon: 'error', title: 'Dados inválidos', text: 'Verifique se você digitou corretamente seus dados e tente novamente.'});</script>");
                    } else {
                        $dados_lojista = $consultar2 -> fetch();
                        $confirmar_email = $conn -> prepare("UPDATE tbl_lojistas SET DS_EMAIL_LOJISTA = :novo_email, NR_CONFIRMACAO_LOJISTA = NULL, DS_TEMPMAIL_LOJISTA = NULL, ST_TEMPMAIL_LOJISTA = 0 WHERE ID_LOJISTA = :id");
                        $confirmar_email -> bindValue(":id", $dados_lojista["ID_LOJISTA"]);
                        $confirmar_email -> bindValue("novo_email", $email);
                        $confirmar_email -> execute();

                        echo ("<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'E-mail alterado',
                            text: 'Seu e-mail foi alterado, no próximo login você já poderá usa-lo para entrar',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace('conta.php');
                            };
                        })
                        </script>");
                    }

                } else {
                    $dados = $consultar -> fetch();
                    $confirma_email = $conn -> prepare("UPDATE tbl_lojas SET DS_EMAIL_LOJA = :novo_email, NR_CONFIRMACAO_LOJA = NULL, DS_TEMPMAIL_LOJA = NULL, ST_TEMPMAIL_LOJA = 0 WHERE ID_LOJA = :id");
                    $confirma_email -> bindValue(":id", $dados["ID_LOJA"]);
                    $confirma_email -> bindValue("novo_email", $email);
                    $confirma_email -> execute();

                    echo ("<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'E-mail alterado',
                        text: 'O e-mail da sua loja foi alterado, o novo e-mail ficará visível na página da loja',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        denyButtonText: `Don't save`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace('perfil.php');
                        };
                    })
                    </script>");
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
                    <h1>Confirmar novo e-mail</h1>
                    <p>Insira o código de seis dígitos enviado no seu e-mail para confirmar o novo endereço.</p>
                    <form class="formulario" method="POST" action="email.php" autocomplete="off">
                        <input class="entradas" type="email" placeholder="email@email.com.br" name="email" value="<?php if (isset($_GET["email"])) { echo($_GET["email"]);}; ?>" required/>
                        <input class="entradas" type="number" maxlength="6" placeholder="000000" name="codigo" value="<?php if (isset($_GET["codigo"])) { echo($_GET["codigo"]);}; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required/>
                        <input class="botao" type="submit" value="Confirmar" name="confirmar"/>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>