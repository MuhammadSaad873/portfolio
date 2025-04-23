<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $message = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['message'])) : '';
    $url = isset($_POST['url']) ? htmlspecialchars(trim($_POST['url'])) : 'Not provided';
    $domain = isset($_POST['domain']) ? htmlspecialchars(trim($_POST['domain'])) : 'Not provided';
    $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : 'No Subject';



    // Check if Terms & Conditions were accepted
    if (!isset($_POST['terms'])) {
        die("<h1>Error: You must accept the Terms & Conditions.</h1>");
    }

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone)|| empty($message)) {
        die("<h1>Error: All fields are required.</h1>");
    }

    // Check email validation
    if (!$email) {
        die("<h1>Error: Invalid email address.</h1>");
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'leads@creativeagency360.com'; // Replace with your SMTP username
        $mail->Password = 'Digital2025*/-'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL for port 465
        $mail->Port = 465;

        $mail->setFrom('muhammadsaad.saad9752@gmail.com', 'Creative Agency 360');

        $mail->addAddress('muhammadsaad.saad9752@gmail.com', 'Leads Team');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Submission: $subject";
        $mail->Body = "
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
             <p><strong>Message:</strong> $message</p>
            <p><strong>Domain:</strong> $domain</p>
            <p><strong>URL:</strong> $url</p>
        ";
        // Send the email
        $mail->send();
        header("Location: thankyou.php");
        exit();

    } catch (Exception $e) {
        // Error handling
        echo "<h1>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</h1>";
    }
} else {
    echo "<h1>Invalid Request</h1>";
}
?>
