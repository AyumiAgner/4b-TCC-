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

 $sqlcompra = "SELECT * FROM tb_compras";
 $stmtcompra = $pdo->prepare($sqlcompra); 
 $stmtcompra->execute();
 $recompra = $stmtcompra->fetchAll(PDO::FETCH_ASSOC);

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
                    <?php foreach ($_SESSION['carrinho'] as $key => $resultadop){ ?>
                    <p><span class="name"><?php echo $resultadop['nome']; ?> : </span><span class="price">R$ <?php echo $resultadop['valor']; ?></span></p>
                    <?php } ?>
                    <p><span class="name">Taxa de entrega : </span><span class="price">R$ <?php echo $_SESSION['frete']?></span></p>
                    <p class="total"><span class="name"> Total do pedido : </span><span class="price">R$ <?php echo $_SESSION['valor_tot_p']+$_SESSION['frete']?></span></p>
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
                    
                    <select name="method" class="box" requires>
                        <option value="" disabled selected>Método de pagamento</option>
                        <option value="dinheiro na entrega">Dinheiro na Entrega</option>
                    </select>

                    <button class="btn" onclick="return confirm('Precisa adicionar o endereço primeiro');" style="margin-left: 13rem;">Finalizar Pedido</button>

                    <?php }else{ ?>
                    <h1 class="title">Seu endereço</h1>
                    <p><i class="fas fa-map-marker-alt"></i><span>Rua <?php echo $rend['rua']?>, <?php echo $rend['numero']?>, <?php echo $rend['bairro']?>, <?php echo $rend['complemento']?>, Cascavel - PR</span></p>
                    <a href="end_atualizar.php" id="end" class="btn2">Atualizar Endereço</a>

                    <select name="method" class="box" requires>
                        <option disabled selected>Método de pagamento</option>
                        <option value="dinheiro na entrega">Dinheiro na Entrega</option>
                    </select>

                    <input type="submit" name="finalizar" value="Finalizar Pedido" class="btn" style="margin-left: 13rem;">
                    <?php } ?>

                </div>

            </form>
        </section>

     <!--Rodapé-->
</body>
<script src="JS/script.js"></script>
</html>
<?php
if (isset($_POST['finalizar'])) {
    $status_pedido = 'Confirmado';
    $forma_pagamento = $_POST['method'];
    $valor_entrega = $_SESSION['frete'];
    $fk_tb_cliente = $cod_cli;
    $cod_compra = count($recompra) == 0 ? 1 : count($recompra) + 1;

    $data_compra = date('Y/m/d');
    $data_compra = str_replace("/", "-", $data_compra);

    try {
        if (empty($forma_pagamento)) {
            echo "necessário adicionar a forma de pagamento";
            exit();
        }
        else{
            $sqlcomp = "INSERT INTO tb_compras (status_pedido, data_compra, forma_pagamento, valor_entrega, fk_tb_cliente) VALUES (:status_pedido, :data_compra, :forma_pagamento, :valor_entrega, :fk_tb_cliente)";
            $compra = $pdo->prepare($sqlcomp); 
            $compra->bindParam(':status_pedido', $status_pedido);
            $compra->bindParam(':data_compra', $data_compra);
            $compra->bindParam(':forma_pagamento', $forma_pagamento);
            $compra->bindParam(':valor_entrega', $valor_entrega);
            $compra->bindParam(':fk_tb_cliente', $fk_tb_cliente);
            $compra->execute();
        
            foreach ($_SESSION['carrinho'] as $key => $resultadop):
                $sqlcart = "INSERT INTO tb_compra_prod (valor_prod, fk_cod_compra, fk_cod_prod, qtd) VALUES (:valor_prod, :fk_cod_compra, :fk_cod_prod, :qtd)";
                $cart = $pdo->prepare($sqlcart); 
                $cart->bindParam(':valor_prod', $resultadop['valor']);
                $cart->bindParam(':fk_cod_compra', $cod_compra);
                $cart->bindParam(':fk_cod_prod', $resultadop['cod_prod']);
                $cart->bindParam(':qtd', $resultadop['qtd']);
                $cart->execute();
            endforeach;
                
                unset($_SESSION['carrinho']);
                unset($_SESSION['frete']);
    
                header('Location: pedidos.php');
        }
    } catch(Exception $e) {
          $e == 'echo"erro ao finalizar o carrinho"';
    }
}
?>