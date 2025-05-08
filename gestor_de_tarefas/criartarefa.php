<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
include 'database.php';
include_once 'header.php';
if(session_status() == PHP_SESSION_NONE){
    session_start();
}


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
       
        exit;
    }

    
    $sql = "INSERT INTO tarefas (titulo, descricao, prioridade, data_conclusao, aviso, user_id) VALUES (?, ?, ?, ?, ?, ?)";
if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssssi", $titulo, $descricao, $prioridade, $data_conclusao, $aviso, $user_id);
    if ($stmt->execute()) {
        if ($aviso == 'agora') {
            enviarEmail($user_email, $titulo, $descricao, $data_conclusao);
        }
    }
    $stmt->close();
}

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
        $mail->Subject = 'Aviso de Tarefa ';
        $mail->Body    = 'Tem uma nova tarefa: <b>' . $subject . '</b><br>' . $body . '<br>Data de conclusão: ' . $date;
        $mail->AltBody = 'Tem uma nova tarefa: ' . $subject . "\n" . $body . "\nData de conclusão: " . $date;

        $mail->send();
        //global $alert;
        //$alert = '<div class="alert alert-success" role="alert">Aviso enviado com sucesso.</div>';
    } catch (Exception $e) {
        //global $alert;
       // $alert = '<div class="alert alert-danger" role="alert">Erro ao enviar aviso: ' . $mail->ErrorInfo . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="PT">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Criar Tarefa</title>
<link rel="stylesheet" href="estilos/stylecriartarefa.css">
</head>
<body>
<div class="container">
    <div id="form">
        <h1>Criar Tarefa</h1>
  
        <form action="" method="POST">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="prioridade">Prioridade:</label>
                <select class="form-control" id="prioridade" name="prioridade">
                    <option value="baixa">Baixa</option>
                    <option value="média">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="data_conclusao">Data de Conclusão:</label>
                <input type="datetime-local" class="form-control" id="data_conclusao" name="data_conclusao" required>
            </div>
            <div class="form-group">
                <label for="aviso">Aviso:</label>
                <select class="form-control" id="aviso" name="aviso" required>
                    <option value="nenhum">Nenhum</option>
                    <option value="agora">Enviar agora (Email) </option>
                </select>
            </div>
                    <button type="submit" class="btn btn-primary">Criar Tarefa</button>
        </form>
    </div>
</div>
</body>
</html>
