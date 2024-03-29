<header class="cabeça">
        <div class="container">
            <div class="logotipo"><a href="index.php">Caramel</a></div>
            <nav class="navbusca">
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="busca.php?search=Ração">Ração</a></li>
                    <li><a href="busca.php?search=Petisco">Petiscos</a></li>
                    <li><a href="busca.php?search=Roupa">Roupas</a></li>
                    <li><a href="busca.php?search=Acessório">Acessórios</a></li>
                    <li><a href="busca.php?search=Outros">Outros</a></li>
                </ul>
            </nav>
            <form class="buscar" method="GET" action="busca.php" autocomplete="off">
                <input name="search" id="buscagem" type="text" placeholder="Digite e tecle enter para buscar" onfocusout="abrirPesquisa()"/>
            </form>
            <ul class="buttons">
                <li><a href="../logout.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960" ><path d="M179.761 941.978q-27.698 0-48.034-20.265-20.336-20.266-20.336-47.865V278.152q0-27.697 20.336-48.033 20.336-20.337 48.034-20.337h292.674v68.37H179.761v595.696h292.674v68.13H179.761Zm486.478-182.369-48.978-48.5 101.043-101.044H371.891v-68.13h344.413L615.261 440.891l48.978-48.5L848.609 577l-182.37 182.609Z"/></svg></a></li>
                <li><button type="button" onclick="abrirLateral('#carrinho');abrirFundo('#total');"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.152 980.065q-27.599 0-47.865-20.266-20.265-20.265-20.265-47.864V399.109q0-27.698 20.265-48.034 20.266-20.336 47.865-20.336h103.783v-10q.478-64.196 45.131-108.413 44.654-44.217 108.892-44.217t108.933 44.217q44.696 44.217 45.174 108.413v10h103.783q27.697 0 48.033 20.336 20.337 20.336 20.337 48.034v512.826q0 27.599-20.337 47.864-20.336 20.266-48.033 20.266H222.152Zm0-68.13h515.696V399.109H634.065v85.695q0 14.663-9.871 24.484-9.871 9.821-24.369 9.821-14.499 0-24.195-9.821-9.695-9.821-9.695-24.484v-85.695h-171.87v85.695q0 14.663-9.871 24.484-9.871 9.821-24.369 9.821-14.499 0-24.195-9.821-9.695-9.821-9.695-24.484v-85.695H222.152v512.826Zm172.152-581.196h171.392v-10q-.479-35.609-25.187-60.054-24.708-24.446-60.532-24.446-35.825 0-60.51 24.446-24.684 24.445-25.163 60.054v10ZM222.152 911.935V399.109v512.826Z"/></svg></button></li>
                <li class="pedidos"><a href="pedidos.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M222.957 987q-47.377 0-80.374-32.996-32.996-32.997-32.996-80.486V742.652h129.869V171.935l61.235 60.956 60.996-60.956 60.756 60.956 61.235-60.956 60.757 60.956 61.195-60.956 60.957 60.956 61.196-60.956 60.956 60.956 61.674-60.956V873.63q0 47.377-33.066 80.374Q784.281 987 737.043 987H222.957Zm514.206-68.37q19.88 0 32.38-12.513 12.5-12.514 12.5-32.534V281.022H307.587v461.63h384.456V873.63q0 20 12.62 32.5t32.5 12.5ZM360.587 440.457v-60h235.456v60H360.587Zm0 134v-60h235.456v60H360.587Zm328.456-134q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9Zm0 129q-12 0-21-9t-9-21q0-12 9-21t21-9q12 0 21 9t9 21q0 12-9 21t-21 9ZM221.957 918.63h401.956V811.022H177.957v62.608q0 20 12.65 32.5t31.35 12.5Zm-44 0V811.022 918.63Z"/></svg></a></li>
                <li class="conta"><a href="../usuario/conta.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 96 960 960"><path d="M479.951 571.891q-68.679 0-112.304-43.625t-43.625-112.305q0-68.679 43.625-112.353 43.625-43.674 112.304-43.674t112.473 43.674q43.794 43.674 43.794 112.353 0 68.68-43.794 112.305t-112.473 43.625ZM154.022 905.087V804.68q0-39.557 19.915-68.042 19.915-28.486 51.433-43.268 67.478-30.24 129.685-45.359 62.208-15.12 124.881-15.12 63.131 0 124.793 15.62 61.662 15.619 128.822 45.053 32.882 14.594 52.774 42.993 19.893 28.4 19.893 68.06v100.47H154.022Zm68.13-68.13h515.696v-31.37q0-15.845-9.5-30.219-9.5-14.373-23.5-21.303-63.044-30.282-115.445-41.543-52.401-11.261-109.521-11.261-56.643 0-110.284 11.261-53.641 11.261-115.343 41.506-14.103 6.932-23.103 21.316-9 14.384-9 30.243v31.37Zm257.799-333.196q38.092 0 62.995-24.866 24.902-24.865 24.902-62.974 0-38.207-24.854-63.031-24.853-24.825-62.945-24.825t-62.995 24.836q-24.902 24.835-24.902 62.902 0 38.165 24.854 63.061 24.853 24.897 62.945 24.897Zm.049-87.848Zm0 421.044Z"/></svg></a></li> 
            </ul>
        </div>
    </header>