<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();
?>

<!DOCTYPE html>
<html lang="pt-bt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="CSS/stylee.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    <title>login</title>
</head>

<body>
    <div class="container2">
        <div class="header">
            <a href="home.php"><img src="./IMG/logo3.png" alt="logo" class="logo"></a>
            <h2> Fazer o login </h2>
        </div>
        <form method="POST" id="form" class="form">
            <div class="form-control ">
                <label for="username">Nome de usuário</label>
                <input type="text" id="username" name="username" placeholder="Digite seu usuário" maxlength="50">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>

            <div class="form-control">
                <label for="password">Senha</label>
                <input type="password" id="password" name="pass" placeholder="Digite sua senha" maxlength="50">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>

            <button type="submit" name="btnSalvar">Enviar</button>
        </form>
        <p class="login">Não tem Login? faça o <a href="cadastro.php">Cadastro</a></p>
    </div>

    <div class="image2">
        <img src="IMG/f_sushi.jpg" alt="">
    </div>

</body>
<script src="https://kit.fontawesome.com/6955baedd3.js" crossorigin="anonymous"></script>
    <script src="JS/login.js"></script>
</html>
<?php
if(isset($_POST['btnSalvar'])){
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    
    if (empty($username) || empty($pass)) {
        echo "necessário preencher todos os campos";
         // header("Location: login.php");
    }
    else{
        $us = "SELECT * FROM tb_clientes WHERE nome_cli = :username";
        $res_user = $pdo->prepare($us); 
        $res_user->bindParam(':username', $username);
        $res_user->execute();

        if($res_user->rowCount() > 0){
           $row_user = $res_user->fetch(PDO::FETCH_ASSOC);
           $pass_db = $row_user['senha'];
           $types = $row_user['tipo'];
           
            if(password_verify($pass, $pass_db)){
                echo "logado com sucesso, bem vindo";
            
                if($types == 'A'){
                    $cod_cli = $row_user['cod_cli'];
                    $_SESSION['cod_cli'] = $row_user['cod_cli'];
                    $_SESSION['log_user'] = true;
                    header("Location: a_home.php");
                }
                else{
                    $cod_cli = $row_user['cod_cli'];
                    $_SESSION['cod_cli'] = $row_user['cod_cli'];
                    $_SESSION['log_user'] = true;
                    header("Location: home.php");
                }
            
            }
            else{
                echo "usuário ou senha inválida";
                // header("Location: login.php");
            }
        }
        else{
            echo "usuário ou senha inválida!";
             //header("Location: login.php");
        }
    }
}
?>
