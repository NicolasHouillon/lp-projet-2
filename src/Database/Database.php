<?php

namespace App\Database;

use App\Database\Driver\BaseDriver;
use App\Database\Driver\MySQLDriver;
use App\Database\Driver\PostgreSQLDriver;
use App\Database\Driver\SQLiteConnector;
use App\Entity\User;
use InvalidArgumentException;

class Database
{

    private ?User $user;
    private string $db;
    private MySQLDriver $msConnector;
    private PostgreSQLDriver $pgConnector;
    private SQLiteConnector $sqConnector;

    public function __construct(string $db, ?User $user = null)
    {
        $this->msConnector = new MySQLDriver($user);
        $this->pgConnector = new PostgreSQLDriver($user);
        $this->sqConnector = new SQLiteConnector($user);
        $this->db = $db;
        $this->user = $user;
    }

    /**
     * Crée les utilisateurs et les bases de données pour l'utilisateur qui vient de s'inscrire
     * @param User $user
     */
    public static function onRegister(User $user): void {
        $dbs = [
            new MySQLDriver($user),
//            new PostgreSQLDriver($user),
            new SQLiteConnector($user)
        ];

        foreach ($dbs as $db) {
            /** @var $db BaseDriver */
            $db->createUserAndDatabase();
        }
    }

    public function createQuery(string $query): array
    {
        switch ($this->db) {
            case "mysql":
                return $this->msConnector->createQuery($query);
            case "postgre":
                return $this->pgConnector->createQuery($query);
            case "sqlite":
                return $this->sqConnector->createQuery($query);
            default:
                throw new InvalidArgumentException("Database should be mysql, postgre or sqlite");
        }
    }

    public function requestQuery(string $query): array
    {
        switch ($this->db) {
            case "mysql":
                return $this->msConnector->requestQuery($query);
            case "postgre":
                return $this->pgConnector->requestQuery($query);
            case "sqlite":
                return $this->sqConnector->requestQuery($query);
            default:
                throw new InvalidArgumentException("Database should be mysql, postgre or sqlite");
        }
    }

}