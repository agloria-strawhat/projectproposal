<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: index.php");
	exit;
}

if (!$_SESSION["changepass"]) {
	header("location: changepass.php");
}
?>

<?php
date_default_timezone_set('Asia/Manila');
if (isset($_POST["approve"]) && $_SESSION['role'] == "OSG") {
	$visID = $_POST["idOfVisitor"];
	$comment = $_POST["comment"];
	$decisionTime = date("M. d, Y h:i:s A");
	$sql2 = "UPDATE visitor SET status = 'APPROVED', osg_decision = 'APPROVED', osg_comment = '$comment', decision_time = '$decisionTime' WHERE VISITOR_ID = '$visID'";
	$result2 = mysqli_query($conn, $sql2);
	echo "<script type='text/javascript'>
	window.addEventListener('load', function() {
		$('#modalApprove').modal();
		});
		</script>
		";
}

if (isset($_POST["deny"]) && $_SESSION['role'] == "OSG") {
	$visID = $_POST["idOfVisitor"];
	$comment = $_POST["comment"];
	$decisionTime = date("M. d, Y h:i:s A");
	$sql5 = "UPDATE visitor SET status='DENIED', osg_decision ='DENIED', osg_comment = '$comment', decision_time = '$decisionTime' WHERE VISITOR_ID = '$visID'";
	$result5 = mysqli_query($conn, $sql5);
	echo "<script type='text/javascript'>
	window.addEventListener('load', function() {
	$('#modalDeny').modal();
	});
	</script>
	";
}
?>

<!DOCTYPE html>
<html>

<head>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="css/datatables.css">
	<link rel="stylesheet" href="css/navalt.css">
	<link rel="stylesheet" href="css/tabs.css">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/passchangescript.js"></script>

	<title>Proposals</title>

</head>

<body>
	<div class="bg">
		<div>
			<nav class="navbar navbar-expand-lg navbar-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<?php
							if ($_SESSION['account'] == "OFFICER") {
							?>
								<a class="nav-link" href="proposals.php">Proposals</a>
							<?php
							} else {
							?>
								<a class="nav-link" href="proposals.php">My Proposals</a>
							<?php
							}
							?>
						</li>

						<?php
						if ($_SESSION["account"] == "CLUB") {
						?>
							<li class="nav-item">
								<a class="nav-link" href="home.php">Create Proposal</a>
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
			<div class="container">
				<br /><br />
				<div style="overflow-x:auto; text-align: center;">
					<table id="thisTable" class="table">
						<thead class="table-dark">
							<tr>
								<th>Club</th>
								<th>Proposal</th>
								<th>Student</th>
								<th>Date Created</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($_SESSION['account'] == "OFFICER") {
								$sql = "SELECT * FROM proposals ORDER BY P_ID DESC";
								$result = mysqli_query($conn, $sql);
							}

							if ($_SESSION['account'] == "CLUB") {
								$email = $_SESSION['email'];
								$sql = "SELECT * FROM proposals WHERE P_EMAIL = '$email' ORDER BY P_ID DESC";
								$result = mysqli_query($conn, $sql);
							}

							while ($rows = mysqli_fetch_array($result)) {
							?>
								<tr>
									<td><?php echo $rows['P_CLUB']; ?></td>
									<td><?php echo $rows['P_TITLE']; ?></td>
									<td><?php echo $rows['P_FNAME'] . " " . $rows['P_LASTNAME']; ?></td>
									<td><?php echo $rows['P_DATECREATED']; ?></td>
									<td>
										<form method="POST" action="eventdetails.php">
											<input type="hidden" name="pID" value="<?php echo $rows['P_ID']; ?>">

											<?php
											if ($rows['P_STATUS'] == "APPROVED") {
												$classBtn = "btn btn-success";
											} else if ($rows['P_STATUS'] == "DENIED") {
												$classBtn = "btn btn-danger";
											} else if ($rows['P_STATUS'] == "PENDING") {
												$classBtn = "btn btn-warning";
											}
											?>
											<input style="width: 100%; height:35px;" type="submit" class="<?php echo $classBtn; ?>" value="<?php echo $rows['P_STATUS']; ?>" onclick='window.location.href = "eventdetails.php";'>
											<div style="display: none;"><?php echo $rows['P_STATUS']; ?></div>

										</form>
									</td>
								</tr>
							<?php
							}
							mysqli_close($conn);
							?>
						</tbody>
					</table>
				</div>
			</div>


			<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="modalApprove" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Request Approved Message</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?php echo $_POST["activityName"]; ?> has been approved!
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="modalDeny" tabindex="-1" role="dialog" aria-labelledby="modalDeny" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Request Denied Message</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?php echo $_POST["activityName"]; ?> has been denied!
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<script>
				$(document).ready(function() {
					$('#thisTable').DataTable({
						"order": [
							[5, "asc"]
						]
					});
				});
			</script>
			<script type="text/javascript">
				console.log(<?php echo $_SESSION['role'] ?>);
			</script>
</body>

</html>