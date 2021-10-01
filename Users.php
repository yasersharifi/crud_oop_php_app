<?php
require_once "DbConnection.php";
class Users extends DbConnection {
    private $table;
    public function __construct()
    {
        parent::__construct();

        $this->table = "users";
    }

    public function get($page) {
        // validate page is number
        if (filter_var($page, FILTER_VALIDATE_INT) == false) {
            $page = 1;
        }

        $limit = 4;
        $startFrom = ($page - 1) * $limit;

        $users = null;
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT $startFrom, $limit";
        $result = $this->connection->query($sql);

        // For pagination
        $countSql = "SELECT COUNT(id) AS userCount FROM {$this->table}";
        $countResult = $this->connection->query($countSql);
        $totalRecords = $countResult->fetch_assoc()["userCount"];
        $totalPages = ceil($totalRecords / $limit);


        $previous = $page - 1;
        $next = $page + 1;
        $pageLinks = "<ul class='pagination'>";
        if ($previous > 0) {
            $pageLinks .= "<li class='page-item disabled'><a href='index.php?page=" .$previous. "'>Previous</a></li>";
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = "";
            if ($page == $i) {$activeClass = "active";}
            $pageLinks .= "<li class='page-item ".$activeClass."'>";
            $pageLinks .= "<a href='index.php?page=".$i."' class='page-link'>$i</a>";
            $pageLinks .= "</li>";
        }
        if ($next <= $totalPages) {
            $pageLinks .= "<li class='page-item disabled'><a href='index.php?page=" .$next. "'>Next</a></li>";
        }
        $pageLinks .= "</ul>";

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
            $data = array(
                "data" => $users,
                "pagination" => $pageLinks,
                "totalRecords" => $totalRecords,
                "showRecords" => $result->num_rows
            );
            return (object) $data;
        }
        return false;
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = $id";

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

        $sql = "INSERT INTO {$this->table} (full_name, email, mobile, address, status) VALUES ('$fullName', '$email', '$mobile', '$address', '$status')";

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
