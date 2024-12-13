<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dreychen17@gmail.com';
        $mail->Password = 'KwetiawAus'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('dreychen17@gmail.com');
        $mail->addReplyTo($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Portfolio Contact: $subject";
        $mail->Body = "
            <h2>New Contact Form Message</h2>
            <table style='border-collapse: collapse; width: 100%;'>
                <tr>
                    <th style='text-align: left; padding: 8px; border: 1px solid #ddd;'>Name</th>
                    <td style='padding: 8px; border: 1px solid #ddd;'>$name</td>
                </tr>
                <tr>
                    <th style='text-align: left; padding: 8px; border: 1px solid #ddd;'>Email</th>
                    <td style='padding: 8px; border: 1px solid #ddd;'>$email</td>
                </tr>
                <tr>
                    <th style='text-align: left; padding: 8px; border: 1px solid #ddd;'>Phone</th>
                    <td style='padding: 8px; border: 1px solid #ddd;'>$phone</td>
                </tr>
                <tr>
                    <th style='text-align: left; padding: 8px; border: 1px solid #ddd;'>Subject</th>
                    <td style='padding: 8px; border: 1px solid #ddd;'>$subject</td>
                </tr>
                <tr>
                    <th style='text-align: left; padding: 8px; border: 1px solid #ddd;'>Message</th>
                    <td style='padding: 8px; border: 1px solid #ddd;'>$message</td>
                </tr>
            </table>
        ";
        
        $mail->send();
        echo json_encode([
            'status' => 'success',
            'message' => 'Message has been sent successfully'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Message could not be sent. Error: ' . $mail->ErrorInfo
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?>