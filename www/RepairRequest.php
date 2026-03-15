<?php

class RepairRequest {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Добавить запись и вернуть ID
    public function add($name, $model, $email, $service, $warranty, $term) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO requests (name, model, email, service, warranty, term) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $model, $email, $service, $warranty, $term]);
        return (int)$this->pdo->lastInsertId();
    }


    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM requests ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM requests WHERE id = ?");
        $stmt->execute([(int)$id]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    public function update($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE requests SET name = ? WHERE id = ?");
        return $stmt->execute([$name, (int)$id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM requests WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }
}