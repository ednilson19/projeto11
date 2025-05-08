<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
      
            $_SESSION["user_id"] = $user["id"];
          
            session_regenerate_id();

            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<?php include_once 'header.php'; ?>
      
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="estilos/stylelogin.css">
  
    
     

</head>
<body>
    
    <div class="wrapper">
        <h1>Login</h1>
        <?php if ($is_invalid): ?>
            <em>Login inválido</em>
        <?php endif; ?>
        <p>Bem-vindo!</p>
        <form method="post">
        <input type="email" name="email" id="email" placeholder="Introduza email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        <input type="password" name="password" placeholder="Introduza a password" required>
        
            <button type="submit">Sign in</button>
        </form>
        <p class="or">Ou</p>
        <div class="not-member">
            Não tem conta? <a href="signin.php">Faça o Resgistro</a>
        </div>
    </div>
    
 
</body>

</html>

