<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_cid = $_GET['cod_cid'];

 $sqlc = "SELECT * FROM tb_cidades WHERE cod_cid = :cod_cid";
 $stmc = $pdo->prepare($sqlc);
 $stmc->bindParam(':cod_cid', $cod_cid);
 $stmc->execute();

 if ($stmc->rowCount() > 0){
    $sqlex = "DELETE FROM tb_cidades WHERE cod_cid = $cod_cid";
    $stmex = $pdo->query($sqlex);
    echo "cidade excluida com sucesso";
 }
 else{
    echo "cidade não encontrada";
 }

 header('Location: a_cidade.php');
 ?>