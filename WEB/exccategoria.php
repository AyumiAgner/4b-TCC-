<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_cat = $_GET['cod_cat'];

 $sqlc = "SELECT * FROM tb_categorias WHERE cod_cat = :cod_cat";
 $stmc = $pdo->prepare($sqlc);
 $stmc->bindParam(':cod_cat', $cod_cat);
 $stmc->execute();

 if ($stmc->rowCount() > 0){
    $sqlex = "DELETE FROM tb_categorias WHERE cod_cat = $cod_cat";
    $stmex = $pdo->query($sqlex);
    echo "categoria excluida com sucesso";
 }
 else{
    echo "categoria não encontrada";
 }

 header('Location: produtos_categorias.php');
 ?>