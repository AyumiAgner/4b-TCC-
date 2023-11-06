<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_cli = $_GET['cod_cli'];

 $sqlc = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
 $stmc = $pdo->prepare($sqlc);
 $stmc->bindParam(':cod_cli', $cod_cli);
 $stmc->execute();

 if ($stmc->rowCount() > 0){
    $sqlex = "DELETE FROM tb_clientes WHERE cod_cli = $cod_cli";
    $stmex = $pdo->query($sqlex);
    echo "cliente excluido com sucesso";
 }
 else{
    echo "cliente não encontrado";
 }

 header('Location: a_cliente_adm.php');
 ?>