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
            $pdo = new PDO("pgsql:host=$host;port=5432");
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if($pdo !== null) {
            $user = $this->user->getPgsqlUser();
            $password = $this->user->getPgsqlPassword();
            $pdo->query("CREATE ROLE " . $user . " createdb");
            $pdo->query("CREATE USER " . $user . " WITH PASSWORD '" . $password . "';");
            $pdo->query("CREATE DATABASE " . $user . " OWNER " . $user);
        }
    }

    public function export()
    {
        // TODO: Implement export() method.
    }


    public function createQuery(string $query)
    {
        try {
            $pdo = new PDO("pgsql:dbname=".$this->user->getPgsqlUser());
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if ($pdo !== null) {
            $result = $pdo->prepare($query);
            $result->execute();
//            return [$pdo, $result->errorInfo()];
            if ($result !== false) {
//                return [$result];
                return $result->errorInfo();
            }
        }
        return [];
    }

    public function requestQuery(string $query)
    {
        try {
            $pdo = new PDO("pgsql:dbname=admin");
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if ($pdo !== null) {
            $result = $pdo->prepare($query);
            $result->execute();
//            return [$pdo, $result->errorInfo()];
            if ($result !== false) {
//                return [$result];
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return [];
    }

    public function suppression()
    {
        try {
            $pdo = new PDO("pgsql:dbname=admin");
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }
        $result = $pdo->prepare('DROP DATABASE '.$this->user->getMariadbUser());
        $result->execute();

        $result = $pdo->prepare('CREATE DATABASE '.$this->user->getMariadbUser());
        $result->execute();
    }
}