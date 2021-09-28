<?php
class DbConnection {
    private $host;
    private $username;
    private $password;
    private $database;

    protected $connection;

    public function __construct()
    {
        $this->host = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "employee_oop";

        if (! $this->connection) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->connection->error) {
                return $this->connection;
            }
        }

        return false;

    }
}
