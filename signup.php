<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <title>SignUp</title>
</head>

<body>
    <?php
    require 'partials.php';
    $servername="localhost";
    $username="root";
    $password="";
    $database="login";
    $connection=mysqli_connect($servername,$username,$password,$database);

    
        if (!$connection) 
        {
            echo 'Connection Failed'.mysqli_error($connection);
        }
        else
        {
            
            if ($_SERVER['REQUEST_METHOD']=='POST')
            {
                $username=$_POST['username'];
                $email=$_POST['email'];
                $password=$_POST['password'];
                $password2=$_POST['password2'];
                
                $sql="SELECT * FROM `login system` WHERE `username`='$username'";
                $result=mysqli_query($connection,$sql);
                $num=mysqli_num_rows($result);
                if ($num>0) 
                {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Failed!</strong> Username already exist.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                }
                else {
                if ($password==$password2) 
                {
                    if ($email && $username)
                    {
                        $hash=password_hash($password,PASSWORD_DEFAULT);
                        $sql="INSERT INTO `login system` (`Sr. No`, `username`, `email`, `password`, `date`) VALUES (NULL, '$username', '$email', '$hash', current_timestamp())";
                        $result=mysqli_query($connection,$sql);
                        if ($result) 
                        {
                            
                            $_SESSION['Signedup']=true;
                            $_SESSION['username']=$username;
                            
                            header("location: home.php");
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong> Your account created successfully. You can now login.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }
                        else 
                        {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Failed!</strong> Failed to sign up. There is some problem, we are sorry for inconvinience.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                        }
                    }
                    else 
                    {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Failed!</strong> Failed to sign up. Please enter details.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                }
                else 
                {
                        echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Failed!</strong> Failed to sign up. Password donot match.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    
                }
                
            }
        }
        }
    ?>
    <div class="container">
        <h1>Signup to our Website</h1>
        <form action="/keepnotes/signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" maxlength="20" class="form-control" id="username" name="username"
                    aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" maxlength="20" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="Password2" class="form-label">Confirm Password</label>
                <input type="password" maxlength="20" class="form-control" id="password2" name="password2">
            </div>
            <div id="emailHelp" class="form-text">We'll never share your information with anyone else.</div>
            <button type="submit" class="btn btn-primary">Signup</button>
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