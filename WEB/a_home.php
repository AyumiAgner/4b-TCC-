<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();
 
 if (isset($_SESSION['cod_cli'])) {
    $cod_cli = $_SESSION['cod_cli'];

    $sql = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
   
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':cod_cli', $cod_cli);
    $stmc->execute();
   
    $re = $stmc->fetch(PDO::FETCH_ASSOC);
 }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Administrador</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/admin.css">

</head>
<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
    <section class="home">
        <div class="image">
            <img src="IMG/Sushi cook-pana.svg">
        </div>
    
        <div class="ped">
            <div class=" ped-header">
                <div class="title">
                    <h1>Pedidos Realizados</h1>
                </div>
            </div>

            <div class="content">
                <p class="tot">Total de pedidos realizados: <span class="total">2</span></p>   
                <p>Pendentes: <span>2</span></p> 
                <p>Fazendo: <span>0</span></p>  
                <p>Finalizados: <span>0</span></p>
            </div> 
        </div>

        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Avaliações de clientes</h1>
                </div>
            </div>
    
            <div class="content">
                <p class="tot">Total de Avaliações realizados: <span class="total">6</span></p>   
            </div> 
        </div>

    </section>
     <!--Rodapé início-->
     <footer class="footer">
        <div class="credit">Criado por Ayumi Agner e Rayssa dos Reis</div>
    </footer>
    <!--Rodapé fim-->
</body>
<script src="JS/script.js"></script>
</html>