<?php

require_once __DIR__ . '/../Core/Database.php';

class Event {
    // Database connection and table name
    private $db;
    private $table_name = "events";

    // Constructor with $db as database connection
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }
    
    public function getAllEvents() {
        $stmt = $this->db->prepare("SELECT * FROM $this->table_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($nome_evento, $data_evento) {
        $stmt = $this->db->prepare("INSERT INTO $this->table_name (nome_evento, data_evento) VALUES (:nome_evento, :data_evento)");
        $stmt->bindParam(':nome_evento', $nome_evento);
        $stmt->bindParam(':data_evento', $data_evento);
        return $stmt->execute();
    }

    public function updateEvent($id, $nome_evento, $data_evento) {
        $stmt = $this->db->prepare("UPDATE $this->table_name SET nome_evento = :nome_evento, data_evento = :data_evento WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome_evento', $nome_evento);
        $stmt->bindParam(':data_evento', $data_evento);
        return $stmt->execute();
    }

    public function deleteEvent($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table_name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
