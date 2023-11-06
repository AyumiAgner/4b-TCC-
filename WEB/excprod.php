<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_prod = $_GET['cod_prod'];

 $sqlp = "SELECT * FROM tb_produtos WHERE cod_prod = :cod_prod";
 $stmp = $pdo->prepare($sqlp);
 $stmp->bindParam(':cod_prod', $cod_prod);
 $stmp->execute();

 if ($stmp->rowCount() > 0){
    $sqlexp = "DELETE FROM tb_produtos WHERE cod_prod = $cod_prod";
    $stmexp = $pdo->query($sqlexp);
    echo "produto excluido com sucesso";
 }
 else{
    echo "produto não encontrado";
 }

 header('Location: produtos_categorias.php');
 ?>