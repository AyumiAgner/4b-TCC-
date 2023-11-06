<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_aval = $_GET['cod_aval'];

 $sqlc = "SELECT * FROM tb_avaliacoes WHERE cod_aval = :cod_aval";
 $stmc = $pdo->prepare($sqlc);
 $stmc->bindParam(':cod_aval', $cod_aval);
 $stmc->execute();

 if ($stmc->rowCount() > 0){
    $sqlex = "DELETE FROM tb_avaliacoes WHERE cod_aval = $cod_aval";
    $stmex = $pdo->query($sqlex);
    echo "avaliação excluida com sucesso";
 }
 else{
    echo "avaliação não encontrada";
 }

 header('Location: a_avaliacoes.php');
 ?>