<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();
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
            <div class="tot"><p>Total do carrinho : <span>R$ 120,00</span></p></div>
            <div class="cart-total">
            <a href="finalizar.php" class="btn2">Finalizar</a>
            <a href="menu.php" class="btn2">Adicionar +</a>
            <form action="" method="post">
                <button type="submit" class="btn2" name="delete_all" onclick="return confirm('deletar todos os itens?');">Deletar</button>
            </form>
        </div>
        
        <div class="menu">
        <div class="pratos">
        <div class="box-container">
            <form action="" method="post" class="box">
                <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('deletar esse item?');"></button>
                <img src="IMG/combo 10p salmao.jpg" alt="">
                <div class="name">Combo 10 peças salmão</div>
                <div class="flex3">
                    <div class="price"><span>R$</span>40,00</div>
                    <input type="number" name="qtd" class="qtd" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                </div>
            </form>
        </div>

        <div class="box-container">
            <form action="" method="post" class="box">
                <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('deletar esse item?');"></button>
                <img src="IMG/q_ramen.jpg" alt="">
                <div class="name">Combo 10 peças salmão</div>
                <div class="flex3">
                    <div class="price"><span>R$</span>40,00</div>
                    <input type="number" name="qtd" class="qtd" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                </div>
            </form>
        </div>

        <div class="box-container">
            <form action="" method="post" class="box">
                <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('deletar esse item?');"></button>
                <img src="IMG/sob_panqueca.jpg" alt="">
                <div class="name">Combo 10 peças salmão</div>
                <div class="flex3">
                    <div class="price"><span>R$</span>40,00</div>
                    <input type="number" name="qtd" class="qtd" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                </div>
            </form>
        </div>
        </div>
        </div>
    </section>
    <!-- carrinho fim -->

    <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>
<?php
$valor_tot_p = 0;

if(isset($_GET['prod_id'])){
    $cod_prod = $_GET['prod_id'];

    $sqlp = "SELECT * FROM tb_produtos WHERE cod_prod = :cod_prod";
    $stmtp = $pdo->prepare($sqlp); 
    $stmtp->bindParam(':cod_prod', $cod_prod);
    $stmtp->execute();
    $resultadop = $stmtp->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($_SESSION['carrinho'][$cod_prod])) {
    $_SESSION['carrinho'][$cod_prod] = array('qtd' => 1, 'cod_prod' => $resultadop['cod_prod'], 'nome' => $resultadop['nome'], 'preco' => $resultadop['valor'], 'desricao' => $resultadop['descricao'], 'imagem' => $resultadop['img']);
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