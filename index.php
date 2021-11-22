<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: proposals.php");
    exit;
}

require_once "config.php";
$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, first_name, last_name, email, password, account, club, changepass FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);


                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $fname, $lastname, $email, $hashed_password, $account, $club, $changepass);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (md5($password) == $hashed_password) {
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["fname"] = $fname;
                            $_SESSION["account"] = $account;
                            $_SESSION["club"] = $club;
                            $_SESSION["lname"] = $lastname;
                            $_SESSION["fullname"] = $fname . " " . $lastname;
                            $_SESSION["changepass"] = $changepass;
                            $_SESSION["loggedin"] = true;
                            if (!$changepass) {
                                header("location: changepass.php");
                            } else {
                                header("location: proposals.php");
                            }
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <script src="indexscript.js"></script>
</head>

<body>

    <div class="bg">
        <div class="center">
            <h1>Project Proposal</h1><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label style="padding-left: 10px;">Email:</label>
                <input type="text" name="email" data-validate="Email is required" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Email">
                <span class="errorclass"><?php echo $email_err; ?></span><br>

                <label style="padding-left: 10px;">Password:</label>
                <input type="password" name="password" data-validate="Password is required" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
                <span class="errorclass"><?php echo $password_err; ?></span>
                <br>
                <br>
                <input type="submit" class="btn btn-primary" value="Login" style="margin-bottom: 15px;">
            </form>

            <div style="text-align: center;">
            <button id="myBtn" class="btn btn-primary">READ ME</button><br>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <b>Officer Credentials</b>
                    <p>Email: </p>
                    <p>angelogloria20@gmail.com</p>
                    <p>Password:</p>
                    <p>agloria</p>
                </div>

            </div>
        </div>
    </div>


</body>
<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</html>