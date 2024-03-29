<?php
    session_start();
    if(!isset($_SESSION["SSO_USUARIO_CARAMEL"])){
        header("location: login.php");
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
    <link rel="stylesheet" type="text/css" href="../store/style.css"/>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../sources/masks.js"></script>
    <script defer type="text/javascript" src="../sources/script.js"></script>
    <script src="../sources/alerts.js"></script>
    <link rel="stylesheet" href="../sources/alerts.css">
    <title>Caramel</title>
</head>
<body>
    <?php
        include("../sources/config.php");
        $usuario = $_SESSION["SSO_USUARIO_CARAMEL"];

        if(isset($_POST["alterar_senha"])) {
            $senha = md5($_POST["senha_atual"]);
            $nova_senha = md5($_POST["nova_senha"]);
            $confirmar_senha = md5($_POST["confirmar_senha"]);
            $login = $conn -> prepare("SELECT * FROM tbl_usuarios WHERE ID_USUARIO = :id AND DS_SENHA_USUARIO = :senha");
            $login -> bindValue(":id", $usuario);
            $login -> bindValue(":senha", $senha);
            $login -> execute();

            if ($senha == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo senha atual encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($nova_senha == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo nova senha encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($confirmar_senha == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo confirmar senha encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                if($login -> rowCount() == 0) { 
                    echo ("<script>Swal.fire({icon: 'error', title: 'Senha inválida', text: 'Verifique se você digitou corretamente seus dados e tente novamente.'});</script>");
                } else {
                    if ($nova_senha == $senha) { 
                        echo ("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'A nova senha é igual a senha atual, informe outra senha.'});</script>");
                    } else if ($confirmar_senha != $nova_senha) {
                        echo ("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'A nova senha não confere com a confirmação, tente novamente.'});</script>");
                    } else {
                        $executa = $conn -> prepare("UPDATE tbl_usuarios SET DS_SENHA_USUARIO = :senha WHERE ID_USUARIO = :id;");
                        $executa -> bindValue(":id", $usuario);
                        $executa -> bindValue(":senha", $nova_senha);
                        $executa -> execute();
                        echo ("<script>Swal.fire({icon: 'success', title: 'Senha alterada', text: 'Sua senha foi alterada com sucesso, no próximo login você já pode usar a nova senha.'});</script>");
                    };
                };
            };
        };

        if(isset($_POST["alterar_dados"])) {
            // REMOVE MASCARAS
            $tel1 = str_replace("(", "",$_POST["telefone"]);
            $tel2 = str_replace(")", "",$tel1);
            $tel3 = str_replace("-", "",$tel2);
            $telefone = str_replace(" ", "",$tel3);
            $email = $_POST["email"];
            $nome = $_POST["nome"];
            $cep = str_replace("-", "",$_POST["cep"]);
            $bairro = $_POST["bairro"];
            $cidade = $_POST["cidade"];
            $logradouro = $_POST["logradouro"];
            $estado = $_POST["estado"];
            $complemento = $_POST["complemento"];

            if ($email == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo e-mail encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($nome == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo nome encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cep == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo CEP encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($bairro == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo bairro encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($cidade == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo cidade encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($logradouro == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo logradouro encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else if ($estado == "") {
                echo("<script>Swal.fire({icon: 'error', title: 'Erro', text: 'O campo estado encontra-se vazio. Preencha os campos corretamente.'});</script>");
            } else {
                $consulta_email = $conn -> prepare("SELECT DS_EMAIL_USUARIO FROM tbl_usuarios WHERE ID_USUARIO = :id");
                $consulta_email -> bindValue(":id", $usuario);
                $consulta_email -> execute();
                $cons_email = $consulta_email -> fetch();
    
                if ($email != $cons_email["DS_EMAIL_USUARIO"]) {
                    $rand = mt_rand(1, 999999);
                    $codigo = str_pad($rand, 6, 0, STR_PAD_LEFT);
    
                    // CONSULTA DUPLICADOS
                    $consulta_duplicidade = $conn -> prepare("SELECT DS_EMAIL_USUARIO FROM tbl_usuarios WHERE DS_EMAIL_USUARIO = :email");
                    $consulta_duplicidade -> bindValue(":email", $email);
                    $consulta_duplicidade -> execute();
                    
                    if ($consulta_duplicidade -> rowCount() == 1) {
                        echo ("<script>Swal.fire({icon: 'error', title: 'E-mail já existente', text: 'Já existe um cadastro com este endereço de e-mail, tente cadastrar outro e-mail.'});</script>");
                    } else {
                        $salva_temp = $conn -> prepare("UPDATE tbl_usuarios SET NR_CONFIRMACAO_USUARIO = :codigo, DS_TEMPMAIL_USUARIO = :email, ST_TEMPMAIL_USUARIO = 1 WHERE ID_USUARIO = :id");
                        $salva_temp -> bindValue(":codigo", $codigo);
                        $salva_temp -> bindValue(":email", $email);
                        $salva_temp -> bindValue(":id", $usuario);
                        $salva_temp -> execute();
        
                        $subject = "Alteração de e-mail na conta do Caramel";
                        $message = "
                        Olá, ".$nome."!
                        <br/>
                        Recebemos sua solicitação de alteração de e-mail, agora é preciso um passo essencial, confirmar seu novo endereço de e-mail. Para isso, existe abaixo um código de confirmação que você pode inserir na <a href='https://caramel.app.br/usuario/email.php'>página de confirmação</a> ou clicando no link abaixo para confirmar automaticamente.
                        <br/><br/>
                        Código: <b>".$codigo."</b>
                        <br/>
                        Link de confirmação: <a href='https://caramel.app.br/usuario/email.php?email=".$email."&codigo=".$codigo."'>https://caramel.app.br/usuario/email.php?email=".$email."&codigo=".$codigo."</a>
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
        
                        $altera = $conn -> prepare("UPDATE tbl_usuarios SET NM_USUARIO = :nome, NR_TELEFONE_USUARIO = :telefone, NR_CEP_USUARIO = :cep, NM_BAIRRO_USUARIO = :bairro, NM_CIDADE_USUARIO = :cidade, DS_LOGRADOURO_USUARIO = :logradouro, SG_UF_USUARIO = :estado, DS_COMPLEMENTO_USUARIO = :complemento WHERE ID_USUARIO = :id;");
                        $altera -> bindValue(":id", $usuario);
                        $altera -> bindValue(":nome", $nome);
                        $altera -> bindValue(":telefone", $telefone);
                        $altera -> bindValue(":cep", $cep);
                        $altera -> bindValue(":bairro", $bairro);
                        $altera -> bindValue(":cidade", $cidade);
                        $altera -> bindValue(":logradouro", $logradouro);
                        $altera -> bindValue(":estado", $estado);
                        $altera -> bindValue(":complemento", $complemento);
                        $altera -> execute();
                        
                        echo ("<script>Swal.fire({icon: 'info', title: 'Confirmação pendente', text: 'Foi enviado um e-mail de confirmação para o novo e-mail informado. Os demais dados foram salvos automaticamente.'});</script>");
                    };
    
                } else {
                    $altera = $conn -> prepare("UPDATE tbl_usuarios SET NM_USUARIO = :nome, NR_TELEFONE_USUARIO = :telefone, NR_CEP_USUARIO = :cep, NM_BAIRRO_USUARIO = :bairro, NM_CIDADE_USUARIO = :cidade, DS_LOGRADOURO_USUARIO = :logradouro, SG_UF_USUARIO = :estado, DS_COMPLEMENTO_USUARIO = :complemento WHERE ID_USUARIO = :id;");
                    $altera -> bindValue(":id", $usuario);
                    $altera -> bindValue(":nome", $nome);
                    $altera -> bindValue(":telefone", $telefone);
                    $altera -> bindValue(":cep", $cep);
                    $altera -> bindValue(":bairro", $bairro);
                    $altera -> bindValue(":cidade", $cidade);
                    $altera -> bindValue(":logradouro", $logradouro);
                    $altera -> bindValue(":estado", $estado);
                    $altera -> bindValue(":complemento", $complemento);
                    $altera -> execute();
    
                    echo ("<script>Swal.fire({icon: 'success', title: 'Dados alterados', text: 'Seus dados foram alterados com sucesso!'});</script>");
                };
            };
        };

        $consulta = $conn -> prepare("SELECT * FROM tbl_usuarios WHERE ID_USUARIO = :id");
        $consulta -> bindValue(":id", $usuario);
        $consulta -> execute();
        $dados = $consulta -> fetch();
    ?>

    <div class="carregamento"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" fill="#FFFFFF"/></svg></div>
    <div class="block" onclick="fecharLateral()"></div>
    <header class="cabeça">
        <div class="container">
            <div class="logotipo"><a href="../store/index.php">Caramel</a></div>
            <nav class="navbusca">
                <ul>
                    <li><a href="../store/index.php">Início</a></li>
                    <li><a href="../store/busca.php?search=Ração" onclick="atualizaPesquisa('Ração')">Ração</a></li>
                    <li><a href="../store/busca.php?search=Petiscos" onclick="atualizaPesquisa('Petiscos')">Petiscos</a></li>
                    <li><a href="../store/busca.php?search=Roupas" onclick="atualizaPesquisa('Roupas')">Roupas</a></li>
                    <li><a href="../store/busca.php?search=Acessórios" onclick="atualizaPesquisa('Acessórios')">Acessórios</a></li>
                    <li><a href="../store/busca.php?search=Outros" onclick="atualizaPesquisa('Outros')">Outros</a></li>
                </ul>
            </nav>
            <form class="buscar" method="GET" action="../store/busca.php" autocomplete="off">
                <input name="search" id="buscagem" type="text" placeholder="Digite e tecle enter para buscar" onfocusout="abrirPesquisa()"/>
            </form>
            <ul class="buttons">
                <li><a href="../logout.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" ><path d="M179.761 941.978q-27.698 0-48.034-20.265-20.336-20.266-20.336-47.865V278.152q0-27.697 20.336-48.033 20.336-20.337 48.034-20.337h292.674v68.37H179.761v595.696h292.674v68.13H179.761Zm486.478-182.369-48.978-48.5 101.043-101.044H371.891v-68.13h344.413L615.261 440.891l48.978-48.5L848.609 577l-182.37 182.609Z"/></svg></a></li>
                <li><button type="button" onclick="abrirLateral('#carrinho');abrirFundo('#total');"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.152 980.065q-27.599 0-47.865-20.266-20.265-20.265-20.265-47.864V399.109q0-27.698 20.265-48.034 20.266-20.336 47.865-20.336h103.783v-10q.478-64.196 45.131-108.413 44.654-44.217 108.892-44.217t108.933 44.217q44.696 44.217 45.174 108.413v10h103.783q27.697 0 48.033 20.336 20.337 20.336 20.337 48.034v512.826q0 27.599-20.337 47.864-20.336 20.266-48.033 20.266H222.152Zm0-68.13h515.696V399.109H634.065v85.695q0 14.663-9.871 24.484-9.871 9.821-24.369 9.821-14.499 0-24.195-9.821-9.695-9.821-9.695-24.484v-85.695h-171.87v85.695q0 14.663-9.871 24.484-9.871 9.821-24.369 9.821-14.499 0-24.195-9.821-9.695-9.821-9.695-24.484v-85.695H222.152v512.826Zm172.152-581.196h171.392v-10q-.479-35.609-25.187-60.054-24.708-24.446-60.532-24.446-35.825 0-60.51 24.446-24.684 24.445-25.163 60.054v10ZM222.152 911.935V399.109v512.826Z"/></svg></button></li>
                <li class="pedidos"><a href="../store/pedidos.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.957 987q-47.377 0-80.374-32.996-32.996-32.997-32.996-80.486V742.652h129.869V171.935l61.235 60.956 60.996-60.956 60.756 60.956 61.235-60.956 60.757 60.956 61.195-60.956 60.957 60.956 61.196-60.956 60.956 60.956 61.674-60.956V873.63q0 47.377-33.066 80.374Q784.281 987 737.043 987H222.957Zm514.206-68.37q19.88 0 32.38-12.513 12.5-12.514 12.5-32.534V281.022H307.587v461.63h384.456V873.63q0 20 12.62 32.5t32.5 12.5ZM360.587 440.457v-60h235.456v60H360.587Zm0 134v-60h235.456v60H360.587Zm328.456-134q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9Zm0 129q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9ZM221.957 918.63h401.956V811.022H177.957v62.608q0 20 12.65 32.5t31.35 12.5Zm-44 0V811.022 918.63Z"/></svg></a></li>
                <li class="conta"><a href="../usuario/conta.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M479.951 571.891q-68.679 0-112.304-43.625t-43.625-112.305q0-68.679 43.625-112.353 43.625-43.674 112.304-43.674t112.473 43.674q43.794 43.674 43.794 112.353 0 68.68-43.794 112.305t-112.473 43.625ZM154.022 905.087V804.68q0-39.557 19.915-68.042 19.915-28.486 51.433-43.268 67.478-30.24 129.685-45.359 62.208-15.12 124.881-15.12 63.131 0 124.793 15.62 61.662 15.619 128.822 45.053 32.882 14.594 52.774 42.993 19.893 28.4 19.893 68.06v100.47H154.022Zm68.13-68.13h515.696v-31.37q0-15.845-9.5-30.219-9.5-14.373-23.5-21.303-63.044-30.282-115.445-41.543-52.401-11.261-109.521-11.261-56.643 0-110.284 11.261-53.641 11.261-115.343 41.506-14.103 6.932-23.103 21.316-9 14.384-9 30.243v31.37Zm257.799-333.196q38.092 0 62.995-24.866 24.902-24.865 24.902-62.974 0-38.207-24.854-63.031-24.853-24.825-62.945-24.825t-62.995 24.836q-24.902 24.835-24.902 62.902 0 38.165 24.854 63.061 24.853 24.897 62.945 24.897Zm.049-87.848Zm0 421.044Z"/></svg></a></li> 
            </ul>
        </div>
    </header>

    <main>
        <section>
            <div class="container">
                <button type="button" class="btvoltar" onclick="window.history.back()"><svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M359-242 120-481l239-239 43 43-166 166h604v60H236l166 166-43 43Z"/></svg> Voltar</button>
                <h1 class="heads">Meus dados</h1>
                <form class="cadastrin" method="POST" action="conta.php" autocomplete="off">
                    <h3 class="subheads">Principal</h3>
                    <fieldset>
                        <div class="esq">
                            <label for="nome">Nome completo</label>
                            <input class="txti" id="nome" type="text" name="nome" placeholder="Caramelo do Brasil" value="<?php echo($dados["NM_USUARIO"]) ?>" required/>
                            <label for="email">Email</label>
                            <input class="txti" id="email" type="text" name="email" placeholder="email@email.com.br" value="<?php echo($dados["DS_EMAIL_USUARIO"]) ?>" required/>    
                        </div>
                        <div class="dir">
                            <label for="email">Celular</label>
                            <input class="txti" id="telefone" type="text" name="telefone" placeholder="(00) 00000-0000" value="<?php echo($dados["NR_TELEFONE_USUARIO"]) ?>"/>
                            <label for="cpf">CPF</label>
                            <input class="txti" id="cpf" type="text" name="cpf" placeholder="000.000.000-00" value="<?php echo($dados["NR_CPF_USUARIO"]) ?>" disabled/>
                        </div>
                    </fieldset>
                    <h3 class="subheads">Credenciais</h3>
                    <fieldset>
                        <label for="nome">Senha</label>
                        <input class="txti txtpass" id="senha" type="password" placeholder="########" value="********" disabled/>
                        <button type="button" class="btb btpass" onclick="abrirModal('#alterpass')">Alterar senha</button>
                    </fieldset>
                    <h3 class="subheads">Endereço</h3>
                    <fieldset>
                        <div class="esq">
                            <label for="cep">CEP</label>
                            <input class="txti" id="cep" type="text" name="cep" onchange="consultarCEP()" value="<?php echo($dados["NR_CEP_USUARIO"]) ?>" required/>
                            <label for="cidade">Cidade</label>
                            <input class="txti" id="cidade" type="text" name="cidade" value="<?php echo($dados["NM_CIDADE_USUARIO"]) ?>" required/>
                            <label for="estado">Estado</label>
                            <input class="txti" id="estado" type="text" name="estado" value="<?php echo($dados["SG_UF_USUARIO"]) ?>" required/>
                        </div>
                        <div class="dir">
                            <label for="bairro">Bairro</label>
                            <input class="txti" id="bairro" type="text" name="bairro" value="<?php echo($dados["NM_BAIRRO_USUARIO"]) ?>" required/>
                            <label for="logradouro">Logradouro</label>
                            <input class="txti" id="logradouro" type="text" name="logradouro" value="<?php echo($dados["DS_LOGRADOURO_USUARIO"]) ?>" required/>
                            <label for="complemento">Complemento</label>
                            <input class="txti" id="complemento" type="text" name="complemento" value="<?php echo($dados["DS_COMPLEMENTO_USUARIO"]) ?>"/>
                        </div>
                    </fieldset>
                    <input class="bta btfit" type="submit" value="Salvar alterações" name="alterar_dados"/>
                    <a class="btb btfit" href="../store/index.php">Cancelar</a>
                </form>
                <script type="text/javascript"> 
                    $("#telefone").mask("(00) 00000-0000");
                    $("#cep").mask("00000-000");
                    $("#cpf").mask("000.000.000-00"); 
                </script>
            </div>
        </section>
        <dialog id="alterpass" class="pass" onkeydown="removeBlur()">
            <div class="cabeca">
                <h1>Alteração de senha</h1>
                <button class="mdfechar" type="button" onclick="fecharModal('#alterpass')"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button>
            </div>
            <div class="conteudo">
                <form class="alterpass" method="POST" action="conta.php" autocomplete="off">
                    <fieldset>
                        <label for="antpass" class="lbs">Senha atual</label>
                        <input class="txti" id="antpass" type="password" placeholder="********" name="senha_atual" required/>
                        <label for="newpass" class="lbs">Nova senha</label>
                        <input class="txti" id="newpass" type="password" placeholder="********" name="nova_senha" minlength="8" required/>
                        <label for="cofpass" class="lbs">Confirmar</label>
                        <input class="txti" id="cofpass" type="password" placeholder="********" name="confirmar_senha"minlength="8" required/>
                        <input class="bta rbtcontent" type="submit" name="alterar_senha" value="Alterar"/>
                        <button class="btb rbtcontent" type="button" onclick="fecharModal('#alterpass')">Cancelar</button>
                    </fieldset>
                </form>
            </div>
        </dialog>

        <section class="mobnavs">
            <a href="../store/index.php"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.152 873.848h143.783V621.935h228.13v251.913h143.783V486.957L480 293.63 222.152 487.036v386.812Zm-68.13 68.13V452.891L480 208.348l326.218 244.543v489.087H528.565V687.435h-97.13v254.543H154.022ZM480 583.239Z"/></svg>
                <p>Home</p>
            </div></a>
            <button class="bt" type="button" onclick="abrirPesquisa()"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M795.761 941.696 531.326 677.5q-29.761 25.264-69.6 39.415-39.84 14.15-85.161 14.15-109.835 0-185.95-76.195Q114.5 578.674 114.5 471t76.196-183.87q76.195-76.195 184.369-76.195t183.87 76.195q75.695 76.196 75.695 184.02 0 43.328-13.641 82.97-13.641 39.641-40.924 74.402L845.5 891.957l-49.739 49.739ZM375.65 662.935q79.73 0 135.29-56.245Q566.5 550.446 566.5 471t-55.595-135.69q-55.595-56.245-135.255-56.245-80.494 0-136.757 56.245Q182.63 391.554 182.63 471t56.228 135.69q56.227 56.245 136.792 56.245Z"/></svg>
                <p>Pesquisa</p>
            </div></button>
            <a href="../store/pedidos.php"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.957 987q-47.377 0-80.374-32.996-32.996-32.997-32.996-80.486V742.652h129.869V171.935l61.235 60.956 60.996-60.956 60.756 60.956 61.235-60.956 60.757 60.956 61.195-60.956 60.957 60.956 61.196-60.956 60.956 60.956 61.674-60.956V873.63q0 47.377-33.066 80.374Q784.281 987 737.043 987H222.957Zm514.206-68.37q19.88 0 32.38-12.513 12.5-12.514 12.5-32.534V281.022H307.587v461.63h384.456V873.63q0 20 12.62 32.5t32.5 12.5ZM360.587 440.457v-60h235.456v60H360.587Zm0 134v-60h235.456v60H360.587Zm328.456-134q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9Zm0 129q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9ZM221.957 918.63h401.956V811.022H177.957v62.608q0 20 12.65 32.5t31.35 12.5Zm-44 0V811.022 918.63Z"/></svg>
                <p>Pedidos</p>
            </div></a>
            <a href="conta.php"><div class="mobnav">
                <svg xmlns="http://www.w3.org/2000/svg"viewBox="0 96 960 960"><path d="M222.957 798.37q62.76-43.522 124.521-66.783 61.761-23.261 132.626-23.261 70.865 0 133.242 23.445 62.376 23.444 124.697 66.599 43.522-54.24 61.663-108.153Q817.848 636.303 817.848 576q0-143.863-96.98-240.856-96.98-96.992-240.826-96.992t-240.868 96.992Q142.152 432.137 142.152 576q0 60.283 18.528 114.139 18.529 53.856 62.277 108.231Zm256.857-190.696q-58.569 0-98.409-40.045-39.84-40.044-39.84-98.456 0-58.412 40.026-98.39 40.026-39.979 98.595-39.979 58.569 0 98.409 40.165 39.84 40.164 39.84 98.576 0 58.412-40.026 98.27-40.026 39.859-98.595 39.859Zm.514 374.304q-83.524 0-157.573-31.928t-129.46-87.333q-55.41-55.406-87.342-129.234-31.931-73.828-31.931-157.769 0-83.671 31.978-157.366 31.978-73.696 87.315-129.033 55.337-55.337 129.177-87.435 73.839-32.098 157.794-32.098 83.671 0 157.366 32.098 73.696 32.098 129.033 87.435 55.337 55.337 87.435 129.085 32.098 73.747 32.098 157.272 0 83.524-32.098 157.6t-87.435 129.413Q711.348 918.022 637.6 950q-73.747 31.978-157.272 31.978Zm-.328-68.13q54.283 0 105.587-15.522t102.304-54.804q-51.239-35.761-102.804-54.163Q533.522 770.957 480 770.957q-53.522 0-104.967 18.402-51.446 18.402-102.685 54.163 51 39.282 102.185 54.804Q425.717 913.848 480 913.848Zm0-369.044q33.251 0 54.408-21.021 21.157-21.022 21.157-54.424t-21.157-54.544Q513.251 393.674 480 393.674q-33.251 0-54.408 21.141-21.157 21.142-21.157 54.544t21.157 54.424q21.157 21.021 54.408 21.021Zm0-75.565Zm.239 373.283Z"/></svg>
                <p>Conta</p>
            </div></a>
        </section>
    
        <?php include ("../store/carrinho.php"); ?>
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
</body>
</html>