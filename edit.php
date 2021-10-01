<?php
require_once "Users.php";
$users = new Users();
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {

    $response = [];
    #--- start get data ---#
    if (isset($_POST["action"]) && $_POST["action"] == "getData") {
        $userInfo = $users->findById($_POST["userId"]);
        $response = array(
            "status" => "ok",
            "data" => $userInfo
        );
    }
    #--- end get data ---#

    #--- start edit data ---#
    elseif (isset($_POST["action"]) && $_POST["action"] == "editData") {
        $editData = array(
            "id" => $_POST["id"],
            "fullName" => $_POST["fullName"],
            "email" => $_POST["email"],
            "mobile" => $_POST["mobile"],
            "address" => $_POST["address"],
            "status" => $_POST["status"],
        );

        if ($users->edit($editData) == true) {
            $_SESSION["msg"] = array(
                "success",
                "Edited user successfully.",
            );

            $response = array(
                "status" => "ok",
            );
        } else {
            $_SESSION["msg"] = array(
                "danger",
                "Error: User not edited.",
            );

            $response = array(
                "status" => "error",
            );
        }


    }
    #--- end edit data ---#

    else {
        $response = array(
            "status" => "error",
            "data" => $_POST
        );
    }

    echo json_encode($response);
    exit();

}



?>
