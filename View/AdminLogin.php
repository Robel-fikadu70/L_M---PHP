<?php include 'Header.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body class="custom">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card my-5 mx-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                <img width="150px" src="Assets/img/user.png" alt="User Icon" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <h3>Admin Login</h3>
                            </div>
                        </div>
                        <hr />
                        <?php
                        include "DBconn.php";
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        $error_message = "";
                        $success_message = "";

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                            $username = trim($_POST['username']);
                            $password = trim($_POST['password']);

                            $sql = "SELECT * FROM admin WHERE User_Name = ? AND Password_ = ?";
                            $qry = mysqli_prepare($conn, $sql);

                            mysqli_stmt_bind_param($qry, "ss", $username, $password);

                            mysqli_stmt_execute($qry);

                            $result = mysqli_stmt_get_result($qry);

                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $_SESSION['username'] = $row['User_Name'];

                                    $_SESSION['role'] = "admin";
                                }

                                $success_message = "Log-in successful.";
                                echo '<script type="text/javascript">
                                        setTimeout(function() {
                                            window.location.href = "homepage.php";
                                        }, 2000); 
                                      </script>';
                            } else {
                                $error_message = "Invalid username Or Password.";
                            }
                        }


                        ?>



                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <input class="form-control" type="text" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="row">
                                <div class="col my-2">

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



                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <button class="btn btn-outline-success me-1 w-100" type="submit">Login</button>
                            </div>
                        </form>
                        <div class="form-group mb-3">
                            <a href="signup.php" class="btn btn-outline-primary me-1 w-100">Sign Up</a>
                        </div>
                    </div>
                </div>
                <a href="homepage.php" class="link-underline d-block text-center my-3">
                    << Back to Home</a>
            </div>
        </div>
    </div>
</body>

</body>

</html>

<?php include 'Footer.php' ?>