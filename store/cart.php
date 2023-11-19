<?php
    session_start();
    if(!isset($_SESSION["SSO_USUARIO_CARAMEL"])){
        header("location: ../usuario/login.php");
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

<body>
</body>

<?php
    include("../sources/config.php");

    if (isset($_POST["adicionar_carrinho"])) {
        $produto = $_POST["id_produto"];
        $quantidade = $_POST["quantidade"];
        $petshop = $_POST["id_petshop"];
        $pagina = $_POST["pg"];
        $usuario = $_SESSION["SSO_USUARIO_CARAMEL"];

        $pet = $conn -> prepare("SELECT * FROM tbl_carrinho WHERE ID_USUARIO = :usuario");
        $pet -> bindValue(":usuario", $usuario);
        $pet -> execute();

        if($pet -> rowCount() != 0) {
            $pets = $pet -> fetch();
            $loja_carrinho = $pets["ID_LOJA"];
    
                if ($petshop != $loja_carrinho) {
                    echo ("
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Compra em outra loja',
                            text: 'É permitido somente adicionar produtos da mesma loja no carrinho, remova os produtos ou continue o pedido com a loja atual',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace('petshop.php?id=".$pets["ID_LOJA"]."');
                            };
                        })
                    </script>");
                    } else {
                        if ($_POST["pg"] == 0) {
                            $sql = $conn -> prepare("INSERT INTO tbl_carrinho (ID_PRODUTO, ID_LOJA, ID_USUARIO, QT_CARRINHO) VALUES (:produto, :loja, :usuario, :quantidade);");
                            $sql -> bindValue(":produto", $produto);
                            $sql -> bindValue(":loja", $petshop);
                            $sql -> bindValue(":usuario", $usuario);
                            $sql -> bindValue(":quantidade", $quantidade);
                            $sql -> execute();
                
                            echo ("
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Produto adicionado ao carrinho',
                                    text: 'O produto foi adicionado ao carrinho, para finalizar a compra clique no icone do carrinho.',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'OK',
                                    denyButtonText: `Don't save`,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.replace('petshop.php?id=".$petshop."');
                                    };
                                })
                            </script>");
                            } else {
                                $sql = $conn -> prepare("INSERT INTO tbl_carrinho (ID_PRODUTO, ID_LOJA, ID_USUARIO, QT_CARRINHO) VALUES (:produto, :loja, :usuario, :quantidade);");
                                $sql -> bindValue(":produto", $produto);
                                $sql -> bindValue(":loja", $petshop);
                                $sql -> bindValue(":usuario", $usuario);
                                $sql -> bindValue(":quantidade", $quantidade);
                                $sql -> execute();
                    
                                echo ("
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Produto adicionado ao carrinho',
                                        text: 'O produto foi adicionado ao carrinho, para finalizar a compra clique no icone do carrinho.',
                                        showDenyButton: false,
                                        showCancelButton: false,
                                        confirmButtonText: 'OK',
                                        denyButtonText: `Don't save`,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.replace('index.php');
                                        };
                                    })
                                </script>");
                };
            };
        } else {
            if ($_POST["pg"] == 0) {
                $sql = $conn -> prepare("INSERT INTO tbl_carrinho (ID_PRODUTO, ID_LOJA, ID_USUARIO, QT_CARRINHO) VALUES (:produto, :loja, :usuario, :quantidade);");
                $sql -> bindValue(":produto", $produto);
                $sql -> bindValue(":loja", $petshop);
                $sql -> bindValue(":usuario", $usuario);
                $sql -> bindValue(":quantidade", $quantidade);
                $sql -> execute();
    
                echo ("
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Produto adicionado ao carrinho',
                        text: 'O produto foi adicionado ao carrinho, para finalizar a compra clique no icone do carrinho.',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        denyButtonText: `Don't save`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace('petshop.php?id=".$petshop."');
                        };
                    })
                </script>");
                } else {
                    $sql = $conn -> prepare("INSERT INTO tbl_carrinho (ID_PRODUTO, ID_LOJA, ID_USUARIO, QT_CARRINHO) VALUES (:produto, :loja, :usuario, :quantidade);");
                    $sql -> bindValue(":produto", $produto);
                    $sql -> bindValue(":loja", $petshop);
                    $sql -> bindValue(":usuario", $usuario);
                    $sql -> bindValue(":quantidade", $quantidade);
                    $sql -> execute();
        
                    echo ("
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Produto adicionado ao carrinho',
                            text: 'O produto foi adicionado ao carrinho, para finalizar a compra clique no icone do carrinho.',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace('index.php');
                            };
                        })
                    </script>");
                };
        };

    } else if (isset($_POST["remover_produto"])) {
        $id = $_POST["id"];
        $sql = $conn -> prepare("DELETE FROM tbl_carrinho WHERE ID_CARRINHO = :id");
        $sql -> bindValue(":id", $id);
        $sql -> execute();
        echo ("<script>Swal.fire({icon: 'success',title: 'Produto removido do carrinho',text: 'O produto foi removido do carrinho, para finalizar a compra clique no icone do carrinho.',showDenyButton: false,showCancelButton: false,confirmButtonText: 'OK',denyButtonText: `Don't save`,}).then((result) => {if (result.isConfirmed) {window.location.replace('index.php');};})</script>");

    } else if (isset($_POST["editar_carrinho"])) {
        $id = $_POST["id"];
        $quantidade = $_POST["quantidade"];

        $sql = $conn -> prepare("UPDATE tbl_carrinho SET QT_CARRINHO = :quantidade WHERE ID_CARRINHO = :id");
        $sql -> bindValue(":id", $id);
        $sql -> bindValue(":quantidade", $quantidade);
        $sql -> execute();
        echo ("<script>Swal.fire({icon: 'success',title: 'Alteração realizada',text: 'O produto foi alterado no carrinho, para finalizar a compra clique no icone do carrinho.',showDenyButton: false,showCancelButton: false,confirmButtonText: 'OK',denyButtonText: `Don't save`,}).then((result) => {if (result.isConfirmed) {window.location.replace('index.php');};})</script>");

    } else {
        echo("<script>window.location.replace('index.php');</script>");
    };

?>

</html>