<?php

namespace App\repository;

use App\model\Status;
use App\model\Task;
use PDO;

class TaskRepository
{

    private $db;
    private $table = 'task';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $taskId): ?Task
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->execute(['id' => $taskId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveTask(Task $task): bool
    {
        if ($task->getId() === null) {
            return $this->insert($task);
        }

        return $this->update($task);
    }

    private function insert(Task $task)
    {
        $sql = "INSERT INTO " . $this->table . "  (description, status) VALUES (:description, :status)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':description' => $task->getDescription(),
            ':status' => $task->getStatus()
        ]);
    }

    private function update(Task $task)
    {
        $query = "UPDATE " . $this->table . " SET description = :description WHERE id = :id";
        return $this->db->prepare($query)->execute(['description' => $task->getDescription(), 'id' => $task->getId()]);
    }


    public function delete(int $taskId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        return $this->db->prepare($query)->execute(['id' => $taskId]);
    }

    public function checkedTaskDone(int $taskId)
    {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        return $this->db->prepare($query)->execute(['status' => Status::DONE, 'id' => $taskId]);
    }

    public function findAllTaskDone(): array
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = :status";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['status' => Status::DONE]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllTaskDoing(): array
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = :status";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['status' => Status::DOING]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifieStatusTaskById(int $taskId): string
    {
        $query = "SELECT status FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $taskId]);
        return $stmt->fetchColumn();
    }

}