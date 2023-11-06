<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

    $cod_cli = $_SESSION['cod_cli'];
    $sql = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
   
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();
   
    $re = $stmc->fetch(PDO::FETCH_ASSOC);
 
 $fk_cod_cli = $cod_cli;

 $sqlend = "SELECT * FROM tb_enderecos WHERE fk_cod_cli = :fk_cod_cli";
 $stmtend = $pdo->prepare($sqlend); 
 $stmtend->bindParam(':fk_cod_cli', $fk_cod_cli);
 $stmtend->execute();
 $rend = $stmtend->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/todos.css">
    <link rel="stylesheet" href="CSS/checkout.css">

</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>
    
        <section class="checkout">
            <h3 class="fin-title">--- Finalizar pedido ---</h3>

            <form action="" method="post">

                <div class="cart-itens">
                    <h1 class="title">Resumo do pedido</h1>
                    <p><span class="name">Combo 10 peças de salmão : </span><span class="price">R$40,00</span></p>
                    <p><span class="name">Combo 10 peças de salmão : </span><span class="price">R$40,00</span></p>
                    <p><span class="name">Combo 10 peças de salmão : </span><span class="price">R$40,00</span></p>
                    <p class="total"><span class="name"> Total do pedido : </span><span class="price">R$120,00</span></p>
                    <a href="carrinho.php" class="btn2">Ver Carrinho</a>
                </div>

                <div class="user-info">
                    <?php
                    if(empty($re['nome_cli'])){ ?>
                    <h1 class="title">Suas informações</h1>
                    <p><i class="fas fa-user"></i><span>Nenhum Adicionado</span></p>
                    <p><i class="fas fa-phone"></i><span>Nenhum Adicionado</span></p>
                    <p><i class="fas fa-envelope"></i><span>Nenhum adicionado</span></p>
                    <a href="login.php" id="perf" class="btn2">Faça Login</a>
                    
                    <?php }else{ ?>
                    <h1 class="title">Suas informações</h1>
                    <p><i class="fas fa-user"></i><span><?php echo $re['nome_cli']; ?></span></p>
                    <p><i class="fas fa-phone"></i><span><?php echo $re['telefone']; ?></span></p>
                    <p><i class="fas fa-envelope"></i><span><?php echo $re['email']; ?></span></p>
                    <a href="perf_atualizar.php" id="perf" class="btn2">Atualizar Perfil</a>
                    <?php } ?>

                    <?php
                    if(empty($rend['rua'])){ ?>
                    <h1 class="title">Seu endereço</h1>
                    <p><i class="fas fa-map-marker-alt"></i><span>Nenhum endereço Adicionado</span></p>
                    <a href="end_cad.php" class="btn2">Adicionar Endereço</a>
                    
                    <?php }else{ ?>
                    <h1 class="title">Seu endereço</h1>
                    <p><i class="fas fa-map-marker-alt"></i><span>Rua <?php echo $rend['rua']?>, <?php echo $rend['numero']?>, <?php echo $rend['bairro']?>, <?php echo $rend['complemento']?>, Cascavel - PR</span></p>
                    <a href="end_atualizar.php" id="end" class="btn2">Atualizar Endereço</a>
                    <?php } ?>

                    <select name="method" class="box" requires>
                        <option value="" disabled selected>Método de pagamento</option>
                        <option value="dinheiro na entrega">Dinheiro na Entrega</option>
                    </select>

                    <input type="submit" value="Finalizar Pedido" class="btn" style="margin-left: 13rem;">
                </div>

            </form>
        </section>

     <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>