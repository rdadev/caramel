<?php
    include("../sources/config.php");

    $avisos = $conn -> prepare("SELECT * FROM tbl_avisos");
    $avisos -> execute();
?>
        
        <section id="avisos" class="lateral">
            <div class="fechar"><span>Avisos</span><button type="button" onclick="fecharLateral()"><svg xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 96 960 960" width="28"><path d="m249 873-66-66 231-231-231-231 66-66 231 231 231-231 66 66-231 231 231 231-66 66-231-231-231 231Z"/></svg></button></div>
            <div class="conteudo">
                <?php
                    if ($avisos ->rowCount() > 0) {
                        while($aviso = $avisos -> fetch()){ 
                            echo("
                            <div class='cartoes'>
                                <h3>".$aviso["NM_AVISO"]."</h3>
                                <p>".$aviso["DS_AVISO"]."</p>
                            </div>
                            ");
                        };
                    };
                ?>
            </div>
        </section>