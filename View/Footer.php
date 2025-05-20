<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="Assets/bootstrap/content/bootstrap.min.css" rel="stylesheet"/>
    <link href="Assets/customCSS/customCSS.css" rel="stylesheet"/>
    <link href="Assets/datatables/CSS/dataTables.dataTables.min.css" rel="stylesheet"/>
    <link href="Assets/fontawesome/css/all.min.css" rel="stylesheet"/>

    <script src="Assets/datatables/JS/dataTables.min.js"></script>
    <script src="Assets/bootstrap/scripts/bootstrap.bundle.min.js"></script>
    <script src="Assets/bootstrap/scripts/bootstrap.min.js"></script>
</head>
<body>
<footer>
    <div id="footer1" class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <p> 
                <?php 
               
                          
                if ($role== 'admin'): ?>
                    
                    <a href="AdminAuthorManagement.php"class="footerlinks" ID="LinkButton11">Author Management</a>
                    &nbsp;
                    <a href="AdminPublisherManagement.php" class="footerlinks " ID="LinkButton12">Publisher Management</a>
                    &nbsp;
                    <a href="AdminBookInventory.php" class="footerlinks " ID="LinkButton8">Book Inventory</a>
                    &nbsp;
                    <a href="AdminBookIssuing.php" class="footerlinks" ID="LinkButton9">Book Issuing</a>
                    &nbsp;
                    <a href="AdminMemberManagement.php" class="footerlinks " ID="LinkButton10">Member Management</a>
                   <?php endif; 
                   if ($role== ''|| $role=='user' ): ?>   <a href="AdminLogin.php" class="footerlinks" ID="LinkButton6">Admin Login</a>
                    &nbsp;
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <div id="footer2" class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <p style="color: white">&copy All right Reversed. <a class="footerlinks" href="#" target=" blank">BookHive </a></p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>