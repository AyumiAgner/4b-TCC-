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
    <title>cadastro-produto</title>
    <link rel="stylesheet" href="CSS/a_produtos_cad.css">
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
    <!--Cabeçalho início-->
    <?php include_once 'header_adm.php'; ?>
    <!--Cabeçalho fim-->

    <div class="container">
        
        <div class="form">
            <form method="POST" enctype="multipart/form-data">
                <div class=" form-header">
                    <div class="title">
                        <h1>Cadastro de Produtos</h1>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome do produto: </label>
                        <input id="nome" type="text" name="nomeP" required>
                    </div>
                </div>

                <div class="input-box">
                    <label for="descricao">Descrição do produto: </label>
                    <input type="text" id="descricao" type="text" name="descricaoP" required>
                </div>

                <div class="tipo-inputs">
                    <div class="tipo-title">
                        <h9>Tipo-produto: </h9>
                    </div>

                    <div class="tipo-group">
                        <div class="tipo-input">
                            <input type="radio" id="ativo" value="S" name="tipoP">
                            <label for="ativo">Ativo</label>
                        </div>

                        <div class="tipo-input">
                            <input type="radio" id="desativado" value="N" name="tipoP">
                            <label for="desativado">Desativo</label>
                        </div>
                    </div>

                    <div class="arquivo">
                        <label>Imagem: </label>
                        <input type="file" name="imagemP">
                    </div>

                    <div class="cat-group">
                        <label>Categoria: </label>
                        <select name="categoriaP">
                            <option>Selecione</option>
                            <?php foreach ($resultado as $d){
                                echo "<option value='{$d['cod_cat']}'>{$d['nome']}</option>";
                                }?>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="money">Valor</label>
                        <input type="money" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="valorP" onkeyup="formatarValor(this)">
                    </div>
                </div>

                <div class="salvar-button">
                    <button type="submit" name="btnSalvar2"><b>Enviar</b></button>
                </div>
            </form>
        </div>

        <div class="form-image">
            <img src="IMG/Order food-amico.svg">
        </div>

        <div class="cat">
            <div class="form">
                <form method="post" >
                    <div class=" form-header">
                        <div class="title">
                            <h1>Cadastro de Categorias</h1>
                        </div>
                    </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="name">Nome da categoria: </label>
                        <input id="name" type="text" name="nome" required>
                    </div>
                </div>

                <div class="salvar-button">
                    <button type="submit" name="btnSalvar"><b>Enviar</b></button>
                </div>
                </form>
            </div>

            <div class="categorias">
                <div class=" cat-header">
                    <div class="title">
                        <h1>Produtos e Categorias</h1>
                    </div>
                </div>

                <div class="content">
                    <p class="tot">Total de produtos e categorias: <span class="total">4</span></p>   
                    <p>Categorias: <span>2</span></p> 
                    <p>Produtos: <span>2</span></p>  
                </div>

                <div class="salvar-button">
                    <button><a href="produtos_categorias.php"><b> Ver produtos e categorias</b></a></button>
                </div>
            </div>
        </div>
    </div>
    <!--Rodapé início-->
    <footer class="footer">
        <div class="credit">Criado por Ayumi Agner e Rayssa dos Reis</div>
    </footer>
    <!--Rodapé fim-->
</body>
 <!-- <script>
    function formatarValor(element) {
        // Remove caracteres não numéricos do valor
        var valor = element.value.replace(/\D/g, '');

        // Formata o valor adicionando separador de milhares e ponto decimal
        var valorFormatado = (parseFloat(valor) / 100).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });

        // Atualiza o valor no campo de input
        element.value = valorFormatado;
    }
</script>  -->
</html>

<?php
// CRUD produtos
if (isset($_POST['btnSalvar2'])) {
    $nomeProd = $_POST['nomeP'];
    $descricaoProd = $_POST['descricaoP'];
    $tipoProd = $_POST['tipoP'];
    $categoriaProd = $_POST['categoriaP'];
    $descricaoImg = $_FILES['imagemP'];
    $valorProd = $_POST['valorP'];

    if (empty($nomeProd) || empty($descricaoProd) || empty($tipoProd) || empty($categoriaProd) || empty($valorProd) || empty($descricaoImg)) {;
        echo "necessário completar todos os campos!";
        exit();
    }

    if($_FILES['imagemP']['error'] == 0){

        $nomeArquivo = str_replace(" ", "_", $descricaoImg['name']);
        $nomeArquivo = explode(".", $nomeArquivo);
        $caminho = "IMG/". $nomeArquivo[0] . "." . $nomeArquivo[1];

        move_uploaded_file($_FILES['imagemP']['tmp_name'], $caminho);
    }
    else{
        $descricaoImg = "IMG/logo3.png";
    }

    $sqlp = "INSERT INTO tb_produtos (fk_cod_cat, descricao, ativo, valor, nome, img) VALUES (:fk_cod_cat, :descricao, :ativo, :valor, :nome, :img)";
    $stmtp = $pdo->prepare($sqlp); 
    $stmtp->bindParam(':fk_cod_cat', $categoriaProd);
    $stmtp->bindParam(':descricao', $descricaoProd);
    $stmtp->bindParam(':ativo', $tipoProd);
    $stmtp->bindParam(':valor', $valorProd);
    $stmtp->bindParam(':nome', $nomeProd);
    $stmtp->bindParam(':img', $caminho);

    if ($stmtp->execute()) {
        echo "produto inserido com sucesso";
        //header("Location: a_produtos_cad.php");
    }
    else {
    echo "erro ao inserir o produto";
    }
}

// CRUD Categorias
if (isset($_POST['btnSalvar'])) {
    $nome = $_POST['nome'];

    if (empty($nome)) {;
        echo "necessário descrição";
        exit();
    }

    $sql = "INSERT INTO tb_categorias (nome) VALUES (:nome)";
    $stmt = $pdo->prepare($sql); 
    $stmt->bindParam(':nome', $nome);

    if ($stmt->execute()) {
        echo "categoria inserida com sucesso";
        header("Location: a_produtos_cad.php");
    }
    else {
    echo "erro ao inserir a categoria";
    }
}
?>