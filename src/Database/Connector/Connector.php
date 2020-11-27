<?php

namespace App\Database\Connector;

interface Connector
{

    public function createUserAndDatabase();
    public function export();
    public function import();

}