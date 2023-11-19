<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

if (isset($_SESSION['cod_cli'])) {
    $cod_cli = $_SESSION['cod_cli'];

    $sql = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";

    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();

    $re = $stmc->fetch(PDO::FETCH_ASSOC);
}

 if (isset($_GET['search-btn'])){
    $pesquisa = $_GET['pesquisa'] . "%";

    $sqlpesq = "SELECT *FROM tb_produtos WHERE nome LIKE :pesquisa ";
    $stmpesq = $pdo->prepare($sqlpesq);
    $stmpesq->bindParam(":pesquisa", $pesquisa);
    $stmpesq->execute();

    $resultado = $stmpesq->fetchAll(PDO::FETCH_ASSOC);

 }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/todos.css">
    <link rel="stylesheet" href="CSS/a_pedidos.css">
    <link rel="stylesheet" href="CSS/menu.css">

</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>

    <section class="menu">
    <h3 class="cart-title">--- Resultado da pesquisa ---</h3>
    <?php
   if(count($resultado) > 0){

    foreach ($resultado as $r){ 
        if ($r['ativo'] == 'S'){?>
        <div class="pratos">
                <div class="box-container">
                    <form action="" method="post" class="box">
                        <a href="carrinho.php?prod_id=<?php echo $r['cod_prod']; ?>" class="fas fa-shopping-cart" name="add_to_cart"></a>
                        <img src="<?php echo $r['img']; ?>" alt="">
                        <div class="name"><?php echo $r['nome']; ?></div>
                        <div class="desc"><?php echo $r['descricao']; ?></div>
                        <div class="flex3">
                            <div class="price"><span>R$</span><?php echo $r['valor']; ?></div>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php }
    else{?>
    <div class="nada"><h1 class="oi"><br><br> Não encontramos nenhum resultado! <br><br><br><br></h1></div>
    <?php } ?>
    </section>

     <!--Rodapé-->
     <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>