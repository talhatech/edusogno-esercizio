<?php
require_once __DIR__ . '/../Core/Database.php';

class User
{
    // Database connection and table name
    private $db;
    private $table_name = "users";

    // Constructor with $db as database connection
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function generatePasswordResetToken($email)
    {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the token in the database
        $stmt = $this->db->prepare("UPDATE $this->table_name SET reset_token = :token WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $token;
    }
    
    public function findUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table_name WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($nome, $cognome, $email, $hashedPassword)
    {
        $stmt = $this->db->prepare("INSERT INTO $this->table_name (nome, cognome, email, password) VALUES (:nome, :cognome, :email, :password)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cognome', $cognome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }
}
