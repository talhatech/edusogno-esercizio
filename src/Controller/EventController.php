<?php
// Require or include necessary files
require_once __DIR__ . '/../Model/Event.php';

class EventController {
    protected $model;

    public function __construct() {
        $this->model = new Event();
    }

    public function index() {
       return $this->model->getAllEvents();
    }

    public function create($nome_evento, $data_evento) {
        return $this->model->createEvent($nome_evento, $data_evento);
    }

    public function update($id, $nome_evento, $data_evento) {
        return $this->model->updateEvent($id, $nome_evento, $data_evento);
    }

    public function delete($id) {
        return $this->model->deleteEvent($id);
    }
}
