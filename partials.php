<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true || isset($_SESSION['Signedup'])) {
  $loggedin = true;
}
 else {
  $loggedin = false;
}

echo '<nav class="navbar navbar-expand-lg bg-info">
  <div class="container-fluid">
    <a class="navbar-brand" href="/keepnotes">keep Notes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/keepnotes/home.php">Home</a>
        </li>';

        if ($loggedin) {
          echo '<li class="nav-item">
            <a class="nav-link" href="/keepnotes/logout.php">Logout</a>
          </li>';
        } else {
          echo '<li class="nav-item">
            <a class="nav-link" href="/keepnotes/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/keepnotes/signup.php">Signup</a>
          </li>';
        }

echo '
      </ul>
    </div>
  </div>
</nav>';
?>
