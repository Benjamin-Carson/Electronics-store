<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");
session_start();

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['email'])){
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();

        $resetLink = "http://localhost:80443/week4/new_password.php?token=" . $token;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv("GMAIL_USER");
            $mail->Password = getenv("GMAIL_PASS");
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom(getenv("GMAIL_USER"), 'ElectroMart');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset';
            $mail->Body = "Click here to reset your password: $resetLink";

            $mail->send();
            $success = " Reset link sent to your email!";
        } catch (Exception $e) {
            $error = " Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    }
    elseif(!empty($_POST['phone'])){
        $phone = $_POST['phone'];
        $otp = rand(100000, 999999);

        $_SESSION['otp'] = $otp;
        $_SESSION['phone'] = $phone;

        $account_sid   = getenv("TWILIO_ACCOUNT_SID");
        $auth_token    = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");

        try {
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($phone, [
                'from' => $twilio_number,
                'body' => "Your ElectroMart OTP code is: $otp"
            ]);
            $success = " OTP sent to your phone!";
        } catch (Exception $e) {
            $error = " OTP could not be sent. Error: {$e->getMessage()}";
        }
    }
}
?>
