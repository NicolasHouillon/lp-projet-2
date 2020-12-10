<?php

namespace App\Database\Connector;

use App\Entity\User;

class SQLiteConnector extends BaseDriver
{

    private User $user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function createUserAndDatabase()
    {
        // TODO: Implement createRolesAndDatabase() method.
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