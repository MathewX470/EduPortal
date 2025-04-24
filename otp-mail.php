<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['sendotp'])) {
    // Sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Database connection
    /*$conn = new mysqli("localhost", "root", "root123", "eduportal");
    if ($conn->connect_error) {
        die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
    }*/

    include("connection.php");

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM logincredentials WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Email exists in the database
        $_SESSION['email'] = $email;
        $otp = rand(1000, 9999); // Generate OTP
        $_SESSION['otp2'] = $otp; // Store OTP in session

        // Create PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mathewpunnen8281@gmail.com';  // Use environment variable here
            $mail->Password   = 'wldesebgozcegend';     // Use environment variable here
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Email content
            $mail->setFrom('mathewpunnen8281@gmail.com', 'EduPortal');
            $mail->addAddress($email); // Recipient's email

            $mail->isHTML(true);
            $mail->Subject = 'OTP Verification';
            $mail->Body    = "Your OTP for password recovery is: <b>{$otp}</b>";

            // Send the email
            $mail->send();
            echo "<script>alert('OTP has been sent to your email.');</script>";
            header('Location: verify-otp.php');
            exit;
        } catch (Exception $e) {
            echo "<p class='error'>Failed to send OTP. Error: {$mail->ErrorInfo}</p>";
        }
    } else {
        // Email not found
        echo "<script>alert('No account found with this email address. Redirecting to login page.');</script>";
        echo "<script>window.location.href='login.php';</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p class='error'>Invalid request!</p>";
}
