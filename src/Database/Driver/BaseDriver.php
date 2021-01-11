<?php


namespace App\Database\Driver;


abstract class BaseDriver
{

    protected string $host;
    protected string $fullHost;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->fullHost = $this->host . ":3306;charset=utf8";
    }

    abstract public function createUserAndDatabase();
    abstract public function createQuery(string $query);
    abstract public function requestQuery(string $query);
    abstract public function export();
    abstract public function import();

}