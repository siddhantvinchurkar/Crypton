<?php

// Server Credentials

$servername = "localhost";
$username = "crypton";
$password = "zimbabwe367";
$dbname = "crypton";

// Create connection

 $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO user_accounts (email)
	VALUES ('".$_GET['email']."')";

$conn->query($sql);

$sql = "SELECT * FROM user_accounts WHERE email='".$_GET['email']."'";

$result = $conn->query($sql);
$balance = 0;

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$balance = $row["balance"];
	}
}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Crypton | Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="icon" href="../images/favicon.png">
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">

				<!-- Intro -->
					<div id="intro">
						<h1>This is<br />
						Crypton</h1>
						<p>A cryptocurrency built in pure JavaScript.</p>
						<ul class="actions">
							<li><a href="#header" class="button icon solo fa-arrow-down scrolly">Continue</a></li>
						</ul>
					</div>

				<!-- Header -->
					<header id="header">
						<a href="../dashboard/<?php echo '?email='.$_GET['email']; ?>" class="logo">Crypton</a>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="links">
							<li class="active"><a href="../dashboard/<?php echo '?email='.$_GET['email']; ?>#main">Your Account</a></li>
							<li><a href="send<?php echo '?email='.$_GET['email']; ?>#main">Send Crypton</a></li>
							<li><a href="mine<?php echo '?email='.$_GET['email']; ?>#main">Mine Crypton</a></li>
						</ul>
						<ul class="icons">
							<li><a href="https://facebook.com/sidvinchurkar" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
							<li><a href="https://github.com/siddhantvinchurkar" class="icon fa-github" target="_blank"><span class="label">GitHub</span></a></li>
							<li><a href="mailto:siddhantvinchurkar@gmail.com" class="icon fa-envelope"><span class="label">Email</span></a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
					<h2>You have <?php echo $balance; ?> Crypton(s)</h2>
					</div>

				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; <script>document.write(new Date().getFullYear())</script> <a href="https://volatile.ga/" target="_blank">Volatile, Inc.</a></li><li>Designed by <a href="https://siddhantvinchurkar.me/" target="_blank">Siddhant Vinchurkar</a></li><li>Made with love for everyone.</li></ul>
					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
