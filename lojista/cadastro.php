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
    <script type="text/javascript" src="../sources/script.js"></script>
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body class="cadastramento">
    <?php
        include("../sources/config.php");

        if(isset($_POST["cadastrar"])) {
            $tel1 = str_replace("(", "",$_POST["telefone"]);
            $tel2 = str_replace(")", "",$tel1);
            $tel3 = str_replace("-", "",$tel2);
            $telefone = str_replace(" ", "",$tel3);
            $cpf1 = str_replace("-", "",$_POST["cpf_admin"]);
            $cpf_admin = str_replace(".", "",$cpf1);
            $cnpj1 = str_replace("-", "",$_POST["cnpj"]);
            $cnpj2 = str_replace(".", "",$cnpj1);
            $cnpj = str_replace("/", "",$cnpj2);
            $razao = strtoupper($_POST["razao"]);
            $email = strtolower($_POST["email"]);
            $senha = md5($_POST["senha"]);
            $nome_admin = strtoupper($_POST["nome_admin"]);
            $cep = str_replace("-", "",$_POST["cep"]);
            $cidade = $_POST["cidade"];
            $estado = $_POST["estado"];
            $bairro = $_POST["bairro"];
            $logradouro = $_POST["logradouro"];
            $complemento = $_POST["complemento"];
            $rand = mt_rand(1, 999999);
            $codigo = str_pad($rand, 6, 0, STR_PAD_LEFT);
            $unico = mt_rand(1, 2147483647);

            if ($telefone == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo telefone encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cpf_admin == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo CPF encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cnpj == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo CNPJ encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($razao == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo razão social encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($senha == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo senha encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($nome_admin == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo nome do responsável encontra-se vazio. Preencha os campos corretamente.'});</script>");
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
            } else {
                // VERIFICACAO DE DUPLICIDADES
                $verifica_cpf = $conn -> prepare("SELECT NR_CPF_LOJISTA FROM tbl_lojistas WHERE NR_CPF_LOJISTA = :cpf");
                $verifica_cpf -> bindValue(":cpf", $cpf_admin);
                $verifica_cpf -> execute();

                $verifica_cnpj = $conn -> prepare("SELECT NR_CNPJ_LOJA FROM tbl_lojas WHERE NR_CNPJ_LOJA = :cnpj");
                $verifica_cnpj -> bindValue(":cnpj", $cnpj);
                $verifica_cnpj -> execute();

                $verifica_email = $conn -> prepare("SELECT DS_EMAIL_LOJISTA FROM tbl_lojistas WHERE DS_EMAIL_LOJISTA = :email");
                $verifica_email -> bindValue(":email", $email);
                $verifica_email -> execute();
                
                $verifica_email2 = $conn -> prepare("SELECT DS_EMAIL_LOJA FROM tbl_lojas WHERE DS_EMAIL_LOJA = :email");
                $verifica_email2 -> bindValue(":email", $email);
                $verifica_email2 -> execute();

                $verifica_id = $conn -> prepare("SELECT ID_LOJA FROM tbl_lojas WHERE ID_LOJA = :id");
                $verifica_id -> bindValue(":id", $unico);
                $verifica_id -> execute();

                if ($verifica_cpf -> rowCount() == 1) { 
                    echo("<script>Swal.fire({icon: 'error', title: 'Conta já existente', text: 'Já existe uma conta cadastrada com o CPF informado. Por favor, tente novamente.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                } else if ($verifica_cnpj -> rowCount() == 1) {
                    echo("<script>Swal.fire({icon: 'error', title: 'Conta já existente', text: 'Já existe uma conta cadastrada com o CNPJ informado, tente com outro CNPJ.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                } else if ($verifica_email -> rowCount() == 1) {
                    echo("<script>Swal.fire({icon: 'error', title: 'Conta já existente', text: 'Já existe uma conta cadastrada com o e-mail informado, tente com outra conta de e-mail.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                } else if ($verifica_email2 -> rowCount() == 1) {
                    echo("<script>Swal.fire({icon: 'error', title: 'Conta já existente', text: 'Já existe uma conta cadastrada com o e-mail informado, tente com outra conta de e-mail.', footer: '<a href=\"login.php\">Fazer login</a>'});</script>");
                } else if ($verifica_id -> rowCount() == 1) {
                    do {
                        $unico = mt_rand(1, 2147483647);
                        $verifica_id = $conn -> prepare("SELECT ID_LOJA FROM tbl_lojas WHERE ID_LOJA = :id");
                        $verifica_id -> bindValue(":id", $unico);
                        $verifica_id -> execute();
                    } while ($verifica_id -> rowCount() == 1);
                } else {
                    $cadastro = $conn -> prepare("INSERT INTO tbl_lojas (ID_LOJA, NM_LOJA, NR_TELEFONE_LOJA, DS_EMAIL_LOJA, DS_LOJA, NR_CNPJ_LOJA, DS_RAZAO_LOJA, DS_CAMINHO_IMAGEM_LOJA, DS_CAMINHO_CAPA_LOJA, NR_CEP_LOJA, NM_CIDADE_LOJA, SG_UF_LOJA, NM_BAIRRO_LOJA, DS_LOGRADOURO_LOJA, NR_CONFIRMACAO_LOJA, DS_TEMPMAIL_LOJA, ST_TEMPMAIL_LOJA) VALUES (:id, :razao, :telefone, :email, '-', :cnpj, :razao, '../uploads/petshops/perfil_padrao.jpg', '../uploads/petshops/capa_padrao.jpg', :cep, :cidade, :estado, :bairro, :logradouro, :codigo, NULL, 0);");
                    $cadastro -> bindValue(":id", $unico);
                    $cadastro -> bindValue(":razao", $razao);
                    $cadastro -> bindValue(":telefone", $telefone);
                    $cadastro -> bindValue(":email", $email);
                    $cadastro -> bindValue(":cnpj", $cnpj);
                    $cadastro -> bindValue(":cep", $cep);
                    $cadastro -> bindValue(":cidade", $cidade);
                    $cadastro -> bindValue(":estado", $estado);
                    $cadastro -> bindValue(":bairro", $bairro);
                    $cadastro -> bindValue(":logradouro", $logradouro);
                    $cadastro -> bindValue(":codigo", $codigo);
                    $cadastro -> execute();

                    $lojista = $conn -> prepare("INSERT INTO tbl_lojistas (NM_LOJISTA, DS_SENHA_LOJISTA, NR_CPF_LOJISTA, DS_EMAIL_LOJISTA, ID_LOJA, ID_PERMISSAO_LOJISTA, ST_CONFIRMACAO_LOJISTA, NR_CONFIRMACAO_LOJISTA, ST_ATIVIDADE_LOJISTA, DS_TEMPMAIL_LOJISTA, ST_TEMPMAIL_LOJISTA, ST_MASTER_LOJISTA, DT_CADASTRO_LOJISTA) VALUES (:nome_admin, :senha, :cpf, :email, :id, 1, 0, :codigo, 1, NULL, 0, 1, :data);");
                    $lojista -> bindValue(":nome_admin", $nome_admin);
                    $lojista -> bindValue(":senha", $senha);
                    $lojista -> bindValue(":cpf", $cpf_admin);
                    $lojista -> bindValue(":codigo", $codigo);
                    $lojista -> bindValue(":email", $email);
                    $lojista -> bindValue(":id", $unico);
                    $lojista -> bindValue(":data", date("Y-m-d"));
                    $lojista -> execute();

                    $subject = "Bem-vindo(a) ao Caramel, ative a conta da sua loja agora mesmo!";
                    $message = "
                        Olá, ".$nome_admin."!
                        <br/>
                        Recebemos sua solicitação de cadastro para sua loja, agora é preciso um passo essencial, ativar sua conta. Para isso, existe abaixo um código de confirmação que você pode inserir na <a href='https://caramel.app.br/lojista/confirmacao.php'>página de confirmação</a> ou clicando no link abaixo para confirmar automaticamente.
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
                    <h1>Seja uma loja parceira</h1>
                    <p>Sua força de vendas online para produtos de petshop e derivados, começe agora mesmo</p>
                    <form class="formulario" method="POST" action="cadastro.php" autocomplete="off">
                        <fieldset>
                            <input name="razao" class="entradas cnpj" type="text" placeholder="Razão social" required/>
                            <input id="cnpj" name="cnpj" class="entradas" type="text" placeholder="CNPJ (somente números)" required/>
                            <input name="email" class="entradas" type="email" placeholder="Seu email comercial" required/>
                            <input name="senha" class="entradas" type="password" minlength="8" placeholder="Crie uma senha" required/>
                            <button class="prox botao" type="button">Próximo</button>
                            <span class="acao">Já é nosso parceiro? <a class="linkacao" href="login.php">Fazer login</a></span>    
                        </fieldset>
                        <fieldset>
                            <input name="nome_admin" class="entradas" type="text" placeholder="Nome do responsável" required/>
                            <input id="cpf" name="cpf_admin" class="entradas" type="text" maxlength="11" placeholder="CPF do responsável" required/>
                            <input name="telefone" id="telefone" class="entradas" type="text" placeholder="Telefone" required/>
                            <button class="prox botao smb" type="button">Próximo</button>
                        </fieldset>
                        <fieldset>
                            <input name="cep" id="cep" onchange="consultarCEP()" class="entradas" type="text" placeholder="CEP" required/>
                            <input name="cidade" id="cidade" class="entradas" type="text" placeholder="Cidade" required/>
                            <input name="estado" id="estado" class="entradas" type="text" placeholder="Estado" required/>
                            <input name="bairro" id="bairro" class="entradas" type="text" placeholder="Bairro" required/>
                            <input name="logradouro" id="logradouro" class="entradas" type="text" placeholder="Logradouro" required/>
                            <input name="complemento" id="complemento" class="entradas" type="text" placeholder="Complemento"/>
                            <span class="termos"><p>Ao clicar em confirmar você concorda com a <a href="../privacidade/index.php" target="_blank">política de privacidade</a> e os <a href="../termos/index.php" target="_blank">termos</a> da plataforma</p></span>
                            <input class="botao smb" type="submit" name="cadastrar" value="Confirmar"/>
                        </fieldset>
                     </form>
                </div>
            </div>
        </section>
    </main>
</body>
    <script> 
        $('#cnpj').mask('00.000.000-0000/00');
        $('#cep').mask('00000-000');
        $('#telefone').mask('(00) 00000-0000');
        $('#cpf').mask('000.000.000-00');
    </script>
</html>