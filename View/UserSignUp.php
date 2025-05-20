<?php include 'Header.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
</head>
<body class="custom">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img width="100" src="Assets/img/profile.png" alt="User Icon" class="mb-3">
                            <h3>Member Sign Up</h3>
                        </div>
                        <hr>

                        <?php
                        include "DBconn.php";

                        $error_message = "";
                        $success_message = "";

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $full_name = trim($_POST['fullName']);
                            $Address = trim($_POST['Address']);
                            $contact_no = trim($_POST['contactNo']);
                            $email = trim($_POST['email']);
                            $password = trim($_POST['password']);

                            if (!memberexist($email, $conn)) {
                                
                                if (usersignup($full_name, $Address, $contact_no, $email, $password, $conn)) {
                                    $success_message = "Sign-up Successful. Please Log In To Your Account";
                                    echo '<script type="text/javascript">
                                            setTimeout(function() {
                                                window.location.href = "UserLogin.php";
                                            }, 2000); 
                                          </script>';
                                } else {
                                    $error_message = "An error occurred during sign-up. Please try again.";
                                }
                            } else {
                                $error_message = "Member already exists.";
                            }
                            
                        }

                        function memberexist($email, $conn)
                        {
                            $sql = "SELECT * FROM member WHERE Email = '$email'";
                            $result = mysqli_query($conn, $sql);
                           if(mysqli_num_rows($result)>0)
                           return true;
                          else return false;
                        }
                        

                        function usersignup($full_name, $Address, $contact_no, $email, $password, $conn)
                        {
                            $sql = "INSERT INTO member (Member_Name, Region, Phone_No, Email, password_, Acc_Status) VALUES (?, ?, ?, ?,?, 'Pending')";
                            $qry = mysqli_prepare($conn, $sql);
                            
                            mysqli_stmt_bind_param($qry, "sssss", $full_name, $Address, $contact_no, $email, $password );

                            mysqli_stmt_execute($qry);
                           return true;
                        }

                        mysqli_close($conn);
                        ?>

                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fullName">Full Name</label>
                                    <div class="form-group my-3">
                                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="dob">Address</label>
                                    <div class="form-group my-3">
                                        <input placeholder="Address" type="text" class="form-control" id="dob" name="Address" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contactNo">Contact No</label>
                                    <div class="form-group my-3">
                                        <input type="number" class="form-control" id="contactNo" name="contactNo" placeholder="Contact No" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email ID</label>
                                    <div class="form-group my-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email ID" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <div class="form-group my-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col my-2 text-center">
                                    <?php if (!empty($error_message)) : ?>
                                        <div class="alert alert-danger py-2 d-inline-block" role="alert">
                                            <?= htmlspecialchars($error_message); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($success_message)) : ?>
                                        <div class="alert alert-success py-2 d-inline-block" role="alert">
                                            <?= htmlspecialchars($success_message); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <button type="submit" class="btn w-100 my-2 btn-outline-success me-1">Sign Up</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="HomePage.php" class="link-underline link-underline-opacity-0">&lt;&lt; Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>

<?php include 'Footer.php' ?>