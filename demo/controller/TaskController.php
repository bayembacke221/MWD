<?php
namespace App\controller;
use App\model\Task;
use App\model\Status;
class TaskController
{
    private  $taskService;
    public function __construct($taskService)
    {
        $this->taskService = $taskService;
    }
    public function index()
    {
        $tasks = $this->taskService->findAll();
        require 'view/task.php';
    }

    /**
     * @throws \JsonException
     */
    public function store()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            if ($data === null) {
                throw new \RuntimeException('Invalid JSON data');
            }

            $task = new Task([
                'description' => $data['description'],
                'status' => Status::TODO
            ]);

            $success = $this->taskService->saveTask($task);

            header('Content-Type: application/json');
            echo json_encode(['success' => $success], JSON_THROW_ON_ERROR);
            exit;

        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ], JSON_THROW_ON_ERROR);
            exit;
        }
    }
    public function delete(int $taskId)
    {
        $this->taskService->delete($taskId);
        header('Location: /');
    }
    public function done(int $taskId)
    {
        $this->taskService->checkedTaskDone($taskId);
        header('Location: /');
    }
    public function doneList()
    {
        $tasks = $this->taskService->findAllTaskDone();
        require 'view/task.php';
    }
    public function doingList()
    {
        $tasks = $this->taskService->findAllTaskDoing();
        require 'view/task.php';
    }

}