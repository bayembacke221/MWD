<?php
namespace App\Config;
class Database {

    private $host = 'localhost';
    private $username ='root';
    private $password = '';
    private $database = 'task_management';

    public function getConnection()
    {
        return new \PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
    }

}