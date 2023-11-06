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

 $sqlp = "SELECT * FROM tb_produtos";
 $stmtp = $pdo->prepare($sqlp); 
 $stmtp->execute();
 $resultadop = $stmtp->fetchAll(PDO::FETCH_ASSOC);

 $sql = "SELECT * FROM tb_categorias";
 $stmt = $pdo->prepare($sql); 
 $stmt->execute();
 //BUSCANDO TODAS AS LINHAS DA TABELA
 $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 //BUSCANDO SOMENTE UM REGISTRO
 //$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias e Produtos</title>
    <link rel="stylesheet" href="CSS/a_produtos_cad.css">
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
 </head>
 <body>
  <!--Cabeçalho início-->
  <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->
    <div class="co">
        <table class="table">
        <h2 class="list_cat">Lista de categorias</h2>
            <tr class="tb_col">
                <th>Código</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
            <?php foreach($resultado as $r){?>
            <tr class="tb_lin">
                <td id="name-list"><?php echo $r['cod_cat']; ?></td>    
                <td id="name-list"><?php echo $r['nome']; ?></td>
                <td> <a href="altcategoria.php?cod_cat= <?php echo $r['cod_cat']; ?>" class="alterar">Alterar</a> - <a href="exccategoria.php?cod_cat= <?php echo $r['cod_cat']; ?>" class="excluir" onclick="return confirm('Excluir essa categoria?');">Excluir</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    
    <div class="co">
        <table class="table">
                <h2 class="list_cat">Lista de Produtos</h2>
                <tr class="tb_col">
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                <?php foreach($resultadop as $res){?>
                    <tr class="tb_lin">
                <td id="name-list"><?php echo $res['cod_prod']; ?></td>
                <td id="name-list"><?php echo $res['nome']; ?></td>
                <td id="name-list"><?php echo $res['descricao']; ?></td>
                <td id="name-list"><?php echo $res['valor']; ?></td>
                <td id="name-list"><?php echo $res['ativo']; ?></td>
                <td> <a href="altprod.php?cod_prod= <?php echo $res['cod_prod']; ?>" class="alterar">Alterar</a> - <a href="excprod.php?cod_prod= <?php echo $res['cod_prod']; ?>" class="excluir" onclick="return confirm('Excluir esse produto?');">Excluir</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
     <!--Rodapé início-->
     <footer class="footer">
        <div class="credit">Criado por Ayumi Agner e Rayssa dos Reis</div>
    </footer>
    <!--Rodapé fim-->
 </body>
 </html>