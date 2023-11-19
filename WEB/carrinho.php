<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

$valor_tot_p = 0;

if(isset($_GET['prod_id'])){
    $cod_prod = filter_input(INPUT_GET, 'prod_id', FILTER_SANITIZE_NUMBER_INT);

    $sqlp = "SELECT * FROM tb_produtos WHERE cod_prod = :cod_prod";
    $stmtp = $pdo->prepare($sqlp); 
    $stmtp->bindParam(':cod_prod', $cod_prod);
    $stmtp->execute();
    $resultadop = $stmtp->fetch(PDO::FETCH_ASSOC);

    if (!isset($_SESSION['carrinho'][$cod_prod])) {
    $_SESSION['carrinho'][$cod_prod] = array('qtd' => 1, 'cod_prod' => $resultadop['cod_prod'], 'nome' => $resultadop['nome'], 'valor' => $resultadop['valor'], 'descricao' => $resultadop['descricao'], 'img' => $resultadop['img']);
    $_SESSION['frete'] = 30;

    echo "produto adicionado ao carrinho";
    header('Location: carrinho.php');
    }
    else{
        echo "produto já inserido no carrinho";
        header('Location: carrinho.php');
    }    
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/todos.css">
    <link rel="stylesheet" href="CSS/menu.css">
    <link rel="stylesheet" href="CSS/cart.css">

</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>
    
    <!-- carrinho início -->
    <section class="cart">
        <h3 class="cart-title">--- Carrinho ---</h3>
            <div class="tot"><p>Total do carrinho : <span>R$ <?php if(!isset($_SESSION['carrinho'])){?> 0 <?php }else{ echo $_SESSION['valor_tot_p']; }?></span></p></div>
            <div class="cart-total">
                <?php if (!isset($_SESSION['log_user']) || !isset($_SESSION['carrinho'])) { ?><button class="btn2" onclick="return confirm('Precisa Logar / adicionar produtos primeiro');">Finalizar</button>
                <?php } else { ?><a href="finalizar.php" class="btn2">Finalizar</a><?php } ?>
            <a href="menu.php" class="btn2">Adicionar +</a>
            <form action="remover_prod_carrinho.php" method="post">
                <button type="submit" class="btn2" name="delete_all" onclick="return confirm('deletar todos os itens?');">Deletar</button>
            </form>
        </div>

<div class="menu">
    
<?php
if(isset($_SESSION['carrinho']) && !$_SESSION['carrinho'] == 0){

    if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) :
        foreach ($_SESSION['carrinho'] as $key => $resultadop) :
            $valor_tot_p += $resultadop['valor'] * $resultadop['qtd'];
?>
    <div class="pratos">
        <div class="box-container">
            <div class="box">
            <form action="remove_prod_cod.php" method="post">
                <input type="hidden" name="cart_prod_cod" value="<?php echo $resultadop['cod_prod']; ?>">
                <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('deletar esse item?');"></button>
            </form>
            <form action="">
                <img src="<?php echo $resultadop['img']; ?>" alt="">
                <div class="name"><?php echo $resultadop['nome']; ?></div>
                <div class="desc"><?php echo $resultadop['descricao']; ?></div>
                <div class="flex3">
                    <div class="price"><span>R$</span><?php echo $resultadop['valor']; ?></div>
                    <input type="number" name="qtd" class="qtd" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                </div>
            </form>
            </div>
        </div>
<?php
endforeach;

$_SESSION['valor_tot_p'] = $valor_tot_p;
?>
    </div>
</div>

<?php

else : ?>
        <div class="nada"><h1>Nenhum item adicionado ao carrinho!</h1></div>
<?php
endif;

} else{ ?>
        <div class="nada"><h1>Nenhum item adicionado ao carrinho!</h1></div>
<?php } ?>

    </section>
    <!-- carrinho fim -->

    <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>
<?php
?>
