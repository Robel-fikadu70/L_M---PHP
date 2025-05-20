<?php include 'Header.php';
include 'DBconn.php';


$Member_ID = '';
$Book_ID = '';
$Member_Name = '';
$Book_Name = '';
$Issue_Date = '';
$Due_Date = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Member_ID = $_POST['Member_ID'];
    $Book_ID = $_POST['Book_ID'];
    $Issue_Date = $_POST['Issue_Date'];
    $Due_Date = $_POST['Due_Date'];

    if (isset($_POST['Issue_btn'])) {
        if (!empty($Member_ID) && !empty($Book_ID)) {
            try {
                $query = "INSERT INTO book_issue(Member_ID, Book_ID, Issue_Date, Due_Date)
                  VALUES('$Member_ID', '$Book_ID', '$Issue_Date', '$Due_Date')";
                $qry = mysqli_query($conn, $query);
                if ($qry) {
                    $success_message = "Issue added successfully!";
                    $qryy = "UPDATE books SET Current_stock = Current_stock-1
                     WHERE Book_ID = '$Book_ID'";
                    mysqli_query($conn, $qryy);
                }
                else {
                    $error_message = "There was a problem while issuing the book";
                }
            
            }
            catch(mysqli_sql_exception $e){
                $error_message = "Book or Member Doesn't exist";
            }
            
        }
        else{
            $error_message = "Booth Fields Are required";
        }
        
    }

    if (isset($_POST['Go_btn'])) {
        if (!empty($Member_ID) && !empty($Book_ID)) {
            $query = "SELECT Member_Name
                      FROM member
                      WHERE Member_ID = '$Member_ID'"; 
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $Member_Name = $row['Member_Name'];
            } 
            else {
                $error_message = "Member Data not Found";
            }
            $queryy = "SELECT Title
                      FROM books
                      WHERE Book_ID = '$Book_ID'";
            $resultt = mysqli_query($conn, $queryy);
            if ($resultt && mysqli_num_rows($resultt) > 0) {
                $roww = mysqli_fetch_assoc($resultt);
                $Book_Name = $roww['Title'];
            } 
            else {
                $error_message = "Book Data not Found";
            }
        } 
        else {
            $error_message = "Booth Fields Are required";
        }
    }

    if (isset($_POST['Return_btn'])) {
        try{
            if (!empty($Member_ID) && !empty($Book_ID)) {
                $query = "DELETE
                          FROM book_issue
                          WHERE Member_ID = '$Member_ID' AND Book_ID = '$Book_ID'";
                $qry = mysqli_query($conn, $query);
                if ($qry) {
                    $success_message = "Book Returned";
                    $qryy = "UPDATE books SET Current_stock = Current_stock+1
                         WHERE Book_ID = '$Book_ID'";
                    mysqli_query($conn, $qryy);
                } 
                else {
                    $error_message = "There was a problem in returning the book";
                }
            } else {
                $error_message = "Booth Fields Are required";
            }
        }
        catch(mysqli_sql_exception $e){
            //$error_message="Book or Member Doesn't exist";
        }
        
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Issuing</title>
</head>

<body class="custom">
    <div class="custom" class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card my-5 mx-3">
                    <form action="" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>book issuing</h4>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <img src="Assets/img/time-to-study.png" width="100" />

                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <label>Member ID</label>
                                    <div class="form-group">
                                        <input name="Member_ID" type="text" Class="form-control" value="<?php echo htmlspecialchars($Member_ID) ?>"
                                            Placeholder="Member ID">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Book ID</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input name="Book_ID" type="text" Class="form-control" value="<?php echo htmlspecialchars($Book_ID) ?>" 
                                                Placeholder="Book ID">
                                            <input name="Go_btn" type="submit" value="Go" class="btn btn-secondary">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Member Name</label>
                                    <div class="form-group">
                                        <input type="text" Class="form-control" ID="TextBox3" value="<?php echo htmlspecialchars($Member_Name) ?>"
                                            Placeholder="Member Name" ReadOnly="True">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Book Name</label>
                                    <div class="form-group">
                                        <input type="text" Class="form-control" value="<?php echo htmlspecialchars($Book_Name) ?>" ID="TextBox4" placeholder="Book Name" ReadOnly="True">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <label>Issue Date</label>
                                    <div class="form-group">
                                        <input name="Issue_Date" type="date" Class="form-control" value="<?php echo htmlspecialchars($Issue_Date) ?>"
                                            placeholder="Issue date" TextMode="Date">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label>Due Date</label>
                                    <div class="form-group">
                                        <input name="Due_Date" type="date" Class="form-control" value="<?php echo htmlspecialchars($Due_Date) ?>"
                                            placeholder="Due date" TextMode="Date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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

                            <div class="row">
                                <div class="col-6">
                                    <input name="Issue_btn" type="submit" value="Issue" class="btn btn-outline-primary me-1 btn-sm w-100 m-2">
                                </div>


                                <div class="col-6">
                                    <input name="Return_btn" type="submit" value="Return" class="btn btn-outline-success me-1 btn-sm w-100 m-2">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <a href="homepage.aspx">
                    << back to homepage</a><br>
                        <br>
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
                                            <th>Member Name</th>
                                            <th>Book ID</th>
                                            <th>Book Name</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT *
                                                FROM book_issue
                                                INNER JOIN member ON member.Member_ID = book_issue.Member_ID
                                                INNER JOIN books ON books.Book_ID = book_issue.Book_ID";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>
                                                    <td>{$row['Member_ID']}</td>
                                                    <td>{$row['Member_Name']}</td>
                                                    <td>{$row['Book_ID']}</td>
                                                    <td>{$row['Title']}</td>
                                                    <td>{$row['Issue_Date']}</td>
                                                    <td>{$row['Due_Date']}</td>
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
</body>

</html>

<?php include 'Footer.php' ?>