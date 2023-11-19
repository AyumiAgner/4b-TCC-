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

 $sqlaval = "SELECT count(*) FROM tb_avaliacoes";
 $stmav = $pdo->prepare($sqlaval); 
 $stmav->execute();
 $res = $stmav->fetchColumn();

 $sqlcliente = "SELECT count(*) FROM tb_clientes";
 $stmtcliente = $pdo->prepare($sqlcliente); 
 $stmtcliente->execute();
 $resultado = $stmtcliente->fetchColumn();

 $sqlp = "SELECT count(*) FROM tb_produtos";
 $stmtp = $pdo->prepare($sqlp); 
 $stmtp->execute();
 $nprod = $stmtp->fetchColumn();

 $sqlc = "SELECT count(*) FROM tb_categorias";
 $stmt = $pdo->prepare($sqlc); 
 $stmt->execute();
 $ncat = $stmt->fetchColumn();

 $sqlcomp = "SELECT count(*) FROM tb_compras";
 $stmtcomp = $pdo->prepare($sqlcomp);
 $stmtcomp->execute();
 $ncomp = $stmtcomp->fetchColumn();
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
    
        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Pedidos Realizados</h1>
                </div>
            </div>

            <div class="content">
                <p class="tot">Total de pedidos realizados: <span class="total"><?php echo $ncomp; ?></span></p>   
                <p>Pendentes: <span>2</span></p> 
                <p>Fazendo: <span>0</span></p>  
                <p>Finalizados: <span>0</span></p>
            </div> 
        </div>

        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Informações de clientes</h1>
                </div>
            </div>
    
            <div class="content">
                <p class="tot">Total de Avaliações realizados: <span class="total"><?php echo $res; ?></span></p> 
                <p class="tot">Total de Clientes cadastrados: <span class="total"><?php echo $resultado; ?></span></p>   
            </div> 
        </div>

    </section>
    <section class="home">

        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Produtos e Categorias</h1>
                </div>
            </div>
            <div class="content">
                <p class="tot">Total de produtos e categorias: <span class="total"><?php echo $nprod + $ncat; ?></span></p>   
                <p>Categorias: <span><?php echo $ncat; ?></span></p> 
                <p>Produtos: <span><?php echo $nprod; ?></span></p>  
            </div>
        </div>

        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Cidades Cadastradas</h1>
                </div>
            </div>
            <div class="content">
                <p class="tot">Total de cidades: <span class="total">1</span></p>   
                <p>Cidades: <span>1</span></p> <br>
                <a href="a_cidade.php" class="btn2">Adicionar mais</a>  
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