<?php


namespace App\Database\Driver;


abstract class BaseDriver
{

    protected string $host;
    protected string $fullHost;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->fullHost = $this->host . ":8000;charset=utf8";
    }

    abstract public function createUserAndDatabase();
    abstract public function query(string $query);
    abstract public function export();
    abstract public function import();

}