<?php
session_start();
require_once "config.php";
date_default_timezone_set('Asia/Manila');
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["account"] == "OFFICER") {
  header("location: index.php");
  exit;
}

if (!$_SESSION["changepass"]) {
  header("location: changepass.php");
}
?>

<?php
date_default_timezone_set('Asia/Manila');

$P_FNAME = $P_LNAME = $P_CLUB = $P_TITLE = $P_DETAILS =
  $P_STARTDATE = $P_BUDGET = $P_FILENAME  = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $P_FNAME = $_SESSION["fname"];
  $P_LNAME = $_SESSION["lname"];
  $P_EMAIL = $_SESSION["email"];
  $P_CLUB = $_SESSION["club"];
  $P_TITLE = $_POST["title"];
  $P_DETAILS = $_POST["details"];
  $P_STARTDATE =  $_POST["startDate"];
  $P_BUDGET = $_POST["budget"];

  $sql = "INSERT INTO proposals (P_FNAME, P_LASTNAME, P_EMAIL, P_CLUB, P_TITLE, P_DETAILS, P_STARTDATE, P_BUDGET)

  VALUES (?,?,?,?,?,?,?,?)";

  if ($stmt = mysqli_prepare($conn, $sql)) {

    mysqli_stmt_bind_param(
      $stmt,
      "ssssssss",
      $param_P_FNAME,
      $param_P_LNAME,
      $param_P_EMAIL,
      $param_P_CLUB,
      $param_P_TITLE,
      $param_P_DETAILS,
      $param_P_STARTDATE,
      $param_P_BUDGET,
    );

    $param_P_FNAME = $P_FNAME;
    $param_P_LNAME = $P_LNAME;
    $param_P_EMAIL = $P_EMAIL;
    $param_P_CLUB = $P_CLUB;
    $param_P_TITLE = $P_TITLE;
    $param_P_DETAILS = $P_DETAILS;
    $param_P_STARTDATE = $P_STARTDATE;
    $param_P_BUDGET = $P_BUDGET;

    if (mysqli_stmt_execute($stmt)) {

      echo "<script type='text/javascript'>
                window.addEventListener('load', function() {
                  $('#exampleModalLong').modal('show');
                  });
                  </script>";
      $last_id = $conn->insert_id;
    } else {
      echo "Something went wrong. Please try again later.";
    }
  }
}
?>

<html>

<head>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="image/png" href="images/icons/faviconko.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="css/navalt.css">
  <link rel="stylesheet" href="css/tabs.css">

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <title>Create Request</title>
</head>



<body>
  <div class="bg">
    <nav class="navbar navbar-expand-lg navbar-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="proposals.php">Manage Request</a>
          </li>

          <?php
          if ($_SESSION["account"] == "CLUB") {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="home.php">Create Request</a>
            </li>

          <?php
          }
          if ($_SESSION["account"] == "OFFICER") {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="newuser.php">Create Account</a>
            </li>
          <?php
          }
          ?>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Welcome, <?php echo $_SESSION["fname"] . " ";
                        if ($_SESSION["account"] == "OFFICER") {
                          echo '<p style="display: inline-block; margin:0px; padding:0px;">' . '| Officer</p>';
                        } else {
                          echo '<p style="display: inline-block; margin:0px; padding:0px;">' . '| ' . $_SESSION["club"] . '</p>';
                        } ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="changepass.php">Change Password</a>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="center">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <h1>Proposal Form</h1><br>
        <label>Project Title:</label>
        <input type="text" name="title" class="form-control wrap-input50" required>

        <label>Project Details:</label>
        <textarea name="details" rows="2" cols="30" class="form-control wrap-input50" required></textarea>

        <label>Estimated Start Date:</label>
        <input type="date" name="startDate" class="form-control wrap-input50" required>

        <label>Estimated Budget:</label>
        <select name="budget" id="budget" class="form-control wrap-input50">
          <option value="$0-$99">$0-$99</option>
          <option value="$100-$499">$100-$499</option>
          <option value="$500-$999">$500-$999</option>
          <option value="$1000">$1000+</option>
        </select>
        <input style="height: 50px;" type="submit" class="button"></button>
        <a class="button" onclick="href='home.php'" style="float: right;">Cancel</a>
      </form>
    </div>

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLong" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Success</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Proposal has been created.
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</html>