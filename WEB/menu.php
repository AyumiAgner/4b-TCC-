<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $sqlp = "SELECT * FROM tb_produtos";
 $stmtp = $pdo->prepare($sqlp); 
 $stmtp->execute();
 $resultadop = $stmtp->fetchAll(PDO::FETCH_ASSOC);

 $sql = "SELECT * FROM tb_categorias";
 $stmt = $pdo->prepare($sql); 
 $stmt->execute();
 //BUSCANDO TODAS AS LINHAS DA TABELA
 $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="./CSS/todos.css">
    <link rel="stylesheet" href="./CSS/menu.css">
</head>
<body>
   <!--Cabeçalho-->
   <?php include_once 'header.php'; ?>
   
    <!-- menu início -->
    <section class="menu">

        <?php foreach($resultado as $re){?>
            <h3 id="frios"><?php echo $re['nome']; ?></h3>

        <?php foreach($resultadop as $r){
            if ($r['ativo'] == 'S'){
            if($re['cod_cat'] == $r['fk_cod_cat']){ ?>
            <div class="pratos">
                <div class="box-container">
                    <form action="" method="post" class="box">
                        <!-- <button type="submit" class="fas fa-eye" name="quick_view"></button> -->
                        <a href="carrinho.php?prod_id=<?php echo $r['cod_prod']; ?>" class="fas fa-shopping-cart" name="add_to_cart"></a>
                        <img src="<?php echo $r['img']; ?>" alt="">
                        <div class="name"><?php echo $r['nome']; ?></div>
                        <div class="desc"><?php echo $r['descricao']; ?></div>
                        <div class="flex3">
                            <div class="price"><span>R$</span><?php echo $r['valor']; ?></div>
                        </div>
                    </form>
            <?php } } ?>
                </div>
        <?php } ?>
            </div>
        <?php } ?>      
    </section>
    <!-- menu fim -->

    <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>