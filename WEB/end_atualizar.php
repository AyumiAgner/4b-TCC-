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

 $sqlcid = "SELECT * FROM tb_cidades";
 $stmt = $pdo->prepare($sqlcid); 
 $stmt->execute();
 $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Atualizar Endereço</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <script type="text/javascript" src="JS/jquery.js"></script>
    <script type="text/javascript" src="JS/jquery.mask.js"></script>
    <script type="text/javascript" src="JS/mask.js"></script>

    <!--link do CSS-->
    <link rel="stylesheet" href="CSS/todos.css">
    <link rel="stylesheet" href="CSS/perfil.css">

</head>
<body>
    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>

    <section class="perfil">
        <form method="POST" id="form" class="form">
            <h1 class="ti">Adicionar Endereço</h1>
                    <div class="form-control ">
                        <label for="rua">Rua</label>
                        <input type="text" name="rua_alt" id="rua" placeholder="Digite sua rua" value="<?php echo $rend['rua']; ?>">
                    </div>

                    <div class="form-control ">
                        <label for="num">Número</label>
                        <input type="text" name="numero_alt" id="num" placeholder="Digite seu número" value="<?php echo $rend['numero']; ?>">
                    </div>

                    <div class="form-control ">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro_alt" id="bairro" placeholder="Digite seu bairro" value="<?php echo $rend['bairro']; ?>">
                    </div>

                    <div class="form-control ">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento_alt" id="complemento" placeholder="Adcione um complemento" value="<?php echo $rend['complemento'] ? $rend['complemento'] : "Adicione um complemento"; ?>">
                    </div>

            <div class="form-control ">
                <label>Cidade</label>
                <select name="cidade">
                    <?php foreach ($resultado as $d){
                        echo "<option value='{$d['cod_cid']}'>{$d['nome_cid']}, {$d['estadocid']}</option>";
                    }?>
                </select>
            </div>

            <button class="btn2" type="submit" name="btnAltE">Enviar</button><a href="perfil.php" id="perf" class="btn2">Cancelar</a>

        </form>
    </section>
    <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
</html>
<?php 

if(isset($_POST['btnAltE'])){

    $rua = $_POST['rua_alt'];
    $numero = $_POST['numero_alt'];
    $bairro = $_POST['bairro_alt'];
    $complemento = $_POST['complemento_alt'];
    $cidade = $_POST['cidade'];

    if(empty($rua) || empty($numero) || empty($bairro)){
        echo "necessário descrição";
    }

    $sqlEd = "UPDATE tb_enderecos SET  rua = :rua, bairro = :bairro, numero = :numero, complemento = :complemento WHERE fk_cod_cli = $cod_cli";

    $stmEd = $pdo->prepare($sqlEd);

    $stmEd->bindParam(':rua', $rua);
    $stmEd->bindParam(':bairro', $bairro);
    $stmEd->bindParam(':numero', $numero); 
    $stmEd->bindParam(':complemento', $complemento); 

    if($stmEd->execute()){
        echo "Endereço alterado com sucesso";
    }
    else{
        echo "Erro ao alterar Endereço";
    }
}
?>