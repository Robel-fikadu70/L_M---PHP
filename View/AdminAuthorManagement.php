<?php 
include 'Header.php';
include 'DBconn.php';

$id = "";
$name = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id'] ?? '');
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');

    if (isset($_POST['add_sub'])) {
        if (!empty($id) && !empty($name)) {
            $query = "INSERT INTO author (Author_ID, Author_Name) VALUES ('$id', '$name')";
            try{
                $qry = mysqli_query($conn, $query);
                if($qry){
                    $success_message = "Author added successfully!";
                }
            }
            catch(Exception ){
                $error_message = "can't use same ID, choose another one!";
            }
        } 
        else{
            $error_message = "Both Fields are required!";
        }
    }
    
    elseif (isset($_POST['update_sub'])) {
        if (!empty($id) && !empty($name)) {
            $query = "UPDATE author SET Author_Name = '$name' WHERE Author_ID = '$id'";
            $qry= mysqli_query($conn, $query);
            if($qry){
                $success_message = "Author updated successfully!";
            }
            else{
                $error_message = mysqli_error($conn);
            }
        } 
        else{
            $error_message = "Both Fields are required!";        }
        }
     
    elseif (isset($_POST['delete_sub'])) {
        if (!empty($id)) {
            $query = "DELETE FROM author WHERE Author_ID = '$id'";
            $qry= mysqli_query($conn, $query);
            if($qry){
                $success_message = "Author deleted successfully!";        
            }
            else{
                $error_message = mysqli_error($conn);
            }
        } 
        else{
            $error_message = "Both Fields are required!";        }
        }
    elseif (isset($_POST['go'])) {
        if (!empty($id)) {
            $query = "SELECT * FROM author WHERE Author_ID = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $name = $row['Author_Name'];
            } else {
                $error_message = "No data found for the provided ID.";
            }
        }
        else {
            $error_message = "Please enter an ID";
        }
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="datatables/css/dataTables.bootstrap5.min.css">
    <title>Author Management</title>
    <style>
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }
        .dataTables_wrapper .dataTables_length {
            float: left;
        }
    </style>
</head>
<body class="custom">
    <form action="" method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="card  my-5 mx-3">
                        <div class="card-body">
                            <center>
                                <h4>Author Detail</h4>
                                <img width="100" src="Assets/img/writer.png" alt="Author Image" />
                            </center>
                            <hr />
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label for="authorId">Author ID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mt-2" id="authorId" placeholder="ID" name="id" value="<?php echo htmlspecialchars($id); ?>" />
                                        <button type="submit" class="btn btn-secondary btn-sm mt-2" name="go">Go</button>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="authorName">Author Name</label>
                                    <input type="text" class="form-control mt-2" id="authorName" placeholder="Author Name" name="name" value="<?php echo htmlspecialchars($name); ?>" />
                                </div>
                            </div>
                            <?php if (!empty($error_message)) { ?>
                                <p style="color: red;"> <?php echo $error_message; ?> </p>
                            <?php }
                            elseif (!empty($success_message)){ ?>
                                <p style="color: green;"> <?php echo $success_message; ?> </p>
                                <?php }
                             ?>
                            <div class="row my-3">
                                <div class="col-4">
                                    <input class="btn btn-outline-success me-1 btn-sm w-100" type="submit" name="add_sub" value="Add">
                                </div>
                                <div class="col-4">
                                    <input class="btn btn-outline-warning me-1 btn-sm w-100" type="submit" name="update_sub" value="Update">
                                </div>
                                <div class="col-4">
                                    <input class="btn btn-outline-danger me-1 btn-sm w-100" type="submit" name="delete_sub" value="Delete">
                                </div>
                            </div>
                            <a class="link-underline link-underline-opacity-0 mt-3" href="#"><< Back to Home</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card  my-5 mx-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h3>Author List</h3>
                                    </center>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col">
                                    <table id="authorTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Author ID</th>
                                                <th>Author Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM author");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>
                                                        <td>{$row['Author_ID']}</td>
                                                        <td>{$row['Author_Name']}</td>
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
    <script>
        $(document).ready(function () {
            $('#authorTable').DataTable({
                lengthMenu: [10, 20, 30],
                pageLength: 10,
                language: {
                    paginate: {
                        previous: 'Previous',
                        next: 'Next',
                    }
                }
            });
        });
    </script>
</body>
</html>

<?php include 'Footer.php'; ?>


