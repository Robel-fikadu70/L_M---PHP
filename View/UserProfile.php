<?php include 'Header.php';
include 'DBconn.php';
$member_name = $address = $contact_no = $email_id = $user_id = $old_password = $new_password = "";
$error_message = "";
$message_type = "";
$user_id_to_fetch = "";
$account_status = "";
$status_badge_class = "";

if (!isset($_SESSION['email'])) {
    header("Location: UserLogin.php");
    exit();
}


$session_email = $_SESSION['email'];
$query_user = "SELECT * FROM member WHERE Email = ?";
$stmt_user = mysqli_prepare($conn, $query_user);
if ($stmt_user) {
    mysqli_stmt_bind_param($stmt_user, "s", $session_email);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);
    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $row = mysqli_fetch_assoc($result_user);
        $member_name = $row['Member_Name'];
        $address = $row['Region'];
        $contact_no = $row['Phone_No'];
        $email_id = $row['Email'];
        $user_id = $row['Member_ID'];
        $user_id_to_fetch =  $user_id;
        $account_status = $row['Acc_Status'];

        if ($account_status == "Approved") {
            $status_badge_class = "badge rounded-pill text-bg-success";
        } else if ($account_status == "Pending") {
            $status_badge_class = "badge rounded-pill text-bg-warning";
        } else if ($account_status == "Suspended") {
            $status_badge_class = "badge rounded-pill text-bg-danger";
        }
    }
    mysqli_stmt_close($stmt_user);
} else {
    $error_message = "Error preparing profile fetch query: " . mysqli_error($conn);
    $message_type = "error";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $member_name = $_POST['fullName'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact_no = $_POST['contactNo'] ?? '';
    $email_id = $_POST['emailId'] ?? '';
    $user_id = $_POST['userId'] ?? '';
    $old_password = $_POST['oldPassword'] ?? '';
    $new_password = $_POST['newPassword'] ?? '';

    $user_id_to_fetch = $user_id;


    if (empty($user_id) && (!empty($old_password) || !empty($new_password))) {
        $error_message = "Please enter User ID.";
        $message_type = "error";
    } else {
        if (empty($member_name) && empty($address) && empty($contact_no) && empty($email_id) && empty($old_password) && empty($new_password)) {
            $error_message = "Please provide at least one field value to update the profile or password";
            $message_type = "error";
        } else {
            $update_query = "UPDATE member SET ";
            $update_parts = array();
            $params = array();
            $types = "";
            $account_status = "Pending";
            if (!empty($member_name)) {
                $update_parts[] = "Member_Name = ?";
                $params[] = $member_name;
                $types .= "s";
                $update_parts[] = "Acc_Status = ?";
                $params[] = $account_status;
                $types .= "s";
                

            }
            if (!empty($address)) {
                $update_parts[] = "Region = ?";
                $params[] = $address;
                $types .= "s";
                $update_parts[] = "Acc_Status = ?";
                $params[] = $account_status;
                $types .= "s";
            }
            if (!empty($contact_no)) {
                $update_parts[] = "Phone_No = ?";
                $params[] = $contact_no;
                $types .= "s";
                $update_parts[] = "Acc_Status = ?";
                $params[] = $account_status;
                $types .= "s";
            }
            
           

            if (!empty($update_parts)) {
                $update_query .= implode(", ", $update_parts);
                $update_query .= " WHERE Member_ID = ?";
                $params[] = $user_id;
                $types .= "s";

                $stmt_update = mysqli_prepare($conn, $update_query);
                if ($stmt_update) {
                    mysqli_stmt_bind_param($stmt_update, $types, ...$params);
                    if (mysqli_stmt_execute($stmt_update)) {
                        $error_message = "Profile updated successfully.";
                        $message_type = "success";
                        // fetch new value
                        $query_user = "SELECT * FROM member WHERE Email = ?";
                        $stmt_user = mysqli_prepare($conn, $query_user);
                        if ($stmt_user) {
                            mysqli_stmt_bind_param($stmt_user, "s", $session_email);
                            mysqli_stmt_execute($stmt_user);
                            $result_user = mysqli_stmt_get_result($stmt_user);
                            if ($result_user && mysqli_num_rows($result_user) > 0) {
                                $row = mysqli_fetch_assoc($result_user);
                                $member_name = $row['Member_Name'];
                                $address = $row['Region'];
                                $contact_no = $row['Phone_No'];
                                $email_id = $row['Email'];
                                $user_id = $row['Member_ID'];
                                $user_id_to_fetch = $user_id;
                                $Acc_Status = 'Pending';
                                $account_status = $row['Acc_Status'];
                                if ($account_status == "Active") {
                                    $status_badge_class = "badge rounded-pill text-bg-success";
                                } else if ($account_status == "Pending") {
                                    $status_badge_class = "badge rounded-pill text-bg-warning";
                                } else if ($account_status == "Suspended") {
                                    $status_badge_class = "badge rounded-pill text-bg-danger";
                                }
                            }
                            mysqli_stmt_close($stmt_user);
                        }
                    } else {
                        $error_message = "Error updating Profile: " . mysqli_error($conn);
                        $message_type = "error";
                    }
                    mysqli_stmt_close($stmt_update);
                } else {
                    $error_message = "Error preparing update query: " . mysqli_error($conn);
                    $message_type = "error";
                }
            }

            if (!empty($old_password) && !empty($new_password)) {
                $query_password = "SELECT Password_ FROM member WHERE Member_ID = ?";
                $stmt_password = mysqli_prepare($conn, $query_password);
                if ($stmt_password) {
                    mysqli_stmt_bind_param($stmt_password, "s", $user_id);
                    mysqli_stmt_execute($stmt_password);
                    $result = mysqli_stmt_get_result($stmt_password);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $stored_password = $row['Password_'];

                        if ($old_password == $stored_password) {
                            $query_update_password = "UPDATE member SET password_ = ? WHERE Member_ID = ?";
                            $stmt_update_password = mysqli_prepare($conn, $query_update_password);
                            if ($stmt_update_password) {
                                mysqli_stmt_bind_param($stmt_update_password, "ss", $new_password, $user_id);
                                if (mysqli_stmt_execute($stmt_update_password)) {
                                    $error_message = " Password updated successfully.";
                                    $message_type = "success";
                                    // fetch new value
                                    $query_user = "SELECT * FROM member WHERE Email = ?";
                                    $stmt_user = mysqli_prepare($conn, $query_user);
                                    if ($stmt_user) {
                                        mysqli_stmt_bind_param($stmt_user, "s", $session_email);
                                        mysqli_stmt_execute($stmt_user);
                                        $result_user = mysqli_stmt_get_result($stmt_user);
                                        if ($result_user && mysqli_num_rows($result_user) > 0) {
                                            $row = mysqli_fetch_assoc($result_user);
                                            $member_name = $row['Member_Name'];
                                            $address = $row['Region'];
                                            $contact_no = $row['Phone_No'];
                                            $email_id = $row['Email'];
                                            $user_id = $row['Member_ID'];
                                            $user_id_to_fetch = $user_id;
                                            $account_status = $row['Acc_Status'];
                                            if ($account_status == "Active") {
                                                $status_badge_class = "badge rounded-pill text-bg-success";
                                            } else if ($account_status == "Pending") {
                                                $status_badge_class = "badge rounded-pill text-bg-warning";
                                            } else if ($account_status == "Suspended") {
                                                $status_badge_class = "badge rounded-pill text-bg-danger";
                                            }
                                        }
                                        mysqli_stmt_close($stmt_user);
                                    }
                                } else {
                                    $error_message = "Error updating password: " . mysqli_error($conn);
                                    $message_type = "error";
                                }
                                mysqli_stmt_close($stmt_update_password);
                            } else {
                                $error_message = "Error preparing password update query: " . mysqli_error($conn);
                                $message_type = "error";
                            }
                        } else {
                            $error_message = "Incorrect Old Password.";
                            $message_type = "error";
                        }
                    } else {
                        $error_message = "No record found with this member ID.";
                        $message_type = "error";
                    }
                    mysqli_stmt_close($stmt_password);
                } else {
                    $error_message = "Error preparing password check query: " . mysqli_error($conn);
                    $message_type = "error";
                }
            }
        }
    }
}

