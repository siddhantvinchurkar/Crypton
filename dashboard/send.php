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
		<script src="../src/bundle-v3.js"></script>
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
							<li><a href="../dashboard/<?php echo '?email='.$_GET['email']; ?>#main">Your Account</a></li>
							<li class="active"><a href="send<?php echo '?email='.$_GET['email']; ?>#main">Send Crypton</a></li>
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
						<form action="send<?php echo '?email='.$_GET['email']; ?>#main" method="post" id="sendform">
							<div class="row">
								<div class="col-md-12">
									<input type="email" name="address" id="address" value="" placeholder="Email">
								</div>
								<div class="col-md-12">
									<input type="number" name="amount" id="amount" value="" placeholder="Amount" max="<?php echo $balance; ?>">
								</div>
								<div class="col-md-12">
									<a href="#main" class="button special icon fa-send" onclick="document.getElementById('sendform').submit();">Send</a>
								</div>
							</div>
						</form>
					</div>

				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; <script>document.write(new Date().getFullYear())</script> <a href="https://volatile.ga/" target="_blank">Volatile, Inc.</a></li><li>Designed by <a href="https://siddhantvinchurkar.me/" target="_blank">Siddhant Vinchurkar</a></li><li>Made with love for everyone.</li></ul>
					</div>

			</div>

<script>
window.onload = function(){
<?php
if(isset($_POST['address']) && isset($_POST['amount'])){
if(!empty($_POST['address']) || !empty($_POST['amount'])){
if($_POST['amount'] <= $balance){
$sql = "SELECT * FROM user_accounts WHERE email='".$_POST['address']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
// We're ready to perform transaction.
echo 'console.log("Ready to perform transaction.");';
// Update account balances on the database
$balance -= $_POST['amount'];
$sql = "UPDATE user_accounts SET balance=".$balance." WHERE email='".$_GET['email']."'";
$result = $conn->query($sql);
$sql = "SELECT * FROM user_accounts WHERE email='".$_POST['address']."'";
$result = $conn->query($sql);
$balance = 0;
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$balance = $row["balance"];
	}
}
$balance += $_POST['amount'];
$sql = "UPDATE user_accounts SET balance=".$balance." WHERE email='".$_POST['address']."'";
$result = $conn->query($sql);
// Get blockchain
$sql = "SELECT * FROM blockchain";
$result = $conn->query($sql);
$blockchain = "";
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$blockchain = $row["blockchain"];
	}
}
// Code that has issues:
echo "cryptonite = JSON.parse('".$blockchain."');";
echo "flag = true;";
echo "console.log(JSON.stringify(crypton));";
// Perform transaction
echo "sender = '".$_GET['email']."';";
echo "recipient = '".$_POST['address']."';";
echo "amount = ".$_POST['amount'].";";
echo "crypton.createTransaction(transaction);";
// Reload the page with the updated blockchain as a GET variable
echo 'window.location.href = "../dashboard/send?'.$_GET['email'].'&blockchain=" + JSON.stringify(crypton);';
}
else echo 'alert("Looks like '.$_POST['address'].' is not a registered user. You can only transfer funds to registered accounts.");';
}
else echo 'alert("It looks like you have insufficient funds to complete the transaction");';
}
else echo 'alert("Please fill out all the necessary details.");';
}
if(isset($_GET['blockchain'])){
// Push updated blockchain to database
$sql = "UPDATE blockchain SET blockchain='".$_GET['blockchain']."'";
$result = $conn->query($sql);
// Reload the page to avoid trouble
header("Location: ../dashboard/?email=".$_GET['email']);
die();
}
?>
}
</script>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
