<?php

namespace App\Database\Driver;

use App\Entity\User;
use Composer\Factory;
use SQLite3;

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
        new SQLite3($this->user->getSqlitePath());
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
        $sqlite = new SQLite3($this->user->getSqlitePath());
        return $sqlite->query($query)->fetchArray(SQLITE3_ASSOC);
    }

    public function suppression()
    {
        // TODO: Implement suppression() method.
    }
}