$query_issued = "SELECT bmt.Title, bit_.Issue_Date, bit_.Due_Date
              FROM book_issue AS bit_
              JOIN books AS bmt ON bit_.Book_ID = bmt.Book_ID
               WHERE bit_.Member_ID = ?";
$stmt_issued = mysqli_prepare($conn, $query_issued);
if ($stmt_issued) {
    mysqli_stmt_bind_param($stmt_issued, "s", $user_id_to_fetch);
    mysqli_stmt_execute($stmt_issued);
    $result_issued = mysqli_stmt_get_result($stmt_issued);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body class="custom">
    <form action="" method="post">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center">Your Profile</h2>
                            <p class="text-center">Account Status-
                                <span class="<?= htmlspecialchars($status_badge_class) ?>">
                                    <?= htmlspecialchars($account_status) ?>
                                </span>
                            </p>
                            <hr>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Enter full name" name="fullName" value="<?= htmlspecialchars($member_name) ?>">
                                </div>
                                <div class="col">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="dob" name="address" value="<?= htmlspecialchars($address) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="contactNo" class="form-label">Contact No</label>
                                    <input type="text" class="form-control" id="contactNo" placeholder="Enter contact no" name="contactNo" value="<?= htmlspecialchars($contact_no) ?>">
                                </div>
                                <div class="col">
                                    <label for="emailId" class="form-label">Email ID</label>
                                    <input type="email" class="form-control" id="emailId" placeholder="Enter email ID" name="emailId" value="<?= htmlspecialchars($email_id) ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col text-center my-3">
                                    <span class="badge text-bg-info">Login Credentials</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="userId" class="form-label">User ID</label>
                                    <input type="text" class="form-control" id="userId" readonly placeholder="Enter user ID" name="userId" value="<?= htmlspecialchars($user_id) ?>">
                                </div>
                                <div class="col">
                                    <label for="oldPassword" class="form-label">Old Password</label>
                                    <input type="password" class="form-control" id="oldPassword" placeholder="Enter old password" name="oldPassword">
                                </div>
                                <div class="col">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" name="newPassword">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn  btn-outline-primary me-1 w-50" name="update_profile">Update</button>
                            </div>
                            <?php if (!empty($error_message)) { ?>
                                <div class="alert <?php echo ($message_type == 'success') ? 'alert-success' : (($message_type == 'warning') ? 'alert-warning' : 'alert-danger'); ?>">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php } ?>
                            <br>
                            <a href="#" class="link-underline link-underline-opacity-0">
                                << Back to Home</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col text-center">
                                    <img src="" alt="User Profile Picture" width="100px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <h3>Your Issued Books</h3>
                                    <p><span class="badge text-bg-info">Your books info</span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <table id="usereprofile" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Book Name</th>
                                                <th>Issued Date</th>
                                                <th>Return Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result_issued && mysqli_num_rows($result_issued) > 0) {
                                                while ($row = mysqli_fetch_assoc($result_issued)) {
                                                    echo "<tr>
                                                         <td>" . htmlspecialchars($row['Title']) . "</td>
                                                        <td>" . htmlspecialchars($row['Issue_Date']) . "</td>
                                                        <td>" . htmlspecialchars($row['Due_Date']) . "</td>
                                                    </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No data available in table</td></tr>";
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

    <script>
        $(document).ready(function() {
            $('#usereprofile').DataTable({
                // lengthMenu: [10, 20, 30],
                // pageLength: 10,
                // language: {
                //     paginate: {
                //         previous: 'Previous',
                //         next: 'Next',
                //     }
                // }
            });
        });
    </script>
</body>

</html>

<?php include 'Footer.php' ?>