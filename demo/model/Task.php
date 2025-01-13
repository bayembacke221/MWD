<?php
namespace App\model;

class Task {
    private ?int $id=null;
    private $description;
    private $status;

    public function __construct(array $data = [])
    {
        $this->description = $data['description'] ?? '';
        $this->status = $data['status'] ?? '';
    }

    // Getters
    public function getId(): ?int
    { return $this->id; }
    public function getDescription() { return $this->description; }
    public function getStatus() { return $this->status; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setDescription($description) { $this->description = $description; }
    public function setStatus($status) { $this->status = $status; }
}