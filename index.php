<?php include_once "config.php"; ?>
<?php include_once "template/header.php"; ?>
<?php
require_once "Users.php";
$users = new Users();
$data = $users->get();

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
                            <button class="btn btn-<?= $item->statusClass; ?>"><?= $item->statusText; ?></button>
                        </td>
                        <td>
                            <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons"
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
                    <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#">Previous</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item active"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item"><a href="#" class="page-link">Next</a></li>
                    </ul>
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
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" value="Save">
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
<script>
    $(document).ready(function () {
        $(".delete").click(function (e) {
            let userId = $(this).parent("td").parent("tr").children("td:nth-child(1)").children("span").children("input").val();
            $("#deleteItem").attr("href", "index.php?action=delete&user_id=" + userId);
        });
    });
</script>

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
            if (ValidateEmail($(this).val())) {
                $("#addEmail").removeClass("border border-danger");
                $(".emailErrorMsg").remove();
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

            if (flag == true) {
                return false;
            }

            $.ajax({
                url: "add.php",
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

    function ValidateEmail(mail)
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
        {
            return (true)
        }
        return (false)
    }
</script>