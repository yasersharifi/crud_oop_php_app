<?php
require_once "DbConnection.php";
class Users extends DbConnection {
    public function __construct()
    {
        parent::__construct();
    }

    public function get() {
        $users = null;
        $sql = "SELECT * FROM users";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = (object) $row;
            }
            return $users;
        }
        return false;
    }
}
