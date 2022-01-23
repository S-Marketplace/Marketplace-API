<?php


namespace App\Libraries;


use Config\Services;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Notification
{
   
    /**
     * sendEmail
     * 
     * Fungsi untuk mengirim email
     *
     * @param  string $email
     * @param  string $subject
     * @param  string $pesan
     * @param  bool $debug
     * 
     * @return bool
     */
    public static function sendEmail($email, $subject, $pesan, $debug = true)
    {
        $mail = new PHPMailer(true);

        try {

            $host       = 'mail.menyambang.id';
            $username   = 'notification@menyambang.id';
            $password   = 'menyambang007';
            $name       = 'Menyambang.id';
            
            //Server settings
            if ($debug) {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            }

            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->Host       = $host;
            $mail->Username   = $username;
            $mail->Password   = $password;

            //Recipients
            $mail->setFrom($username, $name);
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $pesan;

            return $mail->send();
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e,
            ];
        }
    }
}
