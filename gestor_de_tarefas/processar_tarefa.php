<?php
include 'database.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$alert = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'];
    $data_conclusao = $_POST['data_conclusao'];
    $aviso = $_POST['aviso'];
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT email FROM user WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($user_email);
        $stmt->fetch();
        $stmt->close();
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Erro na preparação da consulta: ' . $mysqli->error . '</div>';
        exit;
    }

    // Prepare e execute a consulta SQL para inserir os dados
    $sql = "INSERT INTO tarefas (titulo, descricao, prioridade, data_conclusao, aviso, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssssi", $titulo, $descricao, $prioridade, $data_conclusao, $aviso, $user_id);
        if ($stmt->execute()) {
            $alert = '<div class="alert alert-success" role="alert">Tarefa criada com sucesso.</div>';

            // Verifica se deve agendar o envio do e-mail
            if ($aviso == 'agora') {
                enviarEmail($user_email, $titulo, $descricao, $data_conclusao);
          
            }
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Erro: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Erro na preparação da consulta: ' . $mysqli->error . '</div>';
    }

    $mysqli->close();
}

function enviarEmail($to, $subject, $body, $date) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gestordetarfeas@gmail.com';
        $mail->Password   = 'daia rcvt suui afmu';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('gestordetarfeas@gmail.com', 'Gestor de Tarefas');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Aviso de Tarefa: ';
        $mail->Body    = 'Tem uma nova tarefa: <b>' . $subject . '</b><br>' . $body . '<br>Data de conclusão: ' . $date;
        $mail->AltBody = 'Tem uma nova tarefa: ' . $subject . "\n" . $body . "\nData de conclusão: " . $date;

        $mail->send();
        global $alert;
        $alert = '<div class="alert alert-success" role="alert">Aviso enviado com sucesso.</div>';
    } catch (Exception $e) {
        global $alert;
        $alert = '<div class="alert alert-danger" role="alert">Erro ao enviar aviso: ' . $mail->ErrorInfo . '</div>';
    }
}

/*function inserirEmailAgendado($to, $subject, $body, $date, $aviso) {
    global $mysqli, $alert;

    $sql = "INSERT INTO emails_agendados (to_email, subject, body, data_envio) VALUES (?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $data_envio = date('Y-m-d H:i:s', strtotime($date));
        $stmt->bind_param("ssss", $to, $subject, $body, $data_envio);
        $stmt->execute();
        $stmt->close();
        $alert = '<div class="alert alert-success" role="alert">Email agendado com sucesso.</div>';
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Erro na preparação da consulta: ' . $mysqli->error . '</div>';
    }
}
?>

*/

