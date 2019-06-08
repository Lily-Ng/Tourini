<html>
<head>
<title>Logging In</title>
<link rel="stylesheet" type="text/css" href="login-screen-style.css">
</head>
<body>
<div class = "white-decor"></div>
<h1 style ="float:left;">Tourini</h1>
<h5>Connect with Travelers Now</h5>
<div class = "login-message">
<?php

$mysqli = new mysqli("localhost", "root", "", "tourini");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}?>
<?php
session_start();
$_SESSION['input_username'] = $_GET["login-name"];
$_SESSION['input_password'] = $_GET["login-password"];
if ($stmt = $mysqli->prepare("Select uid, password from Users where uid = ? and password = ?")){
	$stmt->bind_param("ss", $_SESSION['input_username'], $_SESSION['input_password']);
	$stmt->execute();
	$stmt->bind_result($uid, $password);
	if ($stmt->fetch()){
		echo "Welcome back, $uid.<br/>";
		header( "refresh:3; url= home_page.php" );}
	else{
		echo "Incorrect username/password.<br/>Redirecting in 3 seconds...<br/>";
		session_unset();
		header( "refresh:3; url= main.html" );}
	$stmt->close();
}
?>
</div>
</body>
</html>