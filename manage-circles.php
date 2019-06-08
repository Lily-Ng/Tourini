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
<h3>Create New Circle:</h3>
<form action = "create-circle.php" method = "GET">
Circle Name: <input type = "text" name = "cir_name"></input><br/>
Uid of People in Circle: <input type = "text" name = "in_circle"></input>
<input type = "submit" value = "Create Circle"/>
</form>
<h3>Your Circles:</h3>
<?php
if ($stmt2 = $mysqli->prepare("Select cname, in_circle from Circles Where Circles.uid = ?")){
	$stmt2->bind_param("s", $_SESSION['input_username']);
	$stmt2->execute();
	$stmt2->bind_result($cname, $in_circle);
	while ($stmt2->fetch()){
		echo "$cname: $in_circle<br/>";
	}
	$stmt2->close();
}
?>
</div>
</body>
</html>