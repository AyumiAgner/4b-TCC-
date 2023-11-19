<?php
 //session_start();
 require_once("conexao.php");

 $pdo = conectar();

 $cod_compra = $_GET['cod_compra'];

 $sql = "SELECT * FROM tb_compras WHERE cod_compra = :cod_compra";

 $stmc = $pdo->prepare($sql);
 $stmc->bindParam(':cod_compra', $cod_compra);
 $stmc->execute();

 $re = $stmc->fetch(PDO::FETCH_OBJ);
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pedido</title>
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
                            <h1>Alteração do status do Pedido</h1>
                        </div>
                    </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Status: <?php echo $re->status_pedido; ?></label>
                        <select name="status">
                            <option>Selecione</option>
                            <option value="confirmado">confirmado</option>
                            <option value="fazendo">fazendo</option>
                            <option value="finalizado">finalizado</option>
                            <option value="cancelado">Cancelado</option>
                        </select> 
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

    $status = $_POST['status'];

     if(empty($status)){
         echo "necessário informar o status do pedido";
         exit();
     }

    $sqlup = "UPDATE tb_compras SET status_pedido = :status_pedido WHERE cod_compra = :cod_compra";

    $stmup = $pdo->prepare($sqlup);
    $stmup->bindParam(':status_pedido', $status);
    $stmup->bindParam(':cod_compra', $cod_compra);

    if($stmup->execute()){
        echo "Alterado com sucesso";
        header("location: a_pedidos.php");
    }
    else{
        echo "erro";
    }
}

 ?>