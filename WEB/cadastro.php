<?php
 session_start();
 require_once("conexao.php");

 $pdo = conectar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript" src="JS/jquery.js"></script>
    <script type="text/javascript" src="JS/jquery.mask.js"></script>
    <script type="text/javascript" src="JS/mask.js"></script>

    <link rel="stylesheet" href="CSS/stylee.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">
    <title>Cadaste-se</title>
</head>

<body>
    <div class="image">
        <img src="IMG/f_sushi 2.jpg" alt="">
    </div>

    <div class="container">

        <div class="header">
            <a href="home.php"><img src="./IMG/logo3.png" alt="logo" class="logo"></a>
            <h2> Criar uma conta</h2>
        </div>

        <form action="" method="POST" id="form" class="form">
            
            <div class="form-control ">
                <label for="username">Nome de usuário</label>
                <input type="text" id="username" name="username" placeholder="Digite seu nome completo" maxlength="50">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>

        <div class="form2">
            <div class="form-control">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email" maxlength="50">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>
        
            <div class="form-control">
                <label for="telefone">Telefone</label>
                <input class="phone_with_ddd" type="text" id="telefone" name="telefone" placeholder="Digite seu telefone" maxlength="11">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>

            <div class="form-control">
                <label for="cpf">CPF</label>
                <input class="cpf" type="text" id="cpf" name="cpf" placeholder="Digite seu cpf" maxlength="11">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>

            <div class="form-control">
                <label for="data">Data nascimento</label>
                <input class="date" type="text" id="data" name="data" placeholder="Digite seu telefone" maxlength="8">
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

            <div class="form-control">
                <label for="password-confirmation"> Confirme sua senha</label>
                <input type="password" id=password-confirmation name="cpass" placeholder="Confirme sua senha" maxlength="50">
                <i class="fas fa-exclamation-circle"></i>
                <i class="fas fa-check-circle"></i>
                <small> Mensagem de erro</small>
            </div>
        </div>
            <button type="submit" name="btnSalvar">Enviar</button>

            <p class="login">Já possui cadastro? faça o <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
<script src="https://kit.fontawesome.com/6955baedd3.js" crossorigin="anonymous"></script>
<script src="JS/script2.js"></script>
</html>
<?php
if (isset($_POST['btnSalvar'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $data = $_POST['data'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $ativo = 'S';
    $tipo = 'C';

    $pass_enc = password_hash($pass, PASSWORD_DEFAULT);

    if (empty($username) || empty($email) || empty($telefone) || empty($cpf) || empty($data) || empty($pass) || empty($cpass) || empty($ativo) || empty($tipo) ) {
        echo "necessário completar todos os campos";
        exit();
         // header("Location: cadastro.php");
    }

    if($pass == $cpass){

        $data = date("Y-d-m", strtotime($data));
        $data = str_replace("/", "-", $data);

        $arrayTelefone = array("(", ")", "-", " ");
        $telefone = str_replace($arrayTelefone, "", $telefone);

        $arrayCpf = array(".", "-");
        $cpf = str_replace($arrayCpf, "", $cpf);

        $sql = "INSERT INTO tb_clientes (nome_cli, senha, cpf, telefone, data_nasc, email, ativo, tipo) VALUES (:nome_cli, :senha, :cpf, :telefone, :data_nasc, :email, :ativo, :tipo)";
        $cadcli = $pdo->prepare($sql); 
        $cadcli->bindParam(':nome_cli', $username);
        $cadcli->bindParam(':senha', $pass_enc);
        $cadcli->bindParam(':cpf', $cpf);
        $cadcli->bindParam(':telefone', $telefone);
        $cadcli->bindParam(':data_nasc', $data);
        $cadcli->bindParam(':email', $email);
        $cadcli->bindParam(':ativo', $ativo);
        $cadcli->bindParam(':tipo', $tipo);

        if ($cadcli->execute()) {
            echo "cliente cadastrado com sucesso";
            // header("Location: cadastro.php");
        }
        else {
            echo "erro ao cadastrar cliente";
            // header("Location: cadastro.php");
        }
    }
    else{
        echo "senhas não são iguais";
    }
}
?>