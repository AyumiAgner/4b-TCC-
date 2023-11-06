<?php
 if(isset($_SESSION['cod_cli'])){
    $cod_cli = $_SESSION['cod_cli'];

    $sql = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
   
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();
   
    $re = $stmc->fetch(PDO::FETCH_ASSOC);
 }
?>
<!--Cabeçalho início-->
<header class="header">
        <section class="flex">
            <a href="a_home.php"> <img src="./IMG/logo3.png" alt="logo" class="logo"></a>

            <!--seção da pág que aponta para outras págs-->
            <nav class="barranav">
                <a href="a_home.php">Home</a>
                <a href="a_produtos_cad.php">Produtos</a>
                <a href="a_cadastro_adm.php">Adm</a>
                <a href="a_cliente_adm.php">Clientes</a>
                <a href="a_pedidos.php">Pedidos</a>
                <a href="a_avaliacoes.php">Avaliações</a>
            </nav>

            <div class="perfil">
                <p class="name"><?php echo $re['nome_cli'];?></p>
                    <a href="a_cadastro_adm.php" class="adm">Admin</a>
                    <a href="logout.php" class="sair">Sair</a>
            </div>

            <div class="pesquisa">
                <form action="" method="post">
                    <input type="text" placeholder="Pesquise um produto..." name="pesquisa" class="pesq">
                    <button type="submit" name="search-btn" class="fas fa-search"></button>
                </form>
            </div>
        </section>
    </header>
    <!--Cabeçalho fim-->