<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to autoload.php of PHPMailer

class EmailService {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        //Server settings
        $this->mail->isSMTP();                                            // Send using SMTP
        $this->mail->Host       = MAIL_HOST;                              // Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->mail->Username   = MAIL_USERNAME;                          // SMTP username
        $this->mail->Password   = MAIL_PASSWORD;                          // SMTP password
        $this->mail->SMTPSecure = MAIL_ENCRYPTION;                        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mail->Port       = MAIL_PORT;                              // TCP port to connect to
    }

    public function sendPasswordResetEmail($email, $token) {
        try {
            //Recipients
            $this->mail->setFrom('from@example.com', 'Your Name');
            $this->mail->addAddress($email);                                  // Add a recipient

            // Content
            $this->mail->isHTML(true);                                        // Set email format to HTML
            $this->mail->Subject = 'Password Reset';
            $this->mail->Body    = file_get_contents(__DIR__ . "/emails/auth/reset_password.html");
            $this->mail->Body    = str_replace('{token}', $token, $this->mail->Body); // Replace token placeholder with actual token

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
