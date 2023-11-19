<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $sqlp = "SELECT * FROM tb_produtos WHERE cod_prod = :cod_prod";
    $stmtp = $pdo->prepare($sqlp); 
    $stmtp->bindParam(':cod_prod', $cod_prod);
    $stmtp->execute();
    $resultadop = $stmtp->fetch(PDO::FETCH_ASSOC);

 if(isset($_POST['cart_prod_cod'])){
    $cod_prod = filter_input(INPUT_POST, 'cart_prod_cod', FILTER_SANITIZE_NUMBER_INT);
    unset($_SESSION['carrinho'][$cod_prod]);
    header('Location: carrinho.php');

    $valor_tot_p -= $resultadop['valor'] * $resultadop['qtd'];

    header('Location: carrinho.php');
 }
?>