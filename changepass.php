<?php
session_start();
require_once "config.php";

$idForQuery = $_SESSION["id"];
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["new_password"]))) {
    $new_password_err = "<p>Please enter the new password.</p>";
  } elseif (strlen(trim($_POST["new_password"])) < 6) {
    $new_password_err = "<p>Password must have atleast 6 characters.</p>";
  } else {
    $new_password = trim($_POST["new_password"]);
  }

  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "<p>Please confirm the password.</p>";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($new_password_err) && ($new_password != $confirm_password)) {
      $confirm_password_err = "<p>Password did not match.</p>";
    }
  }

  if (empty($new_password_err) && empty($confirm_password_err)) {
    $sql = "UPDATE users SET password = ?, changepass = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "sss", $param_password, $param_changepass, $param_id);

      $param_password = md5($_POST["new_password"]);
      $param_changepass = true;
      $param_id = $_SESSION["id"];


      if (!isset($oldPassBool)) {
        if (mysqli_stmt_execute($stmt)) {
          $sqlOldPass = "INSERT INTO old_password (OLD_PASSWORD, ID) VALUES ( ?, ?)";
          if ($stmtOldPass = mysqli_prepare($conn, $sqlOldPass)) {
            mysqli_stmt_bind_param($stmtOldPass, "ss", $param_OldPass,  $param_OldPass_ID);
            $param_OldPass = $param_password;
            $param_OldPass_ID = $idForQuery;

            if (mysqli_stmt_execute($stmtOldPass)) {
            } else {
              echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmtOldPass);
          }
          echo "<script type='text/javascript'>
        window.addEventListener('load', function() {
          $('#exampleModalLong').modal('show');
          });
          </script>
          </script>";
          session_destroy();
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
    }
    mysqli_stmt_close($stmt);
  }
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="css/navalt.css">
  <link rel="stylesheet" href="css/tabs.css">

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <title>Change Password</title>
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
            <a class="nav-link" href="proposals.php">Proposals</a>
          </li>

          <?php
          if ($_SESSION["account"] != "OFFICER") {
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
                        } elseif ($_SESSION["club"] != null) {
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
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row">
          <h1>Change Password</h1>
        </div>
        <br>

        <label style="padding-left: 10px;">New Password:</label>
        <input placeholder="New Password" id="myInput" type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
        <span><?php echo $new_password_err; ?></span>

        <label style="padding-left: 10px; margin-top: 15px;">Confirm Password:</label>
        <input placeholder="Confirm Password" id="myInput" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
        <span><?php echo $confirm_password_err; ?></span>
        <br>

        <input style="height: 50px;" type="submit" class="button"> </button>
        <div style="float: right; margin-bottom:10px;">
          <a class="button" onclick="href='home.php'">Cancel</a>
        </div>
      </form>
    </div>
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
          Password has been Changed. Please login again.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href = 'index.php'">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>