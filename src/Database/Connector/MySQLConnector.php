<?php

namespace App\Database\Connector;

use App\Entity\User;
use PDO;
use PDOException;

class MySQLConnector implements Connector
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUserAndDatabase(): void {
        $host = $_ENV['DB_HOST'] . ":8000;charset=utf8";
        try {
            $pdo = new PDO("mysql:host=" . $host, 'root', 'root');
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if($pdo !== null) {
            $user = $this->user->getMariadbUser();
            $password = $this->user->getMariadbPassword();
            $pdo->query("CREATE USER '" . $user . "'@'". $host . "' IDENTIFIED BY ' " . $password . "';");
            $pdo->query("CREATE DATABASE " . $user);
            $pdo->query("GRANT ALL PRIVILEGES ON " . $user . ".* TO '" . $user . "'@'" . $host . "' IDENTIFIED BY '" . $password . "';");
        }
    }

    public function export()
    {
        // TODO: Implement export() method.
    }

    public function import()
    {
        // TODO: Implement import() method.
    }

}