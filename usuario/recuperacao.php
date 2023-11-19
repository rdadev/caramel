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
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body class="entrada">
    <?php
        include("../sources/config.php");

        if(isset($_POST["recuperacao"])) {
            $email = $_POST["email"];
            $recupera = $conn -> prepare("SELECT * FROM tbl_usuarios WHERE DS_EMAIL_USUARIO = :email");
            $recupera -> bindValue(":email", $email);
            $recupera -> execute();

            if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                if($recupera -> rowCount() == 0) {
                    echo ("<script>Swal.fire({icon: 'error', title: 'Usuário inexistente', text: 'Verifique se você digitou corretamente seus dados e tente novamente.'});</script>");
                } else {
                    $consulta = $recupera -> fetch();
                    $id = $consulta['ID_USUARIO'];
                    $nome = $consulta['NM_USUARIO'];
                    $email = $consulta['DS_EMAIL_USUARIO'];
                    $rand = mt_rand(1, 999999);
                    $codigo = str_pad($rand, 6, 0, STR_PAD_LEFT);
    
                    $salva_codigo = $conn -> prepare("UPDATE tbl_usuarios SET NR_CONFIRMACAO_USUARIO = :codigo WHERE ID_USUARIO = :id");
                    $salva_codigo -> bindValue(":codigo", $codigo);
                    $salva_codigo -> bindValue(":id", $id);
                    $salva_codigo -> execute();
    
                        $subject = "Alguém solicitou a redefinição de senha em sua conta do Caramel";
                        $message = "
                        Olá, ".$nome."!
                        <br/>
                        Recebemos sua solicitação de redefinição de senha, agora é preciso um passo essencial, validar que a alteração está sendo feita por você. Para isso, existe abaixo um código de confirmação que você pode inserir na <a href='https://caramel.app.br/usuario/redefinicao.php'>página de confirmação</a> ou clicando no link abaixo para confirmar automaticamente.
                        <br/><br/>
                        Código: <b>".$codigo."</b>
                        <br/>
                        Link de confirmação: <a href='https://caramel.app.br/usuario/redefinicao.php?email=".$email."&codigo=".$codigo."'>https://caramel.app.br/usuario/redefinicao.php?email=".$email."&codigo=".$codigo."</a>
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
                        title: 'Redefinição solicitada',
                        text: 'Foi enviado um e-mail de redefinição contendo os passos necessários para recuperar sua senha, verifique sua caixa de entrada.',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        denyButtonText: 'Fechar',
                        footer: '<a href=\"redefinicao.php\">Tenho um código</a>',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace('redefinicao.php');
                        } else if (result.isDenied) {
                            
                        };
                    });
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
                    <h1>Recuperar senha</h1>
                    <p>Insira o seu email e enviaremos um link para você voltar a acessar a sua conta.</p>
                    <form class="formulario" method="POST" action="recuperacao.php" autocomplete="off">
                        <input class="entradas" type="email" placeholder="email@email.com.br" name="email" required/>
                        <input class="botao" type="submit" name="recuperacao" value="Enviar"/>
                        <span class="acao">Já tem uma senha? <a class="linkacao" href="login.php">Login</a></span>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>