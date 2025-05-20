<?php 
include 'Header.php';
include 'DBconn.php';

$id = "";
$name = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    
    if (isset($_POST['add_sub'])) {
        if (!empty($id) && !empty($name)) {
            $query = "INSERT INTO publisher (Publisher_ID, Publisher_Name) VALUES ('$id', '$name')";
            try{
                $qry = mysqli_query($conn, $query);
                if($qry){
                    $success_message = "Publisher added successfully!";
                }
            }
            catch(Exception ){
                $error_message = "can't use same ID, choose another one!";
            }
        } 
        else{
            $error_message = "Both feilds required";
        }
    }

    if (isset($_POST['update_sub'])) {
        if (!empty($id) && !empty($name)) {
            $query = "UPDATE publisher SET Publisher_Name = '$name' WHERE publisher_ID = '$id'";
            mysqli_query($conn, $query);
            $success_message = "Publisher updated successfully!";
        }
        else{
            $error_message = "Both feilds required";
        }
    }

    if (isset($_POST['delete_sub'])) {
        if (!empty($id)) {
            $query = "DELETE FROM publisher WHERE publisher_ID = '$id'";
            mysqli_query($conn, $query);
            $success_message = "Publisher deleted successfully!";
        }
        else{
            $error_message = "ID feild required";
        }
    }

    if (isset($_POST['go'])) {
        if (!empty($id)) {
            $query = "SELECT * FROM publisher WHERE publisher_ID = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $name = $row['Publisher_Name'];
            } else {
                $error_message = "No data found for the given ID.";
            }
        }
        else {
            $error_message = "Please insert an ID.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Publisher Management</title>
    <style>
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
        }
        .dataTables_wrapper .dataTables_filter {
            display: inline-block;
        }
        .dataTables_wrapper .dataTables_length {
            display: inline-block;
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
    <form action="" method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card my-5 mx-3">
                    <div class="card-body">
                        <center>
                            <h4>Publisher Detail</h4>
                            <img width="100" src="Assets/img/printer.png" alt="Publisher Image" />
                        </center>
                        <hr />
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="publisherId">Publisher ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="publisherId" placeholder="ID" name="id" value="<?php echo htmlspecialchars($id); ?>"/>
                                    <button type="submit" class="btn btn-secondary btn-sm ms-2" name="go">Go</button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label for="publisherName">Publisher Name</label> 
                                <input type="text" class="form-control mt-2" id="publisherName" placeholder="Publisher Name" name="name" value="<?php echo htmlspecialchars($name); ?>"/>
                                <?php
                                if (!empty($error_message)) {?>
                                    <p style='color: red;'><?php echo $error_message ?> </p>
                                <?php }
                                elseif(!empty($success_message)){?>
                                    <p style='color: green;'><?php echo $success_message?> </p>
                                <?php } 
                                ?>
                            </div>
                        </div>
                        <div class="row mt-2">
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
                <div class="card my-5 mx-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <center>
                                    <h3>Publisher List</h3>
                                </center>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col">
                                <table id="publisherTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Publisher ID</th>
                                            <th>Publisher Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'dbconn.php';
                                        $result = mysqli_query($conn, "SELECT * FROM publisher");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>
                                                    <td>{$row['Publisher_ID']}</td>
                                                    <td>{$row['Publisher_Name']}</td>
                                                </tr>";
                                        }
                                        mysqli_close($conn);
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
            $('#publisherTable').DataTable({
                lengthMenu: [10,20,30],
                pageLength: 10,
                language: {
                    paginate: {
                        previous: '<a href="#" class="btn btn-sm ">Previous</a>',
                        next: '<a href="#" class="btn btn-sm ">Next</a>',
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php include 'Footer.php'; ?>
