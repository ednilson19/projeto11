<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'stayfit1101@gmail.com';
        $mail->Password = 'luxhktksidbjfnhc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        

        $mail->setFrom('stayfit1101@gmail.com', 'StayFit');
        $mail->addAddress('Ednilsonkapila@gmail.com'); // Set the recipient email address
        $mail->Subject = 'Contact Form Submission';

        $emailBody = "Name: $name<br>";
        $emailBody .= "Email: $email<br>";
        $emailBody .= "Message: $message<br>";

        $mail->isHTML(true);
        $mail->Body = $emailBody;

        try {
            $mail->send();
            echo 'Message sent successfully!';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'Please fill in all the required fields.';
    }
}
?>
