<?php include 'Header.php';
include 'DBconn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book View</title>
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
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
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