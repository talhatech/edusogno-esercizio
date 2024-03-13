<?php
// Start session to manage login state
session_start();

// Include necessary files
require_once '../src/Controller/AuthController.php';

// Check if user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php"); // Redirect to dashboard if already logged in
    exit;

}

// Initialize AuthController
$authController = new AuthController();

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['email']) && !empty($_POST['password'])) {

    // Attempt to login
    if ($authController->login()) {
        // Redirect to dashboard on successful login
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect back to login on failure
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}
 elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['reset_token'])) {
    // Show password reset form...
} else {
    include '../view/login.html';
}

