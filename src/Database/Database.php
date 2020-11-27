<?php

namespace App\Database;

use App\Database\Connector\Connector;
use App\Database\Connector\MySQLConnector;
use App\Database\Connector\PostgreSQLConnector;
use App\Database\Connector\SQLiteConnector;
use App\Entity\User;

class Database
{

    private User $user;
    private MySQLConnector $msConnector;
    private PostgreSQLConnector $pgConnector;
    private SQLiteConnector $sqConnector;

    public function __construct(User $user)
    {
        $this->msConnector = new MySQLConnector($user);
        $this->pgConnector = new PostgreSQLConnector($user);
        $this->sqConnector = new SQLiteConnector($user);
        $this->user = $user;
    }

    /**
     * Crée les utilisateurs et les bases de données pour l'utilisateur qui vient de s'inscrire
     * @param User $user
     */
    public static function onRegister(User $user): void {
        $dbs = [
            new MySQLConnector($user),
            new PostgreSQLConnector($user),
            new SQLiteConnector($user)
        ];

        foreach ($dbs as $db) {
            /** @var $db Connector */
            $db->createUserAndDatabase();
        }
    }

}