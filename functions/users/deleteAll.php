<?php
require_once "./../../Users.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    $users = new Users();
    $response = [];
    if ($_POST["action"] == "deleteAll") {
        // catch data
        $whereIn = implode(", ", $_POST["data"]);

        if ($users->deleteAll($whereIn) == true) {
            $_SESSION["msg"] = array(
                "success",
                "Deleted users successfully.",
            );

            $response = array(
                "status" => "ok",
            );
        } else {
            $_SESSION["msg"] = array(
                "danger",
                "Error: Users not Deleted.",
            );

            $response = array(
                "status" => "error",
                "data" => $users->deleteAll($whereIn)
            );
        }
    }

    echo json_encode($response);
    exit();
}