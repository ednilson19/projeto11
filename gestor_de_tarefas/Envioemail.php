<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Crie uma nova instância do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->SMTPDebug = 0; // Ative a saída de debug detalhada (0 para desativar)
    $mail->isSMTP(); // Defina o e-mail para usar SMTP
    $mail->Host       = 'smtp.gmail.com'; // Defina o servidor SMTP do Gmail
    $mail->SMTPAuth   = true; // Ative a autenticação SMTP
    $mail->Username   = 'gestordetarfeas@gmail.com'; // Seu endereço de e-mail do Gmail
    $mail->Password   = 'daia rcvt suui afmu'; // Sua senha do Gmail
    $mail->SMTPSecure = 'tls'; // Habilite a criptografia TLS; `PHPMailer::ENCRYPTION_STARTTLS` também é aceitável
    $mail->Port       = 587; // Porta TCP para TLS

    // Destinatários
    $mail->setFrom('gestordetarfeas@gmail.com', 'Gestor de tarefas'); // Remetente
    $mail->addAddress('Ednilsonkapila@gmail.com', 'Nome do Destinatário'); // Adicione um destinatário

    // Conteúdo
    $mail->isHTML(true); // Defina o formato do e-mail para HTML
    $mail->Subject = 'Aqui está o assunto';
    $mail->Body    = 'Este é o corpo da mensagem <b>em HTML</b>';
    $mail->AltBody = 'Este é o corpo da mensagem em texto plano para clientes de e-mail que não suportam HTML';

    // Envie o e-mail
    $mail->send();
    echo 'Mensagem enviada com sucesso';
} catch (Exception $e) {
    echo "A mensagem não pôde ser enviada. Erro: {$mail->ErrorInfo}";
}