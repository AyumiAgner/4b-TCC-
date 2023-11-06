<?php
 //session_start();
 require_once("conexao.php");

 $pdo = conectar();

 if (isset($_SESSION['cod_cli'])) {
    $cod_cli = $_SESSION['cod_cli'];

    $sqll = "SELECT * FROM tb_clientes WHERE cod_cli = :cod_cli";
   
    $stml = $pdo->prepare($sqll);
    $stml->bindParam(':cod_cli', $cod_cli);
    $stml->execute();
   
    $r = $stml->fetch(PDO::FETCH_ASSOC);
 }


 $cod_prod = $_GET['cod_prod'];

 $sql = "SELECT * FROM tb_produtos WHERE cod_prod = :cod_prod";

 $stmc = $pdo->prepare($sql);
 $stmc->bindParam(':cod_prod', $cod_prod);
 $stmc->execute();

 $re = $stmc->fetch(PDO::FETCH_OBJ);

 $sql = "SELECT * FROM tb_categorias";
 $stmt = $pdo->prepare($sql); 
 $stmt->execute();
 //BUSCANDO TODAS AS LINHAS DA TABELA
 $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar produtos</title>
    <link rel="stylesheet" href="CSS/a_produtos_cad.css">
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
 </head>
 <body>
    
    <div class="a">
            <div class="form-alt">
                <form method="post" enctype="multipart/form-data">
                    <div class=" form-header">
                        <div class="title">
                            <h1>Alteração de Produtos</h1>
                        </div>
                    </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Nome do produto: </label>
                        <input id="name" type="text" name="nome_alt" value="<?php echo $re->nome; ?>">
                    
                        <br><label for="descricao">Descrição do produto: </label>
                        <input type="text" id="descricao" type="text" name="descricao_alt" value="<?php echo $re->descricao; ?>">

                        <br><label for="tipo">Tipo do produto:</label>
                        <div class="tipo-group">
                        <div class="tipo-input">
                            <input type="radio" id="ativo" value="S" name="tipo_alt">
                            <label for="ativo">Ativo</label>
                        </div>
                        </div>

                        <br><div class="tipo-input">
                            <input type="radio" id="desativado" value="N" name="tipo_alt">
                            <label for="desativado">Desativo</label>
                        </div>

                        <br><label>Imagem: </label>
                        <input type="file" name="imagem_alt" value="<?php echo $re->img; ?>">

                        <br><label>Categoria: </label>
                        <select name="categoria_alt">
                            <option>Selecione</option>
                            <?php foreach ($resultado as $d){
                                echo "<option value='{$d['cod_cat']}'>{$d['nome']}</option>";
                                }?>
                        </select>

                        <br><label for="money">Valor</label>
                        <input type="money" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="valor_alt" onkeyup="formatarValor(this)" value="<?php echo $re->valor; ?>">
                    
                    </div>
                </div>

                <div class="salvar-button">
                    <button type="submit" name="btnAlt" class="btnSalvar">Alterar</button><br><br>
                    <button><a href="produtos_categorias.php" class="btnSalvar">Cancelar</a></button>
                </div>
                </form>
            </div>
    </div>        
    
 </body>
 </html>
 <?php 
 
if(isset($_POST['btnAlt'])){

    $nome = $_POST['nome_alt'];
    $descricao = $_POST['descricao_alt'];
    $tipo = $_POST['tipo_alt'];
    $imagem = $_FILES['imagem_alt'];
    $categoria = $_POST['categoria_alt'];
    $valor = $_POST['valor_alt'];

     if(empty($nome) || empty($descricao) || empty($tipo) || empty($categoria) || empty($valor)){
         echo "necessário completar todos os campos";
         exit();
     }

     if($_FILES['imagem_alt']['error'] == 0){

        $nomeArquivo = str_replace(" ", "_", $imagem['name']);
        $nomeArquivo = explode(".", $nomeArquivo);
        $caminho = "IMG/". $nomeArquivo[0] . "." . $nomeArquivo[1];

        move_uploaded_file($_FILES['imagem_alt']['tmp_name'], $caminho);
    }

    $sqlup = "UPDATE tb_produtos SET fk_cod_cat = :fk_cod_cat, descricao = :descricao, ativo = :ativo, valor = :valor, nome = :nome, img = :img WHERE cod_prod = :cod_prod";

    $stmup = $pdo->prepare($sqlup);

    $stmup->bindParam(':nome', $nome);
    $stmup->bindParam(':descricao', $descricao);
    $stmup->bindParam(':ativo', $tipo);
    $stmup->bindParam(':img', $caminho);
    $stmup->bindParam(':fk_cod_cat', $categoria);
    $stmup->bindParam(':valor', $valor);
    $stmup->bindParam(':cod_prod', $cod_prod);

    if($stmup->execute()){
        echo "Alterado com sucesso";
        header("location: produtos_categorias.php");
    }
    else{
        echo "erro";
    }
    
 header('Location: produtos_categorias.php');
}

 ?>