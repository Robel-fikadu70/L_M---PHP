<?php 
include '../View/DBconn.php';

$id = "";
$name = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id'] ?? '');
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');

    if (isset($_POST['add_sub'])) {
        if (!empty($id) && !empty($name)) {
            $query = "INSERT INTO author (Author_ID, Author_Name) VALUES ('$id', '$name')";
            $qry = mysqli_query($conn, $query);
            if($qry){
                echo "<p style='color:green;'>Author added successfully!</p>";
            }
            else{
                echo"<p style='color:red;'>Error:".mysqli_error($conn)."</p>";
            }
        } 
        else{
            echo"<p style='color:red'>Both Fields are required</p>";
        }
    }
    elseif (isset($_POST['update_sub'])) {
        if (!empty($id) && !empty($name)) {
            $query = "UPDATE author SET Author_Name = '$name' WHERE Author_ID = '$id'";
            $qry= mysqli_query($conn, $query);
            if($qry){
                echo "<p style='color:green;'>Author updated successfully!</p>";
            }
            else{
                echo"<p style='color:red;'>Error:".mysqli_error($conn)."</p>";
            }
        } 
        else{
            echo"<p style='color:red;'>Both Fields are required</p>";
        }
        }
     
    elseif (isset($_POST['delete_sub'])) {
        if (!empty($id)) {
            $query = "DELETE FROM author WHERE Author_ID = '$id'";
            $qry= mysqli_query($conn, $query);
            if($qry){
                echo "<p style='color:green;'>Author deleted successfully!</p>";
            }
            else{
                echo"<p style='color:red;'>Error:".mysqli_error($conn)."</p>";
            }
        } 
        else{
            echo"<p style='color:red;'>Both Fields are required</p>";
        }
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
        } else {
            $error_message = "Please enter an ID.";
        }
    }
}



?>