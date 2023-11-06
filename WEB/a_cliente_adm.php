<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();

 
 $sql = "SELECT * FROM tb_clientes";
 $stmt = $pdo->prepare($sql); 
 $stmt->execute();

 $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>clientes</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="CSS/a_cliente_adm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

</head>

<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
    <section class="avaliacoes1">
        <div class="avaliacoes">
            <div class="image2">
                <img src="IMG/In no time-cuate.svg">
            </div>
    
        <div class="ava">
            <div class=" ava-header">
                <div class="title">
                    <h1>Controle de clientes </h1>
                    
                </div>
            </div>

            <div class="content">
                <p class="tot">Total de clientes cadastrados: <span class="total">10</span></p>   
              
            </div> 
        </div>
    </div>
    <div class="avaliacoes2">
    <?php foreach($resultado as $r){?>
        <div class="aval">
            <img src="<?php echo $r['img'] ? $r['img'] :"IMG/logo3.png"; ?>" alt="">
            <h1><?php echo $r['nome_cli']; ?></h1>
            <P><?php echo $r['email']; ?><br>
            Tipo: <?php echo $r['tipo']; ?></p>
            <a href="exccliente.php?cod_cli= <?php echo $r['cod_cli']; ?>" class="btn2" onclick="return confirm('Excluir esse cliente?');">Excluir</a>
        </div>
        <?php } ?>
    </div>
</section>    
     <!--Rodapé início-->
     <footer class="footer">
        <div class="credit">Criado por Ayumi Agner e Rayssa dos Reis</div>
    </footer>
    <!--Rodapé fim-->  





</body>

</html>