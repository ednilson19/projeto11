<?php include_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/stylesingin.css"> 
  

    <title>Sign Up</title>
</head>
<body>
<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if ($password === $password_confirmation) {
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = sprintf("INSERT INTO user (name, email, password_hash)
                        VALUES ('%s', '%s', '%s')",
            $mysqli->real_escape_string($name),
            $mysqli->real_escape_string($email),
            $mysqli->real_escape_string($password_hash));

        if ($mysqli->query($sql) === true) {
           
            header("Location: login.php");
            exit;
        } else {
            $is_invalid = true;
        }
    } else {
        $is_invalid = true;
    }
}
?>

<div class="wrapper">
    <h1>Sign Up</h1>
    <?php if ($is_invalid): ?>
        <em>Resgistro inválido</em>
    <?php endif; ?>
    <p>Cria sua conta</p>
    <form method="post">
        <input type="text" name="name" id="name" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" id="password" minlenght=8  placeholder="Password" minlength="8" required>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmação de password" minlength="8" required>
        <p class="password-requirements">A password deve conter pelo menos 8 caracteres, pelo menos 1 letra e 1 número</p>
        <button type="submit" value="Sign Up">Sign Up</button>
    </form>
    <div class="already-member">
        Ja tem conta? <a href="login.php">Log In</a>
    </div>
</div>

<?php //include "footer.php"; ?> 
</body>
</html>
