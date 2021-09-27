<?php
require_once "Users.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    $response = [];

    // catch data
    $data = array(
        "fullName" => $_POST["fullName"],
        "email" => $_POST["email"],
        "mobile" => $_POST["mobile"],
        "address" => $_POST["address"],
        "status" => $_POST["status"],
    );

    $users = new Users();
    if ($users->add($data) == true) {
        $_SESSION["msg"] = array(
            "success",
            "Added user successfully.",
        );

        $response = array(
            "status" => "ok",
        );
    } else {
        $_SESSION["msg"] = array(
            "danger",
            "Error: User not added.",
        );

        $response = array(
            "status" => "error",
        );
    }

    echo json_encode($response);
    exit();
}
