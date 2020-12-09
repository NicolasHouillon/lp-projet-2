<?php

namespace App\Database;

use App\Database\Connector\BaseDriver;
use App\Database\Connector\MySQLDriver;
use App\Database\Connector\PostgreSQLDriver;
use App\Database\Connector\SQLiteConnector;
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
//            new SQLiteConnector($user)
        ];

        foreach ($dbs as $db) {
            /** @var $db BaseDriver */
            $db->createUserAndDatabase();
        }
    }

    public function query(string $query): array
    {
        switch ($this->db) {
            case "mysql":
                return $this->msConnector->query($query);
            case "postgre":
                return $this->pgConnector->query($query);
            case "sqlite":
                return $this->sqConnector->query($query);
            default:
                throw new InvalidArgumentException("Database should be mysql, postgre or sqlite");
        }
    }

}