<?php

namespace App\Database\Driver;

use App\Entity\User;
use PDO;
use PDOException;

class MySQLDriver extends BaseDriver
{

    private User $user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function createUserAndDatabase(): void
    {
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:host=$host", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if ($pdo !== null) {
            $user = $this->user->getMariadbUser();
            $password = $this->user->getMariadbPassword();
            $h = $this->host;
            $pdo->query("CREATE USER '$user'@'$h' IDENTIFIED BY '$password';");
            $pdo->query("CREATE DATABASE $user");
            $pdo->query("GRANT ALL PRIVILEGES ON $user.* TO '$user'@'$h' IDENTIFIED BY '$password';");
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

    public function createQuery(string $query)
    {
        // TODO: Implement createQuery() method.
    }

    public function requestQuery(string $query)
    {
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:host=" . $host, 'root', 'root');
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if ($pdo !== null) {
            return $pdo->query($query)->fetchAll();
        }

        return [];
    }
}