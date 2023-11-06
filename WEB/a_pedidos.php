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
    <title>Pedidos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="CSS/a_pedidos.css">

</head>
<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
    <section class="pedidos1">
        <div class="pedidos">
            <div class="image">
                <img src="IMG/Take Away-rafiki.svg">
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
        </div>

        <div class="boxcontainer">
            <div class="box">
                <p>Pedido realizado em : <span>03-07-2023</span></p>
                <p>Nome : <span>Ayumi Agner</span></p>
                <p>Telefone : <span>(45)99840-2940</span></p>
                <p>Email : <span>ayumi@gmail.com</span></p>
                <p>Endereço : <span>Rua Cedro, 232, Tropical, Cascavel, PR</span></p>
                <p>Seus pedidos : <span>Combo 10 peças de salmão, <br> Combo 10 peças de salmão, <br> Combo 10 peças de salmão</span></p>
                <p>Forma de pagamento : <span>Dinheiro na entrega</span></p>
                <p>Status do pedido : <span style="color: var(--lightred); text-decoration: underline;">Processando</span></p>
            </div>

            <div class="box">
                <p>Pedido realizado em : <span>03-07-2023</span></p>
                <p>Nome : <span>Ayumi Agner</span></p>
                <p>Telefone : <span>(45)99840-2940</span></p>
                <p>Email : <span>ayumi@gmail.com</span></p>
                <p>Endereço : <span>Rua Cedro, 232, Tropical, Cascavel, PR</span></p>
                <p>Seus pedidos : <span>Combo 10 peças de salmão, <br> Combo 10 peças de salmão, <br> Combo 10 peças de salmão</span></p>
                <p>Forma de pagamento : <span>Dinheiro na entrega</span></p>
                <p>Status do pedido : <span style="color: var(--lightred); text-decoration: underline;">Processando</span></p>
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