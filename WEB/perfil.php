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

 $fk_cod_cli = $cod_cli;

 $sqlend = "SELECT * FROM tb_enderecos WHERE fk_cod_cli = :fk_cod_cli";
 $stmtend = $pdo->prepare($sqlend); 
 $stmtend->bindParam(':fk_cod_cli', $fk_cod_cli);
 $stmtend->execute();
 $rend = $stmtend->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/todos.css">
    <link rel="stylesheet" href="CSS/perfil.css">

</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>

    <h3>--Bem Vindo---</h3>
    <h2><?php echo $re['nome_cli']; ?></h2>
    <div class="i">
        <img class="img-p" src="<?php echo $re['img'] ? $re['img'] :"IMG/logo3.png"; ?>" alt="">
    </div>  
    <?php
    if(empty($re['img'])){ ?>  
    <div class="i">
        <h2>Inserir imagem de perfil:  </h2>      
        <form method="POST" enctype="multipart/form-data">
             <input type="file" name="imagem">
            <button type="submit" name="btnImg" class="btn2">Enviar</button>
        </form>
    </div>
    <?php } ?>

<section class="perfil"> 
        <div class="pro">    
            <h1 class="title"><i class="fas fa-user"></i> <?php echo $re['nome_cli']; ?></h1>
            <p><span>cpf: <?php echo $re['cpf']; ?></span></p>
            <p><span>telefone: <?php echo $re['telefone']; ?></span></p>
            <p><span>email: <?php echo $re['email']; ?></span></p>
            <p><span>nascimento: <?php echo $re['data_nasc']; ?></span></p>
            <div><a href="perf_atualizar.php" id="perf" class="btn2">Atualizar Perfil</a></div>
        </div> 

        <div class="pro">
            <?php
            if(empty($rend['rua'])){ ?>
                <h1 class="title"><i class="fas fa-map-marker-alt"></i> Seu endereço</h1>
                <p><span>Rua: Nenhum adicionado</span></p>
                <p><span>Nº: Nenhum adicionado</span></p>
                <p><span>Bairro: Nenhum adicionado</span></p>
                <p><span>Complemento: Nenhum adicionado</span></p>
                <p><span>Cascavel - PR</span></p>            
                <div><a href="end_cad.php" id="end" class="btn2">Adicionar Endereço</a></div>
            <?php }else{
            ?>
        <h1 class="title"><i class="fas fa-map-marker-alt"></i> Seu endereço</h1>
            <p><span>Rua: <?php echo $rend['rua']?></span></p>
            <p><span>Nº: <?php echo $rend['numero']?></span></p>
            <p><span>Bairro: <?php echo $rend['bairro']?></span></p>
            <p><span>Complemento: <?php echo $rend['complemento']?></span></p>
            <p><span>Cascavel - PR</span></p>            
            <div><a href="end_atualizar.php" id="end" class="btn2">Atualizar Endereço</a></div>
            <?php } ?>
        </div>

        <section class="avaliacoes">
            <div class="pro">
                <h1 class="title">Nova Avaliação</h1>
                <form action="" method="POST">
                    <div class="form-control-av">
                    <label>Envie sua avaliação de nosso site: </label>    
                    <input type="text" name="descricao" placeholder="Máximo até 100 caracteres" maxlength="100">
                    </div>     
                    <button type="submit" name="btnAval" id="av" class="btn2">Adicionar avaliação</button>
                </form>
            </div>
        </section>

        <section class="orders">
            <div class="pro">
                <h1 class="title">Seus Pedidos</h1>
                <p>Mostrar pedidos realizados anteriormente</p>
                <div><button id="order" class="btn2">Ver Pedidos</button></div>
            </div>
        </section>
</section>

     <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>
<?php
if(isset($_POST['btnImg'])){
    $nomeImg = $_FILES['imagem'];

    if($_FILES['imagem']['error'] == 0){

        $nomeArquivo = str_replace(" ", "_", $nomeImg['name']);
        $nomeArquivo = explode(".", $nomeArquivo);
        $caminho = "IMG/". $nomeArquivo[0] . "." . $nomeArquivo[1];

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
    }
    else{
        $nomeImg = "IMG/logo3.png";
    }

    $sqlPerf = "UPDATE tb_clientes SET img = :img WHERE cod_cli = $cod_cli";
    $imgPerf = $pdo->prepare($sqlPerf); 
    $imgPerf->bindParam(':img', $caminho);

    if ($imgPerf->execute()) {
        echo "imagem alterada com sucesso";
        //header("Location: a_produtos_cad.php");
    }
    else {
    echo "erro ao alterar a imagem";
    }
}

if(isset($_POST['btnAval'])){

    $descricao = $_POST['descricao'];
    $fk_cod_cl = $re['cod_cli'];

    if (empty($descricao) ) {
        echo "necessário descrição";
        exit();
         // header("Location: cadastro.php");
    }

    else{

    $sqlav = "INSERT INTO tb_avaliacoes (descricao, fk_cod_cl) VALUES (:descricao, :fk_cod_cl)";

    $aval = $pdo->prepare($sqlav);
    $aval->bindParam(':descricao', $descricao);
    $aval->bindParam(':fk_cod_cl', $fk_cod_cl);

    if ($aval->execute()) {
        echo "avaliação enviada com sucesso";
        // header("Location: cadastro.php");
    }
    else {
        echo "erro ao enviar avaliação";
        // header("Location: cadastro.php");
    }
    }
}
?>