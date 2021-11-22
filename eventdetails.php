<?php
session_start();

$id = $_POST['pID'];
require_once "config.php";


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}

if (!isset($id)) {
  header("location: proposals.php");
}

if (!$_SESSION["changepass"]) {
  header("location: changepass.php");
}

$fullname = $_SESSION["fullname"];


if (isset($_POST["comment"])) {
  $comment = $_POST["comment"];
} else {
  $comment = null;
}

if (isset($_POST["approve"])) {
  $pID = $_POST["pID"];
  $decisionTime = date("M. d, Y");
  $sql2 = "UPDATE proposals SET P_STATUS = 'APPROVED', P_REMARKS = '$comment', P_REVIEWER = '$fullname' WHERE P_ID = '$pID'";
  $result2 = mysqli_query($conn, $sql2);
  echo "<script type='text/javascript'>
	window.addEventListener('load', function() {
		$('#modalDeny').modal();
		});
		</script>
		";
  header("location: proposals.php");
} elseif (isset($_POST["deny"])) {
  $pID = $_POST["pID"];
  $decisionTime = date("M. d, Y");
  $sql2 = "UPDATE proposals SET P_STATUS = 'DENIED', P_REMARKS = '$comment', P_REVIEWER = '$fullname' WHERE P_ID = '$pID'";
  $result2 = mysqli_query($conn, $sql2);
  echo "<script type='text/javascript'>
	window.addEventListener('load', function() {
		$('#modalDeny').modal();
		});
		</script>
		";
  header("location: proposals.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/stepper.css">
  <link rel="stylesheet" href="css/navalt.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/tabs.css">

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <title>Event Details</title>
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

    </br>
    <div class="container">

      <?php
      $id = $_POST['pID'];
      $sql = "SELECT * FROM proposals WHERE P_ID='$id'";
      $result = mysqli_query($conn, $sql);
      $rows = mysqli_fetch_array($result);

      if ($rows["P_STATUS"] == "PENDING") {
        $banner = "pendingbanner";
      } elseif ($rows["P_STATUS"] == "APPROVED") {
        $banner = "approvedbanner";
      } elseif ($rows["P_STATUS"] == "DENIED") {
        $banner = "deniedbanner";
      }
      ?>
      <div class="container">
        <div class="row" style="text-align: center; margin-right: 250px; margin-left: 250px;">
          <div class="<?php echo $banner; ?>">
            <h1><?php echo $rows["P_STATUS"]; ?></h1>
            <?php
            if ($rows["P_STATUS"] != "PENDING") {
              echo "<p>By " . $rows["P_REVIEWER"] . " on " . $rows["P_DATE_REVIEWED"];
            }
            ?>
          </div>
          <table class="table table-bordered" bgcolor="FFFFFF">
            <thead class="table-dark">
              <tr>
                <td colspan="12" data-toggle="collapse" data-target="#visitors" class="accordion"><?php echo $rows["P_TITLE"]; ?></td>
              </tr>
            </thead>

            <tbody id="visitors" class="collapse.show">
              <tr>
                <td class="tdleft">Details</td>
                <td class="tdright"><?php echo $rows['P_DETAILS'] ?></td>
              </tr>
              <tr>
                <td>Estimated Start Date</td>
                <td><?php echo $rows['P_STARTDATE'] ?></td>
              </tr>
              <tr>
                <td>Estimated Budget</td>
                <td><?php echo $rows['P_BUDGET'] ?></td>
              </tr>
              <tr>
                <td>Club</td>
                <td><?php echo $rows['P_CLUB'] ?></td>
              </tr>
              <tr>
                <td>Proposed by</td>
                <td><?php echo $rows['P_FNAME'] . ' ' . $rows['P_LASTNAME'] ?></td>
              </tr>
            </tbody>


          </table>
          <?php
          if (($_SESSION["account"] == "OFFICER" && $rows["P_STATUS"] == "PENDING")
            || ($_SESSION["account"] == "OFFICER" && $rows["P_STATUS"] != "!PENDING" && !empty($rows["P_REMARKS"]))
            || ($_SESSION["account"] == "CLUB" && $rows["P_STATUS"] != "!PENDING" && !empty($rows["P_REMARKS"]))
          ) {
          ?>
            <table class="table table-bordered" bgcolor="FFFFFF">
              <thead class="table-dark">
                <tr>
                  <td colspan="12" data-toggle="collapse" data-target="#comments" class="clickable">Remarks</td>
                </tr>
              </thead>
              <tbody id="comments" class="collapse.show">
                <tr>
                  <?php
                  if ($_SESSION["account"] == "OFFICER") {
                    $displayName = $_SESSION["fullname"];
                  } else {
                    $displayName = $rows["P_REVIEWER"];
                  }
                  ?>
                  <td style="width: 30%"><?php echo $displayName; ?></td>
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php if (!isset($rows['P_REMARKS'])) { ?>
                      <td><textarea name="comment" cols="47" rows="3" id="comment" placeholder="Please enter additional information"></textarea></td>

                    <?php } else { ?>
                      <td>
                        <?php echo $rows['P_REMARKS']; ?></td>
                    <?php } ?>
                </tr>
              </tbody>
            </table>
          <?php
          }
          ?>
        </div>

        <div style="text-align: center;" ID="btnToHide">
          <input type="hidden" name="pID" value="<?php echo $id; ?>">
          <input type="hidden" name="activityName" value="<?php echo $rows['P_TITLE']; ?>">
          <input type="submit" style="width: 10%; margin: 1%;; display: inline-block;" class="btn btn-success btn-lg finalBtn" value="Approve" name="approve" onclick="return confirm('Are you sure you want to approve?');">
          <input type="submit" style="width: 10%; margin: 1%; display: inline-block;" class="btn btn-danger btn-lg finalBtn" value="Deny" name="deny" onclick="return confirm('Are you sure you want to deny?');">
        </div>
        </form>


        <?php
        $id = $_POST['pID'];
        $sql10 = "SELECT * FROM proposals WHERE P_ID= '$id'";
        $result10 = mysqli_query($conn, $sql10);
        $rows10 = mysqli_fetch_array($result10);
        ?>

        <?php
        if ($rows10['P_STATUS'] != "PENDING" || $_SESSION['account'] == "CLUB") {
          echo "<script>document.getElementById('btnToHide').style = 'display: none;';</script>";
        }
        ?>
</body>

</html>