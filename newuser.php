<?php
session_start();

if ($_SESSION["account"] == "CLUB") {
  header("location: home.php");
}
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}

if (!$_SESSION["changepass"]) {
  header("location: changepass.php");
}
?>
<?php
require_once "config.php";

$email = $username = $password = $confirm_password = $account = $firstName = $lastName = $club = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $firstName = trim($_POST["firstName"]);
  $lastName = trim($_POST["lastName"]);
  $account = $_POST["account"];
  $email = trim($_POST["email"]);
  if (isset($_POST["club"])) {
    $club = $_POST["club"];
  } else {
    $club = ""; 
  }

  if (empty(trim($_POST["email"]))) {
    $username_err = "<p class=labels>Please enter an email address.</p>";
  } else {
    $sql = "SELECT id FROM users WHERE email = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_email);

      $param_email = trim($_POST["email"]);

      if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "<p class=labels>This email address is already taken.</p>";
        } else {
          $username = trim($_POST["email"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
    mysqli_stmt_close($stmt);
  }


  if (empty($username_err)) {

    $sql = "INSERT INTO users (first_name, last_name, email, password, club, account) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {

      mysqli_stmt_bind_param($stmt, "ssssss", $param_firstName, $param_lastName, $param_email, $param_password, $param_club, $param_account);

      $param_firstName = $firstName;
      $param_lastName = $lastName;
      $param_email = $email;
      $param_password = md5(strtolower($firstName[0] . $lastName));
      $param_club = $club;
      $param_account = $account;
      if (mysqli_stmt_execute($stmt)) {
        echo "<script type='text/javascript'>
              window.addEventListener('load', function() {
                $('#exampleModalLong').modal('show');
                });
                </script>
                </script>";
      } else {
        echo "Something went wrong. Please try again later.";
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="css/navalt.css">
  <link rel="stylesheet" href="css/tabs.css">

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="js/crypto-js/crypto-js.js"></script>
  <script src="js/encrypt-functions.js"></script>
  <script src="js/encrypt-app.js"></script>
  <script src="js/newuserscript.js"></script>
  <script src="newuserscript.js"></script>

  <title>Manage Account</title>
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
                        } elseif ($_SESSION["account"] == "CLUB") {
                          echo '<p style="display: inline-block; margin:0px; padding:0px;">' . '| ' . $_SESSION["club"] . '</p>';
                        }
                        ?>
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
        <h1>Create New Account</h1>
        <br>
        <label>First Name:</label>
        <input id="first-name" placeholder="First Name" type="text" name="firstName" required class="form-control wrap-input50" value="<?php echo $firstName ?>">
        <label>Last Name:</label>
        <input id="last-name" placeholder="Last Name" type="text" name="lastName" required class="form-control wrap-input50" value="<?php echo $lastName ?>">

        <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <label>Email Address:</label>
          <p><input placeholder="Email Address" type="email" name="email" required class="form-control wrap-input50" value="<?php echo $email ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
          </p>
        </div>

        <label>Account Type:</label>

        <select class="form-control" name="account" id="roleId" value="<?php echo $account ?>" onChange="myFunction(this.value)" style="margin-bottom: 10px;">
          <option value="OFFICER">Officer</option>
          <option value="CLUB">Club</option>
        </select>
        <label id="clubLabel" style="display: none;" for="clubField">Club:</label>
        <select id="clubField" style="display: none;" name="club" class="form-control" value="<?php echo $club; ?>" placeholder="Club">
          <option value="Anime Club">Anime Club</option>
          <option value="Astrology Club">Astrology Club</option>
          <option value="Basketball Club">Basketball Club</option>
          <option value="Chess Club">Chess Club</option>
          <option value="Drama Club">Drama Club</option>
          <option value="eSports Club">eSports Club</option>
          <option value="Gardening Club">Gardening Club</option>
          <option value="Newspaper Club">Newspaper Club</option>
          <option value="Science Club">Science Club</option>
        </select>
        <br>
        <div style="text-align: center;">
          <button class="button" type="submit"><span>Submit</span></button>
          <a class="button" onclick="href='home.php'"><span>Cancel</span></a>
        </div>
      </form>
      <br>
    </div>


    <!--Modal-->
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
            User Created
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>

</html>