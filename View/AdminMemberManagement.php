<?php include 'Header.php';
include 'DBconn.php';

$Member_ID = "";
$Name = "";
$Status = "";
$Address = "";
$Phone = "";
$Email = "";

function updateMemberStatus($conn, $Member_ID, $status) {
    if (!empty($Member_ID)) {
        $query = "UPDATE member SET Acc_Status = '$status' WHERE Member_ID = '$Member_ID'";
        $qry = mysqli_query($conn, $query);
        if ($qry) {
            return "Member status updated to '$status' successfully!";
        } else {
            return mysqli_error($conn);
        }
    } 
    else {
        return "Member ID is required!";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Member_ID = $_POST['Member_ID'];
    if (isset($_POST['GO_btn'])) {
        if (!empty($Member_ID)) {
            $query = "SELECT * FROM member WHERE Member_ID = '$Member_ID'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                $Name = $row['Member_Name'];
                $Status = $row['Acc_Status'];
                $Address = $row['Region'];
                $Phone = $row['Phone_No'];
                $Email = $row['Email'];
            } else {
                $error_message = "No Data Found";
            }
        } else {
            $error_message = "Booth Fields Are required";
        }
    }
    
    // elseif (isset($_POST['Approve_btn'])) {
    //     if (!empty($Member_ID)) {
    //         $query = "UPDATE member SET Acc_Status = 'Approved' WHERE Member_ID = '$Member_ID'";
    //         $qry = mysqli_query($conn, $query);
    //         if ($qry) {
    //             $success_message = "Member Approved successfully!";
    //         } else {
    //             $error_message = mysqli_error($conn);
    //         }
    //     } else {
    //         $error_message = "Member ID is required!";
    //     }
    // }
    // elseif (isset($_POST['Pending_btn'])) {
    //     if (!empty($Member_ID)) {
    //         $query = "UPDATE member SET Acc_Status = 'Pending' WHERE Member_ID = '$Member_ID'";
    //         $qry = mysqli_query($conn, $query);
    //         if ($qry) {
    //             $success_message = "Member status updated successfully!";
    //         } else {
    //             $error_message = mysqli_error($conn);
    //         }
    //     } else {
    //         $error_message = "Member ID is required!";
    //     }
    // } elseif (isset($_POST['Suspend_btn'])) {
    //     if (!empty($Member_ID)) {
    //         $query = "UPDATE member SET Acc_Status = 'Suspended' WHERE Member_ID = '$Member_ID'";
    //         $qry = mysqli_query($conn, $query);
    //         if ($qry) {
    //             $success_message = "Member status updated successfully!";
    //         } else {
    //             $error_message = mysqli_error($conn);
    //         }
    //     } else {
    //         $error_message = "Member ID is required!";
    //     }
    // }
    elseif (isset($_POST['Delete_btn'])) {
        if (!empty($Member_ID)) {
            $query = "DELETE FROM member WHERE Member_ID = '$Member_ID'";
            $qry= mysqli_query($conn, $query);
            if($qry){
                $success_message = "Member deleted successfully!";        
            }
            else{
                $error_message = mysqli_error($conn);
            }
        } 
        else{
            $error_message = "Member ID is required!";        }
    }
    
    if (isset($_POST['Approve_btn'])) {
        $success_message = updateMemberStatus($conn, $Member_ID, 'Approved');
    } elseif (isset($_POST['Pending_btn'])) {
        $success_message = updateMemberStatus($conn, $Member_ID, 'Pending');
    } elseif (isset($_POST['Suspend_btn'])) {
        $success_message = updateMemberStatus($conn, $Member_ID, 'Suspended');
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Member Managemennt</title>
</head>

<body class="custom">
    <form action="" method="POST">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card my-5 mx-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col text-center">
                                    <h4>Member Details</h4>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col text-center">
                                    <img src="Assets/img/verified-account.png" width="100" alt="Verified Account" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Member ID</label>
                                    <div class="input-group">
                                        <input name="Member_ID" type="text" Class="form-control" placeholder="Member ID" value="<?php echo htmlspecialchars($Member_ID) ?>">
                                        <button type="submit" name="GO_btn" class="btn btn-secondary"><i class="fas fa-check-circle"></i></button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Full Name</label>
                                    <input name="Name" type="text" Class="form-control" placeholder="Full Name" ReadOnly="true" value="<?php echo htmlspecialchars($Name) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <div class="input-group" Class="form-control me-1" placeholder="Account Status" ReadOnly="true">
                                        <input name="Status" type="text" Class="form-control me-1" placeholder="Account status" ReadOnly="true" value="<?php echo htmlspecialchars($Status) ?>">
                                        <!-- Buttons to change account status -->
                                        <button name="Approve_btn" type="submit" class="btn btn-outline-success me-1"><i class="fas fa-check-circle"></i></button>
                                        <button name="Pending_btn" type="submit" class="btn btn-outline-warning me-1"><i class="fas fa-pause-circle"></i></button>
                                        <button name="Suspend_btn" type="submit" class="btn btn-outline-danger me-1"><i class="fas fa-times-circle"></i></button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Address</label>
                                    <input name="House_Number" type="text" Class="form-control" placeholder="Address" ReadOnly="true" value="<?php echo htmlspecialchars($Address)?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                    <input name="Phone" type="text" Class="form-control" placeholder="Phone" ReadOnly="true" value="<?php echo htmlspecialchars($Phone) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input name="Email" type="text" Class="form-control" placeholder="Email" ReadOnly="true" value="<?php echo htmlspecialchars($Email) ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <?php
                                    if (!empty($error_message)) { ?>
                                        <p style='color: red;'><?php echo $error_message ?> </p>
                                    <?php } elseif (!empty($success_message)) { ?>
                                        <p style='color: green;'><?php echo $success_message ?> </p>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col text-center">
                                    <Button name="Delete_btn" type="submit" class="btn btn btn-outline-danger px-5">Delete User</Button>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col text-center">
                                    <a href="homepage.aspx">Back to Homepage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card my-5 mx-3">
                        <div class="card-body">

                            <div class="row">
                                <div clas="col">
                                    <center>
                                        <h4>issued book list</h4>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <hr>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <table>

                                    </table>
                                    <table id="authorTable" class="table table-striped table-bordered">

                                        <thead>
                                            <tr>
                                                <th>Member ID</th>
                                                <th>Full Name</th>
                                                <th>Acc status</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM member";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>
                                                    <td>{$row['Member_ID']}</td>
                                                    <td>{$row['Member_Name']}</td>
                                                    <td>{$row['Acc_Status']}</td>
                                                    <td>{$row['Phone_No']}</td>
                                                    <td>{$row['Region']}</td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>

</html>

<?php include 'Footer.php' ?>