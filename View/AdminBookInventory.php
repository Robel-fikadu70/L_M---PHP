<?php
include 'Header.php';
include 'DBconn.php';

$author_query = "SELECT * FROM author";
$author = mysqli_query($conn, $author_query);

$publisher_query = "SELECT * FROM publisher";
$publisher = mysqli_query($conn, $publisher_query);


$TargetFile = '';
$Book_ID = '';
$Book_Name = '';
$Language = '';
$Pub_ID = '';
$Auth_ID = '';
$Pub_Date = '';
$Genre = '';
$Edition = '';
$Cost = '';
$Page = '';
$Stock = '';
$Current_stock='';
$Issue='';
$Descp = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Path = "Book_inv_img/";
    $TargetFile = $Path . basename($_FILES["Image"]["name"]);
    $Book_ID = $_POST['Book_ID'];
    $Book_Name = $_POST['Book_Name'];
    $Language = isset($_POST['Language']) ? $_POST['Language'] : '';
    $Pub_ID = $_POST['Publisher_Name'];
    $Auth_ID = $_POST['Author_Name'];
    $Pub_Date = $_POST['Date'];
    $Genre = isset($_POST['Genre']) ? $_POST['Genre'] : '';
    $Edition = $_POST['Edition'];
    $Cost = $_POST['Cost'];
    $Page = $_POST['Page'];
    $Stock = $_POST['Stock'];
    $Descp = $_POST['Description'];

    if (isset($_POST["Add_btn"])) {
        $query = "INSERT INTO books (Book_ID, Title, Genere, Author_ID, Publisher_ID, Published_date, Language_, Edition_, Book_cost, Number_pages, Book_description, Actual_stock, Current_stock, Book_img)
                  VALUES ('$Book_ID','$Book_Name', '$Genre', '$Auth_ID', '$Pub_ID', '$Pub_Date', ' $Language','$Edition',  '$Cost', '$Page', '$Descp', '$Stock','$Stock', '$TargetFile')";

        $qry = mysqli_query($conn, $query);

        if ($qry) {

            $success_message = "Book added successfully!";
            move_uploaded_file($_FILES['Image']['tmp_name'], $TargetFile);
        }
    }

    if (isset($_POST['Go_btn'])) {
        if (!empty($Book_ID)) {
            $query = "SELECT * FROM books WHERE Book_ID = '$Book_ID'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $Book_Name = $row['Title'];
                $Genre = $row['Genere'];
                $Auth_ID = $row['Author_ID'];
                $Pub_ID = $row['Publisher_ID'];
                $Pub_Date = $row['Published_date'];
                $Language = $row['Language_'];
                $Edition = $row['Edition_'];
                $Cost = $row['Book_cost'];
                $Page = $row['Number_pages'];
                $Descp = $row['Book_description'];
                $Stock = $row['Actual_stock'];
                $Current_stock = $row['Current_stock'];
                $Issue = $Stock - $Current_stock;
            } else {
                $error_message = "No data found for the given ID.";
            }
        } else {
            $error_message = "Please insert an ID.";
        }
    }

    if (isset($_POST['Update_btn'])) {
        if (!empty($Book_ID)) {
            $query = "UPDATE books SET Title = '$Book_Name',
                                        Genere = '$Genre',
                                        Author_ID = '$Auth_ID',
                                        Publisher_ID = '$Pub_ID',
                                        Published_Date = '$Pub_Date',
                                        Language_ = '$Language',
                                        Edition_ = '$Edition',
                                        Book_cost = '$Cost',
                                        Number_pages = '$Page',
                                        Book_description = '$Descp',
                                        Actual_stock = '$Stock'
                        WHERE Book_ID = '$Book_ID'";
            mysqli_query($conn, $query);
            $success_message = "Book updated successfully!";
        } else {
            $error_message = "All feilds are required";
        }
    }

    if (isset($_POST['Delete_btn'])) {
        if (!empty($Book_ID)) {
            $query = "DELETE FROM books WHERE Book_ID = '$Book_ID'";
            mysqli_query($conn, $query);
            $success_message = "Book deleted successfully!";
        } else {
            $error_message = "ID feild required";
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book inventory</title>
    <style>
        .book-image {
            padding: 2;
            width: 150px;
            /* Ensures the image fits within its container */
            height: 150px;
            /* Maintains aspect ratio */
        }

        .book-container {
            border: 1px solid #dee2e6;
            /* Matches Bootstrap table borders */
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body class="custom">

    <form action="" method="post" enctype="multipart/form-data">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="card my-5 mx-3">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <h4>Book Details</h4>
                                        </center>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <img id="imgview" src="Assets/img/book.png" width="100" />
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
                                        <input name="Image" type="file" class="form-control-file" id="exampleFormControlFile1">
                                    </div>
                                </div>
                                <!-- first row bookid and name  -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Book ID</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="Book_ID" type="text" placeholder="Book ID" Class="form-control" ID="input1" value="<?php echo htmlspecialchars($Book_ID); ?>" />
                                                <Button name="Go_btn" class="btn btn-block btn-secondary ml-1" ID="Button3">GO</Button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <label>Book Name</label>
                                        <div class="form-group">
                                            <input name="Book_Name" type="text" Class="form-control" ID="textbox2" placeholder="Book Name" value="<?php echo htmlspecialchars($Book_Name); ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- second row language, publisher and gener  -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Language</label>
                                        <div class="form-group">
                                            <select name="Language" Class="form-control" ID="DropDownList1">
                                                <option value="" disabled <?= (!isset($Language) || empty($Language)) ? 'selected' : '' ?>>Choose...</option>
                                                <option value="Amharic" <?= (isset($Language) && trim($Language) === 'Amharic') ? 'selected' : '' ?>>Amharic</option>
                                                <option value="English" <?= (isset($Language) && trim($Language) === 'English') ? 'selected' : '' ?>>English</option>
                                                <option value="French" <?= (isset($Language) && trim($Language) === 'French') ? 'selected' : '' ?>>French</option>
                                                <option value="Spanish" <?= (isset($Language) && trim($Language) === 'Spanish') ? 'selected' : '' ?>>Spanish</option>

                                            </select>
                                        </div>

                                        <label>Publisher Name</label>
                                        <div class="form-group">
                                            <select name="Publisher_Name" Class="form-control" ID="DropDownList2">
                                                <?php while ($row = mysqli_fetch_array($publisher)) { ?>
                                                    <option value="<?php echo $row['Publisher_ID'] ?>"
                                                        <?php if (isset($Pub_ID) && trim($Pub_ID) === trim($row['Publisher_ID'])) echo 'selected'; ?>>
                                                        <?php echo $row['Publisher_Name']; ?>
                                                    </option> <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Author Name</label>
                                        <div class="form-group">
                                            <select name="Author_Name" Class="form-control" ID="DropDownList3" value="<?php echo htmlspecialchars($Auth_ID); ?>">
                                                <option value="" disabled>Choose...</option>
                                                <?php while ($row = mysqli_fetch_array($author)) { ?>
                                                    <option value="<?php echo $row['Author_ID'] ?>"
                                                        <?php if (isset($Auth_ID) && trim($Auth_ID) === trim($row['Author_ID'])) echo 'selected'; ?>>
                                                        <?php echo $row['Author_Name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <label>Publisher Date</label>
                                        <div class="form-group">
                                            <input name="Date" type="date" Class="form-control" ID="textbox3" placeholder="Date" TextMode="Date" value="<?php echo htmlspecialchars($Pub_Date); ?>">
                                        </div>

                                    </div>


                                    <div class="col-md-4">
                                        <label>Genre</label>
                                        <div class="form-group">
                                            <select name="Genre" ID="ListBox1" Class="form-control" SelectionMode="Multiple">
                                                <option value="" disabled <?= (!isset($Genre) || empty($Genre)) ? 'selected' : '' ?>>Choose...</option>
                                                <option Value="SELF-HELP / PERSONAL DEVELOPMENT" <?= (isset($Genre) && trim($Genre) === 'SELF-HELP / PERSONAL DEVELOPMENT') ? 'selected' : '' ?>>SELF-HELP / PERSONAL DEVELOPMENT</option>
                                                <option Value="ADVENTURE" <?= (isset($Genre) && trim($Genre) === 'ADVENTURE') ? 'selected' : '' ?>>ADVENTURE</option>
                                                <option Value="ART" <?= (isset($Genre) && trim($Genre) === 'ART') ? 'selected' : '' ?>>ART</option>
                                                <option Value="COOKING" <?= (isset($Genre) && trim($Genre) === 'COOKING') ? 'selected' : '' ?>>COOKING</option>
                                                <option Value="CONTEMPORARY" <?= (isset($Genre) && trim($Genre) === 'CONTEMPORARY') ? 'selected' : '' ?>>CONTEMPORARY</option>
                                                <option Value="DYSTOPIAN" <?= (isset($Genre) && trim($Genre) === 'DYSTOPIAN') ? 'selected' : '' ?>>DYSTOPIAN</option>
                                                <option Value="FAMILIES & RELATIONSHIPS" <?= (isset($Genre) && trim($Genre) === 'FAMILIES & RELATIONSHIPS') ? 'selected' : '' ?>>FAMILIES & RELATIONSHIPS</option>
                                                <option Value="FANTASY" <?= (isset($Genre) && trim($Genre) === 'FANTASY') ? 'selected' : '' ?>>FANTASY</option>
                                                <option Value="GUIDE/HOW-TO" <?= (isset($Genre) && trim($Genre) === 'GUIDE/HOW-TO') ? 'selected' : '' ?>>GUIDE/HOW-TO</option>
                                                <option Value="HEALTH" <?= (isset($Genre) && trim($Genre) === 'HEALTH') ? 'selected' : '' ?>>HEALTH</option>
                                                <option Value="HISTORICAL FICTION" <?= (isset($Genre) && trim($Genre) === 'HISTORICAL FICTION') ? 'selected' : '' ?>>HISTORICAL FICTION</option>
                                                <option Value="HISTORY" <?= (isset($Genre) && trim($Genre) === 'HISTORY') ? 'selected' : '' ?>>HISTORY</option>
                                                <option Value="HORROR" <?= (isset($Genre) && trim($Genre) === 'HORROR') ? 'selected' : '' ?>>HORROR</option>
                                                <option Value="HUMOR" <?= (isset($Genre) && trim($Genre) === 'HUMOR') ? 'selected' : '' ?>>HUMOR</option>
                                                <option Value="MEMOIR" <?= (isset($Genre) && trim($Genre) === 'MEMOIR') ? 'selected' : '' ?>>MEMOIR</option>
                                                <option Value="MYSTERY" <?= (isset($Genre) && trim($Genre) === 'MYSTERY') ? 'selected' : '' ?>>MYSTERY</option>
                                                <option Value="MOTIVATIONAL" <?= (isset($Genre) && trim($Genre) === 'MOTIVATIONAL') ? 'selected' : '' ?>>MOTIVATIONAL</option>
                                                <option Value="PARANORMAL" <?= (isset($Genre) && trim($Genre) === 'PARANORMAL') ? 'selected' : '' ?>>PARANORMAL</option>
                                                <option Value="ROMANCE" <?= (isset($Genre) && trim($Genre) === 'ROMANCE') ? 'selected' : '' ?>>ROMANCE</option>
                                                <option Value="SCIENCE FICTION" <?= (isset($Genre) && trim($Genre) === 'SCIENCE FICTION') ? 'selected' : '' ?>>SCIENCE FICTION</option>
                                                <option Value="THRILLER" <?= (isset($Genre) && trim($Genre) === 'THRILLER') ? 'selected' : '' ?>>THRILLER</option>
                                                <option Value="TRAVEL" <?= (isset($Genre) && trim($Genre) === 'TRAVEL') ? 'selected' : '' ?>>TRAVEL</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Edition</label>
                                        <div class="form-group">
                                            <input name="Edition" type="text" Class="form-control" ID="textbox8" placeholder="Edition" value="<?php echo htmlspecialchars($Edition); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Cost(per unit)</label>
                                        <div class="form-group">
                                            <input name="Cost" for="text" Class="form-control" ID="textbox9" placeholder="Cost" TextMode="Number" value="<?php echo htmlspecialchars($Cost); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Page</label>
                                        <div class="form-group">
                                            <input name="Page" type="text" Class="form-control" ID="textbox10" placeholder="Page" TextMode="Number" value="<?php echo htmlspecialchars($Page); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Stock</label>
                                        <div class="form-group">
                                            <input name="Stock" type="text" Class="form-control" ID="textbox4" placeholder="stock" TextMode="Number" value="<?php echo htmlspecialchars($Stock); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Current stock</label>
                                        <div class="form-group">
                                            <input name="Current_stock" type="text" Class="form-control" ID="textbox5" placeholder="Current stock" TextMode="Number" value="<?php echo htmlspecialchars($Current_stock);?>" ReadOnly="true">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>issue</label>
                                        <div class="form-group">
                                            <input name="Issue" type="text" Class="form-control" ID="textbox6" placeholder="issue" TextMode="Number" value="<?php echo htmlspecialchars($Issue);?>" ReadOnly="true" >
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <label>Description</label>
                                        <div class="form-group">
                                            <input name="Description" type="text" Class="form-control" ID="textbox11" placeholder="description" TextMode="MultiLine" Rows="4"
                                            value="<?php echo htmlspecialchars($Descp)?>">
                                        </div>
                                        <?php
                                        if (!empty($error_message)) { ?>
                                            <p style='color: red;'><?php echo $error_message ?> </p>
                                        <?php } elseif (!empty($success_message)) { ?>
                                            <p style='color: green;'><?php echo $success_message ?> </p>
                                        <?php }
                                        ?>
                                    </div>
                                </div>

                                <div class=" row">
                                    <div class="col-4">
                                        <input name="Add_btn" type="submit" value="add" class="btn btn-outline-success me-1 btn-sm w-100 m-2" ID="button4">
                                    </div>

                                    <div class="col-4">
                                        <input name="Update_btn" type="submit" value="update" class="btn btn-outline-warning me-1 btn-sm w-100 m-2" ID="button1">
                                    </div>

                                    <div class="col-4">
                                        <input name="Delete_btn" type="submit" value="delete" class="btn btn-outline-danger me-1 btn-sm w-100 m-2" ID="button2">
                                    </div>
                                </div>

                                <a href="homepage.aspx">
                                    << back to homepage </a>
                                        <br>
                                        <br>
                            </div>
                        </div>
                </div>

                <div class="col-md-7">
                    <div class="card my-5 mx-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col text-center">
                                    <h4>Book List</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table id="BookTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Data</th>
                                                    <th>Image</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqql = "SELECT books.*, publisher.Publisher_Name, author.Author_Name
                                                                    FROM books
                                                                    INNER JOIN publisher ON books.Publisher_ID = publisher.Publisher_ID
                                                                    INNER JOIN author ON books.Author_ID = author.Author_ID";
                                                $result = mysqli_query($conn, $sqql);

                                                while ($row = mysqli_fetch_array($result)) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['Book_ID']); ?></td>
                                                        <td>
                                                            <div class="book-container">
                                                                <div class="book-label">
                                                                    <h2><b><?php echo htmlspecialchars($row['Title']); ?></b></h2>
                                                                </div>
                                                                <div class="book-info">Author: <b><?php echo htmlspecialchars($row['Author_Name']); ?></b> |
                                                                    Genre: <b><?php echo htmlspecialchars($row['Genere']); ?></b> |
                                                                    Language: <b><?php echo htmlspecialchars($row['Language_']); ?></b></div>
                                                                <div class="book-info">Publisher: <b><?php echo htmlspecialchars($row['Publisher_Name']); ?></b> |
                                                                    Publish Date: <b><?php echo htmlspecialchars($row['Published_date']); ?></b> |
                                                                    Pages: <b><?php echo htmlspecialchars($row['Number_pages']); ?></b> |
                                                                    Edition: <b><?php echo htmlspecialchars($row['Edition_']); ?></b></div>
                                                                <div class="book-info">Cost: <b><?php echo htmlspecialchars($row['Book_cost']); ?></b> |
                                                                    Stock: <b><?php echo htmlspecialchars($row['Actual_stock']); ?> </b>|
                                                                    Available: <b><?php echo htmlspecialchars($row['Current_stock']); ?></b></div>
                                                                <div class="book-info">Description: <b><?php echo htmlspecialchars($row['Book_description']); ?></b></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <img src="<?php echo htmlspecialchars($row['Book_img']); ?>" class="book-image" alt="Book Image">
                                                        </td>
                                                    </tr>
                                                <?php }; ?>

                                            </tbody>
                                        </table>
                                    </div>
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
            $('.table').DataTable({

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

<?php include 'Footer.php' ?>