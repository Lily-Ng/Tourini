<html>
<head>
<title>Home Page</title>
<link rel="stylesheet" type="text/css" href="homepage-style.css">
</head>
<body>
<h1 style = "float:left;">Tourini</h1>
<div class = "white-decor"></div>
<div class = "content-holder">
<div class = "nav-menu">
<ul>
	<li><a href = "home_page.php">Browse</a></li>
	<li><a href = "profile.php">Profile</a></li>
	<li><a href = "http://localhost/upload-photo.php">Upload Photo</a></li>
	<li><a href = "http://localhost/upload-post.php">Upload Post</a></li>
	<li><a href = "http://localhost/setting.php">Setting</a></li>
	<li><a href = "http://localhost/friend-requests.php">Friend Requests</a></li>
	<li><a href = "http://localhost/manage-circles.php">Manage Circles</a></li>
	<li><a href = "http://localhost/manage-friends.php">Manage Friends</a></li>
	<li><a href = "http://localhost/main.html">Log Out</a></li>
</ul>
</div>
</div>
<?php
session_start();?>
<?php

$mysqli = new mysqli("localhost", "root", "", "tourini");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}?>
<div class = "greeting">
<?php
if ($stmt = $mysqli->prepare("Select uid, username, password from Users where uid = ?")){
	$stmt->bind_param("s", $_SESSION['input_username']);
	$stmt->execute();
	$stmt->bind_result($uid, $username, $password);
	$stmt->fetch();
	echo "Welcome back, $username.";
	$stmt->close();
}
?>
<div>
<div class = "main-content">
<h3>Manage Circles</h3>
<hr>
<?php
$new_cname = $_GET['cir_name'];
$new_to_circle = $_GET['in_circle'];

if ($stmt = $mysqli->prepare("Select cname, in_circle from Circles WHERE cname = ? and uid = ?")){
	$stmt->bind_param("ss", $new_cname, $_SESSION['input_username']);
	$stmt->execute();
	if ($stmt->fetch()){
		$stmt2 = $mysqli->prepare("UPDATE Circles SET in_circle = CONCAT(in_circle, ',{$new_to_circle}') WHERE cname = $new_cname;");
		$stmt2->execute();
		echo "circle updated.";
		$stmt2->close();
	$stmt->close();}}
if ($stmt = $mysqli->prepare("INSERT INTO Circles VALUES (DEFAULT, ?, ?, ?)")){
	$stmt->bind_param("sss", $_SESSION['input_username'], $new_cname, $new_to_circle);
	$stmt->execute();
	echo "Circle successfully created";
	$stmt->close();
}
?>
</div>
</body>
</html>