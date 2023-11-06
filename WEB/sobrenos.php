<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();
 
 $sqlaval = "SELECT * FROM tb_avaliacoes";
 $stmav = $pdo->prepare($sqlaval); 
 $stmav->execute();

 $res = $stmav->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nós</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">

    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/todos.css">

</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>
    
    <div class="about">
        <h3>--- Sobre Nós ---</h3>
    </div>
    
    <div class="batchan">
        <video height="400" autoplay muted src="IMG/vídeo_batian.mp4" ></video>

        <p><br> Nosso restaurante foi criado em homenagem a Mitiko Tsutiya, 
            a batchan (avó em japonês) de Ayumi Agner, com o objetivo de trazer
             pratos da gastronomia japonesa tradicional, com ingredientes mais simples
              e acessíveis, mas igualmente saborosos. 
        <br><img class="img" src="./IMG/s_about.jpg" alt=""> </p>

        <img height="400" src="./IMG/sushi_tradicional.jpeg" alt="">
    </div>

    <div class="map">
        <div class="local">
        <h3>--- Nossa Localização ---</h3> 
        <img class="sushicook" src="IMG/sushi-cook-animate.svg" alt="">
        </div>
        <div id="wrapper-9cd199b9cc5410cd3b1ad21cab2e54d3">
		    <div id="map-9cd199b9cc5410cd3b1ad21cab2e54d3"></div>
            <a href="https://1map.com/pt/map-embed"><img src="IMG/map.png" alt=""></a></div>
    </div>

    <section class="ava">
        <h3>--- Avaliações ---</h3><br><br>
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

    <!--Rodapé-->
    <?php include 'footer.php'; ?>

</body>
<script src="JS/script.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

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

(function () {
        var setting = {"height":350,"width":450,"zoom":17,"queryString":"Rua Natal, 2800 - Recanto Tropical, Cascavel - PR, Brasil","place_id":"EjlSdWEgTmF0YWwsIDI4MDAgLSBSZWNhbnRvIFRyb3BpY2FsLCBDYXNjYXZlbCAtIFBSLCBCcmFzaWwiMRIvChQKEgkt-fu8U9HzlBHaIOwLjY0UuxDwFSoUChIJMc4FnADU85QROAML22mm0I8","satellite":false,"centerCoord":[-24.947217707387296,-53.48371819999999],"cid":"0x478092c7fae703cb","lang":"pt","cityUrl":"/brazil/cascavel-37536","cityAnchorText":"","id":"map-9cd199b9cc5410cd3b1ad21cab2e54d3","embed_id":"933303"};
        var d = document;
        var s = d.createElement('script');
        s.src = 'https://1map.com/js/script-for-user.js?embed_id=933303';
        s.async = true;
        s.onload = function (e) {
          window.OneMap.initMap(setting)
        };
        var to = d.getElementsByTagName('script')[0];
        to.parentNode.insertBefore(s, to);
      })();

</script>
</html>