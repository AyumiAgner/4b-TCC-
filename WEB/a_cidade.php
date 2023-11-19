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
 $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="CSS/a_produtos_cad.css">

</head>
<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
    <section class="home">
        <div class="boxes">
            <div class=" ava-header">
                <div class="title">
                    <h1>Cidades Cadastradas</h1>
                </div>
            </div>
            <div class="content">
                <p class="tot">Total de cidades: <span class="total">1</span></p>   
                <p>Cidades: <span><?php
                foreach($res as $r){ 
                    echo $r['nome_cid']; ?> - <?php echo $r['estadocid'];
                    ?></span></p> <br>
                <div class="salvar-button">
                <a href="altcidade.php?cod_cid= <?php echo $r['cod_cid']; ?>" class="alterar">Alterar</a> - <a href="exccidade.php?cod_cid= <?php echo $r['cod_cid']; ?>" class="excluir" onclick="return confirm('Excluir essa cidade?');">Excluir</a>
                </div>
            </div>
            <?php }?>
        </div>

        <div class="boxes">
            <form method="post" >
                    <div class=" ava-header">
                        <div class="title">
                            <h1>Cadastro de Cidades</h1>
                        </div>
                    </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Nome da cidade: </label>
                        <input id="name" type="text" name="nome" required>
                    </div>
    
                    <div class="input-box">
                        <label for="name">Estado UF: </label>
                        <input id="name" type="text" name="estado" maxlength="2" required>
                    </div>
                </div>

                <div class="salvar-button">
                    <button type="submit" name="btnSalvar"><b>Enviar</b></button>
                </div>
            </form>
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
<?php
if (isset($_POST['btnSalvar'])) {
    $nome = $_POST['nome'];
    $estado = $_POST['estado'];

    if (empty($nome) || empty( $estado)) {;
        echo "necessário descrição";
        exit();
    }

    $sqlc = "INSERT INTO tb_cidades (nome_cid, estadocid) VALUES (:nome, :estado)";
    $stmtcid = $pdo->prepare($sqlc); 
    $stmtcid->bindParam(':nome', $nome);
    $stmtcid->bindParam(':estado', $estado);

    if ($stmtcid->execute()) {
        echo "cidade inserida com sucesso";
        header("Location: a_cidade.php");
    }
    else {
    echo "erro ao inserir a cidade";
    }
}
?>