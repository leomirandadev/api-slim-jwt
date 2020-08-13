<?php
namespace Settings;

use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;

class ConnectionDB
{
    protected $db;

    public function connect()
    {
        $driver = new Mysql([
            'database' => '%DBNAME%',
            'host' => 'db',
            'username' => 'root',
            'password' => 'root',
        ]);

        $this->db = new Connection([
            'driver' => $driver,
        ]);
    }
}
