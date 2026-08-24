<?php

namespace DraAnaLuiza\Services;

use PHPMailer\PHPMailer\PHPMailer;

final class EmailService
{
    public static function enviar(string $destinatario, string $assunto, string $mensagem): bool
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = 'gaferg2004@gmail.com';
            $mail->Password = 'wqbs viaf fdev qnio';
            $mail->setFrom('gaferg2004@gmail.com', 'Dra. Ana Luiza - Fisioterapia');
            $mail->addAddress($destinatario);
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;
            $mail->CharSet = 'UTF-8';
            $mail->send();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
