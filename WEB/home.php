<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();
 
 $sql = "SELECT * FROM tb_categorias";
 $stmt = $pdo->prepare($sql); 
 $stmt->execute();
 //BUSCANDO TODAS AS LINHAS DA TABELA
 $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

 $sqlaval = "SELECT * FROM tb_avaliacoes";
 $stmav = $pdo->prepare($sqlaval); 
 $stmav->execute();

 $res = $stmav->fetchAll(PDO::FETCH_ASSOC);
 
 $sqlp = "SELECT * FROM tb_produtos";
 $stmtp = $pdo->prepare($sqlp); 
 $stmtp->execute();
 $resultadop = $stmtp->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!--link da fonte-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    
    <!--link do image slider e slide show-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    
    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/todos.css">
</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>
      
    <!--slide-show e image-swiper-->
    <div class="container">
        <div class="w3-content w3-section">
            <img class="mySlides w3-animate-left" src="IMG/1.png" alt="imagem1">
            <img class="mySlides w3-animate-top" src="IMG/2.png" alt="imagem2">
            <img class="mySlides w3-animate-right" src="IMG/3.png" alt="imagem3">
        </div>
    </div>

    <section class="sug">
        <h1 class="sugestion"><b>--- Sugestões da Batchan ---</b></h1>
            <div class="swiper sugestions-slider">
                <div class="swiper-wrapper">
                    <?php foreach($resultadop as $resp){
                        if ($resp['ativo'] == 'S'){?>
                    <div class="swiper-slide image" >
                        <img class="item" src="<?php echo $resp['img']; ?>" alt="" >
                        <div class="content">
                            <h1 class="food-price">R$ <?php echo $resp['valor']; ?></h1>
                            <p class="food-desc"><?php echo $resp['descricao']; ?></p>
                            <form action="GET"><button class="cart-btn" name="add_to_cart"><a href="carrinho.php?prod_id=<?php echo $resp['cod_prod']; ?>">Adicionar ao Carrinho</a></button></form>
                            <div class="content-bottom">
                                <h2 class="food-name"><?php echo $resp['nome']; ?></h2>  
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
                <br><br><div class="swiper-pagination controls"></div>
            </div>   
            <p id="menu">Veja mais opções em nosso <a href="menu.php">Menu</a></p>
    </section>
    <!--slide-show e image-swiper-->

    <!--categorias início-->
    <section class="category">
        <h1 class="title"><b>---Categorias---</b></h1>
        <div class="box-container">
            <?php foreach($resultado as $r){?>
            <a href="menu.php" class="box">
                <h3 class="cat"><b><?php echo $r['nome']; ?></b></h3>
            </a>
            <?php } ?>
        </div>
    </section>
    <!--categorias fim-->

    <!--avaliações início-->

    <section class="ava">
        <h3><b>--- Avaliações ---</b></h3>
        <div class="swiper reviews-slider">
            <div class="swiper-wrapper">
                
                <?php foreach($res as $aval){
                $claval = "SELECT tb_clientes.nome_cli, tb_clientes.img FROM tb_avaliacoes RIGHT JOIN tb_clientes ON tb_clientes.cod_cli = tb_avaliacoes.fk_cod_cl WHERE cod_aval = :cod_aval";
                $stmav = $pdo->prepare($claval);
                $stmav->bindParam(':cod_aval', $aval['cod_aval']);
                $stmav->execute();

                $r = $stmav->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="swiper-slide slide">
                   <img src="<?php  echo $r['img'] ? $r['img'] :"IMG/logo3.png"; ?>" alt="">
                    <p><?php echo $aval['descricao']; ?></p>
                    <h1><?php echo $r['nome_cli']; ?></h1>
                </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!--avaliações fim-->

    <!--Rodapé-->
    <?php include 'footer.php'; ?>
    
</body>
<!--script image slider-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="JS/script.js"></script>

<script>
var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor:true,
            spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
   },
   breakpoints: {
      550: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

var swiper = new Swiper(".sugestions-slider", {
   loop:true,
   grabCursor:true,
            spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 6,
      },
   },
});

var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 4000);    
}
</script>
</html>