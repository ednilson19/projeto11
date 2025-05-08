<?php
include 'database.php';
include_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $message = $_POST['message'];
    $date = $_POST['date'];

    // Lógica para enviar e-mail (use a função mail() ou uma biblioteca como PHPMailer)
    $to = $email;
    $subject = "Lembrete";
    $body = $message;
    $headers = "From: your-email@example.com";

    if (mail($to, $subject, $body, $headers)) {
        echo "Lembrete enviado com sucesso!";
    } else {
        echo "Falha ao enviar o lembrete.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembretes</title>
    <link rel="stylesheet" href="estilos/stylelembretes.css">
</head>
<body>
<div class="container">
    <h1>Gerenciar Lembretes</h1>
    <form action="lembretes.php" method="POST">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="message">Mensagem:</label>
        <textarea id="message" name="message" required></textarea>
        
        <label for="date">Data de Envio:</label>
        <input type="date" id="date" name="date" required>
        
        <input type="submit" value="Enviar Lembrete">
    </form>
</div>
</body>
</html>
