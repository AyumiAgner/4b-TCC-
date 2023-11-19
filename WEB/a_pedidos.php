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

 $sql = "SELECT * FROM tb_compras";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $compra = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlcomp = "SELECT count(*) FROM tb_compras";
    $stmtcomp = $pdo->prepare($sqlcomp);
    $stmtcomp->execute();
    $ncomp = $stmtcomp->fetchColumn();
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
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="CSS/a_pedidos.css">

</head>
<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
    <section class="pedidos1">
        <div class="pedidos">
            <div class="image">
                <img src="IMG/Take Away-rafiki.svg">
            </div>
            
            <div class="ped">
                <div class=" ped-header">
                    <div class="title">
                        <h1>Pedidos Realizados</h1>
                    </div>
                </div>

                <div class="content">
                    <p class="tot">Total de pedidos realizados: <span class="total"><?php echo $ncomp; ?></span></p>   
                    <p>Pendentes: <span>2</span></p> 
                    <p>Fazendo: <span>0</span></p>  
                    <p>Finalizados: <span>0</span></p>
                </div> 
            </div>
        </div>

        <div class="boxcontainer">
        <?php if(count($compra) > 0){ 
            foreach($compra as $compra){  
                $sqlcomp = "SELECT * FROM tb_compra_prod INNER JOIN tb_compras ON tb_compras.cod_compra = tb_compra_prod.fk_cod_compra WHERE cod_compra = :codCompra";
                $stmtCompra = $pdo->prepare($sqlcomp);
                $stmtCompra->bindParam(':codCompra', $compra['cod_compra']);
                $stmtCompra->execute();
                $dadosCompras = $stmtCompra->fetchAll(PDO::FETCH_ASSOC);

                $sqlcli = "SELECT * FROM tb_clientes INNER JOIN tb_compras ON tb_compras.fk_tb_cliente = tb_clientes.cod_cli WHERE fk_tb_cliente = :fk_tb_cliente";
                $stmtcli = $pdo->prepare($sqlcli);
                $stmtcli->bindParam(":fk_tb_cliente", $compra['fk_tb_cliente']);
                $stmtcli->execute();
                $cliente = $stmtcli->fetch(PDO::FETCH_ASSOC);

                $sqlend = "SELECT * FROM tb_clientes INNER JOIN tb_enderecos ON tb_enderecos.fk_cod_cli = tb_clientes.cod_cli WHERE fk_cod_cli = :fk_cod_cli";
                $stmtend = $pdo->prepare($sqlend);
                $stmtend->bindParam(":fk_cod_cli", $compra['fk_tb_cliente']);
                $stmtend->execute();
                $rend = $stmtend->fetch(PDO::FETCH_ASSOC);
                ?>   
        <div class="box">
            <p>Pedido realizado em : <span> <?php echo $compra['data_compra']; ?></span></p>
            <p>Nome : <span><?php echo $cliente['nome_cli']; ?></span></p>
            <p>Telefone : <span><?php echo $cliente['telefone']; ?></span></p>
            <p>Email : <span><?php echo $cliente['email']; ?></span></p>
            <p>Endereço : <br> <span>Rua <?php echo $rend['rua']?>, <?php echo $rend['numero']?>, <br><?php echo $rend['bairro']?>, <?php echo $rend['complemento']?>,<br> Cascavel - PR</span></p>
            <p>Pedidos : <br><span>
                <?php foreach($dadosCompras as $dados) {
                $sqlp = "SELECT * FROM tb_produtos INNER JOIN tb_compra_prod ON tb_compra_prod.fk_cod_prod = tb_produtos.cod_prod WHERE fk_cod_prod = :codP";
                $stmtP = $pdo->prepare($sqlp);
                $stmtP->bindParam(":codP", $dados['fk_cod_prod']);
                $stmtP->execute();
                $resultadop = $stmtP->fetch(PDO::FETCH_ASSOC);
                echo $resultadop['nome']; ?> X <?php echo $resultadop['qtd']; ?> = <?php echo $resultadop['valor_prod']; ?><br> 
                <?php }; ?>
            <p>Taxa de entrega: <span>R$<?php echo $compra['valor_entrega']; ?></span></p>
            <p>Valor total: <span>R$<?php echo $resultadop['valor_prod'] + $compra['valor_entrega']; ?></span></p>
            <p>Forma de pagamento : <br> <span><?php echo $compra['forma_pagamento']?></span></p>
            <p>Status do pedido : <br> <span><?php echo $compra['status_pedido']?> - <a href="altpedido.php?cod_compra= <?php echo $compra['cod_compra']; ?>" class="btn2">Alterar</a></span></p>
        </div>
        <?php };
             } 
        else{ ?>
            <div class="nada"><h1>Nenhuma compra realizado ainda!</h1></div>
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