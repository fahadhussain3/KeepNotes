<?php
    require 'partials.php';
    $usrname = $_SESSION['username'];
    $servername="localhost";
    $username="root";
    $password="";
    $database="login";
    $connection=mysqli_connect($servername,$username,$password,$database);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("location: login.php");
        exit;
        }
        else{

        //this will chech weather $_SESSION['Signedup'] is equal to true which is only when user signed up
            // if(isset($_SESSION['Signedup'])|| $_SESSION['Signedup'] !== true) {
                $tableCheckQuery = "SHOW TABLES LIKE '{$usrname}'";
                $tableCheckResult = mysqli_query($connection, $tableCheckQuery);
                    if (mysqli_num_rows($tableCheckResult) == 0) {
                        
                        $sqr = "CREATE TABLE  `{$usrname}` (`Sr. No` INT AUTO_INCREMENT PRIMARY KEY,`Note Title` VARCHAR(255) NOT NULL,`Description` TEXT,`Date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
                        $result=mysqli_query($connection,$sqr);}
            }
        
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        if (isset($_POST['delete_id'])) {
                            $id = $_POST['delete_id'];
                            $sql = "DELETE FROM `{$usrname}` WHERE `Sr. No` = $id";
                            $result = mysqli_query($connection, $sql);
                            if ($result) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>Success!</strong> You have Completed your task.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>";
                            } else {
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                        <strong>Error!</strong> Unable to delete note.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>";
                            }
                        } else {
                            $title = $_POST['title'];
                            $description = $_POST['description'];
                            $sql = "INSERT INTO `{$usrname}` (`Sr. No`, `Note Title`, `Description`, `Date`) VALUES (NULL, '$title', '$description', current_timestamp())";
                            $result = mysqli_query($connection, $sql);
                            if ($result) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>Success!</strong> Your note added successfully.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>";
                            }
            }
        }
        }
    
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>Keep Notes</title>
</head>

<body>
    <div class="container">
        <div class="alert alert-info alert-dismissible fade show" role="alert" style="text-align: center;">
            <strong>Welcome!</strong> You can now add your notes here and can delete when you complete the task.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <h4 style="text-align: center;">Welcome to Keep Notes,
        <?php echo $_SESSION['username']; ?>
    </h4>

    <div class="container">
        <form method="POST" action="/keepnotes/home.php">
            <br>
            <h3>Add Your Note</h3>
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
        <br>
        <hr>
        <br>
        <h3 style="text-align: center;">Your Notes</h3>
        <br>
        <hr>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sr. No</th>
                    <th scope="col">Note Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `{$usrname}`";
                $result = mysqli_query($connection, $sql);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <th scope='row'>" . $no . "</th>
                            <td>" . $row['Note Title'] . "</td>
                            <td>" . $row['Description'] . "</td>
                            <td>
                                <form method='POST' action='/keepnotes/home.php' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='" . $row['Sr. No'] . "'>
                                    <button type='submit' class='btn btn-success'>Done</button>
                                </form>
                            </td>
                        </tr>";
                    $no += 1;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>


</body>

</html>