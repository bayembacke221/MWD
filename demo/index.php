<?php
namespace App;
define('BASE_PATH', __DIR__);
define('BASE_URL', '/MWD/demo/');

require_once 'model/Task.php';
require_once 'model/Status.php';

require_once 'config/Database.php';
require_once 'repository/TaskRepository.php';
require_once 'service/TaskService.php';
require_once 'controller/TaskController.php';

$database = new Config\Database();
$dbConnection = $database->getConnection();

$taskRepository = new Repository\TaskRepository($dbConnection);
$taskService = new Service\TaskService($taskRepository);
$taskController = new Controller\TaskController($taskService);

$page = $_GET['page'] ?? null;
$_id = $_GET['_id'] ?? null;

switch ($page) {
    case 'store':
        header('Content-Type: application/json');
        $json = file_get_contents('php://input');
        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            // Debug
            error_log('Received data: ' . print_r($data, true));

            $taskController->store();
        } catch (\JsonException $e) {
            error_log('Error decoding JSON: ' . $e->getMessage());
            echo json_encode(['success' => false], JSON_THROW_ON_ERROR);
            exit;
        }

        break;
    case 'delete':
        $taskController->delete($_id);
        break;
    case 'done':
        $taskController->done($_id);
        break;
    case 'doneList':
        $taskController->doneList();
        break;
    case 'doingList':
        $taskController->doingList();
        break;
    default:
        $taskController->index();
        break;
}