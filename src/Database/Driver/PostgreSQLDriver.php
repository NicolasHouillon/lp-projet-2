<?php

namespace App\Database\Driver;

use App\Entity\User;
use PDO;
use PDOException;

class PostgreSQLDriver extends BaseDriver
{

    private User $user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function createUserAndDatabase()
    {
        $host = $this->host;
        try {
            $pdo = new PDO("pgsql:host=$host;port=7000;user=root;password=root");
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if($pdo !== null) {
            $user = $this->user->getPgsqlUser();
            $password = $this->user->getPgsqlPassword();
            $pdo->query("CREATE DATABASE " . $user . " OWNER " . $user);
            $pdo->query("CREATE USER '" . $user . "'@'". $host . "' WITH PASSWORD ' " . $password . "';");
        }
    }

    public function query(string $query): array
    {
        // TODO: Implement query() method.
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