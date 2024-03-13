<?php
session_start();
require_once '../src/Controller/AuthController.php';

$authController = new AuthController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Validate token
    if ($authController->validateResetToken($email, $token)) {
        // Reset password
        $authController->resetPassword($email, $password);

        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        // Token invalid or expired
        // Handle error or redirect as needed
    }
}
