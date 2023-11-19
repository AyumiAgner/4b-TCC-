<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 if(isset($_SESSION['cod_cli'])){
    $cod_cli = $_SESSION['cod_cli'];

    $sql = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
   
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();
   
    $re = $stmc->fetchAll(PDO::FETCH_ASSOC);
 }

 $sqlaval = "SELECT * FROM tb_avaliacoes";
 $stmav = $pdo->prepare($sqlaval); 
 $stmav->execute();
 $res = $stmav->fetchAll(PDO::FETCH_ASSOC);

 $sqla = "SELECT count(*) FROM tb_avaliacoes";
 $stma = $pdo->prepare($sqla); 
 $stma->execute();
 $n = $stma->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliações</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="CSS/a_pedidos.css">

</head>
<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
<section class="avaliacoes1">
    <div class="avaliacoes">
        <div class="image">
            <img src="IMG/Customer Survey-cuate.svg">
        </div>
    
        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Avaliações de clientes</h1>
                </div>
            </div>

            <div class="content">
                <p class="tot">Total de Avaliações realizados: <span class="total"><?php echo $n; ?></span></p>   
            </div> 
        </div>
    </div>

    <div class="avaliacoes2">
        <?php foreach($res as $aval){
            $claval = "SELECT tb_clientes.nome_cli, tb_clientes.img FROM tb_avaliacoes RIGHT JOIN tb_clientes ON tb_clientes.cod_cli = tb_avaliacoes.fk_cod_cl WHERE cod_aval = :cod_aval";
            $stmav = $pdo->prepare($claval);
            $stmav->bindParam(':cod_aval', $aval['cod_aval']);
            $stmav->execute();

            $r = $stmav->fetch(PDO::FETCH_ASSOC);
            ?>
        <div class="aval">
            <img src="<?php  echo $r['img'] ? $r['img'] :"IMG/logo3.png"; ?>" alt="">
            <p><?php echo $aval['descricao']; ?> -  Ativo: <?php echo $aval['ativo']; ?></p>
            <h1><?php echo $r['nome_cli']; ?></h1><br>
            <a href="excaval.php?cod_aval= <?php echo $aval['cod_aval']; ?>" class="btn2" onclick="return confirm('Excluir esse cliente?');">Excluir</a>
            <a href="altaval.php?cod_aval= <?php echo $aval['cod_aval']; ?>" class="btn2">Alterar</a>
        </div>
        <?php } ?>
    </div>
</section>    
     <!--Rodapé início-->
     <footer class="footer">
        <div class="credit">Criado por Ayumi Agner e Rayssa dos Reis</div>
    </footer>
    <!--Rodapé fim-->
</body>
<script src="JS/script.js"></script>
</html>
<?php 
?>