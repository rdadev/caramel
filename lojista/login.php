<?php
    session_start();
    if(isset($_SESSION["SSO_LOJISTA_CARAMEL"])){
        header("location: dashboard.php");
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
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body class="entrada">
    <?php
            include("../sources/config.php");

            if(isset($_POST["login"])) {
                $email = $_POST["email"];
                $senha = md5($_POST["senha"]);

                if ($email == "") {
                    echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");  
                } else if ($senha == "") {
                    echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo senha encontra-se vazio. Preencha os campos corretamente.'});</script>");  
                } else {
                    $login = $conn -> prepare("SELECT * FROM tbl_lojistas WHERE DS_EMAIL_LOJISTA = :email AND DS_SENHA_LOJISTA = :senha");
                    $login -> bindValue(":email", $email);
                    $login -> bindValue(":senha", $senha);
                    $login -> execute();
    
                    if($login -> rowCount() == 0) {
                        echo ("<script>Swal.fire({icon: 'error', title: 'Dados inválidos', text: 'Verifique se você digitou corretamente seus dados e tente novamente.'});</script>");
                    } else {
                        $consulta = $login -> fetch();
                        if ($consulta['ST_ATIVIDADE_LOJISTA'] == false) {
                            echo ("<script>
                            Swal.fire({
                            icon: 'error',
                            title: 'Usuário inativo',
                            text: 'Seu cadastro está desativado, solicite ao administrador da loja que o ative novamente.',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {
    
                            } else if (result.isDenied) {
                                
                            };
                        });
                        </script>");
    
                        } else if($consulta['ST_CONFIRMACAO_LOJISTA'] == false) {
                            $nome = $consulta['NM_LOJISTA'];
                            $email = $consulta['DS_EMAIL_LOJISTA'];
                            $codigo = $consulta['NR_CONFIRMACAO_LOJISTA'];
        
                            $subject = "Bem-vindo(a) ao Caramel, ative sua conta agora mesmo!";
                            $message = "
                            Olá, ".$nome."!
                            <br/>
                            Recebemos sua solicitação de cadastro, agora é preciso um passo essencial, ativar sua conta. Para isso, existe abaixo um código de confirmação que você pode inserir na <a href='https://caramel.app.br/lojista/confirmacao.php'>página de confirmação</a> ou clicando no link abaixo para confirmar automaticamente.
                            <br/><br/>
                            Código: <b>".$codigo."</b>
                            <br/>
                            Link de confirmação: <a href='https://caramel.app.br/lojista/confirmacao.php?email=".$email."&codigo=".$codigo."'>https://caramel.app.br/lojista/confirmacao.php?email=".$email."&codigo=".$codigo."</a>
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
                            icon: 'error',
                            title: 'E-mail não confirmado',
                            text: 'Seu cadastro ainda não foi confirmado, foi enviado um novo e-mail de confirmação, verifique sua caixa de entrada.',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: 'Fechar',
                            footer: '<a href=\"confirmacao.php\">Tenho um código</a>',
                        }).then((result) => {
                            if (result.isConfirmed) {
        
                            } else if (result.isDenied) {
                                
                            };
                        });
                        </script>");
                        } else {
                            $_SESSION['SSO_LOJISTA_CARAMEL'] = $consulta['ID_LOJISTA'];
                            $_SESSION['PMS_LOJISTA_CARAMEL'] = $consulta['ID_PERMISSAO_LOJISTA'];
                            echo("<script>window.location.replace('dashboard.php');</script>");
                        };
                    };
                };
            };
        ?>
    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <main class="acessos">
        <section class="login">
            <div class="container">
                <div class="containerzinho direita">
                    <div class="logotipo logo"><a href="../index.php">Caramel</a></div>
                    <h1>Entre para continuar</h1>
                    <p>Venda e gerencie pedidos pela plataforma de delivery mais amada pelos petshops</p>
                    <form class="formulario" method="POST" action="login.php">
                        <input id="email" class="entradas" type="email" placeholder="email@email.com.br" name="email" required/>
                        <input id="senha" class="entradas" type="password" placeholder="********" name="senha" required/>
                        <a class="recuperacao" href="recuperacao.php">Esqueceu a senha?</a>
                        <input type="submit" class="botao" value="Entrar" name="login"/>
                        <span class="acao">Ainda não é parceiro? <a class="linkacao" href="cadastro.php">Cadastro</a></span>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>