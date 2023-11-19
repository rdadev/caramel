<?php
    session_start();
    if(!isset($_SESSION["SSO_LOJISTA_CARAMEL"])){
        header("location: login.php");
    };

    if(isset($_POST["turno"])) {
        include("../sources/config.php");
        $usuario = $_SESSION["SSO_LOJISTA_CARAMEL"];

        $consulta_turno = $conn -> prepare("SELECT tbl_lojistas.ID_LOJA, tbl_lojas.ST_TURNO_LOJA FROM tbl_lojistas, tbl_lojas WHERE tbl_lojas.ID_LOJA = tbl_lojistas.ID_LOJA AND tbl_lojistas.ID_LOJISTA = :id");
        $consulta_turno -> bindValue(":id", $usuario);
        $consulta_turno -> execute();
        $loja = $consulta_turno -> fetch();

        // EXECUTA O TOGGLE (MUDANCA) NO DB
        if ($loja["ST_TURNO_LOJA"] == 1) {
            $altera_turno = $conn -> prepare("UPDATE tbl_lojas SET ST_TURNO_LOJA = 0 WHERE ID_LOJA = :id");
            $altera_turno -> bindValue(":id", $loja["ID_LOJA"]);
            $altera_turno -> execute();
            header("location: dashboard.php");
        } else {
            $altera_turno = $conn -> prepare("UPDATE tbl_lojas SET ST_TURNO_LOJA = 1 WHERE ID_LOJA = :id");
            $altera_turno -> bindValue(":id", $loja["ID_LOJA"]);
            $altera_turno -> execute();
            header("location: dashboard.php");
        };
    };
?>