<?php
require_once "DbConnection.php";
class Users extends DbConnection {
    private $table;
    public function __construct()
    {
        parent::__construct();

        $this->table = "users";
    }

    public function get() {
        $users = null;
        $sql = "SELECT * FROM {$this->table}";
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

    public function add($data) {

        $fullName = $data["fullName"];
        $email = $data["email"];
        $mobile = $data["mobile"];
        $address = $data["address"];
        $status = $data["status"];

        $sql = "INSERT INTO users (full_name, email, mobile, address, status) VALUES ('$fullName', '$email', '$mobile', '$address', '$status')";

        if ($this->connection->query($sql) === true) {
            return true;
        }
        return false;
    }

    public function changeStatus($id) {
        $user = $this->findById($id);

        $status = $user->status;

        if ($status == 0)
            $status = '1';
        else
            $status = '0';

        $sql = "UPDATE {$this->table} SET status='$status' WHERE id=" . $id;

        if ($this->connection->query($sql) === true)
            return true;
        return false;

    }

    private function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id= ". $id;
        $result = $this->connection->query($sql);

        $data = [];
        if ($result->num_rows == 1) {
            $data = (object) $result->fetch_assoc();
        }
        return $data;
    }
}
