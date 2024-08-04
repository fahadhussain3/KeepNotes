<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
    integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

  <title>Login</title>
</head>
<body>
  <?php
    require 'partials.php';
    $servername="localhost";
    $username="root";
    $password="";
    $database="login";
    $connection=mysqli_connect($servername,$username,$password,$database);

    if (!$connection) {
        echo 'Connection Failed'.mysqli_error($connection);
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($username && $password) {
                // Prepare and execute the SQL query
                $sql = "SELECT * FROM `login system` WHERE `username` = '$username'";
                $result = mysqli_query($connection, $sql);

                if ($result) {
                    $num = mysqli_num_rows($result);

                    if ($num == 1) {
                        $user = mysqli_fetch_assoc($result);
                        $hashedPassword = $user['password']; // Retrieve the hashed password

                        // Verify the entered password against the hashed password
                        //It then hashes the entered password using the same algorithm and parameters stored in $hashedPassword
                        if (password_verify($password, $hashedPassword)) {
                            $_SESSION['loggedin'] = true;
                            $_SESSION['username'] = $username;
                            header("Location: home.php");
                            exit();
                        } else {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Failed!</strong> Invalid credentials.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Failed!</strong> Invalid credentials.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                } else {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Failed!</strong> Failed to login. There is some problem, we are sorry for the inconvenience.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Failed!</strong> Please enter both username and password.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    }
  ?>
  <div class="container my-3">
    <h1 style="text-align: center;">Welcome, Login to Continue</h1>
    <form action="/keepnotes/login.php" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div id="emailHelp" class="form-text">We'll never share your information with anyone else.</div>
      <button type="submit" class="btn btn-primary">Log In</button>
      <hr>
      <div id="emailHelp" class="form-text">Sign Up if you do not have account</div>
      <button class="btn btn-primary"><a class="nav-link" href="/keepnotes/signup.php">Sign Up</a></button>
    </form>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  -->
</body>
</html>
