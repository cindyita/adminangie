<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * The function `sendEmail` sends an email to a recipient with specified content and configuration
 * settings.
 * 
 * @param recipient Recipient's email address where the email will be sent.
 * @param recipientName The `sendEmail` function you provided takes in four parameters:
 * @param subject The `subject` parameter in the `sendEmail` function is used to specify the subject
 * line of the email that will be sent to the recipient. It typically contains a brief summary or
 * description of the email content.
 * @param content The `sendEmail` function takes in four parameters:
 * 
 * @return -The `sendEmail` function is returning the result of the `createEmailSMTP` function, which is
 * responsible for sending an email using SMTP with the provided parameters such as sender, recipient,
 * subject, content, and email configuration settings.
 */
function sendEmail($recipient,$recipientName,$subject,$content){
    $emailContent = '<div style="color:red;">'.$content.'</div>';
    $config = [
        "host"=>$_ENV['EMAIL_HOST'],
        "username"=>$_ENV['EMAIL_USERNAME'],
        "password"=>$_ENV['EMAIL_PASS'],
        "port"=>$_ENV['EMAIL_PORT']
    ];
    $res = createEmailSMTP($_ENV['EMAIL_ADDRESS'], $_ENV['EMAIL_NAME'], $recipient, $recipientName, $subject, $emailContent, $config);
    return $res;
}

/**
 * Función para enviar un correo electrónico utilizando SMTP y PHPMailer.
 *
 * @param string $sender Correo electrónico del remitente.
 * @param string $senderName Nombre del remitente.
 * @param string $recipient Correo electrónico del destinatario.
 * @param string $recipientName Nombre del destinatario.
 * @param string $subject Asunto del correo electrónico.
 * @param string $emailTemplate Plantilla HTML del correo electrónico.
 * @param array $config Configuración de SMTP, incluyendo host, username, password y port.
 */
function createEmailSMTP($sender, $senderName, $recipient, $recipientName, $subject, $emailTemplate, $config) {

    $mail = new PHPMailer(true);
    try {

        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = $config['port'];

        $mail->setFrom($sender, $senderName);
        $mail->addAddress($recipient, $recipientName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $emailTemplate;

        if($mail->send()){
            return 1;
        }else{
            return "email failed";
        }
        
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
