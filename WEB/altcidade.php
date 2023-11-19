<?php
 //session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_cid = $_GET['cod_cid'];

 $sqlc = "SELECT * FROM tb_cidades WHERE cod_cid = :cod_cid";
 $stmc = $pdo->prepare($sqlc);
 $stmc->bindParam(':cod_cid', $cod_cid);
 $stmc->execute();

 $res = $stmc->fetch(PDO::FETCH_OBJ);
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar cidades</title>
    <link rel="stylesheet" href="CSS/a_produtos_cad.css">
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
 </head>
 <body>
 
    <div class="a">
            <div class="form-alt">
                <form method="post">
                    <div class=" form-header">
                        <div class="title">
                            <h1>Alteração de Cidades</h1>
                        </div>
                    </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Nome da cidade: </label>
                        <input type="text" name="nome_alt" value="<?php echo $res->nome_cid; ?>">
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Estado UF: </label>
                        <input  type="text" name="estado_alt" value="<?php echo $res->estadocid; ?>" maxlength="2" required> 
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Ativo: </label>
                        <input  type="text" name="ativo_alt" value="<?php echo $res->ativo; ?>" maxlength="1" required> 
                    </div>
                </div>

                <div class="salvar-button">
                    <button type="submit" name="btnAlt" class="btnSalvar">Alterar</button>
                </div>
                </form>
            </div>
    </div>        
     
 </body>
 </html>
 <?php 
 
if(isset($_POST['btnAlt'])){

    $nome = $_POST['nome_alt'];
    $estado = $_POST['estado_alt'];
    $ativo = $_POST['ativo_alt'];

     if(empty($nome) || empty( $estado)){
         echo "necessário informar o nome e estado da cidade";
         exit();
     }

    $sqlup = "UPDATE tb_cidades SET nome_cid = :nome, ativo = :ativo, estadocid = :estado WHERE cod_cid = :cod_cid";

    $stmup = $pdo->prepare($sqlup);

    $stmup->bindParam(':nome', $nome);
    $stmup->bindParam(':cod_cid', $cod_cid);
    $stmup->bindParam(':ativo', $ativo);
    $stmup->bindParam(':estado', $estado);

    if($stmup->execute()){
        echo "Alterado com sucesso";
        header("location: a_cidade.php");
    }
    else{
        echo "erro";
    }
}

 ?>