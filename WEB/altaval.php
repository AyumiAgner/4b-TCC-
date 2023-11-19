<?php
 //session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_aval = $_GET['cod_aval'];
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar avaliações</title>
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
                            <h1>Alteração de Avaliações</h1>
                        </div>
                    </div>

        <div class="avaliacoes2">
            <?php 
                $claval = "SELECT tb_clientes.nome_cli, tb_clientes.img FROM tb_avaliacoes RIGHT JOIN tb_clientes ON tb_clientes.cod_cli = tb_avaliacoes.fk_cod_cl WHERE cod_aval = :cod_aval";
                $stmav = $pdo->prepare($claval);
                $stmav->bindParam(':cod_aval', $cod_aval);
                $stmav->execute();
                $r = $stmav->fetch(PDO::FETCH_ASSOC);
                ?>
            <div class="aval">
                <img src="<?php  echo $r['img'] ? $r['img'] :"IMG/logo3.png"; ?>" alt="">
                <h1><?php echo $r['nome_cli']; ?></h1><br>
                <p><?php
                $sql = "SELECT * FROM tb_avaliacoes WHERE cod_aval = :cod_aval";
                $stmc = $pdo->prepare($sql);
                $stmc->bindParam(':cod_aval', $cod_aval);
                $stmc->execute();
                $re = $stmc->fetch(PDO::FETCH_OBJ);
                
                echo $re->descricao; ?> </p>
            
                    <div class="input-box">
                        <label for="name">Ativo: </label>
                        <input  type="text" name="ativo_alt" value="<?php echo $re->ativo; ?>" maxlength="1" required> 
                    </div>
                
                <div class="salvar-button">
                    <button type="submit" name="btnAlt" class="btnSalvar">Alterar</button>
                </div>
                </form>
            </div> 
            </div>
        </div>
                
            </div>
    </div>        
     
 </body>
 </html>
 <?php 
 
if(isset($_POST['btnAlt'])){

    $ativo = $_POST['ativo_alt'];

     if(empty($ativo)){
         echo "necessário descrição";
         exit();
     }

    $sqlup = "UPDATE tb_avaliacoes SET ativo = :ativo WHERE cod_aval = :cod_aval";

    $stmup = $pdo->prepare($sqlup);
    $stmup->bindParam(':ativo', $ativo);
    $stmup->bindParam(':cod_aval', $cod_aval);

    if($stmup->execute()){
        echo "Alterado com sucesso";
        header("location: a_avaliacoes.php");
    }
    else{
        echo "erro";
    }
}

 ?>