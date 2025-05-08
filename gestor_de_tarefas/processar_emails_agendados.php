<?php
include 'database.php'; // Inclua sua configuração de banco de dados aqui

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$sql = "SELECT * FROM emails_agendados WHERE data_envio <= NOW()";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        enviarEmail($row['to_email'], $row['subject'], $row['body'], $row['data_conclusao']);
        // Após enviar o e-mail, você pode excluir o registro do banco de dados ou marcá-lo como enviado
        // Exemplo: $mysqli->query("DELETE FROM emails_agendados WHERE id = " . $row['id']);
    }
}

$mysqli->close();
?>
