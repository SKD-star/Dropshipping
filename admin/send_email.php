<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// $mail = new PHPMailer(true);

// try {
//     $mail->isSMTP();                                              
//     $mail->Host       = 'smtp.sendgrid.net';                        
//     $mail->SMTPAuth   = true;                                       
//     $mail->Username   = 'apikey';                                   
//     $mail->Password   = getenv('SENDGRID_API_KEY') ?: 'YOUR_SENDGRID_API_KEY';
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;             
//     $mail->Port       = 587;                                        

//     $mail->setFrom('concierge@lumina-atelier.com', 'Lumina Atelier');          
//     $mail->addAddress('client@example.com', 'Client Name');  

//     $mail->isHTML(true);                                            
//     $mail->Subject = 'Test Email from SendGrid with PHPMailer';
//     $mail->Body    = 'Hello, this is a test email sent via SendGrid SMTP with PHPMailer.';

//     if ($mail->send()) {
//         echo 'Message has been sent';
//     } else {
//         echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
//     }
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
?>


<?php
// require '../vendor/autoload.php'; // Include PHPMailer
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;


class EmailHandler {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
    }

    // Function to configure SMTP settings
    private function configureSMTP() {
        // SMTP settings
        $this->mail->isSMTP();
        $this->mail->Host = getenv('SMTP_HOST') ?: 'smtp.sendgrid.net';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('SENDGRID_USERNAME') ?: 'apikey';
        $this->mail->Password = getenv('SENDGRID_API_KEY') ?: 'YOUR_SENDGRID_API_KEY';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
    }

    // Function to send OTP email
    public function sendOtpEmail($recipientEmail, $otp) {
        try {
            // Configure SMTP
            $this->configureSMTP();

            // Recipients

            $this->mail->setFrom('bullwagon382@gmail.com', 'Bull Wagon');
            $this->mail->addAddress($recipientEmail);

            // Optionally, add an embedded image
            // if ($imagePath) {
            //     $this->mail->addEmbeddedImage($imagePath, 'image_cid');
            // }

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Your OTP for Login';
            $this->mail->Body = "
                <h1>Login OTP</h1>
                <p>Your OTP is <strong>$otp</strong>.</p>
                <p>Please enter this OTP in the login form to proceed.</p>
                ";
                // <p><img src='cid:image_cid' alt='Embedded Image' /></p>
                
            // Send the email
            $this->mail->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false; // Something went wrong
        }
    }

    public function sendBasicEmail($recipientEmail, $subject, $bodyContent) {
        try {
            $this->configureSMTP();

            $this->mail->setFrom('bullwagon382@gmail.com', 'Bull Wagon');
            $this->mail->addAddress($recipientEmail);

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $bodyContent;

            // Send the email
            $this->mail->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false; // Something went wrong
        }
    }
}
?>
