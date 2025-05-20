
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="Assets/bootstrap/content/bootstrap.min.css" rel="stylesheet"/>
    <link href="Assets/customCSS/customCSS.css" rel="stylesheet"/>
    <link href="Assets/fontawesome/css/all.min.css" rel="stylesheet"/>

    <script src="Assets/bootstrap/scripts/bootstrap.bundle.min.js"></script>
    <script src="Assets/bootstrap/scripts/bootstrap.min.js"></script>
    
    <script src="Assets/Jquery/jquery-3.6.0.min.js"></script>
    <link href="Assets/datatables/CSS/dataTables.dataTables.min.css" rel="stylesheet"/>
    <script src="Assets/datatables/JS/dataTables.min.js"></script>
    
    

</head>
<body>
<div>
    <nav class="navbar navbar-expand-lg navbar-light px-2rem">

        <a class="navbar-brand" href="#">
            <img src="Assets/img/book-of-black-cover-closed.png" width="30" height="30" />
            <b>Bookhive</b>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="Homepage.php">Home</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#">About Us</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#">Terms</a>
                </li>
            </ul>
            <?php 
            session_start();
               if(isset($_SESSION['role'])){
                $role = $_SESSION['role'];
            } else {
                $role ="";
            }
            if(isset($_SESSION['fullname'])){
                $uname = $_SESSION['fullname'];
            } else {
                $uname ="";
            }
                            
                ?>

            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="ViewBooks.php" class="nav-link" ID="LinkButton4">View Books</a>
                </li>
                <?php
                if ($role== '' ): ?> <li class="nav-item active">
                    <a href="UserLogin.php" class="nav-link" ID="LinkButton1">User Login</a>
                </li> <?php endif; ?>

                <?php                
            if ($role== '' ): ?><li class="nav-item active">
                    <a href="UserSignUp.php" class="nav-link" ID="LinkButton2">Sign Up</a>
                </li>
                <?php endif; ?>
                
               
             <?php                
            if ($role== 'admin' || $role== 'user' ): ?> <li class="nav-item active">
                    <a href="LogOut.php" class="nav-link" ID="LinkButton3">Logout</a>
                </li><?php endif; ?> 

               
                <li class="nav-item active">
                    <a href="UserProfile.php" class="nav-link " ID="LinkButton13" width="25" height="25"> </a>
                </li>
                <li class="nav-item active">
                    <a href="UserProfile.php" class="nav-link " ID="LinkButton13" width="25" height="25"> <?php
                    if ($role== 'admin' )
                    echo $_SESSION['username'];
                    else
                        echo $uname;

                     ?>
                    
                   </a>
                </li>
                
                <li class="nav-item active">
                    <button class="nav-link d-none" ID="LinkButton7"></button>
                </li>

            </ul>

        </div>


    </nav>
</div>
</body>
</html>