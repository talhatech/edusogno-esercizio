<?php
session_start();

try {
    require_once '../src/Controller/EventController.php';

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false) {
        header("Location: login.php");
        exit;
    }

    $eventController = new EventController();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add_event'])) {
            $nome_evento = $_POST['nome_evento'];
            $data_evento = $_POST['data_evento'];
            $eventController->create($nome_evento, $data_evento);
            // Add email sending functionality here for adding event
        } elseif (isset($_POST['edit_event'])) {
            $id = $_POST['event_id'];
            $nome_evento = $_POST['nome_evento'];
            $data_evento = $_POST['data_evento'];
            $eventController->update($id, $nome_evento, $data_evento);
            // Add email sending functionality here for editing event
        } elseif (isset($_POST['delete_event'])) {
            $id = $_POST['event_id'];
            $eventController->delete($id);
            // Add email sending functionality here for deleting event
        }
}

$events = $eventController->index();
include '../view/dashboard.html';

} catch (\Throwable $th) {
    echo($th->getMessage());
    die();
}
