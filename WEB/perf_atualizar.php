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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Perfil</title>

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
        <form method="POST" id="form" class="form" enctype="multipart/form-data">
                <h1 class="ti">Alterar Perfil</h1>
                
                <div class="form-control ">
                    <label for="username">Nome de usuário</label>
                    <input type="text" id="username" name="nome_cli_alt" value="<?php echo $re['nome_cli']; ?>">
                </div>

                <div class="form-control">
                    <label for="telefone">Telefone</label>
                    <input class="phone_with_ddd" type="text" id="telefone" name="tel_alt" value="<?php echo $re['telefone']; ?>">
                </div>
    
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email_alt" value="<?php echo $re['email']; ?>">
                </div>
    
                <div class="form-control">
                    <label for="cpf">CPF</label>
                    <input class="cpf" type="text" id="cpf" name="cpf_alt" value="<?php echo $re['cpf']; ?>">
                </div>

                <div class="form-control">
                    <label for="data">Data de nascimento</label>
                    <input type="text" id="data" name="data_alt" value="<?php echo $re['data_nasc']; ?>">
                </div>

                <div class="form-control">
                    <label>Imagem: </label>
                    <input id="arq" type="file" name="ima"  value="<?php echo $re['img']; ?>">
                </div>

                <br><h1 class="ti">Alterar Senha</h1>
                <div class="form-control">
                    <label for="password-new">Nova senha</label>
                    <input type="password" id="password-new" name="pass" placeholder="Digite sua nova senha">
                </div>

                <div class="form-control">
                    <label for="password-confirmation"> Confirme sua senha</label>
                    <input type="password" id=password-confirmation name="cpass" placeholder="Confirme sua senha">
                </div> 
    
                <button type="submit" class="btn2" name="btnAltC">Enviar</button><a href="perfil.php" id="perf" class="btn2">Cancelar</a>
            </form>
    </section>
    <!--Rodapé-->
    <?php include 'footer.php'; ?>
</body>
<script src="JS/script.js"></script>
</html>
<?php 


 
if(isset($_POST['btnAltC'])){

    $nome_cli = $_POST['nome_cli_alt'];
    $telefone = $_POST['tel_alt'];
    $email = $_POST['email_alt'];
    $cpf = $_POST['cpf_alt'];
    $data_nasc = $_POST['data_alt'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $nomeImg = $_FILES['ima'];

    $pass_enc = password_hash($pass, PASSWORD_DEFAULT);

    $arrayTelefone = array("(", ")", "-", " ");
    $telefone = str_replace($arrayTelefone, "", $telefone);

    $arrayCpf = array(".", "-");
    $cpf = str_replace($arrayCpf, "", $cpf);

     if(empty($nome_cli) || empty($telefone) || empty($email) ){
         echo "necessário descrição";
     }

    if($_FILES['ima']['error'] == 0){

        $nomeArquivo = str_replace(" ", "_", $nomeImg['name']);
        $nomeArquivo = explode(".", $nomeArquivo);
        $caminho = "IMG/". $nomeArquivo[0] . "." . $nomeArquivo[1];

        move_uploaded_file($_FILES['ima']['tmp_name'], $caminho);
    }

    $sqlup = "UPDATE tb_clientes SET nome_cli = :nome_cli, cpf = :cpf, telefone = :telefone, data_nasc = :data_nasc, email = :email, img = :img  WHERE cod_cli = $cod_cli";

    $stmup = $pdo->prepare($sqlup);

    $stmup->bindParam(':nome_cli', $nome_cli);
    $stmup->bindParam(':cpf', $cpf);
    $stmup->bindParam(':telefone', $telefone);
    $stmup->bindParam(':data_nasc', $data_nasc);
    $stmup->bindParam(':email', $email);
    $stmup->bindParam(':img', $caminho); 

    if($stmup->execute()){
        echo "Alterado com sucesso";
    }
    else{
        echo "Erro ao alterar";
    }

if(!empty($pass) || !empty($cpass)){

    if($pass == $cpass){  
        $sqlup = "UPDATE tb_clientes SET senha = :senha WHERE cod_cli = $cod_cli";

        $stmup = $pdo->prepare($sqlup);

        $stmup->bindParam(':senha', $pass_enc); 

        if($stmup->execute()){
            echo "Alterado com sucesso";
        }
        else{
            echo "Erro ao alterar";
        }
      }
    else{
        echo "senhas não são iguais";
    }
} 
}

?>