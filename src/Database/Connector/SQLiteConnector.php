<?php

namespace App\Database\Connector;

use App\Entity\User;

class SQLiteConnector implements Connector
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUserAndDatabase()
    {
        // TODO: Implement createRolesAndDatabase() method.
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