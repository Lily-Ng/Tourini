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
	<li><a href = "profile.php"></a></li>
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
<h3>Upload a post</h3>
<hr>
<?php
if(isset($_FILES['fileToUpload']) and isset($_POST['latitude']) and isset($_POST['longitude'])){
	$filename = $_FILES['fileToUpload']['name'];
	$target_dir = "user_photos/$uid/";
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
	if ($stmt = $mysqli->prepare("INSERT INTO Photo VALUES (DEFAULT, ?, ?, DEFAULT, ?, ?, ?)")){
		$stmt->bind_param("sssss", $uid, $target_file, $longitude, $latitude, $_POST["view-opt"]);
		$stmt->execute();
		$stmt->close();
	if (!file_exists("$target_dir")) {
		mkdir("$target_dir", 0777, true);}
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
		echo "$filename had been uploaded.";}
}else
	echo "No file selected."
?>
</div>
</body>
</html>