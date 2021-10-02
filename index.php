<?php include_once "config.php"; ?>
<?php include_once "template/header.php"; ?>
<?php
require_once "Users.php";
$users = new Users();
$page = 1;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}

$data = $users->get($page)->data;
$pagination = $users->get($page)->pagination;
$totalRecords = $users->get($page)->totalRecords;
$showRecords = $users->get($page)->showRecords;

// delete user
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete" && isset($_GET["user_id"])) {
        $userId = $_GET["user_id"];
        if ($users->delete($userId) == true) {
            $_SESSION["msg"] = array(
                "success",
                "The employee deleted successfully.",
            );
            header("Location: index.php");
            exit();
        } else {
            $_SESSION["msg"] = array(
                "danger",
                "Error: The employee not deleted.",
            );
            header("Location: index.php");
            exit();
        }
    }
}

// change status
if (isset($_GET)) {
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "changeStatus") {
            $return = $users->changeStatus($_GET["userId"]);
            if ($return == true) {
                $_SESSION["msg"] = array(
                    "success",
                    "Changing status successfully.",
                );
            } else {
                $_SESSION["msg"] = array(
                    "danger",
                    "Status is not changed.",
                );
            }
            header("Location: index.php");
            exit();
        }
    }
}
?>
    <div class="container-xl">
        <div class="row">
            <div class="col-12 errorMsg">
                <?php if (isset($_SESSION["msg"])): $msg = $_SESSION["msg"] ?>
                    <div class="alert alert-<?= $msg[0]; ?> mt-3">
                        <?= $msg[1]; unset($_SESSION["msg"]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Employees</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                        class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                            <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i
                                        class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                        </th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $counter = 1; if (! empty($data)): foreach ($data as $item): ?>
                        <tr>
                        <td>
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox1" name="options[]" value="<?= $item->id; ?>">
								<label for="checkbox1"></label>
							</span>
                        </td>
                        <td><?php echo $item->full_name; ?></td>
                        <td><?= $item->email; ?></td>
                        <td><?= $item->mobile; ?></td>
                        <td><?= $item->address; ?></td>
                        <td>
                            <a href="index.php?action=changeStatus&userId=<?= $item->id; ?>" class="text-white btn btn-<?= $item->statusClass; ?>"><?= $item->statusText; ?></a>
                        </td>
                        <td>
                            <a href="#editEmployeeModal" id="<?= $item->id; ?>" class="edit" data-toggle="modal"><i class="material-icons"
                                                                                             data-toggle="tooltip"
                                                                                             title="Edit">&#xE254;</i></a>
                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons"
                                                                                                 data-toggle="tooltip"
                                                                                                 title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php endforeach; endif;?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b><?= $showRecords; ?></b> out of <b><?= $totalRecords; ?></b> entries</div>
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addForm">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="addName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="addEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" id="addMobile" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea id="addAddress" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>status</label>
                            <select id="addStatus" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">deActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="button" id="addUsers" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <input type="hidden" id="editId">
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="editName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" id="editMobile" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea id="editAddress" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>status</label>
                            <select id="editStatus" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">deActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="button" id="editUsers" class="btn btn-info">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <a href="#" class="btn btn-danger" id="deleteItem">Delete</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include_once "template/footer.php"; ?>
<script src="assets/js/validateInput.js"></script>
<script>
    $(document).ready(function () {
        $(".delete").click(function (e) {
            let userId = $(this).parent("td").parent("tr").children("td:nth-child(1)").children("span").children("input").val();
            $("#deleteItem").attr("href", "index.php?action=delete&user_id=" + userId);
        });
    });
</script>

<!-- start add data -->
<script>
    // mange add data
    $(document).ready(function () {
        // start check erroe
        $("#addName").keyup(function () {
            if ($(this).val() != "" && $(this).val().length > 3) {
                $("#addName").removeClass("border border-danger");
                $(".nameErrorMsg").remove();
            }
        });

        $("#addEmail").keyup(function () {
            if (ValidateEmail($(this).val()) == true) {
                $("#addEmail").removeClass("border border-danger");
                $(".emailErrorMsg").remove();
            }
        });

        $("#addMobile").keyup(function () {
            if (ValidateMobile($(this).val()) == true) {
                $("#addMobile").removeClass("border border-danger");
                $(".mobileErrorMsg").remove();
            }
        });

        $("#addAddress").keyup(function () {
            if (IsRequired($(this).val()) == true) {
                $("#addAddress").removeClass("border border-danger");
                $(".addressErrorMsg").remove();
            }
        });

        // end check erroe
        $("#addUsers").on('click', function () {
            let fullName = $("#addName").val();
            let email = $("#addEmail").val();
            let mobile = $("#addMobile").val();
            let address = $("#addAddress").val();
            let status = $("#addStatus").val();

            let flag = false;
            if (fullName == "" || fullName == null) {
                flag = true;
                $("#addName").addClass("border border-danger");
                $(".nameErrorMsg").remove();
                $("#addName").after("<div class='text-danger mt-1 nameErrorMsg'>Please enter correct name.</div>");
            }

            if (ValidateEmail(email) == false) {
                flag = true;
                $("#addEmail").addClass("border border-danger");
                $(".emailErrorMsg").remove();
                $("#addEmail").after("<div class='text-danger mt-1 emailErrorMsg'>Please enter correct email.</div>");
            }

            if (ValidateMobile(mobile) == false) {
                flag = true;
                $("#addMobile").addClass("border border-danger");
                $(".mobileErrorMsg").remove();
                $("#addMobile").after("<div class='text-danger mt-1 mobileErrorMsg'>Please enter correct mobile.</div>");
            }

            if (IsRequired(address) == false) {
                flag = true;
                $("#addAddress").addClass("border border-danger");
                $(".addressErrorMsg").remove();
                $("#addAddress").after("<div class='text-danger mt-1 addressErrorMsg'>Please enter address.</div>");
            }

            if (flag == true) {
                return false;
            }

            $.ajax({
                url: "functions/users/add.php",
                type: "POST",
                data: {fullName: fullName, email: email, mobile: mobile, address: address, status: status},
                cache: false,
                success: function(response){
                    $("#addForm")[0].reset();
                    $("#addEmployeeModal").css({display: "none"});
                    location.reload();
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                }
            });
        });
    });
</script>
<!-- end add data -->

<!-- start edit data -->
<script>
    $(document).ready(function () {
        // start read data with id from database
        $(".edit").on('click', function (event) {
            let userId = $(this).attr("id");
            $.ajax({
                url: "edit.php",
                type: "POST",
                data: {action: "getData", userId: userId},
                cache: false,
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data["status"] == "ok") {
                        let userInfo = data["data"];
                        $("#editId").val(userInfo["id"]);
                        $("#editName").val(userInfo["full_name"]);
                        $("#editEmail").val(userInfo["email"]);
                        $("#editMobile").val(userInfo["mobile"]);
                        $("#editAddress").val(userInfo["address"]);

                        $("#editStatus option").each(function () {
                            let itemValue = $(this).val();
                            if (itemValue == userInfo["status"]) {
                                $(this).attr("selected", true)
                            } else {
                                $(this).attr("selected", false)
                            }
                        })
                    }
                }
            });
        });
        // end read data with id from database

        // start edit data
        // start check erroe
        $("#editName").keyup(function () {
            if ($(this).val() != "" && $(this).val().length > 3) {
                $("#editName").removeClass("border border-danger");
                $(".editNameErrorMsg").remove();
            }
        });

        $("#editEmail").keyup(function () {
            if (ValidateEmail($(this).val()) == true) {
                $("#editEmail").removeClass("border border-danger");
                $(".editEmailErrorMsg").remove();
            }
        });

        $("#editMobile").keyup(function () {
            if (ValidateMobile($(this).val()) == true) {
                $("#editMobile").removeClass("border border-danger");
                $(".editMobileErrorMsg").remove();
            }
        });

        $("#editAddress").keyup(function () {
            if (IsRequired($(this).val()) == true) {
                $("#editAddress").removeClass("border border-danger");
                $(".editAddressErrorMsg").remove();
            }
        });

        // end check erroe
        $("#editUsers").on('click', function () {
            let id = $("#editId").val();
            let fullName = $("#editName").val();
            let email = $("#editEmail").val();
            let mobile = $("#editMobile").val();
            let address = $("#editAddress").val();
            let status = $("#editStatus").val();

            let flag = false;
            if (fullName == "" || fullName == null) {
                flag = true;
                $("#editName").addClass("border border-danger");
                $(".editNameErrorMsg").remove();
                $("#editName").after("<div class='text-danger mt-1 editNameErrorMsg'>Please enter correct name.</div>");
            }

            if (ValidateEmail(email) == false) {
                flag = true;
                $("#editEmail").addClass("border border-danger");
                $(".editEmailErrorMsg").remove();
                $("#editEmail").after("<div class='text-danger mt-1 editEmailErrorMsg'>Please enter correct email.</div>");
            }

            if (ValidateMobile(mobile) == false) {
                flag = true;
                $("#editMobile").addClass("border border-danger");
                $(".editMobileErrorMsg").remove();
                $("#editMobile").after("<div class='text-danger mt-1 editMobileErrorMsg'>Please enter correct mobile.</div>");
            }

            if (IsRequired(address) == false) {
                flag = true;
                $("#editAddress").addClass("border border-danger");
                $(".editAddressErrorMsg").remove();
                $("#editAddress").after("<div class='text-danger mt-1 editAddressErrorMsg'>Please enter address.</div>");
            }

            if (flag == true) {
                return false;
            }

            $.ajax({
                url: "edit.php",
                type: "POST",
                data: {action: "editData", id: id, fullName: fullName, email: email, mobile: mobile, address: address, status: status},
                cache: false,
                success: function(response){
                    $("#editForm")[0].reset();
                    $("#editEmployeeModal").css({display: "none"});
                    location.reload();
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                }
            });
        });
        // end edit data
    })
</script>
<!-- end edit data -->