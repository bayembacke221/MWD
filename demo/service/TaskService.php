<?php

namespace App\service;
use App\model\Task;

class TaskService
{
    private  $taskRepository;

    public function __construct($taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function findAll(): array
    {
        return $this->taskRepository->findAll();
    }

    public function findById(int $taskId): ?Task
    {
        return $this->taskRepository->findById($taskId);
    }

    public function saveTask(Task $task): bool
    {
        return $this->taskRepository->saveTask($task);
    }

    public function delete(int $taskId): bool
    {
        return $this->taskRepository->delete($taskId);
    }

    public function checkedTaskDone(int $taskId): bool
    {
        return $this->taskRepository->checkedTaskDone($taskId);
    }

    public function findAllTaskDone(): array
    {
        return $this->taskRepository->findAllTaskDone();
    }

    public function findAllTaskDoing(): array
    {
        return $this->taskRepository->findAllTaskDoing();
    }

    public function verifieStatusTaskById(int $taskId): string
    {
        return $this->taskRepository->verifieStatusTaskById($taskId);
    }

}