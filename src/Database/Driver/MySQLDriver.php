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
            $pdo = new PDO("mysql:host=$host", 'root', 'Coucoutoi++12');
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(1);
        }


        if ($pdo !== null) {

            $user = $this->user->getMariadbUser();
            $password = $this->user->getMariadbPassword();
            $h = $this->host;
//            dd($pdo, $user, $password, $h);
            $pdo->query("CREATE USER '$user'@'$h' IDENTIFIED BY '$password';");
            $pdo->query("CREATE DATABASE $user");
            $pdo->query("GRANT ALL ON $user.* TO '$user'@'$h';");
            $pdo->query("GRANT SELECT ON projet_lp_2.* TO '$user'@'$h';");


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
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:dbname=".$this->user->getMariadbUser().";host=" . $host, $this->user->getMariadbUser(), $this->user->getMariadbPassword());
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
        $host = $this->fullHost;
        try {
            $pdo = new PDO("mysql:dbname=projet_lp_2;host=" . $host, $_ENV['DB_USER'], $_ENV['DB_PWD']);
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

        return $result->errorInfo();
    }
}