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
//        $sqlite = new SQLite3($this->user->getSqlitePath());
//        $requete = ".output public/".$this->user->getMariadbUser()."_sqlite.dump.sql"
//        $sqlite->exec($requete);
//        $sqlite->exec('.dump');
    }


    public function createQuery(string $query)
    {
        $sqlite = new SQLite3($this->user->getSqlitePath());
        try{
            $result = $sqlite->exec($query);
        }
        catch (\Exception $exception){
            $suppr = "Warning: SQLite3::exec():";
            $message =$exception->getMessage();
            return substr($message,strlen($suppr));
        }
        return true;
    }

    public function requestQuery(string $query)
    {
        $data = [];
        $sqlite = new SQLite3($_ENV['DB_SQLITE']);
        $results = $sqlite->query($query);
        while ($res= $results->fetchArray(1))
        {
            array_push($data, $res);

        }
        return $data;
    }

    public function suppression()
    {
        unlink($this->user->getSqlitePath());
        new SQLite3($this->user->getSqlitePath());
    }
}