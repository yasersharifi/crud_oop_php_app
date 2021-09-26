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
                if ($row["status"] == "1") {
                    $row["statusClass"] = "success";
                    $row["statusText"] = "active";
                } else {
                    $row["statusClass"] = "danger";
                    $row["statusText"] = "deactive";
                }

                $users[] = (object) $row;
            }
            return $users;
        }
        return false;
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = $id";

        if ($this->connection->query($sql) === true) {
            return true;
        }
        return false;
    }
}
