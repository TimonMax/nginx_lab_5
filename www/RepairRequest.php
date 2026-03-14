<?php
// RepairRequest.php
class RepairRequest {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function add(string $name, string $model, ?string $email, string $service, int $warranty, string $term): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO requests (name, model, email, service, warranty, term) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $model, $email, $service, $warranty, $term]);
        return (int)$this->pdo->lastInsertId();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM requests ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM requests WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function update(int $id, array $data): bool {
        $fields = [];
        $values = [];
        foreach ($data as $k => $v) {
            if (in_array($k, ['name','model','email','service','warranty','term'])) {
                $fields[] = "$k = ?";
                $values[] = $v;
            }
        }
        if (empty($fields)) return false;
        $values[] = $id;
        $sql = "UPDATE requests SET " . implode(", ", $fields) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM requests WHERE id = ?");
        return $stmt->execute([$id]);
    }
}