<?php
 //session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_cat = $_GET['cod_cat'];

 $sql = "SELECT * FROM tb_categorias WHERE cod_cat = :cod_cat";

 $stmc = $pdo->prepare($sql);
 $stmc->bindParam(':cod_cat', $cod_cat);
 $stmc->execute();

 $re = $stmc->fetch(PDO::FETCH_OBJ);
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar categorias</title>
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
                            <h1>Alteração de Categorias</h1>
                        </div>
                    </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Nome da categoria: </label>
                        <input id="name" type="text" name="nome_alt" value="<?php echo $re->nome; ?>">
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

     if(empty($nome)){
         echo "necessário informar o nome da categoria";
         exit();
     }

    $sqlup = "UPDATE tb_categorias SET nome = :nome WHERE cod_cat = :cod_cat";

    $stmup = $pdo->prepare($sqlup);

    $stmup->bindParam(':nome', $nome);
    $stmup->bindParam(':cod_cat', $cod_cat);

    if($stmup->execute()){
        echo "Alterado com sucesso";
        header("location: a_produtos_cad.php");
    }
    else{
        echo "erro";
    }
}

 ?>