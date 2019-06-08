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
<?php
if (isset($_POST['profile-uid'])){
	$profile_uid = $_POST['profile-uid'];
}else
	$profile_uid = $_SESSION['input_username'];
echo "<h3>$profile_uid's profile</h3>"?>
<hr>
<?php
$requester = $_SESSION['input_username'];
$recipient = $_GET['recipient-uid'];
if ($stmt = $mysqli->prepare("INSERT INTO Friend_Req VALUES (DEFAULT, ?, ?, DEFAULT, 'yes');")){
	$stmt->bind_param("ss", $requester, $recipient);
	$stmt->execute();
	echo "Friend request sent.";
	$stmt->close();
}
if ($stmt = $mysqli->prepare("INSERT INTO Friend_Req VALUES (DEFAULT, ?, ?, DEFAULT, 'na');")){
	$stmt->bind_param("ss", $recipient, $requester);
	$stmt->execute();
	$stmt->close();
}
?>
</div>
</body>
</html>