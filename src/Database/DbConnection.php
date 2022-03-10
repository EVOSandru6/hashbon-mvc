<?php

namespace App\Database;

use PDO;

class DbConnection
{
    private static $instance = null;

    private PDO $connection;

    // todo лучше брать из env
    private string $host = 'localhost';
    private string $user = 'postgres';
    private string $pass = 'postgres';
    private string $name = 'hashbon_mvc_db';
    private int $port = 5432;

    public function __construct()
    {
        $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->name";

        $this->connection = new PDO($dsn, $this->user, $this->pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DbConnection();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}