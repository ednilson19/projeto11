<?php
session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<center><h1>Home</h1>

<?php if (isset($user)): ?>

  <p>Olá <?= htmlspecialchars($user["name"]) ?> !</p>

<p> <a href="logout.php">Log out </a> </p>

<?php else: ?>

<p> <a href="login.php">log in </a> or <a href="signin.php">sign in </a> </P>

<?php endif; ?> 

<a href="index.php">Pagina inical</a>
</center>



