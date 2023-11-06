<?php
if (isset($_SESSION['cod_cli'])) {
    $cod_cli = $_SESSION['cod_cli'];

    $sql = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";

    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();

    $re = $stmc->fetch(PDO::FETCH_ASSOC);
}
?>
<!--Cabeçalho início-->
<?php //include_once 'componentes/header.php'; 
?>

<header class="header">
    <section class="flex">

        <a href="home.php"> <img src="./IMG/logo3.png" alt="logo" class="logo"></a>

        <!-- seção da pág que aponta para outras págs  -->
        <nav class="barranav">
            <a href="home.php">Home</a>
            <a href="sobrenos.php">Sobre nós</a>
            <a href="menu.php">Menu</a>
        </nav>

        <div class="icones">
            <div id="pesquisa-btn" class="fas fa-search"></div>
            <a href="carrinho.php"><i class="fas fa-shopping-cart"></i><span>(3)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="perfil">
            <?php
            if (!isset($_SESSION['log_user'])) {
            ?>
                <p class="name">Faça login</p>
                <p class="conta"><a href="login.php">login</a> ou <a href="cadastro.php">cadastre-se</a></p>
        </div>
        <?php } else { ?>
        <p class="name">
            <?php
                echo $re['nome_cli']; ?></p>
        <div class="flex2">
            <a href="perfil.php" class="btn">Perfil</a>
            <a href="logout.php" class="delete-btn">Sair</a>
        </div>
        <p class="conta"><a href="login.php">login</a> ou <a href="cadastro.php">cadastre-se</a></p>
        <?php
        ?>
        </div><?php } ?>

    <div class="pesquisa">
        <form action="" method="GET">
            <input type="text" placeholder="Pesquise um produto..." name="pesquisa">
            <button type="submit" name="search-btn" class="fas fa-search"></button>
        </form>
    </div>

    <div class="perfil">
    </section>
</header>
<!--Cabeçalho fim-->
<?php
 if (isset($_GET['search-btn'])){
    $pesquisa = $_GET['search-btn'] . "%";

    $sqlpesq = "SELECT *FROM tb_produtos WHERE nome LIKE :pesquisa ";
    $stmpesq = $pdo->prepare($sqlpesq);
    $stmpesq->bindParam(":pesquisa", $pesquisa);
    $stmpesq->execute();

    $resultado = $stmpesq->fetchAll(PDO::FETCH_ASSOC);

    if(count($resultado) > 0){
        echo "Resultado da pesquisa  ";

        foreach ($resultado as $r){
            echo $r['nome']  ;
        }
    }
 }
?>