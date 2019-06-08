<html>
<head>
<title>Signing Up</title>
<link rel="stylesheet" type="text/css" href="signup-screen-style.css">
</head>
<body>
<div class = "white-decor"></div>
<h1 style ="float:left;">Tourini</h1>
<h5>Connect with Travelers Now</h5>
<div class = "signup-message">
<?php

$mysqli = new mysqli("localhost", "root", "", "tourini");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}?>
<?php
$new_username = $_GET["new_login_name"];
$new_display_name = $_GET["new_display_name"];
$new_password = $_GET["new_acc_password"];
if ($new_password == "" or $new_display_name == "" or $new_password == ""){
	echo "Login name, display name, and/or password may not be left blank.<br/>";
}
else{
	if ($stmt = $mysqli->prepare("Select uid from Users where uid = ?")){
	$stmt->bind_param("s", $new_username);
	$stmt->execute();
	$stmt->bind_result($uid);
	if ($stmt->fetch())
		echo "This username is taken.<br/>";
	else{
		$stmt = $mysqli->prepare("INSERT INTO Users VALUES (?, ?, ?, NULL, NULL, NULL);");
		$stmt->bind_param("sss", $new_username, $new_display_name, $new_password);
		$stmt->execute();
		echo "Account successfully created.<br/>Welcome,$new_username.<br/>Thank you for registering.<br/>";}
	$stmt->close();
}}
?>
<a href = "main.html">Log in now</a>
</div>
</body>
</html>