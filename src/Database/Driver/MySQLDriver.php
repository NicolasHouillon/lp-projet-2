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
            $pdo = new PDO("mysql:host=$host", $_ENV['DB_USER'], $_ENV['DB_PWD']);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }


        if ($pdo !== null) {

            $user = $this->user->getMariadbUser();
            $password = $this->user->getMariadbPassword();
            $h = $this->host;
            $pdo->query("DROP USER IF EXISTS '$user'@'$h'");
            $pdo->query("CREATE USER '$user'@'$h' IDENTIFIED BY '$password';");
            $pdo->query("DROP DATABASE IF EXISTS " . $user);
            $pdo->query("CREATE DATABASE $user");
            $pdo->query("GRANT ALL ON $user.* TO '$user'@'$h';");
            $pdo->query("GRANT SELECT ON projet_lp_2.* TO '$user'@'$h';");


        }
    }


    public function export()
    {
        $username = $this->user->getMariadbUser();
        $password = $this->user->getMariadbPassword();
        system("mysql -u$username -p$password $username > $username'_mysql'.dump.sql");
    }


    public function createQuery(string $query)
    {
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:dbname=".$this->user->getMariadbUser().";host=" . $host, $this->user->getMariadbUser(), $this->user->getMariadbPassword());
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if ($pdo !== null) {
            $result = $pdo->prepare($query);
            if ($result !== false) {
                $result->execute();
                return $result->errorInfo();
            }
        }
        return [];
    }

    public function requestQuery(string $query)
    {
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:dbname=".$_ENV['DB_MYSQL'].";host=" . $host, $_ENV['DB_USER'], $_ENV['DB_PWD']);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }

        if ($pdo !== null) {
            $result = $pdo->prepare($query);
            $result->execute();
            if ($result !== false) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return [];
    }

    public function suppression()
    {
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:dbname=".$this->user->getMariadbUser().";host=" . $host, $this->user->getMariadbUser(), $this->user->getMariadbPassword());
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