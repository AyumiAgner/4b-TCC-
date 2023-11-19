<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_cli = $_SESSION['cod_cli'];
    $sqlc = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
    $stmc = $pdo->prepare($sqlc);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();
    $re = $stmc->fetch(PDO::FETCH_ASSOC);

 if (isset($_SESSION['log_user'])){
    $sql = "SELECT * FROM tb_compras WHERE fk_tb_cliente = :cod_cliente";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cod_cliente', $cod_cli);
    $stmt->execute();
    $compra = $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 $sqlend = "SELECT * FROM tb_enderecos WHERE fk_cod_cli = :fk_cod_cli";
 $stmtend = $pdo->prepare($sqlend); 
 $stmtend->bindParam(':fk_cod_cli', $cod_cli);
 $stmtend->execute();
 $rend = $stmtend->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="./CSS/todos.css">
    <link rel="stylesheet" href="./CSS/a_pedidos.css">
</head>
<body>
   <!--Cabeçalho-->
   <?php include_once 'header.php'; ?>
   
<section class="orders">
    <h3 class="cart-title">--- Pedidos ---</h3>
    <div class="boxcontainer">
        <?php if(count($compra) > 0){ 
            foreach($compra as $compra){  
                $sqlcomp = "SELECT * FROM tb_compra_prod INNER JOIN tb_compras ON tb_compras.cod_compra = tb_compra_prod.fk_cod_compra WHERE cod_compra = :codCompra";
                $stmtCompra = $pdo->prepare($sqlcomp);
                $stmtCompra->bindParam(':codCompra', $compra['cod_compra']);
                $stmtCompra->execute();
                $dadosCompras = $stmtCompra->fetchAll(PDO::FETCH_ASSOC);
                ?>   
        <div class="box">
            <p>Pedido realizado em : <span> <?php echo $compra['data_compra']; ?></span></p>
            <p>Nome : <span><?php echo $re['nome_cli']; ?></span></p>
            <p>Telefone : <span><?php echo $re['telefone']; ?></span></p>
            <p>Email : <span><?php echo $re['email']; ?></span></p>
            <p>Endereço : <span>Rua <?php echo $rend['rua']?>, <?php echo $rend['numero']?>, <br><?php echo $rend['bairro']?>, <?php echo $rend['complemento']?>,<br> Cascavel - PR</span></p>
            <p class="ppp">Seus pedidos : <span>
                <?php foreach($dadosCompras as $dados) {
                $sqlp = "SELECT * FROM tb_produtos INNER JOIN tb_compra_prod ON tb_compra_prod.fk_cod_prod = tb_produtos.cod_prod WHERE fk_cod_prod = :codP";
                $stmtP = $pdo->prepare($sqlp);
                $stmtP->bindParam(":codP", $dados['fk_cod_prod']);
                $stmtP->execute();
                $resultadop = $stmtP->fetch(PDO::FETCH_ASSOC);
                echo $resultadop['nome']; ?> x <?php echo $resultadop['qtd']; ?> = R$ <?php echo $resultadop['valor_prod']; ?><br> 
                <?php }; ?>
            <p>Taxa de entrega: <span>R$<?php echo $compra['valor_entrega']; ?></span></p>
            <p>Valor total: <span>R$<?php echo $resultadop['valor_prod'] + $compra['valor_entrega']; ?></span></p>
            <p>Forma de pagamento : <span><?php echo $compra['forma_pagamento']?></span></p>
            <p>Status do pedido : <span style="color: var(--lightred); text-decoration: underline;"><?php echo $compra['status_pedido']?></span></p>
        </div>
        <?php };
             } 
        else{ ?>
            <div class="nada"><h1>Nenhuma compra realizado ainda! <br><br>Por favor de uma olhada em nosso menu <br><br><a href="menu.php" class="delete-btn">Menu</a></h1></div>
        <?php } ?>
    </div>
</section>


    <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>