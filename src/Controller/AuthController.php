<?php
// Require or include necessary files
require_once '../src/Model/User.php';

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->model->findUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                // ... Set any other session variables you need
                return true;
            }
        }
        return false;
    }

    public function register()
    {

        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if user already exists
        $existingUser = $this->model->findUserByEmail($email);
        if ($existingUser) {
            return false; // User already exists
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create new user record
        $createSuccess = $this->model->createUser($nome, $cognome, $email, $hashedPassword);

        return $createSuccess;
    }

    public function sendPasswordResetEmail($email)
    {
        $user = $this->model->findUserByEmail($email);
        if ($user) {
            $token = $this->model->generatePasswordResetToken($email);
             if (EmailService::sendPasswordResetEmail($email, $token)) {
                echo "Password reset email sent successfully.";
            } else {
                echo "Failed to send password reset email.";
            }
        }
    }

    public function validateResetToken($email, $token)
    {
        // Validate if token matches the one stored in the database for the given email
        // Return true if valid, false otherwise
    }

    public function resetPassword($email, $password)
    {
        // Reset the password for the given email
    }
}
