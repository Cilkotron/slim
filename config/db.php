<?php

class DB
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $dbname = 'slim_api';

    public function connect()
    {
        try {
            $conn_string = "mysql:host=$this->host;dbname=$this->dbname";
            $conn = new PDO($conn_string, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
           var_dump($e->getMessage());
        } finally {
            echo "DB connection";
        }
    }
}
