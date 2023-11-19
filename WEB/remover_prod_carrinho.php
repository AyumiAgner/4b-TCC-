<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $_SESSION['valor_tot_p'] = 0;
 $_SESSION['carrinho'] = null;
 header('Location: carrinho.php');

?>